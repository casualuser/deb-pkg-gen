<?php

namespace Ivan1986\DebBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Entity extends WebTestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

}
