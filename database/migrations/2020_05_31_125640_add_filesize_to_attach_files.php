<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilesizeToAttachFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attach_files', function (Blueprint $table) {
            $table->double("size")->nullable()->default(0)->after('originalname');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attach_files', function (Blueprint $table) {
            $table->double("size");
        });
    }
}