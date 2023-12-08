<?php
/**
 * Vite plugin for Craft CMS
 *
 * Allows the use of the Vite.js next generation frontend tooling with Craft CMS
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2021 nystudio107
 */

namespace nystudio107\vite\models;

use craft\base\Model;

/**
 * @author    nystudio107
 * @package   Vite
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var bool Should the dev server be used for?
     */
    public $useDevServer;

    /**
     * @var string File system path (or URL) to the Vite-built manifest.json
     */
    public $manifestPath;

    /**
     * @var string The public URL to the dev server (what appears in `<script src="">` tags
     */
    public $devServerPublic;

    /**
     * @var string The public URL to use when not using the dev server
     */
    public $serverPublic;

    /**
     * @var string|array The JavaScript entry from the manifest.json to inject on Twig error pages
     *              This can be a string or an array of strings
     */
    public $errorEntry = '';

    /**
     * @var string String to be appended to the cache key
     */
    public $cacheKeySuffix = '';

    /**
     * @var string The internal URL to the dev server, when accessed from the environment in which PHP is executing
     *              This can be the same as `$devServerPublic`, but may be different in containerized or VM setups.
     *              ONLY used if $checkDevServer = true
     */
    public $devServerInternal;

    /**
     * @var bool Should we check for the presence of the dev server by pinging $devServerInternal to make sure it's running?
     */
    public $checkDevServer = false;

    /**
     * @var bool Whether the react-refresh-shim should be included
     */
    public $includeReactRefreshShim = false;

    /**
     * @var bool Whether the modulepreload-polyfill shim should be included
     */
    public $includeModulePreloadShim = true;

    /**
     * @var string File system path (or URL) to where the Critical CSS files are stored
     */
    public $criticalPath = '';

    /**
     * @var string the suffix added to the name of the currently rendering template for the critical css file name
     */
    public $criticalSuffix = '_critical.min.css';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'useDevServer',
                    'checkDevServer',
                    'includeReactRefreshShim',
                    'includeModulePreloadShim',
                ],
                'boolean'
            ],
            [
                [
                    'manifestPath',
                    'devServerPublic',
                    'serverPublic',
                    'cacheKeySuffix',
                    'devServerInternal',
                ],
                'string'
            ],
            [
                [
                    'errorEntry',
                ],
                'safe'
            ],
        ];
    }
}
