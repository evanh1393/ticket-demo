<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->text('description');
            $table->string('priority');
            $table->string('department');
            $table->unsignedBigInteger('location_id');
            $table->string('display_id')->unique();
            $table->string('category');
            $table->string('sub_category')->nullable();
            $table->bigInteger('assigned_to')->nullable()->unsigned();
            $table->string('status');
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
