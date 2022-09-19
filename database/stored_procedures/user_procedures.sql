
DELIMITER $$

CREATE PROCEDURE sp_create_user(
    IN _user_id                 VARCHAR(36),
    IN _email                   VARCHAR(255),
    IN _username                VARCHAR(18),
    IN _first_name              VARCHAR(50),
    IN _last_name               VARCHAR(50),
    IN _birth_date              DATE,
    IN _password                VARCHAR(255),
    IN _gender                  INT,
    IN _visibility              INT,
    IN _user_role               INT,
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
            visibility, 
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
            _visibility, 
            _user_role, 
            UUID_TO_BIN(_profile_picture)
    );

END$$

DELIMITER ;


CREATE PROCEDURE sp_update_user();

CREATE PROCEDURE sp_update_user_password();

CREATE PROCEDURE sp_delete_user();

CREATE PROCEDURE sp_get_users();

CREATE PROCEDURE sp_is_email_available();

CREATE PROCEDURE sp_is_username_available();
