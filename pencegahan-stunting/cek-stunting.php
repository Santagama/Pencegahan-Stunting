<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Stunting Anak</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Cek Stunting Anak Anda</h1>
    </header>

    <section>
        <form action="hasil-cek.php" method="post">
            <label for="nama">Nama Anak:</label><br>
            <input type="text" id="nama" name="nama" required><br><br>
            
            <label for="tanggal_lahir">Tanggal Lahir Anak:</label><br>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" required><br><br>
            
            <label for="berat_badan">Berat Badan (kg):</label><br>
            <input type="number" id="berat_badan" name="berat_badan" step="0.01" required><br><br>
            
            <label for="tinggi_badan">Tinggi Badan (cm):</label><br>
            <input type="number" id="tinggi_badan" name="tinggi_badan" step="0.1" required><br><br>
            
            <button type="submit">Cek Stunting</button>
        </form>
    </section>

    <footer>
        <p>Dibuat oleh: Kelompok 1</p>
        <p>&copy; 2024 Pencegahan Stunting</p>
    </footer>
</body>
</html>