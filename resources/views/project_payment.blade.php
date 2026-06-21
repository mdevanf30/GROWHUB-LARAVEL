<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowHub - Status Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] flex h-screen overflow-hidden text-gray-800">

    <!-- Sidebar Navigation -->
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
                    <div class="text-blue-200">
                        @if($activeRole === 'UMKM')
                            <i class="fa-solid fa-store text-lg"></i>
                        @else
                            <i class="fa-regular fa-user text-lg"></i>
                        @endif
                    </div>
                    <div>
                        <p class="text-[10px] text-blue-200 uppercase leading-none mb-1">ROLE</p>
                        <p class="font-semibold text-sm leading-none">
                            @if($activeRole === 'UMKM' && $cek_umkm)
                                {{ $cek_umkm->business_name }}
                            @else
                                Freelancer
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <nav class="px-3 mt-4 space-y-1">
                @if($activeRole === 'UMKM')
                    <a href="{{ route('umkm.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-border-all w-5"></i> Dashboard
                    </a>
                    <a href="{{ route('jelajahi_proyek') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                         <i class="fa-solid fa-magnifying-glass w-5"></i> Jelajahi Proyek
                    </a>
                    <a href="{{ route('project.create') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-circle-plus w-5"></i> Buat Proyek
                    </a>
                    <a href="{{ route('profil') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-user w-5"></i> Profil
                    </a>
                @else
                    <a href="{{ route('dashboard_freelance') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-border-all w-5"></i> Dashboard
                    </a>
                    <a href="{{ route('jelajahi_proyek') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-magnifying-glass w-5"></i> Jelajahi Proyek
                    </a>
                    <a href="{{ route('profil') }}" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#1e60c0] rounded-md transition-colors text-sm">
                        <i class="fa-solid fa-user w-5"></i> Profil
                    </a>
                @endif
            </nav>
        </div>
        <div class="p-4 border-t border-blue-800/30">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 px-3 py-2.5 text-white/80 hover:text-white hover:bg-[#c23939] rounded-md transition-colors text-sm">
                <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 shrink-0">
            <div class="text-sm flex items-center gap-2">
                <span class="text-gray-400">Proyek</span>
                <span class="text-gray-300">/</span>
                <span class="text-gray-400">Detail</span>
                <span class="text-gray-300">/</span>
                <span class="text-gray-800 font-semibold">Status Pembayaran</span>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-500 font-medium">Halo, {{ $nama_user }}</span>
                <div class="w-8 h-8 rounded-full bg-[#0d47a1] text-white flex items-center justify-center font-bold text-xs">
                    {{ substr($nama_user, 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Scrollable content area -->
        <div class="flex-1 overflow-y-auto p-8 flex items-center justify-center">
            
            <div class="{{ $progress->payment_status === 'approved' ? 'max-w-4xl' : 'max-w-xl' }} w-full space-y-6">
                
                <!-- Display Error or Success Alerts -->
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-xs flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-circle-check text-base"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-circle-exclamation text-base"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs space-y-1 shadow-sm">
                        @foreach($errors->all() as $error)
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-circle-exclamation text-base"></i>
                                <span>{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($progress->payment_status === 'approved')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
                        
                        <!-- Left Column: Payment Successful Card -->
                        <div class="bg-white rounded-2xl border border-green-100 bg-green-50/10 p-8 shadow-sm flex flex-col items-center text-center space-y-6 justify-between">
                            <div class="w-full space-y-6">
                                <div class="flex items-center justify-between w-full border-b border-gray-100 pb-4">
                                    <div class="text-left">
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Proyek</p>
                                        <h4 class="font-bold text-gray-800 text-sm leading-tight">{{ $proyek->project_title }}</h4>
                                    </div>
                                    <span class="text-[9px] px-3 py-1 rounded-full font-bold uppercase tracking-wider shrink-0 bg-green-100 text-green-700">
                                        Pembayaran Sukses
                                    </span>
                                </div>

                                <div class="flex flex-col items-center py-4 space-y-3">
                                    <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center border border-green-100 text-green-500 shadow-inner">
                                        <i class="fa-solid fa-check text-4xl"></i>
                                    </div>
                                    <div class="space-y-1">
                                        <h3 class="font-bold text-gray-900 text-lg">Pembayaran Sukses / Proyek Selesai</h3>
                                        <p class="text-xs text-gray-500 max-w-sm leading-relaxed">
                                            Admin telah memverifikasi bukti transfer. Pembayaran dinyatakan valid dan proyek resmi ditutup secara keseluruhan.
                                        </p>
                                    </div>
                                </div>

                                <!-- Payment Proof Preview (Images / PDF link) -->
                                @php
                                    $extension = pathinfo($progress->payment_proof, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                                @endphp
                                @if($isImage)
                                    <div class="w-full bg-gray-50 rounded-xl p-3 border border-gray-100 flex flex-col items-center">
                                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mb-2 self-start">Pratinjau Bukti Pembayaran</p>
                                        <div class="max-h-48 overflow-hidden rounded-lg border border-gray-200 bg-white p-1">
                                            <img src="{{ asset('storage/' . $progress->payment_proof) }}" class="max-w-full h-auto object-contain max-h-40 rounded" alt="Bukti Transfer">
                                        </div>
                                    </div>
                                @else
                                    <div class="w-full bg-gray-50 rounded-xl p-3 border border-gray-100 flex items-center justify-between text-left">
                                        <span class="text-xs text-gray-600 font-medium"><i class="fa-regular fa-file-pdf text-red-500 text-base mr-1.5"></i> Bukti Transfer (PDF)</span>
                                        <a href="{{ asset('storage/' . $progress->payment_proof) }}" target="_blank" class="text-xs text-blue-600 font-bold hover:underline">Buka File</a>
                                    </div>
                                @endif
                            </div>

                            <!-- Unduh Bukti Transfer Button (Active) -->
                            <div class="w-full pt-2">
                                <a href="{{ asset('storage/' . $progress->payment_proof) }}" download class="w-full py-3.5 bg-[#0b51b7] hover:bg-[#0d47a1] text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                                    Unduh Bukti Transfer <i class="fa-solid fa-download text-sm"></i>
                                </a>
                            </div>

                        </div>

                        <!-- Right Column: Rating Form Card -->
                        <div class="bg-white rounded-2xl border border-gray-150 p-8 shadow-sm flex flex-col justify-between h-full">
                            <div>
                                <div class="border-b border-gray-100 pb-4 mb-6 text-left">
                                    <h3 class="font-extrabold text-gray-900 text-lg">
                                        @if($activeRole === 'UMKM')
                                            Berikan Rating Freelancer
                                        @else
                                            Berikan Rating Mitra UMKM
                                        @endif
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                        @if($activeRole === 'UMKM')
                                            Bagaimana kualitas hasil pekerjaan freelancer dalam proyek ini?
                                        @else
                                            Bagaimana pengalaman Anda bekerja sama dengan mitra UMKM ini?
                                        @endif
                                    </p>
                                </div>

                                @php
                                    $hasRated = $activeRole === 'UMKM' 
                                        ? ($progress->rating_for_freelancer !== null)
                                        : ($progress->rating_for_umkm !== null);
                                    $currentRating = $activeRole === 'UMKM'
                                        ? $progress->rating_for_freelancer
                                        : $progress->rating_for_umkm;
                                @endphp

                                @if(!$hasRated)
                                    <form action="{{ route('project.payment.rate', $proyek->project_id) }}" method="POST" class="space-y-6">
                                        @csrf
                                        <div class="flex flex-col items-center py-6 bg-gray-50/50 rounded-2xl border border-dashed border-gray-200">
                                            <div class="flex items-center gap-2 mb-3">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <button type="button" onclick="setRatingValue({{ $i }})" class="star-btn text-gray-300 hover:text-amber-400 text-4xl transition duration-150 cursor-pointer" data-value="{{ $i }}">
                                                        <i class="fa-solid fa-star"></i>
                                                    </button>
                                                @endfor
                                            </div>
                                            <input type="hidden" name="rating" id="rating_input_val" required value="">
                                            <span id="rating_label" class="text-xs text-gray-400 font-bold uppercase tracking-wider">Pilih Bintang</span>
                                        </div>

                                        <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-750 text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                                            Kirim Rating <i class="fa-solid fa-paper-plane text-xs"></i>
                                        </button>
                                    </form>

                                    <script>
                                        function setRatingValue(val) {
                                            document.getElementById('rating_input_val').value = val;
                                            const stars = document.querySelectorAll('.star-btn');
                                            stars.forEach((star, index) => {
                                                if (index < val) {
                                                    star.classList.remove('text-gray-300');
                                                    star.classList.add('text-amber-400');
                                                } else {
                                                    star.classList.remove('text-amber-400');
                                                    star.classList.add('text-gray-300');
                                                }
                                            });
                                            
                                            const labels = {
                                                1: "Sangat Buruk (1/5)",
                                                2: "Buruk (2/5)",
                                                3: "Cukup Baik (3/5)",
                                                4: "Sangat Baik (4/5)",
                                                5: "Luar Biasa (5/5)"
                                            };
                                            document.getElementById('rating_label').innerText = labels[val];
                                        }
                                    </script>
                                @else
                                    <!-- Already Rated state -->
                                    <div class="flex flex-col items-center py-8 space-y-4">
                                        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center text-green-500 border border-green-100 shadow-inner">
                                            <i class="fa-solid fa-circle-check text-4xl"></i>
                                        </div>
                                        <div class="text-center space-y-2">
                                            <h4 class="font-bold text-gray-900">Terima Kasih Atas Penilaian Anda!</h4>
                                            <p class="text-xs text-gray-400 max-w-xs leading-relaxed">Anda telah berhasil memberikan penilaian untuk proyek ini.</p>
                                        </div>
                                        
                                        <div class="flex items-center gap-1.5 bg-amber-50 border border-amber-100 px-4 py-2 rounded-xl text-amber-600 font-extrabold text-sm mt-2">
                                            <span>Rating Anda:</span>
                                            <div class="flex items-center gap-0.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa-solid fa-star {{ $i <= $currentRating ? 'text-amber-400' : 'text-gray-200' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="text-[10px] text-gray-400 text-center border-t border-gray-100 pt-4 mt-6">
                                Penilaian ini bersifat rahasia dan akan memperbarui rating profil secara langsung.
                            </div>
                        </div>

                    </div>
                @else
                    <!-- Single Column: Non-approved states (Unpaid, Pending, Rejected) -->
                    <div class="bg-white rounded-2xl border 
                        @if($progress->payment_status === 'pending') border-amber-100 bg-amber-50/10
                        @elseif($progress->payment_status === 'rejected') border-red-100 bg-red-50/10
                        @else border-gray-100 bg-gray-50/10
                        @endif p-8 shadow-sm flex flex-col items-center text-center space-y-6">
                        
                        <div class="flex items-center justify-between w-full border-b border-gray-100 pb-4">
                            <div class="text-left">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Proyek</p>
                                <h4 class="font-bold text-gray-800 text-sm leading-tight">{{ $proyek->project_title }}</h4>
                            </div>
                            <span class="text-[9px] px-3 py-1 rounded-full font-bold uppercase tracking-wider shrink-0
                                @if($progress->payment_status === 'pending') bg-amber-100 text-amber-700
                                @elseif($progress->payment_status === 'rejected') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-600
                                @endif">
                                @if($progress->payment_status === 'pending') Verifikasi Pembayaran
                                @elseif($progress->payment_status === 'rejected') Pembayaran Ditolak
                                @else Menunggu Pembayaran
                                @endif
                            </span>
                        </div>

                        @if($progress->payment_status === 'unpaid' || $progress->payment_status === 'rejected')
                            <!-- Case A: Waiting for Payment / Rejected -->
                            @if($progress->payment_status === 'rejected')
                                <div class="w-full bg-red-50 border border-red-150 text-red-700 px-4 py-3 rounded-xl text-xs flex items-center gap-2 shadow-sm">
                                    <i class="fa-solid fa-circle-xmark text-base shrink-0"></i>
                                    <span class="text-left leading-tight font-medium">Bukti pembayaran ditolak oleh Admin. Silakan periksa kembali transaksi Anda dan unggah ulang bukti transfer yang valid.</span>
                                </div>
                            @endif

                            <div class="flex flex-col items-center py-4 space-y-3">
                                <div class="w-20 h-20 {{ $progress->payment_status === 'rejected' ? 'bg-red-50 text-red-500 border-red-100' : 'bg-amber-50 text-amber-500 border-amber-100' }} rounded-full flex items-center justify-center border shadow-inner">
                                    @if($progress->payment_status === 'rejected')
                                        <i class="fa-solid fa-circle-exclamation text-4xl animate-bounce"></i>
                                    @else
                                        <i class="fa-regular fa-clock text-4xl animate-pulse"></i>
                                    @endif
                                </div>
                                <div class="space-y-1">
                                    <h3 class="font-bold text-gray-900 text-lg">
                                        {{ $progress->payment_status === 'rejected' ? 'Pembayaran Ditolak' : 'Menunggu Pembayaran' }}
                                    </h3>
                                    <p class="text-xs text-gray-500 max-w-sm leading-relaxed">
                                        @if($activeRole === 'UMKM')
                                            Silakan transfer pembayaran sesuai kesepakatan dan unggah bukti transfer di bawah ini agar diverifikasi oleh Admin.
                                        @else
                                            Silakan tunggu mitra UMKM mengirimkan pembayaran dan melampirkan bukti transfer.
                                        @endif
                                    </p>
                                </div>
                            </div>

                            @if($activeRole === 'UMKM')
                                <!-- Form upload bukti pembayaran langsung di card untuk UMKM -->
                                <form action="{{ route('project.payment.submit', $proyek->project_id) }}" method="POST" enctype="multipart/form-data" class="w-full space-y-4 pt-2">
                                    @csrf
                                    <div class="space-y-2 text-left">
                                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wide block">Unggah Bukti Transfer / Pembayaran</label>
                                        <input type="file" name="payment_proof" required accept="image/jpeg,image/png,image/jpg,application/pdf"
                                            class="w-full text-xs text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#0d47a1] hover:file:bg-blue-100 border border-gray-200 rounded-xl p-2 bg-white">
                                        <p class="text-[10px] text-gray-400 leading-tight">Mendukung format gambar (JPG, PNG, JPEG) atau PDF. Ukuran file maksimal 5MB.</p>
                                    </div>
                                    <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-750 text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                                        <i class="fa-solid fa-cloud-arrow-up text-sm"></i> Kirim Bukti Pembayaran
                                    </button>
                                </form>
                            @else
                                <!-- Unduh Bukti Transfer Button (Disabled for Freelancer) -->
                                <div class="w-full pt-2">
                                    <button disabled class="w-full py-3.5 bg-gray-100 text-gray-400 text-xs font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                        Unduh Bukti Transfer <i class="fa-solid fa-download text-sm"></i>
                                    </button>
                                </div>
                            @endif

                        @elseif($progress->payment_status === 'pending')
                            <!-- Case B: Pending verification -->
                            <div class="flex flex-col items-center py-4 space-y-3">
                                <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center border border-amber-105 text-amber-500 shadow-inner">
                                    <i class="fa-solid fa-hourglass-half text-3xl animate-pulse animate-spin" style="animation-duration: 3s;"></i>
                                </div>
                                <div class="space-y-1">
                                    <h3 class="font-bold text-gray-900 text-lg">Verifikasi Pembayaran</h3>
                                    <p class="text-xs text-gray-500 max-w-sm leading-relaxed">
                                        Bukti pembayaran telah berhasil diunggah. Saat ini Admin sedang memverifikasi keaslian transaksi Anda. Mohon tunggu beberapa saat.
                                    </p>
                                </div>
                            </div>

                            <!-- Payment Proof Preview (Images / PDF link) -->
                            @php
                                $extension = pathinfo($progress->payment_proof, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                            @endphp
                            @if($isImage)
                                <div class="w-full bg-gray-50 rounded-xl p-3 border border-gray-100 flex flex-col items-center">
                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mb-2 self-start">Bukti yang Diunggah</p>
                                    <div class="max-h-48 overflow-hidden rounded-lg border border-gray-200 bg-white p-1">
                                        <img src="{{ asset('storage/' . $progress->payment_proof) }}" class="max-w-full h-auto object-contain max-h-40 rounded" alt="Bukti Transfer">
                                    </div>
                                </div>
                            @else
                                <div class="w-full bg-gray-50 rounded-xl p-3 border border-gray-100 flex items-center justify-between text-left">
                                    <span class="text-xs text-gray-600 font-medium"><i class="fa-regular fa-file-pdf text-red-500 text-base mr-1.5"></i> Bukti Transfer (PDF)</span>
                                    <a href="{{ asset('storage/' . $progress->payment_proof) }}" target="_blank" class="text-xs text-blue-600 font-bold hover:underline">Buka File</a>
                                </div>
                            @endif

                            <!-- Unduh Bukti Transfer Button (Disabled) -->
                            <div class="w-full pt-2">
                                <button disabled class="w-full py-3.5 bg-gray-100 text-gray-400 text-xs font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                    Menunggu Verifikasi Admin <i class="fa-solid fa-spinner fa-spin text-sm"></i>
                                </button>
                            </div>
                        @endif

                    </div>
                @endif

                <!-- Footer Back to Dashboard Action -->
                <div class="flex justify-center">
                    <a href="{{ $activeRole === 'UMKM' ? route('umkm.dashboard') : route('dashboard_freelance') }}" 
                        class="inline-flex items-center gap-2 px-6 py-2.5 text-xs text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-bold transition shadow-sm">
                        <i class="fa-solid fa-house"></i> Kembali ke Dashboard
                    </a>
                </div>

            </div>

        </div>
    </main>

</body>
</html>
