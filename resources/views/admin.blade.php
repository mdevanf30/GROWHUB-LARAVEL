<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
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
                    <span class="text-xs uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded text-primary border border-blue-200 font-bold">Admin Panel</span>
                </div>
                <div class="flex space-x-2 text-sm font-semibold">
                    <span class="px-4 py-2 rounded-lg bg-primary text-white shadow-md shadow-blue-800/20">Menu User</span>
                    <a href="{{ route('admin.umkm.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Menu UMKM</a>
                    <a href="{{ route('admin.project.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">Menu Project</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">ADMIN PANEL</h1>
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
                    <h2 class="font-bold text-gray-700 text-lg">All Users</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200 text-xs uppercase tracking-wider">
                                <th class="p-4">Nama Lengkap</th>
                                <th class="p-4">Tgl Lahir</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">Alamat</th>
                                <th class="p-4">Telepon</th>
                                <th class="p-4">Password</th>
                                <th class="p-4">Rating</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($users as $u)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 font-semibold text-gray-900 whitespace-nowrap">{{ $u->full_name }}</td>
                                <td class="p-4 text-gray-600 whitespace-nowrap font-mono text-xs">{{ $u->birth_date }}</td>
                                <td class="p-4 text-gray-600 font-mono text-xs">{{ $u->email_address }}</td>
                                <td class="p-4 text-gray-500 max-w-xs truncate" title="{{ $u->home_address }}">{{ $u->home_address }}</td>
                                <td class="p-4 text-gray-600 whitespace-nowrap text-xs font-mono">{{ $u->phone_number }}</td>
                                <td class="p-4 text-gray-400 font-mono text-xs max-w-[100px] truncate" title="{{ $u->password }}">{{ $u->password }}</td>
                                <td class="p-4 font-bold text-amber-500 whitespace-nowrap">★ {{ $u->rating }}</td>
                                <td class="p-4">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase border bg-blue-50 text-primary border-blue-200">
                                        {{ $u->status }}
                                    </span>
                                </td>
                                <td class="p-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.index', ['user_id' => $u->user_id]) }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold rounded-lg transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.destroy', $u->user_id) }}" method="POST" class="inline">
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
                <div class="lg:col-span-1">
    @if($user)
    <div class="bg-white border border-blue-200 rounded-2xl shadow-sm overflow-hidden sticky top-24">
        <div class="px-6 py-4 border-b border-gray-200 bg-blue-50/50 flex items-center space-x-2">
            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
            <h2 class="font-bold text-primary text-lg">Edit User</h2>
        </div>
        
        <form action="{{ route('admin.update', $user->user_id) }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT') 

            <div>
                <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Full Name:</label>
                <input type="text" name="full_name" value="{{ $user->full_name }}" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm text-gray-900 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" required>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Birth Date:</label>
                <input type="date" name="birth_date" value="{{ $user->birth_date }}" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm text-gray-900 font-mono focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" required>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Email Address:</label>
                <input type="email" name="email_address" value="{{ $user->email_address }}" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm text-gray-900 font-mono focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" required>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Home Address:</label>
                <textarea name="home_address" rows="3" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm text-gray-900 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" required>{{ $user->home_address }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Phone Number:</label>
                <input type="text" name="phone_number" value="{{ $user->phone_number }}" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm text-gray-900 font-mono focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" required>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-gray-500 mb-1">Status:</label>
                <input type="text" name="status" value="{{ $user->status }}" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2 text-sm text-gray-900 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" required>
            </div>

            <div class="pt-4 border-t border-gray-200">
                <button type="submit" class="w-full px-4 py-2.5 bg-primary hover:hover-bg-primary text-white font-bold text-sm rounded-xl transition shadow-sm">
                    Update
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="bg-white border border-dashed border-gray-300 rounded-2xl p-8 text-center text-gray-400 shadow-sm">
        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
        <p class="text-sm">Klik tombol <span class="text-primary font-medium">Edit</span> pada baris tabel pengguna untuk memodifikasi profil data secara instan.</p>
    </div>
    @endif
            </div>

        </div>
    </main>

</body>
</html>