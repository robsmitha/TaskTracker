<?php
/*
 * Author:      Jacob Mills
 * Date:        10/16/2017
 * Description: This utility provides static functions to implement centralized accessor/mutator methods for all session values.
 *
 */


class SessionManager
{
    public static function getAccountID() {
        if (isset($_SESSION['AccountID']))
            return $_SESSION['AccountID'];
        else
            return 0;

    }

    public static function setAccountID($arg1){
        $_SESSION['AccountID'] = $arg1;
    }

    //For roles
    public static function getRoleID() {
        if (isset($_SESSION['RoleID']))
            return $_SESSION['RoleID'];
        else
            return 0;

    }

    public static function setRoleID($arg1){
        $_SESSION['RoleID'] = $arg1;
    }
    //for name
    public static function getFirstName() {
        if (isset($_SESSION['FirstName']))
            return $_SESSION['FirstName'];
        else
            return 0;

    }

    public static function setFirstName($arg1){
        $_SESSION['FirstName'] = $arg1;
    }

    public static function ResetSession(){
        $_SESSION['FirstName'] = "";
        $_SESSION['RoleID'] = "";
        $_SESSION['AccountID'] = "";
        session_destroy();
    }
}

