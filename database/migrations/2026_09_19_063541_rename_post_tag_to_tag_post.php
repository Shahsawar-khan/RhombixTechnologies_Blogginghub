<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('post_tag', 'tag_post');
    }

    public function down(): void
    {
        Schema::rename('tag_post', 'post_tag');
    }
};