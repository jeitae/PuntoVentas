<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang="es"> 

<?php 
include ("../conectar.php");
?> 

<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>CodeKa Mx, Estadisticas Sistema plantilla</title>
 <link rel="stylesheet"    type= "text/css"  href="../960gs/code/css/reset.css" />
 <link rel="stylesheet"    type= "text/css"  href="../960gs/code/css/text.css" />
 <link rel="stylesheet"    type= "text/css"  href="../960gs/code/css/960.css" />
 <link rel="stylesheet"    type= "text/css"  />
 <!--<link rel="stylesheet" href="css/uncompressed/demo.css" />-->
 <script language="javascript">AC_FL_RunContent = 0;</script>
 <script src="AC_RunActiveContent.js" language="javascript"></script>

<style type="text/css">
BODY{
   background-color:#FFFFFF;
   color: #000000;
   font-family: verdana, arial, helvetica;
}

p{
   border: 1px solid #999;
   padding: 5px;
   margin: 0px;
}
#cabecera{
   background-color: #00FF66;
   background-image:url(imagenes/header2.jpg)
}
#cabecera01{
   background-color: #ccffcc;
}
#izq{
   background-color: #e0e0ff;
}
#izq1{
   background-color: #ccccff;
}

#izq3{
   background-color: #ccccff;
}

#pie{
   background-color: #ff8800;
}
#icono1{
   background-color: #CCCCCC;
}
</style> 
 </head>

  <body>
 
  <div class="container_12">
   
     <div id="cabecera" class="grid_12">
     <p> <img src="img/maxcodeka.jpg" width="480" height="57" alt="Diseño web" />
	 <br /> 	 </p>
	 
	 </div>     
	 <div class="clear"></div>
   
     <div id="cabecera01" class="grid_12">
     <h6 align="left">  Calculadora virtual</h6>
     </div>     
	 <div class="clear"></div>
   	 
	 <div class="grid_12"  id ="izq" >
     <div  class="grid_3 alpha"  id="izq">	  
	 </div>
	   
	 <div  class="grid_6"  id="izq3">
	  
	  	<script language="javascript">
	if (AC_FL_RunContent == 0) {
		alert("Esta opcion requiere que este disponible AC_RunActiveContent.js.");
	} else {
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0',
			'width', '400',
			'height', '400',
			'src', 'calculadora',
			'quality', 'high',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'showall',
			'wmode', 'window',
			'devicefont', 'false',
			'id', 'calculadora',
			'bgcolor', '#ccccff',
			'name', 'calculadora',
			'menu', 'true',
			'allowFullScreen', 'false',
			'allowScriptAccess','sameDomain',
			'movie', 'calculadora',
			'salign', ''
			); //end AC code
	}
</script>
 
	<noscript>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="356" height="370" id="calculadora" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="calculadora.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#f0efe4" />	<embed src="calculadora.swf" quality="high" bgcolor="#f0efe4" width="356" height="370" name="calculadora" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</noscript>	
		
		
		
		</p> 
       </div>
	   
	<div  class = "grid_3  omega"   id="izq"> 
	</div>	  	  
    <div class= "clear"></div> 
    </div>

	<div  class="prefix_5 grid_7"  id= "pie" >
	    <?php
		    echo " www.maxcodeka.com.ar " ;
	    ?> 
	</div>
	<div  class="prefix_10 grid_2"  id= "icono1" >
	  <a href="../central2.php"><img src="../img/botonaceptar.jpg" alt="Salir" width="69" height="25" border="1" onclick = "../central2.php" ondblclick="../central2.php" title="salir"   /></a></div>
	
	
	<div class = "clear"> </div>
  </div>
  <!-- end .container_12 -->  
  </body>
  </html>