<?php
require_once './views/components/header.php';
// require '../../functions/course.php';
require_once './helpers/assignment.php';
$assignments = get_all_assignments($connection);
?>
<?php include './views/partials/alert.php'; ?>
<h2 class="text-2xl font-bold mb-4">Assignment List</h2>
<a href="?action=assignment_create" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4">Add New</a>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-2 px-4 border">SN</th>
                <th class="py-2 px-4 border">Subject</th>
                <th class="py-2 px-4 border">Assignment</th>
                <th class="py-2 px-4 border">Submission</th>
                <th class="py-2 px-4 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            while ($row = mysqli_fetch_assoc($assignments)): ?>
                <tr>
                    <td class="py-2 px-4 border"><?= $count++ ?></td>
                    <td class="py-2 px-4 border"><?= htmlspecialchars($row['subject']) ?></td>
                    <td class="py-2 px-4 border"><?= $row['assignment'] ?></td>
                    <td class="py-2 px-4 border"><?= htmlspecialchars($row['submission']) ?></td>
                    <td class="py-2 px-4">
                        <div class="flex space-x-2 items-center">
                            <a href="?action=assignment_edit&id=<?= $row['id'] ?>" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                            <form action="?action=assignment_delete" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this course?')">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include './views/components/footer.php'; ?>