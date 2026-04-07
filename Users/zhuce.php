<?php
session_start();
$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if (empty($username) || empty($password)) {
        $message = '请填写完整信息';
    } elseif (strlen($username) < 0) {
        $message = '输入你的账户';
    } elseif (strlen($password) < 6) {
        $message = '密码至少6位';
    } elseif ($password !== $confirm) {
        $message = '两次密码不一致';
    } else {
        $usersFile = dirname(__FILE__) . '/../Data/users.json';
        $existing = json_decode(file_get_contents($usersFile), true) ?: [];
        
        $exists = false;
        foreach ($existing as $u) {
            if ($u['username'] === $username) {
                $exists = true;
                break;
            }
        }
        
        if ($exists) {
            $message = '用户名已存在';
        } else {
            $existing[] = ['username' => $username, 'password' => $password];
            file_put_contents($usersFile, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $message = '注册成功！';
            $success = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户注册</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Microsoft YaHei", Arial, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            width: 400px;
            max-width: 100%;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            padding: 40px;
            position: relative;
            overflow: hidden;
        }
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #667eea);
            background-size: 300% 100%;
            animation: gradientMove 4s linear infinite;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            100% { background-position: 300% 50%; }
        }
        h2 {
            text-align: center;
            color: #1a1a2e;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            color: #4a5568;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
        }
        .form-group input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        .message {
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .message.error {
            background: #fff5f5;
            color: #e53e3e;
            border: 1px solid #feb2b2;
        }
        .message.success {
            background: #f0fff4;
            color: #38a169;
            border: 1px solid #9ae6b4;
        }
        .links {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #718096;
        }
        .links a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>用户注册</h2>
        
        <?php if ($message): ?>
            <div class="message <?php echo $success ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if (!$success): ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">用户名</label>
                <input type="text" id="username" name="username" required placeholder="请输入用户名（至少2位）">
            </div>
            <div class="form-group">
                <label for="password">密码</label>
                <input type="password" id="password" name="password" required placeholder="请输入密码（至少6位）">
            </div>
            <div class="form-group">
                <label for="confirm">确认密码</label>
                <input type="password" id="confirm" name="confirm" required placeholder="请再次输入密码">
            </div>
            <button type="submit" class="btn">注册</button>
        </form>
        <?php else: ?>
            <div style="text-align: center;">
                <a href="../index.php" class="btn" style="display: inline-block; text-decoration: none; width: auto; padding: 14px 30px;">立即登录</a>
            </div>
        <?php endif; ?>

        <div class="links">
            已有账号？<a href="../index.php">立即登录</a>
        </div>
    </div>
</body>
</html>