<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            if (!Schema::hasColumn('todos', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('id')
                    ->constrained()
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('todos', 'content')) {
                $table->string('content')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('todos', 'limit_date')) {
                $table->date('limit_date')->nullable()->after('content');
            }

            if (!Schema::hasColumn('todos', 'state')) {
                $table->string('state')->nullable()->after('limit_date');
            }

            if (!Schema::hasColumn('todos', 'created_process')) {
                $table->string('created_process')->nullable()->after('state');
            }

            if (!Schema::hasColumn('todos', 'updated_process')) {
                $table->string('updated_process')->nullable()->after('created_process');
            }
        });
    }

    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            if (Schema::hasColumn('todos', 'updated_process')) {
                $table->dropColumn('updated_process');
            }
            if (Schema::hasColumn('todos', 'created_process')) {
                $table->dropColumn('created_process');
            }
            if (Schema::hasColumn('todos', 'state')) {
                $table->dropColumn('state');
            }
            if (Schema::hasColumn('todos', 'limit_date')) {
                $table->dropColumn('limit_date');
            }
            if (Schema::hasColumn('todos', 'content')) {
                $table->dropColumn('content');
            }
            if (Schema::hasColumn('todos', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};

