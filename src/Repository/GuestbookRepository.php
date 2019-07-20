<?php


namespace Guestbook\Repository;

use Doctrine\ORM\EntityRepository;


class GuestbookRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAllAsArray()
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select(array('g.createTime, g.text', 'u.userName', 'u.email'))
            ->from('Guestbook\Entity\GuestbookRecord', 'g')
            ->leftJoin('g.user', 'u')
            ->orderBy('g.createTime', 'DESC')
            ->getQuery()->getArrayResult();
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countAllRecords()
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('count(g.id)')
            ->from('Guestbook\Entity\GuestbookRecord', 'g')
            ->getQuery()->getSingleScalarResult();
    }

    /**
     * @param int $offset
     * @return array
     */
    public function getOnePageAsArray(int $offset)
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select(array('g.createTime, g.text', 'u.userName', 'u.email'))
            ->from('Guestbook\Entity\GuestbookRecord', 'g')
            ->leftJoin('g.user', 'u')
            ->orderBy('g.createTime', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults(25)
            ->getQuery()->getArrayResult();
    } // need Paginator || slice Collection?
}