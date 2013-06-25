<?php
require_once __DIR__ . '/config/variables.php';
require_once __DIR__ . '/config/functions.php';
require_once __DIR__ . '/config/httpheaders.php';

switch ($settings['domaininput'])
{
    case 'dropdown':
        $manager = DvaSlona\Eximer\DB\Manager::getInstance();
        $repo = $manager->getRepository('Domain');
        /** @var \DvaSlona\Eximer\DB\Object\Domain[] $domains */
        $domains = $repo->findBySql('type = :type AND domain != :domain',
            array(':type' => 'local', ':domain' => 'admin'));
        break;
    case 'static':
        $domain = preg_replace ('/^mail\./', '', $_SERVER['SERVER_NAME']);
        break;
}

include 'templates/login.php';

