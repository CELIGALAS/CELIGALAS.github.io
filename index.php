<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户登录</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Microsoft YaHei", Arial, sns-serif;
        }
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 255, 198, 0.1) 0%, transparent 40%);
            animation: bgFloat 20s ease-in-out infinite;
        }
        @keyframes bgFloat {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(2%, 2%) rotate(1deg); }
            66% { transform: translate(-1%, 1%) rotate(-1deg); }
        }
        .login-container {
            width: 420px;
            max-width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.1) inset;
            position: relative;
            z-index: 1;
        }
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #667eea);
            background-size: 300% 100%;
            border-radius: 20px 20px 0 0;
            animation: gradientMove 4s linear infinite;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            100% { background-position: 300% 50%; }
        }
        .logo {
            text-align: center;
            margin-bottom: 25px;
        }
        .logo-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        .logo-icon svg {
            width: 40px;
            height: 40px;
            fill: white;
        }
        h2 {
            text-align: center;
            color: #1a1a2e;
            margin-bottom: 30px;
            font-size: 26px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .form-group {
            margin-bottom: 22px;
            position: relative;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-size: 14px;
            font-weight: 500;
        }
        .input-wrapper {
            position: relative;
        }
        .input-wrapper::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23a0aec0' viewBox='0 0 24 24'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E");
            background-size: contain;
            opacity: 0.5;
            transition: opacity 0.3s;
        }
        .input-wrapper.password::before {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23a0aec0' viewBox='0 0 24 24'%3E%3Cpath d='M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z'/%3E%3C/svg%3E");
        }
        input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            background: #f7fafc;
            transition: all 0.3s ease;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        input:focus + .input-wrapper::before,
        .form-group:has(input:focus)::before {
            opacity: 1;
        }

        .btn-box {
            display: flex;
            gap: 12px;
            margin: 25px 0 20px;
        }
        #loginBtn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.39, 0.575, 0.565, 1);
        }
        #loginBtn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        #loginBtn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }
        #loginBtn:hover::before {
            left: 100%;
        }
        #loginBtn:active {
            transform: translateY(0);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        #guestBtn {
            flex: 1;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: white;
            color: #4a5568;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.39, 0.575, 0.565, 1);
        }
        #guestBtn:hover {
            border-color: #28a745;
            color: #28a745;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(40, 167, 69, 0.2);
        }
        #guestBtn:active {
            transform: translateY(0);
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 12px;
            background: #f7fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }
        .checkbox-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            cursor: pointer;
            accent-color: #667eea;
        }
        .checkbox-wrapper label {
            color: #4a5568;
            font-size: 13px;
            cursor: pointer;
        }
        .checkbox-wrapper a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        .checkbox-wrapper a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .error-tips {
            color: #e53e3e;
            display: none;
            text-align: center;
            padding: 12px;
            background: #fff5f5;
            border-radius: 8px;
            border: 1px solid #feb2b2;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #718096;
        }
        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        .register-link a:hover {
            color: #764ba2;
            text-decoration: none;
        }
        .register-link a:hover::after {
            content: ' →';
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <div class="logo-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            </div>
        </div>
        <h2>CELI-GALAS 用户登录</h2>
        
        <div class="form-group">
            <label for="username">账户</label>
            <div class="input-wrapper">
                <input type="text" id="username" placeholder="请输入账户">
            </div>
        </div>
        <div class="form-group">
            <label for="password">密码</label>
            <div class="input-wrapper password">
                <input type="password" id="password" placeholder="请输入密码">
            </div>
        </div>

        <!-- 按钮区域（用ID绑定，避免样式冲突） -->
        <div class="checkbox-wrapper">
            <input type="checkbox" id="agreeCheck">
            <label for="agreeCheck">我已认真阅读 <a href="Users/mianze.php" target="_blank">用户条款</a></label>
        </div>

        <div class="btn-box">
            <button id="loginBtn" onclick="doLogin()">登 录</button>
            <button id="guestBtn" onclick="window.location.href='Users/zhuce.php'">注 册</button>
        </div>

        <!-- 提示文字 -->
        <div class="error-tips" id="loginError">账户或密码错误，请重新输入！</div>
    </div>

    <script>
        // 从PHP读取用户数据
        const validUsers = <?php 
            $users = json_decode(file_get_contents(__DIR__ . '/Data/users.json'), true);
            echo json_encode($users, JSON_UNESCAPED_UNICODE);
        ?>;
        
        const loginError = document.getElementById('loginError');
        const agreeCheck = document.getElementById('agreeCheck');

        // 登录
        function doLogin() {
            const uname = document.getElementById('username').value.trim();
            const pwd = document.getElementById('password').value.trim();
            const user = validUsers.find(u => u.username === uname && u.password === pwd);
            
            if (!user) {
                loginError.style.display = 'block';
                return;
            }
            
            // Admin不需要勾选条款
            if (user.role !== 'Admin' && !agreeCheck.checked) {
                alert('请先阅读并同意用户条款');
                return;
            }
            
            loginError.style.display = 'none';
            
            // 根据用户角色跳转
            if (user.role === 'Admin') {
                window.location.href = 'Admin/main.php';
            } else {
                window.location.href = 'Users/main.php';
            }
        }
    </script>
</body>
</html>