<?php

namespace Ivan1986\DebBundle\Tests\Entity;

use Ivan1986\DebBundle\Entity\GpgKeyRepository;
use Ivan1986\DebBundle\Entity\GpgKey;
use Ivan1986\DebBundle\Exception\GpgNotFoundException;

class GpgKeyTest extends Entity
{
    public function testGetMyKey()
    {
        $keys = $this->em->getRepository('Ivan1986DebBundle:GpgKey');
        /** @var $keys GpgKeyRepository */
        $id = '28FA7071';
        $key = $keys->getFromServer($id, 'keyserver.ubuntu.com');
        /** @var $key GpgKey */
        $this->assertEquals($key->getId(), $id);
        $this->assertEquals($key->getFingerprint(), '33C640DA31127882C496917F6831CF9528FA7071');
        $this->assertTrue(strpos($key->getData(), 'Ivan Borzenkov <ivan1986@list.ru>')>0);
    }

    /**
     * @expectedException Ivan1986\DebBundle\Exception\GpgNotFoundException
     */
    public function testGetNotExistKey()
    {
        $keys = $this->em->getRepository('Ivan1986DebBundle:GpgKey');
        /** @var $keys GpgKeyRepository */
        $id = 'ffffff';
        $key = $keys->getFromServer($id, 'keyserver.ubuntu.com');
    }

}
