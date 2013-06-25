<?php
require_once __DIR__ . '/config/variables.php';
require_once __DIR__ . '/config/functions.php';
require_once __DIR__ . '/config/httpheaders.php';

switch ($settings['domaininput'])
{
    case 'dropdown':
        $query = "SELECT domain FROM domains WHERE type='local' AND domain!='admin' ORDER BY domain";
        $result = $db->query($query);
        $domains = array();
        if ($result->numRows())
        {
            while ($row = $result->fetchRow())
            {
                $domains []= $row['domain'];
            }
        }
        break;
    case 'static':
        $domain = preg_replace ('/^mail\./', '', $_SERVER['SERVER_NAME']);
        break;
}

include 'templates/login.php';
