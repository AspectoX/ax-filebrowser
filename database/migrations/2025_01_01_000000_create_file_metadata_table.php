<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('file_metadata', function (Blueprint $table) {
            $table->id();
            $table->string('file_path');          // URL externa o ruta relativa uploads/...
            $table->string('original_name');
            $table->string('folder')->default(''); // carpeta donde fue subido
            $table->string('type')->default('otro');
            $table->boolean('is_external')->default(false);
            $table->date('fecha_archivo')->nullable();
            $table->string('autor')->nullable();
            $table->string('credito_url', 500)->nullable();
            $table->text('epigrafe')->nullable();
            $table->string('tags', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('file_metadata');
    }
};
