<?Php
//require("model.php");
require "config.php";
require "queries.php";
require("form-submitted.php");
 
use \Model\Model as Model ;
use \FormSubmitted\DataInput as DataInput;
$inputData = new DataInput($_SERVER["REQUEST_METHOD"],$fieldNames,$choiceFields);

// $table_created =true;
$member =new Model($config,$table_created); 
// if(!$table_created){
// 	$member->create_table($table_name,$sql_create_table);
// }
$member->prepare_query($insert_member);

//$member->bindParam($col_names1);
?>