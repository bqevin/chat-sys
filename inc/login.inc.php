<?php

/**
* Simple Login System class
*/
class SimpleLoginSystem {

    // variables
    var $bLoggedIn;

    /**
    * constructor
    */

    //This function executes login as long as username and password are available in the cookie
    function SimpleLoginSystem() {
        $this->bLoggedIn = false;
        if ($_COOKIE['member_name'] && $_COOKIE['member_pass']) {
            if ($this->check_login($_COOKIE['member_name'], $_COOKIE['member_pass'], true)) {
                $this->bLoggedIn = true;
            }
        }
        $GLOBALS['bLoggedIn'] = $this->bLoggedIn;
    }

    //Sets cookie and checks if user is logged on or not
    function getLoginBox() {
        ob_start();
        //picks up login of the employer,is the same for user
        require_once('templates/login_employer.html');
        $sLoginForm = ob_get_clean();

        $sLogoutForm = '<a href="'.$_SERVER['PHP_SELF'].'?logout=1">Logout</a><hr />';
        //if user logs out are redirected to index.php
        if ((int)$_REQUEST['logout'] == 1) {
            $this->simple_logout();
            header("Location: index.php"); exit;
        }

        if ($_REQUEST['username'] && $_REQUEST['password']) {
            if ($this->check_login($_REQUEST['username'], MD5($_REQUEST['password']))) {
                $this->simple_login($_REQUEST['username'], $_REQUEST['password']);

                header("Location: index.php"); exit;
            } else {
                return 'Authentication has failed' . $sLoginForm;
            }
        } else {
            if ($_COOKIE['member_name'] && $_COOKIE['member_pass']) {
                if ($this->check_login($_COOKIE['member_name'], $_COOKIE['member_pass'])) {
                    return 'Welcome ' . $_COOKIE['member_name'] . '! ' . $sLogoutForm;
                }
            }
            return $sLoginForm;
        }
    }

    //Picks up the set Cookies
    function simple_login($sName, $sPass) {
        $this->simple_logout();

        $sMd5Password = MD5($sPass);

        $iCookieTime = time() + 24*60*60*30;
        setcookie("member_name", $sName, $iCookieTime, '/');
        $_COOKIE['member_name'] = $sName;
        setcookie("member_pass", $sMd5Password, $iCookieTime, '/');
        $_COOKIE['member_pass'] = $sMd5Password;
    }

    //All cookies flushed
    function simple_logout() { 
        setcookie('member_name', '', time() - 96 * 3600, '/');
        setcookie('member_pass', '', time() - 96 * 3600, '/');

        unset($_COOKIE['member_name']);
        unset($_COOKIE['member_pass']);
    }

    // Logs in Employers <Normal Users/Writers will be written a new function>
    function check_login($sName, $sPass, $bSetGlobals = false) {
        $sNameSafe = $GLOBALS['MySQL']->process_db_input($sName, A_TAGS_STRIP);
        $sPassSafe = $GLOBALS['MySQL']->process_db_input($sPass, A_TAGS_STRIP);

        $sSQL = "SELECT `id` FROM `s_employers` WHERE `name`='{$sNameSafe}' AND `pass`='{$sPassSafe}'";
        $iID = (int)$GLOBALS['MySQL']->getOne($sSQL);

        if ($bSetGlobals) {
            $this->setLoggedMemberInfo($iID);
        }

        return ($iID > 0);
    }

    //Sets information of the logged person to be accessible globally...important during sending chats
    function setLoggedMemberInfo($iMemberID) {
        $sSQL = "SELECT * FROM `s_employers` WHERE `id`='{$iMemberID}'";
        $aMemberInfos = $GLOBALS['MySQL']->getAll($sSQL);
        //Members info posted as an array
        $GLOBALS['aLMemInfo'] = $aMemberInfos[0];
    }

}

//exports globally a new object with all methods inherited
$GLOBALS['oSimpleLoginSystem'] = new SimpleLoginSystem();

?>