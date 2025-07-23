<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Absensi Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.2.0/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/dist/html5-qrcode.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4">QR Absensi Siswa</h1>
        <div id="reader" class="mb-4"></div>
        <p id="status" class="text-gray-600 mb-4">Scan QR Code untuk melakukan absensi.</p>
        <div id="qr-reader-results"></div>
        <audio id="beepSound" src="https://cdn.excode.my.id/assets/beeb.mp3" preload="auto"></audio> <!-- Tambahkan file beep.mp3 di direktori yang sesuai -->
    </div>

    <script>
        let html5QrcodeScanner;

        // Callback sukses untuk pemindaian kode QR
        function onScanSuccess(qrCodeMessage) {
            // Memutar suara beep
            document.getElementById('beepSound').play();

            fetch('<?= site_url('QrAbsensi/submit_qr_absensi') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: `qr_code=${encodeURIComponent(qrCodeMessage)}`
                })
                .then(response => response.json())
                .then(data => {
                    const resultDiv = document.getElementById('qr-reader-results');
                    resultDiv.innerHTML = `
                        <div class="mt-4 p-4 ${data.status === 'success' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'} rounded">
                            ${data.message}
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            // Hentikan pemindaian setelah QR Code terdeteksi
            html5QrcodeScanner.clear();
        }

        function onScanError(errorMessage) {
            console.error('Error:', errorMessage);
        }

        $(document).ready(function() {
            html5QrcodeScanner = new Html5Qrcode("reader");

            // Mulai pemindaian dengan kamera default
            html5QrcodeScanner.start({
                    facingMode: "environment"
                }, // Menggunakan kamera belakang
                {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                onScanSuccess,
                onScanError
            ).catch(function(error) {
                $('#status').text('Gagal memulai scanner.');
                console.error('Error starting scanner:', error);
            });
        });
    </script>
</body>

</html>