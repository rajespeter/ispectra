 

<?php
require_once("./includes/initialize.php"); 
ob_start();
session_start(); 

session_unset();
session_destroy();
ob_end_flush ();
 
?>
 
   

 


  
<?php include_layout_template('header.php'); ?>         
    
    
     <div id="leftContent"> 
    
                <h2 align="center"> iSpectra Registration System </h2>
               
                                     
                 <div align="justify">     
                                       
                </div>
                
                <?php if (isset($_GET['clear'])) {echo"<h3 align='center'> Shopping Cart was Cleared </h3>";} ?>
                <?php if (isset($_GET['complete'])) {echo"<h3 align='center'> Thank you! Your Order has been completed </h3>";} ?>
                
            <div id="ex" >
                <br />
                <p align="center" ><a href='./PayPalCart/html/processGroup.php?id=' 
                	title="Start Registration" target="" class="btn large blue">Start Registration </a> </p>
                <p align="center" ><a href='./PayPalCart/html/processBulk.php?id=' 
                	title="Start Registration" target="" class="btn large blue">Group Tickets </a> </p>
                <p><br /></p>
                <?php /*
                 <p align="center" >
                 	<a href='http://www.ispectraignite.org/' title="iSpectra" target="">
                 		Back to iSpectra </a> </p>
                */ ?>
             
               
                      <p>&nbsp;</p>
          <hr />

               <p>For questions regarding registration contact <br/>
                    
                    <script language="JavaScript">
var username = "registration";
var hostname = "ispectraignite.org";
var linktext = username + "@" + hostname ;
document.write("<a href='" + "mail" + "to:" + username + "@" + hostname + "'>" + linktext + "</a>");
</script>
                 </p>
         
            </div>

           
        
          </div>  <!-- leftContent -->
    
            
             <p class="clear"> </p> 
             
             <!--h2 align="center">Special Registration for Host Church attendees</h2>
             
             <p align="center" ><a href='./PayPalCart/html/processGroup.php?id=HOST' target="">Host Church</a>   </p>
                <p><br /></p-->  
         </div> 

<?php include_layout_template('footer.php'); ?>  