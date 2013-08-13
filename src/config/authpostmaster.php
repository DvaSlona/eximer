<?php
$security = DvaSlona\Eximer\Security\Manager::getInstance();
$user = $security->getUser();

if (null === $user || !$user->isAdmin())
{
    $security->notAuthorized();
}

