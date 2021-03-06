<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateComponentsAndStorageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('components', function (Blueprint $table) {
            $table->renameColumn('ID', 'id');
            $table->integer('storage_id')->after('id')->unsigned();
            $table->renameColumn('Description', 'name');
            $table->renameColumn('Type', 'subcategory');
            $table->renameColumn('Category', 'category');
            $table->renameColumn('Stock', 'stock');
            $table->renameColumn('text', 'description');
            $table->timestamps();
        });

        Schema::table('components', function (Blueprint $table) {
            $table->string('name')->change();
            $table->string('subcategory')->nullable()->change();
            $table->string('package')->nullable()->change();
            $table->string('category')->change();
            $table->integer('imported_id')->nullable()->change();
            $table->string('supplier')->nullable()->change();
            $table->string('description')->nullable()->change();
            $table->string('datasheet')->nullable()->change();
        });

        Schema::table('storage', function (Blueprint $table) {
            $table->renameColumn('ID', 'id');
            $table->renameColumn('Name', 'name');
            $table->renameColumn('Date', 'created_at');
            $table->timestamp('updated_at')->nullable();
        });
        
        $components = DB::table('components')->select('id', 'storage_id', 'storage')->get();

        foreach($components as $component) {
            if(DB::table('storage')->where('name', $component->storage)->exists()) 
            {
                $storage = DB::table('storage')->select('id')->where('name', $component->storage)->get();
    
                DB::table('components')->where('id', $component->id)->update(['storage_id' => $storage[0]->id]);
            }
        }

        Schema::table('components', function (Blueprint $table) {
            $table->dropColumn('storage');
        });

        Schema::table('storage', function (Blueprint $table) {
            $table->string('name')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('components', function (Blueprint $table) {
            $table->renameColumn('id', 'ID');
            $table->string('storage')->after('id');
            $table->renameColumn('description', 'text');
            $table->renameColumn('name', 'Description');
            $table->renameColumn('subcategory', 'Type');
            $table->renameColumn('category', 'Category');
            $table->renameColumn('stock', 'Stock');
            $table->dropTimestamps();
        });

        Schema::table('storage', function (Blueprint $table) {
            $table->renameColumn('id', 'ID');
            $table->renameColumn('name', 'Name');
            $table->renameColumn('created_at', 'Date');
            $table->dropColumn('updated_at');
        });

        $components = DB::table('components')->select('id', 'storage_id', 'storage')->get();

        foreach($components as $component) {
            if(DB::table('storage')->where('id', $component->storage_id)->exists()) 
            {
                $storage = DB::table('storage')->select('name')->where('id', $component->storage_id)->get();
    
                DB::table('components')->where('id', $component->id)->update(['storage' => $storage[0]->name]);
            }
        }

        Schema::table('components', function (Blueprint $table) {
            $table->dropColumn('storage_id');
        });
    }
}
