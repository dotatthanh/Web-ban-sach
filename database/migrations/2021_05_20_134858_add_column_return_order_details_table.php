<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnReturnOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('return_order_details', function (Blueprint $table) {
            $table->unsignedBigInteger('total_money')->after('amount');
            $table->unsignedBigInteger('discount')->after('total_money');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('return_order_details', function (Blueprint $table) {
            $table->dropColumn('total_money');
            $table->dropColumn('discount');
        });
    }
}
