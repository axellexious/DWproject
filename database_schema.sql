-- AI-Generated Exam System Database Schema

-- Create database
CREATE DATABASE IF NOT EXISTS exam_system;
USE exam_system;

-- Users table
CREATE TABLE IF NOT EXISTS userTable (
  userID INT AUTO_INCREMENT COMMENT 'Primary Key',
  userName VARCHAR(10) NOT NULL,
  userPassword VARCHAR(100) NOT NULL,
  userEmail VARCHAR(40) NOT NULL UNIQUE,
  userRole INT NOT NULL DEFAULT 2, -- 1=Admin, 2=Faculty
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dateUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (userID)
);

-- Faculty table
CREATE TABLE IF NOT EXISTS facultyTable (
  profileID INT AUTO_INCREMENT COMMENT 'Primary Key',
  userID_FK INT NOT NULL COMMENT 'Foreign Key referencing userTable.userID',
  firstName VARCHAR(30) NOT NULL,
  lastName VARCHAR(30) NOT NULL,
  middleName VARCHAR(30),
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dateUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (profileID),
  FOREIGN KEY (userID_FK) REFERENCES userTable(userID) ON DELETE CASCADE
);

-- Program table
CREATE TABLE IF NOT EXISTS programTable (
  programID INT AUTO_INCREMENT COMMENT 'Primary Key',
  collegeName VARCHAR(100) NOT NULL,
  programName VARCHAR(100) NOT NULL,
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dateUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (programID)
);

-- Course table
CREATE TABLE IF NOT EXISTS courseTable (
  courseCode VARCHAR(10) COMMENT 'Primary Key',
  programID_FK INT NOT NULL COMMENT 'Foreign Key referencing programTable.programID',
  courseName VARCHAR(50) NOT NULL,
  courseDesc VARCHAR(100),
  courseUnits DOUBLE NOT NULL,
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dateUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (courseCode),
  FOREIGN KEY (programID_FK) REFERENCES programTable(programID) ON DELETE CASCADE
);

-- Assignment table
CREATE TABLE IF NOT EXISTS assignmentTable (
  assignmentID INT AUTO_INCREMENT COMMENT 'Primary Key',
  assignmentDate DATE NOT NULL,
  programID_FK INT NOT NULL COMMENT 'Foreign Key referencing programTable.programID',
  courseCode_FK VARCHAR(10) NOT NULL COMMENT 'Foreign Key referencing courseTable.courseCode',
  profileID_FK INT NOT NULL COMMENT 'Foreign Key referencing facultyTable.profileID',
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dateUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (assignmentID),
  FOREIGN KEY (programID_FK) REFERENCES programTable(programID) ON DELETE CASCADE,
  FOREIGN KEY (courseCode_FK) REFERENCES courseTable(courseCode) ON DELETE CASCADE,
  FOREIGN KEY (profileID_FK) REFERENCES facultyTable(profileID) ON DELETE CASCADE
);

-- Topics table
CREATE TABLE IF NOT EXISTS topicsTable (
  topicID INT AUTO_INCREMENT COMMENT 'Primary Key',
  courseCode_FK VARCHAR(10) NOT NULL COMMENT 'Foreign Key referencing courseTable.courseCode',
  topicDesc VARCHAR(200) NOT NULL,
  contactHours DOUBLE NOT NULL,
  numUnits DOUBLE NOT NULL,
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dateUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (topicID),
  FOREIGN KEY (courseCode_FK) REFERENCES courseTable(courseCode) ON DELETE CASCADE
);

-- Cognitive Skills table
CREATE TABLE IF NOT EXISTS cognitiveSkillsTable (
  cogskillsID INT AUTO_INCREMENT COMMENT 'Primary Key',
  cogskillsName VARCHAR(100) NOT NULL,
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dateUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (cogskillsID)
);

-- Test Type table
CREATE TABLE IF NOT EXISTS testTypeTable (
  testTypeID INT AUTO_INCREMENT COMMENT 'Primary Key',
  cogskillsID_FK INT NOT NULL COMMENT 'Foreign Key referencing cognitiveSkillsTable.cogskillsID',
  testTypeName VARCHAR(100) NOT NULL,
  testItems INT NOT NULL,
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dateUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (testTypeID),
  FOREIGN KEY (cogskillsID_FK) REFERENCES cognitiveSkillsTable(cogskillsID) ON DELETE CASCADE
);

