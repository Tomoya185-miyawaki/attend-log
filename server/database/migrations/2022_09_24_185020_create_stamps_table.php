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
        Schema::create('stamps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->tinyInteger('status')->comment('ステータス');
            $table->dateTime('stamp_start_date')->comment('打刻時間（開始）');
            $table->dateTime('stamp_end_date')->comment('打刻時間（終了）')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stamps');
    }
};
