<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('gift_cards', function (Blueprint $table) {
            $table->unsignedBigInteger('download_count')->default(0)->after('font_size');
            $table->unsignedBigInteger('view_count')->default(0)->after('download_count');
        });
    }

    public function down()
    {
        Schema::table('gift_cards', function (Blueprint $table) {
            $table->dropColumn(['download_count', 'view_count']);
        });
    }
};
