<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('source')->nullable()->change();
            $table->string('author')->nullable()->change();
            $table->text('url')->nullable();
            $table->text('url_to_image')->nullable();
        });
    }
};
