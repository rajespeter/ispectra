<?php 
require_once("./includes/initialize.php"); ?>

<?php include_layout_template('header.php'); ?>

            
 <div id="content">
    
    <div id="leftContent">

        
          <?php if (isset($_GET['clear'])) {echo"<p> Shopping Cart was Cleared </p>";} ?>
        <?php if (isset($_GET['complete'])) {echo"<p> Thank you! Your Order has been completed </p>";} ?>
        
          <h2 align="center" >Register Now</h2>
          
    <div id="ex" >
            <p>Your exhibit fee covers: One 8-foot display table <br />
                -     Website Listing and link to your website <br />
                Delegate Registration Includes: <br/> 
                  SATURDAY lunch, refreshments and materials </p>

            <p> Exhibit fee:  &nbsp; $100    </p>
            
        <p align="center" ><a href="./PayPalCart/html/exhibitors_reg.php?id=EXHIBITOR" target="_blank">
        Register On-Line </a> </p>
     	 <br /><br />
            <p> All exhibit personnel pay the regular <br/>
            delegate registration rate:<br/>
                
      
            <p>Registration Fees:   Includes SATURDAY lunch, <br /> refreshments and materials 
                <br />
            Prior to August 31: &nbsp; $50 per person <br/>
           September 1 - October 17: $60<br/>
           October 18 and 
                At the door:    &nbsp; $75 per person
            </p>

            <p>Children (Grades 1 through 6) - $20 per child <br/>
            ($30 at the door)  <br />
            - ALL DAY SATURDAY 8:30 AM – 4:30 PM

            </p>
           <br /><hr />                    
            
         <p>You can Register additional people with you as your register on-line. <br />
         If you Register an additional 4 or more adults at the same time  <br />
         you save $20 per adult automaticly </p>
                  
           <p> When you Register you can add downloads of all <br />the ENGAGE 2013 workshops 
           as add-on <br /> - $30 for set pet attendee</p>
           <hr />
           
          <p>Fee non-refundable after Oct. 16, receipt for donation only issued upon request.</p>
          <hr />
           
           <p>For questions regarding registration contact <br/>
                By E-mail: John.Dupree@Perspectives.org <br/>
            By Phone:   (209) 848-2262 </p>
          
     </div>  <!-- div ex -->             
  
      </div> <!-- leftContent -->
     
    
    
        <p class="clear" />
        </div> <!-- content -->
</div> <!-- outerDiv -->



<?php include_layout_template('footer.php'); ?>
