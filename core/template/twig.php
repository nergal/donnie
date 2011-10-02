<?php

class Template_Twig extends Template {
    public function __construct($filename = NULL) {
        parent::__construct($filename);

        Loader::add('vendor.twig.lib.Twig.Autoloader');
        Twig_Autoloader::register();
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