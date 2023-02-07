SET TIME_ZONE='+00:00';

DROP DATABASE IF EXISTS 'telemetry_data_db';

CREATE DATABASE IF NOT EXISTS telemetry_data_db COLLATE utf8_unicode_ci;

-- create user account


GRANT SELECT, INSERT ON telemetry_data_db.* TO registered_user@localhost IDENTIFIED BY 'user_pass';

-- Table structure for users

USE telemetry_db;

DROP TABLE IF EXISTS 'user_details';

CREATE TABLE 'user_details'(
    'auto_id' int(10) unsigned NOT NULL AUTO_INCREMENT,
    'full_name' varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
    'email' varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
    'password' varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
    'phone' int(30) COLLATE utf8mb4_unicode_ci NOT NULL,
    'timestamp' timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY('auto_id')
    ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE= utf8mb4_unicode_ci;

DROP TABLE IF EXISTS 'telemetry_data';
CREATE TABLE telemetry_data (
    switch1 varchar(32) NOT NULL,
    switch2 varchar(32) NOT NULL,
    switch3 varchar(32) NOT NULL,
    switch4 varchar(32) NOT NULL,
    fan varchar(32) NOT NULL,
    heater varchar(64) NOT NULL,
    keypad varchar(64) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO telemetry_data (switch1, switch2, switch3, switch4, fan, heater, keypad) VALUES ('on', 'on', 'off', 'off', 'forward', '32', '8');

DROP TABLE IF EXISTS 'message_data';
CREATE TABLE message_data (
    id int AUTO_INCREMENT primary key NOT NULL,
     msisdn varchar(64) NOT NULL,
     destination varchar(64) NOT NULL,
     date varchar(64) NOT NULL,
     message varchar(248) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
