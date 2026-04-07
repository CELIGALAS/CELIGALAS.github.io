<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人网盘系统</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Microsoft Yahei", Arial, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
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
        .login-wrap {
            max-width: 400px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }
        .login-wrap h2 {
            text-align: center;
            color: #1a1a2e;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .form-item {
            margin-bottom: 25px;
        }
        .form-item label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-size: 14px;
            font-weight: 500;
        }
        .form-item input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
        }
        .form-item input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
        .error-tip {
            color: #e53e3e;
            text-align: center;
            margin-top: 15px;
            display: none;
            font-size: 14px;
            padding: 10px;
            background: #fff5f5;
            border-radius: 8px;
        }
        .drive-wrap {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 25px;
            display: none;
        }
        .drive-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 20px;
        }
        .user-info {
            font-size: 18px;
            color: #1a1a2e;
            font-weight: 600;
        }
        .logout-btn {
            padding: 10px 20px;
            background: white;
            color: #e53e3e;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .logout-btn:hover {
            background: #e53e3e;
            color: white;
            border-color: #e53e3e;
        }
        .file-actions {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .upload-btn {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
        #fileUpload {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        .file-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        .file-card {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px 15px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .file-card:hover {
            border-color: #667eea;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }
        .file-icon {
            font-size: 48px;
            margin-bottom: 12px;
        }
        .file-name {
            color: #1a1a2e;
            font-weight: 600;
            margin-bottom: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .file-size {
            color: #718096;
            font-size: 14px;
            margin-bottom: 12px;
        }
        .download-btn {
            padding: 8px 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        .no-files {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 0;
            color: #718096;
            font-size: 16px;
        }
        @media (max-width: 768px) {
            .file-list {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
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
        <div class="login-wrap" id="loginPage">
            <h2>个人网盘登录</h2>
            <div class="form-item">
                <label for="username">用户名</label>
                <input type="text" id="username" placeholder="请输入用户名">
            </div>
            <div class="form-item">
                <label for="password">密码</label>
                <input type="password" id="password" placeholder="请输入密码">
            </div>
            <button class="login-btn" onclick="handleLogin()">登录</button>
            <div class="error-tip" id="errorTip">用户名或密码错误</div>
        </div>

        <div class="drive-wrap" id="drivePage">
            <div class="drive-header">
                <div class="user-info" id="userName"></div>
                <button class="logout-btn" onclick="handleLogout()">退出登录</button>
            </div>

            <div class="file-actions">
                <label class="upload-btn">
                    上传文件
                    <input type="file" id="fileUpload" onchange="handleFileUpload(this)">
                </label>
            </div>

            <div class="file-list" id="fileList"></div>
        </div>
    </div>

    <script>
        // 从PHP读取用户数据
        const userData = <?php 
            $users = json_decode(file_get_contents(dirname(__FILE__) . '/../Data/users.json'), true);
            $data = [];
            foreach ($users as $u) {
                $data[] = ['username' => $u['username'], 'password' => $u['password'], 'files' => []];
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        ?>;

        function initUserData() {
            if (!localStorage.getItem('netDiskUsers')) {
                localStorage.setItem('netDiskUsers', JSON.stringify(userData));
            }
        }

        window.onload = function() {
            initUserData();
            const currentUser = localStorage.getItem('currentLoginUser');
            if (currentUser) {
                showDrivePage(JSON.parse(currentUser));
            }
        };

        function handleLogin() {
            const inputUsername = document.getElementById("username").value.trim();
            const inputPassword = document.getElementById("password").value.trim();
            const errorTip = document.getElementById("errorTip");
            errorTip.style.display = "none";

            const loginUser = userData.find(user => 
                user.username === inputUsername && user.password === inputPassword
            );

            if (loginUser) {
                localStorage.setItem('currentLoginUser', JSON.stringify(loginUser));
                showDrivePage(loginUser);
            } else {
                errorTip.style.display = "block";
            }
        }

        function showDrivePage(user) {
            document.getElementById('loginPage').style.display = "none";
            document.getElementById('drivePage').style.display = "block";
            document.getElementById('userName').textContent = `当前用户：${user.username}`;
            renderFileList(user.files, user.username);
        }

        function renderFileList(files, username) {
            const fileList = document.getElementById('fileList');
            fileList.innerHTML = "";

            if (files.length === 0) {
                fileList.innerHTML = '<div class="no-files">暂无文件，点击上传按钮添加文件吧～</div>';
                return;
            }

            const fileIconMap = {
                doc: "📄", img: "🖼️", pdf: "📑", txt: "📝",
                video: "🎬", audio: "🎵", other: "📁"
            };

            files.forEach((file, index) => {
                const fileType = file.type || "other";
                const fileCard = document.createElement('div');
                fileCard.className = "file-card";
                fileCard.innerHTML = `
                    <div class="file-icon">${fileIconMap[fileType] || fileIconMap.other}</div>
                    <div class="file-name" title="${file.name}">${file.name}</div>
                    <div class="file-size">${file.size}</div>
                    <button class="download-btn" onclick="downloadFile('${username}', ${index})">下载</button>
                `;
                fileList.appendChild(fileCard);
            });
        }

        function handleFileUpload(input) {
            const file = input.files[0];
            if (!file) return;

            const currentUser = JSON.parse(localStorage.getItem('currentLoginUser'));
            const users = JSON.parse(localStorage.getItem('netDiskUsers'));
            const fileSize = formatFileSize(file.size);
            const fileType = getFileType(file.name);

            const reader = new FileReader();
            reader.onload = function(e) {
                const newFile = {
                    name: file.name,
                    size: fileSize,
                    type: fileType,
                    content: e.target.result
                };

                currentUser.files.push(newFile);
                const userIndex = users.findIndex(u => u.username === currentUser.username);
                users[userIndex] = currentUser;
                localStorage.setItem('netDiskUsers', JSON.stringify(users));
                localStorage.setItem('currentLoginUser', JSON.stringify(currentUser));
                renderFileList(currentUser.files, currentUser.username);
                input.value = "";
            };
            reader.readAsDataURL(file);
        }

        function downloadFile(username, fileIndex) {
            const users = JSON.parse(localStorage.getItem('netDiskUsers'));
            const user = users.find(u => u.username === username);
            const file = user.files[fileIndex];

            if (!file.content) {
                alert(`开始下载：${file.name}\n（注：默认演示文件无实际内容）`);
                return;
            }

            const link = document.createElement('a');
            link.href = file.content;
            link.download = file.name;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function handleLogout() {
            localStorage.removeItem('currentLoginUser');
            document.getElementById('drivePage').style.display = "none";
            document.getElementById('loginPage').style.display = "block";
            document.getElementById('username').value = "";
            document.getElementById('password').value = "";
            document.getElementById('errorTip').style.display = "none";
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return "0 B";
            const k = 1024;
            const sizes = ['B', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return (bytes / Math.pow(k, i)).toFixed(1) + ' ' + sizes[i];
        }

        function getFileType(fileName) {
            const ext = fileName.split('.').pop().toLowerCase();
            if (['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(ext)) return 'img';
            if (['mp4', 'avi', 'mov', 'wmv'].includes(ext)) return 'video';
            if (['mp3', 'wav', 'flac'].includes(ext)) return 'audio';
            if (['doc', 'docx'].includes(ext)) return 'doc';
            if (['pdf'].includes(ext)) return 'pdf';
            if (['txt'].includes(ext)) return 'txt';
            return 'other';
        }
    </script>
</body>
</html>