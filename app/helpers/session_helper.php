<?php
// app/helpers/session_helper.php

session_start();

// Flash message helper
// EXAMPLE - flash('register_success', 'You are now registered');
// DISPLAY IN VIEW - echo flash('register_success');
function flash($name = '', $message = '', $class = 'alert alert-success')
{
    if (!empty($name)) {
        // Create flash message
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            // Display flash message
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

// Check if user is logged in
function isLoggedIn()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

// Check user role
function isAdmin()
{
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) {
        return true;
    } else {
        return false;
    }
}

// Get current user ID
function getCurrentUserId()
{
    return $_SESSION['user_id'] ?? null;
}

// Get current user profile ID
function getCurrentProfileId()
{
    return $_SESSION['profile_id'] ?? null;
}

// Get current user name
function getCurrentUserName()
{
    return $_SESSION['full_name'] ?? $_SESSION['user_name'] ?? 'User';
}
