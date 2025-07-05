<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Santri - Sistem Pesantren</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">

    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

    <style>
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.1);
            z-index: 1;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            color: #4B5563;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: #F3F4F6;
            color: #1F2937;
        }

        .dropdown-item i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        /* Custom DataTables style */
        .dataTables_wrapper .dataTables_length select {
            background-position: right 0.5rem center;
            padding-right: 1.5rem;
        }

        /* Ensure table rows are visible */
        #santriTable tbody tr {
            background-color: white;
        }

        #santriTable tbody tr:hover {
            background-color: #F9FAFB !important;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-dark">Data Santri</h1>
                <p class="text-gray-600">Sistem Manajemen Pesantren</p>
            </div>

            <!-- Dropdown User Menu -->
            <div class="dropdown relative">
                <button class="flex items-center space-x-2 bg-white px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 transition">
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white">
                        <i class="fas fa-user"></i>
                    </div>
                    <span>Admin Pesantren</span>
                    <i class="fas fa-chevron-down text-gray-500 text-xs"></i>
                </button>

                <div class="dropdown-content mt-2">
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user-cog"></i> Profil Saya
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-cog"></i> Pengaturan
                    </a>
                    <div class="border-t border-gray-200"></div>
                    <a href="#" class="dropdown-item text-red-500 hover:text-red-700" onclick="confirmLogout()">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </header>

        <!-- Panel Kontrol -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class="mb-4 md:mb-0">
                    <h2 class="text-xl font-semibold mb-1">Daftar Santri Aktif</h2>
                    <p class="text-gray-600">Total: <span id="totalSantri" class="font-medium">0 Santri</span></p>
                </div>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 w-full md:w-auto">
                    <button class="flex bg-secondary hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center" onclick="window.location='<?= base_url('meja') ?>'">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </button>
                    <!-- Tombol Tambah Santri -->
                    <button id="btnTambahSantri" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center whitespace-nowrap">
                        <i class="fas fa-plus mr-2"></i> Tambah Santri
                    </button>

                    <!-- Tombol Export -->
                    <div class="dropdown relative">
                        <button class="flex items-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg whitespace-nowrap">
                            <i class="fas fa-file-export mr-2"></i> Export
                            <i class="fas fa-chevron-down text-gray-500 text-xs ml-2"></i>
                        </button>
                        <div class="dropdown-content mt-1 w-full">
                            <a href="#" class="dropdown-item" onclick="exportData('excel')">
                                <i class="fas fa-file-excel text-green-600"></i> Excel
                            </a>
                            <a href="#" class="dropdown-item" onclick="exportData('pdf')">
                                <i class="fas fa-file-pdf text-red-600"></i> PDF
                            </a>
                            <a href="#" class="dropdown-item" onclick="exportData('print')">
                                <i class="fas fa-print text-blue-600"></i> Print
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data Santri dengan DataTables -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table id="santriTable" class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">NIS</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama Santri</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Kamar</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">lembaga</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan diisi oleh DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Santri -->
    <div id="santriModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="modal-overlay absolute inset-0 bg-black opacity-50"></div>
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-3">
                    <h3 id="modalTitle" class="text-lg font-semibold">Tambah Data Santri</h3>
                    <button onclick="closeModal()" class="modal-close cursor-pointer z-50">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Modal body -->
                <form id="santriForm" class="space-y-4">
                    <input type="hidden" id="santriId">
                    <div>
                        <label for="nis" class="block text-sm font-medium text-gray-700">NIS</label>
                        <input type="text" id="nis" name="nis" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Santri</label>
                        <input type="text" id="nama" name="nama" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="kamar" class="block text-sm font-medium text-gray-700">Kamar</label>
                        <input type="text" id="kamar" name="kamar" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="jenjang" class="block text-sm font-medium text-gray-700">Jenjang</label>
                        <select id="jenjang" name="jenjang" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">
                            <option value="MTs Kelas 7">MTs Kelas 7</option>
                            <option value="MTs Kelas 8">MTs Kelas 8</option>
                            <option value="MTs Kelas 9">MTs Kelas 9</option>
                            <option value="MA Kelas 10">MA Kelas 10</option>
                            <option value="MA Kelas 11">MA Kelas 11</option>
                            <option value="MA Kelas 12">MA Kelas 12</option>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">
                            <option value="Aktif">Aktif</option>
                            <option value="Izin">Izin</option>
                            <option value="Non-Aktif">Non-Aktif</option>
                        </select>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex justify-end pt-4 space-x-3">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Data contoh santri (dalam aplikasi nyata, data ini akan berasal dari API)
        const sampleData = <?= json_encode($data['data'] ?? [], JSON_UNESCAPED_UNICODE); ?>;

        // Inisialisasi DataTable
        let santriTable;
        console.log('hasil :' + sampleData);


        $(document).ready(function() {
            // const filteredData = sampleData.filter(row => row.lembaga.nama !== 'MI DARUL LUGHAH WAL KAROMAH' && row.lembaga.nama !== 'RA DARUL LUGHAH WAL KAROMAH' && row.pd_lama == null);
            santriTable = $('#santriTable').DataTable({
                data: sampleData,
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'nis'
                    },
                    {
                        data: 'nama',
                        render: function(data, type, row) {
                            return `
    <div class="flex items-center">
        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
            <i class="fas fa-user"></i>
        </div>
        <div class="ml-4">
            <div class="font-medium text-gray-900">${row.nama}</div>
            <div class="text-gray-500 text-sm">${row.wilayah.nama || '-'}</div>
        </div>
    </div>
    `;
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            return '-'
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return row.lembaga
                        }
                    },
                    {
                        data: 'ket',
                        render: function(data, row) {
                            let bgColor = 'bg-green-100 text-green-800';
                            let stts = 'Baru';
                            if (data != 'baru') bgColor = 'bg-yellow-100 text-yellow-800';
                            if (data != 'baru') stts = 'Lanjutan';

                            return `<span class="px-2 py-1 text-xs font-semibold rounded-full ${bgColor}">${stts}</span>`;
                        }
                    },
                    {
                        data: 'nis',
                        render: function(data, type, row) {
                            return `
    <a href="<?= base_url('santri/formulir/') ?>${data}" target="_blank" class="text-primary hover:text-blue-700 mr-3">
        <i class="fas fa-print"></i>
    </a>
    <a href="<?= base_url('santri/ikrar/') ?>${data}" target="_blank" class="text-red-500 hover:text-red-700">
        <i class="fas fa-list"></i>
    </a>
    `;
                        },
                        orderable: false
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                responsive: true,
                dom: '<"flex flex-col md:flex-row justify-between items-center mb-4"<"mb-4 md:mb-0"l><"flex"f>>rt<"flex flex-col md:flex-row justify-between items-center mt-4"<"mb-4 md:mb-0"i><"flex"p>>',
                initComplete: function() {
                    // Update total santri
                    $('#totalSantri').text(`${this.api().data().length} Santri`);
                }
            });

            // Custom search input (jika ingin lebih custom dari default DataTables)
            $('#santriTable_filter input').addClass('border border-gray-300 rounded-lg px-3 py-2 focus:ring-primary focus:border-primary');
        });

        // Fungsi untuk logout
        function confirmLogout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                // Redirect ke halaman login
                window.location.href = 'login.html';
            }
        }

        // Fungsi untuk export data
        function exportData(type) {
            alert(`Fitur export ${type} akan diimplementasikan di sini`);
            // Implementasi export sesuai kebutuhan
            // Bisa menggunakan DataTables buttons extension
        }

        // Fungsi untuk membuka modal tambah santri
        $('#btnTambahSantri').click(function() {
            $('#modalTitle').text('Tambah Data Santri');
            $('#santriForm')[0].reset();
            $('#santriId').val('');
            $('#santriModal').removeClass('hidden');
        });

        // Fungsi untuk edit santri
        function editSantri(id) {
            const santri = sampleData.find(item => item.id === id);
            if (santri) {
                $('#modalTitle').text('Edit Data Santri');
                $('#santriId').val(santri.id);
                $('#nis').val(santri.nis);
                $('#nama').val(santri.nama);
                $('#kamar').val(santri.kamar);
                $('#jenjang').val(santri.jenjang);
                $('#status').val(santri.status);
                $('#santriModal').removeClass('hidden');
            }
        }

        // Fungsi untuk hapus santri
        function deleteSantri(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data santri ini?')) {
                // Dalam aplikasi nyata, ini akan berupa AJAX request ke server
                alert(`Data santri dengan ID ${id} akan dihapus`);
                // Setelah hapus, refresh DataTable
                // santriTable.ajax.reload();
            }
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            $('#santriModal').addClass('hidden');
        }

        // Handle form submission
        $('#santriForm').submit(function(e) {
            e.preventDefault();

            const formData = {
                id: $('#santriId').val(),
                nis: $('#nis').val(),
                nama: $('#nama').val(),
                kamar: $('#kamar').val(),
                jenjang: $('#jenjang').val(),
                status: $('#status').val()
            };

            // Validasi sederhana
            if (!formData.nis || !formData.nama) {
                alert('NIS dan Nama Santri harus diisi!');
                return;
            }

            // Simulasi save data
            if (formData.id) {
                // Edit existing data
                alert(`Data santri ${formData.nama} berhasil diperbarui`);
            } else {
                // Add new data
                alert(`Data santri ${formData.nama} berhasil ditambahkan`);
            }

            // Tutup modal
            closeModal();

            // Refresh DataTable (dalam aplikasi nyata, ini akan berupa AJAX request ke server)
            // santriTable.ajax.reload();
        });
    </script>
</body>

</html>