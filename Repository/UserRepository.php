<?php
namespace PMS\Bundle\UserBundle\Entity\Repository;

class UserRepository extends \Gedmo\Sortable\Entity\Repository\SortableRepository
{
    public function findAllOrderedByUpdated()
    {
        return $this->getEntityManager()
                ->createQuery('SELECT u FROM PMSUserBundle:User u ORDER BY u.last_name ASC')
                ->getResult();
    }

    public function search($query)
    {
        return $this->getEntityManager()
                ->createQuery($query)
                ->getResult();
    }
}
