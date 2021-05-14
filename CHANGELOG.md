# Vite Changelog

All notable changes to this project will be documented in this file.

## 1.0.5 - UNRELEASED
### Added
* Moved the live reload through Twig errors to the ViteService so that plugins can get it too
* Added `.fetch()` to allow for fetching of local or remote files, with a caching layer

### Changed
* Use `registerJsFile()` instead of `registerScript()`
* Make the cache last for 30 seconds with `devMode` on

## 1.0.4 - 2021.05.08
### Added
* Added the `devServerInternal` setting back in, along with `checkDevServer` for people who want the fallback behavior (https://github.com/nystudio107/craft-vite/issues/2)

### Changed
* Use `PRIMARY_SITE_URL` in the default config instead of `SITE_URL`
* Switch over to VitePress for the docs

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
