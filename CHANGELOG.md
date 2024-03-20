# Luma | Security Component Changelog

## [Unreleased]
### Added
- Implement `DatabaseUserProvider` - responsible for retrieving instances of the user class from a database.
- Implement `DatabaseSessionManager` - handles sessions, include ID regeneration to protect against session fixation.
- Implement `DatabaseAuthenticator` - responsible for authenticating and retrieving logged-in users.
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