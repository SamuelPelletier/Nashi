<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 15/05/2017
 * Time: 16:26
 */

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;

class RecipeRepository extends EntityRepository
{
    public function getRecipeByName($name){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('r')
            ->from('AppBundle:Recipe', 'r')
            ->where("r.name like '%".$name."%'");
        $qb->setMaxResults(1);

        return $qb->getQuery()->getResult();
    }
}
