<?php
require_once './views/components/header.php';
require_once './helpers/teacher.php';

if (!isset($teachers)) {
    $teachers = get_all_teachers($connection); // Default to all teachers if not set (e.g., for ?action=teacher_index)
}
?>
<?php include './views/partials/alert.php'; ?>
<h2 class="text-2xl font-bold mb-4">Teacher List</h2>
<div class="grid grid-cols-4 gap-4">
    <div class="col-span-1">
        <a href="?action=teacher_create" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4">Add New</a>
    </div>
    <div class="col-span-3 mb-3">
        <form action="?action=search" method="GET">
            <input type="hidden" name="action" value="search">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input name="q" type="search" id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search teachers by name" value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>" required />
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-2 px-4 border">SN</th>
                <th class="py-2 px-4 border">Name</th>
                <th class="py-2 px-4 border">Email</th>
                <th class="py-2 px-4 border">Phone</th>
                <th class="py-2 px-4 border">Course</th>
                <th class="py-2 px-4 border">Image</th>
                <th class="py-2 px-4 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($teachers) > 0): ?>
                <?php $count = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($teachers)): ?>
                    <tr>
                        <td class="py-2 px-4 border"><?= $count++ ?></td>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($row['name']) ?></td>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($row['email']) ?></td>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($row['phone']) ?></td>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($row['course']) ?></td>
                        <td class="py-2 px-4 border"><img src="<?= htmlspecialchars($row['file']) ?>" width="100" height="100" alt="Teacher Image"></td>
                        <td class="py-2 px-4 border flex space-x-2">
                            <a href="?action=teacher_edit&id=<?= $row['id'] ?>" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                            <form action="?action=teacher_delete" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete teacher?')">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="py-2 px-4 border text-center">No teachers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include './views/components/footer.php'; ?>