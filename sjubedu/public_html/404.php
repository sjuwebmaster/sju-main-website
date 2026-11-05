<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/gtm.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | St Joseph's University</title>
    <link rel="icon" type="image/webp" href="https://sjub.s3.ap-south-1.amazonaws.com/Assets/logo.webp">
    
    <style>
        :root {
            --sju-blue: #004a99;
            --sju-dark: #002d5e;
            --bg-gray: #f8fafc;
        }

        body {
            background-color: var(--bg-gray);
            color: #334155;
            font-family: 'Segoe UI', system-ui, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #ffffff;
            padding: 60px 50px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            text-align: center;
            max-width: 500px;
            width: 90%;
            border-top: 6px solid var(--sju-blue);
            animation: fadeIn 0.6s ease-out;
        }

        .logo {
            max-width: 130px;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 72px;
            color: var(--sju-dark);
            margin: 0;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -2px;
        }

        h2 {
            font-size: 20px;
            color: #64748b;
            margin: 10px 0 30px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
        }

        p {
            line-height: 1.7;
            color: #475569;
            font-size: 1.1rem;
            margin-bottom: 40px;
        }

        .btn {
            display: inline-block;
            background: var(--sju-blue);
            color: #ffffff;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px 0 rgba(0, 74, 153, 0.25);
        }

        .btn:hover {
            background: var(--sju-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 74, 153, 0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .footer {
            margin-top: 50px;
            font-size: 0.85rem;
            color: #94a3b8;
            padding-top: 25px;
            border-top: 1px solid #f1f5f9;
        }
    </style>
</head>
<body>

    <div class="container">
        <img src="https://sjub.s3.ap-south-1.amazonaws.com/Assets/logo.webp" alt="SJU Logo" class="logo">
        
        <h1>404</h1>
        <h2>Resource Not Found</h2>
        
        <p>The page you are looking for might have been moved, deleted, or never existed.</p>

        <a href="/" class="btn">Return to Homepage</a>

        <div class="footer">
            &copy; 2026 St Joseph's University. <br>
            Managed by the University IT Department
        </div>
    </div>

</body>
</html>