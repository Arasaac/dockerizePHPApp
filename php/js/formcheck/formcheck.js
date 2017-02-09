/*
******************************************************************
*  Form Check, JavaScript Form Validation Library
*  written by M.Neset KABAKLI <contact at neset dot com>
*
*  Please do not hesitate to contact me for comments, suggestions
*  or requests. You can also get more information and download 
*  the latest version of this file from wwww.neset.com web site.
*
*  Version		: v1.0.2
*  Date			: 09/08/2003
*  Last Update	: 03/11/2004
******************************************************************
*
*  FormCheck currently supports the following contols:
*	- Null values
*	- Minimum and maximum lengths
*	- Minimum and maximum values (for numbers)
*	- Type controls
*	- Checkboxes (03.11.2004)
*
*  FormCheck currently supports the following input types:
*	- date (mm/dd/yyyyy)
*	- datemysql (yyyy-mm-dd)
*	- email
*	- ipaddress
*	- number
*	- text
*
*/
function securityCheck(input) {
	/*
	  SecurityCheck Function
	  Author: M. Neset KABAKLI <contact at neset dot com>
	  Date	: 09/08/2003
	  Update: 31/08/2004
	*/
	var badchars	= Array('\'','\"','%','\\');
	for(var i=0; i<badchars.length;i++) {
		if(input.indexOf(badchars[i]) != -1)
		  return false;
	}
}

function inputCheck(input,type) {
	/*
	  InputCheck Function
	  Author: M. Neset KABAKLI <contact at neset dot com>
	  Date	: 09/08/2003
	  Update: 31/08/2003
	*/
	var errors = 0;
	var expression;

	switch(type) {
		case 'email':
			expression	= /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/;
		break;
		case 'text':
			expression	= "";
		break;
		case 'number':
			expression	= "";
		break;
		case 'date':
			expression	= /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{4}$/;
		break;
		case 'datedb':
			expression	= /^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/;
		break;
		case 'datemysql':
			expression	= /^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/;
		break;
		case 'ipaddress':
			expression	= /^((25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])\.){3}(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])$/;
		break;
		case '':
		break;
	}
	
	if((errors == 0) && (expression != '')) {
		if(!expression.exec(input))
		  errors++;
	}		

	if(errors==0)
		return true;
	else
		return false;
}

function formCheck(cform) {
	/*
	  FormCheck Function
	  Author: M. Neset KABAKLI <contact at neset dot com>
	  Date	: 09/08/2003
	  Update: 31/08/2003
	*/
	if(!cform) {
		alert("Empty form object detected!");
		return false;
	}
	
	var errors		= 0;
	var message		= "Por favor, revise los siguiente elementos: \n";
	var controlmessages	= Array();

	for(i=0;i<cform.elements.length;i++) {
		// Get manual message for this input
		if(cform.elements[i].checkmessage)
		  controlmessages[i] = cform.elements[i].checkmessage;
		else
		  controlmessages[i] = "";
		// Get message
		
		// 1. NULL CONTROL
		if(cform.elements[i].checkallownull && cform.elements[i].checkallownull=='false') {
			if(cform.elements[i].value) {
				if((cform.elements[i].value == '' || cform.elements[i].value == ' ') || (cform.elements[i].type == "checkbox" && cform.elements[i].checked == false)) {
					errors++;
					if(controlmessages[i] != "") 
				  	  message +="* "+controlmessages[i]+"\n";
					else
				 	  message +="* Field "+cform.elements[i].name+" no puede estar en blanco.\n";	
				}
			} else {	
				errors++;
				if(controlmessages[i] != "") 
				  message +="* "+controlmessages[i]+"\n";
				else
				  message +="* Field "+cform.elements[i].name+" no puede estar sin definir.\n";
			}		
		}
		// END OF NULL CONTROL
		
		// 2. TYPE CONTROL
		if((cform.elements[i].checktype) && (cform.elements[i].value)) {
			if(!inputCheck(cform.elements[i].value,cform.elements[i].checktype)) {
				errors++;
				if(controlmessages[i] != "") 
				  message +="* "+controlmessages[i]+"\n";
				else
				  message +="* Invalid "+cform.elements[i].checktype+" format in "+cform.elements[i].name+".\n";
			}
		}
		// END OF TYPE CONTROL

		// 3. LENGTH CONTROL
		if((cform.elements[i].checkminlen) && (cform.elements[i].value)) {
			if(cform.elements[i].value.length < cform.elements[i].checkminlen) {
				errors++;
				if(controlmessages[i] != "") 
				  message +="* "+controlmessages[i]+"\n";
				else
				  message +="* La logitud de "+cform.elements[i].name+" no puede ser menor de "+cform.elements[i].checkminlen+" caracteres.\n";
			}
		}
		if((cform.elements[i].checkmaxlen) && (cform.elements[i].value)) {
			if(cform.elements[i].value.length > cform.elements[i].checkmaxlen) {
				errors++;
				if(controlmessages[i] != "") 
				  message +="* "+controlmessages[i]+"\n";
				else
				  message +="* La longitud de "+cform.elements[i].name+" no puede ser mayor de "+cform.elements[i].checkmaxlen+" caracteres.\n";
			}					
		}
		// END OF LENGTH CONTROL
		
		// 3. MIN/MAX VALUE CONTROL FOR NUMBERS
		if((cform.elements[i].checkminvalue) && (cform.elements[i].value)) {
			if(cform.elements[i].value < cform.elements[i].checkminvalue) {
				errors++;
				if(controlmessages[i] != "") 
				  message +="* "+controlmessages[i]+"\n";
				else
				  message +="* El valor de "+cform.elements[i].name+" no puede ser menor de "+cform.elements[i].checkminvalue+".\n";
			}
		}
		if((cform.elements[i].checkmaxvalue) && (cform.elements[i].value)) {
			if(cform.elements[i].value > cform.elements[i].checkmaxvalue) {
				errors++;
				if(controlmessages[i] != "") 
				  message +="* "+controlmessages[i]+"\n";
				else
				  message +="* El valor de "+cform.elements[i].name+" no puede ser menor de "+cform.elements[i].checkmaxvalue+".\n";
			}
		}
		// END OF MIN/MAX VALUE CONTROL
		if((cform.elements[i].checkmandatorycheckbox)) {
			alert(cform.elements[i].type+" / "+cform.elements[i].checked);
			if(false) {
				if(controlmessages[i] != "") 
				  message +="* "+controlmessages[i]+"\n";
				else
				  message +="* El valor de "+cform.elements[i].name+" no puede ser menor de "+cform.elements[i].checkminvalue+".\n";
			}
		}
	} // END OF THE FOR LOOP
	
	if(errors == 0) {
	  return true;
	} else {
	  alert(message);
	  return false;	
	}	
}

// ##############################################################################