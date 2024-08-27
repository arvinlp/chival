<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        DB::table('users')->insert([
            ['mobile'=>9000000000,'username'=>'admin','email' => 'admin@admin.com', 'password' => Hash::make('admin'),'type'=>'admin'],
            ['mobile'=>9000000001,'username'=>'company','email' => 'company@company.com', 'password' => Hash::make('company'),'type'=>'client']
        ]);
        DB::table('roles')->insert([
            ['name'=>'دسترسی کامل','description'=>'-','type'=>'admin'],
            ['name'=>'دسترسی کامل شرکت','description'=>'-','type'=>'client'],
            ['name'=>'دسترسی کاربر اول','description'=>'-','type'=>'client'],
        ]);
        DB::table('role_accesses')->insert([
            ['role_id'=>1,'code'=>'admins','name'=>'مدیران'],
            ['role_id'=>1,'code'=>'add_admin','name'=>'افزودن'],
            ['role_id'=>1,'code'=>'edit_admin','name'=>'ویرایش'],
            ['role_id'=>1,'code'=>'delete_admin','name'=>'حذف'],

            ['role_id'=>1,'code'=>'users','name'=>'مدیران'],
            ['role_id'=>1,'code'=>'add_user','name'=>'مدیران'],
            ['role_id'=>1,'code'=>'edit_user','name'=>'مدیران'],
            ['role_id'=>1,'code'=>'delete_user','name'=>'مدیران'],

            ['role_id'=>1,'code'=>'companies','name'=>'مدیران'],
            ['role_id'=>1,'code'=>'add_company','name'=>'مدیران'],
            ['role_id'=>1,'code'=>'edit_company','name'=>'مدیران'],
            ['role_id'=>1,'code'=>'delete_company','name'=>'مدیران'],
            
            ['role_id'=>1,'code'=>'roles','name'=>'مدیران'],
            ['role_id'=>1,'code'=>'add_role','name'=>'مدیران'],
            ['role_id'=>1,'code'=>'edit_role','name'=>'مدیران'],
            ['role_id'=>1,'code'=>'delete_role','name'=>'مدیران'],
            
            ['role_id'=>1,'code'=>'worktimes','name'=>'مدیران'],
            ['role_id'=>1,'code'=>'add_worktimes','name'=>'مدیران'],
            ['role_id'=>1,'code'=>'edit_worktimes','name'=>'مدیران'],
            ['role_id'=>1,'code'=>'delete_worktimes','name'=>'مدیران'],

            ['role_id'=>2,'code'=>'users','name'=>'مدیران'],
            ['role_id'=>2,'code'=>'add_user','name'=>'مدیران'],
            ['role_id'=>2,'code'=>'edit_user','name'=>'مدیران'],
            ['role_id'=>2,'code'=>'delete_user','name'=>'مدیران'],
            
            ['role_id'=>2,'code'=>'roles','name'=>'مدیران'],
            ['role_id'=>2,'code'=>'add_role','name'=>'مدیران'],
            ['role_id'=>2,'code'=>'edit_role','name'=>'مدیران'],
            ['role_id'=>2,'code'=>'delete_role','name'=>'مدیران'],
            
            ['role_id'=>2,'code'=>'worktimes','name'=>'مدیران'],
            ['role_id'=>2,'code'=>'add_worktimes','name'=>'مدیران'],
            ['role_id'=>2,'code'=>'edit_worktimes','name'=>'مدیران'],
            ['role_id'=>2,'code'=>'delete_worktimes','name'=>'مدیران'],
        ]);
        DB::table('work_times')->insert([
            ['name'=>'شنبه',    'week'=> 1, 'start'=>'00:00:00', 'end'=>'00:00:00', 'type'=>'admin'],
            ['name'=>'۱ شنبه',  'week'=> 2, 'start'=>'00:00:00', 'end'=>'00:00:00', 'type'=>'admin'],
            ['name'=>'۲ شنبه',  'week'=> 3, 'start'=>'00:00:00', 'end'=>'00:00:00', 'type'=>'admin'],
            ['name'=>'۳ شنبه',  'week'=> 4, 'start'=>'00:00:00', 'end'=>'00:00:00', 'type'=>'admin'],
            ['name'=>'۴ شنبه',  'week'=> 5, 'start'=>'00:00:00', 'end'=>'00:00:00', 'type'=>'admin'],
            ['name'=>'۵ شنبه',  'week'=> 6, 'start'=>'00:00:00', 'end'=>'00:00:00', 'type'=>'admin'],
            ['name'=>'جمعه',    'week'=> 7, 'start'=>'00:00:00', 'end'=>'00:00:00', 'type'=>'admin'],

            ['name'=>'شنبه',    'week'=> 1, 'start'=>'00:00:00', 'end'=>'00:00:00', 'type'=>'client'],
            ['name'=>'۱ شنبه',  'week'=> 2, 'start'=>'00:00:00', 'end'=>'00:00:00', 'type'=>'client'],
            ['name'=>'۲ شنبه',  'week'=> 3, 'start'=>'00:00:00', 'end'=>'00:00:00', 'type'=>'client'],
            ['name'=>'۳ شنبه',  'week'=> 4, 'start'=>'00:00:00', 'end'=>'00:00:00', 'type'=>'client'],
            ['name'=>'۴ شنبه',  'week'=> 5, 'start'=>'00:00:00', 'end'=>'00:00:00', 'type'=>'client'],
            ['name'=>'۵ شنبه',  'week'=> 6, 'start'=>'00:00:00', 'end'=>'00:00:00', 'type'=>'client'],
            ['name'=>'جمعه',    'week'=> 7, 'start'=>'00:00:00', 'end'=>'00:00:00', 'type'=>'client'],
        ]);
    }
}
