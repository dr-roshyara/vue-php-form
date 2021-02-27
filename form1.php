<?php include_once("header.php"); ?>
<?php
$acceptanceText = "यो  बक्समा क्लिक गरेर म यो कुरा स्विकार गर्दैछु कि मैले आफ्नो मन्जुरीले यो फराम भर्दै छु र स्वच्छाले मेरो ब्यक्तिगत विवरण  पार्टी लाई उपलब्ध गराएको  छु।";
$districtName = [
	"dolakha" => "दोलखा", "ramechhap" => "रामेछाप", "sindhuli" => "सिन्धुली",
	"sindhupalunchok" => "सिन्धुपाल्चोक", "bhaktapur" => "भक्तपुर", "lalitpur" => "ललितपुर",
	"kathmandu" => "काठमाडौ", "rasuwa" => "रसुवा", "nuwakot" => "नुवाकोट", "dhading" => "धादिङ",
	"bhaktapur" => "भक्तपुर", "makwanpur" => "मकवानपुर", "chitwan" => "चितवन"
];
//
$committeeName = [
	"wardCommitte" => "वडा कमिटी",
	"nagarCommittee" => "नगर कमिटी", "mahanagarCommitte" => "महानगर कमिटी",
	"regionalCommmitte" => "क्षेत्रिय कमिटी", "districtCommittee" => "जिल्ला कमिटी",
	"specialDistrictCommittee" => "बिशेष जिल्ला कमिटी",
	"janaBargiyaSangathan" => "जन बर्गिय संगठन", "peshagatSangathan" => "पेशगत संगठन",
	"zonalCommittee" => "अञ्चल कमिटी", "centralCommittee" => "केन्द्रिय कमिटी",
	"politBuero" => "पोलिटब्युरो", "standingCommittee" => "स्थाइ कमिटी",
	"centralSecretariat" => "केन्द्रिय सचिवालय"
];
//
$electionField = [
	"region1" => "क्षेत्र नम्बर १", "region2" => "क्षेत्र नम्बर २",
	"region3" => "क्षेत्र नम्बर ३", "region4" => "क्षेत्र नम्बर 4", "region5" => "क्षेत्र नम्बर ५",
	"region6" => "क्षेत्र नम्बर ६", "region7" => "क्षेत्र नम्बर ७", "region9" => "क्षेत्र नम्बर ८",
	"region9" => "क्षेत्र नम्बर ९", "region10" => "क्षेत्र नम्बर १०", "region11" => "क्षेत्र नम्बर ११"
];
//
$fieldnames = [
	"पहिलो नाम", "थर", "सदस्यता कार्डको लागि तस्बिर", "जन्म मिती", "ईमेल", "मोबाईल नम्बर", "टेलिफोन नम्बर",  "आमाको नाम",
	"बुवाको नाम", "बैवाहिक स्थिती", "पती वा पत्नीको नाम", "स्थायी ठेगाना", "अस्थायी ठेगाना",
	"शिक्षा", "पेशा", "पहिलो पटक संगठित सदस्यता प्राप्त मिति", "पछील्लो पटक  संगठित सदस्यता नवीकरण मिति",
	"सदस्यता नबिकरण  समाप्त हुने मिती", "सदस्यता कायम रहेको जिल्ला", "हाल सदस्यता कायम रहेको निर्वाचन क्षेत्र",
	"हाल  कार्यरत कमिटीको नाम", "राजनीतिक पृष्ठभूमी", "आजसम्म प्राप्त पार्टी जिम्मेवारीको विवरण", "आजसम्म प्राप्त राजकीय जिम्मेवारीको विवरण",
	"आफ्नो सुझाव तथा थप भनाई", "मन्जुरिनामा"
];
//
$placeholders = [
	"उदाहरणः नब राज", "उदाहरणः रोस्यारा", "सदस्यता कार्डको लागि तस्बिर", "उदाहरणः 2033/08/06", "उदाहरणः roshyara@gmail.com", "उदाहरणः 9848683788", "टेलिफोन नम्बर", "उदाहरणः दुर्गा देवी रोस्यारा",
	"उदाहरणः लोक राज रोस्यारा ", "बैवाहिक स्थिती", "पती वा पत्नीको नाम", "स्थायी ठेगाना", "अस्थायी ठेगाना",
	"उदाहरणः पि0 एच० डी०", "उदाहरणः आइटी स्पेसिलिस्ट", "बर्ष/महिना/दिन", "बर्ष/महिना/दिन", "बर्ष/महिना/दिन",
	"सदस्यता कायम रहेको जिल्ला", "हाल सदस्यता कायम रहेको निर्वाचन क्षेत्र", "हाल  कार्यरत कमिटीको नाम",
	"राजनीतिक पृष्ठभूमी", "आजसम्म प्राप्त पार्टी जिम्मेवारीको विवरण ", "आजसम्म प्राप्त राजकीय जिम्मेवारीको विवरण",
	"आफ्नो सुझाव तथा थप भनाई", "मन्जुरिनामा "
];
//
$names = [
	"name", "familyName", "file", "dateOfBirth", "email", "mobileNumber", "telephone", "motherName", "fatherName", "maritalStatus", "spouceName", "permanentAddress", "temporaryAddress", "education", "profession", "firstMembershipDate", "lastMembershipDate", "validUntil", "district",
	"region", "workingCommitte", "politicalBackground", "partyResponsibilities", "politicalAppointments", "suggestions", "acceptance"
];
// $names = ["name", "familyName", "file"];
//  
$fieldType = ["text", "text", "file", "text", "text", "text", "text", "text", "text", "selection", "text", "text", "text", "text", "text", "text", "text", "text", "selection", "selection", "selection", "textarea", "textarea", "textarea", "textarea", "checkbox"];
// $names =["name", "familyName","file"];
$script1 = "<script defer src=\"https://use.fontawesome.com/releases/v5.3.1/js/all.js\"></script>";
$outerDiv = '<div class="md:flex md:items-center mb-3 m-auto">';
$outerDiv1 = '<div class="md:w-1/3 block text-gray-800 font-bold md:text-right mb-1 md:m-auto p-2 md:p-4 "> ';
$innerDiv = '<div class="md:w-2/3 m-auto p-2"> ';
$divClose = "</div>";
$labelStart = '<label class="label p-2 md:p-4 ">';
$labelEnd = '</label>';
$inputClass = "m-auto p-2 md:p-4 bg-gray-200 appearance-none shadow border-2 border-green-200 rounded text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 w-full";
$inputType = "<input class=\" input " . $inputClass . "\"";
$selectType = "<select class=\"block bg-gray-200 border-2 border-green-200 py-2 w-full\"";
$textareaType = "<textarea class=\"form-textarea m-auto block bg-gray-200 appearance-none shadow border-2 border-green-200 rounded text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 w-full\"   rows=\"10\"  \n";
//
$inputCheckbox = "<input class=\"form-checkbox w-6 h-6 p-2 m-auto shadow border-2 border-green-200 \"\n";
//write the script name 

