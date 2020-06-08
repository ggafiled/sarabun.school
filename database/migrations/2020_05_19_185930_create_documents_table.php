<?php

use App\Enums\DocumentType;
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
            $table->integer('run_no')->unsigned()->default(0)->index();
            $table->string('document_no')->nullable();
            $table->string('title')->nullable();
            $table->string('source')->nullable();
            $table->string('destination')->nullable();
            $table->string('note')->nullable();
            $table->integer('document_type_id')->unsigned()->nullable()->default(DocumentType::Confused);
            $table->integer('user_id')->unsigned()->index();
            $table->date("document_created_at")->nullable();
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
        Schema::dropIfExists('documents');
    }
}