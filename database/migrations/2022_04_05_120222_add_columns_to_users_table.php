<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->after('id');
            $table->string('first_name')->after('last_name');
            $table->string('last_kana_name')->after('first_name');
            $table->string('first_kana_name')->after('last_kana_name');
            $table->enum('gender', ['male', 'female'])->nullable()->after('password');
            $table->date('birthdate')->nullable()->after('gender');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_name');
            $table->dropColumn('first_name');
            $table->dropColumn('last_kana_name');
            $table->dropColumn('first_kana_name');
            $table->dropColumn('gender');
            $table->dropColumn('birthdate');
        });
    }
}
