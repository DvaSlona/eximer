<?php
/**
 * Абстрактный объект
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */

namespace DvaSlona\Eximer\DB\Object;

/**
 * Абстрактный объект
 */
abstract class AbstractObject
{
    /**
     * Свойства объекта
     * @var array
     */
    protected $data;

    /**
     * Конструктор объекта на основе данных БД
     *
     * @param array $data  запись из БД
     */
    public function __construct(array $data = array())
    {
        $this->data = $data;
    }
}

