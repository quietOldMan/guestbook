<?php

namespace Guestbook\Controller;
define('BASE_PATH', realpath(dirname(__FILE__)));

use Doctrine\ORM\EntityManager;
use Guestbook\Entity\GuestbookRecord;
use Guestbook\Entity\User;
use Guestbook\Entity\UserAgent;
use Monolog\Logger;
use Smarty;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Class DefaultController
 * @package Guestbook\Controller
 */
class DefaultController
{

    /**
     * @var string
     */
    private $templateDir;

    /**
     * @var Smarty
     */
    private $smarty;

    /**
     * DefaultController constructor.
     */
    public function __construct()
    {
        $this->templateDir = BASE_PATH . DIRECTORY_SEPARATOR . 'templates';
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir($this->templateDir);
        $this->smarty->setEscapeHtml(true);
    }

    /**
     * @param Request $request
     * @param string $nounce
     * @throws \SmartyException
     */
    public function indexAction(Request $request, string $nounce)
    {
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);

        $response->headers->set('Content-Security-Policy', "script-src 'nonce-" . $nounce . "' 'unsafe-inline' 'unsafe-eval' 'strict-dynamic' https: http:; object-src 'none'");
        $this->smarty->assign('csp_nonce', $nounce);

        $response->setContent($this->smarty->fetch('view.tpl'));

        $response->prepare($request);
        $response->send();
        return;
    }

    /**
     * @param Request $request
     * @param EntityManager $em
     * @param Logger $logger
     * @param int $page
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \SmartyException
     */
    public function loadTableAction(Request $request, EntityManager $em, Logger $logger, int $page)
    {
        $guestbookRecords = $em->getRepository(GuestbookRecord::class)->getOnePageAsArray($page * 25);
        $guestbookRecordsCount = $em->getRepository(GuestbookRecord::class)->countAllRecords();

        $this->smarty->assign('Records', $guestbookRecords);
        $this->smarty->assign('Page', array('currentPage' => $page + 1, 'maxPage' => ceil($guestbookRecordsCount / 25)));

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent($this->smarty->fetch('table.tpl'));

        $response->prepare($request);
        $response->send();
        return;
    }

    /**
     * @param Request $request
     * @param EntityManager $em
     * @param Logger $logger
     * @throws \Exception
     */
    public function addRecordAction(Request $request, EntityManager $em, Logger $logger)
    {
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/json');

        $status = 'true';

        try {
            if ($request->getMethod() === $request::METHOD_POST) {
                $guestbookRecord = new GuestbookRecord();
                $user = new User();
                $userAgent = new UserAgent();

                if (preg_match('/^[a-zA-Z0-9\'.\s]{1,64}$/', $request->request->get('inputUserName'))) {
                    $user->setUserName($request->request->get('inputUserName'));
                } else {
                    throw new \Exception('There is invalid characters in user name! [' . $request->request->get('inputUserName') . ']');
                }

                if (filter_var($request->request->get('inputEmail'), FILTER_VALIDATE_EMAIL)) {
                    $user->setEmail($request->request->get('inputEmail'));
                } else {
                    throw new \Exception('Email is not valid! [' . $request->request->get('inputEmail') . ']');
                }

                $user->setUserIp($request->getClientIp());

                $userAgent->setUser($user);
                $userAgent->setUserAgent($request->headers->get('User-Agent'));

                $guestbookRecord->setUser($user);
                $guestbookRecord->setCreateTime(new \DateTime('now'));

                if (!preg_match('/<(.|\n)*?>/', $request->request->get('inputMessage'))) {
                    $guestbookRecord->setText($request->request->get('inputMessage'));
                } else {
                    throw new \Exception('There is forbidden HTML tags in message text found!');
                }

                if (empty($request->getSession()) || $request->get('inputCAPTCHA') !== $request->getSession()->get('captcha')) {
                    throw new \Exception('CAPTCHA not found in session or not valid!');
                }

                $em->persist($userAgent);
                $em->persist($guestbookRecord);
                $em->flush();
            };
        } catch (\Exception $e) {
            $logger->error('Exception during data processing.', [($e->getMessage())]);
            $status = 'false';
        }

        $response->setContent(json_encode(['success' => $status]));

        $response->prepare($request);
        $response->send();

        return;
    }

    /**
     * @param Request $request
     * @param string $captcha
     */
    public function createCaptchaAction(Request $request, string $captcha)
    {
        $image = imagecreate(200, 100);
        imagecolorallocate($image, 0, 0, 0);
        $gray = imagecolorallocate($image, 128, 128, 128);

        for ($i = 0; $i < 10; $i++) {
            imageline($image, rand(0, 10) * 20, 0, rand(0, 10) * 20, 100, $gray);
            imageline($image, 0, rand(0, 10) * 10, 200, rand(0, 10) * 10, $gray);
        }
        for ($i = 0; $i < strlen($captcha); $i++) {
            $randcolors = imagecolorallocate($image, rand(100, 255), rand(200, 255), rand(200, 255));
            imagettftext($image, 30, rand(-30, 30), 10 + 30 * $i, rand(40, 70), $randcolors,
                $this->templateDir . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'fonts' . DIRECTORY_SEPARATOR . "OpenSans-Regular.ttf",
                $captcha[$i]);
        }

        ob_start();
        imagepng($image);
        $image_data = ob_get_contents();
        ob_end_clean();
        imagedestroy($image);

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent($image_data);

        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, 'captcha.png');
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/png');

        $response->prepare($request);
        $response->send();
        return;
    }

    public function validateCaptchaAction(Request $request, Logger $logger)
    {
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/json');

        if (!empty($request->getSession()) && $request->get('inputCAPTCHA') === $request->getSession()->get('captcha')) {
            $response->setContent(json_encode(true));
        } else {
            $response->setContent(json_encode('Текст не совпадает с картинкой, попробуйте снова'));
        }

        $response->prepare($request);
        $response->send();
        return;
    }
}