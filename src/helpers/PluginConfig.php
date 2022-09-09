<?php
/**
 * Vite plugin for Craft CMS
 *
 * Allows the use of the Vite.js next generation frontend tooling with Craft CMS
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2022 nystudio107
 */

namespace nystudio107\vite\helpers;

use Craft;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * @author    nystudio107
 * @package   Vite
 * @since     1.0.28
 */
class PluginConfig
{
    // Public static methods
    // =========================================================================

    /**
     * Return a service config definition pre-populated with settings from the
     * $configHandle config/ file
     *
     * @param string $configHandle
     * @param string $serviceClass
     * @return array
     */
    public static function serviceDefinitionFromConfig(string $configHandle, string $serviceClass): array
    {
        $serviceAttrs = [];
        // Get the available attributes from the $serviceClass
        try {
            $serviceAttrs = self::getClassAttributes($serviceClass);
        } catch (ReflectionException $e) {
            // That's fine
        }
        // Intersect the settings from the config file with the available service attributes
        $serviceConfig = array_intersect_key(
            Craft::$app->getConfig()->getConfigFromFile($configHandle),
            $serviceAttrs
        );

        return array_merge(
            $serviceConfig,
            ['class' => $serviceClass]
        );
    }

    /**
     * Return the list of attribute names from a class name
     *
     * @return array list of attribute names.
     * @throws ReflectionException
     */
    public static function getClassAttributes(string $className): array
    {
        $class = new ReflectionClass($className);
        $names = [];
        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $name = $property->getName();
                $names[$name] = $name;
            }
        }

        return $names;
    }
}
