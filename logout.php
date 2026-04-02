<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out - E-Sports League</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #00d4ff;
            --secondary: #7b2ff7;
            --success: #00ffc8;
            --dark: #0a0e27;
            --light: #ffffff;
            --gradient-1: linear-gradient(135deg, #00d4ff 0%, #7b2ff7 100%);
            --gradient-3: linear-gradient(135deg, #00ffc8 0%, #00d4ff 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--dark);
            color: var(--light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background: radial-gradient(circle at 30% 40%, rgba(0, 255, 200, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 70% 60%, rgba(0, 212, 255, 0.15) 0%, transparent 50%);
            animation: bg-pulse 15s ease infinite;
        }

        @keyframes bg-pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 0.8; }
        }

        /* Grid Pattern */
        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(0, 255, 200, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 200, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: grid-float 30s linear infinite;
            z-index: 0;
        }

        @keyframes grid-float {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Logout Container */
        .logout-container {
            position: relative;
            z-index: 10;
            max-width: 500px;
            width: 100%;
            padding: 0 20px;
            animation: zoomIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Logout Card */
        .logout-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(0, 255, 200, 0.3);
            border-radius: 30px;
            padding: 50px 40px;
            text-align: center;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .logout-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-3);
            animation: glow-pulse 2s ease-in-out infinite;
        }

        @keyframes glow-pulse {
            0%, 100% {
                box-shadow: 0 0 20px rgba(0, 255, 200, 0.5);
            }
            50% {
                box-shadow: 0 0 40px rgba(0, 255, 200, 0.8);
            }
        }

        /* Success Icon */
        .logout-icon {
            width: 100px;
            height: 100px;
            background: var(--gradient-3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            position: relative;
            animation: successPop 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            box-shadow: 0 10px 40px rgba(0, 255, 200, 0.5);
        }

        @keyframes successPop {
            0% {
                transform: scale(0) rotate(-180deg);
                opacity: 0;
            }
            60% {
                transform: scale(1.2) rotate(10deg);
            }
            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        .logout-icon::before {
            content: '';
            position: absolute;
            width: 120%;
            height: 120%;
            border-radius: 50%;
            border: 3px solid rgba(0, 255, 200, 0.3);
            animation: ring-pulse 2s ease-out infinite;
        }

        @keyframes ring-pulse {
            0% {
                transform: scale(0.9);
                opacity: 1;
            }
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .logout-icon i {
            font-size: 3.5rem;
            color: white;
            animation: checkmark-draw 0.6s ease-out 0.3s both;
        }

        @keyframes checkmark-draw {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Content */
        .logout-content {
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logout-content h2 {
            font-size: 2.2rem;
            font-weight: 900;
            background: var(--gradient-3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .logout-content p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
            margin-bottom: 35px;
        }

        /* Home Button */
        .btn-home {
            background: var(--gradient-3);
            border: none;
            color: white;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.4s;
            box-shadow: 0 10px 30px rgba(0, 255, 200, 0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-home::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-home:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 255, 200, 0.6);
            color: white;
        }

        .btn-home span {
            position: relative;
            z-index: 1;
        }

        /* Countdown */
        .countdown {
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
            animation: fadeIn 1s ease-out 0.8s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Confetti Effect */
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background: var(--success);
            position: absolute;
            animation: confetti-fall 3s ease-out forwards;
        }

        @keyframes confetti-fall {
            to {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* Responsive */
        @media (max-width: 576px) {
            .logout-card {
                padding: 40px 30px;
            }
            .logout-icon {
                width: 80px;
                height: 80px;
            }
            .logout-icon i {
                font-size: 3rem;
            }
            .logout-content h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg"></div>
    <div class="grid-overlay"></div>

    <!-- Logout Container -->
    <div class="logout-container">
        <div class="logout-card">
            <div class="logout-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <div class="logout-content">
                <h2>Successfully Logged Out</h2>
                <p>Thank you for using the admin portal. Stay safe!</p>
                
                <a href="index.html" class="btn-home">
                    <span><i class="fas fa-home me-2"></i>Back to Home</span>
                </a>
                
                <div class="countdown">
                    Redirecting in <span id="countdown">3</span> seconds...
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Countdown and redirect
        let count = 3;
        const countdownEl = document.getElementById('countdown');
        
        const timer = setInterval(() => {
            count--;
            countdownEl.textContent = count;
            
            if (count <= 0) {
                clearInterval(timer);
                window.location.href = 'index.html';
            }
        }, 1000);

        // Create confetti effect
        function createConfetti() {
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.top = '-10px';
                    confetti.style.background = `hsl(${Math.random() * 360}, 70%, 60%)`;
                    confetti.style.animationDelay = Math.random() * 2 + 's';
                    confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
                    document.body.appendChild(confetti);
                    
                    setTimeout(() => confetti.remove(), 5000);
                }, i * 30);
            }
        }

        // Trigger confetti on load
        setTimeout(createConfetti, 300);

        // Button ripple effect
        document.querySelector('.btn-home').addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.style.position = 'absolute';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(255, 255, 255, 0.6)';
            ripple.style.transform = 'scale(0)';
            ripple.style.animation = 'ripple 0.6s ease-out';
            ripple.style.pointerEvents = 'none';
            
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });

        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>