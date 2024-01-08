INSERT INTO category ('name', 'color', 'image_path', 'order') VALUES 
('Vêtements', '#FF5733', '/images/clothing.jpg', 1),
('Chaussures', '#009688', '/images/shoes.jpg', 2),
('Accessoires', '#FFC107', '/images/accessories.jpg', 3);

INSERT INTO product ('name', 'description', 'category_id', 'is_highlander', 'price', 'stock_quantity') VALUES 
('Robe élégante', 'Robe élégante pour toutes les occasions', 1, 0, 59.99, 50),
('Escarpins classiques', 'Chaussures élégantes pour femmes', 2, 0, 39.99, 30),
('Sac à main chic', 'Accessoire parfait pour compléter votre look', 3, 0, 29.99, 20);

INSERT INTO product_image ('product_id', 'image_path') VALUES 
(1, '/images/dress.jpg'),
(2, '/images/shoes.jpg'),
(3, '/images/handbag.jpg');

INSERT INTO country ('name') VALUES 
('France'),
('Belgique'),
('Canada');

INSERT INTO customer ('first_name', 'last_name', 'email', 'has_validated_email', password) VALUES 
('Alice', 'Dupont', 'alice@example.com', 1, 'motdepasse123'),
('Jean', 'Martin', 'jean@example.com', 1, 'mdp123456'),
('Sophie', 'Lefevre', 'sophie@example.com', 1, 'password789');

INSERT INTO address ('customer_id', 'first_name', 'last_name', 'address1', 'city', 'postal_code', 'country', 'tel') VALUES 
(1, 'Alice', 'Dupont', '123 Rue de la Mode', 'Paris', 75001, 1, '0123456789'),
(2, 'Jean', 'Martin', '456 Avenue Chic', 'Bruxelles', 1000, 2, '0456789123'),
(3, 'Sophie', 'Lefevre', '789 Rue Stylée', 'Montréal', 'H2X 1X9', 3, '0789012345');

INSERT INTO card ('customer_id', 'number', 'expiration_date', cvv) VALUES 
(1, 1234567890123456, '2025-12-31', 123),
(2, 2345678901234567, '2024-10-31', 456),
(3, 3456789012345678, '2023-08-31', 789);

INSERT INTO status ('libelle') VALUES 
('En cours de traitement'),
('Expédiée'),
('Livrée');

INSERT INTO `order` ('customer_id', 'order_date', 'total_amount', 'status_id') VALUES 
(1, '2024-01-08 12:30:00', 89.99, 2),
(2, '2024-01-09 14:45:00', 39.99, 1),
(3, '2024-01-10 10:15:00', 29.99, 3);

INSERT INTO order_product ('order_id', 'product_id', 'quantity', 'item_price') VALUES 
(1, 1, 2, 59.99),
(2, 2, 1, 39.99),
(3, 3, 1, 29.99);

INSERT INTO contact ('customer_id', 'email', 'subject', 'message') VALUES 
(1, 'alice@example.com', 'Question sur ma commande', 'Bonjour, j\'aurais une question concernant ma commande.'),
(2, 'jean@example.com', 'Problème avec un produit', 'Bonjour, j\'ai rencontré un problème avec le produit que j\'ai reçu.'),
(3, 'sophie@example.com', 'Feedback positif', 'Bonjour, je voulais vous faire part de ma satisfaction concernant ma dernière commande. Merci!');