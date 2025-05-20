<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid course ID.'];
    header("Location: ?action=course_index");
    exit;
}

$result = get_course_by_id($connection, $_GET['id']);
if ($result && mysqli_num_rows($result) > 0) {
    $course = mysqli_fetch_assoc($result);
} else {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Course not found.'];
    header("Location: ?action=course_index");
    exit();
}

require_once './views/components/header.php';
require_once './helpers/course.php';

?>
<?php include './views/partials/alert.php'; ?>
<div class="max-w-lg mx-auto mt-8">
    <h4 class="text-xl font-bold mb-4">Edit Course</h4>
    <form action="?action=course_update&id=<?= $course['id'] ?>" method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Course Name</label>
            <input type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?= htmlspecialchars($course['name']) ?>" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required><?= htmlspecialchars($course['description']) ?></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Duration</label>
            <input type="text" name="duration" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?= htmlspecialchars($course['duration']) ?>" required>
        </div>
        <div class="flex space-x-2">
            <button type="submit" name="update_course" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Course</button>
            <a href="?action=course_index" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
        </div>
    </form>
</div>
<?php include './views/components/footer.php'; ?>