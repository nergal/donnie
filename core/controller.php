<?php

trait Controller {
    /**
     * Create an instance to encapsulate all controller logic
     *
     * @return void
     */
    public function __construct() {
        $this->beforeAction();
        try {
            $action = Core::DI()['router']->getAction();
            $params = Core::DI()['router']->getParams();

            call_user_func_array(array(
                $this, $action
            ), $params);
        } catch (Exception $e) {
            $exception = new ReflectionClass($e);

            while ($exception) {
                $magic_exception_catcher = "catch" . $exception->getName();
                if (is_callable(array($this, $magic_exception_catcher))) {
                    call_user_func_array(array($this, $magic_exception_catcher), array($e));
                    break;
                }
                $exception = $exception->getParentClass();
            }

            if ( ! $exception) {
                throw $e;
            }
        }

        $this->afterAction();
    }

    public function beforeAction() { }
    public function afterAction() { }
}