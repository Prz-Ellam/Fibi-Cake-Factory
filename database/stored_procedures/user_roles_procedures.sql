
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_create_user_role $$

CREATE PROCEDURE sp_create_user_role(
    IN _user_role_id                VARCHAR(36),
    IN _name                        VARCHAR(50)
)
BEGIN

    INSERT INTO user_roles(
        user_role_id,
        name
    )
    VALUES(
        UUID_TO_BIN(_user_role_id),
        _name
    );

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_user_role_by_name $$

CREATE PROCEDURE sp_get_user_role_by_name(
    IN _name                        VARCHAR(50)
)
BEGIN

    SELECT
        BIN_TO_UUID(user_role_id) userRoleId,
        name
    FROM
        user_roles
    WHERE
        name = _name
    LIMIT
        1;

END $$
DELIMITER ;




SELECT * FROM users;