<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>反极域控制下载</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Microsoft YaHei', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 30px;
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
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: white;
            margin-bottom: 10px;
        }
        .page-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 15px;
        }
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }
        .download-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        .download-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        .download-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.25);
            border-color: #667eea;
        }
        .download-card:hover::before {
            transform: scaleX(1);
        }
        .card-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        .card-icon svg {
            width: 28px;
            height: 28px;
            fill: white;
        }
        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 10px;
        }
        .card-desc {
            font-size: 14px;
            color: #718096;
            margin-bottom: 15px;
        }
        .file-info {
            font-size: 13px;
            color: #a0aec0;
            margin-bottom: 15px;
        }
        .download-btn {
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }
        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
        @media (max-width: 768px) {
            .card-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <a href="main.php" class="back-btn">
        <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
        返回主页
    </a>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">资源下载中心</h1>
            <p class="page-subtitle">精心整理的开发资源，点击卡片或下载按钮即可获取，安全可靠</p>
        </div>

        <div class="card-grid">
            <div class="download-card" onclick="downloadFile(1)">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                </div>
                <h3 class="card-title">火绒安全软件</h3>
                <p class="card-desc">让我们杀死陶老子</p>
                <div class="file-info">4.8MB</div>
                <button class="download-btn" onclick="event.stopPropagation(); downloadFile(1)">下载</button>
            </div>

            <div class="download-card" onclick="downloadFile(2)">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24"><path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-6 10h-4v-2h4v2z"/></svg>
                </div>
                <h3 class="card-title">极域Tool最终版 [修正].exe</h3>
                <p class="card-desc">招牌</p>
                <div class="file-info">按需修改大小</div>
                <button class="download-btn" onclick="event.stopPropagation(); downloadFile(2)">下载</button>
            </div>

            <div class="download-card" onclick="downloadFile(3)">
                <div class="card-icon">
                    <svg viewBox="0 0 24 24"><path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2z"/></svg>
                </div>
                <h3 class="card-title">SkiesKillerV1.0.1.exe</h3>
                <p class="card-desc">反控老师</p>
                <div class="file-info">按需修改大小</div>
                <button class="download-btn" onclick="event.stopPropagation(); downloadFile(3)">下载</button>
            </div>
        </div>
    </div>

    <script>
        const downloadLinks = {
            1: "火绒.exe",
            2: "极域Tool最终版 [修正].exe",
            3: "SkiesKillerV1.0.1.exe"
        };

        function downloadFile(fileId) {
            if (!downloadLinks[fileId]) {
                alert("下载链接不存在，请检查配置！");
                return;
            }
            try {
                const link = document.createElement("a");
                link.href = downloadLinks[fileId];
                link.download = downloadLinks[fileId].split('/').pop();
                link.target = "_blank";
                document.body.appendChild(link);
                link.click();
                setTimeout(() => link.remove(), 200);
                const cardTitle = document.querySelector(`.download-card[onclick="downloadFile(${fileId})"] .card-title`).textContent;
                alert("开始下载：" + cardTitle + "\n请等待下载弹窗弹出");
            } catch (error) {
                alert("下载失败：" + error.message + "\n请检查网络或文件是否存在");
                console.error("下载错误：", error);
            }
        }
    </script>
</body>
</html>