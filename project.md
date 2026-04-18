Gemini said
Berikut adalah Product Requirements Document (PRD) Final untuk Bali Realty Holidays Villa. Dokumen ini telah merangkum seluruh diskusi kita, mulai dari identitas old money (benchmark Elite Havens), arsitektur multi-villa, pembagian tab spesifik (Facilities, Services, Inclusions), hingga keputusan menggunakan Admin Panel Manual (Custom).

📄 Product Requirements Document (PRD)
Project Name: Bali Realty Holidays Villa Portal
Version: 3.0 (Final)
Target Platform: Web (Responsive Desktop & Mobile)

1. Ringkasan Produk
Website Bali Realty Holidays Villa adalah platform representatif dan fungsional yang dirancang untuk menampilkan puluhan properti villa eksklusif di Bali dengan citra old money: elegan, tenang, berkelas, tidak berlebihan, dan berorientasi pada kualitas jangka panjang.

Website berfungsi sebagai:

Media Branding: Menampilkan portofolio properti premium berdasarkan area (Canggu, Seminyak, Uluwatu, dll).

Kanal Penerimaan Inquiry: Mempermudah tamu kelas atas mengirimkan permintaan reservasi tanpa kesan "salesy".

Sistem Manajemen Internal (Custom Built): Dashboard admin untuk mengelola properti, harga musiman (seasonal rates), galeri foto, inquiry, dan sinkronisasi kalender (iCal).

2. Tujuan Produk
Memberikan kesan pertama yang premium, timeless, dan terpercaya (trustworthy).

Mempermudah calon tamu mengeksplorasi villa dan mengirimkan inquiry secara langsung.

Menyediakan dashboard admin custom yang intuitif untuk mengelola konten, harga, dan tamu tanpa batasan dari library pihak ketiga.

Menghindari double booking melalui sinkronisasi kalender iCal otomatis/manual dengan platform OTA (Airbnb, Booking.com).

3. Target User & Karakteristik
3.1 Target User Utama (Guest)
High-Net-Worth Individuals (HNWI): Tamu dengan preferensi high-end, private, dan understated luxury.

Karakteristik Visual: Mengutamakan privasi, kualitas visual tinggi (foto/video), dan detail informasi. Tidak menyukai tampilan website yang terlalu ramai, flashy, atau penuh pop-up.

3.2 Admin / Internal Team
Staff Villa / Reservation Team & Marketing: Mengelola properti harian, membalas inquiry, dan memperbarui harga.

Karakteristik: Membutuhkan antarmuka (UI) admin yang straightforward (jelas) untuk input data spesifik seperti ketersediaan fasilitas dan musim liburan.

4. Scope Fitur Utama
4.0 Fitur Ketersediaan Kalender & iCal Sync
Fitur ini bersifat informational (non-booking) di sisi user untuk menjaga eksklusivitas.

Fungsi User: Menampilkan status Available / Unavailable di halaman villa. Jika tanggal terisi, user tetap bisa mengirim inquiry dengan notifikasi soft message (contoh: "Selected dates may not be available"). Tampilan kalender menggunakan warna muted (abu-abu/hitam).

Fungsi Admin (iCal Sync): * Admin memasukkan URL iCal eksternal (Airbnb/Booking).

Sistem melakukan sinkronisasi otomatis (Cron Job) atau manual (Button "Sync Now").

Sistem juga men-generate URL iCal internal (Export) per villa untuk dibagikan ke OTA.

4.1 Fitur Pengunjung (Frontend)
Smart Explorer: Pencarian villa berdasarkan Area (Canggu, Seminyak, dll) dan filter kamar/harga.

Halaman Detail Villa (Tabbed Interface): Navigasi mulus menggunakan tab untuk menjaga halaman tetap rapi:

Overview: Deskripsi naratif elegan, kapasitas tamu, luas properti, dan galeri visual kualitas tinggi.

Facilities: Daftar infrastruktur fisik (contoh: 15m Infinity Pool, Media Room, Gym).

Services: Layanan staf/human touch (contoh: Private Chef, 24/7 Butler, Daily Housekeeping).

Rates & Inclusions: Tabel harga transparan berdasarkan Low, Shoulder, dan Peak Season, beserta daftar fasilitas gratis (Complimentary Breakfast, Airport Transfer).

Location: Peta area (muted tone map) dan jarak ke titik populer.

Inquiry Form: Formulir elegan (Nama, Email, WhatsApp, Tanggal, Jumlah Tamu, Pesan).

