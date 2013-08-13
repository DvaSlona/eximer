<?php
/**
 * Шаблон
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */

namespace DvaSlona\Eximer\Templates;

/**
 * Шаблон
 */
class Template
{
    /**
     * Имя файла шаблона
     * @var string
     */
    private $filename;

    /**
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Выводит шаблон, подставляя в него указанные переменные
     *
     * @param array $vars
     */
    public function output(array $vars = array())
    {
        /**
         * Используются в шаблонах
         */
        global $settings, $tmplVars;

        foreach ($vars as $name => $value)
        {
            $$name = $value;
        }
        include __DIR__ . '/../../templates/' . $this->filename;
    }
}

