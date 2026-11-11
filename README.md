## Catatan artisan serve dan composer run dev 
  
Modul ini cukup memakai php artisan serve karena artisan sendiri merupakan alat perintah bawaan dari laravel dan serve untuk menyalakan server pengembangan komputer. Tujuannya untuk belajar mengembangkan aplikasi. 

## Versi Tools 
  - PHP: 8.2.12
  - Composer: 2.10.3
  - Laravel Installer: ____

## Jawaban dari Pertanyaan Seeder
perintah php artisan migrate:fresh --seed selalu menghapus seluruh tabel, membuat ulang tabel dari migration, lalu menjalankan Seeder dari awal.
Jadi, data tidak akan bertambah menjadi dua kali lipat karena data yang lama sudah dihapus sebelum data baru dimasukkan.