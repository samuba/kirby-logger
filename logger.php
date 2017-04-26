<?php

/**
 * Kirby Logger Plugin
 *
 * @version   1.2.0
 * @author    Sonja Broda <info@texniq.de>
 * @copyright Sonja Broda <info@texniq.de>
 * @link      https://github.com/texnixe/kirby-logger
 * @license   MIT
 */




function logger() {
  require_once(__DIR__ . DS . 'mvc' . DS . 'model.php');
  return new Kirby\Panel\Models\Logger;
}

require_once(__DIR__.DS.'lib'.DS.'hooks.php');
require_once(__DIR__ . DS . 'lib' . DS . 'helpers.php');

// Load widgets
if(site()->user() && in_array(site()->user()->role(), c::get('logger.roles', ['admin']))) {
  kirby()->set('widget', 'logger', __DIR__. DS . 'widgets' . DS . 'logger');
}

if(function_exists('panel') && $panel = panel()) {
  $panel->routes = array_merge([
    [
      'pattern' => 'logger',
      'action'  => function() {
        require 'mvc/controller.php';
        require 'mvc/model.php';

        $logger = new LoggerController;
        echo $logger->index();
      },
      'method'  => 'GET|POST'
    ],
  ], $panel->routes);
}
