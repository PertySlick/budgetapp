<?php echo $this->render('resources/template_header.inc.html',NULL,get_defined_vars(),0); ?>   
   
   <div class="container">
        <div class="container col-md-12 ">
            <h1>Income Overview</h1>
    
      <table class="table table-striped table-responsive table-hover">
        <th>ID</th>
        <th>Amount</th>
        <th>Description</th>
        <th>Effective Date</th>
        <th>Frequency</th>
        <th>Actions</th>
        

             <?php foreach (($expenseRecords?:[]) as $item): ?>
                <tr>
                <td><?= $item->getID() ?></td>
                 <td><?= $item->getAmount() ?></td>
                  <td><?= $item->getDescription() ?></td>
                   <td><?= $item->getDateApplied() ?></td>
                   <td>Monthly</td>
                   <td>
                    <div class="row col-md-6"><a href="editExpense/id=<?= $item->getID() ?>"><span class="glyphicon glyphicon-edit"></span></a></div>
                     <div class="row col-md-6"><a href="removeExpense/id=<?= $item->getID() ?>"><span class="glyphicon glyphicon-trash"></span></a></div>
                   </td>
                   </tr>
            <?php endforeach; ?>
             
      </table>

       
            
     
        </div>
        
      
        
   </div>
   
   
<?php echo $this->render('resources/template_footer.inc.html',NULL,get_defined_vars(),0); ?>