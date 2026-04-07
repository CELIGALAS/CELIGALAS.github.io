<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>简易网页浏览器</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Microsoft Yahei", sans-serif;
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
            margin-bottom: 20px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
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
            font-size: 24px;
            font-weight: 600;
        }
        .browser-container {
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        .browser-controls {
            background-color: #f5f5f5;
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .browser-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 13px;
        }
        .browser-btn:disabled {
            background: #cbd5e0;
            cursor: not-allowed;
        }
        .browser-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        .address-bar {
            flex: 1;
            padding: 10px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .address-bar:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        .browser-content {
            width: 100%;
            height: 70vh;
            border: none;
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        .back-btn svg {
            width: 18px;
            height: 18px;
            fill: white;
        }
    </style>
</head>
<body>
    <a href="main.php" class="back-btn">
        <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
        返回主页
    </a>

    <div class="container">
        <div class="header">
            <h1>CELI-GALAS 浏览器</h1>
        </div>

        <div class="browser-container">
            <div class="browser-controls">
                <button id="backBtn" class="browser-btn" disabled>后退</button>
                <button id="forwardBtn" class="browser-btn" disabled>前进</button>
                <input type="text" id="addressInput" class="address-bar" placeholder="输入网址（如 https://www.baidu.com）">
                <button id="goBtn" class="browser-btn">访问</button>
                <button id="refreshBtn" class="browser-btn">刷新</button>
            </div>
            <iframe id="browserFrame" class="browser-content" src="about:blank"></iframe>
        </div>
    </div>

    <script>
        const backBtn = document.getElementById('backBtn');
        const forwardBtn = document.getElementById('forwardBtn');
        const addressInput = document.getElementById('addressInput');
        const goBtn = document.getElementById('goBtn');
        const refreshBtn = document.getElementById('refreshBtn');
        const browserFrame = document.getElementById('browserFrame');

        browserFrame.addEventListener('load', () => {
            addressInput.value = browserFrame.src;
            backBtn.disabled = !browserFrame.contentWindow.history.length;
            forwardBtn.disabled = !browserFrame.contentWindow.history.forward();
        });

        backBtn.addEventListener('click', () => {
            if (browserFrame.contentWindow.history.length > 0) {
                browserFrame.contentWindow.history.back();
            }
        });

        forwardBtn.addEventListener('click', () => {
            browserFrame.contentWindow.history.forward();
        });

        goBtn.addEventListener('click', () => {
            let url = addressInput.value.trim();
            if (!url.startsWith('http://') && !url.startsWith('https://')) {
                url = 'https://' + url;
            }
            browserFrame.src = url;
        });

        refreshBtn.addEventListener('click', () => {
            browserFrame.contentWindow.location.reload();
        });

        addressInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                goBtn.click();
            }
        });
    </script>
</body>
</html>