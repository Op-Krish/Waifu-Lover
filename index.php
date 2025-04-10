<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✨ Ultra Cool PHP Page</title>
    <style>
        :root {
            --primary: #6c5ce7;
            --secondary: #a29bfe;
            --accent: #fd79a8;
            --dark: #2d3436;
            --light: #f5f6fa;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--light);
            padding: 2rem;
        }
        
        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 800px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, var(--light), var(--accent));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .server-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .info-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 12px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .info-card h3 {
            color: var(--accent);
            margin-bottom: 0.5rem;
        }
        
        .dynamic-content {
            margin: 2rem 0;
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
        }
        
        button {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            margin: 0.5rem;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        button:hover {
            background: white;
            color: var(--accent);
            transform: scale(1.05);
        }
        
        footer {
            margin-top: 2rem;
            opacity: 0.8;
            font-size: 0.9rem;
        }
        
        .glow {
            animation: glow 2s infinite alternate;
        }
        
        @keyframes glow {
            from {
                text-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
            }
            to {
                text-shadow: 0 0 15px rgba(253, 121, 168, 0.8);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="glow">Welcome to <br>PHP <?php echo phpversion(); ?>!</h1>
        
        <div class="server-info">
            <div class="info-card">
                <h3>Server Time</h3>
                <p><?php echo date('Y-m-d H:i:s'); ?></p>
            </div>
            
            <div class="info-card">
                <h3>Your IP</h3>
                <p><?php echo $_SERVER['REMOTE_ADDR']; ?></p>
            </div>
            
            <div class="info-card">
                <h3>Server Software</h3>
                <p><?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
            </div>
        </div>
        
        <div class="dynamic-content">
            <h3>Dynamic Content</h3>
            <?php
                $visits = isset($_COOKIE['visits']) ? $_COOKIE['visits'] + 1 : 1;
                setcookie('visits', $visits, time() + (86400 * 30), "/");
                
                $messages = [
                    "You're awesome!",
                    "PHP rocks!",
                    "Have a great day!",
                    "The server loves you!",
                    "Make something amazing!"
                ];
                $randomMessage = $messages[array_rand($messages)];
            ?>
            <p>This is your visit #<?php echo $visits; ?></p>
            <p><?php echo $randomMessage; ?></p>
            
            <button onclick="loadNewMessage()">New Message</button>
            <button onclick="changeTheme()">Change Theme</button>
        </div>
        
        <footer>
            Page generated in <?php echo microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']; ?> seconds
        </footer>
    </div>
    
    <script>
        function loadNewMessage() {
            fetch(window.location.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.dynamic-content p:last-child').textContent;
                document.querySelector('.dynamic-content p:last-child').textContent = newContent;
            });
        }
        
        function changeTheme() {
            const root = document.documentElement;
            const themes = [
                { primary: '#6c5ce7', secondary: '#a29bfe', accent: '#fd79a8' },
                { primary: '#00b894', secondary: '#55efc4', accent: '#ffeaa7' },
                { primary: '#e17055', secondary: '#fab1a0', accent: '#fdcb6e' },
                { primary: '#0984e3', secondary: '#74b9ff', accent: '#ff7675' }
            ];
            
            const currentTheme = window.currentTheme || 0;
            const nextTheme = (currentTheme + 1) % themes.length;
            window.currentTheme = nextTheme;
            
            root.style.setProperty('--primary', themes[nextTheme].primary);
            root.style.setProperty('--secondary', themes[nextTheme].secondary);
            root.style.setProperty('--accent', themes[nextTheme].accent);
        }
    </script>
</body>
</html>
