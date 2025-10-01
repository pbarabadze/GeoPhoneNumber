# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.3] - 2025-10-01
### Fixed
- Fixed missing 'prefix' key in parseNumber() output that caused formatNumber() to fail
- Added proper prefix extraction using substr($normalized, 0, 3)

### Changed
- Refactored formatNumber() to use array-based format mapping for better maintainability
- Added new format options: 'rfc3966' and 'compact'

## [1.0.2] - 2025-05-13
### Added
- New phone number range for Cellfie provider

## Previous Releases
- 2025-02-17: Added new ranges for Silknet provider
- 2025-02-03: Initial release of GeoPhoneNumber package