echo $script1;
?>
<!-- Copying starts from here -->

<div id="formular" class="m-1 p-2 bg-red-700  broder-green-300 md:items-center justify-center" v-cloak>
	<!-- Here starts the form  -->
	<form method="post" action="./form-submitted.php" @submit.prevent="onSubmit()" class=" shadow-lg rounded-lg px-8 pt-6 pb-8  bg-gray-200" enctype="multipart/form-data" @keydown="form.errors.clear($event.target.name)">
		<?php for ($idx = 0; $idx < sizeof($names); $idx++) {
			echo "\n<!--- Here starts the new input:\n******************************************************************************************************* -->\n";
			echo $outerDiv . "\n";
			echo $outerDiv1;
			echo $labelStart . $fieldnames[$idx] . ":" . $labelEnd . "\n";
			echo $divClose . "\n";
			echo $innerDiv . "\n";
			//here is for marital status 
			if ($fieldType[$idx] == "selection") {
				echo $selectType;
				echo " name=\"" . $names[$idx] . "\"";
				echo " id=\"" . $names[$idx] . "\"";
				echo " title= \"" . $fieldnames[$idx] . "\"";
				echo " v-model=\"form." . $names[$idx] . "\"";
				echo ">\n";
				if ($names[$idx] == "maritalStatus") {
					echo "<option  value=\"married\" class=\"w-full\">विवाहित </option>\n";
					echo "<option value=\"unmarried\" class=\"w-full\">अविवाहित</option>\n";
				} else if ($names[$idx] == "district") {
					foreach ($districtName as $ename => $nname) {
						echo "<option value=\"" . $ename . "\" class=\"w-full\">";
						echo $nname;
						echo "</option>\n";
					}
				} else if ($names[$idx] == "workingCommitte") {
					// selection of working committee 
					foreach ($committeeName as $ename => $nname) {
						echo "<option value=\"" . $ename . "\" class=\"w-full\">";
						echo $nname;
						echo "</option>\n";
					}
				} else if ($names[$idx] == "region") {
					foreach ($electionField as $ename => $nname) {
						echo "<option value=\"" . $ename . "\"  class=\"w-full\">";
						echo $nname;
						echo "</option>\n";
					}
				}
				//end of martial status
				echo "</select>\n";
			} else {
				// for the text area 
				if ($fieldType[$idx] == "textarea") {
					//if it is a text area 
					echo "$textareaType";
				} else if ($fieldType[$idx] == "checkbox") {
					//checkbox 
					echo "<div class=\"m-auto grid grid-cols-8  \">";
					echo "<div class=\" col-span-1 m-auto \">";
					echo $inputCheckbox;
					echo "value=\"" . $names[$idx] . "\" ";
				} else {
					echo $inputType . "\n";
				} //check if the  field is an image field.
				if ($fieldType[$idx] == "file") {
					echo " type=\"file\"";
					//echo " ref=\"file\""; 
					echo " v-on:click=\"deleteImageError\" ";
					echo " v-on:change=\"handleFileUpload('#" . $names[$idx] . "');\"";
				} else {
					//this is normal part for text field 
					echo " type=\"" . $fieldType[$idx] . "\"";
					echo " placeholder= \"" . $placeholders[$idx] . "\"";
					echo " v-model=\"form." . $names[$idx] . "\"";
				} // end of image loop loop

				echo " name=\"" . $names[$idx] . "\"";
				echo " id=\"" . $names[$idx] . "\"";
				echo " title= \"" . $fieldnames[$idx] . "\"";
				echo ">\n";
				if ($fieldType[$idx] == "textarea") {
					// if it is a text area . 
					echo "</textarea>\n";
				}
				if ($fieldType[$idx] == "checkbox") {
					if ($names[$idx] == "acceptance") {
						echo "</div>";
						echo "<div class=\"col-span-7 align-center\">";
						echo "<label for=\"" . $names[$idx] . "\" class =\"text-gray-900\" >";
						echo $acceptanceText;

						echo "</label>";
						echo "</div>";
						echo "</div>";
					}
				}
				//here ends 
			}

		?>
			<span v-show="hasError('<?php echo $names[$idx]; ?>')" class="text-red-500 font-bold p-2 text-center">
				गल्ती:<?php echo $fieldnames[$idx] ?> {{form.errors.get('<?php echo $names[$idx]; ?>')}}
			</span>
		<?php
			echo $divClose;
			echo $divClose;
			echo "\n<!--- Here starts the new input:\n******************************************************************************************************* -->";
		} ?>
		<!-- start !!! SUBMITTING !!! -->
		<div class="align-center text-center m-auto">
			<!-- <input type="submit" name="submit" value="Submit (डाटा पठाउन यस्मा थिच्नुहोस्।)" :disabled="form.errors.any()" class="bg-red-700 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline"> -->
			<!-- <input type="submit" name="submit" value="Submit (डाटा पठाउन यस्मा थिच्नुहोस्।)" :disabled='isFormDisabled' class="bg-red-700 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline"> -->
			<input type="submit" name="submit" value="Submit (डाटा पठाउन यस्मा थिच्नुहोस्।)" class="bg-red-700 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline">
		</div>
		<!-- end -->
		<!-- start -->


	</form>
	<?php include_once("testing.php"); ?>
</div>
<?php include_once("form_ending.php"); ?>
<!-- end of copying -->