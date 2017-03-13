<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        $this->call('UsersTableSeeder');
        $this->call('RoleSeeder');


    }

}

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rsmsa_users')->delete();
        DB::table('rsmsa_users')->insert(
            array(
                'firstName'=>'Mathew',
                'middleName'=>'steven',
                'lastName'=>'Shaka',
                'username'=>'Matayo',
                'password'=>Hash::make('energy'),
                'email'=>'matthewshaka@gmail.com',
                'phoneNumber'=>'0783269',
                'role'=>'4',
                'created_at'=>new DateTime,
                'updated_at'=>new DateTime,

            )


            );


    }
}

class RoleSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->delete();

        DB::table('role')->insert(
            array(
                'id'=>'1',
                'name'=>'Doctor',
                'specialized'=>'Pathologist',
                'created_at'=>new DateTime,
                'updated_at'=>new DateTime,

            )


        );

        DB::table('role')->insert(
            array(
                'id'=>'2',
                'name'=>'Laboratory',
                'specialized'=>'Lab Technician',
                'created_at'=>new DateTime,
                'updated_at'=>new DateTime,

            )


        );
        DB::table('role')->insert(
            array(
                'id'=>'3',
                'name'=>'Receptionist',
                'specialized'=>'Receptionist',
                'created_at'=>new DateTime,
                'updated_at'=>new DateTime,

            )


        );
        DB::table('role')->insert(
            array(
                'id'=>'4',
                'name'=>'Admin',
                'specialized'=>'Admin',
                'created_at'=>new DateTime,
                'updated_at'=>new DateTime,

            )


        );
        DB::table('role')->insert(
            array(
                'id'=>'5',
                'name'=>'Accountant',
                'specialized'=>'Admin',
                'created_at'=>new DateTime,
                'updated_at'=>new DateTime,

            )


        );
    }
}

