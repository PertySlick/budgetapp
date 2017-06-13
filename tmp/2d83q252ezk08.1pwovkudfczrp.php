<?php echo $this->render('resources/template_header.inc.html',NULL,get_defined_vars(),0); ?>

<div class="container">
    <div class="row">
        
        <!-- Main Summary -->
        <div class="col-sm-4">
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default panel-primary">
                        <div class="panel-heading">
                            <p class="panel-title text-center">Transactions Time Period</p>
                        </div>
                        <div class="panel-body">
                            <div class="col-xs-6">
                                <p class="text-center">Month</p>
                                <p class=text-center">
                                    <select class="form-control" name="month" id="month">
                                        <?php foreach (($months?:[]) as $string=>$num): ?>
                                            <option value="<?= $num ?>" <?= $currentMonth==$num?'selected="selected"':'' ?>><?= $string ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </p>
                            </div>
                            <div class="col-xs-6">
                                <p class="text-center">Year</p>
                                <p class=text-center">
                                    <select  class="form-control" name="year" id="year">
                                        <?php foreach (($years?:[]) as $year): ?>
                                            <option value="<?= $year ?>" <?= $currentYear==$year?'selected="selected"':'' ?>><?= $year ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main Summary -->
                <div class="col-xs-12">
                    <div class="panel panel-default panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Income vs Expenses <?= $monthString ?></h3>
                        </div>
                        <div class="panel-body">
                            <p>
                                Expenses
                                <span class="pull-right">Income</span>
                            </p>
                            <p>
                                <span class="text-danger"><?= '$' . $totalExpense ?></span>
                                <span class="text-success pull-right"><?= '$' . $totalIncome ?></span>
                            </p>
                            <div class="progress progress-bar-success">
                                <div class="progress-bar progress-bar-danger" role="progressbar" style="<?= 'width: ' . $percentage . '%;' ?>"></div>
                            </div>
                            <p>Remaining <span class="pull-right"><?= '$' . $remaining ?></span></p>
                        </div>
                    </div>
                </div>
                <!-- Expense Categories -->
                <div class="col-xs-12">
                    <div class="panel panel-default panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Expense Categories <?= $monthString ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php foreach (($categoryTotals?:[]) as $entry): ?>
                                <p>
                                    <?= $entry['expensetype'].PHP_EOL ?>
                                    <span class="pull-right"><?= '$' . $entry['total'] ?></span>
                                </p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="row">
                <!-- Expense Summary -->
                <div class="col-xs-12">
                    <div class="panel panel-default panel-danger">
                        <div class="panel-heading">
                            <p class="panel-title">
                                <a href="<?= $BASE . '/expense' ?>" title="View Your Expenses">Upcoming Expenses</a>
                                <a href="<?= $BASE . '/addExpense' ?>" title="Add An Expense">
                                    <button class="btn btn-xs btn-info pull-right">Add Expense</button>
                                </a>
                            </p>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <?php foreach (($last3Expenses?:[]) as $entry): ?>
                                    <tr>
                                        <td class="col-xs-7"><?= $entry->getDescription() ?></td>
                                        <td class="col-xs-3"><?= $entry->getDateApplied() ?></td>
                                        <td class="text-right col-xs-2"><?= '$' . $entry->getAmount() ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Income Summary -->
                <div class="col-xs-12">
                    <div class="panel panel-default panel-success">
                        <div class="panel-heading">
                            <p class="panel-title">
                                <a href="<?= $BASE . '/income' ?>" title="View Your Incomes">Upcoming Income</a>
                                <a href="<?= $BASE . '/addIncome' ?>" title="Add An Expense">
                                    <button class="btn btn-xs btn-info pull-right">Add Income</button>
                                </a>
                            </p>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <?php foreach (($last3Incomes?:[]) as $entry): ?>
                                    <tr>
                                        <td class="col-xs-7"><?= $entry->getDescription() ?></td>
                                        <td class="col-xs-3"><?= $entry->getDateApplied() ?></td>
                                        <td class="text-right col-xs-2"><?= '$' . $entry->getAmount() ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Recent Transactions -->
                <div class="col-xs-12">
                    <div class="panel panel-default panel-info">
                        <div class="panel-heading">
                            <p class="panel-title">Recent Transactions</p>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <?php foreach (($last5?:[]) as $entry): ?>
                                    <tr>
                                        <td class="col-xs-7"><?= $entry->getDescription() ?></td>
                                        <td class="col-xs-3"><?= $entry->getDateApplied() ?></td>
                                        <td class="text-right col-xs-2"><?= '$' . $entry->getAmount() ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->render('resources/template_footer.inc.html',NULL,get_defined_vars(),0); ?>