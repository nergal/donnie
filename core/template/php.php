<?php

class Template_Php extends Template {
    protected $_blocks = array();
    protected $_blocks_stack = array();
    protected $_extends = NULL;

    public function extend($file) {
        $this->_extends = $file;
    }

    protected function capture($filename, array $view_data) {
        extract($view_data, EXTR_SKIP);

        ob_start();
        try {
            include APPLICATION_PATH.'templates/'.$filename;
        } catch (Exception $e) {
            ob_end_clean();
            throw $e;
        }

        return ob_get_clean();
    }

    public function block($name, $content = NULL) {
        if (array_search($name, $this->_blocks_stack) !== FALSE) {
            throw new Exception('View '.$this->_filename.' already collect block '.$name);
        }

        $this->_blocks_stack[] = $name;
        ob_start();

        return empty($this->_blocks[$name]);
    }

    public function endblock($name = NULL) {
        $last = array_pop($this->_blocks_stack);

        if ($name AND $name !== $last) {
            throw new Expcetion('Wrong block order. '.$last.' expected, but '.$name.' given');
        }

        if (empty($this->_blocks[$name])) {
            $this->_blocks[$name] = ob_get_flush();
        } else {
            ob_end_clean();
            echo $this->_blocks[$name];
        }
    }

    public function blocks() {
        return $this->_blocks;
    }

    public function render() {
        if ($this->_filename === NULL) {
            throw new Exception('No template filename added');
        }

        $result = $this->capture($this->_filename, $this->_variables);
        $processed = [$this->_filename => TRUE,];

        while ($this->_extends) {
            $this->_filename = $this->_extends;
            $this->_extends = NULL;

            if (isset($processed[$this->_filename])) {
                throw new Exception('View recursion extend');
            }

            $result = $this->capture($this->_filename, $this->_variables);
            $processed[$this->_filename] = TRUE;
        }

        echo $result;
    }
}