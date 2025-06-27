<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaxvatColumnAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_address', function (Blueprint $table) {
            $table->string('taxvat')->after('email')->nullable();
        });
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->string('taxvat')->after('name')->nullable();
        });
        Schema::table('order_address', function (Blueprint $table) {
            $table->string('taxvat')->after('email')->nullable();
        });
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
