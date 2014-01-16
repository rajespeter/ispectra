 

<?php 
require_once("./includes/initialize.php"); ?>
  
<?php include_layout_template('header.php'); ?>         
    
    
     <div id="leftContent"> 
    
                <h2 align="center"> iSpectra Registration System </h2>
               
                                     
                 <div align="justify">     
                                       
                </div>
                
                <?php if (isset($_GET['clear'])) {echo"<p> Shopping Cart was Cleared </p>";} ?>
                <?php if (isset($_GET['complete'])) {echo"<p> Thank you! Your Order has been completed </p>";} ?>
                
            <div id="ex" >
                
                <p align="center" ><a href='./PayPalCart/html/processGroup.php?id=' 
                	title="Register on Line NOW" target="">Start Registeration </a> </p>
                <p><br /></p>
                 <p align="center" >
                 	<a href='http://www.ispectraignite.org/' title="iSpectra" target="">
                 		Back to iSpectra </a> </p>
                
             
               
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
         <br/>
         <br/>     
               
                  
            </div>

           
        
          </div>  <!-- leftContent -->
    
            
             <p class="clear"> </p> 
             
             <!--h2 align="center">Special Registration for Host Church attendees</h2>
             
             <p align="center" ><a href='./PayPalCart/html/processGroup.php?id=HOST' target="">Host Church</a>   </p>
                <p><br /></p-->  
         </div> 
