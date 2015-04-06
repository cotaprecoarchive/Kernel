<?php

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require 'MyApplication.php';

use Symfony\Component\HttpFoundation\Request;

$app = new MyApplication();
$app->handle(Request::createFromGlobals());
