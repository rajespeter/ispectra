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
            Prior to TBD: &nbsp; $99 per person <br/>
           TBD<br/>
           TBD and 
                At the door:    &nbsp; $99 per person
            </p>

            <p>TBD<br/>
            <br />
            TBD

            </p>
           <br /><hr />                    
            
         <p>You can Register additional people with you as your register on-line. <br />
         If you Register an additional 4 or more adults at the same time  <br />
         you save $20 per adult automaticly </p>
                  
             <p> When you Register you can also register for Ethnic Training conducted by XXXX prior<br />the iSpectra 2014 workshops 
                   as add-on <br /> - $30 for set per attendee</p>
           <hr />
           
          <p>Fee non-refundable after TBD receipt for donation only issued upon request.</p>
          <hr />
           
        <p>For questions regarding registration contact <br/>
                    By E-mail: somone@nowhere.org <br/>
                By Phone:   xxx-xxx-xx </p>
          
     </div>  <!-- div ex -->             
  
      </div> <!-- leftContent -->
     
    
    
        <p class="clear" />
        </div> <!-- content -->
</div> <!-- outerDiv -->



<?php include_layout_template('footer.php'); ?>
