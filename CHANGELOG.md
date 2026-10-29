# Changelog

## [1.3.0] - 2026-10-29
### Breaking Changes
- Minimum PHP version updated from 8.0 to 8.2
- Dependency major versions updated: guzzlehttp/guzzle 8, respect/validation 2,
  kornrunner/secp256k1 0.4, sop/asn1 4, sop/crypto-encoding 0.3, sop/crypto-types 0.3
- JMS serializer metadata moved from docblock annotations to PHP 8 attributes;
  doctrine/annotations is no longer used

### Security
- Replaced mdanter/ecc (critical and medium side-channel advisories) with
  paragonie/ecc through kornrunner/secp256k1 0.4; request signatures are unchanged
- Updated guzzlehttp/guzzle to clear its open advisories

### Changed
- `ApiClient` now returns the response for any Guzzle `ResponseException`; a
  request failure without a response is thrown as `RequestException`
- `composer.lock` is committed (excluded from the package by `.gitattributes`)
  so dependencies can be scanned
- Dev tools updated: phpunit 11, squizlabs/php_codesniffer 4, friendsofphp/php-cs-fixer 3

### Notes
- Supported versions: PHP 8.2, 8.3, 8.4, 8.5

## [1.2.0] - 2026-04-23
### Breaking Changes
- Minimum PHP version updated from 7.2 to 8.0
- PHP 7.x is no longer supported

### Added
- PHP 8.4 added to supported and tested versions

### Notes
- PHP 7.x reached end of life in December 2022
- Supported versions: PHP 8.0, 8.1, 8.2, 8.3, 8.4
- Recommend upgrading to PHP 8.2+ which has active support
