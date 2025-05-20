<?php
function get_all_assignments($connection) {
    $sql = "SELECT * FROM assignments";
    $result = $connection->query($sql);
    return $result;
}

function get_all_assignments_by_id($connection, $id) {
    $sql = "SELECT * FROM assignments WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function create_assignment($connection, $subject, $assignment, $submission) {
    $sql = "INSERT INTO assignments (subject, assignment, submission) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sss", $subject, $assignment, $submission);
    $result = $stmt->execute();
    return $result;
}

function update_assignment($connection, $id, $subject, $assignment, $submission) {
    $sql = "UPDATE assignments SET subject = ?, assignment = ?, submission = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssi", $subject, $assignment, $submission, $id);
    $result = $stmt->execute();
    return $result;
}

function delete_assignment($connection, $id) {
    $sql = "DELETE FROM assignments WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    return $result;
}

?>