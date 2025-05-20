<?php
session_start();
if (!isset($_SESSION['email'])) {

    header("Location: ./auth/login.php");
}
require_once 'config/dbConn.php';
require_once 'helpers/student.php';
require_once 'helpers/course.php';
require_once 'helpers/teacher.php';
require_once 'helpers/assignment.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'create':
        require 'views/create.php';
        break;

    case 'store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_student'])) {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $course = trim($_POST['course']);


            $_SESSION['old'] = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'course' => $course,
            ];
            
            $studentResult = create_student($connection, $name, $email, $phone, $course);
            if($studentResult === "email_exists"){
                $_SESSION['error']['email'] = "Email already exists.";
                header("Location: ?action=create");
                exit();
            }
            elseif($studentResult === "phone_exists"){
                $_SESSION['error']['phone'] = "Phone number already exists.";
                header("Location: ?action=create");
                exit();
            }      
            elseif ($studentResult) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Student added successfully.'];
                header("Location: index.php");
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to add student.'];
                header("Location: ?action=create");
            }
        }
        break;

    case 'edit':
        require 'views/edit.php';
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_student'])) {
            $id = $_GET['id'];
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $course = trim($_POST['course']);

            $studentResult = update_student($connection, $id, $name, $email, $phone, $course);
            if($studentResult === "email_exists"){
                $_SESSION['error']['email'] = "Email already exists.";
                header("Location: ?action=edit&id=$id");
                exit();
            }
            elseif($studentResult === "phone_exists"){
                $_SESSION['error']['phone'] = "Phone number already exists.";
                header("Location: ?action=edit&id=$id");
                exit();
            }
            elseif ($studentResult) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Student updated successfully.'];
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to update student.'];
                header("Location: ?action=edit&id=$id");
                exit();
            }
        }
        break;

    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            if (delete_student($connection, $id)) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Student deleted successfully.'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to delete student.'];
            }
            header("Location: index.php");
        }
        break;

    case 'view':
        require 'views/view.php';
        break;

     case 'search_student':
    if (isset($_GET['q'])) {
        $search_term = trim($_GET['q']);
        $students = search_students($connection, $search_term);
        require 'views/index.php';
    } else {
        $students = get_all_students($connection);
        require 'views/index.php';
    }
    break;

    //courses
    case 'course_index':
        require './views/courses/index.php';
        break;

    case 'course_create':
        require 'views/courses/create.php';
        break;

    case 'course_store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_course'])) {
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $duration = trim($_POST['duration']);

            $_SESSION['old'] = [
                'name' => $name,
                'description' => $description,
                'duration' => $duration
            ];

            if (create_course($connection, $name, $description, $duration)) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Course added successfully.'];
                session_write_close();
                header("Location: ?action=course_index");
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to add course.'];
                session_write_close();
                header("Location: ?action=course_create");
            }
        }
        break;

    case 'course_edit':
        require 'views/courses/edit.php';
        break;

    case 'course_update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_course'])) {
            $id = $_GET['id'];
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $duration = trim($_POST['duration']);

            if (update_course($connection, $id, $name, $description, $duration)) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Course updated successfully.'];
                session_write_close();
                header("Location: ?action=course_index");
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to update course.'];
                session_write_close();
                header("Location: ?action=course_edit&id=$id");
            }
        }
        break;

    case 'course_delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            if (delete_course($connection, $id)) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Course deleted successfully.'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to delete course.'];
            }
            session_write_close();
            header("Location: ?action=course_index");
        }
        break;


    //teachers
    case 'teacher_index':   
        $teachers = get_all_teachers($connection);
        require './views/teachers/index.php';
        break;

    case 'teacher_create':
        require 'views/teachers/create.php';
        break;

    case 'teacher_store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_teacher'])) {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $course = trim($_POST['course']);
            $file = $_FILES['file'];

            $_SESSION['old'] = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'course' => $course,
            ];
            $result = create_teacher($connection, $name, $email, $phone, $course, $file);
            if ($result === "email_exists") {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Email already exists.'];    
                session_write_close();
                header("Location: ?action=teacher_create");
            }elseif($result === "phone_exists"){
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Phone number already exists.'];
                session_write_close();
                header("Location: ?action=teacher_create");
            }
            elseif ($result === "invalid_phone") {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Phone number must start with 98 and must have 10 digits.'];
                session_write_close();
                header("Location: ?action=teacher_create");
            } elseif ($result === "invalid_file_type") {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid file type.'];
                session_write_close();
                header("Location: ?action=teacher_create");
            } elseif ($result) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Teacher added successfully.'];
                session_write_close();
                header("Location: ?action=teacher_index");
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to add teacher.'];
                session_write_close();
                header("Location: ?action=teacher_create");
            }
        }
        break;

    case 'teacher_edit':
        require 'views/teachers/edit.php';
        break;

