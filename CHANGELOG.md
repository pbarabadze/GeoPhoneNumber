# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.7] - 2025-11-06
### Added
- New phone number range for [Cellfie] provider
## [1.0.6] - 2025-10-24
### Added
- New phone number range for [Cellfie] provider

### Changed
- Removed duplicate ranges from [Cellfie] provider array

## [1.0.5] - 2025-10-01
### Added
- New phone number ranges for [Silknet] provider

## [1.0.4] - 2025-10-01
### Fixed
- Fixed incorrect prefix extraction in parseNumber() - now correctly extracts positions 4-6 (actual prefix) instead of 1-3 (country code)
- Fixed main number extraction to start from position 7 instead of position 4

## [1.0.3] - 2025-10-01 [YANKED]
**Note:** This version contains a bug in prefix extraction. Please use v1.0.4 instead.

### Fixed
- Fixed missing 'prefix' key in parseNumber() output that caused formatNumber() to fail
- Added prefix extraction (incorrect positions, fixed in v1.0.4)

### Changed
- Refactored formatNumber() to use array-based format mapping for better maintainability
- Added new format options: 'rfc3966' and 'compact'

## [1.0.2] - 2025-05-13
### Added
- New phone number range for Cellfie provider

## Previous Releases
- 2025-02-17: Added new ranges for Silknet provider
- 2025-02-03: Initial release of GeoPhoneNumber package
