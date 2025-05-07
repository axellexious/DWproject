<?php
// app/models/CognitiveSkill.php
require_once 'app/config/database.php';

class CognitiveSkill
{
    private $db;
    private $table = TBL_COGNITIVE;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Get all cognitive skills
    public function getAllCognitiveSkills()
    {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY cogskillsID';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get cognitive skill by ID
    public function getCognitiveSkillById($id)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE cogskillsID = :id';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create new cognitive skill
    public function create($data)
    {
        $query = 'INSERT INTO ' . $this->table . ' 
                 (cogskillsName, dateCreated, dateUpdated) 
                 VALUES (:cog_skills_name, NOW(), NOW())';

        $stmt = $this->db->prepare($query);

        // Bind values
        $stmt->bindParam(':cog_skills_name', $data['cog_skills_name']);

        // Execute
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    // Update cognitive skill
    public function update($data)
    {
        $query = 'UPDATE ' . $this->table . ' SET 
                 cogskillsName = :cog_skills_name, 
                 dateUpdated = NOW() 
                 WHERE cogskillsID = :cog_skills_id';

        $stmt = $this->db->prepare($query);

        // Bind values
        $stmt->bindParam(':cog_skills_name', $data['cog_skills_name']);
        $stmt->bindParam(':cog_skills_id', $data['cog_skills_id']);

        // Execute
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete cognitive skill
    public function delete($id)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE cogskillsID = :id';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
