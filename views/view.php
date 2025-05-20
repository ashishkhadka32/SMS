<?php
include 'views/components/header.php';
require_once 'helpers/student.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid student ID.'];
    header("Location: index.php");
    exit;
}

$result = get_student_by_id($connection, $_GET['id']);
if ($result && mysqli_num_rows($result) > 0) {
    $student = mysqli_fetch_assoc($result);
} else {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Student not found.'];
    header("Location: index.php");
    exit;
}
?>
<div class="max-w-lg mx-auto mt-8">
    <h4 class="text-xl font-bold mb-4">View Student Details</h4>
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Student Name</label>
            <p class="mt-1 block w-full border border-gray-300 rounded-md p-2 bg-gray-50"><?= htmlspecialchars($student['name']) ?></p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Student Email</label>
            <p class="mt-1 block w-full border border-gray-300 rounded-md p-2 bg-gray-50"><?= htmlspecialchars($student['email']) ?></p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Student Phone</label>
            <p class="mt-1 block w-full border border-gray-300 rounded-md p-2 bg-gray-50"><?= htmlspecialchars($student['phone']) ?></p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Student Course</label>
            <p class="mt-1 block w-full border border-gray-300 rounded-md p-2 bg-gray-50"><?= htmlspecialchars($student['course']) ?></p>
        </div>
        <a href="index.php" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
    </div>
</div>
<?php include 'views/components/footer.php'; ?>