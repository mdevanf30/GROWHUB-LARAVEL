<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowHub - Buat Proyek Baru</title>
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
                <div class="bg-[#0b51b7] rounded-xl p-3 flex items-center gap-3">
                    <div class="text-blue-200"><i class="fa-solid fa-store text-lg"></i></div>
                    <div>
                        <p class="text-[10px] text-blue-200 uppercase leading-none mb-1">UMKM</p>
                        <p class="font-semibold text-sm leading-none">{{ $cek_umkm->business_name ?? 'Mitra UMKM' }}</p>
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
                <a href="{{ route('project.create') }}" class="flex items-center gap-3 px-3 py-2.5 text-white bg-[#1e60c0] rounded-md text-sm font-medium">
                    <i class="fa-solid fa-circle-plus w-5"></i> Buat Proyek
                </a>
                <a href="{{ route('freelancer.profile') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                    <i class="fa-solid fa-user w-5"></i> Profil
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-blue-800/30">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-project').submit();" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#c23939] rounded-md transition-colors text-sm">
                <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Keluar
            </a>
            <form id="logout-form-project" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 shrink-0">
            <div class="text-sm flex items-center gap-2">
                <span class="text-gray-400">Dashboard</span>
                <span class="text-gray-300">/</span>
                <span class="text-gray-800 font-medium">Buat Proyek</span>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-12 bg-white">
            <div class="max-w-2xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Buat Proyek Baru</h1>
                    <p class="text-xs text-gray-400 mt-1">Publikasikan kebutuhan digital Anda dan temukan freelancer terbaik.</p>
                </div>

                <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-700 tracking-wide">Judul Proyek</label>
                        <input type="text" name="project_title" placeholder="Contoh: Desain Logo untuk Toko Online" required
                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs outline-none focus:border-[#0d47a1] transition-colors">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-700 tracking-wide">Kategori</label>
                        <select name="category" required class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs outline-none appearance-none">
                            <option value="" disabled selected>Pilih kategori</option>
                            <option value="Desain logo">Desain Logo</option>
                            <option value="Konten media sosial">Konten Media Sosial</option>
                            <option value="Desain kemasan">Desain Kemasan</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-700 tracking-wide">Deskripsi</label>
                        <textarea name="description" rows="4" placeholder="Jelaskan kebutuhan proyek Anda secara detail..." required
                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs outline-none focus:border-[#0d47a1] resize-none"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-700 tracking-wide">Budget (Rp)</label>
                            <input type="number" name="project_budget" placeholder="500000" required
                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-700 tracking-wide">Deadline</label>
                            <input type="date" name="deadline" required
                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs outline-none text-gray-500">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-700 tracking-wide">Lokasi</label>
                        <input type="text" name="project_address" placeholder="Contoh: Surabaya" required
                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs outline-none">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-700 tracking-wide">Persyaratan (satu per baris)</label>
                        <textarea name="requirements" rows="3" placeholder="Menguasai Adobe Illustrator&#10;Pengalaman minimal 1 tahun&#10;Bisa revisi 3 kali" required
                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs outline-none resize-none"></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-700 tracking-wide">Upload File Referensi</label>
                        <div class="border border-dashed border-gray-300 rounded-xl p-6 flex flex-col items-center justify-center text-gray-400 bg-gray-50">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl mb-1.5 text-gray-400"></i>
                            <p class="text-[11px] font-medium text-gray-600">Klik tombol di bawah untuk memilih file</p>
                            <p class="text-[9px] text-gray-400 mt-0.5">PNG, JPG, PDF - Max 10MB (Opsional)</p>
                            <input type="file" name="reference_file" class="mt-3 text-[10px] text-gray-500 file:mr-3 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-blue-50 file:text-[#0d47a1] hover:file:bg-blue-100">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-[#0d47a1] text-white text-xs font-bold rounded-xl hover:bg-blue-800 transition-colors shadow-sm tracking-wide">
                        Publikasikan Proyek
                    </button>
                </form>
            </div>
        </div>
    </main>

</body>
</html>