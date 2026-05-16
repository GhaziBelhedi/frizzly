@extends('layouts.admin')
@section('title', 'Bibliotheque PDF')
@section('page-title', 'Bibliotheque PDF')
@section('page-sub', 'Gestion des ressources documentaires')

@section('content')
@php
$dummy = collect([
    (object)['id'=>1,'title'=>'Guide pedagogique Frizzly Kit','description'=>'Manuel complet pour enseignants incluant toutes les activites et grilles d evaluation du kit.','category'=>'Pedagogie','file'=>'library/guide.pdf','file_size'=>2048000,'created_at'=>\Carbon\Carbon::now()->subDays(2)],
    (object)['id'=>2,'title'=>'Competences entrepreneuriales - Module 1','description'=>'Support de cours du premier module sur les competences cles de l entrepreneuriat chez les jeunes.','category'=>'Formation','file'=>'library/module1.pdf','file_size'=>1536000,'created_at'=>\Carbon\Carbon::now()->subDays(5)],
    (object)['id'=>3,'title'=>'Evaluation diagnostique CP-CE1','description'=>'Fiches d evaluation adaptees aux niveaux CP et CE1 pour un diagnostic initial des competences.','category'=>'Evaluation','file'=>'library/eval.pdf','file_size'=>876000,'created_at'=>\Carbon\Carbon::now()->subDays(8)],
    (object)['id'=>4,'title'=>'Carnet de progression enseignant','description'=>'Outil de suivi personnel des progres et objectifs pedagogiques annuels de l enseignant.','category'=>'Outils','file'=>'library/carnet.pdf','file_size'=>512000,'created_at'=>\Carbon\Carbon::now()->subDays(12)],
    (object)['id'=>5,'title'=>'Programme certifiant - Syllabus','description'=>'Description detaillee du programme certifiant avec objectifs de formation et modalites.','category'=>'Certification','file'=>'library/syllabus.pdf','file_size'=>1024000,'created_at'=>\Carbon\Carbon::now()->subDays(15)],
    (object)['id'=>6,'title'=>'Fiches activites - Cartes Socita','description'=>'Collection de 24 fiches activites pratiques pour utiliser les cartes Socita en classe.','category'=>'Pedagogie','file'=>'library/socita.pdf','file_size'=>3072000,'created_at'=>\Carbon\Carbon::now()->subDays(20)],
]);
$pdfs = $pdfs ?? $dummy;
$categories = $categories ?? collect(['Pedagogie','Formation','Evaluation','Outils','Certification']);

$catMap = [
    'Pedagogie'    => ['#1e40af','#dbeafe'],
    'Formation'    => ['#5b21b6','#ede9fe'],
    'Evaluation'   => ['#92400e','#fef3c7'],
    'Outils'       => ['#166534','#dcfce7'],
    'Certification'=> ['#991b1b','#fee2e2'],
];

function fmtSz($b) {
    if(!$b) return '--';
    $kb = $b/1024;
    return $kb<1024 ? round($kb,0).' Ko' : round($kb/1024,1).' Mo';
}
@endphp

<div x-data="{ upload: false, del: false, selPdf: null, openDel(p){ this.selPdf=p; this.del=true; } }">

{{-- TOP BAR --}}
<div style="display:flex;flex-wrap:wrap;align-items:center;gap:12px;margin-bottom:20px;">
    <form method="GET" style="display:flex;flex-wrap:wrap;gap:10px;flex:1;">
        <div style="flex:1;min-width:220px;position:relative;">
            <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:0.875rem;"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un document..." class="field field-red field-search">
        </div>
        <select name="category" class="field" style="width:auto;min-width:170px;">
            <option value="">Toutes les categories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category')==$cat?'selected':'' }}>{{ $cat }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-red"><i class="bi bi-funnel-fill"></i> Filtrer</button>
    </form>
    <button @click="upload=true" class="btn btn-green" style="flex-shrink:0;">
        <i class="bi bi-cloud-upload-fill"></i> Uploader un PDF
    </button>
</div>

{{-- STATS ROW --}}
<div style="display:flex;align-items:center;gap:20px;margin-bottom:20px;padding:14px 20px;background:#fff;border-radius:14px;border:1px solid #f1f5f9;">
    <p style="font-size:0.8125rem;color:#64748b;"><span style="font-weight:700;font-size:1.125rem;color:#0f172a;">{{ count($pdfs) }}</span> document{{ count($pdfs)>1?'s':'' }}</p>
    <div style="height:18px;width:1px;background:#f1f5f9;"></div>
    @foreach($categories->take(5) as $cat)
    @php $cc = $catMap[$cat] ?? ['#374151','#f1f5f9']; @endphp
    <span class="badge" style="color:{{ $cc[0] }};background:{{ $cc[1] }};">{{ $cat }}</span>
    @endforeach
