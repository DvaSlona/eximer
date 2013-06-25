<?php
/**
 * Хранилище псевдонимов доменов
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */

namespace DvaSlona\Eximer\DB\Repository;

/**
 * Хранилище псевдонимов доменов
 */
class DomainAlias extends AbstractRepository
{
    /**
     * Имя таблицы
     *
     * @var string
     */
    protected $tableName = 'domainalias';

    /**
     * Имя ключевого поля
     *
     * @var string
     */
    protected $keyName = 'domain_id';
}

