<?php if ($kamar) { ?>
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold mb-6">Kamar <?= $kamar->kamar ?></h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            <?php
            $bg = $kamar->daerah == 'Putra' ? 'blue' : 'pink';
            foreach ($loker->result() as $loker): ?>
                <?php if ($loker->pemilik != '') { ?>
                    <div data-kamar="<?= $kamar->kamar ?>" data-loker="<?= $loker->nomor ?>" class="loker data bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm relative">
                        <div class="loker-door bg-<?= $bg ?>-100 p-4 h-40 flex flex-col justify-between">
                            <div class="flex justify-between items-start">
                                <span class="bg-<?= $bg ?>-600 text-white text-xs px-2 py-1 rounded">Nomor <?= $loker->nomor ?></span>
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Terisi</span>
                            </div>
                            <div class="text-center">
                                <i class="fas fa-user text-3xl text-<?= $bg ?>-500 mb-2"></i>
                                <p class="font-medium">Nama Santri</p>
                            </div>
                        </div>
                        <div class="p-3 bg-gray-50 border-t border-gray-200">
                            <p class="text-sm text-gray-600 truncate"><i class="fas fa-user mr-1 text-<?= $bg ?>-500"></i> Ahmad Fauzi</p>
                            <p class="text-sm text-gray-600 truncate"><i class="fas fa-calendar-alt mr-1 text-<?= $bg ?>-500"></i> 12 Mei 2023</p>
                        </div>
                    </div>
                <?php } else { ?>
                    <!-- Loker 2 -->
                    <div data-kamar="<?= $kamar->kamar ?>" data-loker="<?= $loker->nomor ?>" class="loker data bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm relative">
                        <div class="loker-door bg-grey-100 p-4 h-40 flex flex-col justify-between">
                            <div class="flex justify-between items-start">
                                <span class="bg-<?= $bg ?>-600 text-white text-xs px-2 py-1 rounded">Nomor <?= $loker->nomor ?></span>
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Kosong</span>
                            </div>
                            <div class="text-center">
                                <i class="fas fa-user text-3xl text-gray-400 mb-2"></i>
                                <p class="font-medium text-gray-500">Kosong</p>
                            </div>
                        </div>
                        <div class="p-3 bg-gray-50 border-t border-gray-200">
                            <p class="text-sm text-gray-400 italic">Loker tersedia</p>
                        </div>

                    </div>
            <?php }
            endforeach ?>

        </div>

    </div>
<?php } else {
    echo "Tidak ada data dikamar ini";
} ?>

<!-- Modal Detail Loker (Contoh) -->
<div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="modal-overlay absolute inset-0 bg-black opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-lg font-semibold" id="dtlLoker"></h3>
                <button onclick="closeModal()" class="modal-close cursor-pointer z-50">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal body -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <p class="mt-1"><span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Terisi</span></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Isi Loker</label>
                    <p class="mt-1">Dokumen Keuangan</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Penanggung Jawab</label>
                    <p class="mt-1">Ahmad Fauzi</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Penyimpanan</label>
                    <p class="mt-1">12 Mei 2023</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <p class="mt-1">Dokumen keuangan tahun 2022-2023</p>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="flex justify-end pt-4 space-x-3">
                <button onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Tutup
                </button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    <i class="fas fa-edit mr-1"></i> Edit
                </button>
            </div>
        </div>
    </div>
</div>



<script>
    function openModal() {
        document.getElementById('detailModal').classList.remove('hidden');
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // Contoh: Buka modal saat mengklik tombol detail
    document.querySelectorAll('.loker').forEach(loker => {
        loker.addEventListener('click', function(e) {
            // Jika yang diklik bukan button di dalam .loker
            if (!e.target.closest('button')) {
                openModal();

                // Ambil data-* attribute menggunakan dataset (JavaScript murni)
                const dataLoker = this.getAttribute('data-loker');
                const dataKamar = this.getAttribute('data-kamar');
                document.getElementById('dtlLoker').textContent = `Detail Loker ${dataLoker} - Kamar ${dataKamar}`
            }
        });
    });
</script>