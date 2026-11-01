<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:seed-if-empty', function () {
    if (! Schema::hasTable('users')) {
        $this->error('The users table does not exist. Run migrations first.');

        return 1;
    }

    if (User::query()->exists()) {
        $this->info('Database already initialized — skipping seeders.');

        return 0;
    }

    $this->info('Fresh database detected — running seeders...');

    return $this->call('db:seed', ['--force' => true]);
})->purpose('Seed the initial content only when the database is empty (safe for every deploy)');
