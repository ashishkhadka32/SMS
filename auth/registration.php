<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Use CDN for testing -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
        <form action="./actions/processRegistration.php" method="post" class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Registration</h1>
            <div class="border p-2 w-full">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="w-full border p-2 rounded" required>
            </div>
            <div class="border p-2 w-full">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" class="w-full border p-2 rounded" required>
            </div>
            <div class="border p-2 w-full">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="w-full border p-2 rounded" required>
            </div>
            <div class="col-span-2 text-center mt-4 mx-auto">
                <button class="bg-blue-500 text-white px-4 py-2 rounded mb-2" name="register">Register</button></br>
                <span>Already have an account? <a href="login.php" class="text-blue-500">Login</a></span>
            </div>
        </div>
    </form>
</body>
</html>