<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#1e2d5e">
    <title>BlotterLink — Offline</title>
    <link rel="manifest" href="/manifest.json">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Inter, sans-serif; background: #f5f7fa; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        .card { background: #fff; border-radius: 16px; padding: 40px 32px; text-align: center; max-width: 400px; width: 100%; box-shadow: 0 4px 20px rgba(30,45,94,.1); border: 1px solid #e5e9f0; }
        .icon { width: 64px; height: 64px; border-radius: 16px; background: #e8eef8; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 28px; }
        h1 { font-size: 20px; font-weight: 700; color: #1e2d5e; margin-bottom: 8px; }
        p { font-size: 14px; color: #64748b; line-height: 1.6; margin-bottom: 24px; }
        .btn { display: inline-block; background: #1e2d5e; color: #fff; border-radius: 8px; padding: 12px 28px; font-size: 14px; font-weight: 600; text-decoration: none; cursor: pointer; border: none; font-family: Inter, sans-serif; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">📡</div>
        <h1>You're Offline</h1>
        <p>It looks like you don't have an internet connection. Please check your connection and try again.</p>
        <button class="btn" onclick="window.location.reload()">Try Again</button>
    </div>
</body>
</html>