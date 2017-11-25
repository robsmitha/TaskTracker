use tasktracker;
-- Description: Loads interactions from messages table between two accounts
DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_messages_LoadMessageFeed`
(
	 IN paramSenderAccountID INT,
	 IN paramRecipientAccountID INT
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
	WHERE `messages`.`SenderAccountID` = 1
	AND `messages`.`RecipientAccountID` = 2
	UNION ALL
	SELECT
		`messages`.`MessageID` AS `MessageID`,
		`messages`.`Description` AS `Description`,
		`messages`.`SenderAccountID` AS `SenderAccountID`,
		`messages`.`RecipientAccountID` AS `RecipientAccountID`,
		`messages`.`SentDate` AS `SentDate`,
		`messages`.`Seen` AS `Seen`
	WHERE `messages`.`SenderAccountID` = 2
	AND `messages`.`RecipientAccountID` = 1
	ORDER BY `messages`.`SentDate` DESC;
END //
DELIMITER ;