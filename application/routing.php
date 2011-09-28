<?php

$router = Core::DI()['router'];

$router::route('/', 'main::index');