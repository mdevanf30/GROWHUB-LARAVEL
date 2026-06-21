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
                    <a href="{{ route('admin.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">Menu User</a>
                    <span class="px-4 py-2 rounded-lg bg-primary text-white shadow-md shadow-blue-800/20">Menu UMKM</span>
                    <a href="{{ route('admin.project.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">Menu Project</a>
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
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-xl flex items-center shadow-sm">
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="font-bold text-gray-700 text-lg">Daftar Semua Mitra UMKM</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200 text-xs uppercase tracking-wider">
                                <th class="p-4">ID</th>
                                <th class="p-4">Nama Bisnis</th>
                                <th class="p-4">Kategori</th>
                                <th class="p-4">Alamat</th>
                                <th class="p-4">Rating</th>
                                <th class="p-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($all_umkm as $umkm)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 text-gray-500 font-mono text-xs">{{ $umkm->umkm_id }}</td>
                                <td class="p-4 font-semibold text-gray-900">{{ $umkm->business_name }}</td>
                                <td class="p-4 text-gray-600">{{ $umkm->category }}</td>
                                <td class="p-4 text-gray-500 max-w-[150px] truncate">{{ $umkm->address }}</td>
                                <td class="p-4 text-amber-500 font-bold">★ {{ $umkm->rating }}</td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.umkm.index', ['umkm_id' => $umkm->umkm_id]) }}" class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 text-xs rounded-lg hover:bg-amber-100">Edit</a>
                                        <form action="{{ route('admin.umkm.destroy', $umkm->umkm_id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin?');" class="px-3 py-1 bg-red-50 text-red-600 border border-red-200 text-xs rounded-lg hover:bg-red-100">Delete</button>
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
                    <h2 class="font-bold text-primary text-lg mb-4">Edit Data UMKM (ID: {{ $umkm_select->umkm_id }})</h2>
                    <form action="{{ route('admin.umkm.update', $umkm_select->umkm_id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Nama Bisnis:</label>
                            <input type="text" name="business_name" value="{{ $umkm_select->business_name }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Kategori:</label>
                            <input type="text" name="category" value="{{ $umkm_select->category }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Deskripsi:</label>
                            <textarea name="description" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" required>{{ $umkm_select->description }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Alamat:</label>
                            <textarea name="address" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" required>{{ $umkm_select->address }}</textarea>
                        </div>
                        <div class="flex space-x-4">
                            <div class="flex-1">
                                <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Rating:</label>
                                <input type="number" name="rating" min="0" max="5" step="0.1" value="{{ $umkm_select->rating }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" required>
                            </div>
                        </div>
                        <div class="pt-4 flex space-x-2">
                            <button type="submit" class="flex-1 bg-primary text-white py-2 rounded-lg text-sm font-bold hover-bg-primary">Update</button>
                            <a href="{{ route('admin.umkm.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-semibold">Batal</a>
                        </div>
                    </form>
                </div>
                @else
                <div class="bg-gray-50 border border-dashed border-gray-300 rounded-2xl p-8 text-center text-gray-400">
                    <p class="text-sm">Pilih UMKM dari tabel untuk melakukan pengeditan data.</p>
                </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>