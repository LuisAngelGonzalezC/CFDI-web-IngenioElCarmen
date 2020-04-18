<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->number = 2344;
        $user->name = 'Luis Angel';
        $user->last_name = 'González';
        $user->second_last_name = 'Calihua';
        $user->rfc = 'GFS213DSF02';
        $user->curp = 'GOCL930122HVZNLS00';
        $user->imss = 'F-13754312-4';
        $user->email = 'admin@admin.mx';
        $user->password = bcrypt('12345678');
        $user->type = true;
        $user->confirmation_code = str_random(25);
        $user->save();

        factory(App\User::class, 300)->create();
    }
}
