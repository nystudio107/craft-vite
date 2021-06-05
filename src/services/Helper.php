<?php
/**
 * Vite plugin for Craft CMS 3.x
 *
 * Allows the use of the Vite.js next generation frontend tooling with Craft CMS
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2021 nystudio107
 */

namespace nystudio107\vite\services;

use nystudio107\vite\Vite;
use nystudio107\vite\models\Settings;

use nystudio107\pluginvite\helpers\FileHelper;

use Craft;
use craft\base\Component;
use craft\helpers\Html;

use Twig\Error\LoaderError;

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
     * @return string
     * @throws LoaderError
     */
    public function getCriticalCssTags($name = null, array $attributes = []): string
    {
        // Resolve the template name
        $template = Craft::$app->getView()->resolveTemplate($name ?? Vite::$templateName ?? '');
        if ($template) {
            /** @var Settings $settings */
            $settings = Vite::$plugin->getSettings();
            $name = FileHelper::createUrl(
                pathinfo($template, PATHINFO_DIRNAME),
                pathinfo($template, PATHINFO_FILENAME)
            );
            $dirPrefix = 'templates/';
            if (defined('CRAFT_TEMPLATES_PATH')) {
                $dirPrefix = CRAFT_TEMPLATES_PATH;
            }
            $name = strstr($name, $dirPrefix);
            $name = (string)str_replace($dirPrefix, '', $name);
            $path = FileHelper::createUrl(
                    $settings->criticalPath,
                    $name
                ) . $settings->criticalSuffix;

            return $this->getCssInlineTags($path, $attributes);
        }

        return '';
    }

    /**
     * @param string $path
     * @param array $attributes additional HTML key/value pair attributes to add to the resulting tag
     *
     * @return string
     */
    public function getCssInlineTags(string $path, array $attributes = []): string
    {
        /** @var Settings $settings */
        $settings = Vite::$plugin->getSettings();
        $result = FileHelper::fetch($path, null, $settings->cacheKeySuffix);
        if ($result) {
            $config = [];

            return Html::style($result, array_merge($config, $attributes));
        }

        return '';
    }
}
