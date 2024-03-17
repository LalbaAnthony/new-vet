DELETE FROM contact;

DELETE FROM order_product;

DELETE FROM `order`;

DELETE FROM status;

DELETE FROM card;

DELETE FROM address;

DELETE FROM customer;

DELETE FROM country;

DELETE FROM product_category;

DELETE FROM product_material;

DELETE FROM product_image;

DELETE FROM image;

DELETE FROM product;

DELETE FROM category;

DELETE FROM material;

DELETE FROM admin;

INSERT INTO image (slug, name, path) VALUES 
('robe-elegante-1', 'Image de robe élégante', 'robe-elegante-1.jpg'),
('robe-elegante-2', 'Image de robe élégante', 'robe-elegante-2.jpg'),
('robe-elegante-3', 'Image de robe élégante', 'robe-elegante-3.jpg'),
('robe-elegante-4', 'Image de robe élégante', 'robe-elegante-4.jpg'),
('accessoires', 'Image Accessoire', 'accessoires.webp'),
('chaussures', 'Image Chaussures', 'chaussures.webp'),
('vetements', 'Image Vêtements', 'vetements.webp');

INSERT INTO material (slug, libelle, color) VALUES 
('cuire', 'Cuire', '#c31e1e'),
('coton', 'Coton', '#187dab'),
('laine', 'Laine', '#6b4522'),
('soie', 'Soie', '#ad6b95'),
('denim', 'Denim', '#2b4f6d'),
('polyester', 'Polyester', '#836bb0'),
('elasthane', 'Elasthane', '#b04782'),
('lurex', 'Lurex', '#b09833'),
('viscose', 'Viscose', '#8b9937'),
('nylon', 'Nylon', '#375b99'),
('lacet', 'Lacet', '#b05b2d'),
('lin', 'Lin', '#637c46');

INSERT INTO category (slug, libelle, image_slug, is_highlander, sort_order, color) VALUES 
('vetements', 'Vêtements', 'vetements', 1, 1, '#32a852'),
('chaussures', 'Chaussures', 'chaussures', 1, 2, '#7ba832'),
('accessoires', 'Accessoires', 'accessoires', 0, 3, '#7c2d96'),
('pantalons', 'Pantalons', NULL, 0, 4, '#2d7c96'),
('jupes', 'Jupes', NULL, 0, 5, '#96322d'),
('robes', 'Robes', NULL, 0, 6, '#99832d'),
('manteaux', 'Manteaux', NULL, 0, 7, '#322d96'),
('chemisiers', 'Chemisiers', NULL, 0, 8, '#56854c'),
('pulls', 'Pulls', NULL, 0, 9, '#7c9632'),
('vestes', 'Vestes', NULL, 0, 10, '#32963d'),
('sacs', 'Sacs', NULL, 0, 11, '#96327b'),
('ceintures', 'Ceintures', NULL, 0, 12, '#2d9696'),
('bijoux', 'Bijoux', NULL, 0, 13, '#96327c');

INSERT INTO product (slug, name, description, is_highlander, price, stock_quantity) VALUES 
('robe-elegante', 'Robe élégante', 'Robe élégante pour toutes les occasions', 1, 59.99, 50),
('escarpins-classiques', 'Escarpins classiques', 'Chaussures élégantes pour femmes', 0, 39.99, 30),
('sac-a-main-chic', 'Sac à main chic', 'Accessoire parfait pour compléter votre look', 0, 29.99, 20),
('t-shirt-decontracte', 'T-shirt décontracté', 'T-shirt confortable pour un look décontracté', 0, 19.99, 40),
('jean-slim', 'Jean slim', 'Jean ajusté pour un style tendance', 0, 49.99, 25),
('baskets-sportives', 'Baskets sportives', 'Chaussures idéales pour une activité sportive', 0, 59.99, 35),
('montre-elegante', 'Montre élégante', 'Accessoire raffiné pour ajouter une touche de classe', 0, 79.99, 15),
('chapeau-de-soleil', 'Chapeau de soleil', 'Chapeau élégant pour se protéger du soleil', 0, 24.99, 18),
('pantalon-chic', 'Pantalon chic', 'Pantalon élégant pour une tenue sophistiquée', 0, 54.99, 28),
('collier-fantaisie', 'Collier fantaisie', 'Collier original pour sublimer votre cou', 0, 29.99, 22),
('blouse-florale', 'Blouse florale', 'Blouse légère et féminine avec motif floral', 0, 44.99, 32),
('sweat-a-capuche', 'Sweat à capuche', 'Sweat confortable et stylé pour les journées fraîches', 0, 39.99, 27),
('chaussettes-colorees', 'Chaussettes colorées', 'Chaussettes amusantes pour égayer votre tenue', 0, 9.99, 50),
('ceinture-elegante', 'Ceinture élégante', 'Ceinture pour mettre en valeur votre taille', 0, 19.99, 15),
('casquette-tendance', 'Casquette tendance', 'Casquette stylée pour compléter votre look décontracté', 0, 14.99, 25),
('veste-en-cuir', 'Veste en cuir', 'Veste élégante pour une allure moderne', 0, 89.99, 10);

