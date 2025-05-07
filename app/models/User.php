<?php
// app/models/User.php
require_once 'app/config/database.php';

class User
{
    private $db;
    private $table = TBL_USER;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Login user
    public function login($email, $password)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE userEmail = :email';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        // Verify password - check both camelCase and PascalCase for compatibility
        if (isset($user['userPassword']) && password_verify($password, $user['userPassword'])) {
            return $user;
        } elseif (isset($user['UserPassword']) && password_verify($password, $user['UserPassword'])) {
            return $user;
        } else {
            return false;
        }
    }

    // Find user by email
    public function findUserByEmail($email)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE userEmail = :email';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Get user by ID
    public function getUserById($id)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE userID = :id';

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Register new user (for admin use)
    public function register($data)
    {
        $query = 'INSERT INTO ' . $this->table . ' 
            (userName, UserPassword, userEmail, userRole, dateCreated, dateUpdated) 
            VALUES (:username, :password, :email, :role, NOW(), NOW())';

        $stmt = $this->db->prepare($query);

        // Bind values
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':role', $data['role']);

        // Execute
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
}
