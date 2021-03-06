/*
Author:			This code was generated by DALGen version 1.0.0.0 available at https://github.com/H0r53/DALGen 
Date:			11/19/2017
Description:	Creates the projectcategorytypes table and respective stored procedures

*/


USE tasktracker;



--------------------------------------------------------------
-- Create table
--------------------------------------------------------------



CREATE TABLE `tasktracker`.`projectcategorytypes` (
ProjectCategoryTypeID INT AUTO_INCREMENT,
ProjectCategoryType VARCHAR(255),
Description VARCHAR(1025),
CONSTRAINT pk_projectcategorytypes_ProjectCategoryTypeID PRIMARY KEY (ProjectCategoryTypeID)
);


--------------------------------------------------------------
-- Create default SCRUD sprocs for this table
--------------------------------------------------------------


DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_projectcategorytypes_Load`
(
	 IN paramProjectCategoryTypeID INT
)
BEGIN
	SELECT
		`projectcategorytypes`.`ProjectCategoryTypeID` AS `ProjectCategoryTypeID`,
		`projectcategorytypes`.`ProjectCategoryType` AS `ProjectCategoryType`,
		`projectcategorytypes`.`Description` AS `Description`
	FROM `projectcategorytypes`
	WHERE 		`projectcategorytypes`.`ProjectCategoryTypeID` = paramProjectCategoryTypeID;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_projectcategorytypes_LoadAll`()
BEGIN
	SELECT
		`projectcategorytypes`.`ProjectCategoryTypeID` AS `ProjectCategoryTypeID`,
		`projectcategorytypes`.`ProjectCategoryType` AS `ProjectCategoryType`,
		`projectcategorytypes`.`Description` AS `Description`
	FROM `projectcategorytypes`;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_projectcategorytypes_Add`
(
	 IN paramProjectCategoryType VARCHAR(255),
	 IN paramDescription VARCHAR(1025)
)
BEGIN
	INSERT INTO `projectcategorytypes` (ProjectCategoryType,Description)
	VALUES (paramProjectCategoryType, paramDescription);
	-- Return last inserted ID as result
	SELECT LAST_INSERT_ID() as id;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_projectcategorytypes_Update`
(
	IN paramProjectCategoryTypeID INT,
	IN paramProjectCategoryType VARCHAR(255),
	IN paramDescription VARCHAR(1025)
)
BEGIN
	UPDATE `projectcategorytypes`
	SET ProjectCategoryType = paramProjectCategoryType
		,Description = paramDescription
	WHERE		`projectcategorytypes`.`ProjectCategoryTypeID` = paramProjectCategoryTypeID;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_projectcategorytypes_Delete`
(
	IN paramProjectCategoryTypeID INT
)
BEGIN
	DELETE FROM `projectcategorytypes`
	WHERE		`projectcategorytypes`.`ProjectCategoryTypeID` = paramProjectCategoryTypeID;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE `tasktracker`.`usp_projectcategorytypes_Search`
(
	IN paramProjectCategoryTypeID INT,
	IN paramProjectCategoryType VARCHAR(255),
	IN paramDescription VARCHAR(1025)
)
BEGIN
	SELECT
		`projectcategorytypes`.`ProjectCategoryTypeID` AS `ProjectCategoryTypeID`,
		`projectcategorytypes`.`ProjectCategoryType` AS `ProjectCategoryType`,
		`projectcategorytypes`.`Description` AS `Description`
	FROM `projectcategorytypes`
	WHERE
		COALESCE(projectcategorytypes.`ProjectCategoryTypeID`,0) = COALESCE(paramProjectCategoryTypeID,projectcategorytypes.`ProjectCategoryTypeID`,0)
		AND COALESCE(projectcategorytypes.`ProjectCategoryType`,'') = COALESCE(paramProjectCategoryType,projectcategorytypes.`ProjectCategoryType`,'')
		AND COALESCE(projectcategorytypes.`Description`,'') = COALESCE(paramDescription,projectcategorytypes.`Description`,'');
END //
DELIMITER ;


