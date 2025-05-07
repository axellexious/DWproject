<?php
// app/controllers/DashboardController.php
require_once 'app/controllers/BaseController.php';

class DashboardController extends BaseController
{
    private $tosModel;
    private $courseModel;
    private $facultyModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }

        $this->tosModel = $this->model('TOS');
        $this->courseModel = $this->model('Course');
        $this->facultyModel = $this->model('Faculty');
    }

    // Dashboard index
    public function index()
    {
        // Get counts for dashboard
        $data = [
            'title' => 'Dashboard'
        ];

        // Get TOS count
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) { // Admin
            $tosFiles = $this->tosModel->getAllTOS();
        } else { // Faculty
            $tosFiles = $this->tosModel->getTOSByFaculty($_SESSION['profile_id']);
        }

        $data['tos_count'] = count($tosFiles);

        // Get courses count
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) { // Admin
            $courses = $this->courseModel->getAllCourses();
        } else { // Faculty
            $courses = $this->courseModel->getCoursesByFaculty($_SESSION['profile_id']);
        }

        $data['course_count'] = count($courses);

        // Get recent uploads (last 5)
        $data['recent_tos'] = array_slice($tosFiles, 0, 5);

        $this->view('dashboard/index', $data);
    }
}
