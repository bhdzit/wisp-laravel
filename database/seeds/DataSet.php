<?php

use App\Clientes;
use App\Paquetes;
use App\Sectores;
use App\Servicios;
use App\Torres;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DataSet extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //
        $faker = Faker::create();
        User::create([
            'name' => 'Bryan Eliut Hernandez Moran',
            'email' => 'bhdzit97@gmail.com',
            'email_verified_at' => $faker->date,
            'password' => Hash::make('IT25697.'),
        ]);

        $latitudes_productos = [
            39.49639, 39.50513, 39.50897, 39.51948, 39.50451, 39.50458, 39.52365, 39.60411, 39.57297
        ];

        $longitudes_productos = [
            -0.4419, -0.42233, -0.45537, -0.44113, -0.39332, -0.36199, -0.40948, -0.28519, -0.33446
        ];

        for ($i = 1; $i < 9; $i++) {
            Torres::create([
                'wt_nombre' => 'TORRE##' . $i . '0',
                'wt_altura' => '15',
                'wt_point' => DB::raw("POINT(" . $faker->randomFloat(5, 19, 22) . ',' . $faker->randomFloat(5, -100, -98) . ")")
            ]);
        }

        //Tipos de Antenas
        DB::table('wisp_antenna_type')->insert([
            'wa_name' => 'Sectorial'
        ]);

        DB::table('wisp_antenna_type')->insert([
            'wa_name' => 'Obnidirecional'
        ]);

        for ($i = 0; $i < 10; $i++) {
            Sectores::create([
                'wsct_name' => 'Sector ' . ($i + 1),
                'wsct_dist' => $faker->numberBetween(20, 100),
                'wsct_antenna' => 2,
                'wsct_address' => DB::raw("INET_ATON('" . $i . "')"),
                'wsct_segment' => '24',
                'wsct_tower' => Torres::orderByRaw("rand()")->first()->wt_id,
                'wsct_description' => '',
                'wsct_color' => '000',

            ]);
        }

        for ($i = 0; $i < 10; $i++) {

            $sector = Sectores::create([
                'wsct_name' => 'Sector ' . ($i + 1),
                'wsct_dist' => $faker->numberBetween(20, 100),
                'wsct_antenna' => 1,
                'wsct_address' => DB::raw("INET_ATON('" . $i . "')"),
                'wsct_segment' => '24',
                'wsct_tower' => Torres::orderByRaw("rand()")->first()->wt_id,
                'wsct_description' => '',
                'wsct_color' => '000',

            ]);

            DB::table('wisp_sec_ant')->insert([
                'wsec_id' => $sector->wsct_id,
                'wsec_deg' => $faker->numberBetween(-180, 180),
                'wsec_rank' => $faker->numberBetween(2, 4) * 30
            ]);
        }



        Paquetes::create([
            'wp_name' => 'Paquete 1',
            'wp_tx' => 3,
            'wp_rx' => 7,
            'wp_price' => 200,
            'wp_description' => ''
        ]);

        Paquetes::create([
            'wp_name' => 'Paquete 1',
            'wp_tx' => 3,
            'wp_rx' => 7,
            'wp_price' => 200,
            'wp_description' => ''
        ]);
        DB::table('wisp_contract')->insert([
            'wct_nombre'=>'Prepago',
            'wct_descripcion'=>'Pago por mes una vez adquirido el equipo',
        ]);

        for ($i = 0; $i < 10; $i++) {
           $cliente = Clientes::create([
                'wc_name'=>$faker->name,
                'wc_last_name'=> $faker->lastName,
                'wc_phone'=>$faker->numerify,//$faker->phoneNumber,
                'wc_phone2'=>$faker->numerify//$faker->phoneNumber,
                
            ]);


            Servicios::create([
                'ws_id_cliente'=>$cliente->wc_id,
                'ws_date'=>$faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
                'ws_first_pay_date'=>$faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
                'ws_pkg'=>Paquetes::orderByRaw("rand()")->first()->wp_id,
                'ws_maps'=> DB::raw("POINT(" . $faker->randomFloat(5, 19, 22) . ',' . $faker->randomFloat(5, -100, -98) . ")"),
                'ws_contract'=>1,
                'ws_sector'=>Sectores::orderByRaw("rand()")->first()->wsct_id,
                'ws_ssid'=>'',
                'ws_pass'=>'',
                'ws_ip'=>DB::raw("INET_ATON('192.168." . $i . ".1')"),
            ]);


        }
    }
}
