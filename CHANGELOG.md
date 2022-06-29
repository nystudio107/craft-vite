# Vite Changelog

All notable changes to this project will be documented in this file.

## 1.0.26 - 2022.06.29
### Changed
* Adds a boolean as a second param to the `craft.vite.asset(url, true)` so that assets in the vite public folder can be referenced correctly from Twig ([#10](https://github.com/nystudio107/craft-plugin-vite/pull/10))

## 1.0.25 - 2022.05.15
### Fixed
* Fixed an issue where the plugin couldn't detect the Vite dev server by testing `__vite_ping` instead of `@vite/client` to determine whether the dev server is running or not ([#33](https://github.com/nystudio107/craft-vite/issues/33)) ([#8](https://github.com/nystudio107/craft-plugin-vite/issues/8))

## 1.0.24 - 2022.03.22

### Changed

* Only clear caches in `init()` if we're using the dev server
* Cache the status of the devServer for the duration of the request

## 1.0.23 - 2022.01.21

### Fixed

* Removed errant debugging code

## 1.0.22 - 2022.01.20

### Added

* Added support for [subresource integrity](https://developer.mozilla.org/en-US/docs/Web/Security/Subresource_Integrity)
  via plugins like [vite-plugin-manifest-sri](https://github.com/ElMassimo/vite-plugin-manifest-sri)

## 1.0.21 - 2022.01.17

### Added

* Added a `vite-script-loaded` event dispatched to `document` so listeners can be notified after a script
  loads ([#310](https://github.com/nystudio107/craft-imageoptimize/issues/310))

## 1.0.20 - 2021.12.16

### Fixed

* Fixed a regression caused by [#5](https://github.com/nystudio107/craft-plugin-vite/pull/5) to ensure assets load on
  production ([#6](https://github.com/nystudio107/craft-plugin-vite/issues/6))

## 1.0.19 - 2021.12.15

### Added

* Added the `.entry()` function to retrieve and entry from the `manifest.json` to a JavaScript file, CSS file, or asset

## 1.0.18 - 2021.12.14

### Fixed

* Fixed an issue where the needle/haystack logic was reversed in `strpos()` which could cause it to not match properly
  in some setups ([#5](https://github.com/nystudio107/craft-plugin-vite/pull/5))

## 1.0.17 - 2021.10.21

### Fixed

* Fixed an issue with potentially duplicated `modulepreload` links by adding tags via an associative
  array ([#16](https://github.com/nystudio107/craft-vite/issues/16))

## 1.0.16 - 2021.09.18

### Added

* Added `craft.vite.asset()` to retrive assets such as images that are imported in JavaScript or CSS

## 1.0.15 - 2021.08.25

### Changed

* Changed the `DEVMODE_CACHE_DURATION` to `1` second ([#3](https://github.com/nystudio107/craft-plugin-vite/issues/3))

## 1.0.14 - 2021.08.10

### Added

* Added [Preload Directives Generation](https://vitejs.dev/guide/features.html#preload-directives-generation) that will
  automatically generate `<link rel="modulepreload">` directives for entry chunks and their direct
  imports ([PR#2](https://github.com/nystudio107/craft-plugin-vite/pull/2))

## 1.0.13 - 2021.07.14

### Added

* Added a `craft.vite.devServerRunning()` method to allow you to determine if the Vite dev server is running or not from
  your Twig templates ([#10](https://github.com/nystudio107/craft-vite/issues/10))

## 1.0.12 - 2021.07.14

### Changed

* Switched the `checkDevServer` test file to `@vite/client` to accommodate with the change in Vite `^2.4.0` to use
  the `.mjs` extension ([#11](https://github.com/nystudio107/craft-vite/issues/11))

## 1.0.11 - 2021.06.29

### Changed

* Roll back the automatic inclusion of `@vite/client.js` ([#9](https://github.com/nystudio107/craft-vite/issues/9))

## 1.0.10 - 2021.06.28

### Changed

* Always include the `@vite/client.js` script if the dev server is
  running ([#9](https://github.com/nystudio107/craft-vite/issues/9))

## 1.0.9 - 2021.06.05

### Added

* Added `craft.vite.getCssHash()` that returns the content hash for the build CSS assets

## 1.0.8 - 2021.06.05

### Added

* Added `craft.vite.includeCriticalCssTags()` to make it easy to include inline Critical CSS generated
  via `rollup-plugin-critical`

## 1.0.7 - 2021.05.21

### Added

* Added a `includeReactRefreshShim` setting that will automatically include the
  required [shim for `react-refresh`](https://vitejs.dev/guide/backend-integration.html#backend-integration) when the
  Vite dev server is running ([#5](https://github.com/nystudio107/craft-vite/issues/5))

### Changed

* Removed custom user/agent header that was a holdover from `curl`
* Re-worked how the various JavaScript shims are stored and injected

## 1.0.6 - 2021.05.20

### Changed

* Change the default `useDevServer` setting
  to `App::env('ENVIRONMENT') === 'dev'` ([#6](https://github.com/nystudio107/craft-vite/issues/6))
* Refactored the code from a monolithic `ViteService` to helpers, as appropriate

### Fixed

* Fixed an issue where it was outputting `type="nomodule"` for legacy scripts, when it should have just been `nomodule`

## 1.0.5 - 2021.05.14

### Added

* Moved the live reload through Twig errors to the ViteService so that plugins can get it too
* Added `.inline()` to allow for inlining of local or remote files in your templates, with a caching layer

### Changed

* Use `registerJsFile()` instead of `registerScript()`
* Make the cache last for 30 seconds with `devMode` on
* Refactored to `ViteVariableInterface` & `ViteVariableTrait`

## 1.0.4 - 2021.05.08

### Added

* Added the `devServerInternal` setting back in, along with `checkDevServer` for people who want the fallback
  behavior ([#2](https://github.com/nystudio107/craft-vite/issues/2))

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

* Removed entirely the `devServerInternal` setting, which isn't necessary (we just depend on you setting
  the `useDevServer` flag correctly instead), and added setup complexity

## 1.0.1 - 2021-05-04

### Changed

* Added initial documentation
* Updated default `config.php`

## 1.0.0 - 2021-05-03

### Added

* Initial release
