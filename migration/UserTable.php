<?php
require_once __DIR__."./../env/MyMigration.php";

class UserTable extends MyMigration
{
  public function up()
  {
    $this->createTable('users', function ($table) {

      $table->increments('id');
      $table->string('username')->unique();
      $table->string('password');
      $table->string('email')->unique();
      $table->enum('role',['admin','user']);

     
    });

  }

  public function down()
  {
     $this->dropTable('users');
  }

}