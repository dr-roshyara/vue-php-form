<?php 
class Querry{
 /*** 
** Has the table been created ? 
**Answer : Yes 
***@var $table_created =true;
**
**/
public $table_created =true; 
/*** 
*** create a new member 
*** var : member 
**/   
   public $table_name="";
   public $col_names1=[];
   private $col_names =[];
   public $sql_create_table="";
   public $sql_prepare_member="";
   public $sql_insert_member="";
   
    function __construct($inputData)
    {
        
        $this->col_names=array_keys($inputData);
       $this->table_name="cpnmember4";
       // $this->table_name="test";
      
        if(!$this->table_created){
             if(count($this->col_names)<25){
            exit("There are not enough columns while create a table");
        }
            $this->sql_create_table ="CREATE TABLE ". $this->table_name." ( 
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ".
            $this->col_names[0]." VARCHAR(30) NOT NULL, ".
            $this->col_names[1]." VARCHAR(30) NOT NULL, ".
            $this->col_names[2]." VARCHAR(30), ".   
            $this->col_names[3]." VARCHAR(30), ".
            $this->col_names[4]." VARCHAR(50), ".
            $this->col_names[5]." VARCHAR(30), ".
            $this->col_names[6]." VARCHAR(30) NOT NULL, ".
            $this->col_names[7]." VARCHAR(30) NOT NULL, ".
            $this->col_names[8]." VARCHAR(15) NOT NULL, ". 
            $this->col_names[9]." VARCHAR(30)  NULL, ".
            $this->col_names[10]." VARCHAR(100) NOT NULL, ". 
            $this->col_names[11]." VARCHAR(100)  NULL, ".
            $this->col_names[12]." VARCHAR(30) NOT NULL, ".
            $this->col_names[13]." VARCHAR(30) NOT NULL, ".
            $this->col_names[14]." VARCHAR(30) NOT NULL, ". 
            $this->col_names[15]." VARCHAR(30) NOT NULL, ". 
            $this->col_names[16]." VARCHAR(30) NOT NULL, ". 
            $this->col_names[17]." VARCHAR(30) NOT NULL, ".
            $this->col_names[18]." VARCHAR(30) NOT NULL, ".
            $this->col_names[19]." VARCHAR(30) NOT NULL, ".
            $this->col_names[20]." VARCHAR(2000) NOT NULL, ".
            $this->col_names[21]." VARCHAR(2000) NOT NULL, ".
            $this->col_names[22]." VARCHAR(2000)  NULL, ".
            $this->col_names[23]." VARCHAR(1000) NOT NULL, ".
            $this->col_names[24]." BOOLEAN   NOT NULL, " . 
            "english_dob DATE  NULL, ". 
        "english_first_mebmer_date DATE NULL, ".
        "english_last_mebmer_date DATE NULL, ".
        "english_last_valid_until DATE NULL, ".
        "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, ".
        "updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ".
         ");";
        }  
        // create  prepare for insert member  
        $this->sql_prepare_member = "INSERT INTO ".$this->table_name."(";
            for ($idx=0; $idx<(count($this->col_names)-1); $idx++)
            {
                $this->sql_prepare_member .=$this->col_names[$idx].", ";
            }
        $this->sql_prepare_member .=$this->col_names[count($this->col_names)-1]. ")";
            $this->sql_prepare_member.="VALUES(";
            for ($idx=0; $idx<(count($this->col_names)-1); $idx++){
                $this->sql_prepare_member .=":".$this->col_names[$idx].", ";
              }  
            $this->sql_prepare_member .=":".$this->col_names[count($this->col_names)-1]. ")";
        //insert_member query
         echo $this->sql_prepare_member;  
         //
                 // create  prepare for insert member  
        $this->sql_insert_member = $this->insert_member_stmt($inputData);  



    } //end of querry construct funtion 
    
    protected function insert_member_stmt($inputData)
    {
          $col_names=array_keys($inputData);
          // $col_names=(aray)$col_names;
        $insert_stmt="INSERT INTO ".$this->table_name."(";
            for ($idx=0; $idx<(count($col_names)-1); $idx++)
            {
                $insert_stmt .=$col_names[$idx].", ";
            }
        $insert_stmt .=$col_names[count($col_names)-1]. ")";
        $insert_stmt.="VALUES(";
        for ($idx=0; $idx<(count($col_names)-1); $idx++){
            $insert_stmt.="\"".$inputData[$col_names[$idx]]."\", ";
              }  
            $insert_stmt .=$inputData[$col_names[count($col_names)-1]]. ")";
        //insert_member query
         // echo $insert_stmt;


    return $insert_stmt;
    }
       
}

//  $data = [
//     'name' => $name,
//     'surname' => $surname,
//     'sex' => $sex,
// ];
// $sql = "INSERT INTO users (name, surname, sex) VALUES (:name, :surname, :sex)";
// $stmt= $pdo->prepare($sql);
// $stmt->execute($data);

 ?>       