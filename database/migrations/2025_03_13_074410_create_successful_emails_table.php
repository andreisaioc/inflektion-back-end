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
        Schema::create('successful_emails', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('affiliate_id')->nullable();
            $table->text('envelope')->nullable();
            $table->string('from')->nullable();
            $table->text('subject')->nullable();
            $table->string('dkim')->nullable();
            $table->string('SPF')->nullable();
            $table->float('spam_score')->nullable();
            $table->longText('email');
            $table->longText('raw_text')->nullable();
            $table->string('sender_ip')->nullable();
            $table->text('to')->nullable();
            $table->integer('timestamp')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Enables soft delete functionality

            $table->index('affiliate_id', 'affiliate_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('successful_emails');
    }
};
