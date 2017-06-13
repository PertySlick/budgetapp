<!--
 * File Name: home.html
 * Author: Timothy Roush & Jeff Pratt
 * Date Created: 5/28/17
 * Assignment: Final Budget App
 * Description:  About us page of the site
-->

<?php echo $this->render('resources/template_header.inc.html',NULL,get_defined_vars(),0); ?>

<div class="container text-center">
    <div class="panel panel-default container col-md-12">
        <div class="row text-center">
               <h1>About Us</h1>
        </div>
        
        <div class="col-md-4">
            <h3>IN BRIEF</h3>
            <p>BudgetApp is a web application that allows you to track income and expenses for each month. </p>
            <br>
            <p>We believe it to be very important that people take control of their finances.</p>         
            <p>In a world drowning in debt- we will be your lifeline.</p>
        </div>
            
        <div class="col-md-4">
            <img class="img-responsive img-rounded center-block" src="images/savingimg.jpg">
        </div>
        
            <div class="col-md-4 ">
            <h3>Reasons We Rock</h3>
            <ul>
                <li>Our app is free.</li>
                <li>We won't sell your information.</li>
                <li>Easy overview of your finances.</li>
            </ul>
        </div>      
           <br>
        <br>
        <hr>
    </div>

    <div class="col-md-12 panel panel-default">
         <div class="row">
         <h1> Our Team </h1>
    </div>
        <div class=" card col-md-6">
            <h3>Jeff P.</h3>
            <img class="img img-responsive center-block" src="images/author.jpg">
        </div>
         <div class="card col-md-6">
            <h3>Tim R.</h3>
             <img class="img img-responsive center-block" src="images/author.jpg">
        </div>
    </div>
    
</div>


<?php echo $this->render('resources/template_footer.inc.html',NULL,get_defined_vars(),0); ?>