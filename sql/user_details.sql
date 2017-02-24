CREATE TABLE user_details (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL
) CHARACTER SET utf8;

INSERT INTO user_details VALUES('', 'refresh_token', 'test');
INSERT INTO user_details VALUES('', 'access_token', 'test');
