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

Core::DI()['router'] = Core::DI()->share(function ($c) {
    Loader::add('vendor.moor.Moor');
    $ref  = new ReflectionClass(Moor);
    $self = $ref->newInstanceWithoutConstructor() ;

    return $self;
});

Loader::add('routing');
$router = Core::DI()['router'];
$router::run();