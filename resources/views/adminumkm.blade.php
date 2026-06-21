<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - UMKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <span class="text-xs uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded text-primary border border-blue-200 font-bold">UMKM Panel</span>
                </div>
                <div class="flex space-x-2 text-sm font-semibold">
                    <a href="{{ route('admin.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Menu User</a>
                    <span class="px-4 py-2 rounded-lg bg-primary text-white shadow-md shadow-blue-800/20">Menu UMKM</span>
                    <a href="{{ route('admin.project.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Menu Project</a>
                    <a href="{{ route('admin.reports.list') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Menu Laporan</a>
                    <a href="{{ route('admin.cancellations.list') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Menu Pembatalan</a>
                    <a href="{{ route('admin.grafik.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Data Grafik</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">MANAGEMENT UMKM</h1>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-xl flex items-center space-x-2 shadow-sm">
                <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="font-bold text-gray-700 text-lg">Daftar Semua UMKM</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200 text-xs uppercase tracking-wider">
                                <th class="p-4">Nama UMKM</th>
                                <th class="p-4">Category</th>
                                <th class="p-4">Alamat</th>
                                <th class="p-4">Telepon</th>
                                <th class="p-4">Rating</th>
                                <th class="p-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($all_umkm as $data)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 font-semibold text-gray-900">{{ $data->business_name }}</td>
                                <td class="p-4 text-gray-600">{{ $data->category }}</td>
                                <td class="p-4 text-gray-500 max-w-xs truncate" title="{{ $data->address }}">{{ $data->address }}</td>
                                <td class="p-4 text-gray-600 whitespace-nowrap text-xs font-mono">{{ $data->phone_number }}</td>
                                <td class="p-4 font-bold text-amber-500 whitespace-nowrap">★ {{ $data->rating }}</td>
                                <td class="p-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.umkm.index', ['umkm_id' => $data->umkm_id]) }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.umkm.destroy', $data->umkm_id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?');" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold rounded-lg transition">
                                                Delete
                                            </button>
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
                @if(isset($umkm_select) && $umkm_select)
                <div class="bg-white border border-blue-200 rounded-2xl shadow-sm p-6 sticky top-24">
                    <h2 class="font-bold text-primary text-lg mb-4">Edit UMKM (ID: {{ $umkm_select->umkm_id }})</h2>
                    <form action="{{ route('admin.umkm.update', $umkm_select->umkm_id) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Nama UMKM:</label>
                            <input type="text" name="business_name" value="{{ $umkm_select->business_name }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Deskripsi:</label>
                            <textarea name="description" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" required>{{ $umkm_select->description }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Supporting File:</label>
                            <input type="text" name="supporting_file" value="{{ $umkm_select->supporting_file }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Category:</label>
                            <select name="category" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" required>
                                <option value="kuliner" {{ $umkm_select->category == 'kuliner' ? 'selected' : '' }}>Kuliner</option>
                                <option value="fashion" {{ $umkm_select->category == 'fashion' ? 'selected' : '' }}>Fashion</option>
                                <option value="teknologi" {{ $umkm_select->category == 'teknologi' ? 'selected' : '' }}>Teknologi</option>
                                <option value="jasa" {{ $umkm_select->category == 'jasa' ? 'selected' : '' }}>Jasa</option>
                                <option value="lainnya" {{ $umkm_select->category == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Alamat:</label>
                            <textarea name="address" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" required>{{ $umkm_select->address }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Nomor Telepon:</label>
                            <input type="text" name="phone_number" value="{{ $umkm_select->phone_number }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Rating:</label>
                            <input type="number" name="rating" min="0" max="5" step="0.1" value="{{ $umkm_select->rating }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" required>
                        </div>
                        <div class="pt-4 flex space-x-2">
                            <button type="submit" class="flex-1 bg-primary text-white py-2 rounded-lg text-sm font-bold hover-bg-primary">Update</button>
                            <a href="{{ route('admin.umkm.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-semibold">Batal</a>
                        </div>
                    </form>
                </div>
                @else
                <div class="bg-gray-50 border border-dashed border-gray-300 rounded-2xl p-8 text-center text-gray-400">
                    <p class="text-sm">Pilih UMKM untuk mengedit detailnya.</p>
                </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>