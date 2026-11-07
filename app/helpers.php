<?php

use App\Support\ImageStorage;

if (! function_exists('image_url')) {
    /**
     * Resolve path foto dari database menjadi URL publik.
     *
     * Mengembalikan null bila tidak ada foto sehingga view dapat
     * me-render gambar fallback alih-alih menghasilkan link rusak.
     */
    function image_url(?string $path): ?string
    {
        return ImageStorage::url($path);
    }
}
