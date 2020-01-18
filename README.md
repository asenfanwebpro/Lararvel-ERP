# My Work Plan
Gestione Ufficio (Laravel)

# Librerie Utilizzate:
composer require fzaninotto/faker
composer require psr/log
composer require yoeunes/toastr
composer require barryvdh/laravel-dompdf

# Opzionale: Pulizia dei registri
php artisan clear-compiled
composer dump-autoload -o
php artisan optimize

# Fix Database
AppServiceProvider
use Illuminate\Support\Facades\Schema;

public function boot()
{
    Schema::defaultStringLength(191);
}


# Descrizione del progetto

+ Gestione dei turni di lavoro
    + Creazione delle ditte
        + Gestione dei dipartimenti
            + Gestione degli Uffici
            + Gestione delle qualifiche dipendenti
            + Esportazione Contabilità

+ Protocollo Segreteria

+ Pagamenti
    + Mandati
    + Prima Nota

+ Documentazione
    + Archivio Circolari
    + Documentazione
    + Certificati
