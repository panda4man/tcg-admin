<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->index();
            $table->unsignedInteger('game_cost')->nullable();
            $table->string('type')->nullable();
            $table->string('subtype')->nullable();
            $table->text('description')->nullable();
            $table->text('quote')->nullable();
            $table->foreignId('card_rarity_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('card_culture_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
