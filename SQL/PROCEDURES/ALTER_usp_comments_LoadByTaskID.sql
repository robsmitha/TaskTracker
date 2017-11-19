USE smithadb;

DROP PROCEDURE `smithadb`.`usp_comments_LoadByTaskID`;

DELIMITER //
CREATE PROCEDURE `smithadb`.`usp_comments_LoadByTaskID`
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
	AND `comments`.`CommentStatusTypeID` != 2; -- not deleted
END //
DELIMITER ;