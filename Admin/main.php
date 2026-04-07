<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员后台</title>
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
            padding: 30px 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }
        .header::before {
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
        .header h1 {
            color: #1a1a2e;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .header p {
            color: #718096;
            font-size: 15px;
        }
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.25);
            border-color: #667eea;
        }
        .card:hover::before {
            transform: scaleX(1);
        }
        .card-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
        .card-icon svg {
            width: 28px;
            height: 28px;
            fill: white;
        }
        .card-title {
            font-size: 17px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 8px;
        }
        .card-desc {
            color: #718096;
            font-size: 13px;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        .card-link {
            color: #667eea;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .card:hover .card-link {
            color: #764ba2;
        }

        .logout-section {
            text-align: center;
            margin-top: 20px;
        }
        .logout-btn {
            padding: 12px 35px;
            background: white;
            color: #e53e3e;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .logout-btn:hover {
            background: #e53e3e;
            color: white;
            border-color: #e53e3e;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(229, 62, 62, 0.3);
        }

        @media (max-width: 768px) {
            .card-container {
                grid-template-columns: 1fr;
            }
            .header h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>管理员后台</h1>
            <p>点击下方卡片进入管理模块</p>
        </div>

        <div class="card-container">
            <div class="card" onclick="navigateTo('dir.php')">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                </div>
                <h3 class="card-title">用户列表</h3>
                <p class="card-desc">查看所有用户信息</p>
                <span class="card-link">前往 →</span>
            </div>

            <div class="card" onclick="navigateTo('../Users/main.php')">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                </div>
                <h3 class="card-title">普通用户视图</h3>
                <p class="card-desc">切换到普通用户界面</p>
                <span class="card-link">前往 →</span>
            </div>
        </div>

        <div class="logout-section">
            <button class="logout-btn" onclick="logout()">退出登录</button>
        </div>
    </div>

    <script>
        function navigateTo(pageUrl) {
            window.location.href = pageUrl;
        }

        function logout() {
            if (confirm("确定要退出登录吗？")) {
                window.location.href = "../index.php";
            }
        }
    </script>
</body>
</html>