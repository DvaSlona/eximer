<?php
/**
 * Менеджер базы данных
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */

namespace DvaSlona\Eximer\DB;

use PDO;
use DvaSlona\Eximer\DB\Repository\AbstractRepository;

/**
 * Менеджер базы данных
 */
class Manager
{
    /**
     * @var Manager
     */
    private static $instance = null;

    /**
     * Соединение с БД
     * @var PDO
     */
    private $dbh;

    /**
     * Реестр хранилищ
     * @var AbstractRepository[]
     */
    private $repos = array();

    /**
     * Возвращает экземпляр-одиночку менеджера
     * @return Manager
     */
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Запрещаем самостоятельное создание экземпляров
     */
    private function __construct()
    {
        $type = $GLOBALS['sqltype'];
        $dbname = $GLOBALS['sqlDbName'];
        $host = $GLOBALS['sqlserver'];
        $this->dbh = new PDO("$type:dbname=$dbname;host=$host",
            $GLOBALS['sqlUser'], $GLOBALS['sqlPassword']);
    }

    /**
     * Запрещаем клонирование
     */
    private function __clone()
    {
    }

    /**
     * Возвращает объект хранилища
     *
     * @param string $repoName  имя хранилища
     *
     * @throws \LogicException
     *
     * @return AbstractRepository
     */
    public function getRepository($repoName)
    {
        if (!array_key_exists($repoName, $this->repos))
        {
            $repoClass = __NAMESPACE__ . "\\Repository\\$repoName";
            if (!class_exists($repoClass))
            {
                throw new \LogicException(sprintf('Class "%s" not found', $repoClass));
            }
            $repo = new $repoClass($this->dbh);
            if (!($repo instanceof AbstractRepository))
            {
                throw new \LogicException(sprintf(
                    'Class "%s" should be a descendant of AbstractRepository',
                    $repoClass
                ));
            }
            $this->repos[$repoName] = $repo;
        }
        return $this->repos[$repoName];
    }
}

