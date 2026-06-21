<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftarkan UMKM Anda - GrowHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f8fafc] flex h-screen overflow-hidden text-gray-800">

    <aside class="w-64 bg-[#0d47a1] text-white flex flex-col justify-between shrink-0">
        <div class="flex flex-col">
            <div class="h-20 flex items-center px-6 gap-3">
                <div class="bg-white p-1.5 rounded-lg flex items-center justify-center w-8 h-8">
                    <img src="{{ asset('IMAGES/LOGO_GROWHUB-removebg-preview.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <span class="text-xl font-bold tracking-wide">GrowHub</span>
            </div>
            <div class="px-6 mb-6">
                <div class="bg-[#0d47a1] rounded-xl p-3 flex items-center gap-3">
                    <div class="text-blue-200"><i class="fa-regular fa-user text-lg"></i></div>
                    <div>
                        <p class="text-[10px] text-blue-200 uppercase leading-none mb-1">Role</p>
                        <p class="font-semibold text-sm leading-none">Freelancer</p>
                    </div>
                </div>
            </div>
            <nav class="px-3 mt-4 space-y-1">
                <a href="{{ route('umkm.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                    <i class="fa-solid fa-border-all w-5"></i> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                     <i class="fa-solid fa-magnifying-glass w-5"></i> Jelajahi Proyek
                </a>
                <a href="{{ route('umkm.profile') }}" class="flex items-center gap-3 px-3 py-2.5 text-white bg-[#1e60c0] rounded-md text-sm font-medium">
                    <i class="fa-solid fa-user w-5"></i> Profil UMKM
                </a>
            </nav>
        </div>

         <div class="p-4 border-t border-blue-800/30">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-red-600 rounded-md transition-colors text-sm">
                <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Keluar
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-end px-8 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-[#0d47a1] text-white flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr($nama_user, 0, 1)) }}
                </div>
                <div class="text-sm">
                    <div class="font-semibold text-gray-900">{{ $nama_user }}</div>
                    <div class="text-[11px] text-gray-500 uppercase tracking-wider">Freelancer</div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 bg-[#f8fafc]">
            <div class="max-w-2xl mx-auto text-center mb-8">
                <div class="w-12 h-12 bg-blue-50 text-[#0d47a1] rounded-2xl flex items-center justify-center text-xl mx-auto mb-3 shadow-sm border border-blue-100">
                    <i class="fa-solid fa-store"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Daftarkan UMKM Anda</h1>
                <p class="text-gray-500 text-sm mt-1 leading-relaxed">Lengkapi data berikut untuk mendaftarkan bisnis Anda dan mulai membuat proyek untuk freelancer.</p>
            </div>

            <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                {{-- Display validation errors --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                        <h4 class="font-bold text-red-700 text-sm mb-2">Terjadi Kesalahan:</h4>
                        <ul class="text-sm text-red-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Display success message --}}
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4">
                        <p class="text-sm text-green-700 font-medium">✓ {{ session('success') }}</p>
                    </div>
                @endif

                <form action="{{ route('umkm.register.process') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Nama Bisnis / UMKM</label>
                        <input type="text" name="business_name" required placeholder="Contoh: Toko Roti Makmur" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#0d47a1] @error('business_name') border-red-500 @enderror" value="{{ old('business_name') }}">
                        @error('business_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Kategori UMKM</label>
                        <select name="category" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#0d47a1] bg-white text-gray-600 @error('category') border-red-500 @enderror" value="{{ old('category') }}">
                            <option value="" disabled selected>Pilih kategori UMKM</option>
                            <option value="kuliner">Kuliner (Makanan & Minuman)</option>
                            <option value="fashion">Fashion & Pakaian</option>
                            <option value="jasa">Jasa / Service</option>
                            <option value="kerajinan">Kerajinan / Kriya</option>
                            <option value="teknologi">Teknologi / Startup Lokal</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Alamat UMKM</label>
                        <input type="text" name="address" required placeholder="Contoh: Jl. Raya Darmo No. 45, Surabaya" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#0d47a1] @error('address') border-red-500 @enderror" value="{{ old('address') }}">
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Nomor Telepon UMKM</label>
                        <input type="tel" name="phone_number" required placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#0d47a1] @error('phone_number') border-red-500 @enderror" value="{{ old('phone_number') }}">
                        @error('phone_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Deskripsi Bisnis</label>
                        <textarea name="description" required rows="4" placeholder="Ceritakan tentang bisnis UMKM Anda..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#0d47a1] resize-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Bukti Pendukung UMKM <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <p class="text-[11px] text-gray-400 mb-2">Upload dokumen yang menunjukkan bahwa Anda memiliki bisnis UMKM (SIUP, foto produk, dll)</p>
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-blue-400 transition-colors bg-gray-50/50" id="dropZone">
                            <input type="file" name="supporting_file" id="fileInput" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                            <i class="fa-solid fa-cloud-arrow-up text-gray-400 text-xl mb-2 block"></i>
                            <p class="text-xs font-semibold text-gray-600" id="fileName">Klik untuk upload file</p>
                            <p class="text-[10px] text-gray-400 mt-1">PNG, JPG, PDF - Max 10MB</p>
                        </div>
                        @error('supporting_file')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex gap-3 items-start">
                        <i class="fa-solid fa-circle-shield text-[#0d47a1] mt-0.5"></i>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900 flex items-center gap-1.5">
                                Verifikasi UMKM
                            </h4>
                            <p class="text-[11px] text-gray-500 mt-0.5 leading-relaxed">Data yang Anda kirimkan akan diverifikasi oleh tim GrowHub. Proses verifikasi biasanya memakan waktu 1–2 hari kerja.</p>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-[#0d47a1]/80 hover:bg-[#0d47a1] text-white font-bold rounded-xl text-sm transition-colors shadow-sm mt-4">
                        Daftarkan UMKM
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Handle file upload
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const fileName = document.getElementById('fileName');

        // Click to select file
        dropZone.addEventListener('click', () => fileInput.click());

        // Handle file selection
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                fileName.innerText = file.name;
                dropZone.classList.add('border-green-400', 'bg-green-50');
                dropZone.classList.remove('border-gray-200', 'bg-gray-50/50');
            }
        });

        // Drag and drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-blue-400', 'bg-blue-50');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-blue-400', 'bg-blue-50');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-blue-400', 'bg-blue-50');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                const file = files[0];
                fileName.innerText = file.name;
                dropZone.classList.add('border-green-400', 'bg-green-50');
                dropZone.classList.remove('border-gray-200', 'bg-gray-50/50');
            }
        });
    </script>
</body>
</html>