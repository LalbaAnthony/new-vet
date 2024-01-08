-- Create user

DROP USER IF EXISTS 'new-vet-user'@'localhost';
CREATE USER 'new-vet-user'@'localhost' IDENTIFIED BY 'w11xBg50G2t4YtC1BlbQ';

GRANT SELECT ON romainlamerde.produit TO 'new-vet-user'@'localhost';
GRANT INSERT ON romainlamerde.produit TO 'new-vet-user'@'localhost';
GRANT UPDATE ON romainlamerde.produit TO 'new-vet-user'@'localhost';
GRANT DELETE ON romainlamerde.produit TO 'new-vet-user'@'localhost';

-- ...