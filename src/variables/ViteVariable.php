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

use nystudio107\vite\Vite;

use nystudio107\pluginvite\variables\ViteVariableInterface;
use nystudio107\pluginvite\variables\ViteVariableTrait;

use craft\helpers\Template;

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
    public function includeCriticalCssTags($name = null, array $attributes = []): Markup
    {
        return Template::raw(
            Vite::$plugin->helper->getCriticalCssTags($name, $attributes) ?? ''
        );
    }

}
