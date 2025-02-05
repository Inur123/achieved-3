<!-- resources/views/admin/transaksi/invoice.blade.php -->
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-container {
            width: 100%;
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .company-info {
            text-align: center;
            font-size: 14px;
            color: #777;
        }
        .company-info p {
            margin: 0;
        }
        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .badge {
            padding: 3px 8px;
            font-size: 12px;
            border-radius: 3px;
            color: white;
        }
        .bg-warning {
            background-color: orange;
        }
        .bg-success {
            background-color: green;
        }
        .bg-info {
            background-color: blue;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header with Logo and Company Info -->
        <div class="header">
            <!-- Replace with your logo -->
            <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('template/assets/images/logos/logo2.png'))) }}" alt="Company Logo">


            <h2>Invoice</h2>
        </div>

        <!-- Company Information -->
        <div class="company-info">
            <p><strong>Achieved.id</strong></p>
            <p>Address: Jl. Example No. 123</p>
            <p>Email: support@company.com | Phone: 0812-3456-7890</p>
        </div>

        <!-- Transaction Details -->
        <div>
            <p><strong>Invoice: #{{ $transaction->order_id }}</strong></p>
            <p><strong>Nama User:</strong> {{ $transaction->user->name }}</p>
            <p><strong>Email User:</strong> {{ $transaction->user->email }}</p>
            <p><strong>Nama Produk:</strong> {{ $transaction->product->name }}</p>
            <p><strong>Tanggal Transaksi:</strong> {{ $transaction->created_at->translatedFormat('l, d F Y | H.i.s') }}</p>
            <p><strong>Status Pembayaran:</strong>
                @if ($transaction->status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                @elseif ($transaction->status == 'paid')
                    <span class="badge bg-info">Paid</span>
                @else
                    <span class="badge bg-success">Lunas</span>
                @endif
            </p>
            <p><strong>Total:</strong> Rp {{ number_format($transaction->price, 0, ',', '.') }}</p>
        </div>

        <!-- Product and Pricing Table -->
        <table class="table">
            <tr>
                <th>Produk</th>
                <th>Harga</th>
            </tr>
            <tr>
                <td>{{ $transaction->product->name }}</td>
                <td>Rp {{ number_format($transaction->price, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
