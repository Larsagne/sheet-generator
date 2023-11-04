<?php

use App\Models\User;
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
        Schema::create('sheets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(User::class)->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('artist');
            $table->integer('duration')->nullable();
            $table->integer('tempo')->nullable();
            $table->string('time_signature')->default('4/4');
            $table->string('key')->nullable();
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
        Schema::dropIfExists('sheets');
    }
};
