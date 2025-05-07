<?php
// app/controllers/BaseController.php

class BaseController
{
    // Load the model
    public function model($model)
    {
        // Require model file
        require_once 'app/models/' . $model . '.php';

        // Instantiate model
        return new $model();
    }

    // Load the view
    public function view($view, $data = [])
    {
        // Check for view file
        if (file_exists('app/views/' . $view . '.php')) {
            require_once 'app/views/' . $view . '.php';
        } else {
            // View does not exist
            die('View does not exist');
        }
    }

    // Redirect method
    public function redirect($url)
    {
        header('Location: ' . BASE_URL . '/' . $url);
        exit;
    }

    // Method to check if user is logged in
    public function isLoggedIn()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    // Check user role
    public function checkRole($requiredRole)
    {
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == $requiredRole) {
            return true;
        } else {
            return false;
        }
    }
}
