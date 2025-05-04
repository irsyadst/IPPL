// JavaScript untuk memastikan footer selalu di bawah halaman
document.addEventListener("DOMContentLoaded", function () {
    const footer = document.querySelector('.footer');
    const body = document.querySelector('body');
    
    // Cek tinggi konten halaman
    const checkFooterPosition = () => {
      const contentHeight = document.querySelector('.content-wrap').offsetHeight;
      const windowHeight = window.innerHeight;
  
      // Jika konten halaman lebih pendek dari jendela, letakkan footer di bawah
      if (contentHeight < windowHeight) {
        footer.style.position = 'absolute';
        footer.style.bottom = '0';
        footer.style.width = '100%';
      } else {
        footer.style.position = 'relative';
        footer.style.bottom = 'initial';
      }
    };
  
    // Panggil fungsi saat halaman dimuat atau ukuran layar berubah
    checkFooterPosition();
    window.addEventListener('resize', checkFooterPosition);
  });
  