case 'teacher_update':
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_teacher'])) {
        $id = $_GET['id'];
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $course = trim($_POST['course']);
        $file = $_FILES['file'];
        $old_file = $_POST['old_file'];

        $result = update_teacher($connection, $id, $name, $email, $phone, $course, $file, $old_file);

        if ($result === "email_exists") {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Email already exists.'];
        } elseif ($result === "phone_exists") {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Phone number already exists.'];
        } elseif ($result === "invalid_phone") {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Phone number must start with 98 and be 10 digits.'];
        } elseif ($result === "invalid_file_type") {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid file type.'];
        } elseif ($result) {
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Teacher updated successfully.'];
            header("Location: ?action=teacher_index");
            exit;
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to update teacher.'];
        }
        session_write_close();
        header("Location: ?action=teacher_edit&id=$id");
        exit;
    }
    break;


    case 'teacher_delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            if (delete_teacher($connection, $id)) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Teacher deleted successfully.'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to delete teacher.'];
            }
            session_write_close();
            header("Location: ?action=teacher_index");
        }
        break;

case 'search':
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
        $search_term = trim($_GET['q']);
        if (empty($search_term)) {
            // $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Please enter a search term.'];
            // session_write_close();
            header("Location: ?action=teacher_index");
            exit();
        }

        $teachers = search_teachers($connection, $search_term);
        require 'views/teachers/index.php';
    } else {
        // $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid search request.'];
        // session_write_close();
        header("Location: ?action=teacher_index");
        exit();
    }
    break;


    //Assignments
    case 'assignment_index':
        require './views/assignments/index.php';
        break;

    case 'assignment_create':
        require 'views/assignments/create.php';
        break;

    case 'assignment_store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_assignment'])) {
            $subject = trim($_POST['subject']);
            $assignment = trim($_POST['assignment']);
            $submission = trim($_POST['submission']);
            if (create_assignment($connection, $subject, $assignment, $submission)) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Assignment added successfully.'];
                header("Location: ?action=assignment_index");
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to add assignment.'];
                header("Location: ?action=assignment_create");
            }
        }
        break;
        
        case 'assignment_edit':
            require 'views/assignments/edit.php';
            break;
        
        case 'assignment_update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_assignment'])) {
                $id = $_GET['id'];
                $subject = trim($_POST['subject']);
                $assignment = trim($_POST['assignment']);
                $submission = trim($_POST['submission']);
                if (update_assignment($connection, $id, $subject, $assignment, $submission)) {
                    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Assignment updated successfully.'];
                    header("Location: ?action=assignment_index");
                } else {
                    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to update assignment.'];
                    header("Location: ?action=assignment_edit&id=$id");
                }
            }
            break;

            case 'delete_assignment':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $id = $_POST['id'];
                    if (delete_assignment($connection, $id)) {
                        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Assignment deleted successfully.'];
                    } else {
                        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to delete assignment.'];
                    }
                    session_write_close();
                    header("Location: ?action=assignment_index");
                }
            
            break;
        
    default:
        require 'views/index.php';
        break;
}
