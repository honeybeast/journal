<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PageSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('pages')->insert([
            'title' => 'Explore Latest Researches',
            'slug' => 'explore-latest-researches',
            'sub_title' => 'Greetings & Welcome',
            'body' => '<p>Consectetur adipisicing elied dotaem eiusmod incididunt ulabore etoimisi dolore magnaaliqua aenimalie admie veniam aistrud exrcittion ullamco laboris utaliquip commodouis aute irure dolorendries in voluptate velit esse cillum dolore.</p>',
            'relation_type' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

}
