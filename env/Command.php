<?php
namespace env;

class Command
{
    var $length;
    var $generate_type;
    var $file;
    var $message=false;
    var $path;
    protected $method;
    protected $argm;
    protected $resource;
    public function make($arg)
    {
        error_reporting(0);
        $this->length = count($arg)-1;
        if($arg[1])
        {
            $data = explode(":",$arg[1]);
            $this->generate_type = $data[0];
            $this->file = $data[1];
            if(count($arg) > 2)
            {
                $this->argm = $arg;
                if($arg[2] === 'resource')
                {
                    $this->_creator_model_resource();
                }
                else
                {
                    $this->__creator_method();
                }
            }

            $this->writeFile($this->generate_type);
        }
        else{
            $this->message = "\n  Please use command like this:\n";
            $this->message .= "    php new controller:FileController more_your_method\n";
            $this->message .= "    php new model:FileModel more_your_method\n";
            $this->message .= "    php new model:FileModel resource\n";
            $this->message .= "    php new view:FileView\n";
            $this->message .= "    php new view:folder.subfolder.fileview\n";
            $this->message .= "    php runserver\n";
   }
        return $this;
    }

    public function writeFile($generate_type)
    {
        switch($generate_type){
            case "controller":
                $this->generateController();
            break;
            case "model":
                $this->generateModel();
            break;
            case "view":
                $this->generateView();
            break;
            default:
                $this->message = "\n  Please use command like this:\n";
                $this->message .= "    php new controller:FileController more_your_method\n";
                $this->message .= "    php new model:FileModel more_your_method\n";
                $this->message .= "    php new model:FileModel resource\n";
                $this->message .= "    php new view:FileView\n";
                $this->message .= "    php new view:folder.subfolder.fileview\n";
                $this->message .= "    php runserver\n";
            break;
        }
        return $this;
    }

    public function __creator_method()
    {
        $data ="";
        for($i=2; $i < $this->length+1; $i++)
        {
            $data .= "\n	public function ".$this->argm[$i]."()\n";
            $data .= "	{\n";
            $data .= "		//Your Code\n";
            $data .= "	}\n\n";
        }
		$this->method = $data;
    }

    public function generateController()
    {
        $file  = ucwords($this->file);
        $data  = "<?php\ndefined('BASEPATH') OR exit('No direct script access allowed');";
		$data .= "\n\nclass ".ucwords($this->getPluralPrase($this->file,2))." extends CI_Controller \n{";
		$data .= "\n	public function __construct()\n";
		$data .= "	{\n";
		$data .= "		parent::__construct();\n";
        $data .= "	}\n";
        if($this->method)
        {
            $data .= $this->method;
        }
        else
        {
            $data .= "\n	public function index()\n";
            $data .= "	{\n";
            $data .= "		//Your Code\n";
            $data .= "	}\n\n";
        }

        $data .= "}";
        $path = $this->path."/controllers/".ucwords($this->getPluralPrase($this->file,2)).".php";
        if(file_exists($path))
        {
            $this->message = "Error: File ". ucwords($this->getPluralPrase($this->file,2)) ." Controller already exists";
        }
        else
        {
            $file = fopen($path,"w");
            fwrite($file,$data);
            fclose($file);    
        }
    }

    public function generateModel()
    {
        $file  = ucwords($this->file);
        $data  = "<?php\nerror_reporting(0);\ndefined('BASEPATH') OR exit('No direct script access allowed');";
		$data .= "\n\nclass ".ucwords($this->file)." extends CI_Model \n{";
        $data .= "\n";
        if($this->argm[2] === 'resource')
        {
            $data .= $this->resource;
        }
        else
        {
            if($this->method)
            {
                $data .= $this->method;
            }
        }
        $data .= "}";
        $path = $this->path."/models/".ucwords($this->file).".php";
        if(file_exists($path))
        {
            $this->message = "\n  Error: File ". ucwords($this->file) ." Model already exists\n";
        }
        else
        {
            $file = fopen($path,"w");
            fwrite($file,$data);
            fclose($file);
            $data_load ="\n";
            $data_load .= '$autoload[\'model\'][]=\''.ucwords($this->file).'\';';
            $linked=fopen($this->path."/config/autoload.php","a");
            fwrite($linked,$data_load);
            fclose($linked);
        }
    }

