<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Table;
use App\Models\Reservation;
use App\Models\Customer;
use App\Models\Waiter;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Table::class);
            $table->foreignIdFor(Reservation::class);
            $table->foreignIdFor(Customer::class);
            $table->foreignIdFor(Waiter::class);
            $table->float('total');
            $table->float('paid');
            $table->dateTime('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
};
