#------------------------------------------------------------
# Table: category
#------------------------------------------------------------

DROP TABLE IF EXISTS category;
CREATE TABLE category(
        category_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        name VARCHAR (50) NOT NULL,
        color VARCHAR (7) NOT NULL DEFAULT '#000000',
        image_path VARCHAR (250) UNIQUE,
        order INT UNIQUE,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT category_PK PRIMARY KEY (category_id)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: product
#------------------------------------------------------------

DROP TABLE IF EXISTS product;
CREATE TABLE product(
        product_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        name VARCHAR (50) NOT NULL,
        description VARCHAR (1000),
        category_id INT,
        is_highlander BOOLEAN NOT NULL DEFAULT 0,
        price FLOAT NOT NULL DEFAULT 0,
        stock_quantity INT NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT product_PK PRIMARY KEY (product_id)
        CONSTRAINT product_category_FK FOREIGN KEY (category_id) REFERENCES category(category_id)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: product_image
#------------------------------------------------------------

DROP TABLE IF EXISTS product_image;
CREATE TABLE product_image(
        product_image_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        product_id INT NOT NULL,
        image_path VARCHAR (250) NOT NULL,
        CONSTRAINT product_image_PK PRIMARY KEY (product_image_id)
        CONSTRAINT product_image_product_FK FOREIGN KEY (product_id) REFERENCES product(product_id)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: country
#------------------------------------------------------------

DROP TABLE IF EXISTS country;
CREATE TABLE country(
        country_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        name VARCHAR (50) NOT NULL,
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: customer
#------------------------------------------------------------

DROP TABLE IF EXISTS customer;
CREATE TABLE customer(
        customer_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        first_name VARCHAR (50) NOT NULL,
        last_name VARCHAR (50) NOT NULL,
        email VARCHAR (50) NOT NULL UNIQUE,
        has_validated_email BOOLEAN NOT NULL DEFAULT 0,
        password VARCHAR (50) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT customer_PK PRIMARY KEY (customer_id)
        CONSTRAINT customer_country_FK FOREIGN KEY (country) REFERENCES country(country_id)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: address
#------------------------------------------------------------

DROP TABLE IF EXISTS address;
CREATE TABLE address(
        address_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        customer_id INT NOT NULL,
        first_name VARCHAR (50) NOT NULL,
        last_name VARCHAR (50) NOT NULL,
        address1 VARCHAR (150) NOT NULL,
        address2 VARCHAR (150),
        city VARCHAR (50) NOT NULL,
        region VARCHAR (50),
        postal_code INT (6) NOT NULL,
        country INT NOT NULL,
        tel VARCHAR (20),
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT address_PK PRIMARY KEY (address_id)
        CONSTRAINT address_customer_FK FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: card
#------------------------------------------------------------

DROP TABLE IF EXISTS card;
CREATE TABLE card(
        card_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        customer_id INT NOT NULL,
        number INT (16) NOT NULL UNIQUE,
        expiration_date DATE NOT NULL,
        cvv INT (3) NOT NULL, 
        CONSTRAINT card_PK PRIMARY KEY (card_id)
        CONSTRAINT card_customer_FK FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: status
#------------------------------------------------------------

DROP TABLE IF EXISTS status;
CREATE TABLE status(
        status_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        libelle VARCHAR (50) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT status_PK PRIMARY KEY (status_id)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: order
#------------------------------------------------------------
DROP TABLE IF EXISTS order;
CREATE TABLE order(
        order_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        customer_id INT NOT NULL,
        order_date DATETIME NOT NULL,
        total_amount FLOAT NOT NULL DEFAULT 0,
        status_id INT NOT NULL,
        CONSTRAINT order_PK PRIMARY KEY (order_id)
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT order_customer_FK FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
        CONSTRAINT order_status_FK FOREIGN KEY (status_id) REFERENCES status(status_id)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: order_product
#------------------------------------------------------------
DROP TABLE IF EXISTS order_product;
CREATE TABLE order_product(
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        item_price FLOAT NOT NULL,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT order_product_PK PRIMARY KEY (order_id, product_id)
        CONSTRAINT order_product_order_FK FOREIGN KEY (order_id) REFERENCES order(order_id)
        CONSTRAINT order_product_product_FK FOREIGN KEY (product_id) REFERENCES product(product_id)
)ENGINE=InnoDB; 

#------------------------------------------------------------
# Table: contact
#------------------------------------------------------------

DROP TABLE IF EXISTS contact;
CREATE TABLE contact(
        contact_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        customer_id INT NOT NULL,
        email VARCHAR (50) NOT NULL,
        subject VARCHAR (50) NOT NULL,
        message VARCHAR (1000) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT contact_PK PRIMARY KEY (contact_id)
        CONSTRAINT contact_customer_FK FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
)ENGINE=InnoDB;