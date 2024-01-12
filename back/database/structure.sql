DROP TABLE IF EXISTS contact;

DROP TABLE IF EXISTS order_product;

DROP TABLE IF EXISTS `order`;

DROP TABLE IF EXISTS status;

DROP TABLE IF EXISTS card;

DROP TABLE IF EXISTS address;

DROP TABLE IF EXISTS customer;

DROP TABLE IF EXISTS country;

DROP TABLE IF EXISTS image;

DROP TABLE IF EXISTS product_category;

DROP TABLE IF EXISTS product_material;

DROP TABLE IF EXISTS product;

DROP TABLE IF EXISTS category;

DROP TABLE IF EXISTS material;

DROP TABLE IF EXISTS admin;

#------------------------------------------------------------
# Table: material
#------------------------------------------------------------
CREATE TABLE material(
        slug VARCHAR (50) NOT NULL UNIQUE,
        libelle VARCHAR (50) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT material_PK PRIMARY KEY (slug)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: category
#------------------------------------------------------------
CREATE TABLE category(
        slug VARCHAR (50) NOT NULL UNIQUE,
        libelle VARCHAR (50) NOT NULL,
        image_path VARCHAR (250) UNIQUE,
        sort_order INT UNIQUE,
        is_quick_access BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT category_PK PRIMARY KEY (slug)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: product
#------------------------------------------------------------
CREATE TABLE product(
        slug VARCHAR (50) NOT NULL UNIQUE,
        name VARCHAR (50) NOT NULL,
        description VARCHAR (1000),
        is_highlander BOOLEAN NOT NULL DEFAULT 0,
        price FLOAT NOT NULL DEFAULT 0,
        stock_quantity INT NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT product_PK PRIMARY KEY (slug)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: product_category
#------------------------------------------------------------
CREATE TABLE product_category(
        product_category_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        product_slug VARCHAR (50) NOT NULL,
        category_slug VARCHAR (50) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT product_category_PK PRIMARY KEY (product_category_id),
        CONSTRAINT product_category_product_FK FOREIGN KEY (product_slug) REFERENCES product(slug),
        CONSTRAINT product_category_category_FK FOREIGN KEY (category_slug) REFERENCES category(slug)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: product_material
#------------------------------------------------------------
CREATE TABLE product_material(
        product_material_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        product_slug VARCHAR (50) NOT NULL,
        material_slug VARCHAR (50) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT product_material_PK PRIMARY KEY (product_material_id),
        CONSTRAINT product_material_product_FK FOREIGN KEY (product_slug) REFERENCES product(slug),
        CONSTRAINT product_material_material_FK FOREIGN KEY (material_slug) REFERENCES material(slug)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: image
#------------------------------------------------------------
CREATE TABLE image(
        image_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        product_slug VARCHAR (50) NOT NULL,
        image_path VARCHAR (250) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT image_PK PRIMARY KEY (image_id),
        CONSTRAINT image_product_FK FOREIGN KEY (product_slug) REFERENCES product(slug)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: country
#------------------------------------------------------------
CREATE TABLE country(
        country_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        name VARCHAR (50) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT country_PK PRIMARY KEY (country_id)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: customer
#------------------------------------------------------------
CREATE TABLE customer(
        customer_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        first_name VARCHAR (50) NOT NULL,
        last_name VARCHAR (50) NOT NULL,
        country_id INT NOT NULL,
        email VARCHAR (50) NOT NULL UNIQUE,
        has_validated_email BOOLEAN NOT NULL DEFAULT 0,
        password VARCHAR (150) NOT NULL,
        last_login DATETIME NOT NULL DEFAULT NOW(),
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT customer_PK PRIMARY KEY (customer_id),
        CONSTRAINT customer_country_FK FOREIGN KEY (country_id) REFERENCES country(country_id)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: address
#------------------------------------------------------------
CREATE TABLE address(
        address_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        customer_id INT NOT NULL,
        first_name VARCHAR (50) NOT NULL,
        last_name VARCHAR (50) NOT NULL,
        address1 VARCHAR (150) NOT NULL,
        address2 VARCHAR (150),
        city VARCHAR (50) NOT NULL,
        region VARCHAR (50),
        postal_code VARCHAR (6) NOT NULL,
        country_id INT NOT NULL,
        tel VARCHAR (20),
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT address_PK PRIMARY KEY (address_id),
        CONSTRAINT address_country_FK FOREIGN KEY (country_id) REFERENCES country(country_id),
        CONSTRAINT address_customer_FK FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: card
#------------------------------------------------------------
CREATE TABLE card(
        card_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        customer_id INT NOT NULL,
        number INT (16) NOT NULL,
        expiration_date DATE NOT NULL,
        cvv INT (3) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT card_PK PRIMARY KEY (card_id),
        CONSTRAINT card_customer_FK FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: status
#------------------------------------------------------------
CREATE TABLE status(
        status_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        libelle VARCHAR (50) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT status_PK PRIMARY KEY (status_id)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: `order`
#------------------------------------------------------------
CREATE TABLE `order`(
        order_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        customer_id INT NOT NULL,
        card_id INT NOT NULL,
        order_date DATETIME NOT NULL,
        total_amount FLOAT NOT NULL DEFAULT 0,
        status_id INT NOT NULL,
        CONSTRAINT order_PK PRIMARY KEY (order_id),
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT order_card_FK FOREIGN KEY (card_id) REFERENCES card(card_id),
        CONSTRAINT order_customer_FK FOREIGN KEY (customer_id) REFERENCES customer(customer_id),
        CONSTRAINT order_status_FK FOREIGN KEY (status_id) REFERENCES status(status_id)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: order_product
#------------------------------------------------------------
CREATE TABLE order_product(
        order_id INT NOT NULL,
        product_slug VARCHAR (50) NOT NULL,
        quantity INT NOT NULL,
        item_price FLOAT NOT NULL,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT order_product_PK PRIMARY KEY (order_id, product_slug),
        CONSTRAINT order_product_order_FK FOREIGN KEY (order_id) REFERENCES `order`(order_id),
        CONSTRAINT order_product_product_FK FOREIGN KEY (product_slug) REFERENCES product(slug)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: contact
#------------------------------------------------------------
CREATE TABLE contact(
        contact_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        customer_id INT NOT NULL,
        email VARCHAR (50) NOT NULL,
        subject VARCHAR (50) NOT NULL,
        message VARCHAR (1000) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT contact_PK PRIMARY KEY (contact_id),
        CONSTRAINT contact_customer_FK FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: admin
#------------------------------------------------------------
CREATE TABLE admin(
        admin_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        login VARCHAR (50) NOT NULL,
        password VARCHAR (150) NOT NULL,
        has_access BOOLEAN NOT NULL DEFAULT 0,
        last_login DATETIME NOT NULL DEFAULT NOW(),
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT admin_PK PRIMARY KEY (admin_id)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Trigger: before_select_customer
#------------------------------------------------------------
CREATE
OR REPLACE TRIGGER before_select_customer BEFORE
INSERT
        ON customer FOR EACH ROW
SET
        NEW.last_login = NOW();

#------------------------------------------------------------
# Trigger: before_select_admin
#------------------------------------------------------------
CREATE
OR REPLACE TRIGGER before_select_admin BEFORE
INSERT
        ON admin FOR EACH ROW
SET
        NEW.last_login = NOW();