use tasktracker;
DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_account_Lookup`
(
	IN paramEmail VARCHAR(255)
)
BEGIN
	SELECT
		`accounts`.`AccountID` AS `AccountID`,
		`accounts`.`FirstName` AS `FirstName`,
		`accounts`.`LastName` AS `LastName`,
		`accounts`.`Email` AS `Email`,
		`accounts`.`Password` AS `Password`,
		`accounts`.`Bio` AS `Bio`,
		`accounts`.`RoleID` AS `RoleID`,
		`accounts`.`ImgURL` AS `ImgURL`,
		`accounts`.`DateOfBirth` AS `DateOfBirth`,
		`accounts`.`Location` AS `Location`,
		`accounts`.`CreateDate` AS `CreateDate`
	FROM `accounts`
	WHERE 		`accounts`.`Email` = paramEmail;
END //
DELIMITER ;