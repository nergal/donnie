<?php

define('DEBUG', TRUE);

define('DOCUMENT_ROOT', dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR);
define('APPLICATION_PATH', realpath(DOCUMENT_ROOT.'../application').DIRECTORY_SEPARATOR);
define('MODULES_PATH', realpath(DOCUMENT_ROOT.'../modules').DIRECTORY_SEPARATOR);
define('CORE_PATH', realpath(DOCUMENT_ROOT.'../core').DIRECTORY_SEPARATOR);

require_once CORE_PATH.'loader.php';
Loader::add('init');
