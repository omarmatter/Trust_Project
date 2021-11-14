<?php

namespace Modules\Menu\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Menu\Entities\Categorey;
use Modules\Menu\Entities\Product;

class MenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        Categorey::factory(500)->create();
        Product::factory(500)->create();

    }
}
