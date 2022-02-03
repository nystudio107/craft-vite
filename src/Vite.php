<?php
/**
 * Vite plugin for Craft CMS 3.x
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
use nystudio107\pluginvite\services\ViteService;
use nystudio107\vite\models\Settings;
use nystudio107\vite\services\Helper as HelperService;
use nystudio107\vite\variables\ViteVariable;
use yii\base\Event;

/**
 * Class Vite
 *
 * @author    nystudio107
 * @package   Vite
 * @since     1.0.0
 *
 * @property  ViteService $vite
 * @property  HelperService $helper
 */
class Vite extends Plugin
{
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

    // Static Methods
    // =========================================================================
    /**
     * @var string
     */
    public string $schemaVersion = '1.0.0';

    // Public Properties
    // =========================================================================
    /**
     * @var bool
     */
    public bool $hasCpSettings = false;
    /**
     * @var bool
     */
    public bool $hasCpSection = false;

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        $config['components'] = [
            'helper' => HelperService::class,
            'vite' => [
                'class' => ViteService::class,
            ]
        ];

        parent::__construct($id, $parent, $config);
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;
        // Configure our Vite service with the settings
        $settings = $this->getSettings();
        if ($settings) {
            $settingsAttrs = $settings->getAttributes();
            $viteAttrs = $this->vite->getAttributes();
            Craft::configure($this->vite, array_intersect_key(
                $settingsAttrs,
                $viteAttrs
            ));
        }
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
     * Install our event listeners.
     */
    protected function installEventListeners(): void
    {
        // Register our variable
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
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
            function (RegisterCacheOptionsEvent $event) {
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
            static function (TemplateEvent $event) {
                self::$templateName = $event->template;
            }
        );

    }

    // Protected Methods
    // =========================================================================

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
     * Clear all the caches!
     */
    public function clearAllCaches(): void
    {
        // Clear all of Vite's caches
        $this->vite->invalidateCaches();
    }

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }
}
