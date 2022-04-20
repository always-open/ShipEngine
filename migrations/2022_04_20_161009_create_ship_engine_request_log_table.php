<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipEngineRequestLogTable extends Migration
{
    public function up()
    {
        Schema::create(config('shipengine.request_log_table_name'), function (Blueprint $table) {
            $table->id();
            // Will store the relative path of the request (e.g. /addresses/validate)
            $table->string('path', 191)
                ->index();
            // What parameters were passed in (e.g. carrier_code=ups_ground)
            $table->string('params')
                ->fulltext();
            // HTTP method (e.g. POST/PUT/DELETE)
            $table->string('http_method', 10)
                ->index();
            // Status code (e.g. 200, 204, 429)
            $table->smallInteger('response_code', autoIncrement: false, unsigned: true)
                ->nullable()
                ->index();
            // The entire JSON encoded payload of the request
            $table->json('body')
                ->nullable();
            // The entire JSON encoded responses
            $table->json('response')
                ->nullable();
            $table->string('exception')
                ->nullable();
            // When the request was resolved to the millisecond
            $table->timestamp('occurred_at', 3)->index();
            $table->timestamps(precision: 3);
        });
    }

    public function down()
    {
        Schema::drop(config('shipengine.request_table_name'));
    }
}
