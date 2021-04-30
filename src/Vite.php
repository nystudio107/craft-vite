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

use craft\events\RegisterCacheOptionsEvent;
use craft\utilities\ClearCaches;
use nystudio107\vite\services\Connector as ConnectorService;
use nystudio107\vite\variables\ViteVariable;
use nystudio107\vite\twigextensions\ViteTwigExtension;
use nystudio107\vite\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * Class Vite
 *
 * @author    nystudio107
 * @package   Vite
 * @since     1.0.0
 *
 * @property  ConnectorService $connector
 */
class Vite extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Vite
     */
    public static $plugin;

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        $config['components'] = [
            'connector' => [
                'class' => ConnectorService::class,
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

        // Configure our connector service with the settings
        $settings = $this->getSettings();
        if ($settings) {
            $settingsAttrs = $settings->getAttributes();
            $connectorAttrs = $this->connector->getAttributes();
            Craft::configure($this->connector, array_intersect_key(
                $settingsAttrs,
                $connectorAttrs
            ));
        }
        // Register our Twig extension
        Craft::$app->view->registerTwigExtension(new ViteTwigExtension());
        // Register our variable
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('vite', ViteVariable::class);
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

        $this->connector->devServerRunning();
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
        self::$plugin->connector->invalidateCaches();
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
                'key' => 'twigpack-manifest-cache',
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
