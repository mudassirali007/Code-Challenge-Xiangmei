<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIsIdnColumnDomainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('domains', function (Blueprint $table) {
            $table->boolean('is_idn')->default(1)->change();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('domains', function (Blueprint $table) {
             $table->boolean('is_idn')->default(0)->change();
         });
    }
}
