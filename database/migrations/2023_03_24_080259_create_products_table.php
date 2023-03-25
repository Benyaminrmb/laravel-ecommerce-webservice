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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->longText('describe')->nullable()->comment('we can store markdown description in this field.');
            $table->decimal('price', 8, 2)->unsigned();
            $table->integer('quantity')->unsigned()->comment('The current stock quantity for each product.');
            $table->boolean('featured')->default(false)->comment('A boolean value indicating whether the product should be displayed prominently on the website or not.');

            $table->softDeletes();
            $table->timestamps();
            $table->comment('Products table.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
