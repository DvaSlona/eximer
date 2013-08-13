<?php
/**
 * Абстрактный контроллер
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */

namespace DvaSlona\Eximer\Controller;

/**
 * Абстрактный контроллер
 */
abstract class AbstractController
{
    /**
     * Выполняет действия контроллера
     */
    abstract public function execute();

    /**
     * Выполняет перенаправление на другой адрес
     *
     * @param string $url
     */
    protected function redirect($url)
    {
        header("Location: $url", true, 303);
        die;
    }
}

