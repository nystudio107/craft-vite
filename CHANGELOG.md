# Vite Changelog

All notable changes to this project will be documented in this file.

## 5.0.0-beta.3 - UNRELEASED
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
