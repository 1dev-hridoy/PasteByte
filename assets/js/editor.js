require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs' }});
require(["vs/editor/editor.main"], function () {
    console.log("Monaco editor loaded");
    
    // Create the editor and make it globally accessible
    window.editor = monaco.editor.create(document.getElementById("editor"), {
        value: "// Welcome to PasteByte Code Editor\n// Start coding here...\n\nconsole.log('Hello, world!');\n\n// Try our intelligent code completion\n// Type 'fetch' or 'async' and press Ctrl+Space",
        language: "javascript",
        theme: "vs-dark",
        automaticLayout: true,
        fontSize: 14,
        fontFamily: "'Fira Code', 'Consolas', 'Monaco', monospace",
        lineNumbers: "on",
        minimap: { enabled: true },
        scrollBeyondLastLine: false,
        roundedSelection: true,
        cursorBlinking: "smooth",
        cursorSmoothCaretAnimation: "on",
        smoothScrolling: true,
        renderLineHighlight: "all",
        padding: { top: 16 }
    });

    // Notify that the editor is ready
    console.log("Editor initialized and globally accessible as window.editor");
    
    const languageSelect = document.getElementById("language-select");
    if (languageSelect) {
        languageSelect.addEventListener("change", function () {
            monaco.editor.setModelLanguage(window.editor.getModel(), this.value);
            
            // Add a subtle animation when changing language
            const editorElement = document.getElementById("editor");
            editorElement.classList.add('animate-pulse');
            setTimeout(() => {
                editorElement.classList.remove('animate-pulse');
            }, 500);
        });
    } else {
        console.error("Language select element not found");
    }

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
        let code = window.editor.getValue();
        let outputElement = document.getElementById("output");
        let outputContent = document.getElementById("output-content");
        
        outputElement.classList.remove("hidden");
        outputContent.innerHTML = '<div class="flex items-center"><div class="animate-spin mr-2"><i class="fas fa-circle-notch"></i></div> Running code...</div>';
        
        setTimeout(() => {
            try {
                // Create a safe console.log replacement
                let output = [];
                const originalConsoleLog = console.log;
                console.log = (...args) => {
                    output.push(args.map(arg => 
                        typeof arg === 'object' ? JSON.stringify(arg, null, 2) : String(arg)
                    ).join(' '));
                };
                
                // Run the code
                let result = eval(code);
                
                // Restore original console.log
                console.log = originalConsoleLog;
                
                // Display output
                if (output.length > 0) {
                    outputContent.innerHTML = `<div class="p-2 bg-dark rounded-md">${output.map(line => `<div>${line}</div>`).join('')}</div>`;
                    if (result !== undefined) {
                        outputContent.innerHTML += `<div class="mt-2 p-2 bg-dark rounded-md"><span class="text-primary">Result:</span> ${result}</div>`;
                    }
                } else if (result !== undefined) {
                    outputContent.innerHTML = `<div class="p-2 bg-dark rounded-md"><span class="text-primary">Result:</span> ${result}</div>`;
                } else {
                    outputContent.innerHTML = `<div class="p-2 bg-dark rounded-md text-gray-400">Code executed successfully with no output.</div>`;
                }
            } catch (err) {
                outputContent.innerHTML = `<div class="p-2 bg-dark rounded-md text-red-400"><span class="font-semibold">Error:</span> ${err.message}</div>`;
            }
        }, 500);
    });

    document.getElementById("downloadCode").addEventListener("click", function () {
        let blob = new Blob([window.editor.getValue()], { type: "text/plain" });
        let a = document.createElement("a");
        a.href = URL.createObjectURL(blob);
        a.download = `code.${languageSelect.value}`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        
        // Show a temporary notification
        let notification = document.createElement("div");
        notification.className = "fixed bottom-4 right-4 bg-primary text-white px-4 py-2 rounded-md shadow-lg animate-bounce-in";
        notification.innerHTML = '<i class="fas fa-check-circle mr-2"></i> File downloaded successfully!';
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('animate-fade-out');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 500);
        }, 3000);
    });

    document.getElementById("uploadFile").addEventListener("change", function () {
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                window.editor.setValue(e.target.result);
                
                // Auto-detect language based on file extension
                const fileName = file.name;
                const extension = fileName.split('.').pop().toLowerCase();
                
                const extensionMap = {
                    'js': 'javascript',
                    'py': 'python',
                    'cpp': 'cpp',
                    'c': 'cpp',
                    'java': 'java',
                    'html': 'html',
                    'css': 'css',
                    'php': 'php',
                    'cs': 'csharp',
                    'go': 'go',
                    'rb': 'ruby',
                    'swift': 'swift',
                    'ts': 'typescript',
                    'rs': 'rust',
                    'kt': 'kotlin',
                    'sql': 'sql'
                };
                
                if (extensionMap[extension]) {
                    languageSelect.value = extensionMap[extension];
                    monaco.editor.setModelLanguage(window.editor.getModel(), extensionMap[extension]);
                }
                
                // Show a temporary notification
                let notification = document.createElement("div");
                notification.className = "fixed bottom-4 right-4 bg-primary text-white px-4 py-2 rounded-md shadow-lg animate-bounce-in";
                notification.innerHTML = `<i class="fas fa-check-circle mr-2"></i> File "${fileName}" loaded successfully!`;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.classList.add('animate-fade-out');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 500);
                }, 3000);
            };
            reader.readAsText(file);
        }
    });

    // Enhanced code completion
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
                    },
                    {
                        label: 'setTimeout',
                        kind: monaco.languages.CompletionItemKind.Function,
                        insertText: 'setTimeout(() => {\n\t$0\n}, ${1:1000});',
                        insertTextRules: monaco.languages.CompletionItemInsertTextRule.InsertAsSnippet,
                        documentation: "Executes code after a specified delay (in milliseconds)"
                    },
                    {
                        label: 'for loop',
                        kind: monaco.languages.CompletionItemKind.Snippet,
                        insertText: 'for (let ${1:i} = 0; ${1:i} < ${2:array}.length; ${1:i}++) {\n\t$0\n}',
                        insertTextRules: monaco.languages.CompletionItemInsertTextRule.InsertAsSnippet,
                        documentation: "Standard for loop"
                    },
                    {
                        label: 'forEach',
                        kind: monaco.languages.CompletionItemKind.Snippet,
                        insertText: '${1:array}.forEach((${2:item}) => {\n\t$0\n});',
                        insertTextRules: monaco.languages.CompletionItemInsertTextRule.InsertAsSnippet,
                        documentation: "Array forEach method"
                    },
                    {
                        label: 'map',
                        kind: monaco.languages.CompletionItemKind.Snippet,
                        insertText: 'const ${1:newArray} = ${2:array}.map((${3:item}) => {\n\treturn $0;\n});',
                        insertTextRules: monaco.languages.CompletionItemInsertTextRule.InsertAsSnippet,
                        documentation: "Array map method"
                    },
                    {
                        label: 'filter',
                        kind: monaco.languages.CompletionItemKind.Snippet,
                        insertText: 'const ${1:filteredArray} = ${2:array}.filter((${3:item}) => {\n\treturn $0;\n});',
                        insertTextRules: monaco.languages.CompletionItemInsertTextRule.InsertAsSnippet,
                        documentation: "Array filter method"
                    }
                ]
            };
        }
    });

    // Add keyboard shortcuts
    window.editor.addCommand(monaco.KeyMod.CtrlCmd | monaco.KeyCode.KeyS, function() {
        document.getElementById("downloadCode").click();
    });
    
    window.editor.addCommand(monaco.KeyMod.CtrlCmd | monaco.KeyCode.KeyR, function() {
        document.getElementById("runCode").click();
    });

    // Add a subtle animation to the editor on load
    setTimeout(() => {
        const editorElement = document.getElementById("editor");
        editorElement.style.transition = "box-shadow 0.5s ease";
        editorElement.style.boxShadow = "0 0 30px rgba(99, 102, 241, 0.3)";
    }, 1000);
    
    // Add an event listener to the editor for content changes
    window.editor.onDidChangeModelContent(function() {
        if (typeof updateEditorValues === 'function') {
            updateEditorValues();
        }
    });

    // Test that the editor is working
    console.log("Editor content length: " + window.editor.getValue().length);
});