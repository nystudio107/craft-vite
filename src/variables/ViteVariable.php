<?php
/**
 * Vite plugin for Craft CMS 3.x
 *
 * Allows the use of the Vite.js next generation frontend tooling with Craft CMS
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2021 nystudio107
 */

namespace nystudio107\vite\variables;

use craft\helpers\Template;
use nystudio107\vite\Vite;

use Craft;
use Twig\Markup;

/**
 * @author    nystudio107
 * @package   Vite
 * @since     1.0.0
 */
class ViteVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Return the appropriate tags to load the Vite script, either via the dev server or
     * extracting it from the manifest.json file
     *
     * @param string $path
     * @param bool $asyncCss
     * @param array $scriptTagAttrs
     * @param array $cssTagAttrs
     *
     * @return Markup
     */
    public function script(string $path, bool $asyncCss = true, array $scriptTagAttrs = [], array $cssTagAttrs = []): Markup
    {
        return Template::raw(
            Vite::$plugin->vite->script($path, $asyncCss, $scriptTagAttrs, $cssTagAttrs)
        );
    }

    /**
     * Register the appropriate tags to the Craft View to load the Vite script, either via the dev server or
     * extracting it from the manifest.json file
     *
     * @param string $path
     * @param bool $asyncCss
     * @param array $scriptTagAttrs
     * @param array $cssTagAttrs
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function register(string $path, bool $asyncCss = true, array $scriptTagAttrs = [], array $cssTagAttrs = []): string
    {
        Vite::$plugin->vite->register($path, $asyncCss, $scriptTagAttrs, $cssTagAttrs);

        return Template::raw('');
    }
}
