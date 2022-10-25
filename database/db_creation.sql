CREATE DATABASE IF NOT EXISTS cake_factory;

USE cake_factory;

-- Users
DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users(
    user_id                     BINARY(16) NOT NULL UNIQUE,
    email                       VARCHAR(255) NOT NULL UNIQUE,
    username                    VARCHAR(18) NOT NULL UNIQUE,
    first_name                  VARCHAR(50) NOT NULL,
    last_name                   VARCHAR(50) NOT NULL,
    birth_date                  DATE NOT NULL,
    password                    VARCHAR(255) NOT NULL,
    gender                      SMALLINT NOT NULL,
    visible                     BOOLEAN NOT NULL,
    user_role                   BINARY(16) NOT NULL,
    profile_picture             BINARY(16) NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP DEFAULT NOW(),
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT users_pk
        PRIMARY KEY (user_id)
);

DROP TABLE IF EXISTS user_roles;
-- User roles
CREATE TABLE IF NOT EXISTS user_roles(
    user_role_id                BINARY(16) NOT NULL UNIQUE,
    name                        VARCHAR(50) NOT NULL UNIQUE,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP,
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT user_roles_pk
        PRIMARY KEY (user_role_id)
);

-- Products
DROP TABLE IF EXISTS products;
CREATE TABLE IF NOT EXISTS products(
    product_id                  BINARY(16) NOT NULL UNIQUE,
    name                        VARCHAR(50) NOT NULL,
    description                 VARCHAR(200) NOT NULL,
    is_quotable                 BOOLEAN NOT NULL,
    price                       DECIMAL(15, 2),
    stock                       INT NOT NULL,
    user_id                     BINARY(16) NOT NULL,
    approved                    BOOLEAN NOT NULL DEFAULT FALSE,
    approved_by                 BINARY(16),
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP DEFAULT NOW(),
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT products_pk
        PRIMARY KEY (product_id)
);

-- Categories
DROP TABLE IF EXISTS categories;
CREATE TABLE IF NOT EXISTS categories(
    category_id                 BINARY(16) NOT NULL UNIQUE,
    name                        VARCHAR(50) NOT NULL,
    description                 VARCHAR(200),
    user_id                     BINARY(16) NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP,
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT categories_pk
        PRIMARY KEY (category_id)
);

-- Products Categories
DROP TABLE IF EXISTS products_categories;
CREATE TABLE IF NOT EXISTS products_categories(
    product_category_id         BINARY(16) NOT NULL UNIQUE,
    product_id                  BINARY(16) NOT NULL,
    category_id                 BINARY(16) NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP,
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT products_categories_pk
        PRIMARY KEY (product_category_id)
);

-- Comments
DROP TABLE IF EXISTS reviews;
CREATE TABLE IF NOT EXISTS reviews(
    review_id                   BINARY(16) NOT NULL UNIQUE,
    message                     VARCHAR(255) NOT NULL,
    rate                        SMALLINT,
    product_id                  BINARY(16) NOT NULL,
    user_id                     BINARY(16) NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP DEFAULT NOW(),
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT reviews_pk
        PRIMARY KEY (review_id)
);


-- DROP TABLE IF EXISTS comments;
-- CREATE TABLE IF NOT EXISTS comments(
--    comment_id                  BINARY(16) NOT NULL UNIQUE,
--    message                     VARCHAR(255) NOT NULL,
--    product_id                  BINARY(16) NOT NULL,
--    user_id                     BINARY(16) NOT NULL,
--    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
--    modified_at                 TIMESTAMP DEFAULT NOW(),
--    active                      BOOLEAN NOT NULL DEFAULT TRUE,
--    CONSTRAINT comments_pk
--        PRIMARY KEY (comment_id)
-- );

-- Rates
-- DROP TABLE IF EXISTS rates;
-- CREATE TABLE IF NOT EXISTS rates(
--    rate_id                     BINARY(16) NOT NULL UNIQUE,
--    rate                        SMALLINT NOT NULL,
--    product_id                  BINARY(16) NOT NULL,
--    user_id                     BINARY(16) NOT NULL,
--    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
--    modified_at                 TIMESTAMP,
--    active                      BOOLEAN NOT NULL DEFAULT TRUE,
--    CONSTRAINT rates_pk
--        PRIMARY KEY (rate_id)
-- );

