"C:\Program Files (x86)\EasyPHP-Devserver-17\eds-binaries\dbserver\mysql5717x86x230304150727\bin\mysql.exe" -u ocf -p

CREATE DATABASE ocf CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE USER 'ocf'@'localhost' IDENTIFIED BY 'ocf';

GRANT ALL PRIVILEGES ON ocf.* TO 'ocf'@'localhost';

CREATE TABLE users (
    uid INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    admin BOOLEAN NOT NULL DEFAULT 0
)

CREATE TABLE institutions (
    iid INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
)

CREATE TABLE cashFlow (
    cfid INTEGER PRIMARY KEY AUTO_INCREMENT,
    uid INTEGER NOT NULL,
    iid INTEGER NOT NULL,
    amount INTEGER NOT NULL,
    date DATETIME NOT NULL,
    FOREIGN KEY (uid) REFERENCES users(uid),
    FOREIGN KEY (iid) REFERENCES institution(iid)
)