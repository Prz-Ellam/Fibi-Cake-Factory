DELIMITER //

CREATE FUNCTION BIN_TO_UUID(bin BINARY(16))
RETURNS CHAR(36) DETERMINISTIC
BEGIN
  DECLARE hex CHAR(32);
  SET hex = HEX(bin);
  RETURN LOWER(CONCAT(LEFT(hex, 8), '-', MID(hex, 9, 4), '-', MID(hex, 13, 4), '-', MID(hex, 17, 4), '-', RIGHT(hex, 12)));
END; //

DELIMITER ;



DELIMITER //

CREATE FUNCTION UUID_TO_BIN(uuid CHAR(36))
RETURNS BINARY(16) DETERMINISTIC
RETURN UNHEX(CONCAT(REPLACE(uuid, '-', ''))); //

DELIMITER ;