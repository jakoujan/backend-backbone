<?php

use Illuminate\Database\Seeder;

class SystemCustomer extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(App\SystemCustomer::class, 10)->create()->each(function ($customer) {
           
        });
    }

}
