<?php
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
require_once 'views/components/header.php';
require_once 'helpers/student.php';
?>
<div class="max-w-lg mx-auto mt-8">
    <h4 class="text-xl font-bold mb-4">Edit Student</h4>
    <form action="?action=update&id=<?= $student['id'] ?>" method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Student Name</label>
            <input type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?= htmlspecialchars($student['name']) ?>" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Student Email</label>
            <input type="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?= htmlspecialchars($student['email']) ?>" required>
            <span class="text-xs text-red-500">
                <?php
                if (isset($_SESSION['error']['email'])) {
                    echo $_SESSION['error']['email'];
                    unset($_SESSION['error']['email']); 
                }
                ?>
            </span>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Student Phone</label>
            <input type="text" name="phone" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?= htmlspecialchars($student['phone']) ?>" pattern="[0-9]{10}" title="Enter a 10-digit phone number" required>
            <span class="text-xs text-red-500">
                <?php
                if (isset($_SESSION['error']['phone'])) {
                    echo $_SESSION['error']['phone'];
                    unset($_SESSION['error']['phone']);
                }
                ?>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Student Course</label>
            <input type="text" name="course" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?= htmlspecialchars($student['course']) ?>" required>
        </div>
        <div class="flex space-x-2">
            <button type="submit" name="update_student" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Student</button>
            <a href="index.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
        </div>
    </form>
</div>
<?php include 'views/components/footer.php'; ?>