<?php

namespace App\Http\Middleware;

use Closure;

class ContentSecurityPolicy
{
    /**
     * Menangani permintaan masuk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Mengatur header Content-Security-Policy
        $csp = "default-src 'self'; "; // Mengizinkan sumber daya hanya dari domain yang sama
        $csp .= "script-src 'self'; ";  // Mengizinkan skrip hanya dari sumber yang sama
        $csp .= "style-src 'self' 'unsafe-inline'; ";  // Mengizinkan gaya CSS dari domain yang sama dan inline styles
        $csp .= "img-src 'self' data:; ";  // Mengizinkan gambar dari domain yang sama dan data URIs
        $csp .= "font-src 'self'; ";  // Mengizinkan font dari domain yang sama
        $csp .= "connect-src 'self'; "; // Mengizinkan koneksi (AJAX, WebSockets, dll) dari domain yang sama

        // Jika perlu menambahkan URL sumber lainnya, tambahkan di sini
        // Misalnya untuk mengizinkan gambar dari domain tertentu:
        // $csp .= "img-src 'self' https://trusted-image-source.com;";

        // Menambahkan header CSP ke respons
        response()->headers->set('Content-Security-Policy', $csp);

        return $next($request);
    }
}
