<?php

use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\KategoriPengaduanController;
use App\Http\Controllers\admin\KamusSaraController;
use App\Http\Controllers\eksekutor\PengaduanController as EksekutorPengaduanController;
use App\Http\Controllers\eksekutor\TindakLanjutController as EksekutorTindakLanjutController;
use App\Http\Controllers\global\AuthController;
use App\Http\Controllers\global\DashboardController;
use App\Http\Controllers\global\PengaduanController;
use App\Http\Controllers\global\ProfileController;
use App\Http\Controllers\global\StaticPageController;
use App\Http\Controllers\penduduk\PengaduanController as PendudukPengaduanController;
use Illuminate\Support\Facades\Route;

// Landing Routes
Route::get("/", [StaticPageController::class, "home"])->name("landing.home");
Route::get("/about", [StaticPageController::class, "about"])->name("landing.about");
Route::prefix("/pengaduan")->group(function () {
    Route::get("/", [PengaduanController::class, "index"])->name(
        "landing.pengaduan.index",
    );
    Route::get("/create", [PengaduanController::class, "create"])->name(
        "landing.pengaduan.create",
    );
    Route::post("/", [PengaduanController::class, "store"])
        ->name("landing.pengaduan.store")
        ->middleware("auth");
    Route::get("/{pengaduan}", [PengaduanController::class, "show"])->name(
        "landing.pengaduan.show",
    );
    Route::get("/{pengaduan}/edit", [PengaduanController::class, "edit"])
        ->middleware("auth")
        ->name("landing.pengaduan.edit");
    Route::put("/{pengaduan}", [PengaduanController::class, "update"])
        ->middleware("auth")
        ->name("landing.pengaduan.update");
    Route::post("/{pengaduan}/ulasan", [
        PengaduanController::class,
        "storeUlasan",
    ])
        ->middleware("auth")
        ->name("landing.pengaduan.ulasan.store");
});
Route::get("/contact", [StaticPageController::class, "contact"])->name("landing.contact");

Route::get("/login", [AuthController::class, "loginView"])->name("login");
Route::post("/login", [AuthController::class, "loginStore"]);
Route::post("/logout", [AuthController::class, "logoutStore"])->middleware(
    "auth",
);
Route::get("/dashboard", [AuthController::class, "redirectByRole"])->middleware(
    "auth",
);

// Admin Routes
Route::prefix("/admin")
    ->middleware("auth")
    ->group(function () {
        Route::get("/dashboard", [
            DashboardController::class,
            "adminDashboard",
        ]);

        Route::resource("users", UserController::class);
        Route::resource(
            "kategori-pengaduan",
            KategoriPengaduanController::class,
        );
        Route::resource("kamus-sara", KamusSaraController::class);

        // Pengaduan Transaction
        Route::resource(
            "pengaduan",
            \App\Http\Controllers\admin\PengaduanController::class,
        )
            ->parameters([
                "pengaduan" => "pengaduan",
            ])
            ->names([
                "index" => "admin.pengaduan.index",
                "show" => "admin.pengaduan.show",
                "edit" => "admin.pengaduan.edit",
                "update" => "admin.pengaduan.update",
                "destroy" => "admin.pengaduan.destroy",
            ])
            ->except(["create", "store"]);

        Route::put("pengaduan/{pengaduan}/status", [
            \App\Http\Controllers\admin\PengaduanController::class,
            "updateStatus",
        ])->name("admin.pengaduan.update-status");
        Route::put("pengaduan/{pengaduan}/assign-eksekutor", [
            \App\Http\Controllers\admin\PengaduanController::class,
            "assignEksekutor",
        ])->name("admin.pengaduan.assign-eksekutor");

        // Admin can also add ulasan
        Route::post("pengaduan/{pengaduan}/ulasan", [
            PengaduanController::class,
            "storeUlasan",
        ])->name("admin.pengaduan.ulasan.store");
    });
// Penduduk Routes
Route::prefix("/penduduk")
    ->middleware("auth")
    ->group(function () {
        Route::get("/dashboard", [
            DashboardController::class,
            "pendudukDashboard",
        ]);

        Route::prefix("/pengaduan")->group(function () {
            Route::get("/", [
                PendudukPengaduanController::class,
                "index",
            ])->name("penduduk.pengaduan.index");
            Route::get("/{id}", [
                PendudukPengaduanController::class,
                "show",
            ])->name("penduduk.pengaduan.show");

            // Penduduk can add ulasan to their own pengaduan
            Route::post("/{pengaduan}/ulasan", [
                PengaduanController::class,
                "storeUlasan",
            ])->name("penduduk.pengaduan.ulasan.store");
        });
    });
// Eksekutor Routes
Route::prefix("/eksekutor")
    ->middleware("auth")
    ->group(function () {
        Route::get("/dashboard", [
            DashboardController::class,
            "eksekutorDashboard",
        ]);

        Route::prefix("/pengaduan")->group(function () {
            Route::get("/", [
                EksekutorPengaduanController::class,
                "index",
            ])->name("eksekutor.pengaduan.index");
            Route::get("/{id}", [
                EksekutorPengaduanController::class,
                "show",
            ])->name("eksekutor.pengaduan.show");

            // Eksekutor can add ulasan to pengaduan they handle
            Route::post("/{pengaduan}/ulasan", [
                PengaduanController::class,
                "storeUlasan",
            ])->name("eksekutor.pengaduan.ulasan.store");
        });

        Route::prefix("/tindak-lanjut")->group(function () {
            Route::get("/", [
                EksekutorTindakLanjutController::class,
                "index",
            ])->name("eksekutor.tindak-lanjut.index");
            Route::get("/create", [
                EksekutorTindakLanjutController::class,
                "create",
            ])->name("eksekutor.tindak-lanjut.create");
            Route::post("/", [
                EksekutorTindakLanjutController::class,
                "store",
            ])->name("eksekutor.tindak-lanjut.store");
            Route::get("/{id}", [
                EksekutorTindakLanjutController::class,
                "show",
            ])->name("eksekutor.tindak-lanjut.show");
            Route::get("/{id}/edit", [
                EksekutorTindakLanjutController::class,
                "edit",
            ])->name("eksekutor.tindak-lanjut.edit");
            Route::put("/{id}", [
                EksekutorTindakLanjutController::class,
                "update",
            ])->name("eksekutor.tindak-lanjut.update");
            Route::delete("/{id}", [
                EksekutorTindakLanjutController::class,
                "destroy",
            ])->name("eksekutor.tindak-lanjut.destroy");
        });
    });

// Profile Routes (All Roles)
Route::prefix("profile")
    ->middleware("auth")
    ->group(function () {
        Route::get("/", [ProfileController::class, "show"])->name(
            "profile.show",
        );
        Route::put("/", [ProfileController::class, "update"])->name(
            "profile.update",
        );
        // Update Password
        Route::put("/password", [
            ProfileController::class,
            "updatePassword",
        ])->name("profile.update-password");
    });
