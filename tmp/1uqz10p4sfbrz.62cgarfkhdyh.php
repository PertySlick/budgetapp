<?php echo $this->render('resources/template_header.inc.html',NULL,get_defined_vars(),0); ?>   
   
   <div class="container">
        <div class="container col-md-12 ">
            <h1>Income Overview</h1>
            
            
            <?= var_dump($incomeRecords).PHP_EOL ?>
            
            <p><?= $incomeRecords[0]->getAmount() ?></p>
       <p><?= $incomeRecords[1]->getAmount() ?></p>
        <p><?= $incomeRecords[2]->getAmount() ?></p>
                      
            <?php foreach (($incomeRecords?:[]) as $item): ?>
                <p><?= $item->getAmount() ?></p>
            <?php endforeach; ?>
            
     
  
       
      
 
        </div>
        
      
        
   </div>
   
   
<?php echo $this->render('resources/template_footer.inc.html',NULL,get_defined_vars(),0); ?>