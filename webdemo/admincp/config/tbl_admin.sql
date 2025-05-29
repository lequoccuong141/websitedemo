CREATE TABLE IF NOT EXISTS tbl_admin (
    id_admin int(11) NOT NULL AUTO_INCREMENT,
    username varchar(100) NOT NULL,
    password varchar(100) NOT NULL,
    admin_status int(11) NOT NULL DEFAULT 1,
    PRIMARY KEY (id_admin)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;