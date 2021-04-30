<?php
/**
 * Vite plugin for Craft CMS 3.x
 *
 * Allows the use of the Vite.js next generation frontend tooling with Craft CMS
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2021 nystudio107
 */

namespace nystudio107\vite\models;

use nystudio107\vite\Vite;

use Craft;
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
     * @var string The internal URL to the dev server, when accessed from the environment in which PHP is executing
     *              This can be the same as `$devServerPublic`, but may be different in containerized or VM setups
     */
    public $devServerInternal;

    /**
     * @var string The public URL to use when not using the dev server
     */
    public $serverPublic;

    /**
     * @var string String to be appended to the cache key
     */
    public $cacheKeySuffix = '';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['useDevServer', 'boolean'],
            [
                [
                    'manifestPath',
                    'devServerPublic',
                    'devServerInternal',
                    'serverPublic',
                    'cacheKeySuffix',
                ],
                'string'
            ],
        ];
    }
}
