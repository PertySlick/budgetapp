<?php echo $this->render('resources/template_header.inc.html',NULL,get_defined_vars(),0); ?>   
   
   <div class="container">
        <div class="container col-md-9 text-left">
            <h1>Edit Income</h1>
         <?= var_dump($incomeRecord).PHP_EOL ?>
        </div>
        <div class="container col-md-8">
            <form action="updateincome" method="POST">
                <div class="form-group">
                    <label class="lbl" for="description">Description</label>
                    <input class="form-control" type="text" name="description" value="<?= $incomeRecord[0]->getDescription() ?>">
                </div>
                 <div class="form-group">
                    <label class="lbl" for="type">Income Type</label>
                    <input class="form-control" type="text" name="type" value="<?= $incomeRecord[0]->getCategory() ?>">
                </div>
                <div class="form-group">
                    <label class="lbl" for="date">Date</label>
                    <input class="form-control" type="date" name="date" value="<?= $incomeRecord[0]->getDateApplied() ?>">
                </div>
                <div class="form-group">
                    <label class="lbl" for="amount">Amount</label><br/>
                    <input class="form-control" type="text" name="amount" value="<?= $incomeRecord[0]->getAmount() ?>">      
                </div>
                    <div class="form-group">
                     <label class="lbl" for="frequency">Frequency</label><br/>
                     <select class="form-control" name="frequency">
                     <!--
                     <option value="Daily">Daily</option>
                     <option value="Weekly">Weekly</option>
                     <option value="Bi-Weekly">Bi-Weekly</option>
                     -->
                     <option value="Monthly">Monthly</option>
                     <!--<option value="Semi-Annually">Semi Annually</option>
                     <option value="Quarterly">Quarterly</option>
                     <option value="Annual">Annual</option>-->
                </div>
                    <br>
                <div class="row col-md-9 col-md-offset-3">
                    <input class="img-rounded" type="submit" value="Add Income!">
                </div>
            </form>
        </div>
   </div>
   
   
<?php echo $this->render('resources/template_footer.inc.html',NULL,get_defined_vars(),0); ?>