DELETE FROM order_line;
DELETE FROM `order`;
DELETE FROM card;
DELETE FROM address;
DELETE FROM contact;
DELETE FROM customer;
DELETE FROM country;
DELETE FROM status;
DELETE FROM product_image;
DELETE FROM product_material;
DELETE FROM product_category;
DELETE FROM product;
DELETE FROM category;
DELETE FROM material;
DELETE FROM image;
DELETE FROM admin;

INSERT INTO image (slug, name, path) VALUES 
('accessoires', 'Image d\'accessoires', 'accessoires.webp'),
('baskets-sportives-1', 'Image de basket sportive 1', 'baskets-sportives-1.webp'),
('baskets-sportives-2', 'Image de basket sportive 2' , 'baskets-sportives-2.webp'),
('bijoux', 'Image de bijoux', 'bijoux.webp'),
('blouse-florale-1', 'Image de blouse florale 1' , 'blouse-florale-1.webp'),
('blouse-florale-2', 'Image de blouse florale 2', 'blouse-florale-2.webp'),
('blouse-florale-3', 'Image de blouse florale 3', 'blouse-florale-3.webp'),
('casquette-tendance-1', 'Image de casquette tendance 1', 'casquette-tendance-1.webp'),
('casquette-tendance-2', 'Image de casquette tendance 2', 'casquette-tendance-2.webp'),
('ceinture-elegante-1', 'Image de ceinture élégante 1', 'ceinture-elegante-1.webp'),
('ceinture-elegante-2', 'Image de ceinture élégante 2', 'ceinture-elegante-2.webp'),
('ceinture-elegante-3', 'Image de ceinture élégante 3', 'ceinture-elegante-3.webp'),
('ceintures', 'Image de ceintures', 'ceintures.webp'),
('chapeau-de-soleil-1', 'Image de chapeau de soleil 1', 'chapeau-de-soleil-1.jpg'),
('chapeau-de-soleil-2', 'Image de chapeau de soleil 2', 'chapeau-de-soleil-2.jpg'),
('chaussettes-colorees-1', 'Image de chaussettes colorées 1', 'chaussettes-colorees-1.webp'),
('chaussures', 'Image de chaussures', 'chaussures.webp'),
('chemisiers', 'Image de chemisiers', 'chemisiers.webp'),
('collier-fantaisie-2', 'Image de collier fantaisie 2', 'collier-fantaisie-2.webp'),
('collier-fantaisie-1', 'Image de collier fantaisie 1', 'collier-fantaisie-1.webp'),
('escarpins-classiques-1', 'Image d\'escarpins classiques 1', 'escarpins-classiques-1.jpg'),
('escarpins-classiques-2', 'Image d\'escarpins classiques 2', 'escarpins-classiques-2.jpg'),
('escarpins-classiques-3', 'Image d\'escarpins classiques 3', 'escarpins-classiques-3.jpg'),
('jean-slim-1', 'Image de jean slim', 'jean-slim-1.webp'),
('jupes', 'Image de jupes', 'jupes.webp'),
('manteaux', 'Image de manteaux', 'manteaux.webp'),
('montre-elegante-1', 'Image de montre élégante 1', 'montre-elegante-1.webp'),
('pantalon-chic-1', 'Image de montre élégante 2', 'pantalon-chic-1.webp'),
('pantalons', 'Image de pantalons', 'pantalons.webp'),
('pulls', 'Image de pull', 'pulls.webp'),
('robe-elegante-1', 'Image de robe élégante 1', 'robe-elegante-1.jpg'),
('robe-elegante-2', 'Image de robe élégante 2', 'robe-elegante-2.jpg'),
('robe-elegante-3', 'Image de robe élégante 3', 'robe-elegante-3.jpg'),
('robes', 'Image de robes', 'robes.webp'),
('sac-a-main-chic-1', 'Image de sac à main chic 1' , 'sac-a-main-chic-1.jpg'),
('sac-a-main-chic-2', 'Image de sac à main chic 2' , 'sac-a-main-chic-2.jpg'),
('sac-a-main-chic-3', 'Image de sac à main chic 3' , 'sac-a-main-chic-3.jpg'),
('sac-a-main-chic-4', 'Image de sac à main chic 4' , 'sac-a-main-chic-4.jpg'),
('sacs', 'Image de sacs', 'sacs.webp'),
('sweat-a-capuche-1', 'Image de sweat à capcuche 1' , 'sweat-a-capuche-1.webp'),
('sweat-a-capuche-2', 'Image de sweat à capcuche 2' , 'sweat-a-capuche-2.webp'),
('sweat-a-capuche-3', 'Image de sweat à capcuche 3' , 'sweat-a-capuche-3.webp'),
('t-shirt-decontracte-1', 'Image de T-shirt décontracté 1' , 't-shirt-decontracte-1.webp'),
('t-shirt-decontracte-2', 'Image de T-shirt décontracté 2' , 't-shirt-decontracte-2.webp'),
('t-shirt-decontracte-3', 'Image de T-shirt décontracté 3' , 't-shirt-decontracte-3.webp'),
('veste-en-cuir-1', 'Image de veste en cuite 1' , 'veste-en-cuir-1.webp'),
('veste-en-cuir-2', 'Image de veste en cuite 2' , 'veste-en-cuir-2.webp'),
('veste-en-cuir-3', 'Image de veste en cuite 3' , 'veste-en-cuir-3.webp'),
('vestes', 'Image de vestes', 'vestes.webp'),
('vetements', 'Image de vetements', 'vetements.webp');

