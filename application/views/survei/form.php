<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Survei Arpus Pekalongan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    
    <style>
        /* Memuat Background Banner menggunakan Base URL PHP agar tidak 404 */
        .hero-banner {
            background:
                linear-gradient(115deg, rgba(0,20,46,0.88) 0%, rgba(0,61,122,0.80) 45%, rgba(0,123,255,0.50) 100%),
                url('<?= base_url("assets/img/bg-perpustakaan.jpg"); ?>');
            background-size: cover;
            background-position: center 40%;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <img src="<?= base_url('assets/img/dinas.png'); ?>" alt="Logo"> 
        <div class="title-area">
            <h1>DINAS ARPUS</h1>
            <h2>Kabupaten Pekalongan</h2>
        </div>
    </div>
    
    <input type="text" id="website" name="website" style="position:absolute; left:-9999px; top:-9999px;" tabindex="-1" autocomplete="off">

    <!-- STEP 1: HOME -->
    <div id="p1" class="step active">
        <div class="hero-banner">
            <div class="hero-card">
                <div class="hero-badge">
                    <img src="<?= base_url('assets/img/badge-gedung-arpus.jpg'); ?>" alt="Gedung Dinas">
                </div>
                <h2 class="hero-title">Survei Kepuasan Masyarakat</h2>
                <p class="hero-desc">Wujudkan pelayanan publik yang lebih baik bersama<br>Dinas Kearsipan dan Perpustakaan Kabupaten Pekalongan.</p>
                <div class="btn-group" style="justify-content: flex-start;">
                    <button class="btn" onclick="go(2)">MULAI SURVEI</button>
                    <button class="btn btn-back" onclick="goRekap()">CEK LAPORAN</button>
                </div>
                <div class="extra-logos">
                    <img src="<?= base_url('assets/img/bangga.png'); ?>" alt="Logo 1">  
                    <img src="<?= base_url('assets/img/berakhlaq.png'); ?>" alt="Logo 2"> 
                </div>
            </div>
        </div>

        <div id="section-laporan">
            <h2 style="text-align:center; color: var(--biru); font-weight: 800; text-transform: uppercase; margin-bottom: 30px; font-size: 35px;">
                LAPORAN SURVEY KEPUASAN MASYARAKAT
            </h2>

            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php if (isset($laporan_skm) && !empty($laporan_skm)): ?>
                        <?php foreach ($laporan_skm as $laporan): ?>
                            <div class="swiper-slide">
                                <div class="skm-card-new">
                                    <img src="<?= base_url('assets/img/dinas.png'); ?>" style="width: 60px; margin-bottom: 15px;" alt="Logo Dinas">
                                    <h3>SKM Tahun <?= htmlspecialchars($laporan['tahun'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <strong><?= htmlspecialchars($laporan['judul'], ENT_QUOTES, 'UTF-8'); ?></strong>
                                    <p><?= htmlspecialchars($laporan['deskripsi'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <a href="<?= base_url('uploads/' . $laporan['file_pdf']); ?>" target="_blank" class="btn-pdf-lihat">
                                        Lihat Laporan →
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="swiper-slide">
                            <div class="skm-card-new">
                                <img src="<?= base_url('assets/img/dinas.png'); ?>" style="width: 60px; margin-bottom: 15px; filter: grayscale(100%);">
                                <h3>Laporan Kosong</h3>
                                <p>Belum ada laporan PDF SKM yang dipublikasikan saat ini.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div> <!-- PENUTUP ID="P1" AMAN -->

    <!-- STEP 2: BIODATA RESPONDEN -->
    <div id="p2" class="step">
        <h2 style="text-align: center; margin-bottom: 30px;">BIODATA RESPONDEN</h2>
        <div class="form-grid">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" id="nama">
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select id="jk">
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Umur</label>
                <div class="umur-pilihan">
                    <label><input type="radio" name="usia_pilihan" value="< 20"> &lt; 20</label>
                    <label><input type="radio" name="usia_pilihan" value="20 - 29"> 20 - 29</label>
                    <label><input type="radio" name="usia_pilihan" value="30 - 39"> 30 - 39</label>
                    <label><input type="radio" name="usia_pilihan" value="40 - 49"> 40 - 49</label>
                    <label><input type="radio" name="usia_pilihan" value=">= 50"> &gt;= 50</label>
                </div>
                <input type="hidden" id="usia">
            </div>
            <div class="form-group">
                <label>Nomor HP</label>
                <input type="tel" id="WA" placeholder="08xxxxxxxxxx" pattern="[0-9]{9,14}" inputmode="numeric" required>
            </div>
            <div class="form-group">
                <label>Pendidikan</label>
                <select id="pendidikan">
                    <option value="">-- Pilih --</option>
                    <option value="SD/Sederajat">SD/Sederajat</option>
                    <option value="SMP">SMP/Sederajat</option>
                    <option value="SMA/SMK/Sederajat">SMA/SMK/Sederajat</option>
                    <option value="Diploma">Diploma</option>
                    <option value="S1">S1</option>
                    <option value="S2/S3">S2/S3</option>
                </select>
            </div>
            <div class="form-group">
                <label>Pekerjaan</label>
                <select id="pekerjaan">
                    <option value="">-- Pilih --</option>
                    <option value="PNS/PPPK">PNS/PPPK</option> 
                    <option value="TNI/POLRI">TNI/POLRI</option>
                    <option value="Karyawan Swasta">Karyawan Swasta</option>
                    <option value="Karyawan Honorer">Karyawan Honorer</option>
                    <option value="Karyawan BUMD/BUMN">Karyawan BUMD/BUMN</option>
                    <option value="Dosen">Dosen</option>
                    <option value="Wiraswasta">Wiraswasta</option>
                    <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                    <option value="Pedagang">Pedagang</option> 
                    <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                    <option value="Nelayan">Nelayan</option> 
                    <option value="Seniman">Seniman</option> 
                    <option value="Bidan">Bidan</option> 
                    <option value="Dokter">Dokter</option> 
                    <option value="Apoteker">Apoteker</option>
                    <option value="Perawat">Perawat</option> 
                    <option value="Ustadz/Ustadzah">Ustadz/Ustadzah</option> 
                    <option value="Pengusaha">Pengusaha</option> 
                    <option value="Pensiunan">Pensiunan</option> 
                    <option value="konten creator">konten creator</option> 
                    <option value="Belum/Tidak Bekerja">Belum/Tidak Bekerja</option> 
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="form-group">
                <label>Kecamatan</label>
                <select id="kec">
                    <option value="">-- Pilih --</option>
                    <option value="Kajen">Kajen</option>
                    <option value="Kesesi">Kesesi</option>
                    <option value="Sragi">Sragi</option>
                    <option value="Bojong">Bojong</option>
                    <option value="Wonopringgo">Wonopringgo</option>
                    <option value="Kedungwuni">Kedungwuni</option>
                    <option value="Buaran">Buaran</option>
                    <option value="Tirto">Tirto</option>
                    <option value="Wiradesa">Wiradesa</option>
                    <option value="Siwalan">Siwalan</option>
                    <option value="Wonokerto">Wonokerto</option>
                    <option value="Karangdadap">Karangdadap</option>
                    <option value="Talun">Talun</option>
                    <option value="Doro">Doro</option>
                    <option value="Karanganyar">Karanganyar</option>
                    <option value="Lebakbarang">Lebakbarang</option>
                    <option value="Paninggaran">Paninggaran</option>
                    <option value="Kandangserang">Kandangserang</option>
                    <option value="Petungkriyono">Petungkriyono</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jenis Layanan</label>
                <select id="layanan">
                    <option value="">-- Pilih Layanan --</option>
                    <option value="Informasi Arsip">Layanan Informasi Arsip</option>
                    <option value="Peminjaman Arsip">Layanan Peminjaman Arsip</option>
                    <option value="Konsultasi Kearsipan">Layanan Konsultasi Kearsipan</option>
                    <option value="Fasilitas Kearsipan">Layanan Fasilitas Kearsipan</option>
                    <option value="Layanan Pengaduan">Layanan Pengaduan</option>
                    <option value="Layanan Umum Perpustakaan">Layanan Umum Perpustakaan</option>
                </select>
            </div>
        </div>
        <div class="btn-group">
            <button class="btn btn-back" onclick="go(1)">KEMBALI</button>
            <button class="btn" onclick="validasiBiodata()">LANJUT KE PENILAIAN</button>
        </div>
    </div>

    <!-- STEP 3: SOAL / PENILAIAN -->
    <div id="p3" class="step">
        <h2 style="text-align:center;">Survei Kepuasan Masyarakat Tahun <span id="thnKues"></span></h2>
        <div class="q-progress-wrap">
            <div class="q-progress-track"><div class="q-progress-bar" id="qProgressBar"></div></div>
            <div class="q-progress-label" id="qProgressLabel">Pertanyaan 1 dari 9</div>
        </div>

        <div id="stepQ1" class="q-box q-active">
            <h3 data-template="Bagaimana pendapat Anda tentang kesesuaian persyaratan {layanan} dengan jenis pelayanan yang diberikan?">Bagaimana pendapat saudara tentang kesesuaian persyaratan pelayanan dengan jenis pelayanannya?</h3>
            <div class="emoji-grid" id="q1">
                <div class="emoji-item" onclick="pilih(this, 'q1', 100)"><span>😍</span><b>Sangat Sesuai</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q1', 75)"><span>😊</span><b>Sesuai</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q1', 50)"><span>😐</span><b>Kurang Sesuai</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q1', 25)"><span>☹️</span><b>Tidak Sesuai</b></div>
            </div>
            <button class="btn" onclick="nextQ(2)">SELANJUTNYA</button>
        </div>

        <div id="stepQ2" class="q-box">
            <h3 data-template="Bagaimana pendapat Anda tentang kemudahan prosedur dalam mengakses {layanan}?">Bagaimana pemahaman saudara tentang kemudahan prosedur layanan di unit ini?</h3>
            <div class="emoji-grid" id="q2">
                <div class="emoji-item" onclick="pilih(this, 'q2', 100)"><span>😍</span><b>Sangat Mudah</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q2', 75)"><span>😊</span><b>Mudah</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q2', 50)"><span>😐</span><b>Kurang Mudah</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q2', 25)"><span>☹️</span><b>Tidak Mudah</b></div>
            </div>
            <button class="btn" onclick="nextQ(3)">SELANJUTNYA</button>
        </div>

        <div id="stepQ3" class="q-box">
            <h3 data-template="Bagaimana pendapat Anda tentang kecepatan waktu penyelesaian {layanan}?">Bagaimana pendapat saudara tentang Kecepatan Waktu dalam memberikan pelayanan?</h3>
            <div class="emoji-grid" id="q3">
                <div class="emoji-item" onclick="pilih(this, 'q3', 100)"><span>😍</span><b>Sangat Cepat</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q3', 75)"><span>😊</span><b>Cepat</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q3', 50)"><span>😐</span><b>Kurang Cepat</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q3', 25)"><span>☹️</span><b>Tidak Cepat</b></div>
            </div>
            <button class="btn" onclick="nextQ(4)">SELANJUTNYA</button>
        </div>

        <div id="stepQ4" class="q-box">
            <h3 data-template="Bagaimana pendapat Anda tentang kewajaran biaya atau tarif untuk {layanan}?">Bagaimana pendapat saudara tentang kewajaran biaya atau tarif dalam pelayanan</h3>
            <div class="emoji-grid" id="q4">
                <div class="emoji-item" onclick="pilih(this, 'q4', 100)"><span>😍</span><b>Gratis</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q4', 75)"><span>😊</span><b>Mudah/Gratis</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q4', 50)"><span>😐</span><b>Cukup Mahal</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q4', 25)"><span>☹️</span><b>Sangat Mahal</b></div>
            </div>
            <button class="btn" onclick="nextQ(5)">SELANJUTNYA</button>
        </div>

        <div id="stepQ5" class="q-box">
            <h3 data-template="Bagaimana pendapat Anda tentang kesesuaian hasil {layanan} dengan standar pelayanan yang ditetapkan?">Bagaimana pendapat saudara tentang kesesuaian produk pelayanan antara yang tercantum dalam standar pelayanan dengan hasil yang di berikan</h3>
            <div class="emoji-grid" id="q5">
                <div class="emoji-item" onclick="pilih(this, 'q5', 100)"><span>😍</span><b>Sangat Sesuai</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q5', 75)"><span>😊</span><b>Sesuai</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q5', 50)"><span>😐</span><b>Kurang Sesuai</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q5', 25)"><span>☹️</span><b>Tidak Sesuai</b></div>
            </div>
            <button class="btn" onclick="nextQ(6)">SELANJUTNYA</button>
        </div>

        <div id="stepQ6" class="q-box">
            <h3 data-template="Bagaimana pendapat Anda tentang kompetensi petugas dalam memberikan {layanan}?">Bagaimana pendapat saudara tentang kompetensi atau kemampuan petugas dalam pelayanan?</h3>
            <div class="emoji-grid" id="q6">
                <div class="emoji-item" onclick="pilih(this, 'q6', 100)"><span>😍</span><b>Sangat Kompeten</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q6', 75)"><span>😊</span><b>Kompeten</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q6', 50)"><span>😐</span><b>Kurang Kompeten</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q6', 25)"><span>☹️</span><b>Tidak Kompeten</b></div>
            </div>
            <button class="btn" onclick="nextQ(7)">SELANJUTNYA</button>
        </div>

        <div id="stepQ7" class="q-box">
            <h3 data-template="Bagaimana pendapat Anda tentang kesopanan dan keramahan petugas dalam memberikan {layanan}?">Bagaimana pendapat saudara perilaku petugas dalam pelayanan terkait kesopanan dan keramahan?</h3>
            <div class="emoji-grid" id="q7">
                <div class="emoji-item" onclick="pilih(this, 'q7', 100)"><span>😍</span><b>Sangat Sopan dan Ramah</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q7', 75)"><span>😊</span><b>Sopan Dan Ramah</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q7', 50)"><span>😐</span><b>Kuang Sopan dan Ramah</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q7', 25)"><span>☹️</span><b>Tidak Sopan dan Ramah</b></div>
            </div>
            <button class="btn" onclick="nextQ(8)">SELANJUTNYA</button>
        </div>

        <div id="stepQ8" class="q-box">
            <h3 data-template="Bagaimana pendapat Anda tentang kualitas sarana dan prasarana yang mendukung {layanan}?">Bagaimana pendapat saudara tentang kualitas sarana dan prasarana?</h3>
            <div class="emoji-grid" id="q8">
                <div class="emoji-item" onclick="pilih(this, 'q8', 100)"><span>😍</span><b>Sangat Baik</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q8', 75)"><span>😊</span><b>Baik</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q8', 50)"><span>😐</span><b>Cukup</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q8', 25)"><span>☹️</span><b>Buruk</b></div>
            </div>
            <button class="btn" onclick="nextQ(9)">SELANJUTNYA</button>
        </div>

        <div id="stepQ9" class="q-box">
            <h3 data-template="Bagaimana pendapat Anda tentang penanganan pengaduan terkait {layanan}?">Bagaimana pendapat saudara tentang penanganan, pengaduan pengguna layanan?</h3>
            <div class="emoji-grid" id="q9">
                <input type="hidden" name="q9" id="q9_input" value="">
                <div class="emoji-item" onclick="pilih(this, 'q9', 100)"><span>😍</span><b>Dikelola Dengan Baik</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q9', 75)"><span>😊</span><b>Berfungsi Kurang Maksimal</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q9', 50)"><span>😐</span><b>Ada Tetapi Tidak Berfungsi</b></div>
                <div class="emoji-item" onclick="pilih(this, 'q9', 25)"><span>☹️</span><b>Tidak Ada</b></div>
            </div>
            <button class="btn" onclick="nextQ(10)">SELANJUTNYA</button>
        </div>

        <div id="stepQ10" class="q-box">
            <h3>Saran dan Masukan</h3>
            <p style="max-width:600px;margin:0 auto 20px;">Apakah Anda memiliki saran untuk meningkatkan pelayanan kami?</p>
            <textarea id="Saran" rows="5" style="width:100%;max-width:600px;border-radius:12px;padding:15px;border:1px solid #ccc;" placeholder="Tulis saran Anda di sini (opsional)..."></textarea>
            <div class="btn-group" style="margin-top: 20px;">
                <button type="button" class="btn" onclick="konfirmasiSimpan()" style="background: var(--hijau); width: 50%;">SIMPAN JAWABAN</button>
            </div>
        </div>
    </div>

    <!-- STEP REKAP -->
    <div id="pRekap" class="step">
        <h2 style="text-align:center;">Laporan Indeks Kepuasan</h2>
        <div style="text-align:center; margin-bottom:20px;">
            Filter Tahun: <select id="fTahun" onchange="renderRekap()" style="width:120px;"></select>
        </div>
        <div class="card-indeks" id="kotak-skor">
            <small id="label-laporan">IKM RATA-RATA KESELURUHAN</small>
            <div id="rAvg">Memuat...</div> 
            <div id="predikat-teks" style="font-size: 18px; margin-top: 10px; font-weight: bold;"></div>
        </div>
        <div class="btn-group">
            <button class="btn btn-back" onclick="go(1)">KEMBALI KE BERANDA</button>
        </div>
    </div>

    <!-- FOOTER -->
    <div style="text-align: center; padding: 20px; color: #666; font-size: 14px; border-top: 1px solid #eee; margin-top: 30px;">
        Dinas Kearsipan dan Perpustakaan Kabupaten Pekalongan &copy; <span id="copyYear"></span>
    </div> 
</div>

<!-- MODAL KONFIRMASI -->
<div id="modalKonfirmasi" class="modal-overlay">
    <div class="modal-content">
        <h2 style="color:var(--biru); margin-top:0;">Konfirmasi</h2>
        <p style="font-size:18px;">Apakah Anda sudah yakin dengan jawabannya?</p>
        <div class="btn-group">
            <button class="btn btn-back" onclick="tutupModal()">BELUM</button>
            <button class="btn" style="background:var(--hijau);" onclick="prosesSimpan()">YA, SUDAH YAKIN</button>
        </div>
    </div>
</div>

<!-- SUCCESS OVERLAY -->
<div id="successOverlay" class="success-overlay">
    <div class="checkmark-circle"><div class="checkmark-icon">✓</div></div>
    <h1 style="color:var(--hijau); margin:0;">Terima Kasih!</h1>
    <p style="font-size:18px; color:#666;">Data Anda telah berhasil disimpan.</p>
</div>

<script>
    // Definisikan BASE_URL terlebih dahulu sebelum memuat script eksternal
    const BASE_URL = "<?= base_url(); ?>";
</script>
<script src="<?= base_url('assets/js/main.js'); ?>"></script>
</body>
</html>