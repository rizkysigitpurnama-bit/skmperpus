<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih - E-Survei Arpus Pekalongan</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <style>
        .tk-wrap { min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .tk-card {
            background: white; max-width: 480px; width: 100%; text-align: center;
            padding: 50px 40px; border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>
<div class="tk-wrap">
    <div class="tk-card">
        <div class="checkmark-circle" style="margin: 0 auto 20px;"><div class="checkmark-icon">✓</div></div>
        <h1 style="color: var(--hijau); margin: 0 0 10px;">Terima Kasih<?= $nama ? ', ' . $nama : '' ?>!</h1>
        <p style="font-size: 16px; color: #666; margin-bottom: 30px;">
            Jawaban survei Anda telah berhasil disimpan. Masukan Anda sangat membantu
            Dinas Kearsipan dan Perpustakaan Kabupaten Pekalongan meningkatkan kualitas pelayanan.
        </p>
        <a href="<?= base_url(); ?>" class="btn" style="text-decoration:none; display:inline-block;">KEMBALI KE BERANDA</a>
    </div>
</div>
</body>
</html>
