<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropVoyagerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('roles');
        if (Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function ($table) {
                $table->dropForeign('users_role_id_foreign');
                $table->dropColumn('role_id');
            });
        }
        Schema::dropIfExists('data_rows');
        Schema::dropIfExists('data_types');

        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menus');

        Schema::dropIfExists('settings');

        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');

        Schema::dropIfExists('translations');

        Schema::dropIfExists('user_roles');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
