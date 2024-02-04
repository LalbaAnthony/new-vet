DELETE FROM contact;
DELETE FROM order_product;
DELETE FROM `order`;
DELETE FROM status;
DELETE FROM card;
DELETE FROM address;
DELETE FROM customer;
DELETE FROM country;
DELETE FROM image;
DELETE FROM product;
DELETE FROM category;
DELETE FROM material;
DELETE FROM product_category;
DELETE FROM product_material;
DELETE FROM admin;

INSERT INTO material (slug, libelle, color) VALUES 
('cuire', 'Cuire', '#227553');

INSERT INTO category (slug, libelle, image_path, sort_order, color) VALUES 
('vetements', 'Vêtements', 'uploads/categories/vetements.webp', 1, '#32a852'),
('chaussures', 'Chaussures', 'uploads/categories/chaussures.webp', 2, '#7ba832'),
('accessoires', 'Accessoires', 'uploads/categories/accessoires.webp', 3, '#7c2d96');

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
('chaussettes-colorées', 'Chaussettes colorées', 'Chaussettes amusantes pour égayer votre tenue', 0, 9.99, 50),
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
('veste-en-cuir', 'vetements');

INSERT INTO image (product_slug, image_path, sort_order) VALUES 
('robe-elegante', 'uploads/products/robe-elegante-1.jpg', 1),
('robe-elegante', 'uploads/products/robe-elegante-2.jpg', 2),
('robe-elegante', 'uploads/products/robe-elegante-3.jpg', 3),
('robe-elegante', 'uploads/products/robe-elegante-4.jpg', 4),
('escarpins-classiques', 'uploads/products/escarpins-classiques-1.jpg', 1),
('escarpins-classiques', 'uploads/products/escarpins-classiques-2.jpg', 2),
('sac-a-main-chic', 'uploads/products/sac-a-main-chic-1.jpg', 1),
('sac-a-main-chic', 'uploads/products/sac-a-main-chic-2.jpg', 2),
('t-shirt-decontracte', 'uploads/products/t-shirt-decontracte-1.jpg', 1),
('t-shirt-decontracte', 'uploads/products/t-shirt-decontracte-2.jpg', 2),
('jean-slim', 'uploads/products/jean-slim-1.jpg', 1),
('jean-slim', 'uploads/products/jean-slim-2.jpg', 2),
('baskets-sportives', 'uploads/products/baskets-sportives-1.jpg', 1),
('baskets-sportives', 'uploads/products/baskets-sportives-2.jpg', 2),
('montre-elegante', 'uploads/products/montre-elegante-1.jpg', 1),
('montre-elegante', 'uploads/products/montre-elegante-2.jpg', 2),
('chapeau-de-soleil', 'uploads/products/chapeau-de-soleil-1.jpg', 1),
('chapeau-de-soleil', 'uploads/products/chapeau-de-soleil-2.jpg', 2),
('pantalon-chic', 'uploads/products/pantalon-chic-1.jpg', 1),
('pantalon-chic', 'uploads/products/pantalon-chic-2.jpg', 2),
('collier-fantaisie', 'uploads/products/collier-fantaisie-1.jpg', 1),
('collier-fantaisie', 'uploads/products/collier-fantaisie-2.jpg', 2),
('blouse-florale', 'uploads/products/blouse-florale-1.jpg', 1),
('blouse-florale', 'uploads/products/blouse-florale-2.jpg', 2),
('sweat-a-capuche', 'uploads/products/sweat-a-capuche-1.jpg', 1),
('sweat-a-capuche', 'uploads/products/sweat-a-capuche-2.jpg', 2);

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
(1, 1, 1, '2024-01-08 12:30:00', 89.99, 2),
(2, 2, 2, '2024-01-09 14:45:00', 39.99, 1),
(3, 3, 3, '2024-01-10 10:15:00', 29.99, 3);

INSERT INTO order_product (order_id, product_slug, quantity, item_price) VALUES 
(1, 'robe-elegante', 2, 59.99),
(2, 'escarpins-classiques', 1, 39.99),
(3, 'sac-a-main-chic', 1, 29.99);

INSERT INTO contact (customer_id, email, subject, message) VALUES 
(1, 'alice@example.com', 'Question sur ma commande', 'Bonjour, j\'aurais une question concernant ma commande.'),
(2, 'jean@example.com', 'Problème avec un produit', 'Bonjour, j\'ai rencontré un problème avec le produit que j\'ai reçu.'),
(3, 'sophie@example.com', 'Feedback positif', 'Bonjour, je voulais vous faire part de ma satisfaction concernant ma dernière commande. Merci!');

INSERT INTO admin (login, password, has_access) VALUES 
('testAdmin', '$2y$10$Avrn4BLpK9fZfe5UfxLqve5nb3NdTZ9KV88LE.MHgnTBm.bHRKGl6', 1);