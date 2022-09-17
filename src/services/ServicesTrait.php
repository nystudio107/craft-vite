<?php
/**
 * Vite plugin for Craft CMS
 *
 * Allows the use of the Vite.js next generation frontend tooling with Craft CMS
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2022 nystudio107
 */

namespace nystudio107\vite\services;

use craft\helpers\ArrayHelper;
use nystudio107\pluginvite\services\ViteService;
use nystudio107\vite\helpers\PluginConfig as PluginConfigHelper;
use nystudio107\vite\services\Helper as HelperService;
use yii\base\InvalidConfigException;

/**
 * @author    nystudio107
 * @package   Vite
 * @since     1.0.28
 *
 * @property  ViteService $vite
 * @property  HelperService $helper
 */
trait ServicesTrait
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        // Merge in the passed config, so it our config can be overridden by Plugins::pluginConfigs['vite']
        // ref: https://github.com/craftcms/cms/issues/1989
        $config = ArrayHelper::merge([
            'components' => [
                'helper' => HelperService::class,
                'vite' => PluginConfigHelper::serviceDefinitionFromConfig('vite', ViteService::class)
            ]
        ], $config);

        parent::__construct($id, $parent, $config);
    }

    /**
     * Returns the helper service
     *
     * @return HelperService The helper service
     * @throws InvalidConfigException
     */
    public function getHelper(): HelperService
    {
        return $this->get('helper');
    }

    /**
     * Returns the vite service
     *
     * @return ViteService The helper service
     * @throws InvalidConfigException
     */
    public function getVite(): ViteService
    {
        return $this->get('vite');
    }
}
