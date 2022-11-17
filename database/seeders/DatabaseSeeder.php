<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $admin = Admin::create([
            'name' => 'mason_hows11',
            'first_name' => 'naeem',
            'last_name' => 'soltany',
            'mobile' => '09917230927',
            //'token'=>  mt_rand(111111,999999),
            //'token_verified_at' => Carbon::now(),
        ]);
        $admin1 = Admin::create([
            'name' => 'james',
            'first_name' => 'joe',
            'last_name' => 'james',
            'mobile' => '09178278154',
            //'token'=>  mt_rand(111111,999999),
            //'token_verified_at' => Carbon::now(),
        ]);

        $role_admin = Role::create(['guard_name' => 'admin', 'name' => 'admin']);
        $admin->assignRole($role_admin);

        $user = User::create([
            'first_name' => 'naeem',
            'last_name' => 'soltany',
            'name' => 'mason',
            'email' => 'mason.hows11@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('1289..')
        ]);

        $user1 = User::create([
            'first_name' => 'james',
            'last_name' => 'redfield',
            'name' => 'james',
            'email' => 'james@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('1289..'),
        ]);

        $users = [
            [
                'name' => 'nicky',
                'first_name' => 'nick',
                'last_name' => 'wilson',
                'email' => 'nicky.wilson21@gmail.com',
                'password' => Hash::make('1289..//**'),
                'mobile' => '09917230929',
            ],
            [
                'name' => 'Mary',
                'first_name' => 'maria',
                'last_name' => 'watson',
                'email' => 'mary.watson90@gmail.com',
                'password' => Hash::make('1289..//**'),
                'mobile' => '09917230925',
            ],
            [
                'name' => 'John97',
                'first_name' => 'John',
                'last_name' => 'marston',
                'email' => 'john.marston1870@gmail.com',
                'password' => Hash::make('1289..//**'),
                'mobile' => '09917230922',
            ],
            [
                'name' => 'David',
                'first_name' => 'David120',
                'last_name' => 'Bombal',
                'email' => 'david.bombal11@gmail.com',
                'password' => Hash::make('1289..//**'),
                'mobile' => '09917230911',
            ],

        ];
        foreach ($users as $user) {
            User::create($user);
        }
        User::factory()->count(30)->create();

        $category = Category::create([
            'title_persian' => 'برنامه نویسی',
            'title_english' => 'programming',
        ]);

        $category->child()->saveMany([
            $cat1 = new Category([
                'title_persian' => 'برنامه نویسی وب',
                'title_english' => 'back-end programming',
            ]),
            $cat2 = new Category([
                'title_persian' => 'برنامه نویسی ویندوز',
                'title_english' => 'windows programming',
            ]),
            $cat3 = new Category([
                'title_persian' => 'برنامه نویسی فرانت',
                'title_english' => 'front-end programming',
            ])
        ]);

        $cat1->child()->saveMany([
            new Category([
                'title_persian' => 'پی اچ پی',
                'title_english' => 'php',
            ]),
            new Category([
                'title_persian' => 'لاراول',
                'title_english' => 'laravel',
            ])
        ]);
        $cat2->child()->saveMany([
            new Category([
                'title_persian' => 'سی شارپ',
                'title_english' => 'c-sharp',
            ]),
            new Category([
                'title_persian' => 'پایتون',
                'title_english' => 'python',
            ])
        ]);
        $cat3->child()->saveMany([
            new Category([
                'title_persian' => 'سی اس اس',
                'title_english' => 'css',
            ]),
            new Category([
                'title_persian' => 'اچ تی ام ال',
                'title_english' => 'html',
            ]),
            new Category([
                'title_persian' => 'ری اکت جی اس',
                'title_english' => 'react js',
            ]),
            new Category([
                'title_persian' => 'ویو جی اس',
                'title_english' => 'vue js',
            ])
        ]);


    }
}
