let prevScrollPos = window.pageYOffset;
const navbar = document.querySelector('.navbar');

// Fungsi untuk menangani scroll
window.onscroll = function() {
  let currentScrollPos = window.pageYOffset;

  if (prevScrollPos > currentScrollPos) {
    navbar.style.top = "0"; // Navbar muncul kembali saat scroll ke atas
  } else {
    navbar.style.top = "-100px"; // Navbar menghilang saat scroll ke bawah
  }

  prevScrollPos = currentScrollPos;
}

// Tangkap semua elemen <a> di dalam navbar
const navLinks = document.querySelectorAll('.navbar ul li a');

// Menambahkan event listener untuk setiap link
navLinks.forEach(link => {
    link.addEventListener('click', function(event) {
        // Hapus kelas 'active' dari semua link
        navLinks.forEach(nav => nav.classList.remove('active'));

        // Tambahkan kelas 'active' ke elemen yang diklik
        this.classList.add('active');
    });
});

// Menambahkan kelas 'active' berdasarkan URL saat halaman dimuat
window.addEventListener('load', function() {
    const currentPath = window.location.pathname;

    // Loop melalui semua link navbar
    navLinks.forEach(link => {
        if (link.href.includes(currentPath)) {
            link.classList.add('active');
        }
    });
});
