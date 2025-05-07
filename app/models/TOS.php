<?php
// app/models/TOS.php
require_once '../app/config/database.php';

class TOS
{
    private $db;
    private $table = TBL_TOS;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Get all TOS files with join to related tables
    public function getAllTOS()
    {
        $query = 'SELECT t.*, tp.topicDesc, tt.testTypeName, 
                  c.courseName, c.courseCode, p.programName,
                  CONCAT(f.firstName, " ", f.lastName) as facultyName
                  FROM ' . $this->table . ' t
                  JOIN ' . TBL_TOPIC . ' tp ON t.topicID_FK = tp.topicID
                  JOIN ' . TBL_TEST_TYPE . ' tt ON t.testTypeID_FK = tt.testTypeID
                  JOIN ' . TBL_COURSE . ' c ON tp.courseCode_FK = c.courseCode
                  JOIN ' . TBL_PROGRAM . ' p ON c.programID_FK = p.programID
                  JOIN ' . TBL_ASSIGNMENT . ' a ON c.courseCode = a.courseCode_FK
                  JOIN ' . TBL_FACULTY . ' f ON a.profileID_FK = f.profileID
                  ORDER BY t.dateCreated DESC';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get TOS by ID
    public function getTOSById($id)
    {
        $query = 'SELECT t.*, tp.topicDesc, tt.testTypeName, 
                  c.courseName, c.courseCode, p.programName,
                  CONCAT(f.firstName, " ", f.lastName) as facultyName
                  FROM ' . $this->table . ' t
                  JOIN ' . TBL_TOPIC . ' tp ON t.topicID_FK = tp.topicID
                  JOIN ' . TBL_TEST_TYPE . ' tt ON t.testTypeID_FK = tt.testTypeID
                  JOIN ' . TBL_COURSE . ' c ON tp.courseCode_FK = c.courseCode
                  JOIN ' . TBL_PROGRAM . ' p ON c.programID_FK = p.programID
                  JOIN ' . TBL_ASSIGNMENT . ' a ON c.courseCode = a.courseCode_FK
                  JOIN ' . TBL_FACULTY . ' f ON a.profileID_FK = f.profileID
                  WHERE t.tosID = :id';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get TOS files for a specific faculty
    public function getTOSByFaculty($profileId)
    {
        $query = 'SELECT t.*, tp.topicDesc, tt.testTypeName, 
                  c.courseName, c.courseCode, p.programName
                  FROM ' . $this->table . ' t
                  JOIN ' . TBL_TOPIC . ' tp ON t.topicID_FK = tp.topicID
                  JOIN ' . TBL_TEST_TYPE . ' tt ON t.testTypeID_FK = tt.testTypeID
                  JOIN ' . TBL_COURSE . ' c ON tp.courseCode_FK = c.courseCode
                  JOIN ' . TBL_PROGRAM . ' p ON c.programID_FK = p.programID
                  JOIN ' . TBL_ASSIGNMENT . ' a ON c.courseCode = a.courseCode_FK
                  WHERE a.profileID_FK = :profile_id
                  ORDER BY t.dateCreated DESC';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':profile_id', $profileId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get TOS files for a specific course
    public function getTOSByCourse($courseCode)
    {
        $query = 'SELECT t.*, tp.topicDesc, tt.testTypeName, 
                  CONCAT(f.firstName, " ", f.lastName) as facultyName
                  FROM ' . $this->table . ' t
                  JOIN ' . TBL_TOPIC . ' tp ON t.topicID_FK = tp.topicID
                  JOIN ' . TBL_TEST_TYPE . ' tt ON t.testTypeID_FK = tt.testTypeID
                  JOIN ' . TBL_ASSIGNMENT . ' a ON tp.courseCode_FK = a.courseCode_FK
                  JOIN ' . TBL_FACULTY . ' f ON a.profileID_FK = f.profileID
                  WHERE tp.courseCode_FK = :course_code
                  ORDER BY t.dateCreated DESC';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':course_code', $courseCode);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create new TOS entry
    public function create($data)
    {
        $query = 'INSERT INTO ' . $this->table . ' 
                 (topicID_FK, testTypeID_FK, tosFile, dateCreated, dateUpdated) 
                 VALUES (:topic_id, :test_type_id, :tos_file, NOW(), NOW())';

        $stmt = $this->db->prepare($query);

        // Bind values
        $stmt->bindParam(':topic_id', $data['topic_id']);
        $stmt->bindParam(':test_type_id', $data['test_type_id']);
        $stmt->bindParam(':tos_file', $data['tos_file'], PDO::PARAM_LOB);

        // Execute
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    // Update TOS entry
    public function update($data)
    {
        $query = 'UPDATE ' . $this->table . ' SET 
                 tosFile = :tos_file, 
                 dateUpdated = NOW() 
                 WHERE tosID = :tos_id';

        $stmt = $this->db->prepare($query);

        // Bind values
        $stmt->bindParam(':tos_file', $data['tos_file'], PDO::PARAM_LOB);
        $stmt->bindParam(':tos_id', $data['tos_id']);

        // Execute
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete TOS entry
    public function delete($id)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE tosID = :id';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
