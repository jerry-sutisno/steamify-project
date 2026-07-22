# LAPORAN UJIAN AKHIR SEMESTER
# WORKSHOP PEMOGRAMAN WEB 3
## STEAMIFY: APLIKASI MANAJEMEN ANTREAN DAN RESERVASI CUCI MOTOR BERBASIS WEB

Diajukan Untuk Memenuhi Salah Satu Tugas Mata Kuliah Workshop Pemograman Web 3
Dosen Pengampu: Dikky Suryadi S.Kom,.M.Sc

Disusun Oleh:
1. Jerry Sutisno [202404026]
2. Muhamad Sarwan Al Barizy [202404013]
3. Umar Maula Sidiq [202404016]

**POLITEKNIK ENJINERING INDORAMA**
**PRODI TEKNOLOGI REKAYASA PERANGKAT LUNAK**
**2025/2026**

---

### DAFTAR ISI
*(Daftar isi dan halaman dapat disesuaikan kembali di Word)*

### DAFTAR GAMBAR
Gambar 1. Use Case Diagram
Gambar 2. Activity Diagram Registrasi & Autentikasi
Gambar 3. Activity Diagram Kelola Garasi (Data Motor)
Gambar 4. Activity Diagram Reservasi Jadwal (Booking)
Gambar 5. Activity Diagram Checkout & Pembayaran
Gambar 6. Activity Diagram Kelola Antrean Admin
Gambar 7. Sequence Diagram Login
Gambar 8. Perancangan Data (ERD)

---

## BAB I PENDAHULUAN

### 1.1 Latar Belakang
Jasa pencucian sepeda motor merupakan salah satu jenis usaha sektor jasa yang memiliki tingkat permintaan (aktivitas transaksi) yang cukup tinggi setiap harinya, terutama di daerah perkotaan dengan mobilitas penduduk yang padat. Usaha cuci motor yang telah beroperasi pada umumnya melayani pelanggan secara langsung di tempat (go-show). Dalam pengelolaan operasional kesehariannya, sebagian besar pemilik usaha masih menggunakan sistem antrean fisik dan pencatatan manual. Pelanggan yang datang harus mendaftarkan kendaraannya kepada petugas, kemudian menunggu giliran pengerjaan yang didasarkan pada urutan kedatangan (metode First In, First Out secara manual).

Berdasarkan pengamatan di lapangan, sistem antrean manual ini sering kali menimbulkan berbagai kendala, terutama pada jam-jam sibuk atau akhir pekan. Kendala utama yang sering dikeluhkan adalah penumpukan kendaraan di area ruang tunggu serta ketidakpastian estimasi waktu pengerjaan bagi pelanggan. Hal tersebut menyebabkan banyak pelanggan merasa jenuh karena harus menunggu berjam-jam, atau bahkan memutuskan untuk membatalkan niatnya mencuci motor. Selain itu, dari sisi pengelola, pencatatan transaksi yang masih dilakukan menggunakan buku tulis sering kali menimbulkan masalah seperti kelalaian pencatatan, ketidakcocokan antara jumlah kendaraan yang dicuci dengan uang yang masuk, serta kesulitan dalam merekapitulasi laporan pendapatan bulanan.

Ketidakefisienan dalam pengelolaan antrean dan pencatatan transaksi ini juga kerap terjadi akibat kurangnya sistem informasi yang terintegrasi. Keterlambatan dalam menangani pelanggan berpotensi menurunkan tingkat kepuasan pelanggan, menghambat proses pelayanan operasional, serta menyulitkan pemilik usaha dalam mengontrol dan merencanakan pengembangan usahanya. Jika permasalahan ini dibiarkan terus berlanjut tanpa adanya pembaruan sistem operasional, maka dapat berdampak negatif pada daya saing usaha, efektivitas pelayanan, dan efisiensi pengelolaan keuangan di tengah persaingan bisnis jasa yang semakin ketat.

Oleh karena itu, diperlukan sebuah sistem manajemen pemesanan (booking) dan antrean pencucian motor yang lebih terstruktur dan terkomputerisasi. Sistem tersebut diharapkan mampu membantu pengelola dalam mencatat transaksi secara akurat secara real-time, memantau daftar antrean kendaraan dengan cepat, serta meminimalkan kesalahan pencatatan finansial. Bagi pelanggan, sistem ini dirancang untuk memberikan kemudahan dalam melakukan pemesanan jadwal pencucian secara daring, sehingga pengelolaan operasional pada usaha jasa cuci motor dapat berjalan dengan lebih baik, tertib, dan mendukung perkembangan usaha.

