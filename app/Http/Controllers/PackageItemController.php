<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageItem;
use Illuminate\Http\Request;

class PackageItemController extends Controller
{
    //
    public function index()
    {
        $items = PackageItem::with('package')->get();
        return view('package_items.index', compact('items'));
    }

    public function create()
    {
        $packages = Package::all();
        return view('package_items.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'nama_item'  => 'required|string|max:255',
            'satuan'     => 'required|in:kg,pcs,meter',
            'tipe'       => 'nullable|in:tipis,tebal',
            'harga'      => 'required|numeric|min:0'
        ]);

        PackageItem::create($request->all());

        return redirect()->route('package-items.index')->with('success', 'Item berhasil ditambahkan');
    }

    public function edit(PackageItem $package_item)
    {
        $packages = Package::all();
        return view('package_items.edit', compact('package_item', 'packages'));
    }

    public function update(Request $request, PackageItem $package_item)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'nama_item'  => 'required|string|max:255',
            'satuan'     => 'required|in:kg,pcs,meter',
            'tipe'       => 'nullable|in:tipis,tebal',
            'harga'      => 'required|numeric|min:0'
        ]);

        $package_item->update($request->all());

        return redirect()->route('package-items.index')->with('success', 'Item berhasil diupdate');
    }

    public function destroy(PackageItem $package_item)
    {
        $package_item->delete();
        return redirect()->route('package-items.index')->with('success', 'Item berhasil dihapus');
    }
}