create database SAMPLE_DB;
use SAMPLE_DB;
set global sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

create table USER
(
  USER_ID int primary key AUTO_INCREMENT,
  USER_NAME varchar(25) not null,
  USER_PASS varchar(25) not null
);

create table CHAT_HISTORY
(
  USER_ID int references USER(USER_ID),
  USER_MESSAGE varchar(255) not null,
  MESSAGE_DATE datetime not null default NOW()
);

create view VIEW_CHAT_HISTORY as select u.USER_NAME, ch.USER_MESSAGE, ch.MESSAGE_DATE from CHAT_HISTORY ch inner join USER u on ch.USER_ID = u.USER_ID;

/* Linux CLI Syntax
DELIMITER $$ ;

create procedure addUser (in NAME varchar(25), in PASS varchar(25))
begin
  insert into USER (USER_NAME, USER_PASS) values (NAME, PASS);
end
$$

create procedure addMessage (in xUSER_ID int, in xUSER_MESSAGE varchar(255))
begin
  insert into CHAT_HISTORY (USER_ID, USER_MESSAGE) values (xUSER_ID, xUSER_MESSAGE);
end
$$

DELIMITER ; $$
*/

/* Phpmyadmin syntax for xammp procedures */
CREATE DEFINER=`root`@`localhost` PROCEDURE `addUser`(IN `NAME` VARCHAR(25), IN `PASS` VARCHAR(25)) NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER begin insert into USER (USER_NAME, USER_PASS) values (NAME, PASS); end
CREATE DEFINER=`root`@`localhost` PROCEDURE `addMessage`(IN `xUSER_ID` INT, IN `xUSER_MESSAGE` VARCHAR(255)) NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER begin insert into CHAT_HISTORY (USER_ID, USER_MESSAGE) values (xUSER_ID, xUSER_MESSAGE); end

call addUser('testuser', 'pastafarian');

CREATE USER 'admin'@'localhost' IDENTIFIED BY 'JeffStar';
GRANT ALL PRIVILEGES ON SAMPLE_DB.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;