### 1.2 Lingkup Masalah 
Agar tahapan perancangan dan pengembangan perangkat lunak pada penelitian ini tetap terarah, terfokus, dan tidak menyimpang dari tujuan utama penyelesaian masalah, maka ditetapkan batasan atau ruang lingkup masalah sebagai berikut:
1. **Fokus Sistem Pemesanan (Booking):** Sistem yang dikembangkan difokuskan pada manajemen pemesanan slot waktu operasional (hari dan jam) yang telah disediakan oleh pihak pengelola. Pemesanan ini dilakukan sepenuhnya melalui platform berbasis web.
2. **Manajemen Hak Akses Pengguna (User Access):** Sistem ini membatasi pengelompokan entitas pengguna menjadi dua peran (aktor) utama. Peran pertama adalah Pelanggan (Customer) yang memiliki akses untuk mendaftarkan data kendaraan pribadi dan membuat pesanan. Peran kedua adalah Admin (Pengelola) yang memiliki wewenang penuh untuk mengatur ketersediaan jadwal, paket harga layanan, memperbarui status pengerjaan, dan mengakses laporan transaksi harian.
3. **Mekanisme Pembayaran di Muka (Pre-paid):** Untuk mengikat antrean dan memastikan validitas pesanan, sistem menerapkan konsep pembayaran di awal. Pembayaran diakomodasi melalui pencatatan metode seperti QRIS, Transfer Bank, atau dompet digital (E-Wallet) di dalam antarmuka sistem.
4. **Pelacakan Status Antrean Terpusat:** Admin hanya bertugas memperbarui status dari setiap pesanan (mulai dari Pending, Dikonfirmasi, Diproses, hingga Selesai). Segala bentuk pembaruan status ini akan terefleksi secara langsung (real-time) di halaman Dashboard pelanggan tanpa memerlukan verifikasi manual tambahan.

### 1.3 Definisi dan Istilah
Untuk menyamakan persepsi, menghindari ambiguitas, serta memberikan pemahaman yang komprehensif mengenai istilah-istilah teknis maupun non-teknis yang digunakan di dalam laporan penelitian maupun di dalam sistem Steamify, berikut adalah penjabaran definisinya:
- **Steamify:** Merupakan identitas atau nama dari perangkat lunak (aplikasi) manajemen layanan cuci motor berbasis web yang dibangun menggunakan kerangka kerja (framework) Laravel dan antarmuka Tailwind CSS.
- **Pelanggan (Customer):** Merupakan representasi dari pengguna akhir (end-user) yang mendaftarkan akun ke dalam sistem dengan tujuan untuk menggunakan jasa cuci motor. Pelanggan dapat memasukkan data identitas kendaraannya untuk kemudian digunakan saat memesan jadwal dan paket layanan cuci.
- **Admin (Administrator):** Merupakan pihak internal pengelola usaha (dapat berupa kasir, staf operasional, ataupun pemilik bisnis) yang bertugas sebagai super-user. Admin memegang kendali penuh atas manajemen database paket layanan, pembukaan slot jadwal baru, dan pergerakan status antrean di lapangan.
- **Booking (Pemesanan):** Merupakan suatu proses administratif yang dilakukan oleh pelanggan melalui sistem untuk mereservasi sebuah slot waktu pengerjaan dan memilih spesifikasi paket layanan secara daring sebelum pelanggan tersebut tiba secara fisik di lokasi pencucian.
- **Slot Jadwal:** Merupakan representasi dari ketersediaan kapasitas waktu operasional bengkel/tempat cuci motor pada interval jam tertentu. Apabila suatu slot telah dipesan dan diselesaikan pembayarannya oleh seorang pelanggan, maka slot tersebut akan dikunci oleh sistem (berstatus "Penuh") sehingga tidak terjadi penumpukan pesanan pada waktu yang bersamaan.
- **Nomor Antrean:** Merupakan deretan kode unik alfa-numerik (sebagai contoh: A-01, A-02) yang digenerasikan secara otomatis oleh algoritma sistem setelah sistem memvalidasi penyelesaian transaksi pembayaran. Kode ini berfungsi sebagai identitas urutan pengerjaan kendaraan pada hari yang bersangkutan.
- **Dashboard:** Merupakan halaman beranda atau panel informasi utama pada aplikasi yang didesain secara visual untuk menyajikan ringkasan data strategis secara cepat. Bagi pelanggan, dashboard memvisualisasikan pesanan yang sedang aktif. Sedangkan bagi admin, dashboard memvisualisasikan data kuantitatif seperti total pesanan harian dan total pendapatan.

