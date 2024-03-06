<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->boolean('is_thumbnail')->default(false); // Adds a new column to indicate if the image is a thumbnail
        });

    }
    

    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('is_thumbnail'); // Removes the 'is_thumbnail' column
        });
    
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['thumbnail_image_id']); // Removes the foreign key constraint
            $table->dropColumn('thumbnail_image_id'); // Removes the 'thumbnail_image_id' column
        });
    }
    
};
