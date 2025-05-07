<?php
// app/controllers/RegisterController.php
require_once 'app/controllers/BaseController.php';

class RegisterController extends BaseController
{
    private $userModel;
    private $facultyModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->facultyModel = $this->model('Faculty');
    }

    // Show registration form
    public function index()
    {
        // Init data
        $data = [
            'title' => 'Register',
            'userName' => '',
            'firstName' => '',
            'lastName' => '',
            'middleName' => '',
            'userEmail' => '',
            'userPassword' => '',
            'confirmPassword' => '',
            'userName_err' => '',
            'firstName_err' => '',
            'lastName_err' => '',
            'userEmail_err' => '',
            'userPassword_err' => '',
            'confirmPassword_err' => ''
        ];

        // Load view
        $this->view('auth/register', $data);
    }

    // Process registration form
    public function register()
    {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'title' => 'Register',
                'userName' => trim($_POST['userName']),
                'firstName' => trim($_POST['firstName']),
                'lastName' => trim($_POST['lastName']),
                'middleName' => isset($_POST['middleName']) ? trim($_POST['middleName']) : '',
                'userEmail' => trim($_POST['userEmail']),
                'userPassword' => trim($_POST['userPassword']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'userName_err' => '',
                'firstName_err' => '',
                'lastName_err' => '',
                'userEmail_err' => '',
                'userPassword_err' => '',
                'confirmPassword_err' => ''
            ];

            // Validate Username
            if (empty($data['userName'])) {
                $data['userName_err'] = 'Please enter username';
            } elseif (strlen($data['userName']) > 10) {
                $data['userName_err'] = 'Username must be less than 10 characters';
            }

            // Validate First Name
            if (empty($data['firstName'])) {
                $data['firstName_err'] = 'Please enter first name';
            }

            // Validate Last Name
            if (empty($data['lastName'])) {
                $data['lastName_err'] = 'Please enter last name';
            }

            // Validate Email
            if (empty($data['userEmail'])) {
                $data['userEmail_err'] = 'Please enter email';
            } else {
                // Check email
                if ($this->userModel->findUserByEmail($data['userEmail'])) {
                    $data['userEmail_err'] = 'Email is already taken';
                }
            }

            // Validate Password
            if (empty($data['userPassword'])) {
                $data['userPassword_err'] = 'Please enter password';
            } elseif (strlen($data['userPassword']) < 6) {
                $data['userPassword_err'] = 'Password must be at least 6 characters';
            }

            // Validate Confirm Password
            if (empty($data['confirmPassword'])) {
                $data['confirmPassword_err'] = 'Please confirm password';
            } else {
                if ($data['userPassword'] != $data['confirmPassword']) {
                    $data['confirmPassword_err'] = 'Passwords do not match';
                }
            }

            // Make sure errors are empty
            if (
                empty($data['userName_err']) && empty($data['firstName_err']) && empty($data['lastName_err']) &&
                empty($data['userEmail_err']) && empty($data['userPassword_err']) && empty($data['confirmPassword_err'])
            ) {

                // Hash Password
                $data['userPassword'] = password_hash($data['userPassword'], PASSWORD_DEFAULT);

                // Register User
                $userData = [
                    'username' => $data['userName'],
                    'password' => $data['userPassword'],
                    'email' => $data['userEmail'],
                    'role' => 2 // 2 = Faculty
                ];

                $userId = $this->userModel->register($userData);

                if ($userId) {
                    // Create faculty profile
                    $facultyData = [
                        'user_id' => $userId,
                        'first_name' => $data['firstName'],
                        'last_name' => $data['lastName'],
                        'middle_name' => $data['middleName']
                    ];

                    if ($this->facultyModel->create($facultyData)) {
                        flash('register_success', 'You are now registered and can log in');
                        $this->redirect('auth/login');
                    } else {
                        die('Something went wrong with creating faculty profile');
                    }
                } else {
                    die('Something went wrong with registration');
                }
            } else {
                // Load view with errors
                $this->view('auth/register', $data);
            }
        } else {
            // Redirect to registration form
            $this->redirect('register');
        }
    }
}
