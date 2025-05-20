<?php
include './views/components/header.php';
?>
<?php include './views/partials/alert.php'; ?>
<div class="max-w-lg mx-auto mt-8">
    <h4 class="text-xl font-bold mb-4">Add New Assignment</h4>
    <form action="?action=assignment_store" method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Subject <span class="text-red-500">*</span> </label>
            <input type="text" name="subject" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500"  required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Assignment <span class="text-red-500">*</span> </label>
            <textarea name="assignment" id="summernote" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 h-[100px]"  required></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Submission Date <span class="text-red-500">*</span> </label>
            <input type="date" name="submission" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500"  required>
        </div>
        <div class="flex space-x-2">
            <button type="submit" name="save_assignment" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Save Assignment</button>
            <a href="?action=assignmet_index" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Write your content here',
            tabsize: 2,
            height: 100
        });
    });
  </script>
<?php include './views/components/footer.php'; ?>