INSERT INTO product_material (product_slug, material_slug) VALUES 
('sac-a-main-chic', 'cuire'),
('escarpins-classiques', 'cuire'),
('veste-en-cuir', 'cuire');

INSERT INTO product_category (product_slug, category_slug) VALUES 
('robe-elegante', 'vetements'),
('escarpins-classiques', 'chaussures'),
('sac-a-main-chic', 'accessoires'),
('t-shirt-decontracte', 'vetements'),
('jean-slim', 'vetements'),
('baskets-sportives', 'chaussures'),
('montre-elegante', 'accessoires'),
('chapeau-de-soleil', 'accessoires'),
('pantalon-chic', 'vetements'),
('collier-fantaisie', 'accessoires'),
('blouse-florale', 'vetements'),
('sweat-a-capuche', 'vetements'),
('chaussettes-colorées', 'accessoires'),
('ceinture-elegante', 'accessoires'),
('casquette-tendance', 'accessoires'),
('veste-en-cuir', 'vetements'),
('veste-en-cuir', 'vestes');

INSERT INTO product_image (product_slug, image_slug) VALUES 
('robe-elegante', 'robe-elegante-1'),
('robe-elegante', 'robe-elegante-2'),
('robe-elegante', 'robe-elegante-3'),
('robe-elegante', 'robe-elegante-4');

INSERT INTO country (country_id, name) VALUES 
(1, 'France'),
(2, 'Belgique'),
(3, 'Canada');

INSERT INTO customer (customer_id, first_name, last_name, email, has_validated_email, country_id, password) VALUES 
(1, 'Alice', 'Dupont', 'alice@example.com', 1, 1, 'motdepasse123'),
(2, 'Jean', 'Martin', 'jean@example.com', 1, 2, 'mdp123456'),
(3, 'Sophie', 'Lefevre', 'sophie@example.com', 1, 3, 'password789');

INSERT INTO address (customer_id, first_name, last_name, address1, city, postal_code, country_id, tel) VALUES 
(1, 'Alice', 'Dupont', '123 Rue de la Mode', 'Paris', 75001, 1, '0123456789'),
(2, 'Jean', 'Martin', '456 Avenue Chic', 'Bruxelles', 1000, 2, '0456789123'),
(3, 'Sophie', 'Lefevre', '789 Rue Stylée', 'Montréal', 1000, 3, '0789012345');

INSERT INTO card (card_id, customer_id, number, expiration_date, cvv) VALUES 
(1, 1, 1234567890123456, '2025-12-31', 123),
(2, 2, 2345678901234567, '2024-10-31', 456),
(3, 3, 3456789012345678, '2023-08-31', 789);

INSERT INTO status (status_id, libelle) VALUES 
(1, 'En cours de traitement'),
(2, 'Expédiée'),
(3, 'Livrée');

