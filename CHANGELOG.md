# Vite Changelog

All notable changes to this project will be documented in this file.

## 5.0.2 - 2026.08.01
### Changed
* Filter out empty attributes, but preserve boolean values
* Update the devServer check to include `403` status codes, so it will work with Vite > `6.0` ([#103](https://github.com/nystudio107/craft-vite/issues/103))
* Update `craftcms/cloud` version constraint

### Fixed
* Early-return from `VitePluginService::init()` for console requests ([#31](https://github.com/nystudio107/craft-plugin-vite/issues/31))

## 5.0.1 - 2024.08.13
### Added
* Added a `craft.vite.integrity()` method that will extract the integrity hash (for building a Content Security Policy)
* Added an `includeScriptOnloadHandler` config setting that allows you to disable the adding of an `onload` handler on the `<script>` tags (useful when implementing a Content Security Policy)

### Changed
* Filter out empty attributes so they don't render on the `<script>` tags

### Fixed
* Use `strrpos` instead of `strpos` when attempting to extract a file name without the hash ([#28](https://github.com/nystudio107/craft-plugin-vite/pull/28))

## 5.0.0 - 2024.04.16
### Added
* Stable release for Craft CMS 5
* Add `craft/cloud` to `composer.json` for CI

## 5.0.0-beta.3 - 2024.03.02
### Added
* Add documentation for Craft Cloud usage with Vite ([#83](https://github.com/nystudio107/craft-vite/pull/83))
* Add support for clearing Vite caches in response to Craft Cloud's `UpController::EVENT_AFTER_UP` event ([#83](https://github.com/nystudio107/craft-vite/pull/83))

### Fixed
* Fixed an issue where the wrong CSS hash would be returned if you were using Vite 3 or earlier ([#80](https://github.com/nystudio107/craft-vite/issues/80))
* Fixed an issue where `craft.vite.entry()` would fail if you were using Vite 5 or later, due to the `ManifestHelper::fileNameWithoutHash()` function not working correctly ([#24](https://github.com/nystudio107/craft-plugin-vite/issues/24))

## 5.0.0-beta.2 - 2024.01.30
### Added
* If the `devServer` is running, the `ViteService::fetch()` method will try to use the `devServerInternal` URL first, falling back on the `devServerPublic` so that `craft.vite.inline()` can pull from the `devServer` if it is running ([#22](https://github.com/nystudio107/craft-plugin-vite/issues/22))
* Add `phpstan` and `ecs` code linting
* Add `code-analysis.yaml` GitHub action

### Changed
* PHPstan code cleanup
* ECS code cleanup

## 5.0.0-beta.1 - 2024.01.21
### Added
- Initial beta release
