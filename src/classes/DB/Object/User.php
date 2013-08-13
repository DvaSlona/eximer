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
     * Возвращает идентификатор
     *
     * @return int
     */
    public function getId()
    {
        return $this->data['user_id'];
    }

    /**
     * Возвращает имя пользователя в домене
     *
     * @return string
     */
    public function getLocalPart()
    {
        return $this->data['localpart'];
    }

    /**
     * Возвращает тип пользователя
     *
     * @return string
     * @todo переделать в виде отдельного класса
     */
    public function getType()
    {
        return $this->data['type'];
    }

    /**
     * Возвращает true если пользователь включен
     *
     * @return bool
     */
    public function isEnabled()
    {
        return (bool) $this->data['enabled'];
    }

    /**
     * Возвращает true если пользователь — администратор
     *
     * @return bool
     */
    public function isAdmin()
    {
        return (bool) $this->data['admin'];
    }

    /**
     * Возвращает зашифрованный пароль
     *
     * @return string
     */
    public function getEncryptedPassword()
    {
        return $this->data['crypt'];
    }

    /**
     * Сравнивает переданный пароль с паролем пользователя
     *
     * @param string $password
     *
     * @return bool  true если пароли совпадают и  false в противном случае
     */
    public function checkPassword($password)
    {
        return $this->getEncryptedPassword()
            == crypt_password($password, $this->getEncryptedPassword());
    }
}

