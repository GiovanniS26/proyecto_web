<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Insertando valores en la tabla `roles`
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'user'],
            ['name' => 'client'],
        ]);

        DB::table('users')->insert([
            [
                'name' => 'admin',
                'role_id' => 1,
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin1234')
            ]
        ]);
    }

    public function down()
    {
        // Opcional: eliminar los datos en el método down para revertir la migración
        DB::table('roles')->whereIn('name', ['admin', 'user'])->delete();
        DB::table('users')->whereIn('email', ['admin@admin.com'])->delete();
    }
};
