<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicites', function (Blueprint $table) {
            $table->id();
			$table->string('titre');
			$table->text('description')->nullable();
			$table->enum('type', ['acceuil-1','post-1', 'popup']);
			$table->json('img_urls')->nullable();
			$table->string('redirect_url')->nullable();
			$table->date('date_debut');
			$table->date('date_fin');
			$table->enum('status', ['en-attente','valide', 'suspendu'])->default('en-attente');
			$table->softDeletes();
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
        Schema::dropIfExists('publicites');
    }
}
