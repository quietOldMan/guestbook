<?php


namespace Guestbook\Repository;

use Doctrine\ORM\EntityRepository;


class GuestbookRepository extends EntityRepository
{
    /**
     * @return mixed
     */
    public function findAllAsArray()
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select(array('g.createTime, g.text', 'u.userName', 'u.email'))
            ->from('Guestbook\Entity\GuestbookRecord', 'g')
            ->leftJoin('g.user', 'u')
            ->getQuery()->getArrayResult();
    }
}