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
        Schema::create('about_page_infos', function (Blueprint $table) {
            $table->id();
            $table->string('about_page_title', 50)->nullable();
            $table->string('about_page_banner', 256)->nullable()->default('https://img.freepik.com/free-photo/choosing-right-strategy_1098-1823.jpg?w=1380&t=st=1709131358~exp=1709131958~hmac=d98bd0e0898b58d33583263efa9819fefd39e6326334c20c4ec4b2060d8914d6');
            $table->string('about_company_history', 1000)->nullable();
            $table->string('about_company_vision', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_page_infos');
    }
};
