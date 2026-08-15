<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin - SKM Dinas Arpus Pekalongan</title>
<style>
    * { box-sizing: border-box; }
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #003d7a, #007bff);
        margin: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .login-box {
        background: white;
        width: 100%;
        max-width: 400px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.25);
        padding: 40px;
    }
    .login-box h1 {
        color: #003d7a;
        font-size: 22px;
        text-align: center;
        margin-bottom: 5px;
    }
    .login-box p.sub {
        text-align: center;
        color: #777;
        font-size: 13px;
        margin-bottom: 30px;
    }
    label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #003d7a;
        font-size: 14px;
    }
    input[type=text], input[type=password] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
        margin-bottom: 18px;
    }
    button {
        width: 100%;
        background: #007bff;
        color: white;
        border: none;
        padding: 14px;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        font-size: 15px;
        transition: 0.2s;
    }
    button:hover { background: #003d7a; transform: translateY(-2px); }
    .error-msg {
        background: #fdecea;
        color: #b71c1c;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 13px;
        margin-bottom: 18px;
        text-align: center;
    }
    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        font-size: 13px;
        color: #007bff;
        text-decoration: none;
    }
</style>
</head>
<body>
    <div class="login-box">
        <h1>DASHBOARD ADMIN</h1>
        <p class="sub">SKM Dinas Kearsipan &amp; Perpustakaan Kab. Pekalongan</p>

        <?php if (!empty($errorMsg)): ?>
            <div class="error-msg"><?= htmlspecialchars($errorMsg, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?= form_open('admin/login', ['autocomplete' => 'off']); ?>
            <input type="hidden" name="csrf_token" value="<?= $this->session->userdata('csrf_token'); ?>">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required autofocus>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">MASUK</button>
        <?= form_close(); ?>
        <a href="<?= base_url(); ?>" class="back-link">&larr; Kembali ke Beranda</a>
    </div>
</body>
</html>
