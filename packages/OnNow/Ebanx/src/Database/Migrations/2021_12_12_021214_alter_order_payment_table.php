<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_payment', function (Blueprint $table) {
            $table->string('ext_transaction_code', 100)->nullable()->after('method_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_payment', function (Blueprint $table) {
            $table->dropColumn('ext_transaction_code');
        });
    }
}
