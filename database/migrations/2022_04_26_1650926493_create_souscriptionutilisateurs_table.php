<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSouscriptionUtilisateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('souscription_utilisateurs', function (Blueprint $table) {
            $table->id();
			$table->string('paiement_id')->nullable();
			$table->foreignId('souscription_id')
			->constrained()
			->onDelete('cascade');
			$table->foreignId('utilisateur_id')
			->constrained()
			->onDelete('cascade');
			$table->integer('prix');
			$table->integer('quantite')->default(1);
			$table->enum('status', ['en-attente','paye', 'annule'])->default('en-attente');
			$table->string('mode_paiement');
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
        Schema::dropIfExists('souscription_utilisateurs');
    }
}
