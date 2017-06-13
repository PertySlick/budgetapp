<?php echo $this->render('resources/template_header.inc.html',NULL,get_defined_vars(),0); ?>   
   
   <div class="container">
        <div class="container col-md-9 text-left">
            <h1>Edit <?= $transactionType ?></h1>
        </div>
        <div class="container col-md-8">
            <form action="<?= $URI ?>" method="POST">
                <div class="form-group <?= $descriptionError ? 'has-error' : '' ?>">
                    <label class="control-label lbl" for="description">Description</label>
                    <input class="form-control" type="text" name="description" value="<?= $transaction['description'] ?>">
                    <p class="help-block" id="descriptionError"><?= $descriptionError ?></p>
                </div>
                 <div class="form-group <?= $typeError ? 'has-error' : '' ?>">
                    <label class="control-label lbl" for="type"><?= $transactionType ?> Category</label>
                    <input class="form-control" type="text" name="type" value="<?= $transaction['type'] ?>">
                    <p class="help-block" id="typeError"><?= $typeError ?></p>
                </div>
                <div class="form-group <?= $dateError ? 'has-error' : '' ?>">
                    <label class="control-label lbl" for="date">Date Applied</label>
                    <input class="form-control" type="date" name="date" value="<?= $transaction['date'] ?>">
                    <p class="help-block" id="dateError"><?= $dateError ?></p>
                </div>
                <div class="form-group <?= $amountError ? 'has-error' : '' ?>">
                    <label class="control-label lbl" for="amount">Amount</label><br/>
                    <input class="form-control" type="text" name="amount" value="<?= $transaction['amount'] ?>">
                    <p class="help-block" id="amountError"><?= $amountError ?></p>
                </div>
                <!-- Frequency Field ** Frequency was eliminated from the plan **
                    <div class="form-group">
                     <label class="lbl" for="frequency">Frequency</label><br/>
                     <select class="form-control" name="frequency">
                     <!--
                     <option value="Daily">Daily</option>
                     <option value="Weekly">Weekly</option>
                     <option value="Bi-Weekly">Bi-Weekly</option>
                     
                     <option value="Monthly">Monthly</option>
                     <!--<option value="Semi-Annually">Semi Annually</option>
                     <option value="Quarterly">Quarterly</option>
                     <option value="Annual">Annual</option>
                </div>
                <!-- End Frequency Field -->
                    <br>
                <div class="row col-md-9 col-md-offset-3">
                    <input class="img-rounded" type="submit" value="Update Expense!">
                </div>
            </form>
        </div>
   </div>
   
   
<?php echo $this->render('resources/template_footer.inc.html',NULL,get_defined_vars(),0); ?>