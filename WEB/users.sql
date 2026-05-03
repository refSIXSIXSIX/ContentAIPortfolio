CREATE TABLE IF NOT EXISTS users (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    phone varchar(50),
    password varchar(255) NOT NULL,
    reg_date datetime NOT NULL,
    PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;