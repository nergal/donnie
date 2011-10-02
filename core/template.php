<?php


class Template {
    protected $_variables = [];

    public function __construct($filename = NULL) {
        $this->_filename = $filename;
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

        ob_start();
        extract($this->_variables);
        include_once APPLICATION_PATH.'templates/'.$this->_filename;
        $html = ob_get_clean();

        echo $html;
    }
}