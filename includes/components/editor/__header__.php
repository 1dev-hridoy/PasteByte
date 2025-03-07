<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PasteByte Code Editor</title>
    <script src="./assets/plugin/loader.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="./assets/js/editor.tailwind.config.js"></script>
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