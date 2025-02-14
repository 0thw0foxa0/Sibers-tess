<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

include 'db.php';

// Получение списка пользователей
$stmt = $pdo->query('SELECT * FROM users');
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-purple-500 to-indigo-600 min-h-screen p-8">
    <div class="max-w-7xl mx-auto">
        <!-- // Заголовок и кнопка выхода --> 
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-white">User Management</h1>
            <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300">
                Logout
            </a>
        </div>

        <!-- Кнопка добавления пользователя -->
        <a href="add_user.php" class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg mb-6 hover:bg-green-700 transition duration-300">
            Add New User
        </a>

        <!-- Таблица пользователей -->
        <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Birthdate</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($users as $user): ?>
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo $user['id']; ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo $user['username']; ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo $user['first_name']; ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo $user['last_name']; ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo $user['gender']; ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo $user['birthdate']; ?></td>
                        <td class="px-6 py-4 text-sm">
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="text-blue-600 hover:text-blue-800 mr-4">Edit</a>
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="js/animations.js"></script>
<script src="js/form-validation.js"></script>
</body>
</html>