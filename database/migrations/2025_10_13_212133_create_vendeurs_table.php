<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vendeurs', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('cni')->nullable();
            $table->string('photoProfil')->nullable();
            $table->foreign('id')->references('id')->on('utilisateurs')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('vendeurs');
    }
};
