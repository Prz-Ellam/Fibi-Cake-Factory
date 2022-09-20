
DELIMITER $$

CREATE PROCEDURE sp_login(
    IN _loginOrEmail            VARCHAR(255)
)
BEGIN

    SELECT
        BIN_TO_UUID(user_id) as 'user_id',
        password,
        BIN_TO_UUID(profile_picture) as 'profile_picture'
    FROM
        users
    WHERE
        email = _loginOrEmail OR username = _loginOrEmail;

END$$

DELIMITER ;