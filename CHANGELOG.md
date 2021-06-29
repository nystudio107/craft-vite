# Vite Changelog

All notable changes to this project will be documented in this file.

## 1.0.11 - 2021.06.29
### Changed
* Roll back the automatic inclusion of `@vite/client.js` (https://github.com/nystudio107/craft-vite/issues/9)

## 1.0.10 - 2021.06.28
### Changed
* Always include the `@vite/client.js` script if the dev server is running (https://github.com/nystudio107/craft-vite/issues/9)

## 1.0.9 - 2021.06.05
### Added
* Added `craft.vite.getCssHash()` that returns the content hash for the build CSS assets

## 1.0.8 - 2021.06.05
### Added
* Added `craft.vite.includeCriticalCssTags()` to make it easy to include inline Critical CSS generated via `rollup-plugin-critical` 

## 1.0.7 - 2021.05.21
### Added
* Added a `includeReactRefreshShim` setting that will automatically include the required [shim for `react-refresh`](https://vitejs.dev/guide/backend-integration.html#backend-integration) when the Vite dev server is running (https://github.com/nystudio107/craft-vite/issues/5)

### Changed
* Removed custom user/agent header that was a holdover from `curl`
* Re-worked how the various JavaScript shims are stored and injected

## 1.0.6 - 2021.05.20
### Changed
* Change the default `useDevServer` setting to `App::env('ENVIRONMENT') === 'dev'` (https://github.com/nystudio107/craft-vite/issues/6)
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
