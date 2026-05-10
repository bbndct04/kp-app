<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('complainant_contact')->nullable()->after('complainant_formal_name');
            $table->string('complainant_address')->nullable()->after('complainant_contact');
            $table->string('other_category')->nullable()->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn([
                'complainant_contact',
                'complainant_address',
                'other_category',
            ]);
        });
    }
};