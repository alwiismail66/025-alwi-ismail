<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up () : void
    {
        Schema::create ( 'tasks', function (Blueprint $table)
        {
            $table->id ();
            $table->foreignId ( 'user_id' )->constrained ()->cascadeOnUpdate ()->cascadeOnDelete ();
            $table->string ( 'name' );
            $table->string ( 'notice', length: 300 )->nullable ();
            $table->date ( 'for_date' );
            $table->time ( 'start_at' );
            $table->time ( 'duration' );
            $table->dateTime ( 'expired' );
            $table->decimal ( 'progress', total: 5, places: 2 )->unsigned ()->default ( 0 );
            $table->enum ( 'status', [ 'complete', 'not_complete' ] )->nullable ();
            $table->timestamps ();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down () : void
    {
        Schema::dropIfExists ( 'tasks' );
    }
};
