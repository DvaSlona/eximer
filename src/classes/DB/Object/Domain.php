<?php
/**
 * Домен
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */

namespace DvaSlona\Eximer\DB\Object;
use DvaSlona\Eximer\DB\Manager;

/**
 * Домен
 */
class Domain extends AbstractObject
{
    /**
     * Возвращает идентификатор домена
     * @return int
     */
    public function getId()
    {
        return $this->data['domain_id'];
    }

    /**
     * Возвращает имя домена
     *
     * @return string
     */
    public function getName()
    {
        return $this->data['domain'];
    }

    /**
     * Возвращает true если домен включен
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->data['enabled'];
    }

    /**
     * Возвращает список псевдонимов домена
     *
     * @return DomainAlias[]
     */
    public function getAliases()
    {
        $manager = Manager::getInstance();
        $repo = $manager->getRepository('DomainAlias');
        $aliases = $repo->findBy(array('domain_id' => $this->getId()));
        return $aliases;
    }
}

