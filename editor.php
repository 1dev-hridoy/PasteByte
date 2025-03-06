<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Code Editor</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/loader.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex flex-col items-center justify-center min-h-screen p-5">
    <h2 class="text-2xl font-bold mb-4">🚀 Advanced VS Code-Like Editor</h2>

    <div class="flex gap-3 mb-4">
        <select id="language" class="p-2 bg-gray-800 text-white rounded">
            <option value="javascript">JavaScript</option>
            <option value="python">Python</option>
            <option value="cpp">C++</option>
            <option value="java">Java</option>
            <option value="html">HTML</option>
            <option value="css">CSS</option>
            <option value="php">PHP</option>
            <option value="csharp">C#</option>
            <option value="go">Go</option>
            <option value="ruby">Ruby</option>
            <option value="swift">Swift</option>
            <option value="typescript">TypeScript</option>
            <option value="rust">Rust</option>
            <option value="kotlin">Kotlin</option>
            <option value="sql">SQL</option>
        </select>

        <select id="theme" class="p-2 bg-gray-800 text-white rounded">
            <option value="vs-dark">VS Code Dark</option>
            <option value="vs">VS Code Light</option>
            <option value="hc-black">High Contrast</option>
        </select>

        <button id="fullscreenBtn" class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded">🔍 Full Screen</button>
        <button id="runCode" class="p-2 bg-green-600 hover:bg-green-700 text-white rounded">⚡ Run Code</button>
        <button id="downloadCode" class="p-2 bg-yellow-600 hover:bg-yellow-700 text-black rounded">💾 Download</button>
        <input type="file" id="uploadFile" class="hidden">
        <label for="uploadFile" class="p-2 bg-purple-600 hover:bg-purple-700 text-white rounded cursor-pointer">📂 Load File</label>
    </div>

    <div id="editor" class="w-full h-[70vh] border-2 border-gray-700 rounded"></div>
    <div id="output" class="w-full bg-gray-800 text-white p-3 rounded mt-3 hidden"></div>

    <script>
        require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs' }});
        require(["vs/editor/editor.main"], function () {
            let editor = monaco.editor.create(document.getElementById("editor"), {
                value: "// Start coding here...",
                language: "javascript",
                theme: "vs-dark",
                automaticLayout: true
            });

            document.getElementById("language").addEventListener("change", function () {
                monaco.editor.setModelLanguage(editor.getModel(), this.value);
            });

            document.getElementById("theme").addEventListener("change", function () {
                monaco.editor.setTheme(this.value);
            });

            document.getElementById("fullscreenBtn").addEventListener("click", function () {
                let editorContainer = document.getElementById("editor");
                if (!document.fullscreenElement) {
                    editorContainer.requestFullscreen().catch(err => {
                        console.error(`Error trying to enable full-screen mode: ${err.message}`);
                    });
                } else {
                    document.exitFullscreen();
                }
            });

            document.getElementById("runCode").addEventListener("click", function () {
                let code = editor.getValue();
                try {
                    let result = eval(code);
                    document.getElementById("output").classList.remove("hidden");
                    document.getElementById("output").innerText = `Output: ${result}`;
                } catch (err) {
                    document.getElementById("output").classList.remove("hidden");
                    document.getElementById("output").innerText = `Error: ${err}`;
                }
            });

            document.getElementById("downloadCode").addEventListener("click", function () {
                let blob = new Blob([editor.getValue()], { type: "text/plain" });
                let a = document.createElement("a");
                a.href = URL.createObjectURL(blob);
                a.download = `code.${document.getElementById("language").value}`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            });

            document.getElementById("uploadFile").addEventListener("change", function () {
                let file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        editor.setValue(e.target.result);
                    };
                    reader.readAsText(file);
                }
            });

            monaco.languages.registerCompletionItemProvider('javascript', {
                provideCompletionItems: function() {
                    return {
                        suggestions: [
                            {
                                label: 'console.log',
                                kind: monaco.languages.CompletionItemKind.Function,
                                insertText: 'console.log($1);',
                                insertTextRules: monaco.languages.CompletionItemInsertTextRule.InsertAsSnippet,
                                documentation: "Logs output to the console"
                            },
                            {
                                label: 'fetch',
                                kind: monaco.languages.CompletionItemKind.Function,
                                insertText: 'fetch("${1:url}")\n\t.then(response => response.json())\n\t.then(data => console.log(data))\n\t.catch(error => console.error(error));',
                                insertTextRules: monaco.languages.CompletionItemInsertTextRule.InsertAsSnippet,
                                documentation: "Fetch API call"
                            },
                            {
                                label: 'async function',
                                kind: monaco.languages.CompletionItemKind.Snippet,
                                insertText: 'async function ${1:name}() {\n\ttry {\n\t\t$0\n\t} catch (error) {\n\t\tconsole.error(error);\n\t}\n}',
                                insertTextRules: monaco.languages.CompletionItemInsertTextRule.InsertAsSnippet,
                                documentation: "Creates an async function with error handling"
                            }
                        ]
                    };
                }
            });

        });
    </script>
</body>
</html>