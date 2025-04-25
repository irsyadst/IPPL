<?php
session_start();
include __DIR__ . "/server/database.php";

$menus = [];
$sql = "SELECT * FROM menu ORDER BY id_menu ASC LIMIT 6";
$result = mysqli_query($db, $sql);

while ($row = mysqli_fetch_assoc($result)) {
  $menus[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home page</title>
  <link rel="stylesheet" href="/assets/style/index.css">
</head>

<body>
  <!-- Memanggil navbar -->
  <?php include __DIR__ . "/layout/navbar.php"; ?>

  <!-- Top Section -->
  <div class="top">
    <h1>
      <span class="black-text">Selamat Datang di</span><br>
      <span class="orange-text">Angkringan Sakinih!</span>
    </h1>
    <p class="p1">
      Nikmati suasana santai dan kenikmatan kuliner khas angkringan. Temukan beragam pilihan makanan tradisional yang
      lezat dengan harga terjangkau, mulai dari nasi kucing, sate-satean, hingga aneka gorengan. Sempurna untuk menemani
      waktu bersantai bersama teman dan keluarga.
    </p>
    <p class="p2">
      Angkringan - Hangatnya Kebersamaan, Nikmatnya Makanan Tradisional!
    </p>
  </div>


  <!-- Mid Section -->
  <div class="mid">
    <div class="circle-container">
      <div class="circle-item">
        <div class="circle1">
          <img src="/assets/img/icon-lokasi.svg" alt="lokasi">
        </div>
        <p><strong>Location</strong><br>Jl. kemangkun 25, Purwokerto, Jawa Tengah</p>
      </div>
      <div class="circle-item">
        <div class="circle2">
          <img src="/assets/img/icon-jam.png" alt="jam">
        </div>
        <p><strong>Open Hours</strong><br>Setiap hari 07:00 - 23:00</p>
      </div>
      <div class="circle-item">
        <div class="circle3">
          <img src="/assets/img/icon-resevation.png" alt="reservation">
        </div>
        <p><strong>Reservation</strong><br>sakinihbakawn89@gmail.com</p>
      </div>
    </div>

    <div class="story-container">
      <div class="image-section">
        <img src="/assets/img/icon-angkringan2.png" alt="angkringan2">
        <img src="/assets/img/vektor.png" alt="vektor">
      </div>
      <div class="text1">
        <h2 class="left"><i>The Story</i></h2>
        <p class="left2">
          Angkringan Sarinih Terinspirasi dari kebiasaan nongkrong sederhana, mereka menciptakan angkringan dengan
          konsep modern yang tetap ramah kantong. Mengusung nama "Sarinih," yang berarti "mari kesini."
        </p>
        <h2 class="center"><i>2022</i></h2>
        <p class="center2">
          Angkringan Sarinih lahir pada tahun 2022 dari semangat kebersamaan sekelompok mahasiswa Universitas Telkom
          Purwokerto yang ingin menghadirkan tempat nongkrong sederhana namun berkesan.
        </p>
      </div>
    </div>
  </div>

  <!-- Menu Section -->
  <section class="menu-section">
    <!-- Header Menu -->
    <div class="menu-header">
      <hr class="line1">
      <span class="menu-title">MENU</span>
      <hr class="line1">
    </div>

    <h2>Menu Favorite</h2>
    <p>
      Dibawah ini merupakan menu makanan dan minuman yang kami<br> rekomendasikan di Angkringan Sarinih.
    </p>

    <!-- Menu Container -->
    <div class="menu-container">
      <?php foreach ($menus as $menu): ?>
        <div class="menu-item">
          <img src="/assets/img/<?= htmlspecialchars($menu['gambar']) ?>" alt="<?= htmlspecialchars($menu['nama_menu']) ?>">
          <div class="menu-item-content">
            <div class="h3-price">
              <h3><?= htmlspecialchars($menu['nama_menu']) ?></h3>
            </div>
            <div class="h3-price">
              <span class="price">Rp.<?= htmlspecialchars(number_format($menu['harga'])) ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <a href="includes/menu.php" class="order-now-btn">Order Now</a>



    <!-- Testimonial -->
    <section class="testimonial-section">
      <hr class="line3">
      <h1>TESTIMONIAL</h1>
      <h2>Apa Yang Mereka Katakan</h2>
      <p>Kami sangat menerima kritik dan saran dari para pelanggan. <br> Silahkan tinggalkan kritik atau saran untuk kami.
      </p>
      <div class="testimonials">
        <div class="testimonial">
          <img src="/assets/img/profile1.png" alt="Bang Oyot" class="profile-pic">
          <h3>Bang Oyot</h3>
          <p class="location">Bekasi</p>
          <hr>
          <p class="feedback">“Wah enakkk sekaliii.... Aku sangat sukaa, ini akan menjadi angkringan langganankuuu.”</p>
        </div>
        <div class="testimonial">
          <img src="/assets/img/profile2.png" alt="Mba Esih" class="profile-pic">
          <h3>Mba Esih</h3>
          <p class="location">Malang</p>
          <hr>
          <p class="feedback">“Tempatnya nyaman dan sangat bersih juga.”</p>
        </div>
        <div class="testimonial">
          <img src="/assets/img/profile3.png" alt="Yayat Sutrisno" class="profile-pic">
          <h3>Yayat Sutrisno</h3>
          <p class="location">Purwokerto</p>
          <hr>
          <p class="feedback">“Sate ayamnya enakk dan sosis bakarnya juga gurih euyyy. Pokoknyaa rekomennn bngtt dah.”</p>
        </div>
      </div>
    </section>

    <?php include __DIR__ . "/layout/footer.html"; ?>

</body>

</html>