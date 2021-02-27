<?php
header('Content-Type: application/json; charset=utf-8');
$filedNames = [
    "name", "familyName", "dateOfBirth", "email", "mobileNumber", "telephone", "motherName", "fatherName", "maritalStatus", "spouceName", "permanentAddress", "temporaryAddress", "education", "profession", "firstMembershipDate", "lastMembershipDate", "validUntil", "district",
    "region", "workingCommitte", "politicalBackground", "partyResponsibilities", " politicalAppointments", "suggestions", "acceptance"
];
$filedNames = [ "name", "familyName"];
$fieldLength= count($filedNames);

/**
 * First Handel the other inputs
 *  
 * 
 */
class DataInput
{
    public $errors = [];
    public $iData = [];
    public  $handelResponse = "";
    private $error = false;
    public $status = "";
    public $response = array();
    public $message = "";
    
   // public $filedNames = array("name", "familyName");
    public  $filedNames = array("name", "familyName", "dateOfBirth", "email", "mobileNumber", "telephone", "motherName", "fatherName", "maritalStatus", "spouceName", "permanentAddress", "temporaryAddress", "education", "profession", "firstMembershipDate", "lastMembershipDate", "validUntil", "district",
        "region", "workingCommitte", "politicalBackground", "partyResponsibilities", "politicalAppointments", "suggestions", "acceptance");
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
        $fieldLength=count($this->filedNames);
        try {
            if (empty($_POST)) {
                $this->error = true;
                 $this->message = "No data has been received";
                 throw new RuntimeException('No data has been received.');
            } else {
                //$sentMessage =json_encode($_POST, true);
                for ($xint = 0; $xint < $fieldLength; $xint++) {
                    //foreach ($_POST as $x => $x_value) {
                    $x = $this->filedNames[$xint];
                    //echo $x. ":". $_POST[$x]."\n"; 
                    $x_value = $_POST[$x];
                    if (empty($x_value)) {
                        $this->errors[$x] = $x . " field is required";
                        $this->error = true;
                    } else {
                        if (strlen($x_value) < 3) {
                            //$errors[$x]=[$x, $x." field has less than 3 Characters. Please write Correctly."];
                            $this->errors[$x] = $x . " field has very few characters. Please write it correctly.";
                        } else {
                            $key_value     = $this->clean_input_text($x_value);
                            $data[$x]    = $key_value;
                        }
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
        echo json_encode($response);
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
    // Handel with the image file 
    function handelWithImageFile()
    {
        try {

            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($_FILES['upfile']['error']) ||
                is_array($_FILES['upfile']['error'])
            ) {
                $this->erorr=true;
                throw new RuntimeException('Invalid Image file parameters.');
                
            }

            // Check $_FILES['upfile']['error'] value.
            switch ($_FILES['upfile']['error']) {
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
            if ($_FILES['upfile']['size'] > 1000000) {
                throw new RuntimeException('Exceeded filesize limit of the Image.');
            }

            // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
            // Check MIME Type by yourself.
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search(
                $finfo->file($_FILES['upfile']['tmp_name']),
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
            // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
            // On this example, obtain safe unique name from its binary data.
           if(!$this->error)
           {
               //this is just to check if there is error perviously
                $fileName = sha1_file($_FILES['upfile']['tmp_name']);
                file_put_contents("test.txt", $fileName);
                $fileParts = array($_POST['name'], $_POST['familyName'], $fileName);
                $fileNewName = implode("_", $fileParts);
                $fileNewName = str_replace(" ", "_", $fileNewName);
                if (!move_uploaded_file(
                    $_FILES['upfile']['tmp_name'],
                    sprintf(
                        './uploads/%s.%s',
                        $fileNewName,
                        $ext
                    )
                )) {
                    throw new RuntimeException('Failed to move uploaded image file.');
                }
            // $_POST['name'];
           }

        } catch (RuntimeException $e) {
            $this->erorr = true;
            $this->errors["file"] = $e->getMessage();
            $this->status = "error";
            $this->handelResponse = "Image could not be uploaded.";
            $this->message = $e->getMessage();
        }
    } //end of image function 

    function __construct($method)
    {
        if ($method == "POST") {
            $this->iData = $this->check_input_data();
            $this->handelWithImageFile();
            if ($this->error) {
                $this->sendErrors();
            } else {
                $this->sendSuccessMessage();
            }
        } else {
            exit("There are errors");
        }
    }
}
$inputData = new DataInput($_SERVER["REQUEST_METHOD"]);



?>

<?php include_once("header.php"); ?>
<div class="m-2 p-2 bg-red-700  broder-green-300 md:items-center justify-center">
    <div class="p-2 bg-gray-200">
        <?php
        echo "Thank you <br/>";
        // echo "Name: ".$inputData->iData['name']."<br/>"; 
        // echo "Family name: ".$inputData->iData['familyname']."<br/>"; 
        // echo "Other: ".$json_obj['fdata']."<br/>";
        ?>

    </div>
</div>