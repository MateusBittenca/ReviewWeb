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
        Schema::table('reviews', function (Blueprint $table) {
            $table->text('private_feedback')->nullable()->after('comment');
            $table->enum('contact_preference', ['whatsapp', 'email', 'phone', 'no_contact'])->nullable()->after('private_feedback');
            $table->boolean('has_private_feedback')->default(false)->after('contact_preference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['private_feedback', 'contact_preference', 'has_private_feedback']);
        });
    }
};