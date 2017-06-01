<!--
 * File Name: home.html
 * Author: Timothy Roush & Jeff Pratt
 * Date Created: 5/28/17
 * Assignment: Final Budget App
 * Description:  Main home/splash welcome page of the site
-->

<?php echo $this->render('resources/template_header.inc.html',NULL,get_defined_vars(),0); ?>

<div class="container ">
    <div class="container col-md-12">
        <div class="row">
               <h1>Title?</h1>
        </div>
        
        <div class="row">
            <img class="img-responsive img-rounded" src="images/wheresyourmoney.jpg">
        </div>
        <br>
        <div class="row">
            <button class="btn btn-default center-block">Click Me To Find Out!</button>
        </div>
        <br>
     
    </div>
    <div class="container col-md-12">
        <div class="row">
            <h3>This is a pretty savage budgeting app that will have some cool words placed here so we can kind of explain what we do.</h3>        
        </div>
        <div class="row col-md-6">
        <ul>
            <li>Income Tracking</li>
            <li>Reoccuring Income and Bills!</li>
            <li>Expense Tracking</li>
            <li>Visual Aids!</li>
        </ul>
        </div>
        
        <div class="row col-md-6">
            <li>Monthly Views</li>
            <li>Customizable Budgets!</li>
            <li>Forcasting</li>
            <li>Easy To Use!</li>
        </div>
        
        
    </div>
    
</div>


<?php echo $this->render('resources/template_footer.inc.html',NULL,get_defined_vars(),0); ?>