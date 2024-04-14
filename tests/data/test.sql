# DROP SCHEMA IF EXISTS SecurityComponentTest;
# DROP SCHEMA IF EXISTS Security;
#
CREATE SCHEMA IF NOT EXISTS SecurityComponentTest;
CREATE SCHEMA IF NOT EXISTS Security;

USE Security;

DROP TABLE IF EXISTS tblRoleUser;

USE SecurityComponentTest;

DROP TABLE IF EXISTS User, AddressDetails;

CREATE TABLE User (
    intUserId INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
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
    intUserId INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (intUserId) REFERENCES User(intUserId)
);

USE Security;

DROP TABLE IF EXISTS tblPermissionRole, tblRole, tblPermission;

CREATE TABLE tblRole (
    intRoleId INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    strRoleName VARCHAR(110) NOT NULL UNIQUE,
    strRoleHandle VARCHAR(110) NOT NULL UNIQUE
);

CREATE TABLE tblPermission (
    intPermissionId INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    strPermissionName VARCHAR(110) NOT NULL UNIQUE,
    strPermissionHandle VARCHAR(110) NOT NULL UNIQUE
);

CREATE TABLE tblPermissionRole (
    intPermissionId INT(11) UNSIGNED NOT NULL,
    intRoleId INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (intPermissionId) REFERENCES tblPermission(intPermissionId),
    FOREIGN KEY (intRoleId) REFERENCES tblRole(intRoleId),
    UNIQUE KEY (intPermissionId, intRoleId)
);

CREATE TABLE tblRoleUser (
    intUserId INT(11) UNSIGNED NOT NULL,
    intRoleId INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (intUserId) REFERENCES SecurityComponentTest.user(intUserId),
    FOREIGN KEY (intRoleId) REFERENCES tblRole(intRoleId),
    UNIQUE KEY (intUserId, intRoleId)
);