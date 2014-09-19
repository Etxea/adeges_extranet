<?php
/*
 * This file is part of the Uroges Calendar App
 *
 * (c) Jon Latorre Martinez <jonlatorremartinez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\DBAL\Connection;

namespace Uroges;

class UserProvider implements \Symfony\Component\Security\Core\User\UserProviderInterface
{
    private $conn;
    private $log;
    
    public function __construct(\Doctrine\DBAL\Connection $conn)
    {
        error_log("HOLAAAAAAAAAAAAAAAAAAAAAAAAAAAAA1");
        $this->conn = $conn;
    }

    public function loadUserByUsername($username)
    {
        error_log("HOLAAAAAAAAAAAAAAAAAAAAAAAAAAAAA2 ".strtolower($username));
        $stmt = $this->conn->executeQuery('SELECT * FROM users WHERE username = ?', array(strtolower($username)));
        error_log("HOLAAAAAAAAAAAAAAAAAAAAAAAAAAAAA3");
        if (!$user = $stmt->fetch()) {
            error_log("HOLAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4");
            throw new \Symfony\Component\Security\Core\Exception\UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }
        error_log("HOLAAAAAAAAAAAAAAAAAAAAAAAAAAAAA5");
        //FIXME leer esto de BBDD ?? $roles = explode(',', $user['roles']) 
        if ($user['roles']==1) {
            $roles = array('ROLE_USER','ROLE_ADMIN');
        }
        else {
            $roles = array('ROLE_USER');
        }
        error_log("HOLAAAAAAAAAAAAAAAAAAAAAAAAAAAAA6");
        $usuario = new \Symfony\Component\Security\Core\User\User($user['username'], $user['password'],  $roles, true, true, true, true);
        
        return $usuario;
    }

    public function refreshUser(\Symfony\Component\Security\Core\User\UserInterface $user)
    {
        
        if (!$user instanceof \Symfony\Component\Security\Core\User\User) {
            throw new \Symfony\Component\Security\Core\Exception\UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === '\Symfony\Component\Security\Core\User\User';
    }
}

?>
