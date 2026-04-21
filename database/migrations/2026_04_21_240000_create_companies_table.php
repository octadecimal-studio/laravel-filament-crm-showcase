<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('domain')->nullable()->index();
            $table->string('industry')->nullable();
            $table->string('size')->nullable(); // 1-10, 11-50, 51-200, 201-500, 500+
            $table->string('country', 2)->nullable(); // ISO 3166-1 alpha-2
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