INSERT INTO material (slug, libelle, color) VALUES 
('cuir', 'Cuir', '#c31e1e'),
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
('accessoires', 'Accessoires', 'accessoires', 1, 3, '#7c2d96'),
('pantalons', 'Pantalons', 'pantalons', 0, 4, '#2d7c96'),
('jupes', 'Jupes', 'jupes', 0, 5, '#96322d'),
('robes', 'Robes', 'robes', 0, 6, '#99832d'),
('manteaux', 'Manteaux', 'manteaux', 0, 7, '#322d96'),
('chemisiers', 'Chemisiers', 'chemisiers', 0, 8, '#56854c'),
('pulls', 'Pulls', 'pulls', 0, 9, '#7c9632'),
('vestes', 'Vestes', 'vestes', 0, 10, '#32963d'),
('sacs', 'Sacs', 'sacs', 0, 11, '#96327b'),
('ceintures', 'Ceintures', 'ceintures', 0, 12, '#2d9696'),
('bijoux', 'Bijoux', 'bijoux', 0, 13, '#96327c');

INSERT INTO product (slug, name, description, is_highlander, price, stock_quantity) VALUES 
('robe-elegante', 'Robe élégante', 'Robe élégante pour toutes les occasions', 1, 59.99, 50),
('escarpins-classiques', 'Escarpins classiques', 'Chaussures élégantes pour femmes', 1, 39.99, 30),
('sac-a-main-chic', 'Sac à main chic', 'Accessoire parfait pour compléter votre look', 1, 29.99, 20),
('t-shirt-decontracte', 'T-shirt décontracté', 'T-shirt confortable pour un look décontracté', 1, 19.99, 40),
('jean-slim', 'Jean slim', 'Jean ajusté pour un style tendance', 1, 49.99, 25),
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
('robe-elegante', 'laine'),
('robe-elegante', 'polyester'),
('escarpins-classiques', 'cuir'),
('escarpins-classiques', 'polyester'),
('sac-a-main-chic', 'cuir'),
('sac-a-main-chic', 'polyester'),
('t-shirt-decontracte', 'coton'),
('t-shirt-decontracte', 'polyester'),
('jean-slim', 'denim'),
('jean-slim', 'polyester'),
('baskets-sportives', 'polyester'),
('baskets-sportives', 'nylon'),
('chapeau-de-soleil', 'polyester'),
('chapeau-de-soleil', 'nylon'),
('pantalon-chic', 'polyester'),
('pantalon-chic', 'viscose'),
('collier-fantaisie', 'lurex'),
('collier-fantaisie', 'nylon'),
('blouse-florale', 'polyester'),
('blouse-florale', 'viscose'),
('sweat-a-capuche', 'coton'),
('sweat-a-capuche', 'polyester'),
('chaussettes-colorees', 'coton'),
('chaussettes-colorees', 'elasthane'),
('ceinture-elegante', 'cuir'),
('ceinture-elegante', 'polyester'),
('casquette-tendance', 'polyester'),
('casquette-tendance', 'coton'),
('veste-en-cuir', 'cuir');

