<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 11:40 AM
 */

?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Leave Balances</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered dt-responsive table-hover" id="leavebances">
                        <tbody>

                        <?php



                        foreach($balances as $key => $val){
                            if($key == 'Key')
                                continue;
                            print '
                                    <tr>
                                        <td>'.$key.'</td><td>'.$val.'</td>
                                     </tr>
                            ';

                        } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



