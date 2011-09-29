<?php

class Controller_Main {
    use Controller, View {
        View::beforeAction insteadof Controller;
        View::afterAction insteadof Controller;
    }

    public function action_index() {
        $this->view = 'index.php';
        $this->view->title = 'Donnie';
        $this->view->description = 'Микро-фреймворк на PHP 5.4';
    }

    public function about() {
        $this->view = 'about.php';
    }
}