<?php echo $this->render('resources/template_header.inc.html',NULL,get_defined_vars(),0); ?>   
   
   <div class="container">
        <div class="container col-md-9 text-left">
            <h1>Create Account</h1>
        </div>
        <div class="container col-md-8">
            <form action="signup" method="POST">
                <div class="form-group">
                    <label class="lbl" for="firstname">First Name</label>
                    <input class="form-control" type="text" name="firstname">
                </div>
                 <div class="form-group">
                    <label class="lbl" for="lastname">Last Name</label>
                    <input class="form-control" type="text" name="lastname">
                </div>
                <div class="form-group">
                    <label class="lbl" for="username">Username:</label>
                    <input class="form-control" type="text" name="username">
                </div>
                <div class="form-group">
                    <label class="lbl" for="password">Password</label><br/>
                    <input class="form-control" type="text" name="password">      
                </div>
                <div class="form-group">
                    <label class="lbl" for="email">Email</label><br/>
                    <input class="form-control" type="text" name="email">      
                </div>
                 <div class="form-group">
                    <label class="lbl" for="occupation">Occupation</label><br/>
                    <input class="form-control" type="text" name="occupation">      
                </div>               

                <div class="row col-md-9 col-md-offset-3">
                    <input class="img-rounded" type="submit" value="Create Account">
                </div>
            </form>
        </div>
   </div>
   
   
<?php echo $this->render('resources/template_footer.inc.html',NULL,get_defined_vars(),0); ?>