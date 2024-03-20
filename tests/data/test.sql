DROP SCHEMA IF EXISTS SecurityComponentTest;

CREATE SCHEMA SecurityComponentTest;

USE SecurityComponentTest;

DROP TABLE IF EXISTS User, AddressDetails;

CREATE TABLE User (
    intUserId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    strUsername VARCHAR(60) NOT NULL,
    strEmailAddress VARCHAR(255) NOT NULL,
    strPassword VARCHAR(255) NOT NULL,
    dtmCreated DATETIME NOT NULL DEFAULT NOW(),
    UNIQUE KEY (strEmailAddress)
);

CREATE TABLE AddressDetails (
    intAddressDetailsId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    strAddressLineOne VARCHAR(255) NOT NULL,
    strAddressLineTwo VARCHAR(255),
    strCity VARCHAR(60) NOT NULL,
    strPostcode VARCHAR(9) NOT NULL,
    intUserId INT NOT NULL,
    FOREIGN KEY (intUserId) REFERENCES User(intUserId)
);