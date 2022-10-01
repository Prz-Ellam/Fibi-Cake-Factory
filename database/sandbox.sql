USE cake_factory;

INSERT INTO users(email, username, user_role, birth_date, first_name, last_name, password, 
gender, profile_picture)
VALUES ('a@a.com', 'admin', 1, CURDATE(), 'elrod', 'perez', '123', 1, 1);


SELECT BIN_TO_UUID(user_id), email FROM users;

SELECT BIN_TO_UUID(shopping_cart_item_id), BIN_TO_UUID(product_id) FROM shopping_cart_items;


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

DELETE FROM users WHERE BIN_TO_UUID(user_id) = '66d64531-7a6f-4ec2-a12b-0acd9d4670de';

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


SELECT *, BIN_TO_UUID(user_id) user_id FROM users;
'516a3887-06b1-4203-ad59-07dc13d1e0fe' -- user 1
'b6cc9bbd-fbb2-4935-bb29-b3c0e40ca7bb' -- user 2

SELECT * FROM chat_participants WHERE BIN_TO_UUID(chat_id) =
'c332f2ed-3edf-11ed-8be6-6018950ce9af' -- chat id



SELECT *, BIN_TO_UUID(chat_id) chat_id FROM chats;

SELECT *, BIN_TO_UUID(chat_participant_id) chat_participant_id FROM chat_participants;

SELECT *, BIN_TO_UUID(chat_message_id) chat_message_id,
BIN_TO_UUID(chat_participant_id) chat_participant_id
FROM chat_messages;


CALL sp_create_chat(UUID());

CALL sp_create_chat_participant(UUID(), '5b65138e-4082-11ed-972c-6018950ce9af', '95ee300d-6466-4f43-86fd-35c2737da7f8');
CALL sp_create_chat_participant(UUID(), '5b65138e-4082-11ed-972c-6018950ce9af', '76dd9897-f26a-44d5-852c-9f7c0f3f0c90');


CALL sp_create_chat_message(UUID(), '6f8a6e76-3ee0-11ed-8be6-6018950ce9af', 'Hola como estas');
CALL sp_create_chat_message(UUID(), '72ba36bd-3ee0-11ed-8be6-6018950ce9af', 'Hola muy bien, y tu?');


CALL sp_get_messages_from_chat('c332f2ed-3edf-11ed-8be6-6018950ce9af');



SELECT
    BIN_TO_UUID(c.chat_id) id,
    COUNT(BIN_TO_UUID(cp.chat_participant_id))
    --SUM(BIN_TO_UUID(cp.chat_participant_id)) participant_id
FROM
    chats AS c
INNER JOIN
    chat_participants AS cp
ON
    c.chat_id = cp.chat_id
GROUP BY
    c.chat_id
HAVING
    COUNT(BIN_TO_UUID(cp.chat_participant_id)) > 1;

WHERE
    BIN_TO_UUID(cp.user_id) = '516a3887-06b1-4203-ad59-07dc13d1e0fe'
    OR BIN_TO_UUID(cp.user_id) = 'b6cc9bbd-fbb2-4935-bb29-b3c0e40ca7bb';


-- Checa si dos usuarios ya tienen un chat
SELECT
    --BIN_TO_UUID(c.chat_id) id,
    COUNT(BIN_TO_UUID(cp.chat_participant_id)) = 2 AS `exists`
FROM
    chats AS c
INNER JOIN
    chat_participants AS cp
ON
    c.chat_id = cp.chat_id
WHERE
    --BIN_TO_UUID(c.chat_id) = 'c332f2ed-3edf-11ed-8be6-6018950ce9af'
    BIN_TO_UUID(cp.user_id) = '95ee300d-6466-4f43-86fd-35c2737da7f8'
    OR BIN_TO_UUID(cp.user_id) = '76dd9897-f26a-44d5-852c-9f7c0f3f0c90'
GROUP BY
    c.chat_id
HAVING
    COUNT(BIN_TO_UUID(cp.chat_participant_id)) = 2;


'95ee300d-6466-4f43-86fd-35c2737da7f8'
'76dd9897-f26a-44d5-852c-9f7c0f3f0c90'



SELECT * FROM users;
SELECT * FROM user_roles;


SELECT * FROM orders;



SELECT * FROM wishlists;



SELECT * FROM vw_orders_report;


-- TODO: Tal vez el categorias deberia tener un unique en nombre?

SELECT 
    s.created_at `date`,
    GROUP_CONCAT(DISTINCT c.name) `categories`,
    p.name `productName`,
    IFNULL(ROUND(AVG(r.rate), 2), 'No reviews') `rate`,
    s.amount / s.quantity `price`,
    BIN_TO_UUID(o.user_id) `user`
FROM
    shoppings AS s
INNER JOIN
    orders AS o
ON
    BIN_TO_UUID(s.order_id) = BIN_TO_UUID(o.order_id)
INNER JOIN 
    products AS p 
ON 
    BIN_TO_UUID(s.product_id) = BIN_TO_UUID(p.product_id)
INNER JOIN 
    products_categories AS pc
ON 
    BIN_TO_UUID(s.product_id) = BIN_TO_UUID(pc.product_id)
INNER JOIN 
    categories AS c
ON 
    BIN_TO_UUID(pc.category_id) = BIN_TO_UUID(c.category_id)
LEFT JOIN
    reviews AS r
ON
    BIN_TO_UUID(s.product_id) = BIN_TO_UUID(r.product_id)
GROUP BY
    s.created_at,
    s.amount,
    s.quantity,
    p.name;



SELECT * FROM wishlists;