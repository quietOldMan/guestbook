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
     * @return string
     * @throws \SmartyException
     */
    public function view()
    {
        return $this->smarty->fetch('view.tpl');
    }

    /**
     * @param EntityManager $em
     * @param Logger $logger
     * @param int
     * @return string
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \SmartyException
     */
    public function table(EntityManager $em, Logger $logger, int $page)
    {
        $guestbookRecords = $em->getRepository(GuestbookRecord::class)->findOnePageAsArray($page * 25);
        $guestbookRecordsCount = $em->getRepository(GuestbookRecord::class)->countAllRecords();

//        $logger->debug('1', $guestbookRecords);

        $this->smarty->assign('Records', $guestbookRecords);
        $this->smarty->assign('Count', $guestbookRecordsCount);
        $this->smarty->assign('Page', $page + 1);

        return $this->smarty->fetch('table.tpl');
    }
}