USE cake_factory;

INSERT INTO users(email, username, user_role, birth_date, first_name, last_name, password, 
gender, profile_picture)
VALUES ('a@a.com', 'admin', 1, CURDATE(), 'elrod', 'perez', '123', 1, 1);


SELECT BIN_TO_UUID(user_id), email FROM users;


SELECT JSON_ARRAYAGG(JSON_OBJECT(
    'wishlist_id',  BIN_TO_UUID(wishlist_id), 
    'name',         name,
    'description',  description,
    'visibility',   visibility,
    'images',       (SELECT JSON_ARRAYAGG(BIN_TO_UUID(image_id)) 
                        FROM images 
                        WHERE BIN_TO_UUID(multimedia_entity_id) = BIN_TO_UUID(wishlist_id) AND
                        multimedia_entity_type = 'wishlists'
                    )
)) 
FROM wishlists
WHERE
    BIN_TO_UUID(user_id) = '516a3887-06b1-4203-ad59-07dc13d1e0fe' AND
    active = TRUE;


CALL sp_get_user_wishlists('516a3887-06b1-4203-ad59-07dc13d1e0fe');







SELECT JSON_ARRAYAGG(JSON_OBJECT(
        'wishlist_id', BIN_TO_UUID(w.wishlist_id),
        'name', w.name,
        'description', w.description,
        'visibility', w.visibility,
        'image_id', BIN_TO_UUID(i.image_id) image_id
        ))
    FROM
        wishlists as w
    INNER JOIN
        images AS i
    ON
        BIN_TO_UUID(w.wishlist_id) = BIN_TO_UUID(i.multimedia_entity_id) AND
        i.multimedia_entity_type = 'wishlists'
    WHERE
        BIN_TO_UUID(user_id) = '516a3887-06b1-4203-ad59-07dc13d1e0fe' AND
        w.active = TRUE AND i.active = TRUE;



SELECT *, BIN_TO_UUID(wishlist_id) wishlist_id FROM wishlists;


SELECT *, BIN_TO_UUID(image_id) image_id FROM images 
WHERE BIN_TO_UUID(multimedia_entity_id) = 'ca56c0e8-472a-42bf-9a10-1688bd46d8fe'
AND multimedia_entity_type = 'wishlists';



CALL sp_get_image('bea500c4-2847-4493-92ed-ddc4b968fbc5');

CALL sp_get_user_wishlists('4b8c6a1b-ab63-461e-9576-029d0d7f256c');

SELECT *, BIN_TO_UUID(user_id) as 'user_id' FROM users;

SELECT *, BIN_TO_UUID(wishlist_id) as 'wishlist_id' FROM wishlists;

SELECT * FROM images;

SELECT * FROM products;
SELECT * FROM categories;
SELECT * FROM wishlists;
SELECT * FROM shopping_carts;
SELECT * FROM orders;
SELECT * FROM reviews;

SELECT BIN_TO_UUID(video_id) FROM videos;

DROP TABLE wishlists;
DROP TABLE images;

TRUNCATE TABLE videos;
TRUNCATE TABLE products;

SELECT BIN_TO_UUID(image_id), multimedia_entity_type FROM images WHERE BIN_TO_UUID(multimedia_entity_id) = '168c5a97-5612-4c30-aec2-5bd979009706';


CALL sp_update_wishlist('6579eafa-bd06-4f5f-8b75-f66b257908a7', 'Adios', 'Mundo', 0);


SELECT BIN_TO_UUID(image_id), name FROM images WHERE BIN_TO_UUID(multimedia_entity_id) = 'f6244906-5528-439b-bc2b-cccc61b30c8c';

SELECT BIN_TO_UUID(video_id), name FROM videos WHERE BIN_TO_UUID(multimedia_entity_id) = 'f6244906-5528-439b-bc2b-cccc61b30c8c';












