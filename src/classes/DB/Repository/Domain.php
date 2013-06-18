<?php
/**
 * Хранилище доменов
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */

namespace DvaSlona\Eximer\DB\Repository;

/**
 * Хранилище доменов
 */
class Domain extends AbstractRepository
{
    /**
     * Имя таблицы
     *
     * @var string
     */
    protected $tableName = 'domains';

    /**
     * Имя ключевого поля
     *
     * @var string
     */
    protected $keyName = 'domain_id';
}

