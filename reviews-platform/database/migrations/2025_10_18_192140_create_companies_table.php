<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('token')->unique();
            $table->string('logo')->nullable();
            $table->string('background_image')->nullable();
            $table->string('negative_email');
            $table->string('contact_number')->nullable();
            $table->string('business_website')->nullable();
            $table->text('business_address')->nullable();
            $table->string('google_business_url')->nullable();
            $table->integer('positive_score')->default(4);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
