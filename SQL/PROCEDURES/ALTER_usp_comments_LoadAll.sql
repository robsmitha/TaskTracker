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