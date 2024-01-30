<?php
/**
 * Vite plugin for Craft CMS
 *
 * Allows the use of the Vite.js next generation frontend tooling with Craft CMS
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2021 nystudio107
 */

namespace nystudio107\vite;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\events\RegisterCacheOptionsEvent;
use craft\events\TemplateEvent;
use craft\utilities\ClearCaches;
use craft\web\twig\variables\CraftVariable;
use craft\web\View;
use nystudio107\vite\models\Settings;
use nystudio107\vite\services\ServicesTrait;
use nystudio107\vite\variables\ViteVariable;
use yii\base\Event;

/**
 * Class Vite
 *
 * @author    nystudio107
 * @package   Vite
 * @since     1.0.0
 */
class Vite extends Plugin
{
    // Traits
    // =========================================================================

    use ServicesTrait;

    // Static Properties
    // =========================================================================

    /**
     * @var Vite
     */
    public static Plugin $plugin;

    /**
     * @var string
     */
    public static string $templateName;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public string $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public bool $hasCpSettings = false;

    /**
     * @var bool
     */
    public bool $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;
        // Add our event listeners
        $this->installEventListeners();
        // Log that the plugin has loaded
        Craft::info(
            Craft::t(
                'vite',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    /**
     * Clear all the caches!
     */
    public function clearAllCaches(): void
    {
        // Clear all of Vite's caches
        $this->vite->invalidateCaches();
    }

    // Protected Methods
    // =========================================================================

    /**
     * Install our event listeners.
     */
    protected function installEventListeners(): void
    {
        // Register our variable
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('vite', [
                    'class' => ViteVariable::class,
                    'viteService' => $this->vite,
                ]);
            }
        );
        // Handler: ClearCaches::EVENT_REGISTER_CACHE_OPTIONS
        Event::on(
            ClearCaches::class,
            ClearCaches::EVENT_REGISTER_CACHE_OPTIONS,
            function(RegisterCacheOptionsEvent $event) {
                Craft::debug(
                    'ClearCaches::EVENT_REGISTER_CACHE_OPTIONS',
                    __METHOD__
                );
                // Register our caches for the Clear Cache Utility
                $event->options = array_merge(
                    $event->options,
                    $this->customAdminCpCacheOptions()
                );
            }
        );
        // Remember the name of the currently rendering template
        // Handler: View::EVENT_BEFORE_RENDER_PAGE_TEMPLATE
        Event::on(
            View::class,
            View::EVENT_BEFORE_RENDER_PAGE_TEMPLATE,
            static function(TemplateEvent $event) {
                self::$templateName = $event->template;
            }
        );
    }

    /**
     * Returns the custom Control Panel cache options.
     *
     * @return array
     */
    protected function customAdminCpCacheOptions(): array
    {
        return [
            // Manifest cache
            [
                'key' => 'vite-file-cache',
                'label' => Craft::t('vite', 'Vite Cache'),
                'action' => [$this, 'clearAllCaches'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }
}
