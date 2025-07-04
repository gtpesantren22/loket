<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sistem Antrian Digital</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<!-- jQuery (required by Select2) -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<script>
		tailwind.config = {
			theme: {
				extend: {
					colors: {
						primary: '#3B82F6',
						secondary: '#10B981',
						accent: '#F59E0B',
						dark: '#1F2937',
						danger: '#EF4444',
					}
				}
			}
		}
	</script>
	<style>
		.select2-container--default .select2-selection--single {
			height: 2.5rem;
			/* Sesuaikan dengan Tailwind py-2 */
			padding: 0.5rem 1rem;
			border-radius: 0.5rem;
			border-color: #d1d5db;
			/* Tailwind gray-300 */
		}

		/* Animasi modal */
		.modal {
			transition: opacity 0.3s ease, transform 0.3s ease;
		}

		.modal-hidden {
			opacity: 0;
			transform: translateY(-20px);
			pointer-events: none;
		}

		.modal-visible {
			opacity: 1;
			transform: translateY(0);
		}

		/* Overlay */
		.modal-overlay {
			transition: opacity 0.3s ease;
		}

		.modal-overlay-hidden {
			opacity: 0;
			pointer-events: none;
		}

		.modal-overlay-visible {
			opacity: 0.5;
		}

		.custom-select {
			background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
			background-position: right 0.5rem center;
			background-repeat: no-repeat;
			background-size: 1.5em 1.5em;
			-webkit-print-color-adjust: exact;
			print-color-adjust: exact;
		}
	</style>
</head>

