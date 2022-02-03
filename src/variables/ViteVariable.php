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
use nystudio107\pluginvite\variables\ViteVariableInterface;
use nystudio107\pluginvite\variables\ViteVariableTrait;
use nystudio107\vite\Vite;
use Twig\Error\LoaderError;
use Twig\Markup;

/**
 * @author    nystudio107
 * @package   Vite
 * @since     1.0.5
 */
class ViteVariable implements ViteVariableInterface
{
    use ViteVariableTrait;

    /**
     * Returns the Critical CSS file for $template wrapped in <style></style>
     * tags
     *
     * @param null|string $name
     * @param array $attributes additional HTML key/value pair attributes to add to the resulting tag
     *
     * @return Markup
     * @throws LoaderError
     */
    public function includeCriticalCssTags(?string $name = null, array $attributes = []): Markup
    {
        return Template::raw(
            Vite::$plugin->helper->getCriticalCssTags($name, $attributes) ?? ''
        );
    }

    /**
     * Return the hash value for the first CSS file bundled with the module specified via $path
     *
     * @param $path
     * @return Markup
     */
    public function getCssHash($path): Markup
    {
        return Template::raw(
            Vite::$plugin->helper->getCssHash($path) ?? ''
        );
    }
}