INSERT INTO product_category (product_slug, category_slug) VALUES 
('robe-elegante', 'robes'),
('robe-elegante', 'vetements'),
('escarpins-classiques', 'chaussures'),
('escarpins-classiques', 'vetements'),
('sac-a-main-chic', 'sacs'),
('sac-a-main-chic', 'accessoires'),
('t-shirt-decontracte', 'vetements'),
('jean-slim', 'pantalons'),
('jean-slim', 'vetements'),
('baskets-sportives', 'chaussures'),
('baskets-sportives', 'vetements'),
('montre-elegante', 'accessoires'),
('montre-elegante', 'vetements'),
('chapeau-de-soleil', 'accessoires'),
('chapeau-de-soleil', 'vetements'),
('pantalon-chic', 'pantalons'),
('pantalon-chic', 'vetements'),
('collier-fantaisie', 'bijoux'),
('collier-fantaisie', 'accessoires'),
('blouse-florale', 'chemisiers'),
('blouse-florale', 'vetements'),
('sweat-a-capuche', 'pulls'),
('sweat-a-capuche', 'vetements'),
('chaussettes-colorees', 'accessoires'),
('chaussettes-colorees', 'vetements'),
('ceinture-elegante', 'accessoires'),
('ceinture-elegante', 'vetements'),
('casquette-tendance', 'accessoires'),
('casquette-tendance', 'vetements'),
('veste-en-cuir', 'vestes'),
('veste-en-cuir', 'vetements');

INSERT INTO product_image (product_slug, image_slug) VALUES 
('baskets-sportives', 'baskets-sportives-1'),
('baskets-sportives', 'baskets-sportives-2'),
('blouse-florale', 'blouse-florale-1'),
('blouse-florale', 'blouse-florale-2'),
('blouse-florale', 'blouse-florale-3'),
('casquette-tendance', 'casquette-tendance-1'),
('casquette-tendance', 'casquette-tendance-2'),
('ceinture-elegante', 'ceinture-elegante-1'),
('ceinture-elegante', 'ceinture-elegante-2'),
('ceinture-elegante', 'ceinture-elegante-3'),
('chapeau-de-soleil', 'chapeau-de-soleil-1'),
('chapeau-de-soleil', 'chapeau-de-soleil-2'),
('chaussettes-colorees', 'chaussettes-colorees-1'),
('collier-fantaisie', 'collier-fantaisie-2'),
('collier-fantaisie', 'collier-fantaisie-1'),
('escarpins-classiques', 'escarpins-classiques-1'),
('escarpins-classiques', 'escarpins-classiques-2'),
('escarpins-classiques', 'escarpins-classiques-3'),
('jean-slim', 'jean-slim-1'),
('montre-elegante', 'montre-elegante-1'),
('pantalon-chic', 'pantalon-chic-1'),
('robe-elegante', 'robe-elegante-1'),
('robe-elegante', 'robe-elegante-2'),
('robe-elegante', 'robe-elegante-3'),
('sac-a-main-chic', 'sac-a-main-chic-1'),
('sac-a-main-chic', 'sac-a-main-chic-2'),
('sac-a-main-chic', 'sac-a-main-chic-3'),
('sac-a-main-chic', 'sac-a-main-chic-4'),
('sweat-a-capuche', 'sweat-a-capuche-1'),
('sweat-a-capuche', 'sweat-a-capuche-2'),
('sweat-a-capuche', 'sweat-a-capuche-3'),
('t-shirt-decontracte', 't-shirt-decontracte-1'),
('t-shirt-decontracte', 't-shirt-decontracte-2'),
('t-shirt-decontracte', 't-shirt-decontracte-3'),
('veste-en-cuir', 'veste-en-cuir-1'),
('veste-en-cuir', 'veste-en-cuir-2'),
('veste-en-cuir', 'veste-en-cuir-3');

INSERT INTO country (country_id, name) VALUES 
(1, 'France'),
(2, 'Belgique'),
(3, 'Canada');

INSERT INTO customer (customer_id, first_name, last_name, email, has_validated_email, password) VALUES 
(1, 'Alice', 'Dupont', 'alice@example.com', 1, '$2y$10$yxWRNu3JLaIUkhwD9kngPuYF0jnwNEjEM2ajPbaKRP.Q76A73ApMe'), -- MPD: motDeP@sseT3st
(2, 'Jean', 'Martin', 'jean@example.com', 1, '$2y$10$yxWRNu3JLaIUkhwD9kngPuYF0jnwNEjEM2ajPbaKRP.Q76A73ApMe'), -- MPD: motDeP@sseT3st
(3, 'Sophie', 'Lefevre', 'sophie@example.com', 1, '$2y$10$yxWRNu3JLaIUkhwD9kngPuYF0jnwNEjEM2ajPbaKRP.Q76A73ApMe'); -- MPD: motDeP@sseT3st

