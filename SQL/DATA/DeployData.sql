
use tasktracker;
INSERT INTO `commentstatustypes` (`CommentStatusTypeID`, `CommentStatusType`, `Description`) VALUES (1, 'New', 'The comment has not been edited.');
INSERT INTO `commentstatustypes` (`CommentStatusTypeID`, `CommentStatusType`, `Description`) VALUES (2, 'Deleted', 'The comment has been marked deleted.');
INSERT INTO `commentstatustypes` (`CommentStatusTypeID`, `CommentStatusType`, `Description`) VALUES (3, 'Edit', 'The comment has been edited.');

use tasktracker;
INSERT INTO `notificationtypes` (`NotificationTypeID`, `Notification`, `Description`) VALUES (1, 'Like', 'New like on your comment.');

INSERT INTO `notificationtypes` (`NotificationTypeID`, `Notification`, `Description`) VALUES (2, 'Comment', 'New comment on one of your tasks.');

INSERT INTO `notificationtypes` (`NotificationTypeID`, `Notification`, `Description`) VALUES (3, 'Status Update', 'New status update on one of your tasks.');


use tasktracker;
INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (1, 'Can Create/Edit Accounts', 'Can Create/Edit Accounts', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (2, 'Can Create/Edit Comments', 'Can Create/Edit Comments', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (3, 'Can Create/Edit Comment Status Types', 'Can Create/Edit Comment Status Types', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (4, 'Can Create/Edit Notifications', 'Can Create/Edit Notifications', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (5, 'Can Create/Edit Permissions', 'Can Create/Edit Permissions', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (6, 'Can Create/Edit Priority Types', 'Can Create/Edit Priority Types', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (7, 'Can Create/Edit Project Category Types', 'Can Create/Edit Project Category Types', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (8, 'Can Create/Edit Projects', 'Can Create/Edit Projects', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (9, 'Can Create/Edit Roles', 'Can Create/Edit Roles', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (10, 'Can Create/Edit Roles To Permissions', 'Can Create/Edit Roles To Permissions', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (11, 'Can Create/Edit Status Types', 'Can Create/Edit Status Types', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (12, 'Can Create/Edit Tasks', 'Can Create/Edit Tasks', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (13, 'Can Create/Edit Task Types', 'Can Create/Edit Task Types', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (14, 'Can Create/Edit Teams', 'Can Create/Edit Teams', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (15, 'Can Create/Edit Teams To Accounts', 'Can Create/Edit Teams To Accounts', NULL);

-- Custom Permissions

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (16, 'Can Search Accounts', 'Can Search Accounts', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (17, 'Can Search Tasks', 'Can Search Tasks', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (18, 'Can Update Status', 'Can Update Status', NULL);

INSERT INTO `permissions` (`PermissionID`, `PermissionName`, `Description`, `CreateDate`) VALUES (19, 'Can Search Projects', 'Can Search Projects', NULL);


use tasktracker;
INSERT INTO `prioritytypes` (`PriorityTypeID`, `PriorityType`, `Description`) VALUES (1, 'Low', 'The task is open');

INSERT INTO `prioritytypes` (`PriorityTypeID`, `PriorityType`, `Description`) VALUES (2, 'Medium', 'Medium');

INSERT INTO `prioritytypes` (`PriorityTypeID`, `PriorityType`, `Description`) VALUES (3, 'High', 'High');

INSERT INTO `prioritytypes` (`PriorityTypeID`, `PriorityType`, `Description`) VALUES (4, 'Emergency', 'Emergency');


use tasktracker;
INSERT INTO `projectcategorytypes` (`ProjectCategoryTypeID`, `ProjectCategoryType`, `Description`) VALUES (1, 'ASP.NET Web Application', 'ASP.NET Web Application');

INSERT INTO `projectcategorytypes` (`ProjectCategoryTypeID`, `ProjectCategoryType`, `Description`) VALUES (2, 'PHP/MYSQL Web Application', 'PHP/MYSQL Web Application');

INSERT INTO `projectcategorytypes` (`ProjectCategoryTypeID`, `ProjectCategoryType`, `Description`) VALUES (3, 'HTML/CSS', 'An HTML/CSS website with no server side interactions');

use tasktracker;
INSERT INTO `roles` (`RoleID`, `Role`, `Description`) VALUES (1, 'Administrator', 'Administrator');

INSERT INTO `roles` (`RoleID`, `Role`, `Description`) VALUES (2, 'Developer', 'Developer');

INSERT INTO `roles` (`RoleID`, `Role`, `Description`) VALUES (3, 'Project Manager', 'Project Manager');

INSERT INTO `roles` (`RoleID`, `Role`, `Description`) VALUES (4, 'Quality Assurance', 'Quality Assurance');

INSERT INTO `roles` (`RoleID`, `Role`, `Description`) VALUES (5, 'Client Role', 'Client Role');

INSERT INTO `roles` (`RoleID`, `Role`, `Description`) VALUES (6, 'Read Only', 'Read Only');

use tasktracker;
-- Administrator (RoleID: 1)
INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (1, 1, 1);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (2, 1, 2);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (3, 1, 3);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (4, 1, 4);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (5, 1, 5);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (6, 1, 6);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (7, 1, 7);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (8, 1, 8);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (9, 1, 9);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (10, 1, 10);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (11, 1, 11);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (12, 1, 12);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (13, 1, 13);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (14, 1, 14);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (15, 1, 15);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (16, 1, 16);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (17, 1, 17);

-- Developer
INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (18, 2, 12);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (19, 2, 2);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (20, 2, 18);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (21, 2, 17);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (22, 2, 16);

-- Project Manager
INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (23, 3, 12);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (24, 3, 2);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (25, 3, 18);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (26, 3, 17);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (27, 3, 16);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (28, 3, 6);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (29, 3, 18);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (30, 3, 7);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (31, 3, 8);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (32, 3, 13);

-- Quality Assurance
INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (33, 4, 12);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (34, 4, 2);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (35, 4, 18);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (36, 4, 17);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (37, 4, 16);

-- Client Role
INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (38, 5, 12);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (39, 5, 2);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (40, 5, 17);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (41, 5, 16);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (42, 5, 8);

-- Read Only
INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (43, 6, 17);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (44, 6, 16);


-- add new permissions
INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (45, 1, 19);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (46, 2, 19);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (47, 3, 19);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (48, 4, 19);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (49, 5, 19);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (50, 6, 19);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (51, 1, 18);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (52, 2, 18);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (53, 3, 18);

INSERT INTO `rolestopermissions` (`RoleToPermissionID`, `RoleID`, `PermissionID`) VALUES (54, 4, 18);


use tasktracker;
INSERT INTO `statustypes` (`StatusTypeID`, `Status`, `Description`) VALUES (1, 'Open', 'The task is open');

INSERT INTO `statustypes` (`StatusTypeID`, `Status`, `Description`) VALUES (2, 'In Progress', 'The task has been marked in progress.');

INSERT INTO `statustypes` (`StatusTypeID`, `Status`, `Description`) VALUES (3, 'Resolved', 'The task has been resolved by the assignee.');

INSERT INTO `statustypes` (`StatusTypeID`, `Status`, `Description`) VALUES (4, 'Ready For Testing', 'The task is ready for testing.');

INSERT INTO `statustypes` (`StatusTypeID`, `Status`, `Description`) VALUES (5, 'Reopened', 'The task has failed testing requirements and has been reopened.');

INSERT INTO `statustypes` (`StatusTypeID`, `Status`, `Description`) VALUES (6, 'Closed', 'The task has been closed.');

use tasktracker;
INSERT INTO `tasktypes` (`TaskTypeID`, `TaskType`, `Description`) VALUES (1, 'Bug', 'Bug');

INSERT INTO `tasktypes` (`TaskTypeID`, `TaskType`, `Description`) VALUES (2, 'Improvement', 'Improvement');

INSERT INTO `tasktypes` (`TaskTypeID`, `TaskType`, `Description`) VALUES (3, 'Design', 'Design');

INSERT INTO `tasktypes` (`TaskTypeID`, `TaskType`, `Description`) VALUES (4, 'Development', 'Development');
use tasktracker;
INSERT INTO `teams` (`TeamID`, `Name`, `Description`) VALUES (1, 'COP4710', 'DB Group Project');


INSERT INTO `accounts` (`AccountID`, `FirstName`, `LastName`, `Email`, `Password`, `Bio`, `RoleID`, `ImgURL`, `DateOfBirth`, `Location`, `CreateDate`)
VALUES (1, 'Admin', 'Administrator', 'Admin@tasktracker.com', '$2y$10$uibAKGDKUZQy4RDwCgzeYO0ifI/vdIOnmXCzvn4gx/uk3IbF2LeKu', 'Bio', 1, '', NOW(), 'Florida', NOW());

use tasktracker;
INSERT INTO `projects` (`ProjectId`, `ProjectName`, `ProjectDescription`, `ImgURL`, `ProjectURL`, `ProjectLeadAccountID`, `ProjectCategoryID`)
VALUES (1, 'Example Project', 'Example project created by default', NULL, NULL, 1, 1);

use tasktracker;
INSERT INTO `tasks` (`TaskID`, `TaskName`, `Description`, `AssigneeAccountID`, `ReporterAccountID`, `StatusTypeID`, `TaskTypeID`, `PriorityTypeID`, `ProjectID`, `CreateDate`, `CloseDate`, `ReopenDate`)
VALUES (1, 'Example Task', 'Example task inserted by default', 1, 1, 1, 1, 1, 1, NOW(), NULL, NULL);

use tasktracker;
INSERT INTO `comments` (`CommentID`, `Description`, `AccountID`, `TaskID`, `CommentStatusTypeID`, `CreateDate`, `EditDate`) VALUES ('1', 'Example Comment', '1', '1', '1', '2017-11-20 00:00:00', NULL);