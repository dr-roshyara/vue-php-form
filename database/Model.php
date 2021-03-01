<?php 
namespace Model; 

require("db.php");

use \DB\DB as DB;

//require('config.php');
Class Model {
	/***
	**
	**
	*/
	 private $table_name ="";
	 private $column_names=[];
	/** 
	**@var bool 
	* This variable is to determine if the table is created or not . 
	*/
	private $table_created =false;	
     /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection;
     protected $db;
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;
	/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
	 /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model exists.
     *
     * @var bool
     */
    public $exists = false;
	/**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';
    /**
    * @var string 
    * @statement 
    */
    private $stmt ="";
 
    // construct 
     function __construct($config,$table_created=true)
     { 
      
     	$this->db =new DB($config);
     	$this->table_created =$table_created;
     	echo "\n<br> Model is created."; 
     }
     
    // Prepare statement with query
    // prepare is the  built in pdo function 
	public function prepare_query($query) {
		//echo "\n<br>".$query;
		$this->stmt = $this->db->connection->prepare($query);
	}
	 
	 public function create_table($table_name,$table_query)
	 {
	 	 $this->table_name=$table_name;
	 	 if(!$this->table_created){
	 	 try{

	 	 	$this->db->connection->exec($table_query);
	 	 	echo "\n<br>Table has been created.";
	 	 }catch(PDOException $e){

	 	 }
	 	}else{
	 		echo "\n<br> Table has already been created!";
	 	}	
	}
	// Destruct function 
	 function __destruct(){
	 	echo "\n<br/>Model is destroyed";  
	 }
	 // execute a statement for db 
	 public function db_execute_data($data)
	 {
	 	 $data=(array)$data;
	 	if($this->stmt){
	 		try{
	 			//  echo "i Data";
	 			//  echo json_encode($data);  
	 			$this->stmt->execute($data);
	 			echo "\n your data has been inserted into the database.\n";
	 			// $this->stmt->commit();
			}catch (Exception $e)
			{
    			$this->stmt->rollback();
    			throw $e->getMessage();
			}	
	 	}
	 }
	 // execute statment 
	 // execute a statement for db 
	 public function db_execute_statement($statement)
	 {
	 	
	 		try{
	 			echo json_encode($data); 
	 			//$this->stmt->execute($data);
	 			$this->stmt = $this->db->connection->execute($query);
	 			// $this->stmt->commit();
			}catch (Exception $e)
			{
    			$this->db->connection->rollback();
    			throw $e->getMessage();
			}	
	 	
	 }
public function getColumnNames(){
        $sql = 'SHOW COLUMNS FROM ' . $this->table_name;
        
         $stmt= $this->db->connection->prepare($sql);
            
        try {    
            if($stmt->execute()){
                $raw_column_data = $stmt->fetchAll();
                
                foreach($raw_column_data as $outer_key => $array){
                    foreach($array as $inner_key => $value){
                            
                        if ($inner_key === 'Field'){
                                if (!(int)$inner_key){
                                    $this->column_names[] = $value;
                                }
                            }
                    }
                }        
            }
            return true;
        } catch (Exception $e){
                return $e->getMessage(); //return exception
        }        
    }


}
?>