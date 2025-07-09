<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Loker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .loker {
            transition: all 0.3s ease;
            transform-style: preserve-3d;
        }

        .loker:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .loker-door {
            transition: transform 0.5s ease;
            transform-origin: left;
        }

        .loker:hover .loker-door {
            transform: perspective(800px) rotateY(-30deg);
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Data Penempatan Santri</h1>
            <p class="text-gray-600">PSB PPDWK - Tahun Pelajaran 2025/2026</p>

            <div class="flex justify-between items-center mt-4">
                <div class="relative w-64">
                    <input type="text" placeholder="Cari loker..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <!-- <button id="tambahData" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Loker
                </button> -->
            </div>
        </header>

        <!-- Filter -->
        <div class="bg-white rounded-lg shadow p-4 mb-4 flex flex-wrap gap-4">
            <form id="cek-kamar" class="flex items-center gap-4 flex-wrap">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Daerah</label>
                    <select id="daerah" name="daerah" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>-pilih daerah-</option>
                        <option value="Putra">Putra</option>
                        <option value="Putri">Putri</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Komplek</label>
                    <select id="komplek" name="komplek" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>-pilih komplek-</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kamar</label>
                    <select id="kamar" name="kamar" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>-pilih kamar-</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">-</label>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-eye mr-2"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>

        <!-- Lemari Loker -->
        <div id="show-kamar">
            <?php foreach ($komplek as $kmp):
            ?>
                <div class="bg-white rounded-xl shadow-lg p-6 mt-2">
                    <h2 class="text-xl font-semibold mb-6">Komplek <?= $kmp->komplek ?></h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                        <!-- Loker 1 -->
                        <?php
                        $kamar = $this->db->query("SELECT * FROM kamar WHERE komplek = '$kmp->komplek' ORDER BY kamar ASC ")->result();
                        foreach ($kamar as $kmr) {
                            $bg = $kmr->daerah == 'Putra' ? 'blue' : 'pink';
                        ?>
                            <div class="loker bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm relative">
                                <div class="loker-door bg-<?= $bg ?>-100 p-4 h-40 flex flex-col justify-between">
                                    <div class="flex justify-between items-start">
                                        <span class="bg-<?= $bg ?>-600 text-white text-xs px-2 py-1 rounded"><?= $kmr->daerah ?></span>
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Terisi</span>
                                    </div>
                                    <div class="text-center">
                                        <i class="fas fa-building text-3xl text-<?= $bg ?>-500 mb-2"></i>
                                        <p class="font-medium"><?= $kmr->kamar ?></p>
                                    </div>
                                </div>
                                <div class="p-3 bg-gray-50 border-t border-gray-200">
                                    <p class="text-sm text-gray-600 truncate"><i class="fas fa-user mr-1 text-<?= $bg ?>-500"></i> <?= $kmr->ketua ?></p>
                                    <!-- <p class="text-sm text-gray-600 truncate"><i class="fas fa-calendar-alt mr-1 text-<?= $bg ?>-500"></i> 12 Mei 2023</p> -->
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    </div>


    <script>
        $('#daerah').on('change', function() {
            var daerah = $(this).val();
            // alert(daerah)
            $.ajax({
                type: "POST",
                url: "<?= base_url('kamar/daerah') ?>",
                data: {
                    daerah: daerah
                },
                dataType: 'json',
                success: function(data) {
                    $('#komplek').html(`<option>-pilih komplek-</option>`)
                    $.each(data, function(index, item) {
                        $('#komplek').append(`<option value='${item.komplek}'>${item.komplek}</option>`)
                    });
                },
                error: function() {
                    alert('Error');
                }
            })
        })
        $('#komplek').on('change', function() {
            var komplek = $(this).val();
            // alert(daerah)
            $.ajax({
                type: "POST",
                url: "<?= base_url('kamar/komplek') ?>",
                data: {
                    komplek: komplek
                },
                dataType: 'json',
                success: function(data) {
                    $('#kamar').empty()
                    $.each(data, function(index, item) {
                        $('#kamar').append(`<option value='${item.id}'>${item.kamar}</option>`)
                    });
                },
                error: function() {
                    alert('Error');
                }
            })
        })

        $('#cek-kamar').on('submit', function(e) {
            e.preventDefault()
            var id = $('#kamar').val();
            $.ajax({
                type: "POST",
                url: "<?= base_url('kamar/listKamar') ?>",
                data: {
                    id: id
                },
                dataType: 'html',
                success: function(data) {
                    $('#show-kamar').empty()
                    $('#show-kamar').html(data)
                },
                error: function() {
                    alert('Error');
                }
            })
        })
    </script>
</body>

</html>