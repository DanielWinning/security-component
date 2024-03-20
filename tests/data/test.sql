DROP SCHEMA IF EXISTS SecurityComponentTest;

CREATE SCHEMA SecurityComponentTest;

USE SecurityComponentTest;

DROP TABLE IF EXISTS User, AddressDetails;

CREATE TABLE User (
    intUserId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    strUsername VARCHAR(60) NOT NULL,
    strEmailAddress VARCHAR(255) NOT NULL,
    dtmCreated DATETIME NOT NULL DEFAULT NOW()
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

INSERT INTO User
    (strUsername, strEmailAddress)
VALUES
    ('Andrew', 'andrew@test.com'),
    ('Bella', 'bella@test.com'),
    ('Charlie', 'charlie@test.com'),
    ('Danny', 'danny@test.com');