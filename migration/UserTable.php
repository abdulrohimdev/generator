<?php
require_once __DIR__."./../env/MyMigration.php";

class UserTable extends MyMigration
{
  public function up()
  {
    $this->createTable('users', function ($table) {

      $table->bigIncrements('id');
      $table->string('name');
      $table->string('username')->unique();
      $table->string('password');
      $table->enum('role',['admin','user']);
      $table->timestamps();
     
    });

  }

  public function down()
  {
     $this->dropTable('users');
  }

}