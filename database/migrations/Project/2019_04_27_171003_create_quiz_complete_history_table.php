<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizCompleteHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_complete_history', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique()->index();
            $table->unsignedInteger('quiz_id')->index();
            $table->longText('meta'); // for mysql server type better would be `json` type
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
        Schema::dropIfExists('quiz_complete_history');
    }
}
