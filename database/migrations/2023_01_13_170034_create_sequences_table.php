<?php

use App\Models\Part;
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
        Schema::create('sequences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(Part::class);
            $table->integer('position');
            $table->integer('quantity')->default(1);
            $table->text('description')->nullable();
            $table->json('measures');
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
        Schema::dropIfExists('sequences');
    }
};
