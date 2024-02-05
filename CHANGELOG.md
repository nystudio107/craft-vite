# Vite Changelog

All notable changes to this project will be documented in this file.

## 4.0.9 - UNRELEASED
### Fixed
* Fixed an issue where the wrong CSS hash would be returned if you were using Vite 3 or earlier ([#80](https://github.com/nystudio107/craft-vite/issues/80))

## 4.0.8 - 2024.01.30
### Added
* If the `devServer` is running, the `ViteService::fetch()` method will try to use the `devServerInternal` URL first, falling back on the `devServerPublic` so that `craft.vite.inline()` can pull from the `devServer` if it is running ([#22](https://github.com/nystudio107/craft-plugin-vite/issues/22))
* Add `phpstan` and `ecs` code linting
* Add `code-analysis.yaml` GitHub action

### Changed
* Updated docs to use node 20 & a new sitemap plugin
* PHPstan code cleanup
* ECS code cleanup

## 4.0.7 - 2023.12.08
### Fixed
* Fixed a type error if you passed an array of entries into the `errorEntry` config ([#76](https://github.com/nystudio107/craft-vite/issues/76))
* Fixed an issue where the `craft.vite.getCssHash()` function didn't work with Vite 5, because it now uses a `-` to separate the version hash ([#21](https://github.com/nystudio107/craft-plugin-vite/issues/21))

## 4.0.6 - 2023.06.07
### Added
* Add the `getCssInlineTags()` function to the `ViteVariable` so it's accessible via Twig templates
* Added the `create-release` GitHub workflow to automate release tagging

## 4.0.5 - 2023.01.25
### Changed
* Updated the `craft.vite.asset()` function to work with Vite 3.x or later, where assets are stored as top-level entries in the `manifest.json` ([#56](https://github.com/nystudio107/craft-vite/issues/56)) ([#31](https://github.com/nystudio107/craft-vite/issues/31))
* You can now include CSS manually if it's a top-level entry in your `vite.config.js` (rather than being imported into your JavaScript) via `craft.vite.asset("src/css/app.css")` ([#31](https://github.com/nystudio107/craft-vite/issues/31))

## 4.0.4 - 2023.01.01
### Changed
* Move to using `ServicesTrait` and add getter methods for services
* Update the docs to use Vitepress `^1.0.0-alpha.29`

### Fixed
* Fixed an issue where `craft.vite.includeCriticalCssTags()` would fail if you had `template` in the file path ([#45](https://github.com/nystudio107/craft-vite/issues/45))

## 4.0.3 - 2022.09.09
### Added
* Added support for detecting dev-mode in Craft CMS v4 by changing `App::env('ENVIRONMENT') === 'dev'`
* to `App::env('ENVIRONMENT') === 'dev' || App::env('CRAFT_ENVIRONMENT') === 'dev'` ([#41](https://github.com/nystudio107/craft-vite/pull/41))

### Fixed
* Set the `ViteService` config in the constructor, so that settings from the `config/vite.php` are pre-populated before the `ViteService::init()` method is called ([#44](https://github.com/nystudio107/craft-vite/issues/44))

## 4.0.2 - 2022.07.16
### Changed
* Fixed an issue where `checkDevServer` didn't work with Vite 3, because they removed the intercepting of `__vite_ping` ([#37](https://github.com/nystudio107/craft-vite/issues/37))

## 4.0.1 - 2022.06.29
### Changed
* Adds a boolean as a second param to the `craft.vite.asset(url, true)` so that assets in the vite public folder can be referenced correctly from Twig ([#9](https://github.com/nystudio107/craft-plugin-vite/pull/9))

## 4.0.0 - 2022.05.15
### Added
* Initial Craft CMS 4 release

### Fixed
* Fixed an issue where the plugin couldn't detect the Vite dev server by testing `__vite_ping` instead of `@vite/client` to determine whether the dev server is running or not ([#33](https://github.com/nystudio107/craft-vite/issues/33)) ([#8](https://github.com/nystudio107/craft-plugin-vite/issues/8))

## 4.0.0-beta.4 - 2022.04.26
### Changed
* Don't log the full exception on a Guzzle error, just log the message

### Fixed
* Fix semver for `nystudio107/craft-plugin-vite` so it's not pinned to a specific version

## 4.0.0-beta.3 - 2022.03.22
### Changed
* Only clear caches in `init()` if we're using the dev server
* Cache the status of the devServer for the duration of the request

## 4.0.0-beta.2 - 2022.03.04
### Fixed
* Updated types for Craft CMS `4.0.0-alpha.1` via Rector

## 4.0.0-beta.1 - 2022.02.07
### Added
* Initial Craft CMS 4 compatibility
