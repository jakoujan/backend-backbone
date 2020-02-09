<?php

use Illuminate\Database\Seeder;

class TransactionalCustomer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TransactionalCustomer::class, 120)->create()->each(function ($customer) {
           
        });
    }
}
