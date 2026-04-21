<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('crm_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('due_at')->nullable()->index();
            $table->enum('status', [
                'pending',
                'in_progress',
                'done',
                'cancelled',
            ])->default('pending')->index();
            $table->foreignId('assignee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->nullableMorphs('related'); // related_type + related_id
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crm_tasks');
    }
};