-- Wishlists
DROP TABLE IF EXISTS wishlists;
CREATE TABLE IF NOT EXISTS wishlists(
    wishlist_id                 BINARY(16) NOT NULL UNIQUE,
    name                        VARCHAR(50) NOT NULL,
    description                 VARCHAR(200) NOT NULL,
    visible                     BOOLEAN NOT NULL,
    user_id                     BINARY(16) NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP,
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT wishlists_pk
        PRIMARY KEY (wishlist_id)
);

-- Wishlist Objects
DROP TABLE IF EXISTS wishlist_objects;
CREATE TABLE IF NOT EXISTS wishlist_objects(
    wishlist_object_id          BINARY(16) NOT NULL UNIQUE,
    product_id                  BINARY(16) NOT NULL,
    wishlist_id                 BINARY(16) NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP,
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT wishlist_objects_pk
        PRIMARY KEY (wishlist_object_id)
);

-- Shopping Cart
-- TODO: trigger para que solo un carrito tenga el cart_status TRUE
DROP TABLE IF EXISTS shopping_carts;
CREATE TABLE IF NOT EXISTS shopping_carts(
    shopping_cart_id            BINARY(16) NOT NULL UNIQUE,
    user_id                     BINARY(16) NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP,
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT shopping_carts_pk
        PRIMARY KEY (shopping_cart_id)
);

-- Shopping Cart Items
DROP TABLE IF EXISTS shopping_cart_items;
CREATE TABLE IF NOT EXISTS shopping_cart_items(
    shopping_cart_item_id       BINARY(16) NOT NULL UNIQUE,
    shopping_cart_id            BINARY(16) NOT NULL,
    product_id                  BINARY(16) NOT NULL,
    quantity                    SMALLINT NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP,
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT shopping_cart_items_pk
        PRIMARY KEY (shopping_cart_item_id)
);

-- Orders
DROP TABLE IF EXISTS orders;
CREATE TABLE IF NOT EXISTS orders(
    order_id                    BINARY(16) NOT NULL UNIQUE,    
    user_id                     BINARY(16) NOT NULL,
    phone                       VARCHAR(12) NOT NULL,
    address                     VARCHAR(100) NOT NULL,
    city                        VARCHAR(30) NOT NULL,
    state                       VARCHAR(30) NOT NULL,
    postal_code                 VARCHAR(30) NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP,
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT orders_pk
        PRIMARY KEY (order_id)
);

-- Shoppings
DROP TABLE IF EXISTS shoppings;
CREATE TABLE IF NOT EXISTS shoppings(
    shopping_id                 BINARY(16) NOT NULL UNIQUE,
    order_id                    BINARY(16) NOT NULL,
    product_id                  BINARY(16) NOT NULL,
    quantity                    SMALLINT NOT NULL,
    amount                      DECIMAL(15, 2) NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP,
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT shoppings_pk
        PRIMARY KEY (shopping_id)
);

-- Multimedia types
DROP TABLE IF EXISTS multimedia_types;
CREATE TABLE IF NOT EXISTS multimedia_types(
    multimedia_type_id          BINARY(16) NOT NULL UNIQUE,
    multimedia_type_name        VARCHAR(30) NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP,
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT multimedia_types_pk
        PRIMARY KEY (multimedia_type_id)
);

-- Multimedia entities
DROP TABLE IF EXISTS multimedia_entities;
CREATE TABLE IF NOT EXISTS multimedia_entities(
    multimedia_entity_id        BINARY(16) NOT NULL UNIQUE,
    entity_id                   INT NOT NULL,
    entity_type                 INT NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP,
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT multimedia_entities_pk
        PRIMARY KEY (multimedia_entity_id),
    CONSTRAINT multimedia_entity_unique
        UNIQUE (entity_id, entity_type)
);

