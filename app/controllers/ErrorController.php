<?php
// app/controllers/ErrorController.php
require_once 'app/controllers/BaseController.php';

class ErrorController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => '404 Page Not Found'
        ];

        $this->view('errors/404', $data);
    }
}
