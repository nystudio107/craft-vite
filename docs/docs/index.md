---
title: Vite plugin for Craft CMS 3.x
description: Documentation for the Vite plugin. The Vite plugin allows the use of the Vite.js next generation frontend tooling with Craft CMS
---
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nystudio107/craft-vite/badges/quality-score.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-vite/?branch=v1) [![Code Coverage](https://scrutinizer-ci.com/g/nystudio107/craft-vite/badges/coverage.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-vite/?branch=v1) [![Build Status](https://scrutinizer-ci.com/g/nystudio107/craft-vite/badges/build.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-vite/build-status/v1) [![Code Intelligence Status](https://scrutinizer-ci.com/g/nystudio107/craft-vite/badges/code-intelligence.svg?b=v1)](https://scrutinizer-ci.com/code-intelligence)

# Vite plugin for Craft CMS 3.x

Allows the use of the Vite.js next generation frontend tooling with Craft CMS

![Screenshot](./resources/img/plugin-logo.png)

Related Article: [Vite.js Next Generation Frontend Tooling + Craft CMS](https://nystudio107.com/blog/using-vite-js-next-generation-frontend-tooling-with-craft-cms)

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require nystudio107/craft-vite

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Vite.

## Vite Overview

Vite is a bridge between Craft CMS/Twig and the next generation frontend build tool [Vite.js](https://vitejs.dev/)

Vite allows for Hot Module Replacement (HMR) of JavaScript, CSS, and Twig (even through errors) during development, as well as optimized production builds.

Vite supports both modern and legacy bundle builds, as per the [Deploying ES2015+ Code in Production Today](https://philipwalton.com/articles/deploying-es2015-code-in-production-today/) article.

Vite also handles generating the necessary `<script>` and `<link>` tags to support both synchronous and asynchronous loading of JavaScript and CSS.

Additionally, Vite has a caching layer to ensure optimal performance.

## Configuring Vite

Vite.js is JavaScript frontend tooling, so by default it uses an `index.html` as an [entrypoint to your application](https://vitejs.dev/guide/#index-html-and-project-root), but with the Vite plugin and some minor configuration changes, we can use it with server-rendered setups like [Craft CMS](https://craftcms.com).

Configuration for Vite is done via the `config.php` config file. Here’s the default `config.php`; it should be renamed to `vite.php` and copied to your `config/` directory to take effect.

### The `config.php` File

```php
<?php

use craft\helpers\App;

return [
    'useDevServer' => App::env('ENVIRONMENT') === 'dev',
    'manifestPath' => '@webroot/dist/manifest.json',
    'devServerPublic' => 'http://localhost:3000/',
    'serverPublic' => App::env('PRIMARY_SITE_URL') . '/dist/',
    'errorEntry' => '',
    'cacheKeySuffix' => '',
    'devServerInternal' => '',
    'checkDevServer' => false,
    'includeReactRefreshShim' => false,
    'includeModulePreloadShim' => true,
    'criticalPath' => '@webroot/dist/criticalcss',
    'criticalSuffix' =>'_critical.min.css',
];
```

These are the settings you’ll need to change for your project:

* **`useDevServer`** - is a `boolean` that sets whether you will be using [Vite dev server](https://vitejs.dev/guide/features.html#hot-module-replacement) for hot module replacement (HMR). If this is set to `false`, the files will be pulled from the `manifest.json` specified in `manifestPath`
* **`manifestPath`** - the public server path to your manifest files; it can be a full URL or a partial path, or a Yii2 alias.  This is usually the same as whatever you set your `build.outDir` to in `vite.config.js`
* **`devServerPublic`** - the URL to the Vite dev server, which is used for the hot module replacement (HMR); it can be a full URL or a partial path, or a Yii2 alias. Usually this is `http://localhost:3000`, since Vite defaults to that. This will appear in `<script>` tags on the frontend when the dev server is running
* **`serverPublic`** - the public server URL to your asset files; it can be a full URL or a partial path, or a Yii2 alias. This will appear in `<script>` tags on the frontend for production builds. `App::env('PRIMARY_SITE_URL') . '/dist/'` is a typical setting
  
These are completely optional settings that you probably won’t need to change:

* **`errorEntry`** - is a string, or array of strings, that should be the JavaScript entry point(s) (for example: `src/js/app.ts`) in your `manifest.json` that should be injected into Twig error templates, to allow hot module replacement to work through Twig error pages. `devMode` must be `true` and **useDevServer** must also be `true` for this to have any effect.
* **`cacheKeySuffix`** - String to be appended to the cache key
* **`devServerInternal`** - The internal URL to the dev server, when accessed from the environment in which PHP is executing. This can be the same as `$devServerPublic`, but may be different in containerized or VM setups. ONLY used if `$checkDevServer = true`
* **`checkDevServer`** - Should we check for the presence of the dev server by pinging $devServerInternal to make sure it’s running?
* **`includeReactRefreshShim`** - whether or not the required [shim for `react-refresh`](https://vitejs.dev/guide/backend-integration.html#backend-integration) should be included when the Vite dev server is running
* **`includeModulePreloadShim`** - whether or not the [shim for `modulepreload-polyfill`](https://vitejs.dev/guide/features.html#preload-directives-generation) should be included to polyfill `<link rel="modulepreload">`

If you’re using the [rollup-plugin-critical](https://github.com/nystudio107/rollup-plugin-critical) to generate [critical CSS](https://nystudio107.com/blog/implementing-critical-css), use these settings:

* **`criticalPath`** - File system path (or URL) to where the Critical CSS files are stored
* **`criticalSuffix`** - the suffix added to the name of the currently rendering template for the critical CSS filename


Note also that the **manifestPath** defaults to a Yii2 alias `@webroot/dist/manifest.json` (adjust as necessary to point to your `manifest.json` on the file system); this allows Vite to load the manifest from the file system, rather than via http request, and is the preferred method. However, it works fine as a full URL as well if you have your `manifest.json` hosted on a CDN or such.

### Configuring Vite.js

#### Basic Config

Here’s a basic `vite.config.js` for use as a [Vite config](https://vitejs.dev/config/):

```js
export default ({ command }) => ({
  base: command === 'serve' ? '' : '/dist/',
  build: {
    manifest: true,
    outDir: '../cms/web/dist/',
    rollupOptions: {
      input: {
        app: './src/js/app.ts',
      }
    },
  },
});
```

* **`base`** - set to the root if the dev server is running, and otherwise set it to `/dist/` so our built assets are in their own directory (and often not checked into Git).
* **`build.manifest`** - set to `true` so that the [Rollup build](https://vitejs.dev/guide/build.html) will generate a manifest file of the production assets
* **`build.outDir`** - specifies where the built production assets should go, as a file system path relative to the `vite.config.js` file.
* **`build.rollupOptions.input`** - set to an object that has [key-value pairs](https://vitejs.dev/guide/build.html#multi-page-app) for each of our entrypoint scripts (needed since we’re not using an `index.html` as our application entrypoint). These should be the full path to the script as referenced in your Twig code

#### Modern + Legacy Config

By default, Vite generates JavaScript bundles that work with modern browsers that support [native ESM](https://caniuse.com/es6-module).

If you require support for legacy browsers, you can use the [@vitejs/plugin-legacy](https://github.com/vitejs/vite/tree/main/packages/plugin-legacy) plugin:

```js
import legacy from '@vitejs/plugin-legacy'

export default ({ command }) => ({
   base: command === 'serve' ? '' : '/dist/',
   build: {
      manifest: true,
      outDir: '../cms/web/dist/',
      rollupOptions: {
         input: {
            app: './src/js/app.ts',
         }
      },
   },
   plugins: [
      legacy({
         targets: ['defaults', 'not IE 11']
      }),
   ],
});
```

This will generate `-legacy` files for your production bundles, and the Vite plugin automatically detects them and uses the [module/nomodule](https://philipwalton.com/articles/deploying-es2015-code-in-production-today/) pattern for you.

#### Live Reload of Twig Config

Vite provides hot module replacement (HRM) of CSS and JavaScript as you build your application out of the box.

If you want live reload of your Twig (or other) files as you develop, you can get that with the [vite-plugin-restart](https://github.com/antfu/vite-plugin-restart) plugin:

```js
import ViteRestart from 'vite-plugin-restart';

// https://vitejs.dev/config/
export default ({ command }) => ({
  base: command === 'serve' ? '' : '/dist/',
  build: {
    manifest: true,
    outDir: '../cms/web/dist/',
    rollupOptions: {
      input: {
        app: './src/js/app.ts',
      }
    },
  },
  plugins: [
    ViteRestart({
      reload: [
          '../cms/templates/**/*',
      ],
    }),
  ],
});
```

* **`plugins.ViteRestart.reload`** - lets you specify and array of file system paths or globs to watch for changes, and issue a page refresh if any of the files change

The Vite plugin has support for enabling live refresh even through Twig error pages as you develop.

### Local Development Environment Setup

#### Using HTTPS

If you’re using TLS (https) in local dev, you may get mixed content errors if you don’t change your `devServerPublic` to `https` (and you’d need change your [server.HTTPS](https://vitejs.dev/config/#server-https) Vite config too).

Then you’ll want to ensure you have a trusted self-signed certificate for your browser, or you can use the [vite-plugin-mkcert](https://github.com/liuweiGL/vite-plugin-mkcert) plugin.

#### Using Laravel Valet

If you’re using [Laravel Valet](https://laravel.com/docs/8.x/valet) you may [run into issues](https://github.com/nystudio107/craft-vite/issues/4) with `https`. If so, you can add this config to your `vite.config.js` (see below):

```js
  server: {
    https: {
      key: fs.readFileSync('localhost-key.pem'),
      cert: fs.readFileSync('localhost.pem'),
    },
    hmr: {
      host: 'localhost',
    }
  },
```

#### Using Homestead/VM

If you’re using a VM like Homestead, to get Hot Module Replacement [(HMR) working](https://github.com/nystudio107/craft-vite/issues/3), you’ll need to add this config to your `vite.config.js` (see below):

```js
  server: {
    host: '0.0.0.0',
    watch: {
        usePolling: true,
    },
  },
```
To work inside of a VM like VirtualBox (which is typically used by Homestead) you need to enable polling.

#### Using Docker

To work properly with a Docker setup, the `server.host` needs to be set to `0.0.0.0` so that it broadcasts to all available IPv4 addresses in your `vite.config.js` (see below):

```js
  server: {
    host: '0.0.0.0',
  },
```

#### Using Nitro

Getting Vite up and running in Nitro has been problematic for some.

Since the state of the Nitro frontend development tooling is in flux, check the [Nitro Issues](https://github.com/craftcms/nitro/issues) or the `#nitro` discord channel for the latest.

You have 3 options when running Vite with Nitro:

1. Run Vite inside of the Nitro Docker container
2. Run Vite in its own Docker container, using its own separate Dockerfile
3. Run Vite locally on your computer and configure it to use a port _other_ than `3000`

Option `1` is probably the most viable, but Vite requires Node.js 14 or later, and with Nitro the Node.js version is tied to the PHP version of your site.  Also people have stated that using `nitro npm run dev` doesn’t work, but using `nitro ssh` and then running `npm run dev` from inside the container _does_ work.

Following the [Support for vite configuration](https://github.com/craftcms/nitro/issues/360) GitHub issue is likely a good idea.

If you know Docker, option `2` is a good way to go. You can see an example of how you might do it in the [craft-plugin-vite-buildchain](https://github.com/nystudio107/craft-plugin-vite-buildchain/tree/v1/buildchain) repository.

I would generally discourage option `3`, because we want to run our development tools inside of our local development environment, and not on locally on our computer.

#### Using DDEV

To run Vite inside a DDEV container, you’ll have to [define a custom service](https://ddev.readthedocs.io/en/latest/users/extend/custom-compose-files/) that proxies requests from the frontend to the vite server running inside the VM. This is done by creating a `/.ddev/docker-compose.*.yaml` file, and exposing an additional port to your project.

Create a file named `docker-compose.vite.yaml` and save it in your project’s `/.ddev` folder, with the following contents:

```yaml
# Override the web container's standard HTTP_EXPOSE and HTTPS_EXPOSE services
# to expose port `3000` of DDEV's web container.
version: '3.6'
services:
  web:
    ports:
      - '3000'
    environment:
      - HTTP_EXPOSE=${DDEV_ROUTER_HTTP_PORT}:80,${DDEV_MAILHOG_PORT}:8025,3001:3000
      - HTTPS_EXPOSE=${DDEV_ROUTER_HTTPS_PORT}:80,${DDEV_MAILHOG_HTTPS_PORT}:8025,3000:3000
```

As of this writing, DDEV automatically builds web containers with Node.js 14 installed; if you needed to change this, or simply wish to be explicit in the version to run in the VM, create a file `/.ddev/web-build/Dockerfile` with the following contents (adjust the `ENV NODE_VERSION=14` line as required):

```dockerfile
ARG BASE_IMAGE
FROM $BASE_IMAGE
ENV NODE_VERSION=14
RUN sudo apt-get remove -y nodejs
RUN curl -sSL --fail https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash -
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y -o Dpkg::Options::="--force-confold" --no-install-recommends --no-install-suggests nodejs
```

In your `vite.config.js`, the `server.host` should to be set to `0.0.0.0`, and `server.port` set to `3000`:

```js
server: {
  host: '0.0.0.0',
  port: 3000
}
```

With the above set up, Craft Vite will now have access to the `devServerInternal` via `http://localhost:3000`, and `devServerPublic` via `https://projectname.ddev.site:3000`. Note that `devServerPublic` can run over http or https, `devServerInternal` is always http. Your `config/vite.php` file might thus look like:

```php
<?php

use craft\helpers\App;

return [
	'checkDevServer' => true,
	'devServerInternal' => 'http://localhost:3000',
	'devServerPublic' => App::env('PRIMARY_SITE_URL') . ':3000',
	'serverPublic' => App::env('PRIMARY_SITE_URL') . '/dist/',
	'useDevServer' => App::env('ENVIRONMENT') === 'dev',
	// other config settings...
];
```

If you’re using the [rollup-plugin-critical](https://github.com/nystudio107/rollup-plugin-critical) to generate [critical CSS](https://nystudio107.com/blog/implementing-critical-css), you must add extra Debian packages to enable Puppeteer Headless Chrome support. Add the following line to your `/.ddev/config.yaml` file:

```yaml
webimage_extra_packages: [gconf-service, libasound2, libatk1.0-0, libcairo2, libgconf-2-4, libgdk-pixbuf2.0-0, libgtk-3-0, libnspr4, libpango-1.0-0, libpangocairo-1.0-0, libx11-xcb1, libxcomposite1, libxcursor1, libxdamage1, libxfixes3, libxi6, libxrandr2, libxrender1, libxss1, libxtst6, fonts-liberation, libappindicator1, libnss3, xdg-utils]
```

Then be sure to set `criticalUrl` to `http://localhost` as part of your rollup configuration.

### Vite-Processed Assets

This is cribbed from the [Laravel Vite integration](https://laravel-vite.netlify.app/guide/usage.html#static-assets) docs:

There is currently an [unsolved issue when referencing assets in files processed by Vite](https://github.com/vitejs/vite/issues/2196), such as a Vue or CSS file. In development, URLs will not be properly rewritten.

Additionally, there is currently no way to get the path of a Vite-processed asset (for example an image that was imported in a Vue SFC) from the back-end, since the manifest does not reference the original file path. In most cases, this should not be an issue, as this is not a common use case.

What you can do is leverage the /public [Public Directory](https://vitejs.dev/guide/assets.html#the-public-directory) for static assets in Vite, so the URLs will not get rewritten.

The basic problem is if you have a CSS rule like:
```css
background-image: url('/src/img/woof.jpg');
```

...and your local dev runs off of something like `myhost.test` then the image will be referenced as:
```
/src/img/woof.jpg
```

...which then resolves to the current host:
```
http://myhost.test/src/img/woof.jpg
```

...when what you really want is for it to be coming from the Vite dev server:
```
http://localhost:3000/src/img/woof.jpg
```

This is only a problem when you’re using Vite with a backend system like Craft CMS, where the host you run the site from is different from where the Vite dev server runs.

To work around this, as of Vite ^2.6.0 you can use the server.origin config to tell Vite to serve the static assets it builds from the Vite dev server, and not the site server:
```js
  server: {
   origin: 'http://localhost:3000', 
   host: '0.0.0.0',
}
```

This issue was [discussed in detail](https://github.com/vitejs/vite/pull/4337#issuecomment-885710791), and [fixed via a pull request](https://github.com/vitejs/vite/pull/5104) that was rolled into Vite `^2.6.0` in the form of the `origin` setting.

### Other Config

Vite uses [esbuild](https://github.com/evanw/esbuild) so it is very fast, and has built-in support for TypeScript and JSX.

Vite also comes with support for a number of [plugins](https://vitejs.dev/plugins/) that allow you to use:
* **[Vue.js 3.x](https://github.com/vitejs/vite/tree/main/packages/plugin-vue)**
* **[Vue.js 2.x](https://github.com/underfin/vite-plugin-vue2)**
* **[React fast refresh](https://github.com/vitejs/vite/tree/main/packages/plugin-react-refresh)**

You can easily use [Tailwind CSS with Vite](https://tailwindcss.com/docs/guides/vue-3-vite) as well, with or without the JIT.

Check out [Awesome Vite](https://github.com/vitejs/awesome-vite) for other great Vite plugins & resources.

## Using Vite

### JavaScript

Once the Vite plugin is installed and configured, using it is quite simple. Where you would normally link to a JavaScript file via Twig in a `<script>` tag, you instead do:

```twig
    {{ craft.vite.script("src/js/app.ts") }}
```

Note that Vite automatically also supports the direct linking to TypeScript (as in the above example), JSX, and other files via plugins. You just link directly to them, that’s it.

#### Development

If the Vite dev server is running, this will cause it to output something like this:

```html
<script type="module" src="http://localhost:3000/src/js/app.ts"></script>
```

This is causing it to get the script file from the Vite dev server, with full hot module replacement (HMR) support.

#### Production

In production or otherwise where the Vite dev server is not running, the output will look something like this:

```html
<script type="module" src="https://example.com/dist/assets/app.56c9ea9d.js" crossorigin></script>
<link href="https://example.com/dist/assets/app.c30f6458.css" rel="stylesheet" media="print" onload="this.media='all'">
```

### CSS

To use [CSS with Vite](https://vitejs.dev/guide/features.html#css), you _must_ import it in one of your `build.input` JavaScript file entries listed in the `vite.config.js`, for example:

```js
import '/src/css/app.pcss';
```

The Vite plugin will take care of automatically generating the `<link rel="stylesheet">` tag for you in production.

By default, it loads the [CSS asynchronously](https://www.filamentgroup.com/lab/load-css-simpler/), but you can configure this. See the **Other Options** section.

### Polyfills

To work properly, you must also import the [Vite Polyfill](https://vitejs.dev/config/#build-polyfilldynamicimport) in your `build.input` JavaScript file entries listed in the `vite.config.js`, for example:

```js
import "vite/dynamic-import-polyfill";
```

### Legacy

If you’re using the `vite-plugin-legacy` plugin to generate builds compatible with older browsers, the Vite plugin will automatically detect this and use the [module/nomodule](https://philipwalton.com/articles/deploying-es2015-code-in-production-today/) pattern when outputting production build tags.

The Twig code:

```twig
    {{ craft.vite.script("src/js/app.ts") }}
```

Would then result in the following output, depending on whether the Vite dev server is running:

#### Development

If the Vite dev server is running, this will cause it to output something like this:

```html
<script type="module" src="http://localhost:3000/src/js/app.ts"></script>
```

This is causing it to get the script file from the Vite dev server, with full hot module replacement (HMR) support.

#### Production

In production or otherwise where the Vite dev server is not running, the output will look something like this:

```html
<script>
    !function(){var e=document,t=e.createElement("script");if(!("noModule"in t)&&"onbeforeload"in t){var n=!1;e.addEventListener("beforeload",function(e){if(e.target===t)n=!0;else if(!e.target.hasAttribute("nomodule")||!n)return;e.preventDefault()},!0),t.type="module",t.src=".",e.head.appendChild(t),t.remove()}}();
</script>
<script type="nomodule" src="https://example.com/dist/assets/polyfills-legacy.8fce4e35.js"></script>
<script type="module" src="https://example.com/dist/assets/app.56c9ea9d.js" crossorigin></script>
<link href="https://example.com/dist/assets/app.c30f6458.css" rel="stylesheet" media="print" onload="this.media='all'">
<script type="nomodule" src="https://example.com/dist/assets/app-legacy.0c84e934.js"></script>
```

So that includes:
- Safari 10.1 [nomodule fix script](https://gist.github.com/samthor/64b114e4a4f539915a95b91ffd340acc)
- Legacy `nomodule` polyfills for dynamic imports for older browsers
- Modern `app.js` module for modern browsers
- Extracted CSS
- Legacy `app.js` script for legacy browsers

### The `.register()` function

In addition to the `craft.vite.script()` function, the Vite plugin also provides a `.register()` function:

```twig
    {{ craft.vite.register("src/js/app.ts") }}
```

This works exactly the way the `.script()` function works, but instead of outputting the tags, it _registers_ them with the `Craft::$app->getView()`.

This is primarily useful in plugins that must exist inside of the CP, or other things that leverage the Yii2 AssetBundles and dependencies.

### The `.asset()` function

The Vite plugin includes a `.asset()` function that retrieves an asset served via Vite in your templates. Assets served from Vite include images or fonts that are referenced via CSS, or are imported via JavaScript.

You pass in a relative path to the asset, just as you do for JavaScript files in Vite. For example:

```twig
    {{ craft.vite.asset("src/images/quote-open.svg") }}
```

This will return a URL like this when the Vite dev server is running:
```html
http://localhost:3000/src/assets/img/quote-open.svg
```

...and a URL like this in production when the Vite dev server is not running:
```
http://localhost:8000/dist/assets/quote-open.66b94608.svg
```

**N.B.:** this is only for assets referenced via CSS or imported via JavaScript. For other static assets, you can either put them in the [Vite public directory](https://vitejs.dev/guide/assets.html#the-public-directory) or you can use the [rollup-plugin-copy](https://github.com/vladshcherbin/rollup-plugin-copy) to copy the assets into your public `dist/` directory:

```javascript
import copy from 'rollup-plugin-copy';

export default ({ command }) => ({
   plugins: [
      copy({
         targets: [ { src: 'src/fonts/**/*', dest: '../cms/web/dist/fonts' } ],
         hook: 'writeBundle'
      }),
   ]
});
```

### The `.inline()` function

The Vite plugin also includes a `.inline()` function that inlines the contents of a local file (via path) or remote file (via URL) in your templates.

Yii2 aliases and/or environment variables may be used, and a caching layer is used so that remote files will be kept in the cache until it is cleared, for performance reasons.

URL example:

```twig
    {{ craft.vite.inline("https://example.com/my-file.txt") }}
```

Path example:

```twig
    {{ craft.vite.inline("@webroot/my-file.txt") }}
```

### The `.devServerRunning()` function

The Vite plugin has a `.devServerRunning()` function that allows you to determine if the Vite dev server is running from your Twig templates.

For instance, you could do:

```twig
{% if craft.vite.devServerRunning() %}
   <base href="{{ alias('@viteBaseUrl') }}">
{% endif %}
```

To side-step the [Vite Processed Assets](https://nystudio107.com/blog/using-vite-js-next-generation-frontend-tooling-with-craft-cms#vite-processed-assets) issue.

### The `.includeCriticalCssTags()` function

The Vite plugin includes a `.includeCriticalCssTags()` function that will look for a file in `criticalPath` that matches the name of the currently rendering template, with `criticalSuffix` appended to it.

Used in combination with the [rollup-plugin-critical](https://github.com/nystudio107/rollup-plugin-critical) plugin, this automates the inclusion of critical CSS. For example:

```twig
    {{ craft.vite.includeCriticalCssTags() }}
```

To pass in your own path to the CSS that should be included, you can do that via:

```twig
    {{ craft.vite.includeCriticalCssTags("/path/to/file.css") }}
```

...and you can also pass in attributes to be added to the `<style>` tag as well:

```twig
    {{ craft.vite.includeCriticalCssTags(null, {
         'data-css-info': 'bar',
    }) }}
```

If `null` is passed in as the first parameter, it’ll use the automatic template matching to determine the filename.

### The `.getCssHash()` function

Pass in the path to your entrypoint script, and it will return the hash of the CSS asset:

```twig
   {% set cssHash = craft.vite.getCssHash("src/js/app.ts") %}
```

If the CSS file in the manifest has the name `app.245485b3.css`, the above function will return `245485b3`.

This can be used for critical CSS patterns, for example:

```twig
{# -- Critical CSS -- #}
{#
# Use Nginx Server Sider Includes (SSI) to render different HTML depending on
# the value in the `critical-css` cookie. ref: http://nginx.org/en/docs/http/ngx_http_ssi_module.html
#}
{% set cssHash = craft.vite.getCssHash("src/js/app.ts") %}
{#
 # If the `critical-css` cookie is set, the client already has the CSS file download,
 # so don't include the critical CSS, and load the full stylesheet(s) synchronously
 #}
<!--# if expr="$HTTP_COOKIE=/critical\-css\={{ cssHash }}/" -->
{{ craft.vite.script("src/js/app.ts", false) }}
<!--# else -->
{#
# If the cookie is not set, set the cookie, then include the critical CSS for this page,
# and load the full stylesheet(s) asychronously
#}
<script>
     Cookie.set("critical-css", "{{ cssHash }}", { expires: "7D", secure: true });
</script>
{{ craft.vite.includeCriticalCssTags() }}
{{ craft.vite.script("src/js/app.ts", true) }}
<!--# endif -->
```

### Other Options

The `.script()` and `.register()` functions accept additional options as well:

```twig
    {{ craft.vite.script(PATH, ASYNC_CSS, SCRIPT_TAG_ATTRS, CSS_TAG_ATTRS) }}
```
* **`PATH`** - `string` - the path to the script
* **`ASYNC_CSS`** - `boolean` - whether any CSS should be loaded async or not (defaults to `true`)
* **`SCRIPT_TAG_ATTRS`** - `array` - an array of key-value pairs for additional attributes to add to any generated script tags
* **`CSS_TAG_ATTRS`** - `array` - an array of key-value pairs for additional attributes to add to any generated CSS link tags

So for example:
```twig
    {{ craft.vite.script(
        "src/js/app.ts",
        false,
        { 'data-script-info': 'foo' },
        { 'data-css-info': 'bar' },
    ) }}
```

## Vite Roadmap

Some things to do, and ideas for potential features:

Brought to you by [nystudio107](https://nystudio107.com)
