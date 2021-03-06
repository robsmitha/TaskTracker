/*
Author:			This code was generated by DALGen version 1.0.0.0 available at https://github.com/H0r53/DALGen 
Date:			11/19/2017
Description:	Creates the comments table and respective stored procedures

*/


USE tasktracker;



--------------------------------------------------------------
-- Create table
--------------------------------------------------------------



CREATE TABLE `tasktracker`.`comments` (
CommentID INT AUTO_INCREMENT,
Description VARCHAR(1025),
AccountID INT,
TaskID INT,
CommentStatusTypeID INT,
CreateDate DATETIME,
EditDate DATETIME,
CONSTRAINT pk_comments_CommentID PRIMARY KEY (CommentID)
,
CONSTRAINT fk_comments_AccountID_accounts_AccountID FOREIGN KEY (AccountID) REFERENCES accounts (AccountID)
,
CONSTRAINT fk_comments_TaskID_tasks_TaskID FOREIGN KEY (TaskID) REFERENCES tasks (TaskID)
,
CONSTRAINT fk_comments_CommentStatusTypeID_comstattypes_CommentStatusTypeID FOREIGN KEY (CommentStatusTypeID) REFERENCES commentstatustypes (CommentStatusTypeID)
);


--------------------------------------------------------------
-- Create default SCRUD sprocs for this table
--------------------------------------------------------------


DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_comments_Load`
(
	 IN paramCommentID INT
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
	WHERE 		`comments`.`CommentID` = paramCommentID;
END //
DELIMITER ;

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
	FROM `comments`;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_comments_Add`
(
	 IN paramDescription VARCHAR(1025),
	 IN paramAccountID INT,
	 IN paramTaskID INT,
	 IN paramCommentStatusTypeID INT,
	 IN paramCreateDate DATETIME,
	 IN paramEditDate DATETIME
)
BEGIN
	INSERT INTO `comments` (Description,AccountID,TaskID,CommentStatusTypeID,CreateDate,EditDate)
	VALUES (paramDescription, paramAccountID, paramTaskID, paramCommentStatusTypeID, paramCreateDate, paramEditDate);
	-- Return last inserted ID as result
	SELECT LAST_INSERT_ID() as id;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_comments_Update`
(
	IN paramCommentID INT,
	IN paramDescription VARCHAR(1025),
	IN paramAccountID INT,
	IN paramTaskID INT,
	IN paramCommentStatusTypeID INT,
	IN paramCreateDate DATETIME,
	IN paramEditDate DATETIME
)
BEGIN
	UPDATE `comments`
	SET Description = paramDescription
		,AccountID = paramAccountID
		,TaskID = paramTaskID
		,CommentStatusTypeID = paramCommentStatusTypeID
		,CreateDate = paramCreateDate
		,EditDate = paramEditDate
	WHERE		`comments`.`CommentID` = paramCommentID;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_comments_Delete`
(
	IN paramCommentID INT
)
BEGIN
	DELETE FROM `comments`
	WHERE		`comments`.`CommentID` = paramCommentID;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_comments_Search`
(
	IN paramCommentID INT,
	IN paramDescription VARCHAR(1025),
	IN paramAccountID INT,
	IN paramTaskID INT,
	IN paramCommentStatusTypeID INT,
	IN paramCreateDate DATETIME,
	IN paramEditDate DATETIME
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
	WHERE
		COALESCE(comments.`CommentID`,0) = COALESCE(paramCommentID,comments.`CommentID`,0)
		AND COALESCE(comments.`Description`,'') = COALESCE(paramDescription,comments.`Description`,'')
		AND COALESCE(comments.`AccountID`,0) = COALESCE(paramAccountID,comments.`AccountID`,0)
		AND COALESCE(comments.`TaskID`,0) = COALESCE(paramTaskID,comments.`TaskID`,0)
		AND COALESCE(comments.`CommentStatusTypeID`,0) = COALESCE(paramCommentStatusTypeID,comments.`CommentStatusTypeID`,0)
		AND COALESCE(CAST(comments.`CreateDate` AS DATE), CAST(NOW() AS DATE)) = COALESCE(CAST(paramCreateDate AS DATE),CAST(comments.`CreateDate` AS DATE), CAST(NOW() AS DATE))
		AND COALESCE(CAST(comments.`EditDate` AS DATE), CAST(NOW() AS DATE)) = COALESCE(CAST(paramEditDate AS DATE),CAST(comments.`EditDate` AS DATE), CAST(NOW() AS DATE));
END //
DELIMITER ;


