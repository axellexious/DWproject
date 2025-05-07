<?php
// public/index.php

// Load config
require_once '../app/config/config.php';

// Load helpers
require_once '../app/helpers/session_helper.php';
require_once '../app/helpers/url_helper.php';
require_once '../app/helpers/file_helper.php';

// Autoload Core Classes
spl_autoload_register(function ($className) {
    if (file_exists('../app/controllers/' . $className . '.php')) {
        require_once '../app/controllers/' . $className . '.php';
    } elseif (file_exists('../app/models/' . $className . '.php')) {
        require_once '../app/models/' . $className . '.php';
    }
});

// Simple Router
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = explode('/', filter_var($url, FILTER_SANITIZE_URL));

// Default controller and method
$currentController = !empty($url[0]) ? ucwords($url[0]) . 'Controller' : 'DashboardController';
$currentMethod = !empty($url[1]) ? $url[1] : 'index';

// If controller file doesn't exist, use Error controller
if (!file_exists('../app/controllers/' . $currentController . '.php')) {
    $currentController = 'ErrorController';
    $currentMethod = 'index';
}

// Instantiate controller class
require_once '../app/controllers/' . $currentController . '.php';
$controller = new $currentController;

// Check if method exists in controller
if (!method_exists($controller, $currentMethod)) {
    $currentMethod = 'index';
}

// Get params
$params = array_slice($url, 2);

// Call method with params
call_user_func_array([$controller, $currentMethod], $params);
