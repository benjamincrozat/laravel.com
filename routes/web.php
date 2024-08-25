<?php

use App\Documentation;
use App\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

if (! defined('DEFAULT_VERSION')) {
    define('DEFAULT_VERSION', '11.x');
}

Route::get('docs', [DocsController::class, 'showRootPage']);

Route::get('docs/cashier', function () {
    return redirect(trim('/docs/'.DEFAULT_VERSION.'/billing/'), 301);
});

Route::get('docs/{version}/cashier', function ($version) {
    return redirect(trim('/docs/'.$version.'/billing/'), 301);
});

Route::get('docs/6.0/{page?}', function ($page = null) {
    $page = $page ?: 'installation';
    $page = $page == DEFAULT_VERSION ? 'installation' : $page;

    return redirect(trim('/docs/'.DEFAULT_VERSION.'/'.$page, '/'), 301);
});

Route::get('docs/{version}/index.json', [DocsController::class, 'index']);
Route::get('docs/{version}/{page?}', [DocsController::class, 'show'])->name('docs.version');

Route::redirect('/', '/docs');
