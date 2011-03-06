-- MyTabCloud SQL Scripting
-- Author : Gael Ratovelo

CREATE TABLE IF NOT EXISTS `mtc_user` (
    `usr_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `usr_login` VARCHAR( 50 ) NOT NULL ,
    `usr_mail` VARCHAR( 100 ) NOT NULL ,
    `usr_password` VARCHAR( 32 ) NULL ,
    `usr_password_salt` VARCHAR( 32 ) NULL ,
    `usr_name` VARCHAR( 50 ) NULL ,
    UNIQUE (
    `usr_login`
    )
) ENGINE = InnoDB;
