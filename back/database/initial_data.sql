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

INSERT INTO category (slug, libelle, image_path, sort_order) VALUES 
('vetements', 'Vêtements', '/assets/categories/vetements.jpg', 1),
('chaussures', 'Chaussures', '/assets/categories/chaussures.jpg', 2),
('accessoires', 'Accessoires', '/assets/categories/accessoires.jpg', 3);

INSERT INTO product (slug, name, description, category_slug, is_highlander, price, stock_quantity) VALUES 
('robe-elegante', 'Robe élégante', 'Robe élégante pour toutes les occasions', 'vetements', 1, 59.99, 50),
('escarpins-classiques', 'Escarpins classiques', 'Chaussures élégantes pour femmes', 'chaussures', 0, 39.99, 30),
('sac-a-main-chic', 'Sac à main chic', 'Accessoire parfait pour compléter votre look', 'accessoires', 0, 29.99, 20);

INSERT INTO image (product_slug, image_path) VALUES 
('robe-elegante', '/assets/products/dress.jpg'),
('escarpins-classiques', '/assets/products/shoes.jpg'),
('sac-a-main-chic', '/assets/products/handbag.jpg');

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