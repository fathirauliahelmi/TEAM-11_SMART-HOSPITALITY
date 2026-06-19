# Smart Hospitality - Guest Service

## Deskripsi

Guest Service merupakan layanan yang digunakan untuk mengelola sesi tamu aktif pada sistem Smart Hospitality.

Service ini dibuat sebagai bagian dari mata kuliah Integrasi Aplikasi Enterprise.

## Fitur

* Membuat sesi tamu aktif
* Melihat seluruh sesi tamu
* Melihat detail sesi tamu berdasarkan ID
* Memperbarui data sesi tamu
* API Key Authentication
* Swagger Documentation
* GraphQL Query

## Teknologi

* Laravel 13
* MySQL
* Docker
* L5-Swagger
* Lighthouse GraphQL

## REST API Endpoint

### GET

`/api/v1/guest-sessions`

Mengambil seluruh sesi tamu.

### GET

`/api/v1/guest-sessions/{id}`

Mengambil detail sesi tamu berdasarkan ID.

### POST

`/api/v1/guest-sessions`

Membuat sesi tamu baru.

### PUT

`/api/v1/guest-sessions/{id}`

Memperbarui data sesi tamu.

## API Documentation

Swagger UI:

http://localhost:8888/api/documentation

## GraphQL

Endpoint:

http://localhost:8888/graphql

Contoh Query:

```graphql
{
  allGuestSessions {
    id
    room_number
    guest_name
    status
  }
}
```

## Authentication

Gunakan Header:

```
X-API-KEY: guest12345
```

## Author

Rafli M Fauzan
NIM: 102022400318
Kelas: SI4808
