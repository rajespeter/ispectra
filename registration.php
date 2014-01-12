 

<?php 
require_once("./includes/initialize.php"); ?>
  
<?php include_layout_template('header.php'); ?>         
         <div id="content">
    
     <div id="leftContent"> 
    
                <h2 align="center">Register for iSpectra </h2>
               
                                     
                 <div align="justify">     
                   <h4 align="center" > </h4>
           
                   
                   <h3 align="center" >Hosted at: <br />
                      TBD<br />
                      
                     Date TBD  </h3>
                                      
                </div>
                
                <?php if (isset($_GET['clear'])) {echo"<p> Shopping Cart was Cleared </p>";} ?>
                <?php if (isset($_GET['complete'])) {echo"<p> Thank you! Your Order has been completed </p>";} ?>
                
            <div id="ex" >
                
                <h3 align="center" >Information </h3>
                
                
                <p> Registration Fees:  <br /> 
                    refreshments and materials  <br />
                    Adult On-Line Registration fees:<br />
                    Prior to March 16 2014: &nbsp; $99 per person <br/>
                    TBD<br/>
                    TBD and<br/>
                    Adult Registration At the door:    &nbsp; $99 per person<br/>
                </p>
                
                <p align="center" ><a href='./PayPalCart/html/processGroup.php?id=' title="Register on Line NOW" target="">Register On-Line </a> </p>
                <p><br /></p>
                <!--p>	Children (Grades 1 through 6) <br/>
                     ALL DAY SATURDAY 8:30 AM – 4:30 PM<br/>
                    - $20 per child on-line <br/>
                    ($30 at the door)  <br />
                    
                </p-->
                 <hr />
                 <p>You can Register additional people with you as your register on-line. <br />
                 If you Register an additional 4 or more adults at the same time  <br />
                 you save TBD per adult automaticly </p>        
          
              
                <hr />
               
                <p> When you Register you can also register for Ethnic Training conducted by XXXX prior<br />the iSpectra 2014 workshops 
                   as add-on <br /> - $30 for set per attendee</p>
                   <hr />
       
               <br/>
               <p>For questions regarding registration contact <br/>
                    By E-mail: somone@nowhere.org <br/>
                By Phone:   xxx-xxx-xx </p>
              
               
                  
            </div>

           
        
          </div>  <!-- leftContent -->
    
            
             <p class="clear"> </p> 
             
             <!--h2 align="center">Special Registration for Host Church attendees</h2>
             
             <p align="center" ><a href='./PayPalCart/html/processGroup.php?id=HOST' target="">Host Church</a>   </p>
                <p><br /></p-->  
         </div> <!-- content -->
</div> <!-- outerDiv -->

 
                         <!--            </td>
        </tr></table>
    </td></tr>
</table>
-->
<?php include_layout_template('footer.php'); ?>

