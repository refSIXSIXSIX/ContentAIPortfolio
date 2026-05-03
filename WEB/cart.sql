CREATE TABLE IF NOT EXISTS cart (
    id int(11) NOT NULL AUTO_INCREMENT,
    user_id int(11) NOT NULL,
    product_id int(11) NOT NULL,
    quantity int(11) NOT NULL DEFAULT 1,
    added_date datetime NOT NULL,
    PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;