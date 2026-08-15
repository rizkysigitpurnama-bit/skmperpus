document.getElementById('copyYear').innerText = new Date().getFullYear();
let skor = { q1: 0, q2: 0, q3: 0, q4: 0, q5: 0, q6: 0, q7: 0, q8: 0, q9: 0 };
const TAHUN_INI = new Date().getFullYear();
const urlScript = BASE_URL + "survei/submit";

window.onload = function() {
    document.getElementById('thnKues').innerText = TAHUN_INI;
    let st = document.getElementById('fTahun');
    for (let i = TAHUN_INI; i >= TAHUN_INI - 2; i--) {
        let o = document.createElement('option'); o.value = i; o.innerText = i; st.appendChild(o);
    }
}

function go(s) {
    document.querySelectorAll('.step').forEach(d => d.classList.remove('active'));
    if(s === 'Rekap') document.getElementById('pRekap').classList.add('active');
    else document.getElementById('p' + s).classList.add('active');
    window.scrollTo(0,0);
}

function terapkanTeksLayanan() {
    const layananTerpilih = document.getElementById('layanan');
    const namaLayanan = layananTerpilih.value !== ''
        ? layananTerpilih.options[layananTerpilih.selectedIndex].text
        : 'layanan yang Anda terima';

    document.querySelectorAll('#p3 h3[data-template]').forEach(h3 => {
        h3.innerText = h3.getAttribute('data-template').replace('{layanan}', namaLayanan);
    });
}

function validasiBiodata() {
    const pilihanUsia = document.querySelector('input[name="usia_pilihan"]:checked');
    if (pilihanUsia) {
        document.getElementById('usia').value = pilihanUsia.value;
    }

    const fields = ['nama', 'jk', 'WA', 'usia', 'pendidikan', 'pekerjaan', 'kec', 'layanan'];
    for(let f of fields) { 
        if(document.getElementById(f).value === "") {
            return alert("Harap melengkapi seluruh kolom yang tersedia sebelum melanjutkan!"); 
        }
    }
    
    terapkanTeksLayanan();
    updateProgress(1);
    go(3);
}

function updateProgress(n) {
    const total = 9;
    if (n <= total) {
        const persen = Math.round((n / total) * 100);
        document.getElementById('qProgressBar').style.width = persen + '%';
        document.getElementById('qProgressLabel').innerText = 'Pertanyaan ' + n + ' dari ' + total;
    } else {
        document.getElementById('qProgressBar').style.width = '100%';
        document.getElementById('qProgressLabel').innerText = 'Saran & Masukan';
    }
}

function nextQ(n) {
    if(!skor['q'+(n-1)]) return alert("Pilih salah satu emoji!");
    document.querySelectorAll('.q-box').forEach(q => q.classList.remove('q-active'));
    document.getElementById('stepQ' + n).classList.add('q-active');
    updateProgress(n);
}

function pilih(el, g, v) {
    skor[g] = v;
    document.querySelectorAll('#' + g + ' .emoji-item').forEach(i => i.classList.remove('selected'));
    el.classList.add('selected');
}

function konfirmasiSimpan() {
    if(!skor.q9) return alert("Pilih penilaian terakhir!");
    document.getElementById('modalKonfirmasi').style.display = 'flex';
}

function tutupModal() { document.getElementById('modalKonfirmasi').style.display = 'none'; }

function prosesSimpan() {
    tutupModal();
    document.getElementById('successOverlay').style.display = 'flex';
    
    let namaUser = document.getElementById('nama').value;
    let dataBaru = {
        website: document.getElementById('website').value,
        nama: document.getElementById('nama').value,
        jk: document.getElementById('jk').value,
        usia: document.getElementById('usia').value,
        wa: document.getElementById('WA').value,
        pendidikan: document.getElementById('pendidikan').value,
        pekerjaan: document.getElementById('pekerjaan').value,
        kecamatan: document.getElementById('kec').value,
        layanan: document.getElementById('layanan').value,
        tahun: TAHUN_INI,
        q1: skor.q1,
        q2: skor.q2,
        q3: skor.q3,
        q4: skor.q4,
        q5: skor.q5,
        q6: skor.q6,
        q7: skor.q7,
        q8: skor.q8,
        q9: skor.q9,
        saran: document.getElementById('Saran').value
    };

    fetch(urlScript, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(dataBaru)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            setTimeout(() => {
                window.location.href = BASE_URL + "survei/terimakasih?nama=" + encodeURIComponent(namaUser);
            }, 800);
        } else {
            alert("Gagal menyimpan data.");
        }
    })
    .catch(err => {
        console.error(err);
        alert("Terjadi kesalahan koneksi.");
    });
}

let dataGlobal = null;
async function goRekap() { 
    go('Rekap'); 
    let rAvgElement = document.getElementById('rAvg');
    rAvgElement.innerText = "Memuat...";

    try {
        const respon = await fetch(BASE_URL + "survei/rekap");
        const hasil = await respon.json();
        dataGlobal = hasil;
        renderRekap();
    } catch (e) {
        rAvgElement.innerText = "Error";
        console.error("Gagal koneksi:", e);
    }
}

function renderRekap() {
    if (!dataGlobal) return;

    let tahunDipilih = document.getElementById('fTahun').value.toString();
    let rAvgElement = document.getElementById('rAvg');
    let predikatElement = document.getElementById('predikat-teks');
    let kotakSkor = document.getElementById('kotak-skor');
    let nilaiFinal = 0;

    let histori = dataGlobal.dataHistori.find(item => String(item.tahun) === tahunDipilih);

    if (histori) {
        nilaiFinal = histori.skor;
    } else {
        nilaiFinal = dataGlobal.skorLive;
    }

    let nilaiFixed = parseFloat(nilaiFinal).toFixed(2);
    rAvgElement.innerText = nilaiFixed + "%";

    let pred = "BAIK", warna = "#007BFF";
    if (nilaiFixed >= 88.31) { pred = "SANGAT BAIK"; warna = "#28A745"; }
    else if (nilaiFixed >= 76.61) { pred = "BAIK"; warna = "#007BFF"; }
    else if (nilaiFixed >= 65.00) { pred = "KURANG BAIK"; warna = "#FFA500"; }
    else { pred = "TIDAK BAIK"; warna = "#DC3545"; }

    predikatElement.innerText = pred;
    kotakSkor.style.background = warna;
}

// Inisialisasi Swiper Slider
document.addEventListener("DOMContentLoaded", function() {
    if (typeof Swiper !== 'undefined') {
        new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            speed: 600,
            grabCursor: true,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
        });
    }
});