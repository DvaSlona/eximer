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

/*
 * Маршруты
 * TODO Это временное решение
 */
$routes = array(
    'sitepasswordsubmit.php' => 'SitePasswordController',
);

$security = DvaSlona\Eximer\Security\Manager::getInstance();
$user = $security->getUser();
if (null === $user)
{
    $user =  new DvaSlona\Eximer\DB\Object\User();
    $controller = new DvaSlona\Eximer\Controller\LoginController($user);
    $controller->execute();
}
elseif (array_key_exists($filename, $routes))
{
    $class = 'DvaSlona\Eximer\Controller\\' . $routes[$filename];
    $controller = new $class;
    if ($controller instanceof DvaSlona\Eximer\Controller\AbstractController)
    {
        $controller->execute();
    }
    else
    {
        throw new LogicException(sprintf('Class "%s" must be descendant of "%s"', $class,
            'DvaSlona\Eximer\Controller\AbstractController'));
    }
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

