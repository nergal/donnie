<?php

class Loader {
    public static function add($class_path, $strict = FALSE) {
        $includes = [
            APPLICATION_PATH,
            MODULES_PATH,
            CORE_PATH,
        ];

        $file_name = str_replace('.', DIRECTORY_SEPARATOR, $class_path).'.php';

        foreach ($includes as $path) {
            if ($full_path = realpath($path.$file_name) AND is_readable($full_path)) {
                if ($strict === TRUE) {
                    require_once $full_path;
                } else {
                    include_once $full_path;
                }
                return TRUE;
            }
        }
        throw new Exception('Unable to load class '.$class_path);
    }

    public static function autoload() {
        spl_autoload_register('Loader::__autoload', TRUE);
    }


    public static function __autoload($class_name) {
        if (class_exists($class_name) OR interface_exists($class_name)) {
            return FALSE;
        }

        $includes = [
            APPLICATION_PATH,
            MODULES_PATH,
            CORE_PATH,
            APPLICATION_PATH.'vendor'.DIRECTORY_SEPARATOR,
            MODULES_PATH.'vendor'.DIRECTORY_SEPARATOR,
            CORE_PATH.'vendor'.DIRECTORY_SEPARATOR,
        ];

        $file_name = str_replace('_', DIRECTORY_SEPARATOR, strtolower($class_name)).'.php';
        foreach ($includes as $path) {
            if ($full_path = realpath($path.$file_name) AND is_readable($full_path)) {
                require_once $full_path;
                return TRUE;
            }
        }
    }
}
