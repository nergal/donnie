<?php

trait View {
    protected $_view = NULL;
    public function beforeAction() { }

    public function __set($variable, $value) {
        if ($variable == 'view') {
            $this->_view = new Template($value);
            $this->view = $this->_view;
            return TRUE;
        }

        return parent::__set($variable, $value);
    }

    public function afterAction() {
        if ($this->_view instanceof Template) {
            $this->_view->render();
        }
    }
}