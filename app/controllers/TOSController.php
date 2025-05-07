<?php
// app/controllers/TOSController.php
require_once 'BaseController.php';

class TOSController extends BaseController
{
    private $tosModel;
    private $topicModel;
    private $testTypeModel;
    private $courseModel;
    private $programModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }

        $this->tosModel = $this->model('TOS');
        $this->topicModel = $this->model('Topic');
        $this->testTypeModel = $this->model('TestType');
        $this->courseModel = $this->model('Course');
        $this->programModel = $this->model('Program');
    }

    // Show all TOS files
    public function index()
    {
        // Get all TOS entries or filtered by faculty if not admin
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) { // Admin
            $tosFiles = $this->tosModel->getAllTOS();
        } else { // Faculty
            $tosFiles = $this->tosModel->getTOSByFaculty($_SESSION['profile_id']);
        }

        // Get filter parameters
        $courses = $this->courseModel->getAllCourses();
        $testTypes = $this->testTypeModel->getAllTestTypes();

        $data = [
            'tosFiles' => $tosFiles,
            'courses' => $courses,
            'testTypes' => $testTypes
        ];

        $this->view('tos/index', $data);
    }

    // Show upload form
    public function upload()
    {
        // Get form data for dropdowns
        $topics = $this->topicModel->getAllTopics();
        $testTypes = $this->testTypeModel->getAllTestTypes();
        $courses = $this->courseModel->getAllCourses();

        $data = [
            'topics' => $topics,
            'testTypes' => $testTypes,
            'courses' => $courses,
            'topic_id' => '',
            'test_type_id' => '',
            'topic_id_err' => '',
            'test_type_id_err' => '',
            'file_err' => ''
        ];

        $this->view('tos/upload', $data);
    }

    // Process file upload
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Initialize data
            $data = [
                'topic_id' => trim($_POST['topic_id']),
                'test_type_id' => trim($_POST['test_type_id']),
                'topic_id_err' => '',
                'test_type_id_err' => '',
                'file_err' => ''
            ];

            // Validate topic
            if (empty($data['topic_id'])) {
                $data['topic_id_err'] = 'Please select a topic';
            }

            // Validate test type
            if (empty($data['test_type_id'])) {
                $data['test_type_id_err'] = 'Please select a test type';
            }

            // Check if file was uploaded
            if (!isset($_FILES['tosFile']) || $_FILES['tosFile']['error'] == UPLOAD_ERR_NO_FILE) {
                $data['file_err'] = 'Please select a file to upload';
            } else {
                $file = $_FILES['tosFile'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];

                // Get file extension
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Check if extension is allowed
                $allowed = ALLOWED_DOC_FORMATS;

                if (!in_array($fileExt, $allowed)) {
                    $data['file_err'] = 'Only DOC, DOCX, XLS, and XLSX files are allowed';
                }

                // Check file size (5MB max)
                if ($fileSize > 5000000) {
                    $data['file_err'] = 'File is too large (max 5MB)';
                }

                // Check for upload errors
                if ($fileError !== 0) {
                    $data['file_err'] = 'Error uploading file';
                }
            }

            // Check for errors before uploading
            if (empty($data['topic_id_err']) && empty($data['test_type_id_err']) && empty($data['file_err'])) {
                // Read file content as binary
                $fileContent = file_get_contents($_FILES['tosFile']['tmp_name']);

                // Prepare data for TOS model
                $tosData = [
                    'topic_id' => $data['topic_id'],
                    'test_type_id' => $data['test_type_id'],
                    'tos_file' => $fileContent
                ];

                // Create TOS entry
                if ($this->tosModel->create($tosData)) {
                    // Success
                    flash('tos_message', 'File uploaded successfully');
                    $this->redirect('tos');
                } else {
                    // Error
                    die('Something went wrong');
                }
            } else {
                // Get form data for dropdowns
                $topics = $this->topicModel->getAllTopics();
                $testTypes = $this->testTypeModel->getAllTestTypes();
                $courses = $this->courseModel->getAllCourses();

                $data['topics'] = $topics;
                $data['testTypes'] = $testTypes;
                $data['courses'] = $courses;

                // Load view with errors
                $this->view('tos/upload', $data);
            }
        } else {
            // Redirect to upload form
            $this->redirect('tos/upload');
        }
    }

    // Download TOS file
    public function download($id)
    {
        // Get TOS entry
        $tos = $this->tosModel->getTOSById($id);

        if ($tos) {
            // Set headers for download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="TOS_' . $id . '.docx"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');

            // Output file content
            echo $tos['tosFile'];
            exit;
        } else {
            // File not found
            flash('tos_message', 'File not found', 'alert alert-danger');
            $this->redirect('tos');
        }
    }

    // Delete TOS file
    public function delete($id)
    {
        // Check if POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Delete TOS entry
            if ($this->tosModel->delete($id)) {
                flash('tos_message', 'File deleted successfully');
            } else {
                flash('tos_message', 'Failed to delete file', 'alert alert-danger');
            }
        }

        $this->redirect('tos');
    }

    // Filter TOS files
    public function filter()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get filter criteria
            $courseCode = isset($_POST['course_code']) ? $_POST['course_code'] : '';
            $testTypeId = isset($_POST['test_type_id']) ? $_POST['test_type_id'] : '';

            // Apply filters
            if (!empty($courseCode)) {
                $tosFiles = $this->tosModel->getTOSByCourse($courseCode);
            } else {
                // Get all TOS entries or filtered by faculty if not admin
                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) { // Admin
                    $tosFiles = $this->tosModel->getAllTOS();
                } else { // Faculty
                    $tosFiles = $this->tosModel->getTOSByFaculty($_SESSION['profile_id']);
                }
            }

            // Further filter by test type if specified
            if (!empty($testTypeId) && !empty($tosFiles)) {
                $filteredTos = [];
                foreach ($tosFiles as $tos) {
                    if ($tos['testTypeID_FK'] == $testTypeId) {
                        $filteredTos[] = $tos;
                    }
                }
                $tosFiles = $filteredTos;
            }

            // Get filter parameters for dropdowns
            $courses = $this->courseModel->getAllCourses();
            $testTypes = $this->testTypeModel->getAllTestTypes();

            $data = [
                'tosFiles' => $tosFiles,
                'courses' => $courses,
                'testTypes' => $testTypes,
                'selectedCourse' => $courseCode,
                'selectedTestType' => $testTypeId
            ];

            $this->view('tos/index', $data);
        } else {
            $this->redirect('tos');
        }
    }
}
