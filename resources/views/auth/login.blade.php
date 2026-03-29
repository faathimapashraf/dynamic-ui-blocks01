<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f9fafb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 380px;
            padding: 20px;
        }

        .card {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
            color: #111827;
        }

        .subtitle {
            font-size: 14px;
            color: #6b7280;
            margin: 8px 0 25px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 13px;
        }

        label {
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 15px;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
        }

        button {
            width: 100%;
            padding: 11px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .footer {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-top: 18px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">

        <h2>Sign in</h2>
        <p class="subtitle">Enter your credentials to continue</p>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <div class="footer">
            Role-based access (Admin / User)
        </div>

    </div>
</div>

</body>
</html>