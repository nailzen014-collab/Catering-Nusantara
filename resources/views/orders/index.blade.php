{{-- resources/views/orders/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Order - Katering Nusantara</title>
    <style>
        body {
            font-family: -apple-system, Arial, sans-serif;
            background: #FAF7F2;
            margin: 0;
            padding: 24px;
            color: #2c2c2c;
        }
        h1 {
            color: #B0713F;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 16px;
            text-align: left;
            vertical-align: top;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #B0713F;
            color: #fff;
            font-weight: 600;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .city, .category {
            color: #888;
            font-size: 0.85em;
        }
        .item-list {
            margin: 0;
            padding-left: 18px;
        }
        .status {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 0.8em;
            background: #f0e4d8;
            color: #B0713F;
        }
        .pagination {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h1>Dashboard Order Admin</h1>

    <table>
        <thead>
            <tr>
                <th>ID Order</th>
                <th>Pelanggan</th>
                <th>Pesanan</th>
                <th>Pengiriman &amp; Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    {{-- ID Order --}}
                    <td>#{{ $order->id }}</td>

                    {{-- Pelanggan: Nama + Kota --}}
                    <td>
                        {{ $order->customer->name }}<br>
                        <span class="city">{{ $order->customer->city->name }}</span>
                    </td>

                    {{-- Pesanan: qty x Nama Menu (Kategori) --}}
                    <td>
                        <ul class="item-list">
                            @foreach ($order->orderItems as $item)
                                <li>
                                    {{ $item->qty }}x {{ $item->menu->name }}
                                    <span class="category">({{ $item->menu->category->name }})</span>
                                </li>
                            @endforeach
                        </ul>
                    </td>

                    {{-- Pengiriman & Pembayaran: Kurir - Metode Bayar --}}
                    <td>
                        {{ $order->courier->name }} - {{ $order->paymentMethod->name }}<br>
                        <span class="status">{{ $order->status }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada data order.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        {{ $orders->links() }}
    </div>

</body>
</html>