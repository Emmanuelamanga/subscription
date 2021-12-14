<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribes', function (Blueprint $table) {
            $table->id();
            $table->string('website_name');
            $table->string('email');
            $table->timestamps();
            $table->softDeletes();

        });
        // Schema::table('subscribes', function($table) {
        //    // relationship
        //    $table->foreign('website_name')->references('name')->on('websites')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropForeign('subscribes_website_name_foreign');
        Schema::dropIndex('subscribes_website_name_index');
        Schema::dropIfExists('subscribes');

    }
}
