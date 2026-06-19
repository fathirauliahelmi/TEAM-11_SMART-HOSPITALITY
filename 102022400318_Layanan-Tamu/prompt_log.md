# Prompt Engineering Log - Tugas 2 Guest Service

## Informasi Mahasiswa

Nama: Rafli M Fauzan

NIM: 102022400318

Kelas: SI4808

Service: Layanan Tamu (Guest Service)

---

## Log Prompting AI

### Prompt 1

"Membantu membuat REST API Laravel untuk Guest Service sesuai spesifikasi tugas Integrasi Aplikasi Enterprise."

#### Hasil

* Membuat endpoint:

  * GET /api/v1/guest-sessions
  * GET /api/v1/guest-sessions/{id}
  * POST /api/v1/guest-sessions
  * PUT /api/v1/guest-sessions/{id}
* Menggunakan format response JSON.

---

### Prompt 2

"Membantu membuat dokumentasi Swagger menggunakan L5-Swagger."

#### Hasil

* Konfigurasi OpenAPI berhasil dibuat.
* Swagger UI berhasil diakses pada:

http://localhost:8888/api/documentation

* Seluruh endpoint Guest Service berhasil tampil pada Swagger.

---

### Prompt 3

"Membantu menyelesaikan error Swagger yang tidak menampilkan endpoint controller."

#### Hasil

* Identifikasi masalah pada anotasi Swagger.
* Migrasi dari annotation lama ke PHP Attributes.
* Dokumentasi berhasil tergenerate.

---

### Prompt 4

"Membantu implementasi API Key Authentication."

#### Hasil

* Middleware ApiKeyMiddleware berhasil dibuat.
* Header X-API-KEY digunakan untuk autentikasi.
* Endpoint menghasilkan status 401 jika API Key tidak sesuai.

---

### Prompt 5

"Membantu implementasi GraphQL menggunakan Lighthouse."

#### Hasil

* Schema GraphQL berhasil dibuat.
* Query allGuestSessions berhasil dijalankan.
* Query guestSessionById berhasil dijalankan.
* Endpoint GraphQL tersedia pada:

http://localhost:8888/graphql

---

### Prompt 6

"Membantu pengujian endpoint REST API dan GraphQL."

#### Hasil

Pengujian berhasil dilakukan:

* GET /api/v1/guest-sessions → 200
* POST /api/v1/guest-sessions → 201
* GET /api/v1/guest-sessions/999 → 404
* GraphQL allGuestSessions → berhasil
* GraphQL guestSessionById → berhasil

---

## Kesimpulan Tugas 2

AI digunakan sebagai asisten pembelajaran untuk membantu proses debugging, implementasi REST API, dokumentasi Swagger, autentikasi API Key, serta implementasi GraphQL pada layanan Guest Service.

Seluruh implementasi tetap dilakukan, diuji, dan diverifikasi secara mandiri oleh mahasiswa.




### Prompt 7

"Membantu implementasi Machine-to-Machine (M2M) Authentication menggunakan API Key yang disediakan Cloud Dosen."

#### Hasil

* Berhasil memperoleh JWT Token M2M dari endpoint autentikasi Cloud Dosen.
* Token berhasil digunakan untuk mengakses layanan terpusat.
* Pengujian berhasil dilakukan menggunakan Laravel Service.

---

### Prompt 8

"Membantu integrasi Guest Service dengan Legacy SOAP Audit Service."

#### Hasil

* Berhasil membuat SOAP XML Request sesuai format yang ditentukan.
* Guest Service berhasil mengirim data transaksi kritis ke sistem audit dosen.
* Sistem berhasil menerima Receipt Number sebagai bukti pencatatan transaksi.

Contoh Receipt Number:

IAE-LOG-2026-99CF1C0A

---

### Prompt 9

"Membantu menyimpan Receipt Number hasil SOAP Audit ke database Guest Service."

#### Hasil

* Migration penambahan kolom receipt_number berhasil dibuat.
* Receipt Number berhasil disimpan ke tabel guest_sessions.
* Data audit dapat ditelusuri kembali dari database aplikasi.

---

### Prompt 10

"Membantu implementasi RabbitMQ Publisher untuk menyebarkan event bisnis Guest Service."

#### Hasil

* Guest Service berhasil mengirim event ke RabbitMQ Cloud Dosen.
* Event guest.session.created berhasil muncul pada Message Board.
* Payload event berisi informasi sesi tamu yang berhasil dibuat.

---

### Prompt 11

"Membantu mengotomatisasi proses SOAP Audit dan RabbitMQ Publish setelah pembuatan Guest Session."

#### Hasil

* Endpoint POST /api/v1/guest-sessions berhasil diintegrasikan dengan SOAP Audit Service.
* Receipt Number otomatis disimpan setelah audit berhasil dilakukan.
* Event guest.session.created otomatis dipublikasikan ke RabbitMQ.
* Seluruh proses berjalan dalam satu transaksi bisnis tanpa perlu pengiriman manual melalui PowerShell.

---

## Kesimpulan Tugas 3

AI digunakan sebagai asisten teknis untuk membantu proses integrasi Guest Service dengan infrastruktur terpusat yang disediakan dosen.

Melalui proses prompting dan eksplorasi teknis, berhasil diimplementasikan:

* Machine-to-Machine Authentication (M2M)
* Legacy SOAP/XML Audit Service
* RabbitMQ Event Publisher
* Penyimpanan Receipt Number ke Database
* Otomatisasi proses audit dan event broadcasting

Seluruh implementasi telah diuji dan berhasil berjalan sesuai kebutuhan Tugas 3 Integrasi Aplikasi Enterprise.
