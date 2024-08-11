<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('transactions_items');
        Schema::dropIfExists('transactions');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->integer('users_id');
            $table->integer('total_price')->default(0);
            $table->string('status')->default('PENDING');
            $table->text('payment_url');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('users_id');
            $table->bigInteger('products_id');
            $table->bigInteger('transactions_id');
            $table->bigInteger('quantity');

            $table->timestamps();
        });
    }
}
