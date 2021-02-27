Vue.config.productionTip = false;
Vue.config.devtools = false;
// max size, 100KB=100000Bit, width and height of the image
const MAX_SIZE = 1000000;
const MAX_WIDTH = 550;
const MAX_HEIGHT = 550;
function isEmpty(obj) { 
	for (var key in obj) {
		if (obj.hasOwnProperty(key))
			return false;
	}
	return true;
}
class Errors {
	constructor (){
		this.errors={};
	}
	get(field){
		if(this.errors[field]){
			return this.errors[field];
		}
	}
	record(errors){
		this.errors=errors;
	}
	addError(field, newErrorObj){
		if(this.has(field) )
			{
				this.errors[field] = newErrorObj[field];
				//this.form.errors.errors.file ="test";
			} else if (isEmpty(this.errors)) 
			{
				this.record(newErrorObj);
			} else {
				var newObj = {...this.errors, ...newErrorObj};
				this.record(newObj);

			}
	}


	 
	clear(field){
		if(this.errors[field]){
			delete this.errors[field];
		}
		return (this.errors.hasOwnProperty(field));
	}
	has(field){
		return (this.errors.hasOwnProperty(field));
	}
	any(){
		return Object.keys(this.errors).length>0;
	}
}
class Form{
	/****
		*Create a new form instance 
		*
		*@param {object} data 
		*/
	constructor(data) {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }

	
	/****Fetch all the relevent data from the form 
		*
		*/
		 data() {
        //let data = {};
        // for (let property in this.originalData) {
        //     data[property] = this[property];
		//   }
		var data = new FormData();
		for (let property in this.originalData){
			data.append(property,this[property]);
		}	
		console.log(data);

    	return data ; 
	 }
	submit(requestType,url){
		return  new Promise((resolve,reject)=>{
				axios[requestType](url, this.data(),
				{
					headers: {
						// 'Content-Type': 'multipart/form-data'
						'Content-Type': "application/json"
						
                    }
				}
				)
	   	 	 	.then(response=>{ 
	   	 	  			 	this.onSucess(response.data);
	   	 	 			 	resolve(response.data);
	   	 	 			 	//console.log(response.data);
			 	 		})
	   	 	 			 .catch(error=>{
	   	 	 			this.onFail(error.response.data);
	   	 	 			reject(error.response.data);
	   	 	 			//console.log(error.response.data);  
	   	 	 			
	   	 	 		})

		});
	}
	reset(){
		 for (let property in this.originalData) {
			this[property]="";
			 this.errors.clear(property);
  		}
  		


	}
	onSucess(data){
	 	//alert('success');
		this.reset();
		
	}
	onFail(response){

		// console.log("response");
		console.log(response.errors);
		this.errors.record(response.errors);
	}
	post (url){
		return this.submit('post',url)
	}
	/**
     * Send a PUT request to the given URL.
     * .
     * @param {string} url
     */
    put(url) {
        return this.submit('put', url);
    }
	/**
     * Send a PATCH request to the given URL.
     * .
     * @param {string} url
     */
    patch(url) {
        return this.submit('patch', url);
    }
 	/**
     * Send a DELETE request to the given URL.
     * .
     * @param {string} url
     */
    delete(url) {
        return this.submit('delete', url);
    }


	
}



const form =new Vue({
	   	 	 el:'#formular',
	   	 	 data:{
	   	 	 	test: "hello", 
	   	 	 	fdata:"",
				// submitFileName: '../database/form-submitted.php',
				submitFileName: 'form-submitted1.php',
				imageLoaded:false,
				showError :false,
				image:{
					size:'',
					height:'',
					width:''
				},
			  	form: new Form({
	   	 	 		name:'',
					familyName:'',
					file: '',	 
					upfile:'', 
					dateOfBirth :"",
	   	 	 		email:"", 
	   	 	 		mobileNumber:'',
	   	 	 		telephone:"", 
	   	 	 		motherName:'',   
	   	 	 		fatherName:'',
	   	 	 		maritalStatus:'',
	   	 	 		spouceName:'', 
	   	 	 		permanentAddress:'',
	   	 	 		temporaryAddress:'', 
	   	 	 		education:'',
	   	 	 		profession:'',
	   	 	 		firstMembershipDate:'',
	   	 	 		lastMembershipDate:'',
	   	 	 		validUntil:'',
	   	 	 		district:'',
	   	 	 		region:'',
	   	 	 		workingCommitte:"",
	   	 	 		politicalBackground:"",
	   	 	 		partyResponsibilities:"",
					politicalAppointments:"", 
	   	 	 		suggestions:"",
	   	 	 		acceptance:''


	   	 	 	}),
	   	 	 },
	   	 	 methods:{
	   	 	 	onSubmit(){
					//call the submit function of Form. 
					this.form.post(form.submitFileName)
					.then(response=>{
						alert("Your form has been submitted")
					});
				},
				 deleteImageError: function () {
					this.form.errors.clear('file');
					return (this.form.errors.has('file'));
				},
				hasError(field) {

					return this.form.errors.has(field);
					

				},
				
				handleFileUpload(inputId)
				{
					/**
				 * Once the file is uploaded, delete the error properties. 
				 */
					let curErrors={};
					// this.deleteImageError();
					this.form.errors.clear('file');					
					//check imag e
					//let img = new Image();
					this.imageLoaded = false;
					
					let file = document.querySelector(inputId).files[0];
					if (!file || file.type.indexOf('image/') !== 0) return;
					this.image.size=file.size;
					console.log(this.image.size);
					if(this.image.size>MAX_SIZE)
					{
						curErrors.file = `The image size (${this.image.size}) is too much(max is ${MAX_SIZE}).`;
							
						this.form.errors.addError('file',curErrors);
					 	return; 
					 }

					let reader = new FileReader();

					reader.readAsDataURL(file);
					reader.onload = evt => {
						let img = new Image();
						img.onload = () => {
							this.image.width = img.width;
							this.image.height = img.height;
							console.log(this.image);
							if (this.image.width > MAX_WIDTH) 
							{
								curErrors.file = `The image width (${this.image.width}) is too much (max is ${MAX_WIDTH}).`;
								this.form.errors.addError('file', curErrors);
						
								return;
							}
							if (this.image.height > MAX_HEIGHT)
							 {
								curErrors.file = `The image height (${this.image.height}) is too much (max is ${MAX_HEIGHT}).`;
								this.form.errors.addError('file', curErrors);
							
								return;
							}
							if (img.onerror)
							{
								
								curErrors.file= "not a valid file: " + file.type.indexOf('image/');
								this.form.errors.addError('file', curErrors);
								return;
							}

						}
						img.src = evt.target.result;
					}

					reader.onerror = evt => {
						console.error(evt);
					}
					this.form.upfile=file;
					//this.form.file =this.$refs.file.file[0];
					//this.form.upfile = document.querySelector(inputId).files[0];
					
					
				
				}
	   	 	 		

	   	 	 	
	   	 	 },
	   	 	 created(){
	   	 	 	 // make an ajax request 
	   	 	 	 axios.get('./readme.php').then(response=>this.fdata=response.data);

				 },
				 computed:{
					 isFormDisabled: function(){
						 return this.form.errors.any();
						 					 },
					 
					 
				 }, 
				
	   	 })
   	 

