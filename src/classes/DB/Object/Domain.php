<?php
/**
 * Домен
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */

namespace DvaSlona\Eximer\DB\Object;

/**
 * Домен
 */
class Domain extends AbstractObject
{
    /**
     * Возвращает true если домен включен
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->data['enabled'];
    }
}