</div>

{{-- GRID --}}
@if($pdfs->isEmpty())
<div style="background:#fff;border-radius:16px;border:1px solid #f1f5f9;padding:64px 24px;text-align:center;">
    <i class="bi bi-file-earmark-pdf" style="font-size:3rem;color:#e2e8f0;display:block;margin-bottom:12px;"></i>
    <p style="font-weight:600;color:#94a3b8;font-size:0.9375rem;">Aucun document dans la bibliotheque</p>
    <p style="font-size:0.875rem;color:#cbd5e1;margin-top:4px;margin-bottom:20px;">Commencez par uploader votre premier PDF</p>
    <button @click="upload=true" class="btn btn-red"><i class="bi bi-plus-lg"></i> Ajouter un PDF</button>
</div>
@else
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;">
    @foreach($pdfs as $pdf)
    @php $cc = $catMap[$pdf->category] ?? ['#374151','#f1f5f9']; $sz = fmtSz($pdf->file_size); @endphp
    <div style="background:#fff;border-radius:16px;border:1px solid #f1f5f9;overflow:hidden;transition:box-shadow 0.2s,transform 0.2s;" onmouseover="this.style.boxShadow='0 8px 24px rgba(0,0,0,0.08)';this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='';this.style.transform=''">

        {{-- Card header --}}
        <div style="height:120px;background:linear-gradient(135deg,{{ $cc[1] }},#fff);display:flex;flex-direction:column;align-items:center;justify-content:center;position:relative;border-bottom:1px solid #f1f5f9;">
            <i class="bi bi-file-earmark-pdf-fill" style="font-size:2.75rem;color:{{ $cc[0] }};margin-bottom:8px;"></i>
            <span class="badge" style="color:{{ $cc[0] }};background:{{ $cc[1] }};border:1px solid {{ $cc[0] }}30;">{{ $pdf->category }}</span>

            {{-- Actions on hover --}}
            <div style="position:absolute;top:10px;right:10px;display:flex;gap:6px;opacity:0;transition:opacity 0.2s;" class="pdf-actions">
                <a href="{{ asset('storage/' . $pdf->file) }}" download target="_blank" class="btn btn-icon" style="background:#fff;box-shadow:0 2px 8px rgba(0,0,0,0.1);color:#64748b;" title="Telecharger">
                    <i class="bi bi-download" style="font-size:0.8125rem;"></i>
                </a>
                <button @click="openDel({{ json_encode(['id'=>$pdf->id,'title'=>$pdf->title]) }})" class="btn btn-icon" style="background:#fff;box-shadow:0 2px 8px rgba(0,0,0,0.1);color:#EF4444;" title="Supprimer">
                    <i class="bi bi-trash-fill" style="font-size:0.8125rem;"></i>
                </button>
            </div>
        </div>

        {{-- Card body --}}
        <div style="padding:16px;">
            <h3 style="font-weight:700;color:#0f172a;font-size:0.9rem;margin-bottom:6px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $pdf->title }}</h3>
            <p style="font-size:0.8rem;color:#64748b;line-height:1.5;margin-bottom:12px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">{{ $pdf->description ?? 'Aucune description.' }}</p>
            <div style="display:flex;align-items:center;justify-content:space-between;font-size:0.75rem;color:#94a3b8;margin-bottom:12px;">
                <span><i class="bi bi-hdd" style="margin-right:4px;"></i>{{ $sz }}</span>
                <span>{{ $pdf->created_at->format('d/m/Y') }}</span>
            </div>
            <a href="{{ asset('storage/' . $pdf->file) }}" download target="_blank" class="btn btn-sm" style="width:100%;color:{{ $cc[0] }};background:{{ $cc[1] }};justify-content:center;text-decoration:none;">
                <i class="bi bi-download"></i> Telecharger
            </a>
        </div>
    </div>
    @endforeach
</div>

<style>
.pdf-card:hover .pdf-actions { opacity: 1 !important; }
div:hover > .pdf-actions { opacity: 1 !important; }
</style>
<script>
document.querySelectorAll('[style*="minmax(260px"]').length || (() => {})();
document.querySelectorAll('div[style*="height:120px"]').forEach(el => {
    el.parentElement.addEventListener('mouseenter', () => { const a = el.querySelector('.pdf-actions'); if(a) a.style.opacity='1'; });
    el.parentElement.addEventListener('mouseleave', () => { const a = el.querySelector('.pdf-actions'); if(a) a.style.opacity='0'; });
});
</script>
@endif

