<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Access Install</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <style>
        .toast {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-100 to-blue-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white p-8 rounded-2xl shadow-lg max-w-md w-full">
        <div class="text-center mb-6">
            <!-- Tambahkan logo jika ingin -->
            <!-- <img src="logo.png" alt="SISMA" class="mx-auto mb-3 w-14"> -->
            <h1 class="text-2xl font-bold text-gray-800">Akses Instalasi SISMA</h1>
            <p class="text-gray-600 text-sm mt-1">Masukkan Access Key Anda untuk melanjutkan.</p>
        </div>

        <?php if ($this->session->flashdata('message')) : ?>
            <div class="toast bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-4">
                <strong class="font-semibold">Error:</strong>
                <span class="block mt-1"><?php echo $this->session->flashdata('message'); ?></span>
            </div>
        <?php endif; ?>

        <form action="<?php echo site_url('install/access'); ?>" method="post">
            <div class="mb-4">
                <label for="access_key" class="block text-gray-700 mb-2 text-sm font-medium">Access Key</label>
                <input
                    type="password"
                    name="access_key"
                    id="access_key"
                    class="border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="••••••••"
                    required />
            </div>
            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                Submit
            </button>
        </form>
    </div>
</body>

</html>