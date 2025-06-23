<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\SizesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Cliente\ClienteTiendaController;
use App\Http\Controllers\Admin\InnvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::middleware(['auth', 'cliente'])->prefix('cliente')->group(function () {
    Route::get('/store', [ClienteTiendaController::class, 'index'])->name('cliente.store');
    Route::get('/store/product/{product}', [ClienteTiendaController::class, 'product'])->name('cliente.store.product');
    Route::get('/nosotros', [ClienteTiendaController::class, 'about'])->name('cliente.about');
    Route::get('/contact', [ClienteTiendaController::class, 'contact'])->name('cliente.contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('cliente.contact.store');
    Route::get('/cart', [ClienteTiendaController::class, 'cart'])->name('cliente.cart');
    Route::post('/cart/add', [ClienteTiendaController::class, 'addToCart'])->name('cliente.cart.add');
    Route::delete('/cart/remove/{itemId}', [ClienteTiendaController::class, 'removeFromCart'])->name('cliente.cart.remove');
    Route::post('/cart/actualizar/{id}', [ClienteTiendaController::class, 'updateQuantity'])->name('cliente.cart.update');
    Route::get('/checkout', [ClienteTiendaController::class, 'checkout'])->name('cliente.checkout');
    Route::post('/checkout/place-order', [ClienteTiendaController::class, 'placeOrder'])->name('cliente.checkout.placeorder');
    Route::get('/search', [ClienteTiendaController::class, 'search'])->name('cliente.search');
    Route::get('/reviews', [ClienteTiendaController::class, 'createReviewForm'])->name('cliente.reviews');
    Route::post('/reviews', [ClienteTiendaController::class, 'storeReview'])->name('cliente.reviews.store');
    Route::get('/myorders', [ClienteTiendaController::class, 'myOrders'])->name('cliente.myorders');
    Route::get('/orden/{id}/factura', [ClienteTiendaController::class, 'generateInvoicePDF'])->name('cliente.invoice.download');
    Route::get('/orden/{id}/factura/preview', [ClienteTiendaController::class, 'previewInvoice'])->name('cliente.invoice.preview');
});

// Rutas para panel de Administracion 
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::middleware(['auth', 'role:admin,soporte,inventario,ventas'])->prefix('admin')->name('admin.')->group(function () {

    // Opiniones y Mensajes (admin, soporte)
    Route::middleware('role:admin,soporte')->group(function () {
        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::get('messages', [MessageController::class, 'index'])->name('messages');
        Route::post('messages/respond', [MessageController::class, 'respond'])->name('messages.respond');
        Route::delete('messages/{id}', [MessageController::class, 'delete'])->name('messages.delete');
    });

    // Productos, Categorías y Tallas (admin, inventario)
    Route::middleware('role:admin,inventario')->group(function () {

        // Productos
        Route::get('products', [ProductsController::class, 'index'])->name('products');
        Route::get('products/create', [ProductsController::class, 'create'])->name('products.create');
        Route::post('products', [ProductsController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [ProductsController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');

        // Categorías
        Route::get('products/categories', [CategoriesController::class, 'index'])->name('products.categories.index');
        Route::get('products/categories/create', [CategoriesController::class, 'create'])->name('products.categories.create');
        Route::post('products/categories', [CategoriesController::class, 'store'])->name('products.categories.store');
        Route::get('products/categories/{category}/edit', [CategoriesController::class, 'edit'])->name('products.categories.edit');
        Route::put('products/categories/{category}', [CategoriesController::class, 'update'])->name('products.categories.update');
        Route::delete('products/categories/{category}', [CategoriesController::class, 'destroy'])->name('products.categories.destroy');

        // Tallas
        Route::get('products/sizes', [SizesController::class, 'index'])->name('products.sizes.index');
        Route::get('products/sizes/create', [SizesController::class, 'create'])->name('products.sizes.create');
        Route::post('products/sizes', [SizesController::class, 'store'])->name('products.sizes.store');
        Route::get('products/sizes/{size}/edit', [SizesController::class, 'edit'])->name('products.sizes.edit');
        Route::put('products/sizes/{size}', [SizesController::class, 'update'])->name('products.sizes.update');
        Route::delete('products/sizes/{size}', [SizesController::class, 'destroy'])->name('products.sizes.destroy');
    });

    // Pagos y Facturación (admin, ventas)
    Route::middleware('role:admin,ventas')->group(function () {
        Route::get('payments', [PaymentController::class, 'index'])->name('payments');
        Route::get('payments/create', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
        Route::put('payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
        Route::delete('payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
        Route::get('payments/{payment}/details', [PaymentController::class, 'details'])->name('payments.details');
        Route::get('payments/{payment}/invoice', [PaymentController::class, 'invoice'])->name('payments.invoice');

        Route::get('orders', [OrderController::class, 'index'])->name('orders');
        Route::get('invoice', [InnvoiceController::class, 'index'])->name('invoice');
        Route::post('invoice/{order}/status', [InnvoiceController::class, 'updateStatus'])->name('invoice.updateStatus');
        Route::get('/orden/{id}/factura', [InnvoiceController::class, 'generateInvoicePDF'])->name('invoice.download');
    });

    // Usuarios (solo admin)
    Route::middleware('role:admin')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Logs
        Route::get('logs', [LogController::class, 'index'])->name('logs');

        //Reporte de Movimientos de Usuarios
        Route::get('reports/movimientos-usuarios', [ReportsController::class, 'movimientosUsuarios'])->name('reports.movimientos_usuarios');
    });


    // Reportes generales (accesibles para cualquier rol de administracion)
    Route::get('reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('reports/ventas', [ReportsController::class, 'ventasPorFecha'])->name('reports.ventas');
    Route::get('reports/productos-mas-vendidos', [ReportsController::class, 'productosMasVendidos'])->name('reports.productos_mas_vendidos');
    Route::get('reports/productos-por-categoria', [ReportsController::class, 'productosPorCategoria'])->name('reports.productos_por_categoria');
    Route::get('reports/export/pdf', [ReportsController::class, 'exportPdf'])->name('reports.export.pdf');
    Route::get('reports/export/excel', [ReportsController::class, 'exportExcel'])->name('reports.export.excel');
});