-- Table of Specifications (TOS) table
CREATE TABLE IF NOT EXISTS tosTable (
  tosID INT AUTO_INCREMENT COMMENT 'Primary Key',
  topicID_FK INT NOT NULL COMMENT 'Foreign Key referencing topicsTable.topicID',
  testTypeID_FK INT NOT NULL COMMENT 'Foreign Key referencing testTypeTable.testTypeID',
  tosFile LONGBLOB NOT NULL,
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dateUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (tosID),
  FOREIGN KEY (topicID_FK) REFERENCES topicsTable(topicID) ON DELETE CASCADE,
  FOREIGN KEY (testTypeID_FK) REFERENCES testTypeTable(testTypeID) ON DELETE CASCADE
);

-- Question table
CREATE TABLE IF NOT EXISTS questionTable (
  questionID INT AUTO_INCREMENT COMMENT 'Primary Key',
  tosID_FK INT NOT NULL,
  question VARCHAR(500) NOT NULL,
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dateUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (questionID),
  FOREIGN KEY (tosID_FK) REFERENCES tosTable(tosID) ON DELETE CASCADE
);

-- Option table
CREATE TABLE IF NOT EXISTS optionTable (
  optionID INT AUTO_INCREMENT COMMENT 'Primary Key',
  questionID_FK INT NOT NULL,
  option VARCHAR(200) NOT NULL,
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dateUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (optionID),
  FOREIGN KEY (questionID_FK) REFERENCES questionTable(questionID) ON DELETE CASCADE
);

-- Insert default admin user (password: admin123)
INSERT INTO userTable (userName, userPassword, userEmail, userRole, dateCreated, dateUpdated)
VALUES ('admin', '$2y$10$Vn0iO5jq5RY3e9EOlrCqHOoP3KtaBcqicrHUPwSa8jYZA5Gi4HjJi', 'admin@example.com', 1, NOW(), NOW());

-- Insert sample data for cognitive skills
INSERT INTO cognitiveSkillsTable (cogskillsName) VALUES 
('Knowledge'),
('Comprehension'),
('Application'),
('Analysis'),
('Synthesis'),
('Evaluation');

-- Insert sample data for test types
INSERT INTO testTypeTable (cogskillsID_FK, testTypeName, testItems) VALUES 
(1, 'Multiple Choice', 20),
(2, 'True or False', 15),
(3, 'Essay', 5),
(4, 'Problem Solving', 10),
(5, 'Project', 1);

-- Insert sample data for programs
INSERT INTO programTable (collegeName, programName) VALUES 
('College of Computer Studies', 'Bachelor of Science in Information Technology'),
('College of Engineering', 'Bachelor of Science in Computer Engineering'),
('College of Education', 'Bachelor of Secondary Education');

-- Insert sample courses
INSERT INTO courseTable (courseCode, programID_FK, courseName, courseDesc, courseUnits) VALUES 
('COMP101', 1, 'Introduction to Computing', 'Basic concepts of computing', 3),
('PROG201', 1, 'Programming Fundamentals', 'Basic programming concepts', 3),
('DATA301', 2, 'Database Management', 'Introduction to database systems', 3),
('WEB401', 1, 'Web Development', 'Web development fundamentals', 3);

-- Insert sample topics
INSERT INTO topicsTable (courseCode_FK, topicDesc, contactHours, numUnits) VALUES 
('COMP101', 'Computer Hardware Components', 6, 1),
('COMP101', 'Computer Software', 6, 1),
('PROG201', 'Control Structures', 6, 1),
('PROG201', 'Functions and Methods', 6, 1),
('DATA301', 'Database Design Principles', 6, 1),
('DATA301', 'SQL Fundamentals', 9, 1.5),
('WEB401', 'HTML and CSS Basics', 6, 1),
('WEB401', 'JavaScript Fundamentals', 9, 1.5);