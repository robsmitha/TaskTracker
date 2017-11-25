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