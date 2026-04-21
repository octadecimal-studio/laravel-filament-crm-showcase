<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('stage', [
                'new',
                'discovery',
                'proposal',
                'negotiation',
                'won',
                'lost',
            ])->default('new')->index();
            $table->decimal('amount', 12, 2)->default(0);
            $table->char('currency', 3)->default('PLN');
            $table->date('close_date')->nullable();
            $table->foreignId('contact_id')->nullable()->constrained('contacts')->nullOnDelete();
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->unsignedTinyInteger('probability')->default(0); // 0-100
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('close_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
