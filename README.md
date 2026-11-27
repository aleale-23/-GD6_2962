## Catatan artisan serve dan composer run dev 
  
Modul ini cukup memakai php artisan serve karena artisan sendiri merupakan alat perintah bawaan dari laravel dan serve untuk menyalakan server pengembangan komputer. Tujuannya untuk belajar mengembangkan aplikasi. 

## Versi Tools 
  - PHP: 8.2.12
  - Composer: 2.10.3
  - Laravel Installer: ____

## Jawaban dari Pertanyaan Seeder
perintah php artisan migrate:fresh --seed selalu menghapus seluruh tabel, membuat ulang tabel dari migration, lalu menjalankan Seeder dari awal.
Jadi, data tidak akan bertambah menjadi dua kali lipat karena data yang lama sudah dihapus sebelum data baru dimasukkan.

## Soal 1 Unguided Modul 8
Filter tersebut aman dari SQL injection karena Laravel Eloquent menggunakan mekanisme parameter binding melalui PDO. Nilai parameter kota yang berasal dari pengguna diperlakukan sebagai data, bukan sebagai bagian dari perintah SQL. Dengan menggunakan method where('kota', $kota), Laravel memisahkan nilai input dari struktur query SQL sehingga pengguna tidak dapat mengubah perintah SQL melalui parameter kota.

## Soal 2 Unguided Modul 8 
Status HTTP 401 Unauthorized menunjukkan bahwa pengguna belum berhasil diautentikasi karena tidak menyertakan token, menggunakan token yang tidak valid, atau menggunakan token yang sudah dicabut. Sementara itu, status HTTP 403 Forbidden menunjukkan bahwa pengguna telah berhasil diautentikasi menggunakan token yang valid, tetapi tidak memiliki hak akses yang diperlukan untuk mengakses endpoint tertentu.

Dalam pengujian ini, permintaan tanpa token atau dengan token tidak valid menghasilkan status 401. Token yang memiliki ability konser:baca menghasilkan status 403 ketika digunakan untuk mengakses endpoint /api/admin/pesanan, karena endpoint tersebut membutuhkan ability pesanan:baca. Adapun token dengan ability pesanan:baca menghasilkan status 200 OK karena memenuhi persyaratan autentikasi dan otorisasi.