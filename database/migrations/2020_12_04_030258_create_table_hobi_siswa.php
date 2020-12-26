<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHobiSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hobi_siswa', function (Blueprint $table) {
            // Create tabel hobi_siswa
            $table->integer('id_siswa')->unsigned()->index();
            $table->integer('id_hobi')->unsigned()->index();

            //SET FK
            $table->primary(['id_siswa', 'id_hobi']);

            // SET FK hobi_siswa --- siswa
            $table->foreign('id_siswa')
                ->reference('id')
                ->on('siswa')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // SET FK hobi_siswa --- hobi
            $table->foreign('id_hobi')
                ->reference('id')
                ->on('hobi')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('hobi_siswa');
    }
}
