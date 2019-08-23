<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_messages', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('lead_id');
			$table->string('subject')->nullable();
			$table->string('body')->nullable();
			$table->boolean('new')->default(true);
            $table->timestamps();
        });

		Schema::create('leadmessage_lead', function (Blueprint $table) {
            $table->unsignedInteger('lead_id');
			$table->unsignedInteger('leadmessage_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('lead_messages');
        Schema::dropIfExists('leadmessage_lead');
    }
}
