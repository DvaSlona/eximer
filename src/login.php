<?php
$domainName = array_key_exists('domain', $_POST) ? $_POST['domain'] : null;
$localPart = array_key_exists('localpart', $_POST) ? $_POST['localpart'] : null;
$crypt = array_key_exists('crypt', $_POST) ? $_POST['crypt'] : null;

$domainsRepo = $manager->getRepository('Domain');
/** @var \DvaSlona\Eximer\DB\Object\Domain|null $domain */
$domain = $domainsRepo->findOneBy(array('domain' => $domainName));

if (null === $domain)
{
    header('Location: index.php?login=failed');
    die;
}

$usersRepo = $manager->getRepository('User');
if ('siteadmin' == $localPart)
{
    $user = $usersRepo->findOneBy(array(
        'localpart' => $localPart,
        'domain_id' => $domain->getId()
    ));
}
elseif ($settings['AllowUserLogin'])
{
    $user = $usersRepo->findOneBy(array(
        'localpart' => $localPart,
        'domain_id' => $domain->getId()
    ));
}
else
{
    $user = $usersRepo->findOneBy(array(
        'localpart' => $localPart,
        'domain_id' => $domain->getId(),
        'admin' => 1
    ));
}

/** @var \DvaSlona\Eximer\DB\Object\User $user */
if (null === $user || !$user->checkPassword($crypt))
{
    header ('Location: index.php?login=failed');
    die;
}


/* populate session variables from what was retrieved from the database (NOT what they posted) */
$_SESSION['localpart'] = $user->getLocalPart();
$_SESSION['domain'] = $domain->getName();
$_SESSION['domain_id'] = $domain->getId();
$_SESSION['crypt'] = $user->getEncryptedPassword();
$_SESSION['user_id'] = $user->getId();

# redirect the user to the correct starting page
if ($user->isAdmin() && ($user->getType() == 'site'))
{
    header('Location: site.php');
    die;
}
if ($user->isAdmin())
{
    header('Location: admin.php');
    die;
}
if (!$domain->isEnabled())
{
    header ('Location: index.php?domaindisabled');
    die;
}

# must be a user, send them to edit their own details
header ('Location: userchange.php');

