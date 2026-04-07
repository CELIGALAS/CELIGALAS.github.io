<?php
session_start();
$message = '';

// 处理POST请求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $usersFile = __DIR__ . '/../Data/users.json';
    $users = json_decode(file_get_contents($usersFile), true);
    
    if ($action === 'delete') {
        $index = $_POST['index'] ?? -1;
        if (isset($users[$index])) {
            array_splice($users, $index, 1);
            file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $message = '删除成功';
        }
    } elseif ($action === 'update') {
        $index = $_POST['index'] ?? -1;
        $newUsername = trim($_POST['username'] ?? '');
        $newPassword = $_POST['password'] ?? '';
        $newRole = $_POST['role'] ?? 'users';
        
        if (isset($users[$index]) && $newUsername && $newPassword) {
            // 检查用户名是否与其他用户重复
            $exists = false;
            foreach ($users as $i => $u) {
                if ($i != $index && $u['username'] === $newUsername) {
                    $exists = true;
                    break;
                }
            }
            
            if ($exists) {
                $message = '用户名已存在';
            } else {
                $users[$index]['username'] = $newUsername;
                $users[$index]['password'] = $newPassword;
                $users[$index]['role'] = $newRole;
                file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $message = '修改成功';
            }
        } else {
            $message = '信息不完整';
        }
    } elseif ($action === 'add') {
        $newUsername = trim($_POST['newUsername'] ?? '');
        $newPassword = $_POST['newPassword'] ?? '';
        $newRole = $_POST['newRole'] ?? 'users';
        
        if ($newUsername && $newPassword) {
            // 检查用户名是否已存在
            $exists = false;
            foreach ($users as $u) {
                if ($u['username'] === $newUsername) {
                    $exists = true;
                    break;
                }
            }
            
            if ($exists) {
                $message = '用户名已存在';
            } else {
                $users[] = [
                    'username' => $newUsername,
                    'password' => $newPassword,
                    'role' => $newRole
                ];
                file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $message = '新建成功';
            }
        } else {
            $message = '信息不完整';
        }
    }
    
    // 重新读取数据
    $users = json_decode(file_get_contents($usersFile), true);
} else {
    $users = json_decode(file_get_contents(__DIR__ . '/../Data/users.json'), true);
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户列表 - 管理员</title>
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
            max-width: 1100px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 25px;
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
            width: fit-content;
        }
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        .back-btn svg {
            width: 18px;
            height: 18px;
            fill: white;
        }
        .message {
            text-align: center;
            padding: 12px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            margin-bottom: 20px;
            color: #38a169;
            font-weight: 500;
        }
        .user-table {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            color: #4a5568;
        }
        tr:last-child td {
            border-bottom: none;
        }
        tr:hover {
            background: #f7fafc;
        }
        .role-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .role-admin {
            background: #fef3c7;
            color: #d97706;
        }
        .role-users {
            background: #dbeafe;
            color: #2563eb;
        }
        .action-btns {
            display: flex;
            gap: 8px;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.3s ease;
        }
        .btn-edit {
            background: #667eea;
            color: white;
        }
        .btn-edit:hover {
            background: #5a6fd6;
        }
        .btn-delete {
            background: #e53e3e;
            color: white;
        }
        .btn-delete:hover {
            background: #c53030;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal.show {
            display: flex;
        }
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 16px;
            width: 400px;
            max-width: 90%;
            z-index: 1001;
        }
        .modal-content h3 {
            color: #1a1a2e;
            margin-bottom: 20px;
        }
        .modal-content input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .modal-content input:focus {
            outline: none;
            border-color: #667eea;
        }
        .modal-btns {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        .modal-btns button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }
        .modal-btns .save {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .modal-btns .cancel {
            background: #e2e8f0;
            color: #4a5568;
        }
        .user-count {
            text-align: center;
            padding: 15px;
            background: #f7fafc;
            color: #718096;
            font-size: 14px;
        }
        .btn-add {
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        .modal select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
            background: white;
        }
    </style>
</head>
<body>
    <a href="main.php" class="back-btn">
        <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
        返回管理后台
    </a>

    <div class="container">
        <div class="header">
            <h1>用户列表</h1>
            <button class="btn-add" onclick="openAddModal()" style="margin-top: 15px;">+ 新建用户</button>
        </div>

        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="user-table">
            <table>
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>用户名</th>
                        <th>密码</th>
                        <th>角色</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['password']); ?></td>
                        <td>
                            <span class="role-badge <?php echo $user['role'] === 'Admin' ? 'role-admin' : 'role-users'; ?>">
                                <?php echo $user['role'] === 'Admin' ? '管理员' : '用户'; ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-btns">
                                <button class="btn btn-edit" onclick="openModal(<?php echo $i; ?>, '<?php echo htmlspecialchars($user['username']); ?>', '<?php echo htmlspecialchars($user['password']); ?>', '<?php echo $user['role']; ?>')">编辑</button>
                                <button class="btn btn-delete" onclick="deleteUser(<?php echo $i; ?>)">删除</button>
                            </div>
                        </td>
                    </tr>
                    <?php $i++; endforeach; ?>
                </tbody>
            </table>
            <div class="user-count">共 <?php echo count($users); ?> 位用户</div>
        </div>
    </div>

    <!-- 编辑弹窗 -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <h3>编辑用户</h3>
            <form method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="index" id="editIndex">
                <input type="text" name="username" id="editUsername" placeholder="用户名" required>
                <input type="text" name="password" id="editPassword" placeholder="密码" required>
                <select name="role" id="editRole">
                    <option value="users">用户</option>
                    <option value="Admin">管理员</option>
                </select>
                <div class="modal-btns">
                    <button type="button" class="cancel" onclick="closeModal()">取消</button>
                    <button type="submit" class="save">保存</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 新建用户弹窗 -->
    <div class="modal" id="addModal">
        <div class="modal-content">
            <h3>新建用户</h3>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <input type="text" name="newUsername" placeholder="用户名" required>
                <input type="text" name="newPassword" placeholder="密码" required>
                <select name="newRole">
                    <option value="users">用户</option>
                    <option value="Admin">管理员</option>
                </select>
                <div class="modal-btns">
                    <button type="button" class="cancel" onclick="closeAddModal()">取消</button>
                    <button type="submit" class="save">新建</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(index, username, password, role) {
            document.getElementById('editIndex').value = index;
            document.getElementById('editUsername').value = username;
            document.getElementById('editPassword').value = password;
            document.getElementById('editRole').value = role;
            document.getElementById('editModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('editModal').classList.remove('show');
        }

        function openAddModal() {
            document.getElementById('addModal').classList.add('show');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.remove('show');
        }

        function deleteUser(index) {
            if (confirm('确定要删除该用户吗？')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = '<input type="hidden" name="action" value="delete"><input type="hidden" name="index" value="' + index + '">';
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>