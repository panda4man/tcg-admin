<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardCollectionPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_collection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('collection_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('count')->default(0);
            $table->index(['card_id', 'collection_id'], 'card_collection_compound_primary_index');
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
        Schema::dropIfExists('card_collection');
    }
}
