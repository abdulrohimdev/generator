<?php
    namespace env;
    class server
    {
        var $host;
        var $port;
        
        public function run()
        {
            if($this->host === '' || $this->host === false)
            {
                $this->host = "localhost";
            }

            if($this->port === '' || $this->port === false )
            {
                $this->port = "4500";
            }
            
            $message = "Your Project development server started: http://$this->host:$this->port \r\n";
            echo $message;
            system("cd ../ && php -S $this->host:$this->port/");
        }
    }
?>