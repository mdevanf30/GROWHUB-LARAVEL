<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Projects</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-primary { background-color: #0d47a1; }
        .text-primary { color: #0d47a1; }
        .border-primary { border-color: #0d47a1; }
        .hover-bg-primary:hover { background-color: #0a3981; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans min-h-screen">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl font-black tracking-wider text-primary">GROWHUB</span>
                    <span class="text-xs uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded text-primary border border-blue-200 font-bold">Project Panel</span>
                </div>
                <div class="flex space-x-2 text-sm font-semibold">
                    <a href="{{ route('admin.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">Menu User</a>
                    <a href="{{ route('admin.umkm.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">Menu UMKM</a>
                    <span class="px-4 py-2 rounded-lg bg-primary text-white shadow-md shadow-blue-800/20">Menu Project</span>
                    <a href="{{ route('admin.reports.list') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Menu Laporan</a>
                    <a href="{{ route('admin.cancellations.list') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Menu Pembatalan</a>
                    <a href="{{ route('admin.grafik.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition font-semibold">Data Grafik</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">MANAGEMENT PROJECT</h1>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-xl flex items-center shadow-sm">
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-300 text-red-800 rounded-xl shadow-sm space-y-1">
                @foreach($errors->all() as $error)
                    <div class="text-xs font-medium">{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="font-bold text-gray-700 text-lg">Daftar Semua Project UMKM</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200 text-xs uppercase tracking-wider">
                                <th class="p-4">Project</th>
                                <th class="p-4">Category</th>
                                <th class="p-4">Budget</th>
                                <th class="p-4">Deadline</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($all_projects as $p)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4">
                                    <div class="font-semibold text-gray-900">{{ $p->project_title }}</div>
                                    <div class="text-xs text-gray-400">{{ $p->category }}</div>
                                </td>
                                <td class="p-4 font-mono font-medium text-emerald-600">Rp {{ number_format($p->project_budget, 0, ',', '.') }}</td>
                                <td class="p-4 text-gray-500 font-mono text-xs">{{ $p->deadline }}</td>
                                <td class="p-4">
                                    <div class="flex flex-col gap-1 items-start">
                                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase border 
                                            {{ $p->status == 'open' ? 'bg-blue-50 text-blue-700 border-blue-200' : 
                                               ($p->status == 'in_progress' ? 'bg-amber-50 text-amber-700 border-amber-200' : 
                                               ($p->status == 'completed' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200')) }}">
                                            {{ $p->status }}
                                        </span>
                                        @if($p->status == 'completed')
                                            <span class="px-1.5 py-0.5 rounded text-[8px] font-extrabold uppercase border
                                                {{ $p->payment_status == 'approved' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' :
                                                   ($p->payment_status == 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200 animate-pulse' :
                                                   ($p->payment_status == 'rejected' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-gray-50 text-gray-500 border-gray-200')) }}">
                                                @if($p->payment_status == 'approved') Paid
                                                @elseif($p->payment_status == 'pending') Pending Verification
                                                @elseif($p->payment_status == 'rejected') Rejected
                                                @else Unpaid
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.project.index', ['project_id' => $p->project_id]) }}" class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 text-xs rounded-lg hover:bg-amber-100">Edit</a>
                                        <form action="{{ route('admin.project.destroy', $p->project_id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus proyek?');" class="px-3 py-1 bg-red-50 text-red-600 border border-red-200 text-xs rounded-lg hover:bg-red-100">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="lg:col-span-1">
                @if(isset($project_select) && $project_select)
                <div class="bg-white border border-blue-200 rounded-2xl shadow-sm p-6 sticky top-24">
                    <h2 class="font-bold text-primary text-lg mb-4">Edit Proyek (ID: {{ $project_select->project_id }})</h2>
                    <form action="{{ route('admin.project.update', $project_select->project_id) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Judul:</label>
                            <input type="text" name="project_title" value="{{ $project_select->project_title }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Kategori:</label>
                            <input type="text" name="category" value="{{ $project_select->category }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Budget (Rp):</label>
                            <input type="number" name="project_budget" value="{{ $project_select->project_budget }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Deadline:</label>
                            <input type="date" name="deadline" value="{{ $project_select->deadline }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Status Proyek:</label>
                            <select name="status" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none">
                                <option value="open" {{ $project_select->status == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ $project_select->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $project_select->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $project_select->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        
                        @if($project_select->status === 'completed')
                        <div class="border-t border-gray-100 pt-3 mt-3 space-y-3">
                            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wide">Status Pembayaran</h4>
                            @if($project_select->payment_proof)
                                <div class="p-3 bg-blue-50 border border-blue-200 rounded-xl text-xs space-y-2">
                                    <label class="block font-bold text-[#0d47a1] uppercase">Bukti Transfer:</label>
                                    
                                    @php
                                        $ext = pathinfo($project_select->payment_proof, PATHINFO_EXTENSION);
                                        $isImg = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);
                                    @endphp
                                    
                                    @if($isImg)
                                        <div class="border border-gray-200 rounded bg-white p-1 max-h-36 overflow-hidden flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $project_select->payment_proof) }}" class="max-h-32 object-contain" alt="Bukti Transfer">
                                        </div>
                                    @endif
                                    
                                    <a href="{{ asset('storage/' . $project_select->payment_proof) }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 font-bold hover:underline">
                                        Buka Lampiran Bukti <i class="fa-solid fa-up-right-from-square text-[10px]"></i>
                                    </a>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Verifikasi Pembayaran:</label>
                                    <select name="payment_status" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none">
                                        <option value="pending" {{ $project_select->payment_status == 'pending' ? 'selected' : '' }}>Verifikasi (Pending)</option>
                                        <option value="approved" {{ $project_select->payment_status == 'approved' ? 'selected' : '' }}>Setujui (Approved)</option>
                                        <option value="rejected" {{ $project_select->payment_status == 'rejected' ? 'selected' : '' }}>Tolak (Rejected)</option>
                                        <option value="unpaid" {{ $project_select->payment_status == 'unpaid' ? 'selected' : '' }}>Belum Bayar (Unpaid)</option>
                                    </select>
                                </div>
                            @else
                                <div class="p-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-xs flex items-center gap-2">
                                    <i class="fa-solid fa-triangle-exclamation text-base"></i>
                                    <span class="font-medium">UMKM belum mengunggah bukti pembayaran.</span>
                                </div>
                            @endif
                        </div>
                        @endif
                        <div class="pt-4 flex space-x-2">
                            <button type="submit" class="flex-1 bg-primary text-white py-2 rounded-lg text-sm font-bold hover-bg-primary">Update</button>
                            <a href="{{ route('admin.project.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-semibold">Batal</a>
                        </div>
                    </form>
                </div>
                @else
                <div class="bg-gray-50 border border-dashed border-gray-300 rounded-2xl p-8 text-center text-gray-400">
                    <p class="text-sm">Pilih proyek untuk mengedit detailnya.</p>
                </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>