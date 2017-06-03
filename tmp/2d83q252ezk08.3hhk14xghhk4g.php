<?php echo $this->render('resources/template_header.inc.html',NULL,get_defined_vars(),0); ?>   
   
<div class="container">
     <div class="container col-md-9 text-left">
         <h1>Create Account</h1>
     </div>
     <div class="container col-md-8">
         <form action="./signup" method="POST" id="registration" > <!--onsubmit="return validateRegistration()">-->
             <div class="form-group">
                 <label class="control-label lbl" for="userName">Username:</label>
                 <input class="form-control" type="text" name="userName" id="userName">
                 <div class="help-block" id="userNameError"></div>
             </div>
             <div class="form-group">
                 <label class="control-label lbl" for="password">Password</label><br/>
                 <input class="form-control" type="password" name="password" id="password">
                 <div class="help-block" id="passwordError"></div>
             </div>
             <div class="form-group">
                 <label class="control-label lbl" for="verify">Verify</label><br/>
                 <input class="form-control" type="password" name="verify" id="verify">
                 <div class="help-block" id="verifyError"></div>
             </div>
             <div class="form-group">
                 <label class="control-label lbl" for="email">Email</label><br/>
                 <input class="form-control" type="text" name="email" id="email">
                 <div class="help-block" id="emailError"></div>
             </div>
             <div class="row col-md-9 col-md-offset-3">
                 <input class="img-rounded" type="submit" id="submit" value="Create Account">
             </div>
         </form>
     </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="js/registration.js"></script>
   
   
<?php echo $this->render('resources/template_footer.inc.html',NULL,get_defined_vars(),0); ?>