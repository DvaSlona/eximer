<?php
/**
 * Контроллер входа в систему
 *
 * @copyright 2013, ООО "Два слона", http://dvaslona.ru/
 * @author Михаил Красильников <mk@dvaslona.ru>
 */

namespace DvaSlona\Eximer\Controller;
use DvaSlona\Eximer\DB\Manager as DbManager;
use DvaSlona\Eximer\DB\Object\User;
use DvaSlona\Eximer\Templates\Template;

/**
 * Контроллер входа в систему
 */
class LoginController extends AbstractController
{
    /**
     * Выводит форму аутентификации и производит обработку введённых данных
     */
    public function execute()
    {
        global $settings;

        $db = DbManager::getInstance();
        $domainsRepo = $db->getRepository('Domain');

        if ('POST' == $_SERVER['REQUEST_METHOD'])
        {
            $domainName = array_key_exists('domain', $_POST) ? $_POST['domain'] : null;
            $localPart = array_key_exists('localpart', $_POST) ? $_POST['localpart'] : null;
            $crypt = array_key_exists('crypt', $_POST) ? $_POST['crypt'] : null;

            /** @var \DvaSlona\Eximer\DB\Object\Domain|null $domain */
            $domain = $domainsRepo->findOneBy(array('domain' => $domainName));

            if (null === $domain)
            {
                $this->fail();
            }

            $usersRepo = $db->getRepository('User');
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
                $this->fail();
            }

            /* populate session variables from what was retrieved from the database (NOT what they posted) */
            $_SESSION['localpart'] = $user->getLocalPart();
            $_SESSION['domain'] = $domain->getName();
            $_SESSION['domain_id'] = $domain->getId();
            $_SESSION['crypt'] = $user->getEncryptedPassword();
            $_SESSION['user_id'] = $user->getId();

            // redirect the user to the correct starting page
            if ($user->isAdmin() && ($user->getType() == 'site'))
            {
                $this->redirect('site.php');
            }
            if ($user->isAdmin())
            {
                $this->redirect('admin.php');
            }
            if (!$domain->isEnabled())
            {
                $this->redirect('index.php?domaindisabled');
            }

            // must be a user, send them to edit their own details
            $this->redirect('userchange.php');
        }

        $vars = array();
        switch ($settings['domaininput'])
        {
            case 'dropdown':
                /** @var \DvaSlona\Eximer\DB\Object\Domain[] $domains */
                $vars['domains'] = $domainsRepo->findBySql('type = :type AND domain != :domain',
                    array(':type' => 'local', ':domain' => 'admin'));
                break;
            case 'static':
                $name = preg_replace('/^mail\./', '', $_SERVER['SERVER_NAME']);
                $vars['domain'] = $domainsRepo->findOneBy(array('domain' => $name));
                break;
        }

        $tmpl = new Template('login.php');
        $tmpl->output($vars);
    }

    /**
     * Выводит сообщение о провале попытки входа
     */
    private function fail()
    {
        $this->redirect('index.php?login=failed');
    }
}

