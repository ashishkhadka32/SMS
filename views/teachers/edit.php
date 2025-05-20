<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid teacher ID.'];
    header("Location: ?action=teacher_index");
    exit;
}

$result = get_all_teachers_by_id($connection, $_GET['id']);
if ($result && mysqli_num_rows($result) > 0) {
    $teacher = mysqli_fetch_assoc($result);
} else {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Teacher not found.'];
    header("Location: ?action=teacher_index");
    exit();
}

require_once './views/components/header.php';
require_once './helpers/teacher.php';

?>
<?php include './views/partials/alert.php'; ?>
<div class="max-w-lg mx-auto mt-8">
    <h4 class="text-xl font-bold mb-4">Edit Teacher</h4>
    <form action="?action=teacher_update&id=<?= $teacher['id'] ?>" method="POST" class="space-y-4" enctype="multipart/form-data">
         <div>
            <label class="block text-sm font-medium text-gray-700">Teacher Name</label>
            <input type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?php echo $teacher['name']; ?>" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Teacher Email</label>
            <input type="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?php echo $teacher['email']; ?>" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Teacher Phone</label>
            <input type="text" name="phone" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" pattern="[0-9]{10}" title="Enter a 10-digit phone number" value="<?php echo $teacher['phone']; ?>" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Teacher Course</label>
            <input type="text" name="course" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?php echo $teacher['course']; ?>" required>
        </div>
         <div>
            <img class="w-32 h-32" src="<?php echo $teacher['file']; ?>" alt="">
            <label class="block text-sm font-medium text-gray-700">Add Image</label>
            <input type="file" name="file" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?php echo $teacher['file']; ?>">
            <input type="hidden" name="old_file" value="<?= $teacher['file'] ?>">
        </div>
        <div class="flex space-x-2">
            <button type="submit" name="update_teacher" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update Teacher</button>
            <a href="?action=teacher_index" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
        </div>
    </form>
</div>
<?php include './views/components/footer.php'; ?>