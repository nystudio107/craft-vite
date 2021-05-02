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

use nystudio107\vite\services\Vite as ViteService;
use nystudio107\vite\variables\ViteVariable;
use nystudio107\vite\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterCacheOptionsEvent;
use craft\utilities\ClearCaches;
use craft\web\Application;
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
        // delay attaching event handler to the view component after it is fully configured
        $app = Craft::$app;
        if ($app->getConfig()->getGeneral()->devMode) {
            $app->on(Application::EVENT_BEFORE_REQUEST, function () use ($app) {
                $app->getView()->on(View::EVENT_END_BODY, [$this, 'injectErrorEntry']);
            });
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
        $this->vite::invalidateCaches();
    }

    // Protected Methods
    // =========================================================================

    /**
     * Inject the error entry point JavaScript for auto-reloading of Twig error
     * pages
     */
    protected function injectErrorEntry()
    {
        $response = Craft::$app->getResponse();
        if ($response->isServerError || $response->isClientError) {
            $settings = $this->getSettings();
            /** @var Settings $settings */
            if (!empty($settings->errorEntry) && $settings->useDevServer) {
                try {
                    $errorEntry = $settings->errorEntry;
                    if (is_string($errorEntry)) {
                        $errorEntry = [$errorEntry];
                    }
                    foreach ($errorEntry as $entry) {
                        $tag = $this->vite->script($entry);
                        if ($tag !== null) {
                            echo $tag;
                        }
                    }
                } catch (\Throwable $e) {
                    // That's okay, Vite will have already logged the error
                }
            }
        }
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
