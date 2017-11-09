<?php
/**
 * Author:  Jacob Mills
 * Description: Class for managing authentication routines
 * Date: 10/15/2017
 */

include_once("SessionManager.php");
include_once("DAL/accounts.php");

class Authentication
{

    // Returns boolean indication if user is found
    public static function authLogin($email,$password) {
        $account = Accounts::lookup($email);
        if($account != null && password_verify($password, $account->getPassword())) {
            SessionManager::setAccountID($account->getAccountID());
            SessionManager::setRoleID($account->getRoleID());
            return true;
        }
        else {
            return false;
        }
    }

    public static function createAccount($paramFirstName,$paramLastName,$paramEmail,$paramPassword,$paramBio,$paramRoleID,$paramImgURL,$paramDateOfBirth,$paramLocation,$paramCreateDate) {
        // Create password using the code below to generate a hash

        $options = [
            'cost' => 10,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        $hash = password_hash($paramPassword, PASSWORD_BCRYPT, $options);

        $account = new Accounts(0,$paramFirstName,$paramLastName,$paramEmail,$hash,$paramBio,$paramRoleID,$paramImgURL,$paramDateOfBirth,$paramLocation,$paramCreateDate);
        $account->save();

        return $account;
    }
}

?>