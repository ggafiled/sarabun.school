<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_no');
            $table->string('title');
            $table->string('source');
            $table->string('destination');
            $table->string('note');
            $table->integer('document_type_id')->unsigned();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('attach_file_id')->unsigned();
            $table->timestamps();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->foreign('document_type_id')
                  ->references('id')
                  ->on('document_types')
                  ->onDelete('cascade');
            $table->foreign('attach_file_id')
                  ->references('id')
                  ->on('attach_files')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}