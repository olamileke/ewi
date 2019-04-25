<?php

use Illuminate\Database\Seeder;

use App\Type;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
        	'type'=>'Sonnet'
        ]);

        Type::create([
        	'type'=>'Elegy'
        ]);


        Type::create([
        	'type'=>'Ballad'
        ]);


        Type::create([
        	'type'=>'Epic'
        ]);


        Type::create([
        	'type'=>'Limerick'
        ]);


        Type::create([
        	'type'=>'Ode'
        ]);

    }

}
