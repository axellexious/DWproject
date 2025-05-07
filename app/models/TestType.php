<?php
// app/models/TestType.php
require_once 'app/config/database.php';

class TestType
{
    private $db;
    private $table = TBL_TEST_TYPE;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Get all test types
    public function getAllTestTypes()
    {
        $query = 'SELECT tt.*, cs.cogskillsName 
                  FROM ' . $this->table . ' tt
                  JOIN ' . TBL_COGNITIVE . ' cs ON tt.cogskillsID_FK = cs.cogskillsID
                  ORDER BY tt.testTypeID';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get test type by ID
    public function getTestTypeById($id)
    {
        $query = 'SELECT tt.*, cs.cogskillsName 
                  FROM ' . $this->table . ' tt
                  JOIN ' . TBL_COGNITIVE . ' cs ON tt.cogskillsID_FK = cs.cogskillsID
                  WHERE tt.testTypeID = :id';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get test types by cognitive skill ID
    public function getTestTypesByCogSkill($cogSkillId)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE cogskillsID_FK = :cog_skill_id ORDER BY testTypeID';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cog_skill_id', $cogSkillId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create new test type
    public function create($data)
    {
        $query = 'INSERT INTO ' . $this->table . ' 
                 (cogskillsID_FK, testTypeName, testItems, dateCreated, dateUpdated) 
                 VALUES (:cog_skill_id, :test_type_name, :test_items, NOW(), NOW())';

        $stmt = $this->db->prepare($query);

        // Bind values
        $stmt->bindParam(':cog_skill_id', $data['cog_skill_id']);
        $stmt->bindParam(':test_type_name', $data['test_type_name']);
        $stmt->bindParam(':test_items', $data['test_items']);

        // Execute
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
}
