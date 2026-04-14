<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline - Sproutplex Jobs</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .offline-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 48px;
            padding: 3rem;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 50px 100px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .signal-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1e2937;
            margin-bottom: 1rem;
        }

        .signal-bars {
            display: flex;
            justify-content: center;
            gap: 4px;
            margin: 2rem 0;
        }

        .bar {
            width: 12px;
            height: 30px;
            background: #e2e8f0;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .bar.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            animation: barWave 1.5s infinite;
        }

        .bar-1 {
            animation-delay: 0s;
        }

        .bar-2 {
            animation-delay: 0.2s;
        }

        .bar-3 {
            animation-delay: 0.4s;
        }

        .bar-4 {
            animation-delay: 0.6s;
        }

        @keyframes barWave {

            0%,
            100% {
                height: 30px;
            }

            50% {
                height: 50px;
            }
        }

        p {
            color: #64748b;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .tips {
            background: #f8fafc;
            border-radius: 24px;
            padding: 1.5rem;
            margin: 2rem 0;
            text-align: left;
        }

        .tips h3 {
            color: #1e2937;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tips ul {
            list-style: none;
        }

        .tips li {
            color: #475569;
            padding: 8px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .tips li:last-child {
            border-bottom: none;
        }

        .tips li i {
            color: #10b981;
        }

        .button {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 60px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }

        .saved-indicator {
            margin-top: 2rem;
            padding: 1rem;
            background: #f0fdf4;
            border-radius: 16px;
            color: #047857;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 0.95rem;
        }

        .saved-indicator i {
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <div class="offline-card">
        <div class="signal-icon">📡</div>

        <h1>You're Offline</h1>

        <div class="signal-bars">
            <div class="bar bar-1 active"></div>
            <div class="bar bar-2 active"></div>
            <div class="bar bar-3"></div>
            <div class="bar bar-4"></div>
        </div>

        <p>We can't detect an internet connection. Don't worry, you can still access some features.</p>

        <div class="tips">
            <h3>
                <i class="💡"></i>
                While you're offline:
            </h3>
            <ul>
                <li>
                    <i>✓</i>
                    View recently viewed jobs
                </li>
                <li>
                    <i>✓</i>
                    Read saved job descriptions
                </li>
                <li>
                    <i>✓</i>
                    Review application drafts
                </li>
            </ul>
        </div>

        <button onclick="retryConnection()" class="button">
            <span class="btn-text">Try Reconnecting</span>
            <span class="btn-icon">↻</span>
        </button>

        <div class="saved-indicator">
            <i>✓</i>
            <span>You have 5 saved jobs available offline</span>
        </div>
    </div>

    <script>
        function retryConnection() {
            const button = document.querySelector('.button');
            button.innerHTML = '<span class="btn-text">Checking...</span> <span class="btn-icon">⌛</span>';

            setTimeout(() => {
                if (navigator.onLine) {
                    window.location.reload();
                } else {
                    button.innerHTML =
                        '<span class="btn-text">Still Offline</span> <span class="btn-icon">⚠️</span>';
                    setTimeout(() => {
                        button.innerHTML =
                            '<span class="btn-text">Try Reconnecting</span> <span class="btn-icon">↻</span>';
                    }, 2000);
                }
            }, 1500);
        }

        // Listen for connection restoration
        window.addEventListener('online', function() {
            window.location.reload();
        });
    </script>
</body>

</html>
