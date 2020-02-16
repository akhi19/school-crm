<?php 
        require_once '../../includes/config.php';
        require_once '../../includes/functions.php';
    ?>
    <!-- Content Wrapper. Contains page content -->
    <?php if($_POST["gr_no"]) { ?>
    <!-- <div class="content-wrapper"> -->
        <!-- Content Header (Page header) -->
        <section class="content-header">
		<h1>
                <?php echo $_POST["first_name"]." ". $_POST["last_name"]; 
                    $allFees = getPendingFeesByGrNo($_POST["gr_no"]);
                ?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active"><a href="#">Student</a></li>

            </ol>
        </section>
        <?php 
            $totalFeesToPay = 0;
            $monthsMapper = [
                "1" => "Jan",
                "2" => "Feb",
                "3" => "Mar",
                "4" => "Apr",
                "5" => "May",
                "6" => "Jun",
                "7" => "Jul",
                "8" => "Aug",
                "9" => "Sep",
                "10" => "Oct",
                "11" => "Nov",
                "0" => "Dec"
            ];
        ?>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">

                    <div class="box">
                        <div class="box-header">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Pay Fees for </label>
                                    <input id="pay_for_months_number" name="pay_for_months_number" oninput="javascript: 
                                        if (this.value.length > this.maxLength)
                                             this.value = this.value.slice(0, this.maxLength);
                                        if (this.value > 2) 
                                            this.value = 2; 
                                        if (this.value < 0)
                                            this.value = 0;
                                        var feesToPay = 0;
                                        for(let i=0; i<this.value; i++) {
                                            var fees = $('#fees_info_table').find('tbody tr:nth-child('+ parseInt(i+2) +') td:nth-child(5)').text();
                                            feesToPay += parseInt(fees);
                                        }
                                        $('#payableAmountValue').text(feesToPay);
                                            " 
                                     type="number" maxlength="2" style="width: 4.5rem; height: 2.5rem" />
                                    <label> month(s) </label>
                                </div>
                            </div>
                        </div>
                        <div id="message-response"> </div>
                            <div class="row">
                            <?php if(in_array($_SESSION['sessUser'], array('admin'))){ ?>
                                <div class="col-md-5">
                                    <div class="form-group" id="payment_mode">
                                        <label for="text">Payment Mode:</label>
                                        <label class="radio-inline">
                                            <input type="radio" value="Cash"  name="payment_mode_option">Cash
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" value="Debit Card" name="payment_mode_option">Debit Card
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" value="Credit Card" name="payment_mode_option"> Credit Card
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label>Payable Amount: </label>
                                        <label id="payableAmountValue">  </label>
                                     </div>
                                    <div class="form-group">
                                            <button type="button"  onclick="getMultipleColumnValue();" class="btn btn-primary
                                            btn-flat submit-trigger">Pay Now</button>
                                            <button type="button" style="display: none;"   class="btn btn-primary  btn-flat submit-process"><i class="fa fa-spinner fa-spin" ></i> Process...</button>
                                    </div>
                                        
                                 </div>
                            <?php } else { ?>
                                <!-- <div class="col-md-5">
                                    <div class="form-group">
                                            <button type="button"  onclick="getMultipleColumnValue();" class="btn btn-primary
                                            btn-flat submit-trigger">Pay Now</button>
                                            <button type="button" style="display: none;"   class="btn btn-primary  btn-flat submit-process"><i class="fa fa-spinner fa-spin" ></i> Process...</button>
                                    </div>
                                </div> -->

                                    <?php }?>
                            </div>
                        </div>
                    </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div id="error-student"></div>
                                <table  id = "fees_info_table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Class</th>
                                        <th>Academic Year</th>
                                        <th>Month</th>
                                        <th>Outstanding Fees</th>
                                        <th>Fees</th>
                                    </tr>
                                    </thead>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td> <?php echo $allFees[0]['outstanding_fees']; ?> </td>
                                            <td></td>
                                        </tr>
                                        <?php if(!empty($allFees)) { ?>
									<?php $i = 0; foreach($allFees as $row) { $i++; ?>
                                                <?php 
                                                     while($monthsMapper[$row['fees_months']%12] != "Jun") { ?>
                                                         <tr>
                                                            <td><?php echo $row['class']; ?> </td>
											                <td><?php echo $row['academic_year']; ?></td>
                                                            <td><?php echo $monthsMapper[$row['fees_months']%12]; ?></td>
                                                            <td></td>
                                                            <td> 200 <?php $totalFeesToPay += 200; ?> </td>
                                                            <td style="display:none;"> <?php echo $row['gr_no']; ?></td>
                                                         </tr>
                                                        <?php $row['fees_months']++;
                                                    }
                                                ?>
									<?php } ?>
								<?php } ?>
                                </table>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </section>
<?php } ?>
<!-- ./wrapper -->
<?php require_once 'footer.php'; ?>
