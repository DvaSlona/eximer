<?php
/**
 * Пользователь
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */

namespace DvaSlona\Eximer\DB\Object;

/**
 * Пользователь
 */
class User extends AbstractObject
{
    /**
     * Возвращает true если пользователь включен
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->data['enabled'];
    }
}

