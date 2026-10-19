<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background: #f8fafc;
            color: #111827;
        }

        .wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .card {
            width: 100%;
            max-width: 520px;
            background: white;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 14px 35px rgba(0,0,0,0.08);
        }

        .badge {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            background: #fef3c7;
            color: #b45309;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 14px;
        }

        h1 {
            margin: 0 0 10px;
            font-size: 30px;
        }

        .subtitle {
            margin: 0;
            color: #6b7280;
            line-height: 1.8;
            font-size: 14px;
        }

        .note {
            margin-top: 20px;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            padding: 16px;
            border-radius: 16px;
            line-height: 1.8;
            font-size: 14px;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 22px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: #2563eb;
            color: white;
            padding: 12px 16px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-light {
            background: #e5e7eb;
            color: #111827;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <span class="badge">Lupa Password</span>
            <h1>Reset Password</h1>
            <p class="subtitle">
                Jika Anda lupa password, silakan hubungi admin atau pengelola sistem untuk bantuan reset password.
            </p>

            <div class="note">
                Untuk keamanan, reset password tidak dilakukan otomatis melalui email atau OTP.
                Perubahan password akan dibantu langsung oleh admin sistem.
            </div>

            <div class="actions">
                <a href="{{ route('login') }}" class="btn">Kembali ke Login</a>
            </div>

            <div class="footer">
                © {{ date('Y') }} PT Djanjikita Putra Mandiri
            </div>
        </div>
    </div>
</body>
</html>