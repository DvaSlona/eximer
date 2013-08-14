<?php
/**
 * Основной файл приложения
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */


/*
 * TODO Это временный код! Переделать!
 */
error_reporting(E_ALL);
ini_set('display_errors', true);

$filename = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (substr($filename, -1) == '/')
{
    $filename = 'index.php';
}
else
{
    $filename = basename($filename);
}

require 'config/db.php';
include 'config/i18n.php';
require_once 'config/variables.php';
include_once 'config/functions.php';
include_once 'config/httpheaders.php';

$security = DvaSlona\Eximer\Security\Manager::getInstance();
$user = $security->getUser();
if (null === $user)
{
    $controller = new DvaSlona\Eximer\Controller\LoginController();
    $controller->execute();
}
else
{
    if (!file_exists($filename))
    {
        header('404 Not Found', true, 404);
        die;
    }

    $manager = DvaSlona\Eximer\DB\Manager::getInstance();
    $domainsRepo = $manager->getRepository('Domain');
    /** @var \DvaSlona\Eximer\DB\Object\Domain $domain */
    $domain = $domainsRepo->find($_SESSION['domain_id']);

    /** @noinspection PhpIncludeInspection */
    include $filename;
}

