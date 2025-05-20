<?php
include 'views/components/header.php';
?>
<?php include './views/partials/alert.php'; ?>
<div class="max-w-lg mx-auto mt-8">
    <h4 class="text-xl font-bold mb-4">Add New Teacher</h4>
    <form action="?action=teacher_store" method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Teacher Name <span class="text-red-500">*</span> </label>
            <input type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?= isset($_SESSION['old']['name'])? $_SESSION['old']['name'] : '' ?>" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Teacher Email <span class="text-red-500">*</span> </label>
            <input type="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?= isset($_SESSION['old']['email'])? $_SESSION['old']['email'] : '' ?>" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Teacher Phone <span class="text-red-500">*</span> </label>
            <input type="text" name="phone" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" pattern="[0-9]{10}" title="Enter a 10-digit phone number" value="<?= isset($_SESSION['old']['phone'])? $_SESSION['old']['phone'] : '' ?>" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Teacher Course <span class="text-red-500">*</span> </label>
            <input type="text" name="course" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" value="<?= isset($_SESSION['old']['course'])? $_SESSION['old']['course'] : '' ?>" required>
        </div>
         <div>
            <label class="block text-sm font-medium text-gray-700">Add Image <span class="text-red-500">*</span> </label>
            <input type="file" name="file" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div class="flex space-x-2">
            <button type="submit" name="save_teacher" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Save Student</button>
            <a href="?action=teacher_index" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
        </div>
    </form>
</div>
<?php include 'views/components/footer.php'; ?>