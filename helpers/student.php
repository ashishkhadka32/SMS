<?php
function get_all_students($connection)
{
    $sql = "SELECT * FROM students";
    $result = $connection->query($sql);
    return $result;
}

function get_student_by_id($connection, $id)
{
    $sql = "SELECT * FROM students WHERE id = ?";
    $stmt = $connection->prepare($sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    return $result;
}
function create_student($connection, $name, $email, $phone, $course)
{
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $check_query = "SELECT email, phone FROM students WHERE email = ? OR phone = ?";
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
    $query = "INSERT INTO students (name, email, phone, course) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $course);
    $result = mysqli_stmt_execute($stmt);
    return $result;
}

function update_student($connection, $id, $name, $email, $phone, $course)
{
    $check_query = "SELECT email, phone FROM students WHERE (email = ? OR phone = ?) AND id != ?";
    $stmt = mysqli_prepare($connection, $check_query);
    mysqli_stmt_bind_param($stmt, "ssi", $email, $phone, $id);
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
    $sql = "update students set name = ?, email = ?, phone = ?, course = ? where id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $phone, $course, $id);
    $result = mysqli_stmt_execute($stmt);
    return $result;
}

function delete_student($connection, $id)
{
    $sql = "delete from students where id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);
    return $result;
}

function search_students($connection, $search_term) {
    $search_term = "%" . $search_term . "%";
    $sql = "SELECT * FROM students WHERE name LIKE ? OR email LIKE ? OR id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $search_term, $search_term, $search_term);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $result;
}