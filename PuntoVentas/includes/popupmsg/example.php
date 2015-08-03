<?php 
// popupMsg usage example 

/***********************   popupMsg usage example  ********************************
/*
/* Usage : Apply the following parameters for the class (refer to class documentation for more details) : 
/*  top,left,width,height :  Absulute position of top,left and then width/height of message 
/*  $HeadlineTxt,$Msgtxt,$controlTXT  : Headling Text , Message Text , Control Text
/*  timeout (in ms)  : In case the message should be self disappeared after a period of time
/*  $MessageStyleArr,$HeadlineStyleArr,$TextStyleArr,$ControlStyleArr : Associative array of
/*  Styling describing the Message/Headline/Text/Control section respectively.
/*
/***************************************************************************/



include_once("popup.class.php");



/*
// EXAMPLE 1 : Normal Usage 
$msg1 = new popupMsg (30,30,200,90,"Example 1","Cannot connect to DB , please retry","Close");
$msg1->populateHTML();
$msg1->PrintMsg();
*/

// EXAMPLE 2 : Normal Usage  , with time out.
$HeadlineStyleArr["text-align"] = "left";
$HeadlineStyleArr["color"] = "purple"; 
$HeadlineStyleArr["background-color"] = "silver";
$HeadlineStyleArr["font-style"] = "italic";
$HeadlineStyleArr["font-family"] = "arial, sans-serif";
$MessageStyleArr["border"] = "black 8px solid";
$MessageStyleArr["filter"] =  "alpha(opacity=80)"; // IE
$MessageStyleArr["moz-opacity"] = 0.8;  //FF
$MessageStyleArr["opacity"] = 0.8;    // FF

$TextStyleArr["text-align"] = "center";
$TextStyleArr["color"] = "silver"; 
$TextStyleArr["background-color"] = "purple";
$TextStyleArr["font-weight"] = "bold";
$TextStyleArr["font-family"] = "arial, sans-serif";

$msg2 = new popupMsg (150,30,450,100,"Conestate Peru","OK",16000);
$msg2->populateHTML();
$msg2->PrintMsg();
/*
// EXAMPLE 3 : Change message border
$MessageStyleArr["border"] = "yellow 4px dashed";
$msg3 = new popupMsg (150,300,300,100,"Example 3:Override Message Styling","This example shows how to override message paramter , all W3C styles values are valid","OK",0,$MessageStyleArr,'','','');
$msg3->populateHTML();
$msg3->PrintMsg();

// EXAMPLE 4 : Change Headling Styling parameters 
$HeadlineStyleArr["text-align"] = "center";
$HeadlineStyleArr["color"] = "purple"; 
$HeadlineStyleArr["background-color"] = "silver";
$HeadlineStyleArr["font-style"] = "italic";
$HeadlineStyleArr["font-family"] = "arial, sans-serif";
 
$msg4 = new popupMsg (30,300,300,100,"Example 4:Override Message Headline","This example shows how to override message headline style paramter","Close",0,'',$HeadlineStyleArr,'','');
$msg4->populateHTML();
$msg4->PrintMsg(); 





 
// EXAMPLE 5 : Change Text Styling parameters 
$MessageStyleArr["border"] = "black 2px solid";
$MessageStyleArr["filter"] =  "alpha(opacity=80)"; // IE
$MessageStyleArr["moz-opacity"] = 0.8;  //FF
$MessageStyleArr["opacity"] = 0.8;    // FF

$TextStyleArr["text-align"] = "center";
$TextStyleArr["color"] = "silver"; 
$TextStyleArr["background-color"] = "purple";
$TextStyleArr["font-weight"] = "bold";
$TextStyleArr["font-family"] = "arial, sans-serif";

$msg5 = new popupMsg (0,400,300,100,"Este programa sera enviado a quien lo solicite en el Foro de la pagina WEB a contar del dia 21 de Noviembre 2010","Back",0,'','',$TextStyleArr,'');
$msg5->populateHTML();
$msg5->PrintMsg();  


/*
// EXAMPLE 6 : 
// override ALL
// please note that $MessageStyleArr,$HeadlineStyleArr,$TextStyleArr have been
// defined in previous examples


$msg6 = new popupMsg (150,400,400,200,"Example 6:Override All (Msg,Headline,Text)","This example shows how to override All message paramters , all W3C styles values are valid","Close",0,$MessageStyleArr,$HeadlineStyleArr,$TextStyleArr,'');
$msg6->populateHTML();
$msg6->PrintMsg();  


// Example 7: Change Control parameters (and border change at Message styling) 

$MessageStyleArr["border"] = "black 2px solid";
$ControlStyleArr["text-align"] = "left";      
$ControlStyleArr["font-weight"] = "bold";

$msg7 = new popupMsg (400,400,260,120,"Example 7:Changing Control paramteres","This example shows how to override All message paramters , all W3C styles values are valid","Close",0,$MessageStyleArr,'','',$ControlStyleArr);
$msg7->populateHTML();
$msg7->PrintMsg();  




// Example 8 : controlling Transparency (this illusrates opacity of 80%):

$MessageStyleArr["border"] = "black 2px solid";
$MessageStyleArr["filter"] =  "alpha(opacity=80)"; // IE
$MessageStyleArr["moz-opacity"] = 0.8;  //FF
$MessageStyleArr["opacity"] = 0.8;    // FF

$msg7 = new popupMsg (100,500,260,120,"Example 7:Changing Opacity","This example shows how to control Opacity level of message","Close",0,$MessageStyleArr,'','','');
$msg7->populateHTML();
$msg7->PrintMsg();  
*/
	    
?>