4.2 Fitur Admin Panel (Manual / Custom MVC)
Admin panel bersifat private (login protected) dibangun murni menggunakan Blade/Tailwind tanpa Filament.

Dashboard Utama: Metrik jumlah inquiry baru dan status sinkronisasi iCal.

Manajemen Villa (CRUD): * Tambah/Edit properti (Nama, Area, Deskripsi).

Status Publikasi: Draft atau Published.

Manajemen Fasilitas: Sistem checklist (centang) untuk menandai Facilities, Services, dan Inclusions yang tersedia di villa tersebut.

Manajemen Harga Musiman (Seasonal Rates): Set tanggal Low, Shoulder, Peak dan tentukan harganya per villa.

Manajemen Galeri: Upload massal, set Hero Image, dan atur urutan (Sort Order) foto.

Manajemen Inquiry: Tracking pesan masuk dengan status (New, Contacted, Confirmed, Archived).

Manajemen Review: Input testimoni tamu secara manual (Nama, Negara, Pesan) dan toggle Publish/Unpublish.

5. Halaman Website (User Side)
Home: Hero full-width, pencarian, featured villas.

Area / Destinations: Katalog villa berdasarkan wilayah.

Villa Detail Page: Informasi komprehensif properti (Overview, Facilities, Services, Rates/Inclusions, Location).

About Us: Cerita dan standar layanan Bali Realty.

Contact / General Inquiry: Form untuk pertanyaan non-spesifik properti.

6. Desain & UX Guidelines (Benchmark: Elite Havens)
Karakter Umum: Minimalis elegan, layout simetris, dan optimalisasi white space.

Typography: Kombinasi Serif klasik (contoh: Playfair Display) untuk Heading dan Sans-serif modern (contoh: Inter/Montserrat) untuk Body Text.

Warna: Palet warna muted (Putih, Krem/Warm Yellow, Abu-abu gelap, Charcoal). Tanpa warna neon/mencolok.

Interaksi & Animasi: Bebas elemen yang mengganggu. Transisi antar halaman yang halus, scroll-reveal (AOS/GSAP) yang lambat dan elegan, efek hover zoom mikro pada foto galeri.

7. Tech Stack & Arsitektur Data
7.1 Teknologi
Backend: Laravel 11 (PHP).

Frontend UI: Tailwind CSS & Blade Templating.

Animasi: Alpine.js (untuk Tab/Modal) & GSAP / AOS (untuk animasi scroll).

Database & Environment: MySQL, XAMPP (Local Development).

Calendar Parser: spatie/icalendar-generator atau custom parser PHP.

7.2 Struktur Database (High-Level Schema)
Mengakomodasi pemisahan Facilities, Services, dan Inclusions:

areas: id, name, slug

villas: id, area_id, name, slug, overview, status, ical_url

amenity_categories: id, name (1=Facilities, 2=Services, 3=Inclusions)

amenities: id, category_id, name, icon_path

villa_amenity: (Pivot) villa_id, amenity_id

seasons: id, name, start_date, end_date

villa_rates: id, villa_id, season_id, price

photos: id, villa_id, path, category (Hero/Gallery), sort_order

inquiries: id, villa_id, name, email, phone, check_in, check_out, guests, message, status

reviews: id, villa_id, guest_name, country, review_text, is_published

8. Non-Functional Requirements
Kecepatan: Optimasi gambar otomatis (WebP) agar loading cepat meski padat visual.

Responsif: Pendekatan Desktop-first (menyesuaikan gaya presentasi luxury di layar lebar) namun tetap flawless di perangkat Mobile.

Keamanan: Proteksi CSRF di setiap form dan validasi backend ketat.

9. KPI & Success Metrics
Jumlah inquiry valid per bulan.

Berkurangnya double booking berkat sinkronisasi iCal yang akurat.

Bounce rate pengunjung menurun karena visual dan waktu muat (load time) yang baik.

10. Future Enhancements (Di luar lingkup saat ini)
Fitur Online Booking dan Payment Gateway terintegrasi.

Dukungan Multi-bahasa (Inggris, Mandarin, Rusia).

11. Kesimpulan
Website Bali Realty Holidays Villa ini dirancang murni untuk merepresentasikan gaya hidup old money: halus, berkelas, dan eksklusif. Dengan menggunakan kontrol penuh dari arsitektur Admin Panel Custom, tim internal dapat bekerja efisien mengelola data puluhan villa, sementara pengunjung disajikan pengalaman browsing sekelas Elite Havens. PRD ini menjadi fondasi mutlak untuk tahap development.