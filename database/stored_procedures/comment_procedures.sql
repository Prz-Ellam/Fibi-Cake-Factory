USE cake_factory;

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_create_comment $$

CREATE PROCEDURE sp_create_comment(
    IN _comment_id              VARCHAR(36),
    IN _message                 VARCHAR(255),
    IN _product_id              VARCHAR(36),
    IN _user_id                 VARCHAR(36)
)
BEGIN

    INSERT INTO comments(
        comment_id,
        message,
        product_id,
        user_id
    )
    VALUES(
        UUID_TO_BIN(_comment_id),
        _message,
        UUID_TO_BIN(_product_id),
        UUID_TO_BIN(_user_id)
    );

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_comments_get_all_by_product $$

CREATE PROCEDURE sp_comments_get_all_by_product(
    IN _product_id              VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(c.comment_id) id,
        c.message,
        BIN_TO_UUID(c.product_id) productId,
        BIN_TO_UUID(c.user_id) userId,
        u.username,
        BIN_TO_UUID(u.profile_picture) profilePicture,
        c.created_at createdAt,
        c.modified_at modifiedAt
    FROM
        comments AS c
    INNER JOIN
        users AS u
    ON
        BIN_TO_UUID(c.user_id) = BIN_TO_UUID(u.user_id)
    WHERE
        BIN_TO_UUID(product_id) = _product_id
    ORDER BY
        c.created_at DESC;

END $$
DELIMITER ;



SELECT * FROM users;
