<?php echo $this->render('resources/template_header.inc.html',NULL,get_defined_vars(),0); ?>

<!-- MAIN VIEW CONTENT GOES HERE -->

<div class="container login-cont">
    <div class="col-md-8 col-md-offset-2">
        <div class="row text-center">
            <h1>User Login</h1>
        </div>        
        <form action="login" method="post">
            <div class="container col-md-9 col-md-offset-3">
                <div class="row">
                    <div class="form-group col-md-9">
                      <span class="label label-default center-block big-lbl" for="username">Username</span>
                    </div>
                    <div class="form-group col-md-9">
                      <input class="form-control" type="text" name="username" required>
                    </div>                
                </div>
                <div class="row">
                    <div class="form-group col-md-9">
                      <span class="label label-default center-block big-lbl text-center" for="password">Password</span>
                    </div>
                    <div class="form-group col-md-9">
                        <input class="form-control" type="text" name="password" required>
                    </div>
                </div>
                <div class="row col-md-offset-4">
                    <input class="img-rounded" type="submit" value="Log In">
                </div>
           
            </div>
        </form>
    </div>
</div>

<?php echo $this->render('resources/template_footer.inc.html',NULL,get_defined_vars(),0); ?>