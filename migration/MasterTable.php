<?php
require_once __DIR__."./../env/MyMigration.php";

class MasterTable extends MyMigration
{
  public function up()
  {
    $this->createTable('masters', function ($table) {
      $table->bigIncrements('id');
      $table->string('employee_id')->unique();
      $table->string('fullname');
      $table->string('company');
      $table->string('department');
      $table->integer('stock_ticket');
      $table->enum('actual_presence',['0','1']);
      $table->integer('lunch');
      $table->integer('photobooth');
      $table->timestamps();

    });

  }

  public function down()
  {
     $this->dropTable('masters');
  }

}