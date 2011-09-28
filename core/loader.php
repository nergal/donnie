<?php

class Loader {
    public static function add($class_path, $strict = FALSE) {
        $includes = [
            APPLICATION_PATH,
            MODULES_PATH,
            CORE_PATH,
        ];

        $class_name = str_replace('.', '_', $class_path);
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
        throw Exception('Unable to load class');
    }
}
