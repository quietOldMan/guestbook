<?php

namespace Guestbook\Controller;
define('BASE_PATH', realpath(dirname(__FILE__)));

use Doctrine\ORM\EntityManager;
use Guestbook\Entity\GuestbookRecord;
use Monolog\Logger;
use Smarty;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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
    }

    /**
     * @param Request $request
     * @throws \SmartyException
     */
    public function indexAction(Request $request)
    {
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
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
        $guestbookRecords = $em->getRepository(GuestbookRecord::class)->findOnePageAsArray($page * 25);
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

        imagepng($image);

        $response = new BinaryFileResponse($image, Response::HTTP_OK);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'captcha.png');
        $response->headers->set('Content-Type', 'image/png;');

        $response->prepare($request);
        $response->send();
        return;
    }
}