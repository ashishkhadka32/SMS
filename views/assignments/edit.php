<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid assignment ID.'];
    header("Location: ?action=assignment_index");
    exit;
}

$result = get_all_assignments_by_id($connection, $_GET['id']);
if ($result && mysqli_num_rows($result) > 0) {
    $assignment = mysqli_fetch_assoc($result);
} else {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Assignment not found.'];
    header("Location: ?action=assignment_index");
    exit();
}

require_once './views/components/header.php';
require_once './helpers/assignment.php';

?>
<?php include './views/partials/alert.php'; ?>
<div class="max-w-lg mx-auto mt-8">
    <h4 class="text-xl font-bold mb-4">Edit Assignment</h4>
    <form action="?action=assignment_update&id=<?= $assignment['id'] ?>" method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Subject</label>
            <input type="text" name="subject" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?= $assignment['subject'] ?>" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Assignment</label>
            <textarea name="assignment" id="summernote" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required><?= $assignment['assignment'] ?></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Submission Date</label>
            <input type="date" name="submission" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?= $assignment['submission'] ?>" required>
        </div>
        <div class="flex space-x-2">
            <button type="submit" name="update_assignment" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update Assignment</button>
            <a href="?action=assignment_index" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>
<?php include './views/components/footer.php'; ?>