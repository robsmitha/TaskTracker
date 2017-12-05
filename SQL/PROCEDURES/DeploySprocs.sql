


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

use tasktracker;
DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_comments_LoadByTaskID`
(
	 IN paramTaskID INT
)
BEGIN
	SELECT
		`comments`.`CommentID` AS `CommentID`,
		`comments`.`Description` AS `Description`,
		`comments`.`AccountID` AS `AccountID`,
		`comments`.`TaskID` AS `TaskID`,
		`comments`.`CommentStatusTypeID` AS `CommentStatusTypeID`,
		`comments`.`CreateDate` AS `CreateDate`,
		`comments`.`EditDate` AS `EditDate`
	FROM `comments`
	WHERE 		`comments`.`TaskID` = paramTaskID;
END //
DELIMITER ;

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
	AND `messages`.`Seen` = 0
	ORDER BY `messages`.`SentDate` DESC;
END //
DELIMITER ;

use tasktracker;
DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_notifications_LoadByAccountID`
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

use tasktracker;
DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_rolestopermissions_LoadByRoleID`
(
	 IN paramRoleID INT
)
BEGIN
	SELECT
		`rolestopermissions`.`RoleToPermissionID` AS `RoleToPermissionID`,
		`rolestopermissions`.`RoleID` AS `RoleID`,
		`rolestopermissions`.`PermissionID` AS `PermissionID`
	FROM `rolestopermissions`
	WHERE 		`rolestopermissions`.`RoleID` = paramRoleID;
END //
DELIMITER ;

use tasktracker;
DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_tasks_LoadByAccountID`
(
	 IN paramAccountID INT
)
BEGIN
	SELECT
		`tasks`.`TaskID` AS `TaskID`,
		`tasks`.`TaskName` AS `TaskName`,
		`tasks`.`Description` AS `Description`,
		`tasks`.`AssigneeAccountID` AS `AssigneeAccountID`,
		`tasks`.`ReporterAccountID` AS `ReporterAccountID`,
		`tasks`.`StatusTypeID` AS `StatusTypeID`,
		`tasks`.`TaskTypeID` AS `TaskTypeID`,
		`tasks`.`PriorityTypeID` AS `PriorityTypeID`,
		`tasks`.`ProjectID` AS `ProjectID`,
		`tasks`.`CreateDate` AS `CreateDate`,
		`tasks`.`CloseDate` AS `CloseDate`,
		`tasks`.`ReopenDate` AS `ReopenDate`
	FROM `tasks`
	WHERE 		`tasks`.`AssigneeAccountID` = paramAccountID;
END //
DELIMITER ;

use tasktracker;
DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_tasks_LoadByProjectID`
(
	 IN paramProjectID INT
)
BEGIN
	SELECT
		`tasks`.`TaskID` AS `TaskID`,
		`tasks`.`TaskName` AS `TaskName`,
		`tasks`.`Description` AS `Description`,
		`tasks`.`AssigneeAccountID` AS `AssigneeAccountID`,
		`tasks`.`ReporterAccountID` AS `ReporterAccountID`,
		`tasks`.`StatusTypeID` AS `StatusTypeID`,
		`tasks`.`TaskTypeID` AS `TaskTypeID`,
		`tasks`.`PriorityTypeID` AS `PriorityTypeID`,
		`tasks`.`ProjectID` AS `ProjectID`,
		`tasks`.`CreateDate` AS `CreateDate`,
		`tasks`.`CloseDate` AS `CloseDate`,
		`tasks`.`ReopenDate` AS `ReopenDate`
	FROM `tasks`
	WHERE 		`tasks`.`ProjectID` = paramProjectID;
END //
DELIMITER ;

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

use tasktracker;

DROP PROCEDURE `tasktracker`.`usp_comments_LoadByTaskID`;

DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_comments_LoadByTaskID`
(
	 IN paramTaskID INT
)
BEGIN
	SELECT
		`comments`.`CommentID` AS `CommentID`,
		`comments`.`Description` AS `Description`,
		`comments`.`AccountID` AS `AccountID`,
		`comments`.`TaskID` AS `TaskID`,
		`comments`.`CommentStatusTypeID` AS `CommentStatusTypeID`,
		`comments`.`CreateDate` AS `CreateDate`,
		`comments`.`EditDate` AS `EditDate`
	FROM `comments`
	WHERE 		`comments`.`TaskID` = paramTaskID
	AND `comments`.`CommentStatusTypeID` != 2 -- not deleted
	ORDER BY `comments`.`CreateDate` DESC;
END //
DELIMITER ;


use tasktracker;
DROP PROCEDURE `tasktracker`.`usp_comments_LoadAll`;


DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_comments_LoadAll`()
BEGIN
	SELECT
		`comments`.`CommentID` AS `CommentID`,
		`comments`.`Description` AS `Description`,
		`comments`.`AccountID` AS `AccountID`,
		`comments`.`TaskID` AS `TaskID`,
		`comments`.`CommentStatusTypeID` AS `CommentStatusTypeID`,
		`comments`.`CreateDate` AS `CreateDate`,
		`comments`.`EditDate` AS `EditDate`
	FROM `comments`
	ORDER BY `comments`.`CreateDate` DESC;
END //
DELIMITER ;


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
	WHERE `messages`.`SenderAccountID` = paramSenderAccountID
	AND `messages`.`RecipientAccountID` = paramRecipientAccountID
	ORDER BY `messages`.`SentDate` DESC;
END //
DELIMITER ;

USE tasktracker;



DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_notifications_ClearNotificationsByAccountID`
(
	 IN paramAccountID INT
)
BEGIN
  UPDATE notifications
  SET Seen = 1,
  SeenDate = NOW()
  WHERE AccountID = paramAccountID;
END //
DELIMITER ;

