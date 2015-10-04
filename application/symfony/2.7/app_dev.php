<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
umask(0000);

function checkAllowedIp($remoteAddress)
{
    if (in_array($remoteAddress, array('127.0.0.1', 'fe80::1', '::1'))) {
        return true;
    }

    $matches = array();
    if (preg_match('/([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})/', $remoteAddress, $matches) === 1) {
        for ($i = 1; $i < 5; $i++) {
            $matches[$i] = (int)$matches[$i];
        }
        // localhost
        if ($matches[1] === 127) {
            return true;
        }
        if ($matches[1] === 10) {
            return true;
        }
        if ($matches[1] === 172 && $matches[2] >= 16 && $matches[2] <= 31) {
            return true;
        }
        if ($matches[1] === 192 && $matches[2] === 168) {
            return true;
        }
    }
}

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !(checkAllowedIp($_SERVER['REMOTE_ADDR']) || php_sapi_name() === 'cli-server')
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
