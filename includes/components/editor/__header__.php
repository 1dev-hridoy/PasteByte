<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SnipSync Code Editor</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/loader.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#6366f1',
                            dark: '#4f46e5',
                        },
                        dark: {
                            DEFAULT: '#0f172a',
                            lighter: '#1e293b',
                        },
                    },
                    animation: {
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 3s ease-in-out infinite',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'slide-down': 'slideDown 0.5s ease-out',
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'bounce-in': 'bounceIn 0.8s ease-out',
                        'spin-slow': 'spin 8s linear infinite',
                        'wiggle': 'wiggle 1s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideDown: {
                            '0%': { transform: 'translateY(-20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        bounceIn: {
                            '0%': { transform: 'scale(0.8)', opacity: '0' },
                            '70%': { transform: 'scale(1.05)', opacity: '1' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                        wiggle: {
                            '0%, 100%': { transform: 'rotate(-3deg)' },
                            '50%': { transform: 'rotate(3deg)' },
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="./assets/css/editor.css">
</head>
<body class="bg-dark text-gray-100 font-sans overflow-x-hidden bg-grid min-h-screen">
    <!-- Header -->
    <header class="w-full bg-dark/80 backdrop-blur-md border-b border-gray-800 py-4">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between">
                <a href="index.html" class="text-2xl font-bold text-white flex items-center animate-fade-in">
                    <span class="text-primary mr-1"><i class="fas fa-code"></i></span>
                    Paste<span class="text-primary">Byte</span>
                    <span class="ml-2 text-sm bg-dark-lighter px-2 py-1 rounded-md">Editor</span>
                </a>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">
                        <i class="fas fa-question-circle"></i>
                        <span class="ml-1 hidden md:inline">Help</span>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">
                        <i class="fas fa-cog"></i>
                        <span class="ml-1 hidden md:inline">Settings</span>
                    </a>
                    <a href="#" class="px-4 py-2 rounded-md bg-primary hover:bg-primary-dark transition-colors duration-300 btn-hover-effect">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span class="ml-1">Share</span>
                    </a>
                </div>
            </div>
        </div>
    </header>