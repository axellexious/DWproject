<?php
// app/models/Course.php
require_once 'app/config/database.php';

class Course
{
    private $db;
    private $table = TBL_COURSE;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Get all courses
    public function getAllCourses()
    {
        $query = 'SELECT c.*, p.programName 
                  FROM ' . $this->table . ' c
                  JOIN ' . TBL_PROGRAM . ' p ON c.programID_FK = p.programID
                  ORDER BY c.courseCode';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get course by course code
    public function getCourseByCode($courseCode)
    {
        $query = 'SELECT c.*, p.programName 
                  FROM ' . $this->table . ' c
                  JOIN ' . TBL_PROGRAM . ' p ON c.programID_FK = p.programID
                  WHERE c.courseCode = :course_code';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':course_code', $courseCode);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get courses by program ID
    public function getCoursesByProgram($programId)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE programID_FK = :program_id ORDER BY courseCode';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':program_id', $programId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get courses assigned to a faculty
    public function getCoursesByFaculty($profileId)
    {
        $query = 'SELECT c.*, p.programName 
                  FROM ' . $this->table . ' c
                  JOIN ' . TBL_PROGRAM . ' p ON c.programID_FK = p.programID
                  JOIN ' . TBL_ASSIGNMENT . ' a ON c.courseCode = a.courseCode_FK
                  WHERE a.profileID_FK = :profile_id
                  GROUP BY c.courseCode
                  ORDER BY c.courseCode';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':profile_id', $profileId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create new course
    public function create($data)
    {
        $query = 'INSERT INTO ' . $this->table . ' 
                 (courseCode, programID_FK, courseName, courseDesc, courseUnits, dateCreated, dateUpdated) 
                 VALUES (:course_code, :program_id, :course_name, :course_desc, :course_units, NOW(), NOW())';

        $stmt = $this->db->prepare($query);

        // Bind values
        $stmt->bindParam(':course_code', $data['course_code']);
        $stmt->bindParam(':program_id', $data['program_id']);
        $stmt->bindParam(':course_name', $data['course_name']);
        $stmt->bindParam(':course_desc', $data['course_desc']);
        $stmt->bindParam(':course_units', $data['course_units']);

        // Execute
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
