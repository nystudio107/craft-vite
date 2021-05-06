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
     * @var string The public URL to use when not using the dev server
     */
    public $serverPublic;

    /**
     * @var string The JavaScript entry from the manifest.json to inject on Twig error pages
     *              This can be a string or an array of strings
     */
    public $errorEntry = '';

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
                    'serverPublic',
                    'errorEntry',
                    'cacheKeySuffix',
                ],
                'string'
            ],
        ];
    }
}
