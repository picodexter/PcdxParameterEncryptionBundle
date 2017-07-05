# Changelog

This project adheres to [Semantic Versioning](http://semver.org/).

## (Unreleased)

### Added

*   (empty)

### Changed

*   (empty)

### Deprecated

*   (empty)

### Removed

*   (empty)

### Fixed

*   (empty)

### Security

*   (empty)

## 1.0.1 (2017-07-05)

### Added

*   Added Bundle Configuration Service Definition Rewriting feature to replace encrypted parameters in service
    definitions, which originally got their arguments from bundle configurations, with their decrypted counterparts.

    You can find more on this topic in the new
    [Bundle Configuration Service Definition Rewriting documentation page](Resources/doc/bundle-configuration-service-definition-rewriting.rst).

### Removed

*   Removed PHP CS Fixer dist config file from Git exports
*   Removed PHPUnit dist config file from Git exports

### Fixed

*   Fixed interpretation of priority value for service tag "pcdx_parameter_encryption.crypto.key_must_not_be_empty"

## 1.0.0 (2017-06-21)

*   Initial release
