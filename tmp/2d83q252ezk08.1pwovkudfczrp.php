<?php echo $this->render('resources/template_header.inc.html',NULL,get_defined_vars(),0); ?>

<link rel ="stylesheet" href="/328/budgetapp/css/new.css" />

<div class="container">
    <div class="row">
        
        <!-- Main Summary -->
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Income vs Expenses</h3>
                </div>
                <div class="panel-body">
                    <p>Income <span class="pull-right">$7,345</span></p>
                    <p>Expenses <span class="pull-right">$3,327</span></p>
                    <p>Remaining <span class="pull-right">$3,818</span></p>
                </div>
            </div>
        </div>
        
        <!-- Expense Summary -->
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-title">
                        Upcoming Bills
                        <button class="btn btn-xs btn-info pull-right">Add Expense</button>
                    </p>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td>Puget Sound Energy</td>
                            <td>5/15/17</td>
                            <td>$83.34</td>
                        </tr>
                        <tr>
                            <td>Comcast</td>
                            <td>5/17/17</td>
                            <td>$123.45</td>
                        </tr>
                        <tr>
                            <td>T-Mobile</td>
                            <td>5/30/17</td>
                            <td>$33.65</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- Income vs Expense Bar -->
        <div class="col-sm-4">
            <h4 class="text-center">Incoming Remaining For November</h3>
            <div class="progress progress-bar-success">
                <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 60%;"></div>
            </div>
        </div>
        
        <!-- Income Summary -->
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-title">
                        Upcoming Income
                        <button class="btn btn-xs btn-info pull-right">Add Income</button>
                    </p>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td>Puget Sound Energy</td>
                            <td>5/15/17</td>
                            <td>$83.34</td>
                        </tr>
                        <tr>
                            <td>Comcast</td>
                            <td>5/17/17</td>
                            <td>$123.45</td>
                        </tr>
                        <tr>
                            <td>T-Mobile</td>
                            <td>5/30/17</td>
                            <td>$33.65</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- Expense Categories -->
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Expense Categories</h3>
                </div>
                <div class="panel-body">
                    <p>Groceries <span class="pull-right">$435</span></p>
                    <p>Restaurants <span class="pull-right">$123</span></p>
                    <p>Gas <span class="pull-right">$215</span></p>
                </div>
            </div>
        </div>
        
        <!-- Recent Transactions -->
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Recent Transactions</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td>Puget Sound Energy</td>
                            <td>5/15/17</td>
                            <td>$83.34</td>
                        </tr>
                        <tr>
                            <td>Comcast</td>
                            <td>5/17/17</td>
                            <td>$123.45</td>
                        </tr>
                        <tr>
                            <td>T-Mobile</td>
                            <td>5/30/17</td>
                            <td>$33.65</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->render('resources/template_footer.inc.html',NULL,get_defined_vars(),0); ?>