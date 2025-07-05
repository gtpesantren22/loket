<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Petugas - Sistem Antrian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=1K12oLKZ"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        danger: '#EF4444',
                        accent: '#F59E0B',
                        dark: '#1F2937',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-6">
        <!-- Header Petugas -->
        <header class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-dark">Panel Petugas Meja</h1>
                <p class="text-gray-600">Sistem Antrian Digital - PSB PPDWK 2025/2026</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-white px-4 py-2 rounded-lg shadow-sm flex items-center">
                    <i class="fas fa-user-circle text-primary mr-2"></i>
                    <span><?= $nama ?></span>
                </div>
                <button class="bg-secondary hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center" onclick="window.location='<?= base_url('santri') ?>'">
                    <i class="fas fa-users mr-2"></i> Data Santri
                </button>
                <button class="bg-danger hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center" onclick="window.location='auth/logout'">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </div>
        </header>

        <!-- Informasi Loket -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h2 class="text-xl font-semibold mb-1">Meja Pendaftaran - <?= $tugas->nomor ?></h2>
                    <p class="text-gray-600">Status: <span class="font-medium text-green-600">Aktif</span></p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <button class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-cog mr-2"></i> Pengaturan
                    </button>
                    <button class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-sync-alt mr-2"></i> Refresh
                    </button>
                </div>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Panel Antrian Saat Ini -->
            <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2">
                <h2 class="text-xl font-semibold mb-6">Antrian yang Sedang Dilayani</h2>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                    <div class="text-6xl font-bold text-accent mb-4" id="current-queue"><?= $proses ? $proses->jenis . convNol($proses->nomor) : '0' ?></div>
                    <div class="text-2xl font-medium mb-2" id="current-customer-name"><?= $proses ? $proses->nama : 'nama santri' ?></div>
                    <div class="text-gray-600 mb-6" id="current-service-type">Layanan: <?= $proses && $proses->jenis == 'A' ? 'Cetak Formulir' : 'Pendaftaran Baru' ?></div>

                    <div class="grid grid-cols-2 gap-4 max-w-md mx-auto">
                        <?php if ($proses): ?>
                            <a href="<?= base_url('meja/batal/' . $proses->id) ?>" onclick="return confirm('Yakin akan dibatalkan ?')"
                                class="bg-danger hover:bg-red-700 text-white py-3 px-4 rounded-lg flex items-center justify-center">
                                <i class="fas fa-times-circle mr-2"></i> Batalkan
                            </a>
                            <a href="<?= base_url('meja/selesai/' . $proses->id) ?>" onclick="return confirm('Yakin akan diselesaikan ?')"
                                class="bg-secondary hover:bg-green-600 text-white py-3 px-4 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle mr-2"></i> Selesai
                            </a>
                        <?php endif ?>
                    </div>
                </div>

                <!-- Informasi Waktu -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-1 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <div class="text-gray-600 mb-1">Menuggu antrian</div>
                        <div class="text-xl font-medium" id="start-time"><?= $menunggu ?> antrian</div>
                    </div>
                </div>
            </div>

            <!-- Panel Antrian Berikutnya -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-6">Antrian Berikutnya</h2>

                <div class="space-y-4">
                    <!-- Antrian 1 -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <div class="text-2xl font-bold text-accent"><?= $proses ? $proses->jenis . convNol($proses->nomor) : '0' ?></div>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">Saat ini</span>
                        </div>
                        <div class="text-gray-700 mb-1"><?= $proses ? $proses->nama : 'nama santri' ?></div>
                        <?php if ($proses): ?>
                            <div class="text-sm text-gray-500">Layanan: <?= $proses && $proses->jenis == 'A' ? 'Cetak Formulir' : 'Pendaftaran Baru' ?></div>
                            <input type="hidden" id="text" value="<?= 'nomor antrian, ' . $proses->jenis . $proses->nomor . ', ' . strtolower($proses->nama) . ', silahkan menuju operator ' . $proses->loket ?>">
                            <!-- <input type="hidden" id="text" value="<?= 'nomor antrian, ' . $proses->jenis . $proses->nomor . ',  silahkan menuju operator ' . $proses->loket ?>"> -->
                            <button id="playButton" onclick="speak()"
                                class="w-full mt-3 bg-primary hover:bg-blue-700 text-white py-2 px-4 rounded-lg flex items-center justify-center">
                                <i class="fas fa-bullhorn mr-2"></i></i> Panggil Sekarang
                            </button>
                            <audio id="audio-before" src="<?= base_url('assets/audio/bell-in.mp3') ?>" preload="auto"></audio>
                            <audio id="audio-after" src="<?= base_url('assets/audio/bell-out.mp3') ?>" preload="auto"></audio>
                        <?php endif ?>
                    </div>
                </div>

                <!-- Tombol Panggil Ulang -->
                <div class="mt-6">
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-3">
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('meja/ambil') ?>" method="post">
                        <input type="hidden" name="meja" value="<?= $tugas->nomor ?>">
                        <input type="hidden" name="pelayan" value="<?= $user_id ?>">
                        <button type="submit"
                            class="w-full bg-accent hover:bg-yellow-600 text-white py-3 px-4 rounded-lg flex items-center justify-center">
                            <i class="fas fa-play-circle mr-2"></i> Ambil Antrian Berikutnya
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar Antrian Hari Ini -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Daftar Antrian Hari Ini</h2>
                <div class="flex space-x-2">
                    <button class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">
                        <i class="fas fa-filter"></i>
                    </button>
                    <button class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-print"></i> Cetak
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="py-3 px-4 text-left rounded-tl-lg">No. Antrian</th>
                            <th class="py-3 px-4 text-left">Nama</th>
                            <th class="py-3 px-4 text-left">Layanan</th>
                            <th class="py-3 px-4 text-left">Waktu Ambil</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($antrianAll as $antall): ?>
                            <tr>
                                <td class="py-3 px-4 font-medium"><?= $antall->jenis .  convNol($antall->nomor) ?></td>
                                <td class="py-3 px-4">Pendaftaran</td>
                                <td class="py-3 px-4"><?= $antall->nama ?></td>
                                <td class="py-3 px-4"><?= $antall->waktu ?></td>
                                <td class="py-3 px-4">
                                    <?php if ($antall->ket == 'menunggu') { ?>
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-sm">Menunggu</span>
                                    <?php } elseif ($antall->ket == 'proses') { ?>
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">Dilayani</span>
                                    <?php } else { ?>
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Selesai</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk update waktu
        function updateCurrentTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            // Hitung durasi (contoh: mulai dari 09:15:23)
            const startTime = new Date();
            startTime.setHours(9, 15, 23);
            const diffMs = now - startTime;
            const diffMins = Math.floor(diffMs / 60000);
            const diffSecs = Math.floor((diffMs % 60000) / 1000);
            const durationString = `${diffMins.toString().padStart(2, '0')}:${diffSecs.toString().padStart(2, '0')}`;

            // Hitung estimasi selesai (contoh: tambah 7 menit dari waktu mulai)
            const endTime = new Date(startTime.getTime() + 7 * 60000);
            const endTimeString = endTime.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            // Update tampilan
            document.getElementById('duration').textContent = durationString;
            document.getElementById('estimated-end').textContent = endTimeString;
        }

        // Update setiap detik
        // setInterval(updateCurrentTime, 1000);
        // updateCurrentTime(); 

        function speak() {
            const text = document.getElementById('text').value;
            const playButton = document.getElementById('playButton');
            const audioBefore = document.getElementById('audio-before');
            const audioAfter = document.getElementById('audio-after');

            if (!text || !responsiveVoice || !responsiveVoice.speak) {
                alert("Browser Anda tidak mendukung Text-to-Speech.");
                return;
            }

            playButton.disabled = true;

            // Fungsi bicara menggunakan ResponsiveVoice
            const speakText = () => {
                responsiveVoice.speak(text, "Indonesian Male", {
                    rate: 0.9,
                    onend: () => {
                        audioAfter.play();
                    }
                });
            };

            // Urutan: mainkan audio pembuka -> bicara -> mainkan audio penutup
            audioBefore.onended = () => {
                speakText();
            };

            audioAfter.onended = () => {
                playButton.disabled = false;
            };

            audioBefore.play();
        }
    </script>
</body>

</html>