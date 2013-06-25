<?php
/**
 * Псевдоним домена
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */

namespace DvaSlona\Eximer\DB\Object;

use DvaSlona\Eximer\DB\Manager;

/**
 * Псевдоним домена
 */
class DomainAlias extends AbstractObject
{
    /**
     * Возвращает псевдоним
     *
     * @return string
     */
    public function getName()
    {
        return $this->data['alias'];
    }

    /**
     * @return Domain
     */
    public function getDomain()
    {
        $manager = Manager::getInstance();
        $repo = $manager->getRepository('Domain');
        $domain = $repo->find($this->data['domain_id']);
        return $domain;
    }
}

