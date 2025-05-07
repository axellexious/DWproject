<?php
// app/controllers/AuthController.php
require_once 'BaseController.php';

class AuthController extends BaseController
{
    private $userModel;
    private $facultyModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->facultyModel = $this->model('Faculty');
    }

    // Show login form
    public function login()
    {
        // Check if user is already logged in
        if ($this->isLoggedIn()) {
            $this->redirect('dashboard');
        }

        // Check if login form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'userEmail' => trim($_POST['userEmail']),
                'userPassword' => trim($_POST['userPassword']),
                'email_err' => '',
                'password_err' => ''
            ];

            // Validate email
            if (empty($data['userEmail'])) {
                $data['email_err'] = 'Please enter email';
            }

            // Validate password
            if (empty($data['userPassword'])) {
                $data['password_err'] = 'Please enter password';
            }

            // Check for errors
            if (empty($data['email_err']) && empty($data['password_err'])) {
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['userEmail'], $data['userPassword']);

                if ($loggedInUser) {
                    // Create session
                    $this->createUserSession($loggedInUser);
                    $this->redirect('dashboard');
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('auth/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('auth/login', $data);
            }
        } else {
            // Init data
            $data = [
                'userEmail' => '',
                'userPassword' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            // Load view
            $this->view('auth/login', $data);
        }
    }

    // Create user session
    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user['userID'];
        $_SESSION['user_email'] = $user['userEmail'];
        $_SESSION['user_name'] = $user['userName'];
        $_SESSION['user_role'] = $user['userRole'];

        // Get faculty profile if exists
        $faculty = $this->facultyModel->getFacultyByUserId($user['userID']);
        if ($faculty) {
            $_SESSION['profile_id'] = $faculty['profileID'];
            $_SESSION['full_name'] = $faculty['firstName'] . ' ' . $faculty['lastName'];
        }
    }

    // Logout and destroy session
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        unset($_SESSION['profile_id']);
        unset($_SESSION['full_name']);

        session_destroy();
        $this->redirect('auth/login');
    }
}
