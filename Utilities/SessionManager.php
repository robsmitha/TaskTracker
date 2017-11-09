<?php
/*
 * Author:      Jacob Mills
 * Date:        10/16/2017
 * Description: This utility provides static functions to implement centralized accessor/mutator methods for all session values.
 *
 */


class SessionManager
{

    public static function getTestMessage() {
        if (isset($_SESSION['msg']))
            return $_SESSION['msg'];
        else
            return "";

    }

    public static function setTestMessage($arg1){
        $_SESSION['msg'] = $arg1;
    }



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
}

