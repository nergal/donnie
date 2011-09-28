<?php

class Core {
    protected static $_di = NULL;

    public static function di() {
        if (self::$_di === NULL) {
            Loader::add('pimple');
            self::$_di = new Pimple;
        }

        return self::$_di;
    }
}
