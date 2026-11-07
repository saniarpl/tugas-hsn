<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Penyimpanan foto tunggal untuk seluruh aplikasi.
 *
 * Bila Supabase Storage terkonfigurasi, file diunggah ke bucket publik
 * dan path relatif (mis. "galleries/xxx.jpg") yang disimpan di database
 * akan di-resolve menjadi URL publik Supabase. Bila tidak, file disimpan
 * ke disk lokal seperti biasa.
 */
class ImageStorage
{
    /**
     * Unggah file dan kembalikan path relatif untuk disimpan di database.
     */
    public static function store(string $folder, UploadedFile $file): string
    {
        if (! self::enabled()) {
            $path = Storage::disk('public')->putFile($folder, $file);

            if ($path === false) {
                throw new RuntimeException('Gagal menyimpan file upload: '.$file->getClientOriginalName());
            }

            return $path;
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $name = Str::random(40).($extension !== '' ? '.'.$extension : '');
        $path = trim($folder.'/'.$name, '/');

        $contents = file_get_contents($file->getRealPath());
        if ($contents === false) {
            throw new RuntimeException('Gagal membaca file upload: '.$file->getClientOriginalName());
        }

        $response = Http::withToken(self::key())
            ->withHeaders(['x-upsert' => 'true'])
            ->withBody($contents, self::mimeType($file))
            ->timeout(60)
            ->put(self::endpoint('/storage/v1/object/'.self::bucket().'/'.$path));

        if (! $response->successful()) {
            throw new RuntimeException(
                'Gagal mengunggah foto ke Supabase Storage: HTTP '.$response->status().' '.$response->body()
            );
        }

        return $path;
    }

    /**
     * Hapus file berdasarkan path relatif yang tersimpan di database.
     */
    public static function delete(?string $path): void
    {
        if ($path === null || $path === '') {
            return;
        }

        $path = self::relativePath($path);

        if ($path === null) {
            return;
        }

        if (! self::enabled()) {
            Storage::disk('public')->delete($path);

            return;
        }

        Http::withToken(self::key())
            ->timeout(30)
            ->delete(self::endpoint('/storage/v1/object/'.self::bucket().'/'.$path));
    }

    /**
     * Resolve path tersimpan menjadi URL publik yang bisa ditampilkan.
     * Mengembalikan null bila tidak ada foto agar view bisa me-render fallback.
     */
    public static function url(?string $path): ?string
    {
        if ($path === null || trim($path) === '') {
            return null;
        }

        // Sudah berupa URL penuh (mis. hasil migrasi lama), pakai apa adanya.
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (self::enabled()) {
            return self::publicBase().'/'.ltrim($path, '/');
        }

        return asset('storage/'.$path);
    }

    /**
     * Supabase aktif hanya bila URL dan service role key sudah diisi.
     */
    public static function enabled(): bool
    {
        return self::baseUrl() !== '' && self::key() !== '';
    }

    private static function baseUrl(): string
    {
        return trim((string) config('supabase.url'));
    }

    private static function key(): string
    {
        return trim((string) config('supabase.service_role_key'));
    }

    private static function bucket(): string
    {
        $bucket = trim((string) config('supabase.storage_bucket'));

        return rawurlencode($bucket !== '' ? $bucket : 'wanuwin');
    }

    private static function publicBase(): string
    {
        return rtrim(self::baseUrl(), '/').'/storage/v1/object/public/'.self::bucket();
    }

    private static function endpoint(string $path): string
    {
        return rtrim(self::baseUrl(), '/').$path;
    }

    /**
     * Ambil path relatif dari penyimpanan; abaikan URL eksternal yang
     * bukan milik bucket Supabase kita.
     */
    private static function relativePath(string $path): ?string
    {
        if (! Str::startsWith($path, ['http://', 'https://'])) {
            return ltrim($path, '/');
        }

        $marker = '/storage/v1/object/';
        $position = strpos($path, $marker);
        if ($position === false) {
            return null;
        }

        $remainder = substr($path, $position + strlen($marker));
        // Buang prefix "public/" bila URL memakai bentuk publik.
        if (Str::startsWith($remainder, 'public/')) {
            $remainder = substr($remainder, strlen('public/'));
        }

        // Sisakan setelah nama bucket.
        $slash = strpos($remainder, '/');
        if ($slash === false) {
            return null;
        }

        return substr($remainder, $slash + 1);
    }

    private static function mimeType(UploadedFile $file): string
    {
        $mime = $file->getClientMimeType();

        return $mime !== null && $mime !== '' ? $mime : 'application/octet-stream';
    }
}
