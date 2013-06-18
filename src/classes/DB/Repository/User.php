<?php
/**
 * Хранилище пользователей
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */

namespace DvaSlona\Eximer\DB\Repository;

/**
 * Хранилище пользователей
 */
class User extends AbstractRepository
{
    /**
     * Имя таблицы
     *
     * @var string
     */
    protected $tableName = 'users';

    /**
     * Имя ключевого поля
     *
     * @var string
     */
    protected $keyName = 'user_id';
}

