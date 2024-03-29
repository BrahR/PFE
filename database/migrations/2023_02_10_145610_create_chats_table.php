<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string("message");
            $table->timestamp("sent_at");
            $table->boolean("is_attached")->default(false);

            $table->foreignId("user_id")->constrained();
            $table->foreignId("task_id")->nullable()->constrained();
            $table->foreignId("phase_id")->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('chats');
    }
};