INSERT INTO `order` (order_id, customer_id, card_id, order_date, total_amount, status_id) VALUES 
(1, 1, 1, '2024-01-13 12:30:00', 89.99, 2),
(2, 2, 2, '2024-01-13 14:45:00', 39.99, 1),
(3, 3, 3, '2024-01-10 10:15:00', 29.99, 3),
(4, 1, 1, '2024-01-10 10:15:00', 59.99, 1),
(5, 2, 2, '2024-01-10 10:15:00', 39.99, 2),
(6, 3, 3, '2024-01-10 10:15:00', 29.99, 3),
(7, 1, 1, '2024-01-10 10:15:00', 59.99, 1),
(8, 2, 2, '2024-01-10 10:15:00', 39.99, 2),
(9, 3, 3, '2024-01-10 10:15:00', 29.99, 3),
(10, 1, 1, '2024-01-11 09:00:00', 59.99, 1),
(11, 2, 2, '2024-01-11 14:00:00', 39.99, 2),
(12, 3, 3, '2024-01-11 07:30:00', 29.99, 3),
(13, 1, 1, '2024-01-11 08:00:00', 59.99, 1),
(14, 2, 2, '2024-01-11 13:00:00', 39.99, 2),
(15, 3, 3, '2024-01-11 06:30:00', 29.99, 3),
(16, 1, 1, '2024-01-12 07:00:00', 59.99, 1),
(17, 2, 2, '2024-01-12 12:00:00', 39.99, 2),
(18, 3, 3, '2024-01-12 05:30:00', 29.99, 3),
(19, 1, 1, '2024-01-12 06:00:00', 59.99, 1),
(20, 2, 2, '2024-01-12 11:00:00', 39.99, 2),
(21, 3, 3, '2024-01-12 04:30:00', 29.99, 3),
(22, 1, 1, '2024-01-13 05:00:00', 59.99, 1),
(23, 2, 2, '2024-01-13 10:00:00', 39.99, 2),
(24, 3, 3, '2024-01-13 03:30:00', 29.99, 3),
(25, 1, 1, '2024-02-01 04:00:00', 59.99, 1),
(26, 2, 2, '2024-02-02 09:00:00', 39.99, 2),
(27, 3, 3, '2024-02-03 02:30:00', 29.99, 3),
(28, 1, 1, '2024-02-04 03:00:00', 59.99, 1),
(29, 2, 2, '2024-02-05 08:00:00', 39.99, 2),
(30, 3, 3, '2024-02-06 01:30:00', 29.99, 3);

INSERT INTO order_product (order_id, product_slug, quantity, item_price) VALUES 
(1, 'robe-elegante', 2, 59.99),
(2, 'escarpins-classiques', 1, 39.99),
(3, 'sac-a-main-chic', 1, 29.99),
(4, 'robe-elegante', 1, 59.99),
(5, 'escarpins-classiques', 1, 39.99),
(6, 'sac-a-main-chic', 1, 29.99),
(7, 'robe-elegante', 1, 59.99),
(8, 'escarpins-classiques', 1, 39.99),
(9, 'sac-a-main-chic', 1, 29.99),
(10, 'robe-elegante', 1, 59.99),
(11, 'escarpins-classiques', 1, 39.99),
(12, 'sac-a-main-chic', 1, 29.99),
(13, 'robe-elegante', 1, 59.99),
(14, 'escarpins-classiques', 1, 39.99),
(15, 'sac-a-main-chic', 1, 29.99),
(16, 'robe-elegante', 1, 59.99),
(17, 'escarpins-classiques', 1, 39.99),
(18, 'sac-a-main-chic', 1, 29.99),
(19, 'robe-elegante', 1, 59.99),
(20, 'escarpins-classiques', 1, 39.99),
(21, 'sac-a-main-chic', 1, 29.99),
(22, 'robe-elegante', 1, 59.99),
(23, 'escarpins-classiques', 1, 39.99),
(24, 'sac-a-main-chic', 1, 29.99),
(25, 'robe-elegante', 1, 59.99),
(26, 'escarpins-classiques', 1, 39.99),
(27, 'sac-a-main-chic', 1, 29.99),
(28, 'robe-elegante', 1, 59.99),
(29, 'escarpins-classiques', 1, 39.99),
(30, 'sac-a-main-chic', 1, 29.99);

INSERT INTO contact (customer_id, email, subject, message) VALUES 
(1, 'alice@example.com', 'Question sur ma commande', 'Bonjour, j\'aurais une question concernant ma commande.'),
(2, 'jean@example.com', 'Problème avec un produit', 'Bonjour, j\'ai rencontré un problème avec le produit que j\'ai reçu.'),
(3, 'sophie@example.com', 'Feedback positif', 'Bonjour, je voulais vous faire part de ma satisfaction concernant ma dernière commande. Merci!');

INSERT INTO admin (login, password, has_access) VALUES 
('testAdmin', '$2y$10$Avrn4BLpK9fZfe5UfxLqve5nb3NdTZ9KV88LE.MHgnTBm.bHRKGl6', 1);