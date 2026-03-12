<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\Role;
use Modules\User\Entities\User;
use Spatie\Permission\PermissionRegistrar;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //Ipix Admin
        Role::where('name', 'super_privilege')->delete();
        $ipixAdminRole = Role::create(['name' => 'super_privilege', 'guard_name' => 'admin']);

        User::where('email', 'web@ipixsolutions.com')->forceDelete();
        $ipixAdminUser = new User();
        $ipixAdminUser->status = true;
        $ipixAdminUser->name = 'Ipix Admin';
        $ipixAdminUser->email = 'web@ipixsolutions.com';
        $ipixAdminUser->password = Hash::make('elegant@01');
        $ipixAdminUser->save();
        $ipixAdminUser->assignRole($ipixAdminRole);

        // elegant Admin
        Role::where('name', 'elegant_admin')->delete();
        $elegantAdminRole = Role::create(['name' => 'elegant_admin', 'guard_name' => 'admin']);

        User::where('email', 'admin@elegant.com')->forceDelete();
        $elegantAdminUser = new User();
        $elegantAdminUser->name = 'Elegant Admin';
        $elegantAdminUser->status = true;
        $elegantAdminUser->email = 'admin@elegant.com';
        $elegantAdminUser->password = Hash::make('elegant@01');
        $elegantAdminUser->deleted_at = null;
        $elegantAdminUser->save();
        $elegantAdminUser->assignRole($elegantAdminRole);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        User::where('email', 'web@ipixsolutions.com')->forceDelete();
        User::where('email', 'admin@elegant.com')->forceDelete();
    }
};
