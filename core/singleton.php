<?php

/**
 * Реализация паттерна Singleton
 *
 * @trait
 * @author Nergal
 * @package core
 */
trait Singleton {
    /**
     * @Singleton
     */
    protected static $_instance = NULL;

    /**
     * @constructor
     * @private
     * @use parent
     */
    private function __construct() { }

    /**
     * @private
     * @use parent
     * @return mixed
     */
    private function __clone() { }

    /**
     * Выбор инстанции класса
     *
     * @static
     * @return Singleton
     */
    public static function instance() {
        if (self::$_instance == NULL) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * Сброс инстанции
     *
     * @static
     * @return void
     */
    public static function reset() {
        self::$_instance = NULL;
    }
}