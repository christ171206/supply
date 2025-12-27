<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'photo_profil')) {
                $table->string('photo_profil')->nullable();
            }
            if (!Schema::hasColumn('users', 'derniere_activite')) {
                $table->timestamp('derniere_activite')->nullable();
            }
            if (!Schema::hasColumn('users', 'boutique_nom')) {
                $table->string('boutique_nom')->nullable();
            }
            if (!Schema::hasColumn('users', 'telephone')) {
                $table->string('telephone')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['photo_profil', 'derniere_activite', 'boutique_nom', 'telephone']);
        });
    }
};