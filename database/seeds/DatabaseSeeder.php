<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AdminTableSeeder::class);

        Model::reguard();
    }
}

/**
* 
*/
class AdminTableSeeder extends Seeder
{
    
    public function run()
    {
      $data['username']=Admin::USERNAME;
      $data['email']=Admin::EMAIL;
      $data['password']=bcrypt(Admin::PASSWORD);
      $data['modules_permission']=Admin::MODULE;
      $data['first_name'] = Admin::FULLNAME;
      Admin::create($data);
    }
}