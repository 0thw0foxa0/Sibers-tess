<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

include 'db.php';

if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];

    // Если пароль был введён, хэшируем его
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE users SET username = ?, password = ?, first_name = ?, last_name = ?, gender = ?, birthdate = ? WHERE id = ?');
        $stmt->execute([$username, $password, $first_name, $last_name, $gender, $birthdate, $id]);
    } else {
        // Если пароль не был введён, обновляем остальные данные
        $stmt = $pdo->prepare('UPDATE users SET username = ?, first_name = ?, last_name = ?, gender = ?, birthdate = ? WHERE id = ?');
        $stmt->execute([$username, $first_name, $last_name, $gender, $birthdate, $id]);
    }

    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-yellow-500 to-orange-600 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-md transform transition-all duration-500 hover:scale-105">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Edit User</h1>
        <form method="POST" class="space-y-6">
            <input type="text" name="username" value="<?php echo $user['username']; ?>" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
            <input type="password" name="password" placeholder="New Password (leave blank to keep current)"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
            <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
            <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
            <select name="gender" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <option value="male" <?php echo $user['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo $user['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
                <option value="other" <?php echo $user['gender'] === 'other' ? 'selected' : ''; ?>>Other</option>
            </select>
            <input type="date" name="birthdate" value="<?php echo $user['birthdate']; ?>" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
            <button type="submit"
                    class="w-full bg-yellow-600 text-white py-2 rounded-lg hover:bg-yellow-700 transition duration-300">
                Update User
            </button>
        </form>
    </div>
    <script src="js/animations.js"></script>
<script src="js/form-validation.js"></script>
</body>
</html>