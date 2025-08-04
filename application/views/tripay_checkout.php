<!DOCTYPE html>
<html>
<head>
    <title>Checkout dengan Tripay</title>
</head>
<body>
    <h2>Form Pembayaran</h2>
    <form action="<?= base_url('tripay/create_transaction') ?>" method="post">
        <label>Metode Pembayaran (mis. QRIS, BNI, BCA):</label>
        <input type="text" name="method" required><br>

        <label>Nominal (mis. 10000):</label>
        <input type="number" name="amount" required><br>

        <label>Nama Customer:</label>
        <input type="text" name="customer_name" required><br>

        <label>Email Customer:</label>
        <input type="email" name="customer_email" required><br>

        <button type="submit">Bayar Sekarang</button>
    </form>
</body>
</html>
