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

## Soal 3 Unguided Modul 8 
Token yang tidak pernah kedaluwarsa berbahaya apabila bocor karena pihak yang tidak berwenang dapat menggunakannya untuk mengakses endpoint API selama token tersebut belum dicabut. Hal ini dapat menyebabkan penyalahgunaan hak akses, kebocoran data, dan akses tidak sah terhadap sistem. Dengan menerapkan masa berlaku token, risiko penyalahgunaan dapat dikurangi karena token secara otomatis menjadi tidak valid setelah melewati batas waktu yang ditentukan.


## Soal 4 Unguided Modul 8 
Apabila perintah php artisan migrate:fresh --seed dijalankan kembali, seluruh tabel database beserta datanya akan dihapus, kemudian dibuat ulang melalui migration dan diisi kembali melalui seeder. AdminSeeder akan membaca nilai ADMIN_PASSWORD dari file .env untuk membuat akun admin.

Akibatnya, kata sandi baru yang sebelumnya diubah melalui halaman ganti kata sandi akan hilang dan kata sandi admin kembali mengikuti nilai ADMIN_PASSWORD pada file .env. Oleh karena itu, apabila file .env belum diperbarui, admin harus kembali menggunakan kata sandi lama setelah proses migration dan seeding selesai.

## Soal 5 
Status HTTP 204 No Content digunakan karena proses penghapusan data berhasil dilakukan tanpa perlu mengembalikan isi respons kepada klien. Berbeda dengan status 200 OK yang umumnya disertai data atau pesan hasil pemrosesan, status 204 menunjukkan bahwa permintaan berhasil tetapi tidak memiliki response body. Penggunaan status 204 sesuai dengan karakteristik operasi DELETE ketika tidak ada data tambahan yang perlu dikirimkan.

Konser yang sudah memiliki pesanan tidak boleh dihapus karena terdapat hubungan antara tabel konsers dan tabel pesanans melalui foreign key konser_id. Apabila konser tersebut dihapus, data pesanan akan kehilangan referensi terhadap konser yang dipesan. Hal tersebut dapat mengganggu integritas database, riwayat transaksi, dan laporan penjualan. Oleh karena itu, sistem menolak penghapusan konser yang memiliki pesanan menggunakan status HTTP 409 Conflict.


## Soal 6 Unguided Modul 8 
Status pesanan harus diperiksa di dalam transaksi setelah menggunakan lockForUpdate() untuk memastikan bahwa data yang diperiksa merupakan data terbaru dan tidak dapat diubah oleh transaksi lain selama proses berlangsung. Jika pemeriksaan status dilakukan sebelum baris dikunci, dua permintaan yang berjalan secara bersamaan dapat membaca status yang sama, yaitu menunggu_bayar, sehingga keduanya dapat memproses pembatalan dan mengembalikan stok tiket sebanyak dua kali.

Penggunaan DB::transaction() dan lockForUpdate() mencegah kondisi tersebut karena permintaan berikutnya harus menunggu transaksi sebelumnya selesai. Setelah memperoleh kunci, permintaan berikutnya membaca status terbaru dan ditolak apabila pesanan sudah berstatus lunas atau batal. Dengan demikian, konsistensi status pesanan dan stok tiket tetap terjaga.