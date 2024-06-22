DROP TABLE IF EXISTS order_line;

DROP TABLE IF EXISTS `order`;

DROP TABLE IF EXISTS card;

DROP TABLE IF EXISTS address;

DROP TABLE IF EXISTS contact;

DROP TABLE IF EXISTS customer;

DROP TABLE IF EXISTS country;

DROP TABLE IF EXISTS status;

DROP TABLE IF EXISTS product_image;

DROP TABLE IF EXISTS product_material;

DROP TABLE IF EXISTS product_category;

DROP TABLE IF EXISTS product;

DROP TABLE IF EXISTS category;

DROP TABLE IF EXISTS material;

DROP TABLE IF EXISTS image;

DROP TABLE IF EXISTS admin;

#------------------------------------------------------------
# Table: image
#------------------------------------------------------------
CREATE TABLE image(
        slug VARCHAR (50) NOT NULL UNIQUE,
        name VARCHAR (50),
        alt VARCHAR (250),
        path VARCHAR (250) NOT NULL,
        weight INT,
        extention VARCHAR (5),
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT image_PK PRIMARY KEY (slug)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: material
#------------------------------------------------------------
CREATE TABLE material(
        slug VARCHAR (50) NOT NULL UNIQUE,
        libelle VARCHAR (50) NOT NULL,
        color VARCHAR (7) NOT NULL UNIQUE DEFAULT '#000000',
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT material_PK PRIMARY KEY (slug)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: category
#------------------------------------------------------------
CREATE TABLE category(
        slug VARCHAR (50) NOT NULL UNIQUE,
        libelle VARCHAR (50) NOT NULL,
        image_slug VARCHAR (50),
        is_highlander BOOLEAN NOT NULL DEFAULT 0,
        sort_order INT,
        color VARCHAR (7) NOT NULL UNIQUE DEFAULT '#000000',
        is_quick_access BOOLEAN NOT NULL DEFAULT 0,
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
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
        sort_order INT,
        price FLOAT NOT NULL DEFAULT 0,
        stock_quantity INT NOT NULL DEFAULT 0,
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
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
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT product_category_PK PRIMARY KEY (product_category_id),
        CONSTRAINT product_category_product_FK FOREIGN KEY (product_slug) REFERENCES product(slug) ON DELETE CASCADE,
        CONSTRAINT product_category_category_FK FOREIGN KEY (category_slug) REFERENCES category(slug) ON DELETE CASCADE
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: product_material
#------------------------------------------------------------
CREATE TABLE product_material(
        product_material_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        product_slug VARCHAR (50) NOT NULL,
        material_slug VARCHAR (50) NOT NULL,
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT product_material_PK PRIMARY KEY (product_material_id),
        CONSTRAINT product_material_product_FK FOREIGN KEY (product_slug) REFERENCES product(slug) ON DELETE CASCADE,
        CONSTRAINT product_material_material_FK FOREIGN KEY (material_slug) REFERENCES material(slug) ON DELETE CASCADE
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: product_image
#------------------------------------------------------------
CREATE TABLE product_image(
        product_image_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        product_slug VARCHAR (50) NOT NULL,
        image_slug VARCHAR (50) NOT NULL,
        sort_order INT,
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT product_image_PK PRIMARY KEY (product_image_id),
        CONSTRAINT product_image_product_FK FOREIGN KEY (product_slug) REFERENCES product(slug) ON DELETE CASCADE,
        CONSTRAINT product_image_image_FK FOREIGN KEY (image_slug) REFERENCES image(slug) ON DELETE CASCADE
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: country
#------------------------------------------------------------
CREATE TABLE country(
        country_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        name VARCHAR (50) NOT NULL,
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
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
        email VARCHAR (50) NOT NULL UNIQUE,
        connection_token VARCHAR (500),
        validate_email_token VARCHAR (500),
        reset_password_code INT (6),
        has_validated_email BOOLEAN NOT NULL DEFAULT 0,
        password VARCHAR (150) NOT NULL,
        last_login DATETIME,
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT customer_PK PRIMARY KEY (customer_id)
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
        zip VARCHAR (6) NOT NULL,
        country_id INT NOT NULL,
        tel VARCHAR (20),
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT address_PK PRIMARY KEY (address_id),
        CONSTRAINT address_country_FK FOREIGN KEY (country_id) REFERENCES country(country_id),
        CONSTRAINT address_customer_FK FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: card
#------------------------------------------------------------
CREATE TABLE card(
        card_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        customer_id INT NOT NULL,
        first_name VARCHAR (50) NOT NULL,
        last_name VARCHAR (50) NOT NULL,
        number INT (16) NOT NULL,
        expiration_date VARCHAR (10) NOT NULL,
        cvv INT (3) NOT NULL,
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT card_PK PRIMARY KEY (card_id),
        CONSTRAINT card_customer_FK FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: status
#------------------------------------------------------------
CREATE TABLE status(
        status_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        libelle VARCHAR (50) NOT NULL,
        color VARCHAR (7) NOT NULL UNIQUE DEFAULT '#000000',
        sort_order INT,
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT status_PK PRIMARY KEY (status_id)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: `order`
#------------------------------------------------------------
CREATE TABLE `order`(
        order_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        customer_id INT NOT NULL,
        shipping_address_id INT NOT NULL,
        billing_address_id INT NOT NULL,
        card_id INT NOT NULL,
        status_id INT NOT NULL,
        order_date DATETIME NOT NULL,
        total_amount FLOAT NOT NULL DEFAULT 0,
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT order_PK PRIMARY KEY (order_id),
        CONSTRAINT order_customer_FK FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE,
        CONSTRAINT order_shipping_address_FK FOREIGN KEY (shipping_address_id) REFERENCES address(address_id),
        CONSTRAINT order_billing_address_FK FOREIGN KEY (billing_address_id) REFERENCES address(address_id),
        CONSTRAINT order_card_FK FOREIGN KEY (card_id) REFERENCES card(card_id),
        CONSTRAINT order_status_FK FOREIGN KEY (status_id) REFERENCES status(status_id)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: order_line
#------------------------------------------------------------
CREATE TABLE order_line(
        order_line_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        order_id INT NOT NULL,
        product_slug VARCHAR (50) NOT NULL,
        quantity INT NOT NULL,
        line_price FLOAT NOT NULL,
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT order_line_PK PRIMARY KEY (order_line_id),
        CONSTRAINT order_line_order_FK FOREIGN KEY (order_id) REFERENCES `order`(order_id) ON DELETE CASCADE,
        CONSTRAINT order_line_product_FK FOREIGN KEY (product_slug) REFERENCES product(slug)
) ENGINE = InnoDB;

#------------------------------------------------------------
# Table: contact
#------------------------------------------------------------
CREATE TABLE contact(
        contact_id INT AUTO_INCREMENT NOT NULL UNIQUE,
        customer_id INT,
        email VARCHAR (50) NOT NULL,
        subject VARCHAR (50) NOT NULL,
        message VARCHAR (1000) NOT NULL,
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
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
        last_login DATETIME,
        is_deleted BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT NOW(),
        CONSTRAINT admin_PK PRIMARY KEY (admin_id)
) ENGINE = InnoDB;