-- Max de tamaño es 16MB pero solo admitiremos archivos de 8MB o menos, como discord
-- Images
DROP TABLE IF EXISTS images;
CREATE TABLE IF NOT EXISTS images(
    image_id                    BINARY(16) NOT NULL UNIQUE,
    name                        VARCHAR(255) NOT NULL,
    size                        BIGINT NOT NULL,
    content                     MEDIUMBLOB NOT NULL,
    type                        VARCHAR(30) NOT NULL,
    multimedia_entity_id        BINARY(16) NOT NULL,
    multimedia_entity_type      VARCHAR(50) NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP DEFAULT NOW(),
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT images_pk
        PRIMARY KEY (image_id)
);

-- Max de LONGBLOB es 4GB pero no aceptaron mucho tampoco, porque 4GB es demasiado
-- Videos
DROP TABLE IF EXISTS videos;
CREATE TABLE IF NOT EXISTS videos(
    video_id                    BINARY(16) NOT NULL UNIQUE,
    name                        VARCHAR(255) NOT NULL,
    size                        BIGINT NOT NULL,
    content                     LONGBLOB NOT NULL,
    type                        VARCHAR(30) NOT NULL,
    multimedia_entity_id        BINARY(16) NOT NULL,
    multimedia_entity_type      VARCHAR(50) NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP,
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT videos_pk
        PRIMARY KEY (video_id)
);

-- Chats
DROP TABLE IF EXISTS chats;
CREATE TABLE IF NOT EXISTS chats(
    chat_id                     BINARY(16) NOT NULL UNIQUE,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP DEFAULT NOW(),
    active                      BOOLEAN DEFAULT TRUE,
    CONSTRAINT chats_pk
        PRIMARY KEY (chat_id)
);

-- Chat Participants
DROP TABLE IF EXISTS chat_participants;
CREATE TABLE IF NOT EXISTS chat_participants(
    chat_participant_id         BINARY(16) NOT NULL UNIQUE,
    chat_id                     BINARY(16) NOT NULL,
    user_id                     BINARY(16) NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP DEFAULT NOW(),
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT chat_participants_pk
        PRIMARY KEY (chat_participant_id)
);

-- Chat Messages
DROP TABLE IF EXISTS chat_messages;
CREATE TABLE IF NOT EXISTS chat_messages(
    chat_message_id             BINARY(16) NOT NULL UNIQUE,
    chat_participant_id         BINARY(16) NOT NULL,
    message_content             VARCHAR(255) NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP DEFAULT NOW(),
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT chat_messages_pk
        PRIMARY KEY (chat_message_id)
);

-- Chat files
-- imagenes, videos, documentos, audios
DROP TABLE IF EXISTS chat_files;
CREATE TABLE IF NOT EXISTS chat_files(
    chat_file_id                BINARY(16) NOT NULL UNIQUE,
    chat_participant_id         BINARY(16) NOT NULL,
    file_content                MEDIUMBLOB NOT NULL,
    created_at                  TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at                 TIMESTAMP,
    active                      BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT chat_files_pk
        PRIMARY KEY (chat_file_id)
);



-- Foreign keys
ALTER TABLE users
    ADD CONSTRAINT users_user_roles_fk
        FOREIGN KEY (user_role)
        REFERENCES user_roles(user_role_id);

ALTER TABLE products
    ADD CONSTRAINT products_users_fk
        FOREIGN KEY (user_id)
        REFERENCES users(user_id);

ALTER TABLE products
    ADD CONSTRAINT products_approves_fk
        FOREIGN KEY (approved_by)
        REFERENCES users(user_id);

ALTER TABLE categories
    ADD CONSTRAINT categories_users_fk
        FOREIGN KEY (user_id)
        REFERENCES users(user_id);

ALTER TABLE products_categories
    ADD CONSTRAINT products_categories_products_fk
        FOREIGN KEY (product_id)
        REFERENCES products(product_id);

ALTER TABLE products_categories
    ADD CONSTRAINT products_categories_categories_fk
        FOREIGN KEY (category_id)
        REFERENCES categories(category_id);

