<?php
/**
 * Менеджер безопасности
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */

namespace DvaSlona\Eximer\Security;

use DvaSlona\Eximer\DB\Manager as DbManager;
use DvaSlona\Eximer\DB\Object\User;

/**
 * Менеджер безопасности
 */
class Manager
{
    /**
     * @var Manager
     */
    private static $instance = null;

    /**
     * Авторизованный пользователь
     *
     * @var null|User
     */
    private $user = null;

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
     * Возвращает модель пользователя, если он авторизован и null в противном случае
     *
     * @return User|null
     */
    public function getUser()
    {
        if (null === $this->user)
        {
            if (array_key_exists('user_id', $_SESSION))
            {
                $db = DbManager::getInstance();
                $this->user = $db->getRepository('User')->find(intval($_SESSION['user_id']));
            }
        }
        return $this->user;
    }

    /**
     * Запрещаем самостоятельное создание экземпляров
     */
    private function __construct()
    {
    }

    /**
     * Запрещаем клонирование
     */
    private function __clone()
    {
    }
}

