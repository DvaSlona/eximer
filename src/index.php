<?php
$repo = $manager->getRepository('Domain');

switch ($settings['domaininput'])
{
    case 'dropdown':
        /** @var \DvaSlona\Eximer\DB\Object\Domain[] $domains */
        $domains = $repo->findBySql('type = :type AND domain != :domain',
            array(':type' => 'local', ':domain' => 'admin'));
        break;
    case 'static':
        $name = preg_replace('/^mail\./', '', $_SERVER['SERVER_NAME']);
        $domain = $repo->findOneBy(array('domain' => $name));
        break;
}

include 'templates/login.php';