---

## BAB II DESKRIPSI UMUM PERANGKAT LUNAK

### 2.1 Deskripsi Umum Sistem
Perangkat lunak yang dikembangkan dalam penelitian ini diberi nama Steamify, yaitu sebuah sistem informasi manajemen pemesanan (booking) dan antrean pencucian sepeda motor berbasis web (web-based application). Sistem ini dirancang sebagai solusi atas permasalahan inefisiensi pencatatan manual dan antrean fisik yang sering kali tidak beraturan pada usaha jasa cuci motor konvensional. Melalui sistem ini, seluruh proses operasional mulai dari pendaftaran kendaraan pelanggan, pemilihan paket pencucian, penetapan jadwal pengerjaan, hingga simulasi pembayaran awal (pre-paid) dapat dilakukan secara terpusat secara digital.

Sistem Steamify bekerja secara sinkron dan langsung (real-time) dalam menghubungkan dua entitas utama, yaitu pihak pelanggan di satu sisi dan pihak pengelola (admin) di sisi lainnya. Ketika seorang pelanggan berhasil mengamankan slot waktu pencucian melalui konfirmasi pembayaran di dalam sistem, data tersebut akan secara otomatis terdistribusi ke dalam basis data (database) pusat. Selanjutnya, algoritma sistem akan menggenerasikan nomor antrean secara dinamis sesuai dengan tanggal yang dipilih. Dari sisi pengelola, data yang masuk tersebut akan divisualisasikan dalam bentuk antarmuka papan kendali (kanban board) yang memungkinkan pengelola untuk melacak, mengelola, dan memperbarui status pengerjaan setiap kendaraan secara akurat tanpa memerlukan pencatatan fisik tambahan.

### 2.2 Karakteristik Pengguna
Berdasarkan fungsionalitas dan alur bisnis yang telah dirancang, perangkat lunak Steamify akan dioperasikan oleh dua kelompok pengguna utama yang memiliki hak akses (privilege) dan karakteristik interaksi yang berbeda. Adapun rincian karakteristik pengguna tersebut adalah sebagai berikut:

**1. Pelanggan (Customer)**
Pelanggan merupakan masyarakat umum pengguna jasa cuci motor. Karakteristik utama dari pengguna ini adalah mereka membutuhkan kemudahan akses melalui berbagai perangkat (seperti telepon pintar atau komputer) untuk melakukan pemesanan jadwal secara cepat. Tingkat keahlian teknis yang diharapkan dari pelanggan adalah kemampuan dasar dalam mengoperasikan peramban web (web browser) dan pemahaman umum terkait prosedur transaksi digital. Aktivitas utama yang dilakukan meliputi pembuatan akun, penambahan data kendaraan, pemilihan jadwal pencucian, dan pemantauan riwayat transaksi.

**2. Administrator (Pengelola/Kasir)**
Administrator merupakan pihak internal dari tempat usaha cuci motor yang memiliki tanggung jawab penuh terhadap kegiatan operasional harian. Karakteristik pengguna ini menuntut pemahaman yang lebih baik terhadap alur layanan usaha serta kemampuan untuk mengelola data master. Tingkat keahlian teknis yang dibutuhkan mencakup kemampuan dasar pengoperasian komputer dan aplikasi berbasis web. Akses yang dimiliki oleh administrator bersifat tidak terbatas terhadap data operasional, yang meliputi kewenangan untuk menambahkan atau menghapus paket layanan, membuka atau menutup ketersediaan slot jadwal, memperbarui status antrean kendaraan di lapangan, serta mengevaluasi rekapitulasi data pendapatan harian.

