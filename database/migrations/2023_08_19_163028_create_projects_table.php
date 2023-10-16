<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250);
            $table->string('subtitle', 250);
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->time('duration')->nullable();
            $table->string('status', 50)->nullable();
            $table->integer('participants_count')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
}

