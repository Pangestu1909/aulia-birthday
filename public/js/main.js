document.addEventListener('DOMContentLoaded', function () {
  var amplop = document.getElementById('amplop');
  var segelBtn = document.getElementById('segelBtn');
  var amplopWrap = document.getElementById('amplopWrap');
  var isiUndangan = document.getElementById('isiUndangan');
  var backgroundMusic = document.getElementById('backgroundMusic');
  var galeriSection = document.getElementById('galeriSection');

  var revealObserverSudahAktif = false;

  /*
   * =========================
   * MUSIK
   * =========================
   */

  function putarMusik() {
    if (!backgroundMusic) {
      console.error('Elemen #backgroundMusic tidak ditemukan');
      return;
    }

    if (!backgroundMusic.paused) {
      return;
    }

    backgroundMusic.volume = 0.7;

    backgroundMusic.play().catch(function (error) {
      console.error('Musik gagal diputar:', error);
    });
  }

  /*
   * =========================
   * REVEAL SAAT SCROLL
   * =========================
   */

  function aktifkanRevealSection() {
    if (revealObserverSudahAktif) {
      return;
    }

    revealObserverSudahAktif = true;

    function amatiSection(element, callback) {
      if (!element) {
        console.error('Section reveal tidak ditemukan');
        return;
      }

      var observer = new IntersectionObserver(
        function (entries, currentObserver) {
          entries.forEach(function (entry) {
            if (!entry.isIntersecting) {
              return;
            }

            entry.target.classList.add('is-visible');

            if (typeof callback === 'function') {
              callback();
            }

            currentObserver.unobserve(entry.target);
          });
        },
        {
          threshold: 0.01,
          rootMargin: '-10% 0px -55% 0px'
        }
      );

      observer.observe(element);
    }

    /*
     * Galeri muncul ketika discroll.
     * Setelah galeri muncul, slider kata-kata
     * muncul 1,5 detik kemudian.
     */

    amatiSection(galeriSection, function () {
      window.setTimeout(function () {
        if (kataSlider) {
          kataSlider.classList.add('is-visible');
        }
      }, 1500);
    });
  }

  /*
   * =========================
   * BUKA AMPLOP
   * =========================
   */

  function bukaAmplop() {
    if (
      !amplop ||
      amplop.classList.contains('amplop--terbuka')
    ) {
      return;
    }

    putarMusik();

    amplop.classList.add('amplop--terbuka');

    window.setTimeout(function () {
      document.body.classList.add('undangan-terbuka');

      if (amplopWrap) {
        amplopWrap.classList.add('amplop-wrap--selesai');
      }

      if (isiUndangan) {
        isiUndangan.hidden = false;

        aktifkanRevealSection();

        var suratUtama =
          isiUndangan.querySelector('.surat');

        if (suratUtama) {
          suratUtama.classList.add('is-visible');
          suratUtama.classList.remove('surat-muncul');

          window.requestAnimationFrame(function () {
            suratUtama.classList.add('surat-muncul');
          });
        }

        var targetScroll =
          suratUtama || isiUndangan;

        var posisiScroll =
          targetScroll.getBoundingClientRect().top +
          window.scrollY -
          16;

        window.scrollTo({
          top: Math.max(posisiScroll, 0),
          behavior: 'smooth'
        });
      }
    }, 900);
  }

  /*
   * Tombol Open
   */

  if (segelBtn) {
    segelBtn.addEventListener('click', function (event) {
      event.preventDefault();
      event.stopPropagation();

      bukaAmplop();
    });
  }

  /*
   * Klik bagian amplop
   */

  if (amplop) {
    amplop.addEventListener('click', bukaAmplop);
  }

  /*
   * =========================
   * SMOOTH SCROLL
   * =========================
   */

  document
    .querySelectorAll('a[href^="#"]')
    .forEach(function (link) {
      link.addEventListener('click', function (event) {
        var targetSelector =
          this.getAttribute('href');

        if (
          !targetSelector ||
          targetSelector === '#'
        ) {
          return;
        }

        var target =
          document.querySelector(targetSelector);

        if (!target) {
          return;
        }

        event.preventDefault();

        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      });
    });

  /*
   * =========================
   * SLIDER KATA-KATA
   * =========================
   */

  var kataSlider =
    document.getElementById('kataSlider');

  var kataSlides =
    document.querySelectorAll('[data-kata-slide]');

  var kataDots =
    document.querySelectorAll('[data-kata-dot]');

  var kataIndex = 0;
  var kataInterval = null;

  function tampilkanKata(index) {
    if (!kataSlides.length) {
      return;
    }

    if (index < 0) {
      index = kataSlides.length - 1;
    }

    if (index >= kataSlides.length) {
      index = 0;
    }

    kataIndex = index;

    kataSlides.forEach(function (slide, slideIndex) {
      slide.classList.toggle(
        'is-active',
        slideIndex === kataIndex
      );
    });

    kataDots.forEach(function (dot, dotIndex) {
      dot.classList.toggle(
        'is-active',
        dotIndex === kataIndex
      );
    });
  }

  function mulaiSliderKata() {
    window.clearInterval(kataInterval);

    kataInterval = window.setInterval(function () {
      tampilkanKata(kataIndex + 1);
    }, 4500);
  }

  /*
   * Navigasi dots
   */

  kataDots.forEach(function (dot) {
    dot.addEventListener('click', function () {
      var index = parseInt(
        this.getAttribute('data-kata-dot'),
        10
      );

      tampilkanKata(index);
      mulaiSliderKata();
    });
  });

  /*
   * Slide pertama
   */

  if (kataSlider && kataSlides.length) {
    tampilkanKata(0);
  }

  /*
   * Autoplay slider
   */

  if (kataSlider && kataSlides.length > 1) {
    mulaiSliderKata();

    /*
     * =========================
     * ANIMASI FOTO SAAT SCROLL
     * =========================
     */

    var semuaFotoGaleri =
      document.querySelectorAll('.galeri__item');

    if (semuaFotoGaleri.length) {
      document.body.classList.add('animasi-foto-aktif');

      /*
       * Browser lama yang tidak mendukung IntersectionObserver
       * tetap menampilkan semua foto.
       */

      if (!('IntersectionObserver' in window)) {
        semuaFotoGaleri.forEach(function (foto) {
          foto.classList.add('foto-sudah-muncul');
        });
      } else {
        var observerFoto = new IntersectionObserver(
          function (entries, observer) {
            entries.forEach(function (entry) {
              if (!entry.isIntersecting) {
                return;
              }

              entry.target.classList.add(
                'foto-sudah-muncul'
              );

              /*
               * Setelah muncul sekali, foto tidak diamati lagi.
               * Ini mencegah animasi berulang ketika scroll naik-turun.
               */

              observer.unobserve(entry.target);
            });
          },
          {
            threshold: 0.18,
            rootMargin: '0px 0px -8% 0px'
          }
        );

        semuaFotoGaleri.forEach(function (foto, index) {
          /*
           * Dalam setiap baris:
           * foto kiri tampil lebih dulu,
           * foto kanan menyusul 150 ms.
           */

          var delayFoto =
            index % 2 === 0 ? 0 : 150;

          foto.style.setProperty(
            '--foto-delay',
            delayFoto + 'ms'
          );

          observerFoto.observe(foto);
        });
      }
    }

    var kataViewport =
      kataSlider.querySelector('.kata-slider__viewport');

    if (kataViewport) {
      kataViewport.addEventListener(
        'mouseenter',
        function () {
          tampilkanKata(kataIndex + 1);
          mulaiSliderKata();
        }
      );
    }
  }

  /*
   * =========================
   * ANIMASI SLIDER SAAT SCROLL
   * =========================
   */

  if (kataSlider) {
    if ('IntersectionObserver' in window) {
      var observerKataSlider =
        new IntersectionObserver(
          function (entries, observer) {
            entries.forEach(function (entry) {
              if (!entry.isIntersecting) {
                return;
              }

              /*
               * Pastikan slider terlihat,
               * lalu jalankan animasinya.
               */

              entry.target.classList.add('is-visible');
              entry.target.classList.add(
                'kata-slider--muncul'
              );

              /*
               * Saat pertama terlihat,
               * mulai kembali dari kata pertama.
               */

              window.clearInterval(kataInterval);

              tampilkanKata(0);
              mulaiSliderKata();

              /*
               * Animasi hanya terjadi sekali.
               */

              observer.unobserve(entry.target);
            });
          },
          {
            threshold: 0.25,
            rootMargin: '0px 0px -10% 0px'
          }
        );

      observerKataSlider.observe(kataSlider);
    } else {
      kataSlider.classList.add('is-visible');
      kataSlider.classList.add(
        'kata-slider--muncul'
      );
    }
  }
});