INSERT INTO address (address_id, customer_id, first_name, last_name, address1, city, postal_code, country_id, tel) VALUES 
(1, 1, 'Alice', 'Dupont', '123 Rue de la Mode', 'Paris', 75001, 1, '0123456789'),
(2, 2, 'Jean', 'Martin', '456 Avenue Chic', 'Bruxelles', 1000, 2, '0456789123'),
(3, 3, 'Sophie', 'Lefevre', '789 Rue Stylée', 'Montréal', 1000, 3, '0789012345');

INSERT INTO card (card_id, customer_id, number, expiration_date, cvv, first_name, last_name) VALUES 
(1, 1, 1234567890123456, '2025-12-31', 123, 'Alice', 'Dupont'),
(2, 2, 2345678901234567, '2024-10-31', 456, 'Jean', 'Martin'),
(3, 3, 3456789012345678, '2023-08-31', 789, 'Sophie', 'Lefevre');

INSERT INTO status (status_id, libelle, sort_order) VALUES 
(1, 'En cours de traitement', 1),
(2, 'Expédiée', 2),
(3, 'Livrée', 3),
(4, 'Annulée', 4);

INSERT INTO `order` (order_id, customer_id, card_id, order_date, total_amount, status_id, shipping_address_id, billing_address_id) VALUES 
(1, 1, 1, '2024-01-13 12:30:00', 89.99, 2, 1, 1),
(2, 2, 2, '2024-01-13 14:45:00', 39.99, 1, 2, 2),
(3, 3, 3, '2024-01-10 10:15:00', 29.99, 3, 3, 3),
(4, 1, 1, '2024-01-10 10:15:00', 59.99, 1, 1, 1),
(5, 2, 2, '2024-01-10 10:15:00', 39.99, 2, 2, 2),
(6, 3, 3, '2024-01-10 10:15:00', 29.99, 3, 3, 3),
(7, 1, 1, '2024-01-10 10:15:00', 59.99, 1, 1, 1),
(8, 2, 2, '2024-01-10 10:15:00', 39.99, 2, 2, 2),
(9, 3, 3, '2024-01-10 10:15:00', 29.99, 3, 3, 3),
(10, 1, 1, '2024-01-11 09:00:00', 59.99, 1, 1, 1),
(11, 2, 2, '2024-01-11 14:00:00', 39.99, 2, 2, 2),
(12, 3, 3, '2024-01-11 07:30:00', 29.99, 3, 3, 3),
(13, 1, 1, '2024-01-11 08:00:00', 59.99, 1, 1, 1),
(14, 2, 2, '2024-01-11 13:00:00', 39.99, 2, 2, 2),
(15, 3, 3, '2024-01-11 06:30:00', 29.99, 3, 3, 3),
(16, 1, 1, '2024-01-12 07:00:00', 59.99, 1, 1, 1),
(17, 2, 2, '2024-01-12 12:00:00', 39.99, 2, 2, 2),
(18, 3, 3, '2024-01-12 05:30:00', 29.99, 3, 3, 3),
(19, 1, 1, '2024-01-12 06:00:00', 59.99, 1, 1, 1),
(20, 2, 2, '2024-01-12 11:00:00', 39.99, 2, 2, 2),
(21, 3, 3, '2024-01-12 04:30:00', 29.99, 3, 3, 3),
(22, 1, 1, '2024-01-13 05:00:00', 59.99, 1, 1, 1),
(23, 2, 2, '2024-01-13 10:00:00', 39.99, 2, 2, 2),
(24, 3, 3, '2024-01-13 03:30:00', 29.99, 3, 3, 3),
(25, 1, 1, '2024-02-01 04:00:00', 59.99, 1, 1, 1),
(26, 2, 2, '2024-02-02 09:00:00', 39.99, 2, 2, 2),
(27, 3, 3, '2024-02-03 02:30:00', 29.99, 3, 3, 3),
(28, 1, 1, '2024-02-04 03:00:00', 59.99, 1, 1, 1),
(29, 2, 2, '2024-02-05 08:00:00', 39.99, 2, 2, 2),
(30, 3, 3, '2024-02-06 01:30:00', 29.99, 3, 3, 3);

INSERT INTO order_line (order_id, product_slug, quantity, line_price) VALUES 
(1, 'robe-elegante', 2, 59.99),
(2, 'escarpins-classiques', 1, 39.99),
(2, 'veste-en-cuir', 1, 89.99),
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