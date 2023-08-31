<?php

namespace Config;

use App\Filters\FilterAdmin;
use App\Filters\FilterGudang;
use App\Filters\FilterKasir;
use App\Filters\FilterOwner;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'filterAdmin' => FilterAdmin::class,
        'filterKasir' => FilterKasir::class,
        'filterGudang' => FilterGudang::class,
        'filterOwner' => FilterOwner::class
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     */
    public array $globals = [
        // Sebelum Login tidak Boleh Masuk
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
            'filterAdmin' => [
                // Kecuali ke ->
                'except' => ['login/*', 'login', '/']
            ],
            'filterGudang' => [
                // Kecuali ke ->
                'except' => ['login/*', 'login', '/']
            ],
            'filterKasir' => [
                // Kecuali ke ->
                'except' => ['login/*', 'login', '/']
            ],
            'filterOwner' => [
                // Kecuali ke ->
                'except' => ['login/*', 'login', '/']
            ],
        ],
        // Setelah Login boleh Masuk
        'after' => [
            'filterAdmin' => [
                // kecuali ke ->
                'except' => ['main/*', 'barang/*', 'kategori/*', 'satuan/*', 'barang', 'kategori', 'satuan', 'barangmasuk', 'barangkeluar', 'barangmasuk/*', 'barangkeluar/*', 'pelanggan/*', 'laporan', 'laporan/*']
            ],
            'filterGudang' => [
                'except' => ['main/*', 'barang', 'barangmasuk/*', 'barangmasuk']
            ],
            'filterKasir' => [
                'except' => ['main/*', 'barangkeluar/*', 'barangkeluar']
            ],
            'filterOwner' => [
                'except' => ['*']
            ],
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [];
}
