<?php
session_start();
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
      <!-- Indomie Goreng -->
      <div class="menu-item">
        <img src="/assets/img/mie-goreng.png" alt="indomiey">
        <div class="menu-item-content">
          <div class="h3-price">
            <h3>Indomiey Goreng</h3>
            <span class="price">10k</span>
          </div>
          <div class="rating-order">
            <div class="rating">
              <span>5.0</span>
              <span class="stars">★★★★★</span>
            </div>
            <a href="/includes/order-indomie.php">
              <button class="order-btn">Order Now</button>
            </a>
          </div>
        </div>
      </div>

      <!-- Sate Telur Puyuh -->
      <div class="menu-item">
        <img src="/assets/img/icon-telur-puyuh.png" alt="telur puyuh">
        <div class="menu-item-content">
          <div class="h3-price">
            <h3>Sate Tilir Piyih</h3>
            <span class="price">5k</span>
          </div>
          <div class="rating-order">
            <div class="rating">
              <span>4.0</span>
              <span class="stars">★★★★☆</span>
            </div>
            <a href="/includes/menu.php">
              <button class="order-btn">Order Now</button>
            </a>
          </div>
        </div>
      </div>

      <!-- Sate Kulit Ayam -->
      <div class="menu-item">
        <img src="/assets/img/icon-sate-kulit.png" alt="sate kulit">
        <div class="menu-item-content">
          <div class="h3-price">
            <h3>Sate Kilit Iyim</h3>
            <span class="price">4k</span>
          </div>
          <div class="rating-order">
            <div class="rating">
              <span>5.0</span>
              <span class="stars">★★★★★</span>
            </div>
            <a href="/includes/menu.php">
              <button class="order-btn">Order Now</button>
            </a>
          </div>
        </div>
      </div>

      <!-- Nasi Meong -->
      <div class="menu-item">
        <img src="/assets/img/nasi-meong.png" alt="nasi meong">
        <div class="menu-item-content">
          <div class="h3-price">
            <h3>Nasi Meong</h3>
            <span class="price">3k</span>
          </div>
          <div class="rating-order">
            <div class="rating">
              <span>5.0</span>
              <span class="stars">★★★★★</span>
            </div>
            <a href="/includes/menu.php">
              <button class="order-btn">Order Now</button>
            </a>
          </div>
        </div>
      </div>

      <!-- Susu Jahe -->
      <div class="menu-item">
        <img src="/assets/img/susu-jahe.png" alt="susu jahe">
        <div class="menu-item-content">
          <div class="h3-price">
            <h3>Milk Jahe</h3>
            <span class="price">5k</span>
          </div>
          <div class="rating-order">
            <div class="rating">
              <span>5.0</span>
              <span class="stars">★★★★★</span>
            </div>
            <a href="/includes/menu.php">
              <button class="order-btn">Order Now</button>
            </a>
          </div>
        </div>
      </div>

      <!-- Mendoan bakar -->
      <div class="menu-item">
        <img src="/assets/img/mendoan-bakar.png" alt="mendoan bakar">
        <div class="menu-item-content">
          <div class="h3-price">
            <h3>Mendoan Bakar</h3>
            <span class="price">1k</span>
          </div>
          <div class="rating-order">
            <div class="rating">
              <span>4.5</span>
              <span class="stars">★★★★☆</span>
            </div>
            <a href="/includes/ordermendoan.php">
              <button class="order-btn">Order Now</button>
            </a>
          </div>
        </div>
      </div>
    </div>
    <a class="view-menu-btn" href="/includes/menu.php">View Menu</a>
  </section>

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