<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GradingPackage;
use Illuminate\Http\Request;

class GradingPackageController extends Controller
{
    public function index()
    {
        $packages = GradingPackage::latest()->get();
        return view('admin.grading-packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.grading-packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_name' => 'required|string|unique:grading_packages,package_name',
            'price' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
        ]);

        GradingPackage::create($validated);
        return redirect()->route('admin.grading-packages.index')->with('success', 'Paket grading berhasil ditambahkan!');
    }

    public function show(GradingPackage $gradingPackage) { abort(404); }

    public function edit(GradingPackage $gradingPackage)
    {
        return view('admin.grading-packages.edit', compact('gradingPackage'));
    }

    public function update(Request $request, GradingPackage $gradingPackage)
    {
        $validated = $request->validate([
            'package_name' => 'required|string|unique:grading_packages,package_name,' . $gradingPackage->id,
            'price' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
        ]);

        $gradingPackage->update($validated);
        return redirect()->route('admin.grading-packages.index')->with('success', 'Paket grading berhasil diperbarui!');
    }

    public function destroy(GradingPackage $gradingPackage)
    {
        $gradingPackage->delete();
        return redirect()->route('admin.grading-packages.index')->with('success', 'Paket grading berhasil dihapus!');
    }
}