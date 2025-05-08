# AI-Generated Exam System

A PHP-based MVC application for faculty to upload, manage, and view Table of Specifications (TOS) files for exam generation. The system allows users to upload document files (DOC, DOCX, XLS, XLSX) and stores them in the database, providing a filterable table view for easy access.

## Features

- User authentication (login/logout)
- File upload system for document files (DOC, DOCX, XLS, XLSX)
- File storage in the database as BLOB
- File viewing and downloading
- Filterable table view for uploaded files
- Bootstrap-based responsive UI design
- MVC architecture

## System Requirements

- PHP 7.4+
- MySQL 5.7+
- Apache web server with mod_rewrite enabled
- Web browser with JavaScript enabled

## Installation

1. Clone or download the repository to your web server's document root
2. Create a new MySQL database named `exam_system`
3. Import the `database_schema.sql` file into your database
4. Configure the database connection in `app/config/database.php`
5. Configure the base URL in `app/config/config.php`
6. Ensure that the `public/uploads` directory has write permissions
7. Configure your web server to use the `.htaccess` file for URL rewriting

## Directory Structure

The application follows the MVC (Model-View-Controller) architecture:

- `app/`: Application core
  - `config/`: Configuration files
  - `controllers/`: Controller classes
  - `models/`: Model classes
  - `views/`: View templates
  - `helpers/`: Helper functions
- `public/`: Publicly accessible files
  - `css/`: CSS stylesheets
  - `js/`: JavaScript files
  - `uploads/`: Temporary file upload directory
  - `index.php`: Entry point to the application

## Usage

1. Open the application in your web browser
2. Log in with the default admin credentials:
   - Email: admin@example.com
   - Password: admin123
3. Navigate to the "Upload File" page to upload a TOS document
4. View and manage uploaded files in the "TOS Files" page
5. Use the filter feature to search for specific files

## Default User Accounts

- Admin User:
  - Email: admin@example.com
  - Password: admin123
  - Role: Administrator

## Contributors
- James Allen M. Josue (axellexious)
   
## License

This project is licensed under the MIT License.

## Credits

- Bootstrap 5: https://getbootstrap.com/
- Bootstrap Icons: https://icons.getbootstrap.com/
