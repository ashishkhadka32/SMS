<?php
function get_all_teachers($connection)
{
    $sql = "SELECT * FROM teachers";
    $result = mysqli_query($connection, $sql);
    return $result;
}

function get_all_teachers_by_id($connection, $id)
{
    $sql = "SELECT * FROM teachers WHERE id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    return $result;
}


function create_teacher($connection, $name, $email, $phone, $course, $file)
{
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $check_query = "SELECT email, phone FROM teachers WHERE email = ? OR phone = ?";
    $stmt = mysqli_prepare($connection, $check_query);
    mysqli_stmt_bind_param($stmt, "ss", $email, $phone);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['email'] === $email) {
            return "email_exists";
        }
        if ($row['phone'] === $phone) {
            return "phone_exists";
        }
    }
 

    if (!preg_match('/^98\d{8}$/', $phone)) {
        return "invalid_phone";
    }

    $filename = $file['name'];
    $filepath = $file['tmp_name'];
    $fileerror = $file['error'];
    $file_extension = explode('.', $filename);
    $file_extension_check = strtolower(end($file_extension));
    $valid_file_extensions = array('jpg', 'jpeg', 'png', 'gif');

    if ($fileerror === 0) {
        if (in_array($file_extension_check, $valid_file_extensions)) {
            $new_filename = time() . '_' . basename($filename);
            $destfile = 'uploads/' . $new_filename;
            if (move_uploaded_file($filepath, $destfile)) {
                $query = "INSERT INTO teachers (name, email, phone, course, file) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $course, $destfile);
                return mysqli_stmt_execute($stmt);
            }
        } else {
            return "invalid_file_type";
        }
    }
       return false;
}

function update_teacher($connection, $id, $name, $email, $phone, $course, $file, $old_file)
{
    $check_query = "SELECT email, phone FROM teachers WHERE (email = ? OR phone = ?) AND id != ?";
    $stmt = mysqli_prepare($connection, $check_query);
    mysqli_stmt_bind_param($stmt, 'ssi', $email, $phone, $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['email'] === $email) {
            return "email_exists";
        }
        if ($row['phone'] === $phone) {
            return "phone_exists";
        }
    }
    if (!preg_match('/^98\d{8}$/', $phone)) {
        return "invalid_phone";
    }

    // Default to old file path
    $destfile = $old_file;

    // Check if new file is uploaded
    $filename = $file['name'];
    $filepath = $file['tmp_name'];
    $fileerror = $file['error'];

    if ($fileerror === 0 && !empty($filename)) {
        $file_extension = explode('.', $filename);
        $file_extension_check = strtolower(end($file_extension));
        $valid_file_extensions = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($file_extension_check, $valid_file_extensions)) {
            $destfile = 'uploads/' . uniqid('teacher_', true) . '.' . $file_extension_check;
            move_uploaded_file($filepath, $destfile);
        } else {
            return "invalid_file_type";
        }
    }

    // Update query
    $sql = "UPDATE teachers SET name = ?, email = ?, phone = ?, course = ?, file = ? WHERE id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $name, $email, $phone, $course, $destfile, $id);
    $result = mysqli_stmt_execute($stmt);

    return $result;
}


function delete_teacher($connection, $id)
{
    try {
        //file delete code
        $sql = "SELECT `file` FROM teachers WHERE id = ?";
        $stmt = $connection->prepare($sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $filepath = $row['file'];

        unlink($filepath);

        $sql = "DELETE from teachers where id = ?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        $result = mysqli_stmt_execute($stmt);

        return true;
    } catch (\Throwable $th) {
        return false;
    }
}

function search_teachers($connection, $search_term)
{
    $search_term_like = "%" . trim($search_term) . "%"; // For name and email (partial match)
    $search_term_id = trim($search_term); // For ID (exact match)

    $sql = "SELECT * FROM teachers WHERE name LIKE ? OR email LIKE ? OR id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $search_term_like, $search_term_like, $search_term_id); 
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $result;
}
