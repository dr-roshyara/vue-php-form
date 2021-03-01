<?php

namespace DB;

use PDO;
use PDOException;
use RuntimeException;

class  DB{
    private $dbdriver ="";
    private $dbhost ="";
    private $dbuser ="";
    private $dbpass ="";
    private $dbname ="";
    private $dbh ;
    public $db ; 
    private $dberrors=[];
    private $dbstmt ; 
    public $connection;
    //
    /**
     * The PDO connection options.
     *
     * @var array
     */
    protected $options = [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES => false,
    ];

    public function __construct($configData){

      $this->connection =$this->connect($configData); 
    }
    /**
     * @connect the data base 
     * 
     */
    public function db_connect($conn)
    {
        try {
            $this->db = new PDO($conn, $this->dbuser, $this->dbpass, (array) $this->options);
        //$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$this->pdo->setAttribute($this->options);
        //echo "\n <br/> Connection with the database has been established."; 
        return $this->db;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            exit($this->error);
        }
    }

  private  function connect($configData){
        $this->dbdriver   =$configData['driver'];
        $this->dbhost     =$configData['host'];
        $this->dbuser     = $configData['user'];
        $this->dbpass     = $configData['pass'];
        $this->dbname     = $configData['dbname'];
       
       
        try{
            // create the connection prefex 
            switch($this->dbdriver){
                case  'mysql':
                $conn ="mysql:host ={$this->dbhost}; dbname={$this->dbname}";
                break; 
                default:
                throw new  RuntimeException('Dabase driver e.g. mysql  is not defined.');
            }

            return ($this->db_connect($conn));

        }catch(PDOException $e){
            $this->error = $e->getMessage();
            exit($this->error);
        }
   
    }
    // create table must be here 
    public function show_erros(){
        for  ($idx=0; $idx<count($this->dberrors); $idx++){
              echo "Error-".$idx.": ".$this->dberrors[$idx]. " \n";
        }
    }
   // public function closeConnection()
   //  {
   //      $this->db = null;
   //  } 
   public function __destruct()
    {
         if(count($this->dberrors)>0){
            $this->show_erros();
         }
        $this->dbh = NULL; // Setting the handler to NULL closes the connection propperly
    } 
}
?>