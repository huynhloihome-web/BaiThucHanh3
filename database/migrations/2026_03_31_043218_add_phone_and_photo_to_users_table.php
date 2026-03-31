<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Thêm cột phone (tối đa 10 số, có thể null)
            $table->string('phone', 10)->nullable()->after('email');
            // Thêm cột photo (lưu tên file ảnh)
            $table->string('photo')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Xóa 2 cột nếu rollback
            $table->dropColumn(['phone', 'photo']);
        });
    }
};