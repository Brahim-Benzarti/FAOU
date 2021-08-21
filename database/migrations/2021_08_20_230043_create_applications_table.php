<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->String("Time")->nullable();
            $table->String("First_Name")->nullable();
            $table->String("Last_Name")->nullable();
            $table->String("Email",1000)->nullable();
            $table->String("Nationality")->nullable();
            $table->String("Birthday")->nullable();
            $table->String("Position")->nullable();
            $table->String("First_Time")->nullable();
            $table->String("CV",1000)->nullable();
            $table->String("Biography",1500)->nullable();
            $table->String("Motivation_Letter",3500)->nullable();
            $table->String("User_id")->nullable();
            $table->enum("status",array("read","pending"))->default("pending");
            $table->enum("decision",array("accepted","rejected"))->nullable();
            $table->enum("flag",array(1,0))->default(0);
            $table->enum("incomplete",array(0,1))->default(0);
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
        Schema::dropIfExists('applications');
    }
}
