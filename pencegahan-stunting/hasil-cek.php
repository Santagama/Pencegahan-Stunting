<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Cek Stunting</title>
    <link rel="stylesheet" href="css/style.css">
</head>

    <header>
        <h1>Hasil Cek Stunting Anak</h1>
    </header>

    <section>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama = htmlspecialchars($_POST['nama']);
            $tanggal_lahir = htmlspecialchars($_POST['tanggal_lahir']);
            $berat_badan = floatval($_POST['berat_badan']);
            $tinggi_badan = floatval($_POST['tinggi_badan']);

            // Menghitung usia anak dalam bulan
            $tanggal_lahir = new DateTime($tanggal_lahir);
            $sekarang = new DateTime();
            $usia_bulan = $sekarang->diff($tanggal_lahir)->y * 12 + $sekarang->diff($tanggal_lahir)->m;

            // Standar tinggi badan minimal berdasarkan usia (standar WHO)
            $standar_tinggi_badan = [
                0 => 49.5, 1 => 54.7, 2 => 58.4, 3 => 61.4, 4 => 63.9, 
                5 => 65.9, 6 => 67.6, 12 => 76.1, 24 => 85.0, 
                36 => 95.1, 48 => 102.0, 60 => 109.4
            ];

            // Fungsi interpolasi untuk menebak tinggi badan standar berdasarkan usia yang tidak ada di tabel
            function interpolasi_standar_tinggi($usia_bulan, $standar_tinggi_badan) {
                $usia_bulan_terdekat = array_keys($standar_tinggi_badan);

                // Temukan dua titik usia terdekat untuk interpolasi
                $usia_bawah = 0;
                $usia_atas = 0;
                foreach ($usia_bulan_terdekat as $usia) {
                    if ($usia <= $usia_bulan) {
                        $usia_bawah = $usia;
                    }
                    if ($usia > $usia_bulan && $usia_atas == 0) {
                        $usia_atas = $usia;
                    }
                }

                // Jika usia yang dimasukkan lebih besar dari usia maksimum yang ada di tabel
                if ($usia_atas == 0) {
                    return $standar_tinggi_badan[$usia_bawah];
                }

                // Interpolasi linear
                $tinggi_bawah = $standar_tinggi_badan[$usia_bawah];
                $tinggi_atas = $standar_tinggi_badan[$usia_atas];

                $tinggi_standar = $tinggi_bawah + ($tinggi_atas - $tinggi_bawah) * (($usia_bulan - $usia_bawah) / ($usia_atas - $usia_bawah));

                return $tinggi_standar;
            }

            // Mengambil tinggi standar berdasarkan interpolasi
            $tinggi_badan_standar = interpolasi_standar_tinggi($usia_bulan, $standar_tinggi_badan);

            // Logika untuk cek apakah anak mengalami stunting atau kelebihan tinggi badan
            if ($tinggi_badan < ($tinggi_badan_standar - 2)) {
                $hasil = "$nama <strong>kemungkinan mengalami stunting</strong>. Tinggi badannya lebih rendah dari standar WHO untuk usia $usia_bulan bulan. Ini bisa menjadi tanda bahwa pertumbuhan anak terhambat, sehingga disarankan untuk berkonsultasi dengan dokter.";
            } elseif ($tinggi_badan > $tinggi_badan_standar + 2) {
                $hasil = "$nama <strong>memiliki tinggi badan lebih tinggi dari standar WHO untuk usia $usia_bulan bulan.</strong> Pertumbuhan anak lebih cepat dari rata-rata, dan ini umumnya merupakan pertanda baik.";
            } elseif ($tinggi_badan > $tinggi_badan_standar) {
                $hasil = "$nama <strong>tidak mengalami stunting.</strong Tinggi badannya lebih tinggi sedikit dari standar WHO, dan ini menunjukkan perkembangan yang baik.";
            } else {
                $hasil = "$nama memiliki tinggi badan yang sesuai dengan standar WHO, menandakan pertumbuhan yang sehat.";
            }

            // Tampilkan hasil dengan background dan desain yang rapi
            echo "<div style='background-color: rgba(255, 255, 255, 0.8); padding: 20px; border-radius: 10px; margin: 20px;'>";
            echo "<h3>Hasil Cek Stunting</h3>";
            echo "<p>$hasil</p>";
            echo "</div>";
        }
        ?>
    </section>

    <footer>
        <p>Dibuat oleh: Kelompok 1</p>
        <p>&copy; 2024 Pencegahan Stunting</p>
    </footer>

</body>
</html>