<?php
/**
 * Vite plugin for Craft CMS
 *
 * Allows the use of the Vite.js next generation frontend tooling with Craft CMS
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2021 nystudio107
 */

namespace nystudio107\vite\services;

use Craft;
use craft\base\Component;
use craft\helpers\Html;
use nystudio107\pluginvite\helpers\FileHelper;
use nystudio107\pluginvite\helpers\ManifestHelper;
use nystudio107\vite\models\Settings;
use nystudio107\vite\Vite;
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
        $template = Craft::$app->getView()->resolveTemplate($name ?? Vite::$templateName);
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
            $pos = strpos($name, $dirPrefix);
            if ($pos !== false) {
                $name = (string)substr_replace($name, '', $pos, strlen($dirPrefix));
            }
            $path = FileHelper::createUrl(
                    $settings->criticalPath,
                    $name
                ) . $settings->criticalSuffix;

            return $this->getCssInlineTags($path, $attributes);
        }

        return '';
    }

    /**
     * Returns the passed in CSS file at the specified file system path or URL, wrapped in
     * <style></style> tags
     *
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

    /**
     * Return the hash value for the first CSS file bundled with the module specified via $path
     *
     * @param $path
     * @return string
     */
    public function getCssHash($path): string
    {
        /** @var Settings $settings */
        $settings = Vite::$plugin->getSettings();
        ManifestHelper::fetchManifest($settings->manifestPath);
        $tags = ManifestHelper::manifestTags($path, false);
        foreach ($tags as $tag) {
            if (!empty($tag)) {
                if ($tag['type'] === 'css') {
                    // Extract only the Hash Value
                    $modulePath = pathinfo($tag['url']);
                    $moduleFilename = $modulePath['filename'];
                    $moduleHash = substr($moduleFilename, strpos($moduleFilename, '.') + 1);
                    // Vite 5 now uses a `-` to separate the version hash, so account for that as well
                    if (str_contains($moduleHash, '-')) {
                        $moduleHash = substr($moduleHash, strpos($moduleHash, '-') + 1);
                    }

                    return $moduleHash;
                }
            }
        }

        return '';
    }
}
