# Vite plugin for Craft CMS 3.x

Allows the use of the Vite.js next generation frontend tooling with Craft CMS

![Screenshot](resources/img/plugin-logo.png)

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

Vite is a bridge between Craft CMS/Twig and the next generation frontend build tool Vite.js

Vite allows for Hot Module Replacement (HMR) of JavaScript, CSS, and Twig during development, and optimized production builds.

Vite supports both modern and legacy bundle builds, as per the [Deploying ES2015+ Code in Production Today](https://philipwalton.com/articles/deploying-es2015-code-in-production-today/) article.

Vite also handles generating the necessary `<script>` and `<link>` tags to support both synchronous and asynchronous loading of JavaScript and CSS.

Additionally, Twigpack has a caching layer to ensure optimal performance.

## Configuring Vite

-Insert text here-

## Using Vite

-Insert text here-

## Vite Roadmap

Some things to do, and ideas for potential features:

* Release it

Brought to you by [nystudio107](https://nystudio107.com)
