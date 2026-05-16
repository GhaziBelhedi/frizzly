<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LibraryPdfController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\TestResultController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Enseignant\ChatbotController;
use App\Http\Controllers\Enseignant\ChatController;
use App\Http\Controllers\QuizTakeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// ── Public pages ────────────────────────────────────────────
Route::get('/',          fn () => view('home'))->name('home');
Route::get('/about',     fn () => view('about'))->name('about');
Route::get('/programme', fn () => view('programme'))->name('programme');
Route::get('/produits',  fn () => view('produits'))->name('produits');
Route::get('/contact',   fn () => view('contact'))->name('contact');
Route::post('/contact',  [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
Route::get('/actualite', fn () => view('actualite'))->name('actualite');

// ── Auth pages ───────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    fn () => view('auth.login'))->name('login');
    Route::get('/register', fn () => view('auth.register'))->name('register');
});
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Admin dashboard ──────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Tests Reçus
    Route::get('/tests',             [TestResultController::class, 'index'])->name('tests.index');
    Route::get('/tests/{test}',      [TestResultController::class, 'show'])->name('tests.show');
    Route::delete('/tests/{test}',   [TestResultController::class, 'destroy'])->name('tests.destroy');

    // Users
    Route::get('/users',                          [UserController::class, 'index'])->name('users.index');
    Route::post('/users',                         [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}',                   [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}',                [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/toggle-status',   [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Bibliothèque PDF
    Route::get('/library',                  [LibraryPdfController::class, 'index'])->name('library.index');
    Route::post('/library',                 [LibraryPdfController::class, 'store'])->name('library.store');
    Route::delete('/library/{libraryPdf}',  [LibraryPdfController::class, 'destroy'])->name('library.destroy');

    // Produits & Commandes
    Route::get('/products',                   [ProductController::class, 'index'])->name('products.index');
    Route::post('/products',                  [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}',         [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}',      [ProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('/orders/{order}/status',    [ProductController::class, 'updateOrder'])->name('orders.update');

    // Messages
    Route::get('/messages',                   [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}',         [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/reply',  [MessageController::class, 'reply'])->name('messages.reply');
    Route::patch('/messages/{message}/read',  [MessageController::class, 'markRead'])->name('messages.read');
    Route::delete('/messages/{message}',      [MessageController::class, 'destroy'])->name('messages.destroy');

    // QCM
    Route::get('/quiz',                     [QuizController::class, 'index'])->name('quiz.index');
    Route::get('/quiz/create',              [QuizController::class, 'create'])->name('quiz.create');
    Route::post('/quiz',                    [QuizController::class, 'store'])->name('quiz.store');
    Route::get('/quiz/{quiz}',              [QuizController::class, 'show'])->name('quiz.show');
    Route::get('/quiz/{quiz}/edit',         [QuizController::class, 'edit'])->name('quiz.edit');
    Route::put('/quiz/{quiz}',              [QuizController::class, 'update'])->name('quiz.update');
    Route::delete('/quiz/{quiz}',           [QuizController::class, 'destroy'])->name('quiz.destroy');
    Route::patch('/quiz/{quiz}/toggle',     [QuizController::class, 'toggleStatus'])->name('quiz.toggle');

    // Legacy redirects
    Route::get('/commandes', fn () => redirect()->route('admin.products.index', ['tab' => 'orders']))->name('commandes');
    Route::get('/quiz/creer',fn () => redirect()->route('admin.quiz.create'))->name('quiz.creer');
});

// ── Teacher dashboard ────────────────────────────────────────
Route::prefix('enseignant')->name('enseignant.')->middleware(['auth', 'role:enseignant'])->group(function () {
    Route::get('/',            fn () => view('enseignant.dashboard'))->name('dashboard');
    Route::get('/quiz',        fn () => view('enseignant.quiz'))->name('quiz');
    Route::get('/progression', fn () => view('enseignant.progression'))->name('progression');
    Route::get('/carnet',      fn () => view('enseignant.carnet'))->name('carnet');
    Route::get('/formation',   fn () => view('enseignant.formation'))->name('formation');
    Route::get('/messages',      [ChatController::class, 'index'])->name('messages');
    Route::post('/messages',     [ChatController::class, 'store'])->name('messages.store');
    Route::get('/messages/poll', [ChatController::class, 'poll'])->name('messages.poll');
    Route::get('/chatbot',       [ChatbotController::class, 'index'])->name('chatbot');
    Route::post('/chatbot',      [ChatbotController::class, 'chat'])->name('chatbot.chat');
});

// ── Quiz (teachers take quiz) ────────────────────────────────
Route::middleware(['auth', 'role:enseignant'])->group(function () {
    Route::get('/quiz/{quiz}/repondre',          [QuizTakeController::class, 'show'])->name('quiz.repondre');
    Route::post('/quiz/{quiz}/repondre',         [QuizTakeController::class, 'submit'])->name('quiz.submit');
    Route::get('/quiz/{quiz}/resultat/{result}', [QuizTakeController::class, 'result'])->name('quiz.resultat');
});
