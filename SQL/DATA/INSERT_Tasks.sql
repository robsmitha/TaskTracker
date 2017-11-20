use tasktracker;
INSERT INTO `tasks` (`TaskID`, `TaskName`, `Description`, `AssigneeAccountID`, `ReporterAccountID`, `StatusTypeID`, `TaskTypeID`, `PriorityTypeID`, `ProjectID`, `CreateDate`, `CloseDate`, `ReopenDate`)
VALUES (1, 'Example Task', 'Example task inserted by default', 1, 1, 1, 1, 1, 1, NOW(), NULL, NULL);