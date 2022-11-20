DELIMITER $$
DROP PROCEDURE IF EXISTS sp_users_create $$

CREATE PROCEDURE sp_users_create(
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



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_users_update $$

CREATE PROCEDURE sp_users_update(
    IN _user_id                 VARCHAR(36),
    IN _email                   VARCHAR(255),
    IN _username                VARCHAR(18),
    IN _first_name              VARCHAR(50),
    IN _last_name               VARCHAR(50),
    IN _birth_date              DATE,
    IN _gender                  INT,
    IN _profile_picture         VARCHAR(36)
)
BEGIN

    UPDATE
        users
    SET
        email           = IFNULL(_email, email),
        username        = IFNULL(_username, username),
        first_name      = IFNULL(_first_name, first_name),
        last_name       = IFNULL(_last_name, last_name),
        birth_date      = IFNULL(_birth_date, birth_date),
        gender          = IFNULL(_gender, gender),
        profile_picture = IFNULL(UUID_TO_BIN(_profile_picture), profile_picture),
        modified_at     = NOW()
    WHERE
        BIN_TO_UUID(user_id) = _user_id
        AND active = TRUE;

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_users_update_password $$

CREATE PROCEDURE sp_users_update_password(
    IN _user_id                 VARCHAR(36),
    IN _password                VARCHAR(255)
)
BEGIN

    UPDATE
        users
    SET
        password        = IFNULL(_password, password),
        modified_at     = NOW()
    WHERE
        BIN_TO_UUID(user_id) = _user_id
        AND active = TRUE;

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_users_delete $$

CREATE PROCEDURE sp_users_delete(
    IN _user_id                 VARCHAR(36)
)
BEGIN

    UPDATE
        users
    SET
        active          = FALSE,
        modified_at     = NOW()
    WHERE
        BIN_TO_UUID(user_id) = _user_id;

END
DELIMITER ;



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


CALL sp_get_users_except('', '');

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
        u.first_name,
        u.last_name,
        u.profile_picture,
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
        u.email,
        u.username,
        u.first_name AS firstName,
        u.last_name AS lastName,
        u.birth_date AS birthDate,
        u.visible AS visible,
        u.gender AS gender,
        ur.name AS userRole,
        BIN_TO_UUID(u.profile_picture) AS profilePicture
    FROM
        users AS u
    INNER JOIN
        user_roles AS ur
    ON
        BIN_TO_UUID(u.user_role) = BIN_TO_UUID(ur.user_role_id)
    WHERE
        BIN_TO_UUID(user_id) = _user_id
    LIMIT
        1;

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_user_by_filter $$

CREATE PROCEDURE sp_get_user_by_filter(
    IN _filter                  VARCHAR(255),
    IN _except                  VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(u.user_id) id,
        u.email,
        u.username,
        u.first_name AS firstName,
        u.last_name AS lastName,
        u.birth_date AS birthDate,
        u.gender AS gender,
        ur.name AS userRole,
        BIN_TO_UUID(u.profile_picture) AS profilePicture
    FROM
        users AS u
    INNER JOIN
        user_roles AS ur
    ON
        BIN_TO_UUID(u.user_role) = BIN_TO_UUID(ur.user_role_id)
    WHERE
        u.username LIKE CONCAT('%', _filter, '%')
        AND BIN_TO_UUID(u.user_id) != _except;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_email_exists $$

CREATE PROCEDURE sp_email_exists(
    IN _user_id         VARCHAR(36),
    IN _email           VARCHAR(255)
)
BEGIN

    SELECT
        IF(COUNT(email) > 0, TRUE, FALSE) 'result'
    FROM
        users
    WHERE
        email = _email
        AND BIN_TO_UUID(user_id) <> _user_id;

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_username_exists $$

CREATE PROCEDURE sp_username_exists(
    IN _user_id             VARCHAR(36),
    IN _username            VARCHAR(18)
)
BEGIN

    SELECT
        IF(COUNT(username) > 0, TRUE, FALSE) 'result'
    FROM
        users
    WHERE
        username = _username
        AND BIN_TO_UUID(user_id) <> _user_id;

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
