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