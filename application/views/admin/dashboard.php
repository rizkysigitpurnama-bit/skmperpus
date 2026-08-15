<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SKM Dinas Arpus Pekalongan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { 
            --biru: #003d7a; 
            --langit: #007bff; 
            --hijau: #28a745; 
            --merah: #dc3545;
            --abu-bg: #f4f7fa; 
            --abu-border: #dde3ec;
            --text: #333; 
            --text-muted: #6c757d;
        }

        * { box-sizing: border-box; font-family: 'Segoe UI', system-ui, sans-serif; }
        body { background: var(--abu-bg); margin: 0; color: var(--text); display: flex; min-height: 100vh; }

        /* SIDEBAR COMPONENT */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, var(--biru), #00264d);
            color: white;
            position: fixed;
            top: 0; bottom: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }
        .sidebar-brand {
            padding: 25px 20px;
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
            flex: 1;
        }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: 0.2s;
        }
        .sidebar-menu li a:hover, .sidebar-menu li.active a {
            color: white;
            background: rgba(255,255,255,0.1);
            border-left: 4px solid var(--langit);
        }
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            background: rgba(255,255,255,0.15);
            color: white;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            transition: 0.2s;
        }
        .btn-logout:hover { background: var(--merah); }

        /* MAIN CONTENT LAYOUT */
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 30px;
            max-width: calc(100% - 260px);
        }

        /* TOPBAR / HEADER */
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .content-header h1 { font-size: 24px; font-weight: 700; color: var(--biru); margin: 0; }
        .user-greeting { font-size: 14px; color: var(--text-muted); }
        .user-greeting b { color: var(--text); }

        /* NOTIFICATION */
        .notif-box {
            background: #e7f7ec;
            color: #1b6b3a;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: 500;
            border-left: 5px solid var(--hijau);
        }

        /* STATS CARD GRAPHICS */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.02);
            position: relative;
            overflow: hidden;
        }
        .stat-card .angka { font-size: 36px; font-weight: 800; color: var(--biru); line-height: 1.2; }
        .stat-card .label { font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 5px; }
        
        .badge-predikat {
            display: inline-block;
            margin-top: 10px;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        /* PANEL DESIGN */
        .panel {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            margin-bottom: 30px;
            border: 1px solid rgba(0,0,0,0.02);
        }
        .panel h2 { font-size: 16px; font-weight: 700; color: var(--biru); margin-top: 0; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px; }

        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        /* MANAGEMENT UPLOAD PDF */
        .upload-container {
            display: grid;
            grid-template-columns: 1fr 1.3fr;
            gap: 30px;
        }
        .form-group-pdf { margin-bottom: 16px; }
        .form-group-pdf label { display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px; }
        
        .form-group-pdf input[type="text"],
        .form-group-pdf input[type="number"],
        .form-group-pdf textarea {
            width: 100%;
            padding: 12px;
            border: 1.5px solid var(--abu-border);
            border-radius: 8px;
            font-size: 14px;
            transition: 0.2s;
        }
        .form-group-pdf input:focus, .form-group-pdf textarea:focus {
            outline: none; border-color: var(--langit); box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
        }
        
        .btn-submit-pdf {
            background: var(--biru);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
            width: 100%;
            transition: 0.2s;
        }
        .btn-submit-pdf:hover { background: #00264d; transform: translateY(-1px); }

        /* DATA FILTER TOOLBAR */
        .toolbar {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .toolbar input, .toolbar select {
            padding: 10px 14px;
            border: 1.5px solid var(--abu-border);
            border-radius: 8px;
            font-size: 14px;
            background: white;
        }
        .toolbar button, .toolbar a.btn-export {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background: var(--langit);
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
        }
        .toolbar button:hover { background: var(--biru); }
        .toolbar a.btn-export { background: var(--hijau); }
        .toolbar a.btn-export:hover { background: #1e7e34; }

        /* MODERN RESPONSIVE TABLES */
        .table-container { 
            overflow-x: auto; 
            border: 1px solid var(--abu-border);
            border-radius: 12px;
        }
        table { width: 100%; border-collapse: collapse; background: white; }
        th { background: #f8f9fa; color: var(--biru); padding: 14px 12px; font-size: 13px; font-weight: 700; text-align: center; border-bottom: 2px solid var(--abu-border); white-space: nowrap; }
        td { padding: 12px 10px; border-bottom: 1px solid var(--abu-border); text-align: center; font-size: 13px; color: #444; }
        tr:hover td { background: rgba(0,123,255,0.02); }
        
        .mini-table-container {
            max-height: 380px;
            overflow-y: auto;
            border: 1px solid var(--abu-border);
            border-radius: 10px;
        }
        
        .btn-action-view {
            background-color: var(--langit); color: white; padding: 6px 12px; 
            text-decoration: none; border-radius: 6px; font-size: 12px; font-weight: 600;
            display: inline-block; transition: 0.2s;
        }
        .btn-action-view:hover { background: var(--biru); }

        .btn-hapus {
            background: rgba(220, 53, 69, 0.1);
            color: var(--merah);
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: 0.2s;
        }
        .btn-hapus:hover { background: var(--merah); color: white; }
        .saran-cell { max-width: 220px; white-space: normal; text-align: left; color: #555; line-height: 1.4; }

        /* PAGINATION */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 25px;
        }
        .pagination .page-btn {
            padding: 8px 16px;
            border-radius: 8px;
            background: white;
            color: var(--text);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            border: 1.5px solid var(--abu-border);
            transition: 0.2s;
        }
        .pagination .page-btn:hover { border-color: var(--langit); color: var(--langit); }
        .pagination .page-btn.disabled {
            background: #e9ecef;
            color: #ccc;
            border-color: var(--abu-border);
            pointer-events: none;
        }
        .pagination .page-info { font-size: 13px; color: var(--text-muted); font-weight: 500; }

        /* RESPONSIVE DESIGN BREAKPOINTS */
        @media (max-width: 1024px) {
            .sidebar { width: 70px; }
            .sidebar-brand span, .sidebar-menu li a span, .sidebar-footer { display: none; }
            .sidebar-brand { justify-content: center; padding: 20px 0; }
            .sidebar-menu li a { justify-content: center; padding: 15px 0; font-size: 18px; }
            .main-content { margin-left: 70px; max-width: calc(100% - 70px); padding: 20px; }
            .charts-grid, .upload-container { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .content-header { flex-direction: column; align-items: flex-start; gap: 8px; }
            thead { display: none; }
            table, tbody, tr, td { display: block; width: 100%; }
            tr {
                background: #fff;
                border: 1px solid var(--abu-border);
                border-radius: 12px;
                margin-bottom: 15px;
                padding: 8px 0;
                box-shadow: 0 2px 5px rgba(0,0,0,0.02);
            }
            td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: right;
                padding: 10px 15px;
                border-bottom: 1px solid #f2f2f2;
                font-size: 13px;
            }
            td:last-child { border-bottom: none; }
            td::before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--biru);
                text-align: left;
                font-size: 11px;
                text-transform: uppercase;
            }
            .saran-cell { text-align: right; max-width: 100%; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR COMPONENT -->
<div class="sidebar">
    <div class="sidebar-brand">
        <i class="fa-solid deductions fa-chart-pie" style="color: var(--langit); font-size: 20px;"></i>
        <span>ARPUS PANEL</span>
    </div>
    <ul class="sidebar-menu">
        <li class="active"><a href="#"><i class="fa-solid fa-gauge"></i> <span>Dashboard</span></a></li>
        <li><a href="#publikasi-section"><i class="fa-solid fa-file-pdf"></i> <span>Laporan PDF</span></a></li>
        <li><a href="#data-section"><i class="fa-solid fa-users"></i> <span>Data Responden</span></a></li>
    </ul>
    <div class="sidebar-footer">
        <a href="<?= site_url('admin/logout'); ?>" class="btn-logout">
            <i class="fa-solid fa-sign-out-alt"></i> <span>KELUAR</span>
        </a>
    </div>
</div>

<!-- MAIN DASHBOARD CONTAINER -->
<div class="main-content">

    <div class="content-header">
        <div>
            <h1>Dashboard SKM</h1>
            <div class="user-greeting">Dinas Kearsipan dan Perpustakaan Kota Pekalongan</div>
        </div>
        <div class="user-greeting">
            Halo, <b><?= htmlspecialchars($this->session->userdata('admin_nama') ?: $this->session->userdata('admin_username'), ENT_QUOTES, 'UTF-8') ?></b>
        </div>
    </div>

    <?php if ($notif): ?>
        <div class="notif-box"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($notif, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <!-- STATISTIK CARDS -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="angka"><?= $totalFilter ?></div>
            <div class="label">Total Responden</div>
        </div>
        <div class="stat-card">
            <div class="angka" style="color: <?= warnaPredikat($ikmKeseluruhan) ?>;"><?= number_format($ikmKeseluruhan, 2) ?>%</div>
            <div class="label">Nilai IKM Keseluruhan</div>
            <span class="badge-predikat" style="background: <?= warnaPredikat($ikmKeseluruhan) ?>;"><?= predikatIkm($ikmKeseluruhan) ?></span>
        </div>
        <div class="stat-card">
            <div class="angka"><?= count($tahunList) ?></div>
            <div class="label">Tahun Survei Tercatat</div>
        </div>
    </div>

    <!-- GRAPHICS PANEL -->
    <div class="panel">
        <h2><i class="fa-solid fa-chart-line"></i> Grafik Statistik Kepuasan</h2>
        <div class="charts-grid">
            <div>
                <canvas id="chartTahun" height="160"></canvas>
            </div>
            <div>
                <canvas id="chartUnsur" height="160"></canvas>
            </div>
        </div>
    </div>

    <!-- PDF MANAGEMENT PANEL -->
    <div class="panel" id="publikasi-section">
        <h2><i class="fa-solid fa-cloud-arrow-up"></i> Manajemen Publikasi Laporan SKM (PDF)</h2>
        <div class="upload-container">
            
            <!-- FORM UPLOAD -->
            <div style="background: #fafbfc; padding: 20px; border-radius: 12px; border: 1px solid var(--abu-border);">
                <form method="POST" action="<?= site_url('dashboard'); ?>" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload_laporan">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($this->session->userdata('csrf_token'), ENT_QUOTES, 'UTF-8') ?>">
                    
                    <div class="form-group-pdf">
                        <label>Tahun Laporan</label>
                        <input type="number" name="tahun" value="<?= date('Y') ?>" min="2015" max="2050" required>
                    </div>
                    <div class="form-group-pdf">
                        <label>Judul Laporan</label>
                        <input type="text" name="judul" placeholder="Contoh: Laporan SKM Semester I 2026" required>
                    </div>
                    <div class="form-group-pdf">
                        <label>Deskripsi Singkat</label>
                        <textarea name="deskripsi" rows="3" placeholder="Tulis ringkasan info berkas..." required style="resize:vertical;"></textarea>
                    </div>
                    <div class="form-group-pdf">
                        <label>Pilih File PDF (Maksimal 10MB)</label>
                        <input type="file" name="file_pdf" accept="application/pdf" required style="margin-top:5px;">
                    </div>
                    <button type="submit" class="btn-submit-pdf"><i class="fa-solid fa-paper-plane"></i> Muli Publikasikan</button>
                </form>
            </div>

            <!-- TABLE VIEW BERKAS PDF -->
            <div class="mini-table-container">
                <table style="font-size: 13.5px;">
                    <thead style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th style="width: 15%;">Tahun</th>
                            <th>Judul File / Informasi</th>
                            <th style="width: 30%;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($list_laporan)): ?>
                            <?php foreach ($list_laporan as $laporan): ?>
                                <tr>
                                    <td style="font-weight:600;"><?= htmlspecialchars($laporan['tahun'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td style="text-align: left; padding: 12px;">
                                        <strong style="color: #222;"><?= htmlspecialchars($laporan['judul'], ENT_QUOTES, 'UTF-8'); ?></strong><br>
                                        <small style="color: #666;"><?= htmlspecialchars($laporan['deskripsi'], ENT_QUOTES, 'UTF-8'); ?></small>
                                    </td>
                                    <td>
                                        <div style="display:flex; gap:6px; justify-content: center;">
                                            <a href="<?= base_url('uploads/' . $laporan['file_pdf']); ?>" target="_blank" class="btn-action-view">
                                                Lihat
                                            </a>
                                            <form method="POST" action="<?= site_url('dashboard/hapus_laporan'); ?>" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');" style="display:inline;">
                                                <input type="hidden" name="action" value="hapus_pdf">
                                                <input type="hidden" name="id" value="<?= $laporan['id']; ?>">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($this->session->userdata('csrf_token'), ENT_QUOTES, 'UTF-8') ?>">
                                                <button type="submit" class="btn-hapus">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" style="color: #888; padding: 40px; background: white;">
                                    <i class="fa-regular fa-folder-open" style="font-size:24px; margin-bottom:10px; display:block; color:#ccc;"></i>
                                    Belum ada dokumen PDF terbit.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MAIN RESPONDENT DATA PANEL -->
    <div class="panel" id="data-section">
        <h2><i class="fa-solid fa-table-list"></i> Data Responden Hasil Survei</h2>

        <form method="GET" action="<?= site_url('admin/dashboard'); ?>" class="toolbar">
            <input type="text" name="cari" placeholder="Cari nama, kecamatan, layanan..." value="<?= htmlspecialchars($cari, ENT_QUOTES, 'UTF-8') ?>" style="flex:1; min-width:200px;">
            <select name="tahun">
                <option value="">-- Semua Tahun --</option>
                <?php foreach ($tahunList as $ty): ?>
                    <option value="<?= $ty ?>" <?= ($tahunPil !== '' && (int)$tahunPil === (int)$ty) ? 'selected' : '' ?>><?= $ty ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Filter</button>
            <a class="btn-export" href="<?= site_url('admin/export') ?>?cari=<?= urlencode($cari) ?>&tahun=<?= urlencode($tahunPil) ?>"><i class="fa-solid fa-file-excel"></i> Export Excel</a>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th><th>Nama</th><th>JK</th><th>Usia</th><th>No. HP</th>
                        <th>Pendidikan</th><th>Pekerjaan</th><th>Kecamatan</th><th>Layanan</th>
                        <th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th><th>Q5</th><th>Q6</th><th>Q7</th><th>Q8</th><th>Q9</th>
                        <th>Saran</th><th>Tahun</th><th>Waktu Isi</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($dataResponden)): ?>
                    <tr><td colspan="21" style="padding: 40px; color:#999;">Belum ada data responden yang sesuai.</td></tr>
                <?php else: ?>
                    <?php foreach ($dataResponden as $d): ?>
                        <tr>
                            <td data-label="ID"><?= (int)$d['id'] ?></td>
                            <td data-label="Nama" style="font-weight:600; text-align:left; white-space:nowrap;"><?= htmlspecialchars($d['nama'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td data-label="JK"><?= htmlspecialchars($d['jk'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td data-label="Usia"><?= htmlspecialchars($d['usia'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td data-label="No. HP"><?= htmlspecialchars($d['wa'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td data-label="Pendidikan"><?= htmlspecialchars($d['pendidikan'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td data-label="Pekerjaan"><?= htmlspecialchars($d['pekerjaan'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td data-label="Kecamatan"><?= htmlspecialchars($d['kecamatan'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td data-label="Layanan" style="text-align:left; min-width:120px;"><?= htmlspecialchars($d['layanan'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td data-label="Q1" style="font-weight:600;"><?= (int)$d['q1'] ?></td>
                            <td data-label="Q2" style="font-weight:600;"><?= (int)$d['q2'] ?></td>
                            <td data-label="Q3" style="font-weight:600;"><?= (int)$d['q3'] ?></td>
                            <td data-label="Q4" style="font-weight:600;"><?= (int)$d['q4'] ?></td>
                            <td data-label="Q5" style="font-weight:600;"><?= (int)$d['q5'] ?></td>
                            <td data-label="Q6" style="font-weight:600;"><?= (int)$d['q6'] ?></td>
                            <td data-label="Q7" style="font-weight:600;"><?= (int)$d['q7'] ?></td>
                            <td data-label="Q8" style="font-weight:600;"><?= (int)$d['q8'] ?></td>
                            <td data-label="Q9" style="font-weight:600;"><?= (int)$d['q9'] ?></td>
                            <td class="saran-cell" data-label="Saran"><?= nl2br(htmlspecialchars($d['saran'], ENT_QUOTES, 'UTF-8')) ?></td>
                            <td data-label="Tahun"><?= (int)$d['tahun'] ?></td>
                            <td data-label="Waktu Isi" style="white-space:nowrap;"><?= htmlspecialchars($d['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td data-label="Aksi">
                                <form method="POST" action="<?= site_url('admin/dashboard'); ?>" onsubmit="return confirm('Yakin ingin menghapus data responden ini?');">
                                    <input type="hidden" name="action" value="hapus">
                                    <input type="hidden" name="id" value="<?= (int)$d['id'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($this->session->userdata('csrf_token'), ENT_QUOTES, 'UTF-8') ?>">
                                    <button type="submit" class="btn-hapus"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION SECTION -->
        <?php if ($totalHalaman > 1): ?>
        <div class="pagination">
            <?php
                $qs = ['cari' => $cari, 'tahun' => $tahunPil];
                function buatLinkHalaman($h, $qs) { return site_url('admin/dashboard') . '?' . http_build_query(array_merge($qs, ['halaman' => $h])); }
            ?>
            <a href="<?= buatLinkHalaman(max(1, $halaman - 1), $qs) ?>" class="page-btn <?= $halaman <= 1 ? 'disabled' : '' ?>"><i class="fa-solid fa-chevron-left"></i></a>
            <span class="page-info">Halaman <b><?= $halaman ?></b> dari <?= $totalHalaman ?> (Total <?= $totalFilter ?> data)</span>
            <a href="<?= buatLinkHalaman(min($totalHalaman, $halaman + 1), $qs) ?>" class="page-btn <?= $halaman >= $totalHalaman ? 'disabled' : '' ?>"><i class="fa-solid fa-chevron-right"></i></a>
        </div>
        <?php endif; ?>
    </div>

</div>

<!-- GRAPH DATA CHARTS INITIALIZATION -->
<script>
    const grafikTahun = <?= json_encode($grafikTahun) ?>;
    const grafikSkor  = <?= json_encode($grafikSkor) ?>;
    const unsurData   = <?= json_encode($unsurData) ?>;

    new Chart(document.getElementById('chartTahun'), {
        type: 'line',
        data: {
            labels: grafikTahun,
            datasets: [{
                label: 'Nilai IKM per Tahun (%)',
                data: grafikSkor,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0,123,255,0.08)',
                fill: true,
                tension: 0.3,
                borderWidth: 3,
                pointBackgroundColor: '#007bff'
            }]
        },
        options: {
            responsive: true,
            plugins: { title: { display: true, text: 'Tren Nilai IKM per Tahun', font: { size: 14, weight: 'bold' } } },
            scales: { y: { min: 0, max: 100 } }
        }
    });

    new Chart(document.getElementById('chartUnsur'), {
        type: 'bar',
        data: {
            labels: ['U1','U2','U3','U4','U5','U6','U7','U8','U9'],
            datasets: [{
                label: 'Rata-rata Skor per Unsur',
                data: unsurData,
                backgroundColor: '#28a745',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: { title: { display: true, text: 'Rata-rata Skor per Unsur Pelayanan (U1-U9)', font: { size: 14, weight: 'bold' } } },
            scales: { y: { min: 0, max: 100 } }
        }
    });
</script>

</body>
</html>