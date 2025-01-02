<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        require_once app_path('Helpers/Terbilang.php');
    }

    public function printTiket1($id)
    {
        $deposito = Deposito::findOrFail($id);
        $nominal = $deposito->nominal; // Ganti dengan field yang sesuai
        $jatuhTempo = $deposito->jatuhTempo; // Ganti dengan field yang sesuai
        $kewajibanSegera = $deposito->kewajibanSegera; // Ganti dengan field yang sesuai

        return view('report.tiket', compact('nominal', 'jatuhTempo', 'kewajibanSegera'));
    }
}
