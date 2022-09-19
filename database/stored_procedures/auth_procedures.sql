DELIMITER $$


CREATE PROCEDURE sp_login(
    IN _loginOrEmail            VARCHAR(255)
)
BEGIN

    SELECT
            password
    FROM
            users
    WHERE
            email = _loginOrEmail OR username = _loginOrEmail;

END$$

DELIMITER ;