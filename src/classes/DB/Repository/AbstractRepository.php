<?php
/**
 * Абстрактное хранилище (таблица или группа таблиц БД)
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */

namespace DvaSlona\Eximer\DB\Repository;

use PDO;
use PDOStatement;
use DvaSlona\Eximer\DB\Object\AbstractObject;

/**
 * Абстрактное хранилище (таблица или группа таблиц БД)
 */
abstract class AbstractRepository
{
    /**
     * Соединение с БД
     * @var PDO
     */
    protected $dbh;

    /**
     * Имя таблицы
     *
     * @var string
     */
    protected $tableName;

    /**
     * Имя ключевого поля
     *
     * @var string
     */
    protected $keyName;

    /**
     * Реестр загруженных объектов
     *
     * @var AbstractObject[]
     */
    protected $registry = array();

    /**
     * Конструктор
     *
     * @param PDO $dbh
     */
    public function __construct(PDO $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * Возвращает объект по его идентификатору
     *
     * @param int|string $id
     *
     * @return AbstractObject|null
     *
     * @todo добавить указание типа в bindValue
     */
    public function find($id)
    {
        if (!array_key_exists($id, $this->registry))
        {
            $query = $this->dbh->prepare(
                "SELECT * FROM {$this->tableName} WHERE {$this->keyName} = :id LIMIT 1");
            $query->bindValue(':id', $id);
            $query->execute();
            $raw = $query->fetch(PDO::FETCH_ASSOC);
            $objectClass = $this->getObjectClass();
            $this->registry[$id] = new $objectClass($raw);
        }
        return $this->registry[$id];
    }

    /**
     * Возвращает объекты по набору условий
     *
     * @param array $set
     *
     * @return AbstractObject[]
     *
     * @todo добавить указание типа в bindValue
     */
    public function findBy($set)
    {
        $where = array();
        foreach (array_keys($set) as $field)
        {
            $where []= "$field = :$field";
        }
        $where = implode(' AND ', $where);
        $query = $this->dbh->prepare(
            "SELECT * FROM {$this->tableName} WHERE $where");
        foreach ($set as $field => $value)
        {
            $query->bindValue(":$field", $value);
        }
        return $this->loadFromQuery($query);
    }

    /**
     * Возвращает объект по набору условий
     *
     * @param array $set
     *
     * @return AbstractObject|null
     *
     * @todo добавить указание типа в bindValue
     */
    public function findOneBy($set)
    {
        $where = array();
        foreach (array_keys($set) as $field)
        {
            $where []= "$field = :$field";
        }
        $where = implode(' AND ', $where);
        $query = $this->dbh->prepare(
            "SELECT * FROM {$this->tableName} WHERE $where LIMIT 1");
        foreach ($set as $field => $value)
        {
            $query->bindValue(":$field", $value);
        }
        $query->execute();
        $raw = $query->fetch(PDO::FETCH_ASSOC);
        if (!$raw)
        {
            return null;
        }

        if (array_key_exists($raw[$this->keyName], $this->registry))
        {
            return $this->registry[$raw[$this->keyName]];
        }

        $objectClass = $this->getObjectClass();
        $this->registry[$raw[$this->keyName]] = new $objectClass($raw);
        return $this->registry[$raw[$this->keyName]];
    }

    /**
     * @param string $where   условие WHERE с именованными псевдопеременными в стиле PDO
     * @param array  $params  значения псевдопеременных
     *
     * @return AbstractObject[]
     */
    public function findBySql($where, array $params)
    {
        $query = $this->dbh->prepare(
            "SELECT * FROM {$this->tableName} WHERE $where");
        foreach ($params as $name => $value)
        {
            $query->bindValue($name, $value);
        }
        return $this->loadFromQuery($query);
    }

    /**
     * Загружает объекты из запроса
     *
     * @param PDOStatement $query
     *
     * @return AbstractObject[]
     */
    protected function loadFromQuery(PDOStatement $query)
    {
        $query->execute();
        $raw = $query->fetchAll(PDO::FETCH_ASSOC);

        $objects = array();
        $objectClass = $this->getObjectClass();
        foreach ($raw as $rawObject)
        {
            if (!array_key_exists($rawObject[$this->keyName], $this->registry))
            {
                $this->registry[$rawObject[$this->keyName]] = new $objectClass($rawObject);
            }
            $objects []= $this->registry[$rawObject[$this->keyName]];
        }
        return $objects;
    }

    /**
     * Возвращает класс объектов этого хранилища
     *
     * @return string
     */
    protected function getObjectClass()
    {
        return str_replace('\\Repository\\', '\\Object\\', get_class($this));
    }
}

