<?php

namespace Ivan1986\DebBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * RepositoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RepositoryRepository extends EntityRepository
{

    public function createFromAptString($string, $bin=true, $src=true)
    {
        //
    }

}