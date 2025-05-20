<?php
function get_all_courses($connection) {
    $sql = "SELECT * FROM courses";
    $result = mysqli_query($connection, $sql);
    return $result;
}
function get_course_by_id($connection, $id) {
    $sql = "SELECT * FROM courses WHERE id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    return $result;
}
function create_course($connection, $name, $description, $duration) {
    $query = "INSERT INTO courses (name, description, duration) VALUES (?, ?, ?)";
    mysqli_escape_string($connection, $name);
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "sss", $name, $description, $duration);
    return mysqli_stmt_execute($stmt);
}

function update_course($connection, $id, $name, $description, $duration) {
    $sql = "update courses set name = ?, description = ?, duration = ? where id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $description, $duration, $id);
    return mysqli_stmt_execute($stmt);
}

function delete_course($connection, $id) {
    $sql = "delete from courses where id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}

function get_course_by_name($connection, $name) {
    $sql = "SELECT * FROM courses WHERE name = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    return $result;
}
?>
