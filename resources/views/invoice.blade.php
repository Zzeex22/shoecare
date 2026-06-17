<!DOCTYPE html>
<html lang="id">
<head>
    <title>Invoice #{{ $order->kode_order }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 py-10" onload="window.print()">
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-xl print:shadow-none print:w-full print:max-w-none">
        <div class="text-center border-b-2 border-dashed border-gray-300 pb-6 mb-6">
            <h1 class="font-extrabold text-3xl text-gray-800 tracking-wider">SHOECARE.</h1>
            <p class="text-sm text-gray-500 mt-1">Premium Footwear Solutions</p>
            <p class="text-xs text-gray-400 mt-1">Komp. Startup Indonesia | Telp: 0812-XXXX-XXXX</p>
        </div>

        <div class="mb-6">
            <p class="text-xs text-gray-400 font-bold">INVOICE NO.</p>
            <p class="font-extrabold text-lg text-gray-800 mb-4">#{{ $order->kode_order }}</p>
            <table class="w-full text-sm text-gray-700">
                <tr><td class="py-1 font-bold">Tanggal</td><td class="text-right">{{ date('d M Y - H:i', strtotime($order->created_at)) }}</td></tr>
                <tr><td class="py-1 font-bold">Nama Pelanggan</td><td class="text-right">{{ $order->user->name }}</td></tr>
                <tr><td class="py-1 font-bold">Status</td><td class="text-right uppercase font-bold text-green-600">{{ $order->status }}</td></tr>
            </table>
        </div>

        <div class="border-t-2 border-b-2 border-dashed border-gray-300 py-4 mb-6">
            <div class="flex justify-between items-center mb-2">
                <span class="font-bold text-gray-800">{{ $order->jenis_layanan }}</span>
                <span class="font-bold text-gray-800">Rp {{ number_format($order->harga, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center text-xs text-gray-500">
                <span>Biaya Antar-Jemput</span>
                <span>Gratis (Rp 0)</span>
            </div>
        </div>

        <div class="flex justify-between items-center mb-8">
            <span class="font-extrabold text-xl text-gray-800">TOTAL</span>
            <span class="font-extrabold text-xl text-gray-800">Rp {{ number_format($order->harga, 0, ',', '.') }}</span>
        </div>

        <div class="text-center text-xs text-gray-500">
            <p class="font-bold mb-1">METODE PEMBAYARAN: {{ strtoupper($order->metode_pembayaran) }}</p>
            <p>Terima kasih telah mempercayakan perawatan sepatu Anda kepada ShoeCare.</p>
            <p class="mt-4 italic text-gray-400">--- Simpan struk ini sebagai bukti ---</p>
        </div>
    </div>
</body>
</html>