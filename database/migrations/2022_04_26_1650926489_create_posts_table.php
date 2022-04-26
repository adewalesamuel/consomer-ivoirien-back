<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
			$table->string('titre');
			$table->longText('description')->nullable();
			$table->json('attributs')->nullable(); //{"ville", "pays", "dimension", "marque",...} 
			$table->integer('prix');
			$table->json('img_urls')->nullable();
			$table->foreignId('categorie_id')
			->constrained()
			->onDelete('cascade');
			$table->foreignId('utilisateur_id')
			->constrained()
			->onDelete('cascade');
			$table->date('promotion_end_date')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
