<?php
// app/models/Program.php
require_once '../app/config/database.php';

class Program
{
    private $db;
    private $table = TBL_PROGRAM;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Get all programs
    public function getAllPrograms()
    {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY programName';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get program by ID
    public function getProgramById($id)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE programID = :id';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create new program
    public function create($data)
    {
        $query = 'INSERT INTO ' . $this->table . ' 
                 (collegeName, programName, dateCreated, dateUpdated) 
                 VALUES (:college_name, :program_name, NOW(), NOW())';

        $stmt = $this->db->prepare($query);

        // Bind values
        $stmt->bindParam(':college_name', $data['college_name']);
        $stmt->bindParam(':program_name', $data['program_name']);

        // Execute
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    // Update program 
    public function update($data)
    {
        $query = 'UPDATE ' . $this->table . ' SET 
                 collegeName = :college_name, 
                 programName = :program_name, 
                 dateUpdated = NOW() 
                 WHERE programID = :program_id';

        $stmt = $this->db->prepare($query);

        // Bind values
        $stmt->bindParam(':college_name', $data['college_name']);
        $stmt->bindParam(':program_name', $data['program_name']);
        $stmt->bindParam(':program_id', $data['program_id']);

        // Execute
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
