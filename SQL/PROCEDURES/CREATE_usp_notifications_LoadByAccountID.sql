DELIMITER //
CREATE PROCEDURE `smithadb`.`usp_notifications_LoadByAccountID`
(
	 IN paramAccountID INT
)
BEGIN
	SELECT
		`notifications`.`NotificationID` AS `NotificationID`,
		`notifications`.`NotificationTypeID` AS `NotificationTypeID`,
		`notifications`.`AccountID` AS `AccountID`,
		`notifications`.`CreateDate` AS `CreateDate`,
		`notifications`.`SeenDate` AS `SeenDate`,
		`notifications`.`Seen` AS `Seen`,
		`notifications`.`TaskID` AS `TaskID`,
		`notifications`.`ProjectID` AS `ProjectID`,
		`notifications`.`CommentID` AS `CommentID`
	FROM `notifications`
	JOIN `notificationtypes` ON `notifications`.`NotificationTypeID` = `notificationtypes`.`NotificationTypeID`
	WHERE 		`notifications`.`AccountID` = paramAccountID
	AND `notifications`.`Seen` = 0    -- unseen notifications
	ORDER BY `notifications`.`CreateDate` DESC; -- show latest first
END //
DELIMITER ;