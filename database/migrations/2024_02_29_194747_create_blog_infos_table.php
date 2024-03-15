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
        Schema::create('blog_infos', function (Blueprint $table) {
            $table->id();
            $table->string('blogs_title', 100)->nullable();
            $table->string('blogs_category', 50)->nullable();
            $table->string('blogs_content', 1000)->nullable();
            $table->string('blogs_image', 1000)->nullable()->default('https://img.freepik.com/free-photo/ai-technology-microchip-background-digital-transformation-concept_53876-124669.jpg?t=st=1709131730~exp=1709135330~hmac=2743fb1c835e5b84bb0ca50de5753e8a297ce79a9228f6f3e723cb755df8c83e&w=1380');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_infos');
    }
};
