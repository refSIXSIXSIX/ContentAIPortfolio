CREATE TABLE IF NOT EXISTS product (
    id int(11) NOT NULL AUTO_INCREMENT,
    manufacturer_id smallint(6) NOT NULL,
    name varchar(255) NOT NULL,
    alias varchar(255) NOT NULL,
    short_description text NOT NULL,
    description text NOT NULL,
    price decimal(20,2) NOT NULL,
    image varchar(255) NOT NULL,
    available smallint(1) NOT NULL DEFAULT '1',
    meta_keywords varchar(255) NOT NULL,
    meta_description varchar(255) NOT NULL,
    meta_title varchar(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;