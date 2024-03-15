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
        Schema::create('blog_page_infos', function (Blueprint $table) {
            $table->id();
            $table->string('blogs_page_title', 50)->nullable();
            $table->string('blogs_page_banner', 300)->nullable()->default('https://img.freepik.com/free-photo/social-media-networking-online-communication-connect-concept_53876-124862.jpg?t=st=1709131525~exp=1709135125~hmac=d7ea766e74958099648f0638a8fd6ecc989cd1615fbea268e373908c4370bcc2&w=1060');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_page_infos');
    }
};
