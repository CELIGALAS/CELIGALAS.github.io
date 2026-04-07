<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML 查看器</title>
    <style>
        :root {
            --editor-bg: #1e1e1e;
            --preview-bg: #ffffff;
            --primary: #667eea;
            --secondary: #2d2d2d;
            --text-primary: #e0e0e0;
            --text-secondary: #9e9e9e;
            --success: #00c853;
            --danger: #ff5252;
            --border: #333333;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            --radius: 6px;
            --transition: all 0.2s ease;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .app-container {
            max-width: 1600px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            width: fit-content;
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
        .app-header {
            text-align: center;
            margin-bottom: 10px;
        }
        .app-header h1 {
            font-size: 24px;
            font-weight: 600;
            color: white;
            margin-bottom: 8px;
        }
        .app-header p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
        }
        .control-bar {
            display: flex;
            gap: 12px;
        }
        .btn {
            padding: 10px 20px;
            border-radius: var(--radius);
            border: none;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }
        .btn-run {
            background-color: var(--success);
            color: white;
        }
        .btn-run:hover {
            background-color: #00b248;
        }
        .btn-clear {
            background-color: var(--danger);
            color: white;
        }
        .btn-clear:hover {
            background-color: #ff1744;
        }
        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            height: calc(100vh - 220px);
        }
        .panel {
            background-color: var(--secondary);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .panel-header {
            padding: 12px 16px;
            background-color: var(--editor-bg);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            color: white;
        }
        .panel-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }
        #html-editor {
            flex: 1;
            width: 100%;
            padding: 16px;
            border: none;
            outline: none;
            resize: none;
            background-color: var(--editor-bg);
            color: var(--text-primary);
            font-family: 'Consolas', 'Monaco', monospace;
            font-size: 14px;
            line-height: 1.6;
            scrollbar-width: thin;
            scrollbar-color: var(--primary) var(--secondary);
        }
        #html-editor::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        #html-editor::-webkit-scrollbar-thumb {
            background-color: var(--primary);
            border-radius: 4px;
        }
        #html-editor::-webkit-scrollbar-track {
            background-color: var(--secondary);
        }
        #preview-frame {
            flex: 1;
            width: 100%;
            border: none;
            background-color: var(--preview-bg);
        }
        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
                height: auto;
            }
            .panel {
                height: 400px;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <a href="main.php" class="back-btn">
            <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
            返回主页
        </a>

        <div class="app-header">
            <h1>HTML 实时查看器</h1>
            <p>极简版 | 输入代码 · 即时预览</p>
        </div>

        <div class="control-bar">
            <button class="btn btn-run" id="run-btn">
                <span>▶</span> 运行 HTML
            </button>
            <button class="btn btn-clear" id="clear-btn">
                <span>✕</span> 清空内容
            </button>
        </div>

        <div class="main-content">
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-icon">&lt;/&gt;</div>
                    <span>HTML 编辑区</span>
                </div>
                <textarea id="html-editor" placeholder="请输入HTML代码...">
&lt;!DOCTYPE html&gt;
&lt;html lang="zh-CN"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;title&gt;预览示例&lt;/title&gt;
    &lt;style&gt;
        body {
            font-family: -apple-system, sans-serif;
            text-align: center;
            margin-top: 80px;
            background: #f5f5f5;
        }
        h1 {
            color: #667eea;
            font-weight: 500;
        }
        p {
            color: #666;
            margin-top: 20px;
        }
    &lt;/style&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;极简 HTML 查看器&lt;/h1&gt;
    &lt;p&gt;输入代码，点击运行即可实时预览 ✨&lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;
                </textarea>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <div class="panel-icon">👁️</div>
                    <span>预览区</span>
                </div>
                <iframe id="preview-frame"></iframe>
            </div>
        </div>
    </div>

    <script>
        const htmlEditor = document.getElementById('html-editor');
        const previewFrame = document.getElementById('preview-frame');
        const runBtn = document.getElementById('run-btn');
        const clearBtn = document.getElementById('clear-btn');

        function renderHtml() {
            try {
                const htmlCode = htmlEditor.value.trim();
                const previewDoc = previewFrame.contentDocument || previewFrame.contentWindow.document;
                previewDoc.open();
                previewDoc.write(htmlCode || '<div style="text-align:center; padding:50px; color:#999;">暂无预览内容</div>');
                previewDoc.close();
            } catch (error) {
                alert('解析错误：' + error.message);
            }
        }

        function clearContent() {
            if (confirm('确定清空所有内容吗？')) {
                htmlEditor.value = '';
                renderHtml();
            }
        }

        runBtn.addEventListener('click', renderHtml);
        clearBtn.addEventListener('click', clearContent);
        window.addEventListener('load', renderHtml);

        htmlEditor.addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.key === 'Enter') {
                renderHtml();
                e.preventDefault();
            }
        });
    </script>
</body>
</html>