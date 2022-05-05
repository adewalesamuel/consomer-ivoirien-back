<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilisateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
			$table->string('nom_prenoms');
			$table->string('email')->unique();
			$table->string('password');
			$table->string('adresse')->nullable();
			$table->string('ville')->nullable();
			$table->string('pays')->nullable();
			$table->string('telephone')->nullable();
            $table->string('api_token')->unique()->nullable();
			$table->string('img_url')->nullable();
			$table->enum('status', ['valide','suspendu', 'en-attente'])->default('en-attente');
			$table->timestamp('email_verified_at')->nullable();
			$table->rememberToken();
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
        Schema::dropIfExists('utilisateurs');
    }
}
