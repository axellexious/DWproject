<?php
// app/models/Faculty.php
require_once 'app/config/database.php';

class Faculty
{
    private $db;
    private $table = TBL_FACULTY;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Get faculty profile by user ID
    public function getFacultyByUserId($userId)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE userID_FK = :user_id';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get faculty profile by profile ID
    public function getFacultyByProfileId($profileId)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE profileID = :profile_id';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':profile_id', $profileId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create faculty profile
    public function create($data)
    {
        $query = 'INSERT INTO ' . $this->table . ' 
            (userID_FK, firstName, lastName, middleName, dateCreated, dateUpdated) 
            VALUES (:user_id, :first_name, :last_name, :middle_name, NOW(), NOW())';

        $stmt = $this->db->prepare($query);

        // Bind values
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':middle_name', $data['middle_name']);

        // Execute
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    // Update faculty profile
    public function update($data)
    {
        $query = 'UPDATE ' . $this->table . ' SET 
            firstName = :first_name, 
            lastName = :last_name, 
            middleName = :middle_name, 
            dateUpdated = NOW() 
            WHERE profileID = :profile_id';

        $stmt = $this->db->prepare($query);

        // Bind values
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':middle_name', $data['middle_name']);
        $stmt->bindParam(':profile_id', $data['profile_id']);

        // Execute
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Get all faculty 
    public function getAllFaculty()
    {
        $query = 'SELECT f.*, u.userEmail, u.userName FROM ' . $this->table . ' f
                  JOIN ' . TBL_USER . ' u ON f.userID_FK = u.userID
                  ORDER BY f.lastName, f.firstName';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
