-- Create user
DROP USER IF EXISTS 'new-vet-user'@'localhost';
CREATE USER 'new-vet-user'@'localhost' IDENTIFIED BY 'w11xBg50G2t4YtC1BlbQ';

-- Grant privileges
GRANT SELECT ON new-vet.category TO 'new-vet-user'@'localhost';
GRANT INSERT ON new-vet.category TO 'new-vet-user'@'localhost';
GRANT UPDATE ON new-vet.category TO 'new-vet-user'@'localhost';
GRANT DELETE ON new-vet.category TO 'new-vet-user'@'localhost';

GRANT SELECT ON new-vet.product TO 'new-vet-user'@'localhost';
GRANT INSERT ON new-vet.product TO 'new-vet-user'@'localhost';
GRANT UPDATE ON new-vet.product TO 'new-vet-user'@'localhost';
GRANT DELETE ON new-vet.product TO 'new-vet-user'@'localhost';

GRANT SELECT ON new-vet.image TO 'new-vet-user'@'localhost';
GRANT INSERT ON new-vet.image TO 'new-vet-user'@'localhost';
GRANT UPDATE ON new-vet.image TO 'new-vet-user'@'localhost';
GRANT DELETE ON new-vet.image TO 'new-vet-user'@'localhost';

GRANT SELECT ON new-vet.country TO 'new-vet-user'@'localhost';
GRANT INSERT ON new-vet.country TO 'new-vet-user'@'localhost';
GRANT UPDATE ON new-vet.country TO 'new-vet-user'@'localhost';
GRANT DELETE ON new-vet.country TO 'new-vet-user'@'localhost';

GRANT SELECT ON new-vet.customer TO 'new-vet-user'@'localhost';
GRANT INSERT ON new-vet.customer TO 'new-vet-user'@'localhost';
GRANT UPDATE ON new-vet.customer TO 'new-vet-user'@'localhost';
GRANT DELETE ON new-vet.customer TO 'new-vet-user'@'localhost';

GRANT SELECT ON new-vet.address TO 'new-vet-user'@'localhost';
GRANT INSERT ON new-vet.address TO 'new-vet-user'@'localhost';
GRANT UPDATE ON new-vet.address TO 'new-vet-user'@'localhost';
GRANT DELETE ON new-vet.address TO 'new-vet-user'@'localhost';

GRANT SELECT ON new-vet.card TO 'new-vet-user'@'localhost';
GRANT INSERT ON new-vet.card TO 'new-vet-user'@'localhost';
GRANT UPDATE ON new-vet.card TO 'new-vet-user'@'localhost';
GRANT DELETE ON new-vet.card TO 'new-vet-user'@'localhost';

GRANT SELECT ON new-vet.status TO 'new-vet-user'@'localhost';
GRANT INSERT ON new-vet.status TO 'new-vet-user'@'localhost';
GRANT UPDATE ON new-vet.status TO 'new-vet-user'@'localhost';
GRANT DELETE ON new-vet.status TO 'new-vet-user'@'localhost';

GRANT SELECT ON new-vet.order TO 'new-vet-user'@'localhost';
GRANT INSERT ON new-vet.order TO 'new-vet-user'@'localhost';
GRANT UPDATE ON new-vet.order TO 'new-vet-user'@'localhost';
GRANT DELETE ON new-vet.order TO 'new-vet-user'@'localhost';

GRANT SELECT ON new-vet.order_product TO 'new-vet-user'@'localhost';
GRANT INSERT ON new-vet.order_product TO 'new-vet-user'@'localhost';
GRANT UPDATE ON new-vet.order_product TO 'new-vet-user'@'localhost';
GRANT DELETE ON new-vet.order_product TO 'new-vet-user'@'localhost';

GRANT SELECT ON new-vet.contact TO 'new-vet-user'@'localhost';
GRANT INSERT ON new-vet.contact TO 'new-vet-user'@'localhost';
GRANT UPDATE ON new-vet.contact TO 'new-vet-user'@'localhost';
GRANT DELETE ON new-vet.contact TO 'new-vet-user'@'localhost';