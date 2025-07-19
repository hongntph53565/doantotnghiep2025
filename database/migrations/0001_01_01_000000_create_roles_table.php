<?php
// First create the roles migration (0000_create_roles_table.php)
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id('role_id');
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Seed default roles
        DB::table('roles')->insert([
            ['name' => 'admin', 'description' => 'System administrator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'manager', 'description' => 'cinema management', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'employee', 'description' => 'System administrator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'user', 'description' => 'Default system user', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};