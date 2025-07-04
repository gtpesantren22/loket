<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Antrian Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        dark: '#1F2937',
                    }
                }
            }
        }

        // Contoh fungsi login (simulasi)
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "timeOut": "3000"
        };

        function attemptLogin() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            // Simulasi error
            if (username === '' || password === '') {
                toastr.error('Username dan password harus diisi');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "<?= base_url('auth/login') ?>",
                data: {
                    username: username,
                    password: password
                },
                dataType: 'json',
                success: function(data) {
                    var url = data.rdrc;
                    if (data.status == 'success') {
                        toastr.success('Login Success');
                        window.location.href = data.rdrc;
                    } else {
                        toastr.error('Username atau password salah');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Terjadi kesalahan saat login');
                    console.log(xhr);
                    console.log(status);
                    console.log(error);



                }
            });
        }
    </script>
    <style>
        .bg-login {
            background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%);
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md mx-4">

        <!-- Card Login -->
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <!-- Header dengan gradient -->
            <div class="bg-login py-6 px-8 text-center">
                <i class="fas fa-ticket-alt text-white text-4xl mb-3"></i>
                <h1 class="text-2xl font-bold text-white">Sistem Antrian Digital</h1>
                <p class="text-blue-100 mt-1">PSB PPDWK - Tahun 2025/2026</p>
            </div>

            <!-- Form Login -->
            <div class="px-8 py-8">
                <form class="space-y-6" onsubmit="event.preventDefault(); attemptLogin();">
                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" name="username" id="username"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Masukkan username">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" id="password"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Masukkan password">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-medium text-primary hover:text-blue-700">Lupa password?</a>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary hover:opacity-90 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-300">
                            <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                        </button>
                    </div>
                </form>

            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-4 text-center">
                <p class="text-sm text-gray-600">Belum punya akun? <a href="auth/register"
                        class="font-medium text-primary hover:text-blue-700">Daftar sekarang</a></p>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>© 2023 Sistem Antrian Digital - DWK 2025. All rights reserved.</p>
        </div>
    </div>
</body>

</html>