use tasktracker;
DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_messages_LoadByRecipientAccountID`
(
	 IN paramAccountID INT
)
BEGIN
	SELECT
		`messages`.`MessageID` AS `MessageID`,
		`messages`.`Description` AS `Description`,
		`messages`.`SenderAccountID` AS `SenderAccountID`,
		`messages`.`RecipientAccountID` AS `RecipientAccountID`,
		`messages`.`SentDate` AS `SentDate`,
		`messages`.`Seen` AS `Seen`
	FROM `messages`
	WHERE 		`messages`.`RecipientAccountID` = paramAccountID
	-- AND `messages`.`Seen` = 0
	ORDER BY `messages`.`SentDate` DESC;
END //
DELIMITER ;