<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoGrafiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_grafiks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author')->default(1);
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('keyword')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('status', ['0', '1']);
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
        Schema::dropIfExists('info_grafiks');
    }
}
