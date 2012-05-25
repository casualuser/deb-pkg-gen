<?php

namespace Ivan1986\DebBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Ivan1986\UserBundle\Entity\User;

use Ivan1986\DebBundle\Exception\ParseRepoStringException;

/**
 * RepositoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RepositoryRepository extends EntityRepository
{

    /**
     * Разбирает строку репозитория
     *
     * @param $string строка
     * @param bool $bin бинарный есть
     * @param bool $src исходники есть
     * @throws ParseRepoStringException
     * @return Repository
     */
    public function createFromAptString($string, $bin=true, $src=true)
    {
        $items = explode(' ', $string);
        //устраняем лишние пробелы
        foreach($items as $k=>$v)
            if (empty($v))
                unset($items[$k]);
        $items = array_values($items);

        if (count($items) == 0)
            throw new ParseRepoStringException($string, 'Empty String', 0);
        if ($items[0] == 'deb' || $items[0] == 'deb-src')
            array_shift($items);
        if (count($items) == 0)
            throw new ParseRepoStringException($string, 'Not Found Url', 1);

        $repo = new Repository();
        $repo->setUrl(array_shift($items));
        $repo->setBin($bin);
        $repo->setSrc($src);

        if (count($items) == 0)
            throw new ParseRepoStringException($string, 'Not Found Release', 2);

        $repo->setRelease(array_shift($items));

        //Если нету компонентов, то это упрощенный репозиторий, что тоже нормально
        if (count($items))
            $repo->setComponents($items);

        return $repo;
    }

    /**
     * Получить репозитории пользователя
     *
     * @param User $user
     * @return array
     */
    public function getByUser(User $user)
    {
        return $this->findBy(array('owner' => $user->getId()));
    }

    /**
     * Получить репозиторий по ID с проверкой пользователя
     *
     * @param $id ID репозитория
     * @param User $user пользователь
     * @return object
     */
    public function getByIdAndCheckUser($id, User $user)
    {
        return $this->findOneBy(array('id' => $id, 'owner' => $user->getId()));
    }


}