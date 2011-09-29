<?php


class Template {
    protected $_variables = [];

    public function __construct($filename = NULL) {
        $this->_filename = $filename;

        Loader::add('vendor.twig.lib.Twig.Autoloader');
        Twig_Autoloader::register();
    }

    public function __get($var) {
        return $this->get($var);
    }

    public function get($var) {
        return array_key_exists($var, $this->_variables) ? $this->_variables[$var] : NULL;
    }

    public function __set($var, $value) {
        $this->set($var, $value);
    }

    public function set($var, $value) {
        $this->_variables[$var] = $value;
    }

    public function bind($var, $value) {
        $this->_variables[$var] = & $value;
    }

    public function render() {
        if ($this->_filename === NULL) {
            throw new Exception('No template filename added');
        }

        $loader = new Twig_Loader_Filesystem(APPLICATION_PATH.'templates');
        $twig = new Twig_Environment($loader);

        echo $twig->render($this->_filename, $this->_variables);
    }
}