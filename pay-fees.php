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
                <?php
					$empty = "Student not registered for online fees payment. Contact school administrator";
					$emptyClass = "Fees not available for this class";
                    $allFees = getPendingFeesByGrNo($_POST["gr_no"]);
					if (!($allFees)){
					?>
						<div class="alert alert-danger">
                                    <strong>Error!</strong> <?php echo $empty; return;?>
                        </div>
					<?php }
					$i = 0 ;
					foreach ($allFees as $row)
					{ 
						if ($row['academic_year'] == 0){
							$fees[$i] = 0;
							$i++;
							continue;
						}
						$classYearwiseFees[$i] = getClassYearwiseFees($allFees[$i]['class'],$allFees[$i]['academic_year']);
						if (!($classYearwiseFees[$i])){
						?>
							<div class="alert alert-danger">
                                    <strong>Error!</strong> <?php echo $emptyClass; return;?>
                    	    </div>
				
						<?php }
						$fees[$i] = $classYearwiseFees[$i]["total_fees"];
						$i++;
					}
					echo $_POST["first_name"]." ". $_POST["last_name"];
					$monthsMapper = ["Jun","Jul","Aug","Sep","Oct","Nov","Dec","Jan","Feb", "Mar", "Apr", "May"];
                ?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active"><a href="#">Student</a></li>

            </ol>
        </section>
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
                                    <input name="pay_for_months_number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);
                                                                    if (this.value > 2) this.value = 2" type="number" maxlength="2" style="width: 4.5rem; height: 2.5rem" />
                                    <label> month(s) </label>
                                </div>
                            </div>
                        </div>

                            <div class="row">
                            <?php if(in_array($_SESSION['sessUser'], array('admin'))){ ?>
                                        <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#paymentMethod"> Pay </a>
                                    <?php } else { ?>
                                <div class="col-md-5">
                                    <div class="form-group">
                                            <button type="button"  onclick="" class="btn btn-primary btn-flat submit-trigger">PayNow</button>
                                            <button type="button" style="display: none;"   class="btn btn-primary  btn-flat submit-process"><i class="fa fa-spinner fa-spin" ></i> Process...</button>
                                    </div>
                                </div>
                                    <?php }?>
                            </div>
                        </div>
                    </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div id="error-student"></div>
                                <table  class="table table-bordered table-striped">
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
									<?php $i = 0; foreach($allFees as $row) {; ?>
                                                <?php 
													 $months = $row['fees_months'];
													 if ($row['academic_year'] == 0){
													 	$i++;
													 	continue;
													 }
                                                     while($months <= 11){ ?>
                                                         <tr>
                                                            <td><?php echo $row['class']; ?> </td>
											                <td><?php echo $row['academic_year']; ?></td>
                                                            <td><?php echo $monthsMapper[$months]; ?></td>
                                                            <td></td>
                                                            <td> <?php echo $fees[$i]; ?> </td>
                                                         </tr>
                                                        <?php 
														$months++;
                                                    }
													$i++;
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
<div id="paymentMethod" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Fees</h4> -->
                </div>
                <div class="modal-body">
                    <div id="response">agsjhasgdjhg</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
</div>
<?php require_once 'footer.php'; ?>
