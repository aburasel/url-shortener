<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('urls', function (Blueprint $table) {
            $table->id();
            $table->string('short_url',64);
            $table->string('long_url',255);
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->integer('visit_count')->default(0);
            $table->timestamp('time')->useCurrent();
            $table->unique(['user_id','long_url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urls');
    }
};
