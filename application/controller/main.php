<?php

class Main_Controller {
    use Controller;
    use Template;

    public function index_action() {
        $this->template = 'index';
    }
}