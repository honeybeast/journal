<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('sitemanagements')->insert([
            'meta_key' => 'socials',
            'meta_value' => 'a:4:{i:0;a:2:{s:5:"title";s:8:"facebook";s:3:"url";s:16:"www.facebook.com";}i:3;a:2:{s:5:"title";s:7:"twitter";s:3:"url";s:15:"www.twitter.com";}i:4;a:2:{s:5:"title";s:8:"linkedin";s:3:"url";s:16:"www.linkedin.com";}i:5;a:2:{s:5:"title";s:10:"googleplus";s:3:"url";s:14:"www.google.com";}}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('sitemanagements')->insert([
            'meta_key' => 'site_title',
            'meta_value' => 'a:1:{i:0;a:1:{s:10:"site_title";s:7:"Journal";}}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('sitemanagements')->insert([
            'meta_key' => 'slides',
            'meta_value' => 'a:2:{i:0;a:3:{s:11:"slide_title";s:55:"We Welcome Latest Research Articles In Field Of Science";s:10:"slide_desc";s:75:"Consectetur adipisicing elit sedaui sedaui labore quis nostrud exercitation";s:11:"slide_image";s:11:"fronimg.png";}i:5;a:3:{s:11:"slide_title";s:51:"We Welcome Latest Research Articles In Field Of Web";s:10:"slide_desc";s:75:"Consectetur adipisicing elit sedaui sedaui labore quis nostrud exercitation";s:11:"slide_image";s:11:"fronimg.png";}}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('sitemanagements')->insert([
            'meta_key' => 'payment_mode',
            'meta_value' => 'a:1:{i:0;s:18:"individual-product";}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('sitemanagements')->insert([
            'meta_key' => 'payment_settings',
            'meta_value' => 'a:1:{i:0;a:6:{s:9:"client_id";s:28:"etwordpress03_api1.gmail.com";s:15:"paypal_password";s:16:"ZGKBBWQQCB7D8PV4";s:13:"paypal_secret";s:56:"AFcWxV21C7fd0v3bYYYRCpSSRl31AourX-ksxTzlCrJKdyT7e6ktdq5g";s:8:"currency";s:3:"USD";s:3:"vat";s:2:"25";s:12:"payment_type";s:9:"test_mode";}}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('sitemanagements')->insert([
            'meta_key' => 'pages',
            'meta_value' => 'a:1:{i:0;s:25:"explore-latest-researches";}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('sitemanagements')->insert([
            'meta_key' => 'welcome_slides',
            'meta_value' => 'a:3:{i:0;a:1:{s:19:"welcome_slide_image";s:10:"img-01.jpg";}i:1;a:1:{s:19:"welcome_slide_image";s:10:"img-02.jpg";}i:2;a:1:{s:19:"welcome_slide_image";s:10:"img-03.jpg";}}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

}
