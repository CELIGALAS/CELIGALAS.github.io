<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>免责申明的</title>
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
        .container {
            width: 520px;
            max-width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 35px;
            border-radius: 20px;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.1) inset;
            position: relative;
            z-index: 1;
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
            border-radius: 20px 20px 0 0;
            animation: gradientMove 4s linear infinite;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            100% { background-position: 300% 50%; }
        }
        h2 {
            text-align: center;
            color: #1a1a2e;
            margin-bottom: 25px;
            font-size: 24px;
            font-weight: 600;
        }
        .disclaimer {
            border: 2px solid #e2e8f0;
            padding: 20px;
            margin-bottom: 20px;
            height: 320px;
            overflow-y: auto;
            background-color: #f7fafc;
            border-radius: 12px;
        }
        .disclaimer::-webkit-scrollbar {
            width: 8px;
        }
        .disclaimer::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 4px;
        }
        .disclaimer::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 4px;
        }
        .disclaimer h3 {
            color: #1a1a2e;
            font-size: 16px;
            margin-bottom: 15px;
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .disclaimer p {
            color: #4a5568;
            font-size: 13px;
            line-height: 1.8;
            margin-bottom: 12px;
            text-align: justify;
        }
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding: 15px;
            background: #f7fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }
        .checkbox-wrapper input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            cursor: pointer;
            accent-color: #667eea;
        }
        .checkbox-wrapper label {
            color: #4a5568;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-group {
            display: flex;
            gap: 15px;
        }
        .btn-group button {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.39, 0.575, 0.565, 1);
        }
        .agree-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        .agree-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .agree-btn:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }
        .agree-btn:hover::before {
            left: 100%;
        }
        .agree-btn:disabled {
            background: #cbd5e0;
            cursor: not-allowed;
            box-shadow: none;
        }
        .disagree-btn {
            background: white;
            color: #718096;
            border: 2px solid #e2e8f0;
        }
        .disagree-btn:hover {
            border-color: #e53e3e;
            color: #e53e3e;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(229, 62, 62, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>CELI-GALAS 登录免责申明的</h2>
        <div class="disclaimer">
            <h3>免责条款</h3>
            <p>A. 本网站所载文字、图片、数据、资料等内容仅为信息参考，不构成投资建议、交易依据、法律意见、医疗建议或专业服务承诺。</p>
            <p>B. 本网站不保证内容的准确性、完整性、及时性、适用性，对信息错误、遗漏、过时不承担责任。</p>
            <p>C. 您使用本网站的全部风险由您自行承担。</p>
            <p>D. 因使用本合同网站导致的任何直接/间接损失（包括数据丢失、利润损失、业务中断等），本合同网站均不承担法律责任。</p>
            <p>E. 本网站可能包含第三方网站链接，第三方网站内容不受本合同网站控制。</p>
            <p>F. 本网站不对第三方内容、隐私政策、服务行为负责，亦不承担任何连带责任。</p>
            <p>G. 因网络故障、黑客攻击、病毒、服务器故障、政府管制、自然灾害等不可抗力导致的服务中断、数据丢失，本网站不承担责任。</p>
            <p>H. 用户在本网站发布、上传、传播的内容，由用户自行承担全部法律责任。</p>
            <p>I. 如侵犯第三方权益，由用户独立处理并赔偿损失，与本合同网站无关。</p>
            <p>J. 本网站所有内容（文字、图片、logo、设计等）受著作权法保护。</p>
            <p>K. 未经书面许可，不得复制、转载、改编、商用，违者将依法追责。</p>
            <p>L. 本网站有权随时更新本免责声明，更新后生效，不再另行通知。</p>
            <p>M. 继续使用本平台即视为接受修改后的条款。</p>
        </div>

        <div class="checkbox-wrapper">
            <input type="checkbox" id="agreeCheck">
            <label for="agreeCheck">我已仔细阅读并同意以上免责条款</label>
        </div>

        <div class="btn-group">
            <button class="agree-btn" id="agreeBtn" disabled onclick="goToMain()">同意并进入</button>
            <button class="disagree-btn" onclick="goBackLogin()">不同意</button>
        </div>
    </div>

    <script>
        const agreeCheck = document.getElementById("agreeCheck");
        const agreeBtn = document.getElementById("agreeBtn");

        agreeCheck.addEventListener("change", function() {
            agreeBtn.disabled = !this.checked;
        });

        function goToMain() {
            window.location.href = "main.php";
        }

        function goBackLogin() {
            window.location.href = "../index.php";
        }
    </script>
</body>
</html>