<body class="bg-gray-50 min-h-screen">
	<div class="container mx-auto px-4 py-8">
		<!-- Header -->
		<header class="mb-10 text-center">
			<h1 class="text-4xl font-bold text-dark mb-2">Sistem Antrian Digital</h1>
			<p class="text-lg text-gray-600">PSB PPDWK - TAHUN 2025/2026</p>
			<div class="mt-4 flex justify-center">
				<div class="bg-primary text-white px-4 py-2 rounded-full flex items-center">
					<i class="fas fa-clock mr-2"></i>
					<span id="current-time">00:00:00</span>
				</div>
				<div class="bg-secondary text-white px-4 py-2 rounded-full flex items-center ml-4">
					<span id="current-date">Hari, DD/MM/YYYY</span>
				</div>

				<button onclick="openModal()" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg flex items-center ml-4">
					<i class="fas fa-cog mr-2"></i> Pengaturan
				</button>
				<button onclick="window.location='auth/logout'" class="bg-danger hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center ml-4">
					<i class="fas fa-sign-out-alt mr-2"></i> Logout
				</button>

				<!-- Modal Overlay -->
				<div id="modal-overlay" class="fixed inset-0 bg-black modal-overlay modal-overlay-hidden z-40"></div>

				<!-- Modal -->
				<div id="antrian-modal" class="modal modal-hidden fixed inset-0 flex items-center justify-center z-50">
					<div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4">
						<!-- Modal Header -->
						<div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
							<h3 class="text-lg font-semibold text-gray-800">Atur Antrian</h3>
							<button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
								<i class="fas fa-times"></i>
							</button>
						</div>

						<!-- Modal Body -->
						<div class="p-6">
							<form id="antrian-form" class="space-y-5" method="post" action="<?= base_url('welcome/upTugas') ?>">
								<!-- Select User -->
								<div>
									<label for="select-user" class="block text-sm font-medium text-gray-700 mb-1">Pilih User</label>
									<div class="relative">
										<select id="select-user" name="user" class="custom-select w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary appearance-none">
											<option value="" disabled selected>-- Pilih User --</option>
											<?php foreach ($data_user as $du): ?>
												<option value="<?= $du->user_id ?>"><?= $du->nama ?></option>
											<?php endforeach ?>
										</select>
										<!-- <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
											<i class="fas fa-user text-gray-400"></i>
										</div> -->
									</div>
								</div>

								<!-- Select Loket -->
								<div>
									<label for="select-loket" class="block text-sm font-medium text-gray-700 mb-1">Pilih Meja</label>
									<div class="relative">
										<select id="select-loket" name="meja" class="custom-select w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary appearance-none">
											<option value="" disabled selected>-- Pilih Meja --</option>
											<?php foreach ($data_meja as $dm): ?>
												<option value="<?= $dm->id ?>"><?= $dm->nama ?></option>
											<?php endforeach ?>
										</select>
										<!-- <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
											<i class="fas fa-desktop text-gray-400"></i>
										</div> -->
									</div>
								</div>
							</form>
						</div>

						<!-- Modal Footer -->
						<div class="border-t border-gray-200 px-6 py-4 flex justify-end space-x-3">
							<button onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
								Batal
							</button>
							<button type="submit" form="antrian-form" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition flex items-center">
								<i class="fas fa-check-circle mr-2"></i> Simpan
							</button>
						</div>
					</div>
				</div>

			</div>
		</header>

		<!-- Main Content -->
		<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
			<!-- Panel Antrian Sekarang -->
			<div class="bg-white rounded-xl shadow-lg p-6 col-span-2">
				<h2 class="text-2xl font-semibold text-dark mb-6">Antrian Saat Ini</h2>

				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
					<?php foreach ($meja as $meja): ?>
						<!-- Loket -->
						<div class="bg-gray-100 rounded-lg p-4 text-center">
							<div
								class="bg-primary text-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
								<span class="text-2xl font-bold"><?= $meja['nomor_meja'] ?></span>
							</div>
							<h3 class="font-medium text-lg mb-2"><?= $meja['petugas'] ?></h3>
							<div class="text-4xl font-bold text-accent mb-2" id="current-queue-1">
								<?= $meja['jenis'] != '' && $meja['antrian'] != '' ? $meja['jenis'] . convNol($meja['antrian']) : '0' ?>
							</div>
							<div class="text-gray-500" id="current-name-1"><?= $meja['nama'] != '' ? $meja['nama'] : 'belum' ?></div>
						</div>
					<?php endforeach ?>
				</div>
				<!-- Antrian Berikutnya -->
				<div class="mt-8">
					<h3 class="text-xl font-semibold mb-4">Antrian Berikutnya</h3>
					<div class="bg-gray-50 rounded-lg p-4">
						<div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center font-medium">
							<?php foreach ($antrian as $ant): ?>
								<div>Nomor: <span class="text-accent"><?= $ant->jenis . convNol($ant->nomor) ?></span></div>
							<?php endforeach ?>
						</div>
					</div>
				</div>
			</div>

			<!-- Panel Ambil Antrian -->
			<div class="bg-white rounded-xl shadow-lg p-6">
				<h2 class="text-2xl font-semibold text-dark mb-6">Ambil Antrian</h2>

				<form class="space-y-4" method="post" action="<?= base_url('welcome/add') ?>">
					<div>
						<label class="block text-gray-700 mb-2">Cari Nama</label>
						<select id="cariSantri" name="nama" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
							<option>Pilih santri</option>
						</select>
					</div>
					<div>
						<label class="block text-gray-700 mb-2">Jenis</label>
						<select name="jenis" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
							<option value="A">Sudah Daftar</option>
							<option value="B">Belum Daftar</option>
						</select>
					</div>

					<button type="submit"
						class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center">
						<i class="fas fa-ticket-alt mr-2"></i> Ambil Nomor Antrian
					</button>
				</form>

				<!-- Info Antrian Anda -->
				<div class="mt-8 bg-blue-50 rounded-lg p-4 border border-blue-200">
					<h3 class="text-lg font-semibold text-blue-800 mb-2">Antrian Terakhir</h3>
					<div class="text-center py-4">
						<div class="text-5xl font-bold text-accent mb-2"><?= $last ? $last->jenis .  convNol($last->nomor) : 0 ?></div>
						<div class="text-gray-700">Nama: <span class="font-medium"><?= $last ? $last->nama : '' ?></span>
						</div>
					</div>
					<?php if ($last): ?>
						<a href="<?= base_url('welcome/batal/' . $last->id) ?>" onclick="return confirm('Yakin akan dibatalkan ?')"
							class="w-full bg-accent hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center">
							<i class="fas fa-trash mr-2"></i> Batalkan
						</a>
					<?php endif ?>
				</div>
			</div>
		</div>

		<!-- Daftar Antrian -->
		<div class="mt-10 bg-white rounded-xl shadow-lg p-6">
			<h2 class="text-2xl font-semibold text-dark mb-6">Daftar Antrian Hari Ini</h2>

			<div class="overflow-x-auto">
				<table class="w-full">
					<thead>
						<tr class="bg-gray-100 text-gray-700">
							<th class="py-3 px-4 text-left rounded-tl-lg">No. Antrian</th>
							<th class="py-3 px-4 text-left">Layanan</th>
							<th class="py-3 px-4 text-left">Nama</th>
							<th class="py-3 px-4 text-left">Waktu Ambil</th>
							<th class="py-3 px-4 text-left rounded-tr-lg">Status</th>
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

		<!-- Footer -->
		<footer class="mt-12 text-center text-gray-600">
			<p>© 2023 Sistem Antrian Digital - Dinas Pelayanan Publik</p>
			<p class="mt-2 text-sm">Nomor antrian dapat dipantau melalui aplikasi mobile kami</p>
			<div class="flex justify-center mt-4 space-x-4">
				<a href="#" class="text-primary hover:text-blue-700"><i class="fab fa-whatsapp text-xl"></i></a>
				<a href="#" class="text-primary hover:text-blue-700"><i class="fab fa-instagram text-xl"></i></a>
				<a href="#" class="text-primary hover:text-blue-700"><i class="fas fa-globe text-xl"></i></a>
			</div>
		</footer>
	</div>

	<script>
		// Update waktu dan tanggal secara real-time
		function updateDateTime() {
			const now = new Date();

			// Format waktu
			const timeString = now.toLocaleTimeString('id-ID', {
				hour: '2-digit',
				minute: '2-digit',
				second: '2-digit'
			});

			// Format tanggal
			const options = {
				weekday: 'long',
				year: 'numeric',
				month: 'long',
				day: 'numeric'
			};
			const dateString = now.toLocaleDateString('id-ID', options);

			document.getElementById('current-time').textContent = timeString;
			document.getElementById('current-date').textContent = dateString;
		}

		// Update setiap detik
		setInterval(updateDateTime, 1000);
		updateDateTime(); // Panggil sekali saat pertama kali load

		function openModal() {
			document.getElementById('antrian-modal').classList.remove('modal-hidden');
			document.getElementById('antrian-modal').classList.add('modal-visible');
			document.getElementById('modal-overlay').classList.remove('modal-overlay-hidden');
			document.getElementById('modal-overlay').classList.add('modal-overlay-visible');
			document.body.style.overflow = 'hidden'; // Prevent scrolling
		}

		// Fungsi untuk menutup modal
		function closeModal() {
			document.getElementById('antrian-modal').classList.remove('modal-visible');
			document.getElementById('antrian-modal').classList.add('modal-hidden');
			document.getElementById('modal-overlay').classList.remove('modal-overlay-visible');
			document.getElementById('modal-overlay').classList.add('modal-overlay-hidden');
			document.body.style.overflow = ''; // Enable scrolling
		}

		// Tutup modal ketika klik overlay
		document.getElementById('modal-overlay').addEventListener('click', closeModal);

		// Tutup modal dengan ESC key
		document.addEventListener('keydown', function(event) {
			if (event.key === 'Escape') {
				closeModal();
			}
		});
	</script>
	<script>
		$(document).ready(function() {
			$('#cariSantri').select2({
				placeholder: "Pilih santri",
				allowClear: true,
				width: '100%' // supaya mengikuti lebar Tailwind
			});
			loadSantri();
		});

		function loadSantri() {
			$.ajax({
				type: "GET",
				url: "<?= base_url('welcome/santri') ?>",
				dataType: "json",
				success: function(response) {
					$('#cariSantri').empty();
					$.each(response.data.data, function(index, value) {
						$('#cariSantri').append(' <option value = "' + value.nama + '" >' + value.nama + ' </>');
					});
				},
				error: function(xhr, status, error) {
					console.log(xhr.responseText);
				}
			});
		}
	</script>


</body>

</html>