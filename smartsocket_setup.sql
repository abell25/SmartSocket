CREATE DATABASE smartsocket;

USE smartsocket;

CREATE TABLE user (
	user_id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(50) NOT NULL,
	email VARCHAR(50) NOT NULL,
	password VARCHAR(50) NOT NULL,
	power_cost FLOAT NULL
);

CREATE TABLE device (
	dev_id SMALLINT NOT NULL,
	user_id SMALLINT NOT NULL,
	nickname varchar(50) NOT NULL,
	resistance SMALLINT NULL,
	schedule_last_modified TIMESTAMP NULL,
	schedule TEXT NULL,
	max_power_usage FLOAT NULL,
	max_cost FLOAT NULL,
	PRIMARY KEY (dev_id),
	FOREIGN KEY (user_id) REFERENCES user(user_id)
);

CREATE TABLE reading (
	dev_id SMALLINT NOT NULL,
	time_id TIMESTAMP NOT NULL,
	milliamps FLOAT NOT NULL,
	millivolts FLOAT NOT NULL,
	state BOOL NOT NULL,
	FOREIGN KEY (dev_id) REFERENCES device(dev_id),
	PRIMARY KEY (dev_id, time_id)
);