    public function generateView()
    {
        $data  = "This your file views";
        $path  = $this->path."/views/";
        $path_file  = str_replace(".","/",$this->file);
        $check_path = $path.$path_file.".php";
        if(file_exists($check_path))
        {
            $this->message = "\n  Error: File $check_path already exists\n";
        }
        else
        {
            $folder = explode(".",$this->file);
            $folder_path ="";
            for($i=0; $i<count($folder)-1; $i++)
            {
                $folder_path .= $folder[$i]."/";
            }

            if($folder_path)
            {
                $length = count($folder)-1;
                mkdir($path.$folder_path,0777,true);
                $create_path = $path.$folder_path.$folder[$length].".php";
            }
            else
            {
                $create_path = $path.$this->file.".php";
            }

            $file = fopen($create_path,"w");
            fwrite($file,$data);
            fclose($file);
            if(file_exists($create_path))
            {
                $this->message = " \n View $create_path was created!\n";
            }
            else
            {
                $this->message = "\nError: view can not to created, please use:\n   php new view:page \n   or\n   php new view:page.index\n";
            }
        
        }
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
    

    public function _creator_model_resource()
    {
        $data = "\n";
        $data .= '    protected $table=\''.$this->getPluralPrase($this->file,2).'\';';        
        $data .= "\n";
        $data .= '    protected $primaryKey=\'id\';';
        $data .= "\n";
        $data .= '    public $data;';        
        $data .= "\n\n";
        $data .= "    public function all()\n";        
        $data .= "    {\n";        
        $data .= '         $this->data = $this->db->get($this->table)->result();';        
        $data .= "\n";
        $data .= '         return $this;';
        $data .= "\n    }";
        $data .= "\n\n";
        $data .= '    public function find($id)';
        $data .= "\n";        
        $data .= "    {\n";        
        $data .= '         $this->data = $this->db->get_where($this->table,[$this->primaryKey => $id])->row();';        
        $data .= "\n";
        $data .= '         return $this;';
        $data .= "\n    }";
        $data .= "\n\n";
        $this->resource = $data;
        $data .= '    public function where($condition)';
        $data .= "\n";        
        $data .= "    {\n";        
        $data .= '         return $this->db->where($condition)->get($this->table)->row();';        
        $data .= "\n    }";
        $data .= "\n\n";
        $data .= '    public function save()';
        $data .= "\n";        
        $data .= "    {\n";        
        $data .= '         $result = $this->db->insert($this->table,$this->data);';        
        $data .= "\n";
        $data .= '         return $result;';
        $data .= "\n    }";
        $data .= "\n\n";
        $data .= '    public function delete()';
        $data .= "\n";        
        $data .= "    {\n";        
        $data .= '         $result = $this->db->where($this->primaryKey,$this->data->id)->delete($this->table);';        
        $data .= "\n";
        $data .= '         return $result;';
        $data .= "\n    }";
        $data .= "\n\n";
        $data .= '    public function update()';
        $data .= "\n";        
        $data .= "    {\n";        
        $data .= '         $result = $this->db->where($this->primaryKey,$this->data->id)->update($this->table,$this->data);';        
        $data .= "\n";
        $data .= '         return $result;';
        $data .= "\n    }";
        $data .= "\n\n";
        $data .= '    public function query($query)';
        $data .= "\n";        
        $data .= "    {\n";        
        $data .= '         $result = $this->db->query($query);';        
        $data .= "\n";
        $data .= '         return $result;';
        $data .= "\n    }";
        $data .= "\n\n";

        $this->resource = $data;
        return $this;
    }

    public function exec()
    {
        if($this->message === false)
        {
            echo ucwords($this->generate_type)." ".ucwords($this->file)." was created!\n";
        }
        else
        {
            echo $this->message;
        }
    }
}

?>