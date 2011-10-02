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

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

$handler = function(Exception $exception) {
    $code = uniqid();

    $styles = "
#error-{$code} p, #error-{$code} a, #error-{$code} code, #error-{$code} strong, #error-{$code} li, #error-{$code} ol,
#error-{$code} ul, #error-{$code} table, #error-{$code} tbody, #error-{$code} tfoot, #error-{$code} thead, #error-{$code} tr, #error-{$code} th,
#error-{$code} td { margin: 0; padding: 0; border: 0; font-weight: normal; font-style: normal; font-size: 100%; line-height: 1; font-family: inherit; }
#error-{$code} { font-family: \"Helvetica Neue\",Helvetica,Arial,sans-serif; font-size: 13px; font-weight: normal; line-height: 18px; color: #404040; width:80%; margin:10px auto; }
#error-{$code} .alert-message { position: relative; padding: 7px 15px; margin-bottom: 18px; color: #404040; background-color: #EEDC94; background-repeat: repeat-x; border-color: #EEDC94 #EEDC94 #E4C652; border-width: 1px; border-style: solid; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; }
#error-{$code} .label.important { background-color: #C43C35; }
#error-{$code} .label { padding: 1px 3px 2px; background-color: #BFBFBF; font-size: 9.75px; font-weight: bold; color: white; text-transform: uppercase; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; }
#error-{$code} strong { font-style: inherit; font-weight: bold; }
#error-{$code} table { width: 100%; margin-bottom: 18px; padding: 0; border-collapse: separate; font-size: 13px; border: 1px solid #DDD; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; border-spacing: 0; }
#error-{$code} table th {padding-top: 9px;font-weight: bold;vertical-align: middle;border-bottom: 1px solid #DDD; }
#error-{$code} table th, #error-{$code} table td { padding: 10px 10px 9px; line-height: 18px; text-align: left; }
#error-{$code} table tr + tr td { border-top: 1px solid #DDD; }
#error-{$code} table th + th, #error-{$code} table td + td { border-left: 1px solid #DDD; }
#error-{$code} table td { vertical-align: top; }
#error-{$code} .zebra-striped tbody tr:nth-child(odd) td { background-color: #F9F9F9; }";

    $traceline = "<td>%s</td><td>%s:%s</td><td><b>%s</b>(%s)</td>";
    $msg = array("<div class='alert-message'><span class='label important'>PHP Fatal error</span>  Uncaught <strong>%s</strong> - %s in <strong>%s:%s</strong></div>");
    $msg[] = "<table class='zebra-striped'><tr><th>#</th><th>Filename and line</th><th>Function</th></tr><tr>%s</tr></table>";

    $msg = implode("\n", $msg);

    $trace = $exception->getTrace();
    foreach ($trace as $key => $stackPoint) {
        if ( ! array_key_exists('args', $trace[$key])) {
            $trace[$key]['args'] = [];
        }

        $trace[$key]['args'] = array_map(function($item) {
            $name = gettype($item);

            if (is_string($item)) {
                $long_name = htmlentities($item);
                $short_name = substr($item, 0, 20);
                $postfix = (strlen($item) > 20) ? '&hellip;' : '';
                $short_name = htmlentities($short_name);
                $name.= ' <i title="'.$long_name.'">"'.$short_name.$postfix.'"</i>';
            } elseif (is_array($item)) {
                $name.= ' <i>['.count($item).']</i>';
            } elseif (is_object($item)) {
                $name.= ' <i>'.get_class($item).'</i>';
            } else {
                $name.= ' <i>'.((string)$item).'</i>';
            }

            return $name;
        }, $trace[$key]['args']);
    }

    $result = array();
    foreach ($trace as $key => $stackPoint) {
        foreach (['function', 'file', 'line', 'args'] as $_key) {
            if ( ! array_key_exists($_key, $stackPoint)) {
                $stackPoint[$_key] = '<i>unknown</i>';
            }
        }

        $function_name = $stackPoint['function'];
        if (isset($stackPoint['class']) AND isset($stackPoint['type'])) {
            $function_name = $stackPoint['class'].$stackPoint['type'].$function_name;
        }


        $result[] = sprintf(
            $traceline,
            $key,
            $stackPoint['file'],
            $stackPoint['line'],
            $function_name,
            implode(', ', $stackPoint['args'])
        );
    }

    $result[] = '<td>' . ++$key . '</td><td>{main}</td><td></td>';
    $msg = sprintf(
        $msg,
        get_class($exception),
        $exception->getMessage(),
        $exception->getFile(),
        $exception->getLine(),
        implode("</tr><tr>\n", $result),
        $exception->getFile(),
        $exception->getLine()
    );

    $msg = '<style>'.$styles.'</style>'.$msg;
    echo "<div id='error-{$code}'>".$msg."</div>";
};

set_exception_handler($handler);

register_shutdown_function(function() use ($handler) {
    $error = error_get_last();
    if ($error !== NULL) {
        ob_end_clean();

        $exception = new ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
        $handler($exception);
    }
});



Core::DI()['router'] = Core::DI()->share(function ($c) {
    Loader::add('singleton');
    Loader::add('router');
    return Router::instance();
});

$router = Core::DI()['router'];
Loader::autoload();
Loader::add('routing');

$router->init();

$controller_class = $router->getController();
$controller = new $controller_class;
