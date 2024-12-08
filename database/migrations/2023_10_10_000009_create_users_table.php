<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); // Ensure this matches the User model
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('user_type', ['Entrepreneur', 'Investor', 'Admin']);
            $table->enum('account_status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });

        // Check if an admin user exists
        $adminExists = DB::table('users')->where('user_type', 'Admin')->exists();

        // Insert default admin user if none exists
        if (!$adminExists) {
            DB::table('users')->insert([
                'username' => 'admin',
                'email' => 'admin@ub.edu.ph',
                'password' => Hash::make('admin_marc'),
                'first_name' => 'Admin',
                'last_name' => 'User',
                'user_type' => 'Admin',
                'account_status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
