<?php

namespace Ivan1986\DebBundle\Model;

use Ivan1986\DebBundle\Exception\GpgNotFoundException;
use Ivan1986\DebBundle\Entity\GpgKey;
use Anchovy\CURLBundle\CURL\Curl;

class GpgLoader
{
    /**
     * Получает ключ с сервера
     *
     * @param $keyId ID ключа в шеснадцатиричном формате без начального 0x
     * @param $serverName адрес сервера
     * @return GpgKey
     * @throws \Ivan1986\DebBundle\Exception\GpgNotFoundException
     */
    public static function getFromServer($keyId, $serverName)
    {
        $c = new Curl();
        $c->setURL('http://'.$serverName.':11371/pks/lookup?op=get&search=0x'.$keyId);
        $data = $c->execute();
        $start = strpos($data, '-----BEGIN PGP PUBLIC KEY BLOCK-----');
        if ($start===false)
            throw new GpgNotFoundException($keyId);

        $gpg = new \gnupg();
        $PublicKey = $gpg->import($data);
        $gpg->setarmor(false);

        $key = new GpgKey();

        $key->setId($keyId);
        $key->setData($gpg->export($PublicKey['fingerprint']));
        $key->setFingerprint($PublicKey['fingerprint']);
        return $key;
    }

    public static function getFromFile($file)
    {
        if (!is_file($file))
            throw new GpgNotFoundException(0);
        $data = file_get_contents($file);
        $gpg = new \gnupg();
        $PublicKey = $gpg->import($data);
        if (empty($PublicKey['fingerprint']))
            throw new GpgNotFoundException(0);
        $gpg->setarmor(false);
        $info = $gpg->keyinfo($PublicKey['fingerprint']);
        if (empty($info[0]['subkeys'][0]))
            throw new GpgNotFoundException(0);
        $keyId = $info[0]['subkeys'][0]['keyid'];
        $keyId = substr($keyId, 8);
        if (strlen($keyId) != 8)
            throw new GpgNotFoundException(0);

        $key = new GpgKey();

        $key->setId($keyId);
        $key->setData($gpg->export($PublicKey['fingerprint']));
        $key->setFingerprint($PublicKey['fingerprint']);
        return $key;
    }

}
