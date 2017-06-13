<?php echo $this->render('resources/template_header.inc.html',NULL,get_defined_vars(),0); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css"/>
   
<div class="container">
     <div class="container col-md-12 ">
          <p class="h1">
               Income Overview
               <a href="<?= $BASE . '/addIncome' ?>" title="Add An Income">
                    <button class="btn btn-success pull-right">Add Income</button>
               </a>
          </p>

          <table class="table table-striped table-responsive table-hover display" id="transactions">
              <thead>
                    <tr>
                         <th>Description</th>
                         <th class="text-center">Amount</th>
                         <th>Category</th>
                         <th>Effective Date</th>
                         <th>Actions</th> 
                    </tr>
               </thead>
               <tbody>
                    <?php foreach (($records?:[]) as $item): ?>
                         <tr>
                              <td><?= $item->getDescription() ?></td>
                              <td class="text-center"><?= '$' . $item->getAmount() ?></td>
                              <td><?= $item->getCategory() ?></td>
                              <td><?= $item->getDateApplied() ?></td>
                              <td>
                                   <div class="row col-md-6"><a href="editIncome/id=<?= $item->getID() ?>"><span class="glyphicon glyphicon-edit"></span></a></div>
                                   <div class="row col-md-6"><a href="removeIncome/id=<?= $item->getID() ?>"><span class="glyphicon glyphicon-trash"></span></a></div>
                              </td>
                         </tr>
                    <?php endforeach; ?>
               </tbody>
          </table>
     </div>
</div>
   
   
<?php echo $this->render('resources/template_footer.inc.html',NULL,get_defined_vars(),0); ?>