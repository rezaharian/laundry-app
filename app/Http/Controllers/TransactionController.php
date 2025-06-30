<?php

namespace App\Http\Controllers;

use App\Models\PackageItem;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    //
    public function index()
    {
        $transactions = Transaction::with('user')->orderByDesc('created_at')->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $items = PackageItem::with('package')->get();
        $services = Service::all();
        return view('transactions.create', compact('items', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:package_items,id',
            'items.*.qty' => 'required|numeric|min:1',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',
        ]);

        // Simpan Transaksi
        $trx = Transaction::create([
            'user_id' => Auth::id(),
            'pelanggan_nama' => $request->customer_name,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_keluar' => $request->tanggal_keluar ?: null,

        ]);

        // Simpan Detail Item
        foreach ($request->items as $item) {
            $trx->items()->create([
                'package_item_id' => $item['item_id'],
                'jumlah' => $item['qty'],
                'subtotal' => $item['qty'],
            ]);
        }

        // Simpan layanan tambahan (banyak ke banyak)
        if ($request->services) {
            $trx->services()->sync($request->services);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan.');
    }
    public function edit(Transaction $transaction)
    {
        $transaction->load(['items', 'services']);
        $users = User::all();
        $packageItems = PackageItem::with('package')->get();
        $services = Service::all();

        return view('transactions.edit', compact('transaction', 'users', 'packageItems', 'services'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'pelanggan_nama' => 'required|string|max:255',
            'tanggal_keluar' => 'required|date',
            'items.*.item_id' => 'required|exists:package_items,id',
            'items.*.qty' => 'required|numeric|min:1',
        ]);

        // Update header transaksi
        $transaction->update([
            'pelanggan_nama' => $request->pelanggan_nama,
            'tanggal_keluar' => $request->tanggal_keluar,
        ]);

        // Hapus item sebelumnya
        $transaction->items()->delete();

        $totalBiaya = 0;

        // Masukkan item baru
        foreach ($request->items as $item) {
            $packageItem = \App\Models\PackageItem::findOrFail($item['item_id']);
            $harga = $packageItem->harga;
            $subtotal = $harga * $item['qty'];
            $totalBiaya += $subtotal;

            $transaction->items()->create([
                'package_item_id' => $item['item_id'],
                'jumlah' => $item['qty'],
                'subtotal' => $subtotal,
            ]);
        }

        // Sinkronisasi layanan tambahan
        $serviceIds = $request->service_ids ?? [];
        $transaction->services()->sync($serviceIds);

        // Tambahkan biaya layanan ke total
        if (count($serviceIds)) {
            $serviceTotal = \App\Models\Service::whereIn('id', $serviceIds)->sum('harga');
            $totalBiaya += $serviceTotal;
        }

        // Simpan total biaya ke transaksi
        $transaction->update([
            'total_biaya' => $totalBiaya
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }




    public function show(Transaction $transaction)
    {
        $transaction->load(['items.packageItem.package', 'services']);
        return view('transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function cetak($id)
    {
        $transaction = Transaction::with(['user', 'items.packageItem.package', 'services'])->findOrFail($id);

        return view('transactions.cetak', compact('transaction'));
    }
}
