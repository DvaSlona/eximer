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

if (!file_exists($filename))
{
    header('404 Not Found', true, 404);
    die;
}

/* SQL Database login information */
require "DB.php";
include 'config/i18n.php';

$sqlserver = "localhost";
$sqltype = "mysql";
require 'config/db.php';
$dsn = "$sqltype://$sqlUser:$sqlPassword@$sqlserver/$sqlDbName";

/** @var DB_common $db */
$db = DB::connect($dsn);
if (DB::isError($db))
{
    die($db->getMessage());
}
$db->setFetchMode(DB_FETCHMODE_ASSOC);
$db->Query("SET CHARACTER SET UTF8");
$db->Query("SET NAMES UTF8");

require_once 'config/variables.php';
include_once 'config/functions.php';
include_once 'config/httpheaders.php';

$manager = DvaSlona\Eximer\DB\Manager::getInstance();

include $filename;
