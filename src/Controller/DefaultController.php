<?php

namespace Guestbook\Controller;
define('BASE_PATH', realpath(dirname(__FILE__)));

use Doctrine\ORM\EntityManager;
use Guestbook\Entity\GuestbookRecord;
use Monolog\Logger;
use Smarty;

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
     * @param EntityManager $em
     * @param Logger $logger
     * @return string
     * @throws \SmartyException
     */
    public function view(EntityManager $em, Logger $logger)
    {
        $guestbookRecords = $em->getRepository(GuestbookRecord::class)->findAllAsArray();

//        $logger->debug('1', $guestbookRecords);

        $this->smarty->assign('Records', $guestbookRecords);

        return $this->smarty->fetch('view.tpl');
    }
}