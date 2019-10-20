<?php
require "Bootstrap.php";
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class MyMigration extends Capsule
{
    public function createTable($tables,$callback)
    {   
        if (!$this->schema()->hasTable($tables)) {
            $this->schema()->create($tables,$callback);
            echo "\nCreate Table $tables was successfully";      
        }
        else
        {
            echo "\n$tables migration has been done or there is no migration.";
        }
    } 
    
    public function dropTable($tables)
    {
        if($this->schema()->dropIfExists($tables))
        {
            $this->schema()->drop($tables);
            echo "\nDrop Table $tables was successfully";  
     
        }
        else
        {
            echo "\n$tables There is no table deletion";
        }

    }
}

