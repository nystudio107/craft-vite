# Vite Changelog

All notable changes to this project will be documented in this file.

## 1.0.3 - 2021.05.07
### Changed
* Crawl the `manifest.json` dependency graph recursively to look for CSS files

### Fixed
* Don't call any AssetManager methods in the component `init()` method during console requests

## 1.0.2 - 2021-05-06
### Changed
* Removed entirely the `devServerInternal` setting, which isn't necessary (we just depend on you setting the `useDevServer` flag correctly instead), and added setup complexity

## 1.0.1 - 2021-05-04
### Changed
* Added initial documentation
* Updated default `config.php`

## 1.0.0 - 2021-05-03
### Added
* Initial release
