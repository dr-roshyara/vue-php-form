<?php 
require("Datainput.php");
require("model.php");
require "config.php";
require "queries.php";

use \Datainput\DataInput as DataInput;
use \Model\Model as Model ;
// use RuntimeException;
header('Content-Type: application/json; charset=utf-8');
$fieldNames = array("name", "familyName", "dateOfBirth", "email", "mobileNumber", "telephone", "motherName", "fatherName", "maritalStatus", "spouceName", "permanentAddress", "temporaryAddress", "education", "profession", "firstMembershipDate", "lastMembershipDate", "validUntil", "district",
    "region", "workingCommitte", "politicalBackground", "partyResponsibilities", "politicalAppointments", "suggestions", "acceptance");
// $fieldNames = array( "name", "familyName"); 
/** How to reduce fields of the form and set up only a few for the test
 * 1) Enable in form1.php the field names to only a few 
 * 2) comment the rest of the filed in app.js 
 * 3) enable the $fieldNames variable with only a few here above.
 */
    // $exampleData =[
// "name" =>"Nab Raj", 
// "familyName"=>"Roshyara", 
// "dateOfBirth"=>"2033-08-06", 
// "email"=>"roshyara@gmail.com", 
// "mobileNumber"=>"015164322589", 
// "telephone"=>"", 
// "motherName"=>"Durga", 
// "fatherName"=>"Lok Raj Roshyara", 
// "maritalStatus"=>"married", 
// "spouceName"=>"Sarada", 
// "permanentAddress"=>"",
//  "temporaryAddress"=>"", 
//  "education"=>"PHD",
//   "profession"=>"informatiker",
// "firstMembershipDate"=>"", 
// "lastMembershipDate"=>"", 
// "validUntil"=>"", 
// "district"=>"",
// "region"=>"", 
// "workingCommitte"=>"Germany", 
// "politicalBackground"=>"", 
// "partyResponsibilities"=>"",
//  "politicalAppointments"=>"", 
//  "suggestions"=>"", 
//  "acceptance"=>1
// ];

$choiceFields = ["email" ,"spouceName", "telephone","temporaryAddress"];
$fieldLength= count($fieldNames);
/** 
**  Take operation of input fields . they are given as the nname of 
**/
// $fieldNames = array("name", "familyName");
$inputData = new DataInput($_SERVER["REQUEST_METHOD"],$fieldNames,$choiceFields);

try{
    //echo $dataType =gettype($inputData->iData);
    if($dataType="array"){
        $queries =new Querry($inputData->iData); 
        // $queries =new Querry($exampleData);

        /*** 
        *** create a new member 
        *** var : member 
        **/
        $member =new Model($config,$queries->table_created); 
        /***
        **If table is not created then create one . 
        **This is however done once; 
        **/
        if(!$queries->table_created){
          $member->create_table($queries->table_name,$queries->sql_create_table);
         }
        /** Prepare to  add the data to data bank 
        **/
        $member->prepare_query($queries->sql_prepare_member);
        //$member->db_execute($inputData);
         $member->db_execute_data($inputData->iData);
         //$member->db_execute_data($exampleData);
         
         }else{
            throw new RuntimeException('Invalid image file format.');
         }
    }catch( RuntimeException $e)
    {
        
        echo $e->getMessage();
}     


?>
