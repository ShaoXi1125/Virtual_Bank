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
        Schema::create('online_banking_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id'); // 外键，指向 clients 表
            $table->string('username')->unique(); // 登录用户名
            $table->string('password'); // 登录密码
            $table->enum('status', ['active', 'inactive'])->default('active'); // 账户状态（启用/禁用）
            $table->timestamp('last_login')->nullable(); // 最后登录时间
            $table->timestamps();

            // 外键约束，确保每个在线银行账户都有对应的客户端
            $table->foreign('client_id')->references('client_id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_banking_accounts');
    }
};
