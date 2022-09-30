
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_create_user $$

CREATE PROCEDURE sp_create_user(
    IN _user_id                 VARCHAR(36),
    IN _email                   VARCHAR(255),
    IN _username                VARCHAR(18),
    IN _first_name              VARCHAR(50),
    IN _last_name               VARCHAR(50),
    IN _birth_date              DATE,
    IN _password                VARCHAR(255),
    IN _gender                  INT,
    IN _visible                 BOOLEAN,
    IN _user_role               VARCHAR(36),
    IN _profile_picture         VARCHAR(36)
)
BEGIN

    INSERT INTO users(
        user_id,
        email, 
        username, 
        first_name, 
        last_name, 
        birth_date, 
        password, 
        gender, 
        visible, 
        user_role, 
        profile_picture
    )
    VALUES(
        UUID_TO_BIN(_user_id),
        _email, 
        _username, 
        _first_name, 
        _last_name, 
        _birth_date, 
        _password, 
        _gender, 
        _visible, 
        UUID_TO_BIN(_user_role), 
        UUID_TO_BIN(_profile_picture)
    );

END$$
DELIMITER ;


CREATE PROCEDURE sp_update_user();

CREATE PROCEDURE sp_update_user_password();

CREATE PROCEDURE sp_delete_user();




DELIMITER $$

CREATE PROCEDURE sp_get_users(
    IN _search              VARCHAR(255)
)
BEGIN

    SELECT
        BIN_TO_UUID(user_id),
        email,
        username
    FROM
        users
    WHERE
        username LIKE CONCAT('%', _search, '%');

END $$
DELIMITER ;


CALL sp_get_users_except('', '1');

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_users_except $$

CREATE PROCEDURE sp_get_users_except(
    IN _search              VARCHAR(255),
    IN _user_id             VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(u.user_id) id,
        u.email,
        u.username,
        ur.name userRole
    FROM
        users AS u
    INNER JOIN
        user_roles AS ur
    ON
        BIN_TO_UUID(u.user_role) = BIN_TO_UUID(ur.user_role_id)
    WHERE
        username LIKE CONCAT('%', _search, '%')
        AND BIN_TO_UUID(user_id) <> _user_id;

END $$
DELIMITER ;




DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_user $$

CREATE PROCEDURE sp_get_user(
    IN _user_id                 VARCHAR(36)
)
BEGIN

    SELECT
        email,
        username,
        first_name AS firstName,
        last_name AS lastName,
        birth_date AS birthDate,
        gender AS gender,
        BIN_TO_UUID(profile_picture) AS profilePicture
    FROM
        users
    WHERE
        BIN_TO_UUID(user_id) = _user_id;

END $$
DELIMITER ;



DELIMITER $$
CREATE PROCEDURE sp_email_exists(
    IN _email           VARCHAR(255)
)
BEGIN

    SELECT
        IF(COUNT(email) > 0, TRUE, FALSE)
    FROM
        users
    WHERE
        email = _email;

END $$
DELIMITER ;



DELIMITER $$
CREATE PROCEDURE sp_username_exists(
    IN _username            VARCHAR(18)
)
BEGIN

    SELECT
        IF(COUNT(username) > 0, TRUE, FALSE)
    FROM
        users
    WHERE
        username = _username;

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_user_by_username $$

CREATE PROCEDURE sp_get_user_by_username(
    IN _username                 VARCHAR(18)
)
BEGIN

    SELECT
        email,
        username,
        first_name AS firstName,
        last_name AS lastName,
        birth_date AS birthDate,
        gender AS gender,
        BIN_TO_UUID(profile_picture) AS profilePicture
    FROM
        users
    WHERE
        username = _username;

END $$
DELIMITER ;