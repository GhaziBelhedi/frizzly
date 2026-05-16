<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LibraryPdfController extends Controller
{
    public function index(Request $request)
    {
        $query = LibraryPdf::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('title', 'like', "%$s%")->orWhere('description', 'like', "%$s%"));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $pdfs       = $query->latest()->paginate(12)->withQueryString();
        $categories = LibraryPdf::distinct()->pluck('category');

        return view('admin.library.index', compact('pdfs', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category'    => 'required|string|max:100',
            'file'        => 'required|file|mimes:pdf|max:20480',
        ]);

        $path = $request->file('file')->store('library', 'public');
        $size = $request->file('file')->getSize();

        LibraryPdf::create([
            'title'       => $request->title,
            'description' => $request->description,
            'category'    => $request->category,
            'file'        => $path,
            'file_size'   => $size,
        ]);

        return back()->with('success', 'PDF ajouté avec succès.');
    }

    public function destroy(LibraryPdf $libraryPdf)
    {
        Storage::disk('public')->delete($libraryPdf->file);
        $libraryPdf->delete();
        return back()->with('success', 'PDF supprimé.');
    }
}
