<?php

/**
 * @var array      $config
 * @var array      $ucapan
 * @var array|null $flash
 */

$tanggal = new DateTime($config['tanggal_acara']);

$bulanInggris = [
     1  => 'January',
    2  => 'February',
    3  => 'March',
    4  => 'April',
    5  => 'May',
    6  => 'June',
    7  => 'July',
    8  => 'August',
    9  => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December',
];

$tanggalTampil =
    $tanggal->format('d') . ' ' .
    $bulanInggris[(int) $tanggal->format('n')] . ' ' .
    $tanggal->format('Y');

$sudahDibuka = !empty($flash);
$kataKata = $config['kata_kata'] ?? [];

?>

<div class="kolase-template" aria-hidden="true">
    <span class="kolase-coretan kolase-coretan--1"></span>
    <span class="kolase-coretan kolase-coretan--2">✦</span>
</div>

<!-- SELURUH KONTEN UTAMA -->
<div class="page">

    <!-- ============ AMPLOP ============ -->
    <section
        class="amplop-wrap<?= $sudahDibuka ? ' amplop-wrap--selesai' : '' ?>"
        id="amplopWrap"
    >
     <div class="front-decoration" aria-hidden="true">
    <span class="front-decoration__item front-decoration__item--1">♡</span>
    <span class="front-decoration__item front-decoration__item--2">✦</span>
    <span class="front-decoration__item front-decoration__item--3">♥</span>
    <span class="front-decoration__item front-decoration__item--4">✧</span>
    </div>
        <div class="amplop" id="amplop">

        <p class="amplop-hint">
                 Tap the seal to open
        </p>


            <div class="amplop__badan"></div>

            <div class="amplop__surat">
                <p class="amplop__surat-eyebrow">
                    For
                </p>

                <p class="amplop__surat-nama">
                    <?= htmlspecialchars($config['nama_penerima']) ?>
                </p>
            </div>

            <div class="amplop__saku"></div>
            <div class="amplop__flap"></div>

            <button
                class="amplop__segel"
                id="segelBtn"
                type="button"
                aria-label="Buka amplop undangan"
            >
                <span>Open</span>
            </button>

        </div>
    </section>

    <!-- Musik background -->
    <audio
        id="backgroundMusic"
        loop
        preload="auto"
    >
        <source
            src="/audio/lagu.mp3"
            type="audio/mpeg"
        >

        Browser tidak mendukung audio.
    </audio>

    <!-- ============ ISI UNDANGAN ============ -->
    <div
        class="isi"
        id="isiUndangan"
        <?= $sudahDibuka ? '' : 'hidden' ?>
    >

        <!-- Surat utama -->
       <section class="surat reveal-section is-visible">

            <p class="surat__eyebrow">
                — Happy level up my love —
            </p>

            <h1 class="surat__judul">
                
                <span><?= (int) $config['usia'] ?></span>
            </h1>

            <p class="surat__nama">
                <?= htmlspecialchars($config['nama_penerima']) ?>
            </p>

            <p class="surat__tanggal">
                <?= htmlspecialchars($tanggalTampil) ?>
            </p>

            <div class="surat__garis"></div>

            <p class="surat__pesan">
                "<?= htmlspecialchars($config['ucapan_utama']) ?>"
            </p>

            <p class="surat__dari">
                — <?= htmlspecialchars($config['dari']) ?>
            </p>

        </section>

        <!-- Galeri foto -->
<section
    class="galeri reveal-section"
    id="galeriSection"
>

    <h2 class="galeri__judul"></h2>

    <div class="galeri__grid">

        <?php foreach ($config['foto'] as $i => $foto): ?>

            <figure class="galeri__item rot-<?= $i % 5 ?>">

                <span class="galeri__pin"></span>

                <div
                    class="galeri__photo ph-<?= $i % 6 ?>"
                    style="background-image:url('/img/<?= htmlspecialchars($foto['src']) ?>')"
                ></div>

                <figcaption>
                    <?= htmlspecialchars($foto['caption']) ?>
                </figcaption>

            </figure>

        <?php endforeach; ?>

    </div>

</section>


<!-- Slider kata-kata -->
<?php if (!empty($kataKata)): ?>

<section
    class="kata-slider reveal-section"
    id="kataSlider"
>

    <p class="kata-slider__eyebrow">
        — A few words for you —
    </p>


    <div class="kata-slider__ornamen">
        <span></span>
        <b>♥</b>
        <span></span>
    </div>

                <div class="kata-slider__viewport">

                    <?php foreach ($kataKata as $index => $kata): ?>

                        <article
                            class="kata-slider__item<?= $index === 0 ? ' is-active' : '' ?>"
                            data-kata-slide
                        >

                            <span
                                class="kata-slider__quote kata-slider__quote--kiri"
                            >
                                “
                            </span>

                            <p>
                                <?= htmlspecialchars($kata) ?>
                            </p>

                            <span
                                class="kata-slider__quote kata-slider__quote--kanan"
                            >
                                ”
                            </span>

                            <span class="kata-slider__number">
                                <?= str_pad(
                                    (string) ($index + 1),
                                    2,
                                    '0',
                                    STR_PAD_LEFT
                                ) ?>

                                /

                                <?= str_pad(
                                    (string) count($kataKata),
                                    2,
                                    '0',
                                    STR_PAD_LEFT
                                ) ?>
                            </span>

                        </article>

                    <?php endforeach; ?>

                </div>

                <div class="kata-slider__navigation">

    <div class="kata-slider__dots">

        <?php foreach ($kataKata as $index => $kata): ?>

            <button
                type="button"
                class="kata-slider__dot<?= $index === 0 ? ' is-active' : '' ?>"
                data-kata-dot="<?= $index ?>"
                aria-label="Tampilkan kata <?= $index + 1 ?>"
            ></button>

        <?php endforeach; ?>


        <?php endif; ?>

</div>

<?php if ($sudahDibuka): ?>

    <script>
        document.body.classList.add('undangan-terbuka');
    </script>

<?php endif; ?>