<?php
// app/config/config.php

// Define base URL 
define('BASE_URL', 'http://localhost/exam-system');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));

// Upload directory
define('UPLOAD_DIR', dirname(dirname(__FILE__)) . '/public/uploads/');

// Document formats allowed
define('ALLOWED_DOC_FORMATS', ['doc', 'docx', 'xls', 'xlsx']);

// Database tables
define('TBL_USER', 'userTable');
define('TBL_FACULTY', 'facultyTable');
define('TBL_PROGRAM', 'programTable');
define('TBL_COURSE', 'courseTable');
define('TBL_TOPIC', 'topicsTable');
define('TBL_COGNITIVE', 'cognitiveSkillsTable');
define('TBL_TEST_TYPE', 'testTypeTable');
define('TBL_TOS', 'tosTable');
define('TBL_QUESTION', 'questionTable');
define('TBL_OPTION', 'optionTable');
define('TBL_ASSIGNMENT', 'assignmentTable');
