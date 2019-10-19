<?php
require_once(__DIR__.'./../../../config.php');
//namespace migration;

class Connection
{
    var $connect;
    var $hostname;
    public function __construct()
    {
        $this->hostname=$host;
    }
}

$data = new Connection();
$data->hostname = $host;