ALTER TABLE orders
    ADD CONSTRAINT orders_users_fk
        FOREIGN KEY (user_id)
        REFERENCES users(user_id);

ALTER TABLE shoppings
    ADD CONSTRAINT shoppings_orders_fk
        FOREIGN KEY (order_id)
        REFERENCES orders(order_id);

ALTER TABLE shoppings
    ADD CONSTRAINT shoppings_products_fk
        FOREIGN KEY (product_id)
        REFERENCES products(product_id);

ALTER TABLE reviews
    ADD CONSTRAINT reviews_products_fk
        FOREIGN KEY (product_id)
        REFERENCES products(product_id);

ALTER TABLE reviews
    ADD CONSTRAINT reviews_users_fk
        FOREIGN KEY (user_id)
        REFERENCES users(user_id);

ALTER TABLE wishlists
    ADD CONSTRAINT wishlists_users_fk
        FOREIGN KEY (user_id)
        REFERENCES users(user_id);

ALTER TABLE wishlist_objects
    ADD CONSTRAINT wishlist_objects_products_fk
        FOREIGN KEY (product_id)
        REFERENCES products(product_id);

ALTER TABLE wishlist_objects
    ADD CONSTRAINT wishlist_objects_wishlists_fk
        FOREIGN KEY (wishlist_id)
        REFERENCES wishlists(wishlist_id);

ALTER TABLE shopping_carts
    ADD CONSTRAINT shopping_carts_users_fk
        FOREIGN KEY (user_id)
        REFERENCES users(user_id);

ALTER TABLE shopping_cart_items
    ADD CONSTRAINT shopping_cart_items_shopping_carts_fk
        FOREIGN KEY (shopping_cart_id)
        REFERENCES shopping_carts(shopping_cart_id);

ALTER TABLE shopping_cart_items
    ADD CONSTRAINT shopping_cart_items_products_fk
        FOREIGN KEY (product_id)
        REFERENCES products(product_id);

ALTER TABLE users
    ADD CONSTRAINT users_multimedia_entities_fk
        FOREIGN KEY (user_id, multimedia_type)
        REFERENCES multimedia_entities(entity_id, entity_type);

ALTER TABLE products
    ADD CONSTRAINT products_multimedia_entities_fk
        FOREIGN KEY (product_id, multimedia_type)
        REFERENCES multimedia_entities(entity_id, entity_type);

ALTER TABLE wishlists
    ADD CONSTRAINT wishlists_multimedia_entities_fk
        FOREIGN KEY (wishlist_id, multimedia_type)
        REFERENCES multimedia_entities(entity_id, entity_type);

ALTER TABLE images
    ADD CONSTRAINT images_multimedia_entities_fk
        FOREIGN KEY (multimedia_entity_id)
        REFERENCES multimedia_entities(entity_id);

ALTER TABLE videos
    ADD CONSTRAINT videos_multimedia_entities_fk
        FOREIGN KEY (multimedia_entity_id)
        REFERENCES multimedia_entities(entity_id);

ALTER TABLE chat_participants
    ADD CONSTRAINT chat_participants_chats_fk
        FOREIGN KEY (chat_id)
        REFERENCES chats(chat_id);

ALTER TABLE chat_participants
    ADD CONSTRAINT chat_participants_users_fk
        FOREIGN KEY (user_id)
        REFERENCES users(user_id);

ALTER TABLE chat_messages
    ADD CONSTRAINT chat_messages_chat_participants_fk
        FOREIGN KEY (chat_participant_id)
        REFERENCES chat_participants(chat_participant_id);

ALTER TABLE chat_files
    ADD CONSTRAINT chat_files_chat_participants_fk
        FOREIGN KEY (chat_participant_id)
        REFERENCES chat_participants(chat_participant_id);


-- https://mysql.tutorials24x7.com/blog/guide-to-design-database-for-shopping-cart-in-mysql
-- https://fabric.inc/blog/shopping-cart-database-design/
-- https://fabric.inc/blog/ecommerce-database-design-example/
