<?php
session_start();

$error = "";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === "usm" && $password === "123") {
        $_SESSION['username'] = $username;
        $_SESSION['login_count'] = ($_SESSION['login_count'] ?? 0) + 1;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Minimalist</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 360px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
            color: #333;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s;
        }
        .login-container input:focus {
            border-color: #4e8cff;
            outline: none;
        }
        .login-container .checkbox {
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        .login-container button {
            width: 100%;
            padding: 0.75rem;
            background-color: #4e8cff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-container button:hover {
            background-color: #3a6fd8;
        }
        .error-message {
            background-color: #ffd1d1;
            color: #a70000;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <form class="login-container" method="POST" action="">
        <h2>Login</h2>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        
        <div class="checkbox">
            <input type="checkbox" id="remember" />
            <label for="remember">Ingatkan saya</label>
        </div>

        <button type="submit">Masuk</button>
    </form>
</body>
</html>
