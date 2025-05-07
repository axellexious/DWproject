<?php
// app/models/Topic.php
require_once 'app/config/database.php';

class Topic
{
    private $db;
    private $table = TBL_TOPIC;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Get all topics
    public function getAllTopics()
    {
        $query = 'SELECT t.*, c.courseName 
                  FROM ' . $this->table . ' t
                  JOIN ' . TBL_COURSE . ' c ON t.courseCode_FK = c.courseCode
                  ORDER BY t.topicID';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get topic by ID
    public function getTopicById($id)
    {
        $query = 'SELECT t.*, c.courseName 
                  FROM ' . $this->table . ' t
                  JOIN ' . TBL_COURSE . ' c ON t.courseCode_FK = c.courseCode
                  WHERE t.topicID = :id';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get topics by course code
    public function getTopicsByCourse($courseCode)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE courseCode_FK = :course_code ORDER BY topicID';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':course_code', $courseCode);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create new topic
    public function create($data)
    {
        $query = 'INSERT INTO ' . $this->table . ' 
                 (courseCode_FK, topicDesc, contactHours, numUnits, dateCreated, dateUpdated) 
                 VALUES (:course_code, :topic_desc, :contact_hours, :num_units, NOW(), NOW())';

        $stmt = $this->db->prepare($query);

        // Bind values
        $stmt->bindParam(':course_code', $data['course_code']);
        $stmt->bindParam(':topic_desc', $data['topic_desc']);
        $stmt->bindParam(':contact_hours', $data['contact_hours']);
        $stmt->bindParam(':num_units', $data['num_units']);

        // Execute
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    // Update topic
    public function update($data)
    {
        $query = 'UPDATE ' . $this->table . ' SET 
                 topicDesc = :topic_desc, 
                 contactHours = :contact_hours, 
                 numUnits = :num_units,
                 dateUpdated = NOW() 
                 WHERE topicID = :topic_id';

        $stmt = $this->db->prepare($query);

        // Bind values
        $stmt->bindParam(':topic_desc', $data['topic_desc']);
        $stmt->bindParam(':contact_hours', $data['contact_hours']);
        $stmt->bindParam(':num_units', $data['num_units']);
        $stmt->bindParam(':topic_id', $data['topic_id']);

        // Execute
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
