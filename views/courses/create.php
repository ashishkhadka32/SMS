<?php
include './views/components/header.php';
?>
<?php include './views/partials/alert.php'; ?>
<div class="max-w-lg mx-auto mt-8">
    <h4 class="text-xl font-bold mb-4">Add New Course</h4>
    <form action="?action=course_store" method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Course Name <span class="text-red-500">*</span> </label>
            <input type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?= isset($_SESSION['old']['name'])? $_SESSION['old']['name'] : '' ?>" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Description <span class="text-red-500">*</span> </label>
            <textarea name="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?= isset($_SESSION['old']['description'])? $_SESSION['old']['description'] : '' ?>" required></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Duration <span class="text-red-500">*</span> </label>
            <input type="text" name="duration" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?= isset($_SESSION['old']['duration'])? $_SESSION['old']['duration'] : '' ?>" required>
        </div>
        <div class="flex space-x-2">
            <button type="submit" name="save_course" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Save Course</button>
            <a href="?action=course_index" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
        </div>
    </form>
</div>
<?php include './views/components/footer.php'; ?>