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