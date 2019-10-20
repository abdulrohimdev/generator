<?php
require __DIR__."./../vendor/autoload.php";
require __DIR__."./../config.php";

use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection($config);
$capsule->setAsGlobal();
$capsule->bootEloquent();
?>