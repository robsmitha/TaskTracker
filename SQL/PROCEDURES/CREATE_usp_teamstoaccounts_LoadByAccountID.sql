use tasktracker;
DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_teamstoaccounts_LoadByAccountID`
(
	 IN paramAccountID INT
)
BEGIN
	SELECT
		`teamstoaccounts`.`TeamToAccountID` AS `TeamToAccountID`,
		`teamstoaccounts`.`TeamID` AS `TeamID`,
		`teamstoaccounts`.`AccountID` AS `AccountID`
	FROM `teamstoaccounts`
	WHERE 		`teamstoaccounts`.`AccountID` = paramAccountID;
END //
DELIMITER ;