<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waybills', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number');
            $table->date('issued_at');
            $table->integer('valid_for_days');
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->string('route_from');
            $table->string('route_to');
            $table->foreignId('responsible_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', [1, 0]);
            $table->json('classifications');
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
        Schema::dropIfExists('waybills');
    }
};
