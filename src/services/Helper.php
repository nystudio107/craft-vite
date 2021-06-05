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

use craft\base\Component;
use nystudio107\pluginvite\variables\ViteVariableInterface;
use nystudio107\pluginvite\variables\ViteVariableTrait;

use craft\helpers\Template;

use Twig\Markup;

/**
 * @author    nystudio107
 * @package   Vite
 * @since     1.0.5
 */
class Helper extends Component
{
    /**
     * Returns the Critical CSS file for $template wrapped in <style></style>
     * tags
     *
     * @param null|string $name
     * @param array $attributes additional HTML key/value pair attributes to add to the resulting tag
     *
     * @return Markup
     * @throws \Twig\Error\LoaderError
     */
    public function includeCriticalCssTags($name = null, array $attributes = []): Markup
    {
        // Resolve the template name
        $template = Craft::$app->getView()->resolveTemplate($name ?? Twigpack::$templateName ?? '');
        if ($template) {
            $name = self::combinePaths(
                pathinfo($template, PATHINFO_DIRNAME),
                pathinfo($template, PATHINFO_FILENAME)
            );
            $dirPrefix = 'templates/';
            if (defined('CRAFT_TEMPLATES_PATH')) {
                $dirPrefix = CRAFT_TEMPLATES_PATH;
            }
            $name = strstr($name, $dirPrefix);
            $name = (string)str_replace($dirPrefix, '', $name);
            $path = self::combinePaths(
                    $config['localFiles']['basePath'],
                    $config['localFiles']['criticalPrefix'],
                    $name
                ) . $config['localFiles']['criticalSuffix'];

            return self::getCssInlineTags($path, $attributes);
        }

        return '';

        return Template::raw(
            Twigpack::$plugin->manifest->getCriticalCssTags($name, null, $attributes) ?? ''
        );
    }

    /**
     * Combined the passed in paths, whether file system or URL
     *
     * @param string ...$paths
     *
     * @return string
     */
    protected function combinePaths(string ...$paths): string
    {
        $last_key = count($paths) - 1;
        array_walk($paths, function (&$val, $key) use ($last_key) {
            switch ($key) {
                case 0:
                    $val = rtrim($val, '/ ');
                    break;
                case $last_key:
                    $val = ltrim($val, '/ ');
                    break;
                default:
                    $val = trim($val, '/ ');
                    break;
            }
        });

        $first = array_shift($paths);
        $last = array_pop($paths);
        $paths = array_filter($paths);
        array_unshift($paths, $first);
        $paths[] = $last;

        return implode('/', $paths);
    }

}