{{-- UPLOAD MODAL --}}
<div x-show="upload" x-cloak style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;padding:16px;" @keydown.escape.window="upload=false">
    <div class="modal-backdrop" @click="upload=false"></div>
    <div class="modal-box" style="width:100%;max-width:460px;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="modal-header">
            <h3 style="font-weight:700;color:#0f172a;font-size:1rem;">Uploader un PDF</h3>
            <button @click="upload=false" class="btn btn-icon btn-ghost"><i class="bi bi-x-lg" style="font-size:0.875rem;"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.library.store') }}" enctype="multipart/form-data" style="display:flex;flex-direction:column;overflow:hidden;">
            @csrf
            <div class="modal-body" style="display:flex;flex-direction:column;gap:14px;">
                <div><label class="field-label">Titre du document</label><input type="text" name="title" required class="field" placeholder="Titre du PDF"></div>
                <div>
                    <label class="field-label">Categorie</label>
                    <input type="text" name="category" required list="cat-list" class="field" placeholder="Pedagogie, Formation...">
                    <datalist id="cat-list">@foreach($categories as $cat)<option value="{{ $cat }}">@endforeach</datalist>
                </div>
                <div><label class="field-label">Description</label><textarea name="description" rows="3" class="field" style="resize:none;" placeholder="Description du document..."></textarea></div>
                <div>
                    <label class="field-label">Fichier PDF <span style="color:#94a3b8;font-weight:400;">(max 20 Mo)</span></label>
                    <label style="display:flex;flex-direction:column;align-items:center;justify-content:center;width:100%;height:100px;border:2px dashed #e5e7eb;border-radius:12px;cursor:pointer;transition:border-color 0.15s,background 0.15s;" onmouseover="this.style.borderColor='#E94E3C';this.style.background='rgba(233,78,60,0.02)'" onmouseout="this.style.borderColor='#e5e7eb';this.style.background=''">
                        <i class="bi bi-cloud-upload-fill" style="font-size:1.75rem;color:#cbd5e1;margin-bottom:6px;"></i>
                        <span id="file-name" style="font-size:0.8125rem;color:#94a3b8;">Cliquer pour selectionner un fichier PDF</span>
                        <input type="file" name="file" accept=".pdf" required style="display:none;" onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'Selectionner un PDF'">
                    </label>
                </div>
            </div>
            <div class="modal-footer" style="display:flex;gap:10px;">
                <button type="button" @click="upload=false" class="btn btn-ghost" style="flex:1;">Annuler</button>
                <button type="submit" class="btn btn-red" style="flex:1;"><i class="bi bi-cloud-upload-fill"></i> Uploader</button>
            </div>
        </form>
    </div>
</div>

{{-- DELETE MODAL --}}
<div x-show="del" x-cloak style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;padding:16px;" @keydown.escape.window="del=false">
    <div class="modal-backdrop" @click="del=false"></div>
    <div class="modal-box" style="width:100%;max-width:360px;text-align:center;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="modal-body" style="display:flex;flex-direction:column;align-items:center;gap:12px;padding:28px 24px;">
            <div style="width:60px;height:60px;border-radius:16px;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-file-earmark-x-fill" style="font-size:1.5rem;color:#EF4444;"></i>
            </div>
            <h3 style="font-weight:700;color:#0f172a;font-size:1rem;">Supprimer le PDF</h3>
            <p style="font-size:0.875rem;color:#64748b;line-height:1.5;">Supprimer <strong x-text="selPdf ? selPdf.title : ''"></strong> ? Le fichier sera definitivement efface.</p>
        </div>
        <template x-if="selPdf">
            <form method="POST" :action="'/admin/library/' + selPdf.id">
                @csrf @method('DELETE')
                <div class="modal-footer" style="display:flex;gap:10px;">
                    <button type="button" @click="del=false" class="btn btn-ghost" style="flex:1;">Annuler</button>
                    <button type="submit" style="flex:1;padding:9px 18px;border-radius:10px;font-size:0.8125rem;font-weight:600;cursor:pointer;border:none;background:#EF4444;color:#fff;">Supprimer</button>
                </div>
            </form>
        </template>
    </div>
</div>

</div>
@endsection
