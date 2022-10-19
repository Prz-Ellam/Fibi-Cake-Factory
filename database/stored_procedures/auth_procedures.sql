
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_login $$

CREATE PROCEDURE sp_login(
    IN _loginOrEmail            VARCHAR(255)
)
BEGIN

    SELECT
        BIN_TO_UUID(u.user_id) as 'user_id',
        u.password,
        ur.name as 'user_role',
        BIN_TO_UUID(u.profile_picture) as 'profile_picture'
    FROM
        users AS u
    INNER JOIN
        user_roles AS ur
    ON
        BIN_TO_UUID(u.user_role) = BIN_TO_UUID(ur.user_role_id)
    WHERE
        email = _loginOrEmail 
        OR username = _loginOrEmail;

END$$

DELIMITER ;



CALL sp_login('PerezAlex088@outlook.com')


SELECT image_id, name, created_at FROM images;
