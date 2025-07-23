<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Instalasi SmartSchool</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <style>
        .toast {
            animation: slideIn 0.4s ease-out;
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

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-lg w-full">
        <div class="text-center mb-6">
            <!-- Tambahkan logo jika ada -->
            <!-- <img src="logo.png" alt="SmartSchool" class="mx-auto mb-3 w-16"> -->
            <h1 class="text-3xl font-bold text-gray-800">Instalasi SmartSchool</h1>
            <p class="text-gray-600 mt-2">Selamat datang! Silakan lanjutkan untuk menginstal sistem SmartSchool.</p>
        </div>

        <?php if (!empty($message)) : ?>
            <?php if (strpos($message, 'successfully') !== false) : ?>
                <div class="toast bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md mb-4">
                    <strong class="font-semibold">Berhasil:</strong>
                    <span class="block mt-1"><?php echo $message; ?></span>
                </div>
            <?php elseif (strpos($message, 'Failed') !== false) : ?>
                <div class="toast bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md mb-4">
                    <strong class="font-semibold">Gagal:</strong>
                    <span class="block mt-1"><?php echo $message; ?></span>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="<?php echo site_url('install/execute'); ?>" method="post">
            <div class="mb-4 text-left">
                <label class="inline-flex items-start">
                    <input type="checkbox" name="confirm_install" required class="mt-1 mr-2 text-blue-500 focus:ring focus:ring-blue-300" />
                    <span class="text-sm text-gray-700">Saya menyetujui untuk melanjutkan instalasi database SmartSchool.</span>
                </label>
                <?php echo form_error('confirm_install', '<p class="text-red-500 text-xs italic mt-2">', '</p>'); ?>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 ease-in-out">
                Mulai Instalasi
            </button>
        </form>
    </div>
</body>

</html>