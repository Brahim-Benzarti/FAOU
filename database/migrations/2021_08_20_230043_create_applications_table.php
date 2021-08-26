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
            $table->String("User_id");
            $table->String("Users_Access")->nullable();
            $table->char("seen",1)->default(0);
            $table->char("flag",1)->default(0);
            $table->char("incomplete",1)->default(0);
            $table->char("accepted",1)->default(0);
            $table->char("rejected",1)->default(0);
            $table->char("stars",1)->default(0);
            $table->char("new",1)->default(1);
            $table->char("interviewed",1)->default(0);
            $table->char('mailed',1)->default(0);
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
