<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $adminRole = Role::create(['name' => 'Admin']);
        $distManagerRole = Role::create(['name' => 'District Manager']);
        $facilitiesRole = Role::create(['name' => 'Facilities Agent']);
        $itRole = Role::create(['name' => 'IT Agent']);
        $basicRole = Role::create(['name' => 'Basic User']);
        $storeManagerRole = Role::create(['name' => 'Store Manager']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
