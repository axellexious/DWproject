<?php
// app/helpers/url_helper.php

// Simple page redirect
function redirect($page)
{
    header('location: ' . BASE_URL . '/' . $page);
    exit;
}

// Get current URL
function getCurrentUrl()
{
    return BASE_URL . $_SERVER['REQUEST_URI'];
}

// Get base URL
function getBaseUrl()
{
    return BASE_URL;
}

// Generate URL for assets
function asset($path)
{
    return BASE_URL . '/public/' . $path;
}

// Active link helper
function isActive($path)
{
    $currentPath = $_SERVER['REQUEST_URI'];
    if (strpos($currentPath, $path) !== false) {
        return 'active';
    }
    return '';
}
