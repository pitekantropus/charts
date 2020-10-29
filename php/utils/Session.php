<?php
require_once('DBConnection.php');

function setMyCookie($name, $value, $expirationTime) {
    setcookie($name, $value, $expirationTime, '/', 'dobre-wykresy.cba.pl');
}

function destroyCookie($cookie) {
    setMyCookie($cookie, '', time() - 3600);
    unset($_COOKIE[$cookie]);
}

class Session {
    private $variables = array(
        'logged' => false,
        'id' => '',
        'email' => '',
        'nick' => '',
        'power' => ''
    );

    function __construct($tryLogin = true) {
        session_start();
        if(!$tryLogin) {
            return;
        }
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
            $this->variables['logged'] = true;
            $this->variables['id'] = $_SESSION['id'];
            $this->variables['email'] = $_SESSION['email'];
            $this->variables['nick'] = $_SESSION['nick'];
            $this->variables['power'] = $_SESSION['power'];
        } else if(isset($_COOKIE['rememberId']) && isset($_COOKIE['rememberHash'])) {
            $db = new DBConnection();
            $rememberId = $_COOKIE['rememberId'];
            $rememberHash = $_COOKIE['rememberHash'];
            $result = $db->fetchSingleRowById('users', $rememberId);
            if(!$result) {
                return;
            }
            if(!password_verify($rememberHash, $result['hash'])) {
                $this->removeRememberMe($db, $rememberId);
                return;
            }
            $today = date('Y-m-d');
            if($result['rememberExpirationDate'] < $today) {
                $this->removeRememberMe($db, $rememberId);
                return;
            }
            $this->setSessionVariable('loggedin', true);
            $this->setSessionVariable('id', $rememberId);
            $this->setSessionVariable('email', $result['email']);
            $this->setSessionVariable('nick', $result['nick']);
            $this->setSessionVariable('power', $result['power']);
            $cookieExpirationTime = time() + 30*24*60*60;
            $cookieExpirationDate = date('Y-m-d', $cookieExpirationTime);
            setMyCookie('rememberId', $rememberId, $cookieExpirationTime);
            setMyCookie('rememberHash', $rememberHash, $cookieExpirationTime);
            $db->query("UPDATE users SET logTimestamp = now(),
                        rememberExpirationDate = '$cookieExpirationDate' WHERE id = '$rememberId'");
        }
    }

    public function login($email, $password, $remember) {
        $db = new DBConnection();
        $email = $db->safeString($email);
        $password = $db->safeString($password);
        $result = $db->fetchSingleRow('users', 'email', $email);
        if(!$result) {
            return false;
        }
        $hashedPassword = $result['password'];
        if(!password_verify($password, $hashedPassword)) {
            return false;
        }

        $id = $result['id'];
        $rememberHash = '';
        $cookieExpirationDate = '';
        if($remember) {
            $cookieExpirationTime = time() + 30*24*60*60;
            $cookieExpirationDate = date('Y-m-d', $cookieExpirationTime);
            $randomNumber = random_int(1000000000, 9999999999);
            $rememberHash = password_hash($randomNumber, PASSWORD_DEFAULT);
            setMyCookie('rememberId', $id, $cookieExpirationTime);
            setMyCookie('rememberHash', $randomNumber, $cookieExpirationTime);
        } else {
            destroyCookie('rememberId');
            destroyCookie('rememberHash');
        }
        $db->query("UPDATE users SET logTimestamp = now(), hash = '$rememberHash',
                        rememberExpirationDate = '$cookieExpirationDate' WHERE id = '$id'");

        $this->setSessionVariable('loggedin', true);
        $this->setSessionVariable('id', $id);
        $this->setSessionVariable('email', $email);
        $this->setSessionVariable('nick', $result['nick']);
        $this->setSessionVariable('power', $result['power']);

        return true;
    }

    public function logout() {
        $_SESSION = array();
        session_destroy();
        destroyCookie('rememberId');
        destroyCookie('rememberHash');
    }

    public function setSessionVariable($name, $value) {
        $_SESSION[$name] = $value;
        $this->variables[$name] = $value;
    }

    public function isLogged() {
        return $this->variables['logged'];
    }

    private function removeRememberMe($db, $id) {
        $db->query("UPDATE users SET hash = '', rememberExpirationDate = '' WHERE id = '$id'");
        destroyCookie('rememberId');
        destroyCookie('rememberHash');
    }

    public function checkPermission($access) {
        if(!$this->isLogged()) {
            return false;
        }
        $db = new DBConnection();
        $result = $db->fetchSingleRow('permissions', 'power', $this->variables['power']);
        if(!$result) {
            die('Something wrong with range: ' . $this->variables['power']);
        }
        $permissions = explode(';', $result['permissions']);
        if(in_array($access, $permissions)) {
            return true;
        } else {
            return false;
        }
    }
}
?>
