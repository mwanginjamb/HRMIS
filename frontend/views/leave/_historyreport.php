<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 10:43 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - AAS Leave History Report';
$this->params['breadcrumbs'][] = ['label' => 'Leaves', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Leaves Report', 'url' => ['reportview']];
$webroot = Yii::getAlias(@$webroot);
?>

    <div class="row">
        <div class="col-md-12">

                    <!--logo-->

                    <img src="<?= $webroot ?>/images/30 - Logo1.png" style="width: 250px; margin-left: 40%">


                    <h3 class="card-title"> Leave History List</h3>






                <div class="details">
                    <table class="table table-bordered dt-responsive table-hover " id="leaves">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No</th>
                                <th>Leave Type</th>
                                <th>Application Date</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Days Applied</th>
                                <th>Approval Status</th>
                                <th>Leave Balance</th>

                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $count = 0;
                            foreach($leaves as $l){
                                ++$count;
                                print '<tr>

                                            <td>'.$count.'</td>
                                            <td>'.$l->Application_No.'</td>
                                            <td>'.$l->Leave_Code.'</td>
                                            <td>'.date('jS M Y',strtotime($l->Application_Date)).'</td>
                                            <td>'.date('jS M Y',strtotime($l->Start_Date)).'</td>
                                            <td>'.date('jS M Y',strtotime($l->End_Date)).'</td>
                                            <td>'.$l->Days_Applied.'</td>
                                            <td>'.$l->Approval_Status.'</td>
                                            <td>'.$l->Leave_balance.'</td>

                                        </tr>';
                            }
                        ?>

                        </tbody>
                    </table>
                </div>

        </div>
    </div>











