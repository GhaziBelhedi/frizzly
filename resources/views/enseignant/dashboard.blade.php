@extends('layouts.enseignant')
@section('title', 'Bibliothèque')
@section('page-title', 'Bibliothèque PDF')
@section('page-sub', 'Ressources pédagogiques disponibles')

@section('content')
@php
use App\Models\LibraryPdf;
$pdfs = LibraryPdf::latest()->get();
@endphp

<div id="bibliotheque" class="e-card">

    {{-- Header --}}
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:22px;">
        <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#2ECC71,#4DA3FF);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="bi bi-book-fill" style="color:#fff;font-size:1rem;"></i>
        </div>
        <div>
            <h2 style="font-weight:700;color:#0f172a;font-size:1rem;line-height:1.2;">Bibliothèque PDF</h2>
            <p style="font-size:0.75rem;color:#94a3b8;margin:0;">{{ $pdfs->count() }} ressource{{ $pdfs->count() !== 1 ? 's' : '' }} disponible{{ $pdfs->count() !== 1 ? 's' : '' }}</p>
        </div>
    </div>

    {{-- Empty state --}}
    @if($pdfs->isEmpty())
    <div style="text-align:center;padding:48px 24px;">
        <div style="width:56px;height:56px;border-radius:16px;background:#E8FAF0;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
            <i class="bi bi-file-earmark-pdf" style="color:#2ECC71;font-size:1.5rem;"></i>
        </div>
        <p style="font-weight:600;color:#374151;margin-bottom:4px;">Bibliothèque vide</p>
        <p style="font-size:0.85rem;color:#94a3b8;">Aucune ressource PDF n'a encore été ajoutée.</p>
    </div>

    {{-- PDF list --}}
    @else
    <div style="display:flex;flex-direction:column;gap:10px;">
        @foreach($pdfs as $pdf)
        <div style="display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:14px;border:1px solid #f1f5f9;background:#fafafa;transition:box-shadow 0.15s,border-color 0.15s;"
             onmouseover="this.style.boxShadow='0 2px 12px rgba(0,0,0,0.06)';this.style.borderColor='#dcfce7'"
             onmouseout="this.style.boxShadow='none';this.style.borderColor='#f1f5f9'">

            {{-- Icon --}}
            <div style="width:44px;height:44px;border-radius:12px;background:#E8FAF0;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-file-earmark-pdf-fill" style="color:#2ECC71;font-size:1.25rem;"></i>
            </div>

            {{-- Info --}}
            <div style="flex:1;min-width:0;">
                <p style="font-weight:600;color:#0f172a;font-size:0.875rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:4px;">{{ $pdf->title }}</p>
                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                    <span style="font-size:0.7rem;font-weight:600;padding:2px 8px;border-radius:20px;background:#E8FAF0;color:#16a34a;">{{ $pdf->category }}</span>
                    @if($pdf->file_size)
                    <span style="font-size:0.7rem;color:#94a3b8;">{{ $pdf->file_size_formatted }}</span>
                    @endif
                    @if($pdf->description)
                    <span style="font-size:0.72rem;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:300px;">{{ $pdf->description }}</span>
                    @endif
                </div>
            </div>

            {{-- Download --}}
            <a href="{{ asset('storage/' . $pdf->file) }}" target="_blank" download
               style="display:flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;background:#E8FAF0;color:#16a34a;font-size:0.78rem;font-weight:700;text-decoration:none;flex-shrink:0;transition:background 0.15s,transform 0.15s;"
               onmouseover="this.style.background='#bbf7d0';this.style.transform='translateY(-1px)'"
               onmouseout="this.style.background='#E8FAF0';this.style.transform='translateY(0)'">
                <i class="bi bi-download"></i> Télécharger
            </a>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection
