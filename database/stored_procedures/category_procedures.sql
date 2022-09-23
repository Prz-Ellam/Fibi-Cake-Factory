
DELIMITER $$

CREATE PROCEDURE sp_create_category(
    IN _category_id             VARCHAR(36),
    IN _name                    VARCHAR(50),
    IN _description             VARCHAR(200),
    IN _user_id                 VARCHAR(36)
)
BEGIN

    INSERT INTO categories(
        category_id,
        name,
        description,
        user_id
    )
    VALUES(
        UUID_TO_BIN(_category_id),
        _name,
        _description,
        UUID_TO_BIN(_user_id)
    );

END$$

DELIMITER ;



DELIMITER $$

CREATE PROCEDURE sp_update_category(
    IN _category_id             VARCHAR(36),
    IN _name                    VARCHAR(50),
    IN _description             VARCHAR(200)
)
BEGIN

    UPDATE
        categories
    SET
        name        = IFNULL(_name, name),
        description = IFNULL(_description, description),
        modified_at = NOW()
    WHERE
        BIN_TO_UUID(category_id) = _category_id
        AND active = TRUE;

END$$

DELIMITER ;



DELIMITER $$

CREATE PROCEDURE sp_delete_category(
    IN _category_id             VARCHAR(36)
)
BEGIN

    UPDATE
        categories
    SET
        active      = FALSE,
        modified_at = NOW()
    WHERE
        BIN_TO_UUID(category_id) = _category_id;

END $$
DELIMITER ;


DELIMITER $$

CREATE PROCEDURE sp_get_categories()
BEGIN

    SELECT
        BIN_TO_UUID(category_id) as 'category_id',
        name,
        description,
        BIN_TO_UUID(user_id) as 'user_id'
    FROM
        categories
    WHERE
        active = TRUE;

END$$

DELIMITER ;