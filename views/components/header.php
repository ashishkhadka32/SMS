<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/summernote/summernote-lite.min.css">
    <script src="assets/summernote/summernote-lite.min.js"></script>
</head>

<body class="bg-gray-100">
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    $currentAction = $_GET['action'] ?? '';
    ?>
    <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-md">
        <div class="container max-w-screen-xl flex flex-wrap items-center justify-between mx-auto py-4">
            <span class="interactive-text self-center font-bold text-2xl font-semibold whitespace-nowrap text-orange-500 hover:text-orange-600 hover:bg-orange-100 rounded-lg px-2 py-1 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50">
                ABC School
            </span>
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="index.php"
                            class="block py-2 px-3 <?= $currentPage == 'index.php' && $currentAction == '' ? 'primary' : 'text-gray-900 hover-primary' ?>">
                            Student
                        </a>
                    </li>
                    <li>
                        <a href="?action=teacher_index"
                            class="block py-2 px-3 <?= $currentAction == 'teacher_index' ? 'primary' : 'text-gray-900 hover-primary' ?>">
                            Teacher
                        </a>
                    </li>
                    <li>
                        <a href="?action=course_index"
                            class="block py-2 px-3 <?= $currentAction == 'course_index' ? 'primary' : 'text-gray-900 hover-primary' ?>">
                            Course
                        </a>
                    </li>
                    <li>
                        <a href="?action=assignment_index"
                            class="block py-2 px-3 <?= $currentAction == 'assignment_index' ? 'primary' : 'text-gray-900 hover-primary' ?>">
                            Assignment
                        </a>
                    </li>
                    <?php if (!isset($_SESSION['email'])): ?>
                        <li>
                            <a href="../../auth/login.php"
                                class="block py-2 px-3 <?= $currentPage == 'login.php' ? 'primary' : 'text-gray-900 hover-primary' ?>">
                                Login
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="./auth/logout.php"
                                class="block py-2 px-3 text-gray-900 hover-primary">
                                Logout
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mx-auto p-6">