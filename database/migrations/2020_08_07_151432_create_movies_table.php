<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('movieTitle');
            $table->string('movieDirector')->nullable();
            $table->string('movieGenre')->nullable();
            $table->string('movieCast')->nullable();
            $table->timestamps();

            $table->foreignId("user_id")->unsigned();
            // this tells MySQL that the user_id column
            // references the id column on the users table
            // we also want MySQL to automatically remove any
            // movies linked to users that are deleted
            $table->foreign("user_id")->references("id")
                ->on("users")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
