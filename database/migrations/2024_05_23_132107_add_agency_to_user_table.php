<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('user', function (Blueprint $table) {
        $table->string('agency')->nullable(); // Add the agency column
    });
}

public function down()
{
    Schema::table('user', function (Blueprint $table) {
        $table->dropColumn('agency'); // Remove the agency column
    });
}

};
