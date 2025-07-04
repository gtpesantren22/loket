<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Sistem Antrian Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        danger: '#EF4444',
                        dark: '#1F2937',
                    }
                }
            }
        }

        // Fungsi untuk validasi form
        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const errorElement = document.getElementById('error-message');

            // Reset error
            errorElement.textContent = '';
            document.getElementById('error-notification').classList.add('hidden');

            // Validasi password match
            if (password !== confirmPassword) {
                showError('Password dan konfirmasi password tidak sama');
                return false;
            }

            // Validasi panjang password
            if (password.length < 4) {
                showError('Password minimal 4 karakter');
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "<?= base_url('auth/daftar') ?>",
                data: {
                    nama: document.getElementById('nama').value,
                    username: document.getElementById('username').value,
                    password: password,
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        window.location.href = '<?= base_url() ?>';
                        showSuccess('simpan user berhasil');
                    } else {
                        showError('Error simpan user');
                    }
                },
                error: function(xhr, status, error) {
                    showError('Terjadi kesalahan saat login');
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });

            return true; // Untuk demo saja, di real app return true
        }

        // Fungsi untuk menampilkan notifikasi error
        function showError(message) {
            const errorNotif = document.getElementById('error-notification');
            const errorMessage = document.getElementById('error-message');

            errorMessage.textContent = message;
            errorNotif.classList.remove('hidden', 'bg-secondary');
            errorNotif.classList.add('bg-danger', 'animate-fade-in');

            // Sembunyikan setelah 5 detik
            setTimeout(() => {
                errorNotif.classList.add('animate-fade-out');
                setTimeout(() => {
                    errorNotif.classList.add('hidden');
                    errorNotif.classList.remove('animate-fade-in', 'animate-fade-out');
                }, 300);
            }, 5000);
        }

        // Fungsi untuk menampilkan notifikasi sukses
        function showSuccess(message) {
            const errorNotif = document.getElementById('error-notification');
            const errorMessage = document.getElementById('error-message');

            errorMessage.textContent = message;
            errorNotif.classList.remove('hidden', 'bg-danger');
            errorNotif.classList.add('bg-secondary', 'animate-fade-in');

            // Tetap tampil lebih lama untuk sukses (8 detik)
            setTimeout(() => {
                errorNotif.classList.add('animate-fade-out');
                setTimeout(() => {
                    errorNotif.classList.add('hidden');
                    errorNotif.classList.remove('animate-fade-in', 'animate-fade-out');
                }, 300);
            }, 8000);
        }
    </script>
    <style>
        .bg-register {
            background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%);
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-fade-out {
            animation: fadeOut 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6B7280;
        }

        .password-toggle:hover {
            color: #4B5563;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <!-- Notifikasi -->
    <div id="error-notification" class="hidden fixed top-4 left-1/2 transform -translate-x-1/2 w-full max-w-md z-50">
        <div class="text-white px-6 py-4 rounded-lg shadow-lg flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-xl"></i>
            </div>
            <div class="ml-4">
                <p id="error-message" class="text-sm mt-1">Pesan notifikasi akan muncul di sini</p>
            </div>
            <button onclick="document.getElementById('error-notification').classList.add('hidden')" class="ml-auto text-white opacity-70 hover:opacity-100">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <div class="w-full max-w-md">
        <!-- Card Register -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <!-- Header dengan gradient -->
            <div class="bg-register py-8 px-8 text-center">
                <div class="bg-white/20 p-4 rounded-full inline-block">
                    <i class="fas fa-user-plus text-white text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mt-4">Buat Akun Baru</h1>
                <p class="text-blue-100 mt-2">PSB PPDWK - Tahun 2025/2026</p>
            </div>

            <!-- Form Register -->
            <div class="px-8 py-8">
                <form class="space-y-5" onsubmit="event.preventDefault(); validateForm(); ">
                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" id="nama" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-at text-gray-400"></i>
                            </div>
                            <input type="text" id="username" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Buat username" required>
                        </div>
                    </div>

                    <div class="relative">
                        <label class="block text-gray-700 mb-2 font-medium">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" type="password" class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Buat password" required>
                            <span class="password-toggle" onclick="togglePassword('password')">
                                <i class="far fa-eye"></i>
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Minimal 4 karakter</p>
                    </div>

                    <div class="relative">
                        <label class="block text-gray-700 mb-2 font-medium">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="confirm-password" type="password" class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Ulangi password" required>
                            <span class="password-toggle" onclick="togglePassword('confirm-password')">
                                <i class="far fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="agree-terms" name="agree-terms" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" required>
                        <label for="agree-terms" class="ml-2 block text-sm text-gray-700">
                            Saya menyetujui <a href="#" class="text-primary hover:text-blue-700">Syarat & Ketentuan</a>
                        </label>
                    </div>

                    <div>
                        <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary hover:opacity-90 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-300">
                            <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">Sudah punya akun? <a href="<?= base_url() ?>" class="font-medium text-primary hover:text-blue-700">Masuk di sini</a></p>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>© 2023 Sistem Antrian Digital - DWK 2025. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Fungsi untuk toggle password visibility
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Fungsi untuk close notifikasi
        function closeNotification() {
            document.getElementById('error-notification').classList.add('hidden');
        }
    </script>
</body>

</html>