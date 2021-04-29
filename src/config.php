<?php
/**
 * Vite plugin for Craft CMS 3.x
 *
 * Allows the use of the Vite.js next generation frontend tooling with Craft CMS
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2021 nystudio107
 */

/**
 * Vite config.php
 *
 * This file exists only as a template for the Vite settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'vite.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [

   /**
    * Should the dev server be used for?
    *
    * @var bool
    */
    'useDevServer' => true,

    /**
     * File system path (or URL) to the Vite-built manifest.json
     *
     * @var string
     */
    'manifestPath' => '@webroot/dist/manifest.json',

    /**
     * The public URL to the dev server (what appears in `<script src="">` tags
     *
     * @var string
     */
    'devServerPublic' => 'http://localhost:3000/',

    /**
     * The internal URL to the dev server, when accessed from the environment in which PHP is executing
     * This can be the same as `$devServerPublic`, but may be different in containerized or VM setups
     *
     * @var string
     */
    'devServerInternal' => 'http://craft-vite-buildchain:3000/',

    /**
     * The public URL to use when not using the dev server
     *
     * @var string
     */
    'serverPublic' => 'http://localhost:8000/dist/',
];
