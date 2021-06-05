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

use nystudio107\vite\models\Settings;
use nystudio107\vite\variables\ViteVariable;

use nystudio107\pluginvite\services\ViteService;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterCacheOptionsEvent;
use craft\events\TemplateEvent;
use craft\utilities\ClearCaches;
use craft\web\twig\variables\CraftVariable;
use craft\web\View;

use yii\base\Event;

/**
 * Class Vite
 *
 * @author    nystudio107
 * @package   Vite
 * @since     1.0.0
 *
 * @property  ViteService $vite
 */
class Vite extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Vite
     */
    public static $plugin;

    /**
     * @var string
     */
    public static $templateName;

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        $config['components'] = [
            'vite' => [
                'class' => ViteService::class,
            ]
        ];

        parent::__construct($id, $parent, $config);
    }

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = false;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
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
    public function clearAllCaches()
    {
        // Clear all of Vite's caches
        $this->vite->invalidateCaches();
    }

    // Protected Methods
    // =========================================================================

    /**
     * Install our event listeners.
     */
    protected function installEventListeners()
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
            function (TemplateEvent $event) {
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
    protected function createSettingsModel()
    {
        return new Settings();
    }
}
