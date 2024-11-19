DROP SCHEMA IF EXISTS Security;
DROP SCHEMA IF EXISTS SecurityComponentTest;

CREATE SCHEMA Security;

USE Security;

DROP TABLE IF EXISTS tblRoleUser, tblPermissionRole, ublRole, ublPermission;

CREATE TABLE tblUser (
    intUserId INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    strUsername VARCHAR(60) NOT NULL,
    strEmailAddress VARCHAR(255) NOT NULL,
    strPassword VARCHAR(255) NOT NULL,
    dtmCreated DATETIME NOT NULL DEFAULT NOW(),
    UNIQUE KEY (strEmailAddress)
);

CREATE TABLE tblAddressDetails (
    intAddressDetailsId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    strAddressLineOne VARCHAR(255) NOT NULL,
    strAddressLineTwo VARCHAR(255),
    strCity VARCHAR(60) NOT NULL,
    strPostcode VARCHAR(9) NOT NULL,
    intUserId INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (intUserId) REFERENCES tblUser(intUserId)
);

CREATE TABLE ublRole (
    intRoleId INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    strRoleName VARCHAR(110) NOT NULL UNIQUE,
    strRoleHandle VARCHAR(110) NOT NULL UNIQUE
);

CREATE TABLE ublPermission (
    intPermissionId INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    strPermissionName VARCHAR(110) NOT NULL UNIQUE,
    strPermissionHandle VARCHAR(110) NOT NULL UNIQUE
);

CREATE TABLE tblPermissionRole (
    intPermissionId INT(11) UNSIGNED NOT NULL,
    intRoleId INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (intPermissionId) REFERENCES ublPermission(intPermissionId),
    FOREIGN KEY (intRoleId) REFERENCES ublRole(intRoleId),
    UNIQUE KEY (intPermissionId, intRoleId)
);

CREATE TABLE tblRoleUser (
    intUserId INT(11) UNSIGNED NOT NULL,
    intRoleId INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (intUserId) REFERENCES tblUser(intUserId),
    FOREIGN KEY (intRoleId) REFERENCES ublRole(intRoleId),
    UNIQUE KEY (intUserId, intRoleId)
);