<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSouscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('souscriptions', function (Blueprint $table) {
            $table->id();
			$table->string('titre')->unique();
			$table->text('description')->nullable();
			$table->json('img_urls')->nullable();
			$table->integer('periode');
			$table->integer('prix');
			$table->json('attributs')->nullable(); //{"posts_par_mois","images_par_post"}
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
        Schema::dropIfExists('souscriptions');
    }
}
