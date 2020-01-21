<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hostname')->nullable();
            $table->string('ipaddr4')->unique();
            $table->string('ipaddr6')->unique()->nullable();
            $table->string('macaddr')->unique();
            $table->boolean('online')->default(true);
            $table->bigInteger('offline-count')->default(0);
            $table->string('comment')->nullable();
            $table->softDeletes();
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
        if(Schema::hasTable('nodes')) Schema::dropIfExists('nodes');
    }
}
