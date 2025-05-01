<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use MongoDB\Laravel\Connection; // Import spécifique pour MongoDB

class MongoSessionServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if (config('session.driver') === 'mongodb') {
            /** @var Connection $connection */
            $connection = DB::connection('mongodb');
            $collection = $connection->getCollection('sessions');

            try {
                $collection->dropIndex('id_1');
            } catch (\Exception $e) {
                // Ignorer si l'index n'existe pas
            }

            $collection->createIndex(['id' => 1], [
                'unique' => true,
                'sparse' => true
            ]);
        }
    }
}