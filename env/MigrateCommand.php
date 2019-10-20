<?php
namespace env;

class MigrateCommand
{
    var $path;
    protected $arguments;    
    protected $table;
    protected $file_migrate;
    protected $field_query ='';
    protected $message=false;
    public function make($argm)
    {
        error_reporting(0);
        if($argm[1] === false || $argm[1] === null)
        {
            $this->message = "\n Please Use Command like this : \n";
            $this->message .= "\n    php migrate table field:type_data";
            $this->message .= "\n    php migrate up {for migrate table to database}";
            $this->message .= "\n    php migrate down {for drop table from database}";
            $this->message .= "\n";
        }
        else if($argm[1] === 'up')
        {
            $this->upTable();
        }
        else if($argm[1] === 'down')
        {
            $this->downTable();
        }
        else
        {
            for($i=1; $i < count($argm); $i++)
            {
                if($i === 1)
                {
                    $this->file_migrate = ucwords($argm[$i]);
                    $this->table = $this->getPluralPrase($argm[$i],2);
                }
                else if($argm[$i] !== 'up' || $argm[$i] !== 'down')
                {
                    $data = explode(":",$argm[$i]);
                    $this->field($data[1],$data[0]);
                }
            }
            $this->write_code();    
        }
        return $this;
    }

    public function write_code()
    {
        $data  = "<?php\n";
        $data .= 'require_once __DIR__."./../env/MyMigration.php";';
        $data .= "\n\n";
        $data .= "class ".$this->file_migrate."Table extends MyMigration\n{";
        $data .= "\n  public function up()\n  {\n";
        $data .= '    $this->createTable(\''.$this->table.'\', function ($table) {';
        $data .= "\n";
        $data .= $this->field_query;
        $data .= "\n     \n    });\n\n  }";
        $data .= "\n\n  public function down()\n  {\n";    
        $data .= '     $this->dropTable(\''.$this->table.'\');';
        $data .="\n  }\n";
        $data .="\n}";

        $file = fopen($this->path."/".$this->file_migrate."Table.php","w");
        fwrite($file,$data);
        fclose($file);
        if(file_exists($this->path."/".$this->file_migrate."Table.php"))
        {
            $this->message = " \n Migration ".$this->path."/".$this->file_migrate."Table"." was created!\n";
        }
        else
        {
            $this->message = "\nError";
        }
 
    }


    public function field($type_data,$field)
    {
        switch($type_data)
        {
            case "primarykey":
                $this->write_id_primary($field);
            break;
            case "integer":
                $this->write_integer($field);
            break;
            case "integer_uniq":
                $this->write_integer($field,'unique');
            break;
            case "string":
                $this->write_string($field);
            break;
            case "string_uniq";
                $this->write_string($field,'unique');
            break;
            case "float":
                $this->write_float($field);
            break;
            case "date":
                $this->write_date($field,false);
            break;
            case "datetime":
                $this->write_date($field,true);
            break;
            case "text":
                $this->write_text($field);
            break;
            default:
                $this->write_enum($field,$type_data);
            break;
        }
        return $this;
    }

    public function write_id_primary($field)
    {
        $this->field_query .="\n";
        $this->field_query .= '      $table->increments(\''.$field.'\');'; 
        return $this;
    }

    public function write_text($field)
    {
        $this->field_query .="\n";
        $this->field_query .= '      $table->longText(\''.$field.'\');'; 
        return $this;
    }

    public function write_integer($field,$unique=false)
    {
        $this->field_query .="\n";
        if($unique === 'unique')
        {
            $this->field_query .= '      $table->integer(\''.$field.'\')->unique();';             
        }
        else
        {
            $this->field_query .= '      $table->integer(\''.$field.'\');'; 
        }
        return $this;
    }

    public function write_float($field)
    {
        $this->field_query .="\n";
        $this->field_query .= '      $table->float(\''.$field.'\',8,2);';
        return $this;
    }

    public function write_string($field,$unique=false)
    {
        $this->field_query .="\n";
        if($unique === 'unique')
        {
            $this->field_query .= '      $table->string(\''.$field.'\')->unique();';             
        }
        else
        {
            $this->field_query .= '      $table->string(\''.$field.'\');'; 
        }
        return $this;
    }

    public function write_date($field,$datetime=false)
    {
        $this->field_query .="\n";
        if($datetime === false)
        {
            $this->field_query .= '      $table->date(\''.$field.'\');';             
        }
        else
        {
            $this->field_query .= '      $table->dateTime(\''.$field.'\');'; 
        }
        return $this;
    }

    public function write_enum($field,$data)
    {
        $data   = explode("_",$data);
        $option = $data[1];
        $this->field_query .="\n";
        $this->field_query .= '      $table->enum(\''.$field.'\',';
        $this->field_query .= $option;
        $this->field_query .= ");";
        return $this;
    }

    public function upTable()
    {
        $scan   = scandir($this->path,1);
        $length = count($scan)-2;
        for($i=0; $i < $length; $i++)
        {
            $this->createTable($scan[$i]);
        }
        return $this;
    }

    public function createTable($file)
    {
        require_once(__DIR__."./../migration/".$file);
        $cut_str        = explode(".",$file);
        $_class_name    = $cut_str[0];
        $exec           = new $_class_name();
        $exec->up();
    }

    public function downTable()
    {
        $scan   = scandir($this->path,1);
        $length = count($scan)-2;
        for($i=0; $i < $length; $i++)
        {
            $this->dropTable($scan[$i]);
        }
        return $this;
    }

    public function dropTable($file)
    {
        require_once(__DIR__."./../migration/".$file);
        $cut_str        = explode(".",$file);
        $_class_name    = $cut_str[0];
        $exec           = new $_class_name();
        $exec->down();
    }


    public function getPluralPrase($phrase,$value){
        $plural='';
        if($value>1){
            for($i=0;$i<strlen($phrase);$i++){
                if($i==strlen($phrase)-1){
                    $plural.=($phrase[$i]=='y')? 'ies':(($phrase[$i]=='s'|| $phrase[$i]=='x' || $phrase[$i]=='z' || $phrase[$i]=='ch' || $phrase[$i]=='sh')? $phrase[$i].'es' :$phrase[$i].'s');
                }else{
                    $plural.=$phrase[$i];
                }
            }
            return $plural;
        }
        return $phrase;
    }


    public function exec()
    {   
        if($this->message)
        {
            echo $this->message;
        }
    }
}