CREATE TABLE IF NOT EXISTS product_properties (
    id int(11) NOT NULL AUTO_INCREMENT,
    product_id int(11) NOT NULL,
    property_name varchar(255) NOT NULL,
    property_value varchar(255) NOT NULL,
    property_price decimal(20,2) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;