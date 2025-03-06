<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PasteByte - Share Your Code with Ease</title>
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
    <style type="text/tailwindcss">
        @layer utilities {
            .text-glow {
                text-shadow: 0 0 10px rgba(99, 102, 241, 0.7), 0 0 20px rgba(99, 102, 241, 0.5);
            }
            .bg-grid {
                background-image: 
                    linear-gradient(rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.9)),
                    linear-gradient(to right, rgba(99, 102, 241, 0.1) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(99, 102, 241, 0.1) 1px, transparent 1px);
                background-size: 100%, 20px 20px, 20px 20px;
            }
            .animate-delay-100 {
                animation-delay: 100ms;
            }
            .animate-delay-200 {
                animation-delay: 200ms;
            }
            .animate-delay-300 {
                animation-delay: 300ms;
            }
            .animate-delay-400 {
                animation-delay: 400ms;
            }
            .animate-delay-500 {
                animation-delay: 500ms;
            }
            .hover-scale {
                transition: transform 0.3s ease;
            }
            .hover-scale:hover {
                transform: scale(1.05);
            }
            .btn-hover-effect {
                position: relative;
                overflow: hidden;
            }
            .btn-hover-effect:after {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: 0.5s;
            }
            .btn-hover-effect:hover:after {
                left: 100%;
            }
        }
    </style>
</head>