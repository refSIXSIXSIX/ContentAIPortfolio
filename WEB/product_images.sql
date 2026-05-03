CREATE TABLE IF NOT EXISTS product_images (
    id int(11) NOT NULL AUTO_INCREMENT,
    product_id int(11) NOT NULL,
    image varchar(255) NOT NULL,
    title varchar(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;