### 2.3 Lingkungan Operasi
Agar perangkat lunak Steamify dapat berfungsi secara optimal dan memberikan kinerja yang stabil, sistem ini mensyaratkan lingkungan operasi perangkat keras dan perangkat lunak tertentu. Lingkungan operasi ini terbagi menjadi dua sisi, yaitu sisi peladen (server-side) dan sisi pengguna (client-side):

**Sisi Peladen (Server-Side):**
- Sistem Operasi: Kompatibel dengan berbagai sistem operasi server seperti Linux (Ubuntu/CentOS) maupun Windows Server.
- Web Server: Apache HTTP Server atau Nginx (dalam hal ini menggunakan env Laragon).
- Database Management System (DBMS): MySQL versi 5.7 atau yang lebih baru, untuk mengelola basis data transaksional.
- Bahasa Pemrograman & Framework: PHP versi 8.x dan kerangka kerja (framework) Laravel.

**Sisi Pengguna (Client-Side):**
- Perangkat Keras: Dapat diakses menggunakan komputer meja (desktop), laptop, komputer tablet, maupun telepon pintar (smartphone) yang memiliki konektivitas internet.
- Perangkat Lunak: Tidak membutuhkan instalasi aplikasi khusus. Pengguna hanya membutuhkan aplikasi peramban web (web browser) modern yang mendukung HTML5, CSS3 (Tailwind CSS), dan JavaScript.

### 2.4 Batasan Sistem dan Asumsi
Dalam pengembangan sistem pemesanan pencucian motor ini, terdapat beberapa batasan teknis maupun asumsi operasional yang ditetapkan agar cakupan sistem tidak melebar, antara lain:
1. Sistem bergantung sepenuhnya pada ketersediaan koneksi internet yang stabil, baik di pihak pelanggan saat melakukan pemesanan maupun di pihak admin saat mengelola antrean.
2. Modul pembayaran yang terdapat di dalam sistem saat ini bersifat simulasi pencatatan (dummy). Artinya, proses validasi pembayaran elektronik di dunia nyata masih dilakukan secara terpisah (misalnya melalui verifikasi kasir atau pengecekan mutasi rekening), dan sistem secara langsung mengasumsikan transaksi telah "Lunas" setelah dikonfirmasi atau dibayarkan.
3. Sistem tidak menyediakan fitur penjadwalan ulang secara mandiri oleh pelanggan setelah pembayaran dikonfirmasi. Jika terjadi perubahan jadwal atau pembatalan, pelanggan diasumsikan harus menghubungi pihak pengelola secara langsung.

---

## BAB III ANALISIS DAN PERANCANGAN

### 3.1 Analisa Kebutuhan Fungsional Perangkat Lunak
Kebutuhan fungsional mendefinisikan layanan, fitur, dan fungsi spesifik yang harus mampu disediakan oleh sistem Steamify untuk memenuhi tujuan bisnisnya. Pada sistem ini, pengguna diklasifikasikan menjadi dua peran utama: Pelanggan dan Administrator.
- Pelanggan harus dapat melakukan registrasi, masuk (login), menambah data kendaraan, memesan jadwal (booking), memilih metode pembayaran, memberikan ulasan (review), serta memantau riwayat transaksinya.
- Administrator harus dapat mengelola paket layanan, mengatur ketersediaan slot waktu operasional, memperbarui status antrean kendaraan secara real-time, melunasi pembayaran transaksi (DP atau penuh), dan meninjau seluruh laporan transaksi.

*(Bagian Use Case Diagram dan Spesifikasi dipertahankan karena sudah sesuai, kecuali penamaan Activity Diagram diselaraskan dengan fitur Steamify)*

### 3.1.3 Activity Diagram (Revisi)
*(Note: Silakan perbarui gambar diagram di file Word dengan diagram yang merepresentasikan alur berikut, bukan alur inventori stok/barang)*
1. **Activity Diagram Registrasi & Autentikasi**: Menggambarkan alur pelanggan saat mendaftar akun baru dan proses login ke dalam sistem.
2. **Activity Diagram Kelola Garasi (Data Motor)**: Menggambarkan alur saat pelanggan menambahkan, mengedit, atau menghapus (soft delete) data kendaraan/motor mereka.
3. **Activity Diagram Reservasi Jadwal (Booking)**: Menggambarkan alur saat pelanggan memilih kendaraan, memilih paket layanan, memilih jadwal, dan melakukan booking.
4. **Activity Diagram Checkout & Pembayaran**: Menggambarkan alur saat pelanggan memilih metode pembayaran (Transfer, QRIS, Tunai, dll) dan sistem mengonfirmasi status pembayarannya.
5. **Activity Diagram Kelola Antrean Admin**: Menggambarkan alur Admin saat memperbarui status booking dari "Pending", menjadi "Dikonfirmasi", "Diproses", hingga "Selesai", serta proses pencetakan laporan atau struk.

