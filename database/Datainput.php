<?php
namespace Datainput;
use RuntimeException;
use  finfo;
class DataInput
{
    public $errors = [];
    public $iData = [];
    public  $handelResponse = "";
    private $error = false;
    public $status = "";
    public $response = array();
    public $message = "";
    private $fieldNames=[];
    private $choiceFields=[];
    function clean_input_text($data) {
        $data = trim($data);
        $value = htmlentities($data);
        // Removes any html from the string and turns it into &lt; format
        $value = strip_tags($data);
        $data = stripslashes($data); 
        $data = htmlspecialchars($data);
        // Removes any html from the string and turns it into &lt; format
        $bad_chars = array("{", "}", "(", ")", ";", ":", "<", ">", "/", "$");
        $data = str_ireplace($bad_chars, "", $data);
        return $data;
    }
    function check_input_data()
    {
        $data  =array();
        $fieldLength=count($this->fieldNames);
        try {
            if (empty($_POST)) {
                $this->error = true;
                 $this->message = "No data has been received";
                 throw new RuntimeException('No data has been received.');
            } else {
                //$sentMessage =json_encode($_POST, true);
                for ($xint = 0; $xint < $fieldLength; $xint++) {
                    //foreach ($_POST as $x => $x_value) {
                    $x = $this->fieldNames[$xint];
                   // echo $x. ":". $_POST[$x]."\n"; 
                    $x_value = $_POST[$x];
                    /**
                    ** Check the errors only if the fields are compulsary
                    ** That means avoid choice Fields. 
                    **/
                    if(!in_array($x, $this->choiceFields)){
                        $this->check_errors($x,$x_value);
                    }
                    //Add the value onyl if there is no error at all. 
                    if(!$this->error)
                    {
                        $key_value     = $this->clean_input_text($x_value);
                        $data[$x]    = $key_value;
                    }
                    $x_value = "";
                    $x = "";
                }
            }   
        return $data;
        }catch( RuntimeException $e){

        }
    }
    function sendSuccessMessage()
    {
        $response = array(
            "status" => "success",
            "error" => $this->error,
            "message" => "File uploaded successfully",
            "errors" => $this->errors

        );
        //echo json_encode($response);
    }
    function sendErrors()
    {
        
         $response = array(
            "status" => $this->status,
             "error" => $this->error,
            "errors" => $this->errors,
            "message"=>$this->message
            );
            echo json_encode($response);
            // echo (json_encode($this->errors));
             header('X-PHP-Response-Code: 404', true, 404);
            http_response_code(404);
            die();
        
    }
     //create image file folder  and name 
    private function create_image_name($imageTag, $imageFolder, $ext){
        $image_file_name="";
        $fileName = sha1_file($_FILES[$imageTag]['tmp_name']);
        file_put_contents("test.txt", $fileName);
        $fileParts = array($_POST['name'], $_POST['familyName'], $_POST['dateOfBirth'], $fileName);

        $fileNewName = implode("_", $fileParts);
        $fileNewName = str_replace(" ", "_", $fileNewName);
        $fileNewName = str_replace("/", "", $fileNewName);
        $fileNewName = str_replace("-", "", $fileNewName);
        $image_folder_name="";
        // $image_folder ='./uploads/';
        //  $image_file_name=sprintf('%s%s.%s', $image_folder, $fileNewName,    $ext);
         $image_file_name=sprintf('%s%s.%s', $imageFolder, $fileNewName,    $ext);
         return $image_file_name;
     }
    // Handel with the image file 
  function handelWithImageFile($imageTag, $imageFolder)
    {
        try {
            $image_file_name        = "";
            $this->errors["file"]   ="";
            $this->erorr            = false;
            $this->status           = "";
            $this->handelResponse   = "";
            $this->message          = "";
            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($_FILES[$imageTag]['error']) ||
                is_array($_FILES[$imageTag]['error'])
            ) {
                $this->erorr=true;
                throw new RuntimeException('Invalid Image file parameters.');
                
            }

            // Check $_FILES[$imageTag]['error'] value.
            switch ($_FILES[$imageTag]['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit.');
                default:
                    throw new RuntimeException('Unknown errors.');
            }

            // You should also check filesize here. 
            if ($_FILES[$imageTag]['size'] > 1000000) {
                throw new RuntimeException('Exceeded filesize limit of the Image.');
            }

            // DO NOT TRUST $_FILES[$imageTag]['mime'] VALUE !!
            // Check MIME Type by yourself.
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search(
                $finfo->file($_FILES[$imageTag]['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ),
                true
            )) {
                throw new RuntimeException('Invalid image file format.');
            }

            // You should name it uniquely.
            // DO NOT USE $_FILES[$imageTag]['name'] WITHOUT ANY VALIDATION !!
            // On this example, obtain safe unique name from its binary data.
        
           if(!$this->error)
           {
               $image_file_name =$this->create_image_name($imageTag,$imageFolder,$ext);
                if (!move_uploaded_file(
                    $_FILES[$imageTag]['tmp_name'], $image_file_name)
                    // sprintf(
                    //     './uploads/%s.%s',
                    //     $fileNewName,
                    //     $ext
                    // ))
                ) {
                    throw new RuntimeException('Failed to move uploaded image file.');
                }
            // $_POST['name'];
           }
           return $image_file_name;
        } catch (RuntimeException $e) {
            $this->erorr = true;
            $this->errors["file"] = $e->getMessage();
            $this->status = "error";
            $this->handelResponse = "Image could not be uploaded.";
            $this->message = $e->getMessage();
        }
    } //end of image function 

    function __construct($method, $fieldNames,$choiceFields)
    {
        $this->fieldNames=$fieldNames;
        $this->choiceFields=$choiceFields;
        if ($method == "POST") {
            $this->iData = $this->check_input_data();
            /***create folder name to save image  
            * $imageFoder="./central/"; /default
            * If there is district field given then save the pictures by district wise. 
            * So we firtst need to catch the district field.
            */
            $basicFolder ="./";
            $imageFolder=$basicFolder."central/";
            if(array_key_exists("district",$this->iData)){
                if($this->iData["district"]!=""){
                    $imageFolder=$basicFolder.$this->iData["district"]."/";
                }
            }
            $this->iData["upfile"]=$this->handelWithImageFile('upfile', $imageFolder);
            if($this->iData["upfile"]==""){
                $this->error=true;
                $this->errors["file"]="Image file couldn't be found.Please upload the image again.";
               
            }
            if ($this->error) {
                $this->sendErrors();
            } else {
                $this->sendSuccessMessage();
            }
        } else {
            exit("There are errors");
        }
    }
    private function check_errors($x, $x_value){
        if (empty($x_value)) 
        {
            // $this->errors[$x] = $x . " field is required";
            $this->errors[$x] = " फिल्डमा लेख्न अनिबार्य छ। This filed is necessary.";
            $this->error = true;
        }else if (strlen($x_value) < 3) 
        {
            $this->error = true;
            $this->errors[$x] = $x . "यस्मा थोरै अक्षर लेख्नु भएको छ । कृपया राम्रो सँग लेख्नु हुन बिनम्र अनुरोध छ । ";
         }
         if($x=="email"){
            $this->check_email_validity($x, $x_value);
         }
    }
   private function check_email_validity($x , $email)
   {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error = true;
            $this->errors[$x] = "यहाँले लेखेको ईमेल ठेगाना सही नभएकोले यस्लाई सच्याउनको लागि बिनम्र अनुरोध छ।";
        }
   } 

}//end of class 



?>