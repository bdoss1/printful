<?php

namespace App\Helpers;
/**
 * Class MultiTenant
 * 
 * @package App\Helpers
 */
class Multitenant
{
    /**
     * Retrieve class based on given path for organization
     */
    protected static function resolve($class, $path)
    {  
        /*
         *  Similar to migrations and views always separate models for the current Project and the Core one!
         */
        if (class_exists($path . 'Project\\' . $class)) {
            return $path . 'Project\\' . $class;
        }
        return $path . 'Core\\' . $class;
    }

    /**
     * Retrieve service class for organization
     */
    public static function getService($class)
    {
        return self::resolve($class, 'App\Services\\');
    }

    /**
     * Retrieve model class for organization
     */
    public static function getModel($class)
    {
        return self::resolve($class, 'App\Models\\');
    }
}