### 3.2 Analisa Kebutuhan Non Fungsional
Selain kebutuhan fungsional, sistem ini harus memenuhi atribut kualitas (Quality Attributes) berikut agar dapat berjalan secara optimal:
- **Performance (Kinerja):** Sistem harus mampu memuat (load) halaman dashboard dan alur pemesanan dalam waktu kurang dari 3 detik pada kondisi jaringan internet standar.
- **Reliability (Keandalan):** Sistem dituntut mampu mencegah terjadinya pemesanan jadwal secara ganda (Double Booking).
- **Usability (Kemudahan Penggunaan):** Antarmuka (UI) harus berprinsip Mobile-First, responsif, dan adaptif (Tailwind CSS) karena diasumsikan pelanggan lebih banyak mengakses layanan melalui telepon pintar.
- **Security (Keamanan):** Sandi pengguna harus dienkripsi menggunakan metode hashing yang kuat (Bcrypt bawaan Laravel) dan mencegah adanya injeksi kode.

### 3.3 Perancangan

#### 3.3.1 Sequence Diagram
*(Tetap dipertahankan untuk menjelaskan interaksi objek saat pelanggan konfirmasi pembayaran)*

#### 3.3.2 Perancangan Data
Struktur basis data (Database) pada sistem Steamify merupakan relasi dari berbagai entitas. Secara konseptual, skema tabel (Data Dictionary) yang dirancang dan sudah disesuaikan dengan skema Migration Laravel yang dibuat mencakup:

1. **Tabel `pelanggan`**: Menyimpan data autentikasi dan profil untuk pengguna aplikasi (customer). Terdiri dari kolom `id_pelanggan`, `nama`, `email`, `no_hp`, dan `password`.
2. **Tabel `admin`**: Menyimpan data autentikasi khusus untuk pengelola. Terdiri dari kolom `id_admin`, `nama_admin`, `email`, dan `password`.
3. **Tabel `motor`**: Bertindak sebagai "Garasi Digital". Menyimpan atribut identitas kendaraan berupa `id_motor`, `id_pelanggan` (Foreign Key), `merk_motor`, `tipe_motor`, `warna_motor`, `plat_nomor`, dan `deleted_at` (Mendukung fitur Soft Delete agar data riwayat transaksi tidak error jika motor dihapus).
4. **Tabel `paket_layanan`**: Master data untuk opsi pencucian. Atributnya meliputi `id_paket`, `nama_paket`, `harga`, `estimasi_waktu` (dalam menit), dan `deskripsi`.
5. **Tabel `jadwal`**: Mengelola ketersediaan waktu bengkel. Atribut utamanya adalah `id_jadwal`, `jam_slot`, dan `status_ketersediaan` (Tersedia / Penuh).
6. **Tabel `booking`**: Tabel relasi inti yang menghubungkan pelanggan dengan jadwal dan layanannya. Terdiri dari kolom `id_booking`, `id_pelanggan`, `id_motor`, `id_paket`, `id_jadwal`, `tanggal_booking`, `status_booking`, `nomor_antrian`, serta kolom ulasan (`review`/`rating`).
7. **Tabel `transaksi`**: Tabel validasi finansial. Berisi `id_transaksi`, `id_booking` (Foreign Key), `nomor_struk`, `metode_bayar`, `tanggal_bayar`, `total_bayar`, `status_bayar`, serta kolom pendukung untuk pembayaran Uang Muka / Down Payment (DP).

#### 3.3.3 Perancangan Antarmuka Pengguna
Link Figma: https://www.figma.com/design/R0dkCUHSWxbs1bg8hMqtwI/Untitled?node-id=0-1&t=60DaYZmpEsmkzi7G-1
