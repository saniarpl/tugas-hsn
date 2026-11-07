<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Supabase Storage
    |--------------------------------------------------------------------------
    |
    | Dipakai untuk menyimpan foto (berita, galeri, carousel, anggota, dll)
    | agar permanen dan bisa diakses publik. Filesystem container di Vercel
    | bersifat sementara, jadi foto tidak boleh disimpan di disk lokal.
    |
    | Bila SERVICE_ROLE_KEY belum diisi, aplikasi otomatis jatuh ke disk
    | lokal (storage/app/public) seperti perilaku Laravel bawaan.
    |
    */

    'url' => env('SUPABASE_URL'),

    'service_role_key' => env('SUPABASE_SERVICE_ROLE_KEY'),

    'storage_bucket' => env('SUPABASE_STORAGE_BUCKET', 'wanuwin'),

];
