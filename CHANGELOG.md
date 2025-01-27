# Luma | Security Component Changelog

## [2.0.2] - 2025-01-27
### Changed
- Update dependencies

---

## [2.0.1] - 2024-11-20
### Changed
- Fetch roles when refreshing the logged-in user

---

## [2.0.0] - 2024-11-19
### Added
- Added `SecurityController` to provide login/registration functionality from the package
- Added `lumax/form-component`
- Added `PopulateCommand` for populating initial security data
- Added `Role` and `Permission` entities
- Increased session duration

### Changed
- N/A

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- N/A

### Security
- N/A

---

## [1.6.0] - 2024-08-23
### Added
- N/A

### Changed
- N/A

### Deprecated
- N/A

### Removed
- Removed `username` requirement from classes extending `AbstractUser`

### Fixed
- N/A

### Security
- N/A

---

## [1.5.2] - 2024-07-21
### Added
- N/A

### Changed
- N/A

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- Critical bug fixed; 500 error when attempting to login as a user that does not exist

### Security
- N/A

---

## [1.5.1] - 2024-07-16
### Added
- N/A

### Changed
- N/A

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- Fixed `DatabaseUserProvider::loadUserByUsername` when fetching associations

### Security
- N/A

---

## [1.5.0] - 2024-07-15
### Added
- N/A

### Changed
- Allow associated entities to be fetched along with logged-in user (for Roles, Permissions etc.)

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- N/A

### Security
- N/A

---

## [1.4.0] - 2024-05-02
### Added
- Added `AbstractUser::refresh` method to refresh the session user

### Changed
- N/A

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- N/A

### Security
- N/A

---

## [1.3.1] - 2024-05-01
### Added
- `RoleInterface` now requires `hasPermission`

### Changed
- N/A

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- N/A

### Security
- N/A

---

## [1.3.0] - 2024-04-28
### Added
- N/A

### Changed
- N/A

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- Fixed logout to just regenerate session without destroying it

### Security
- N/A

---

## [1.2.2] - 2024-04-28
### Added
- N/A

### Changed
- N/A

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- Ensured the session is restarted within the logout method

### Security
- N/A

---

## [1.2.1] - 2024-04-24
### Added
- N/A

### Changed
- N/A

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- Fixed issue with redirect header always being called in logout, causing application to perform two redirects

### Security
- N/A

---

## [1.2.0] - 2024-04-24
### Added
- N/A

### Changed
- Stop automatic redirection from logout method of `DatabaseAuthenticator`

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- N/A

### Security
- N/A

---

## [1.1.0] - 2024-04-18
### Added
- Add static `getSecurityIdentifier` method to `AbstractUser`

### Changed
- N/A

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- N/A

### Security
- N/A

---

## [1.0.1] - 2024-04-17
### Added
- Add `getUserFromSession` to `UserProviderInterface`

### Changed
- N/A

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- N/A

### Security
- N/A

---

## [1.0.0] - 2024-04-14
### Added
- Implement `DatabaseUserProvider` - responsible for retrieving instances of the user class from a database.
- Implement `DatabaseSessionManager` - handles sessions, include ID regeneration to protect against session fixation.
- Implement `DatabaseAuthenticator` - responsible for authenticating, login, registration and logout handling.
- Implement `Password` class along with `hash` and `generateRandom` static methods.

### Changed
- N/A

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- N/A

### Security
- N/A