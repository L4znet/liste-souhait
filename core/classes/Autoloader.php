<?php

namespace Core;

class Autoloader {

    public static function register()
    {
        spl_autoload_register(['Core\Autoloader', 'autoload']);
    }

    protected static function autoload($class_name)
    {
        $namespace_details = explode('\\', $class_name);
        $class_name = array_pop($namespace_details);
        $root = array_shift($namespace_details);
        $class_path = strtolower(implode('/', $namespace_details)) . '/' . $class_name . '.php';

        switch ($root) {

            case 'Core':
                $class_path = 'core/classes/' . $class_path;
                break;

            default:
                $class_path = strtolower($root) . '/' . $class_path;
                break;
        }

        if (file_exists($class_path)) {
            require $class_path;
        }
    }
}