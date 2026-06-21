## 🔧 Troubleshooting - Kelola Pelamar Tidak Bekerja

### Langkah 1: Jalankan Migration
Buka terminal di folder `c:\xampp\htdocs\growhubfix` dan jalankan:

```bash
php artisan migrate
```

Pastikan output menunjukkan bahwa migration `create_project_applicants_table` berhasil dibuat.

### Langkah 2: Cek Logs
Jika masih error, cek file log untuk melihat error detail:

```
c:\xampp\htdocs\growhubfix\storage\logs\laravel.log
```

### Langkah 3: Clear Cache (Jika Perlu)
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Langkah 4: Test Endpoint
Akses URL ini di browser:
```
http://localhost/growhubfix/project/1/applicants
```

Ganti `1` dengan `project_id` yang sebenarnya.

### Debugging Checklist:
- [ ] Migration sudah dijalankan
- [ ] Table `project_applicants` sudah ada di database
- [ ] File `resources/views/kelola_pelamar.blade.php` ada
- [ ] Controller `app/Http/Controllers/ProjectApplicantController.php` ada
- [ ] Route `/project/{project_id}/applicants` terdaftar di `routes/web.php`

### Jika Masih Error:
1. Bagikan error message dari `storage/logs/laravel.log`
2. Pastikan Database benar-benar ter-create (bukan hanya schema)
3. Cek apakah ada PHP error di browser console
