<link rel="stylesheet" href="<?php echo base_url(); ?>assets/src/css/style_numbers.css">
<div class="app-body bg-white">
    <main class="main pb-4 pt-4">
        <div class="container-fluid">
            <div data-v-1cbf545e="" class="animated fadeIn container"><h1 data-v-1cbf545e="">월드문자 발송 상세</h1>
                <?php

                ?>
                <table data-v-1cbf545e="" class="border-table mt-4">
                    <tr data-v-1cbf545e="">
                        <td data-v-1cbf545e="">
                            <?php echo $message_detail->created_date; ?>
                        </td>
                        <td data-v-1cbf545e="">
                            <?php echo $message_detail->message; ?>
                        </td>
                        <td data-v-1cbf545e="">
                            발송 <span data-v-1cbf545e=""
                                     class="color-skyblue link"><?php echo $message_detail->quantity; ?></span>
                            /
                            성공 <span data-v-1cbf545e=""
                                     class="color-skyblue link"><?php echo $message_detail->delivered_count; ?></span>
                            /
                            대기 <span data-v-1cbf545e=""
                                     class="color-skyblue link"><?php echo $message_detail->pending_count; ?></span>
                            /
                            미성공 <span data-v-1cbf545e=""
                                      class="color-skyblue link"><?php echo $message_detail->undelivered_count; ?></span>
                            /
                            실패 <span data-v-1cbf545e=""
                                     class="color-skyblue link"><?php echo $message_detail->error_count; ?></span></td>
                    </tr>
                </table>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <form action="<?php echo base_url(); ?>/users/SmsRequestPhoneSearch" method="post">
                            <div role="group" class="input-group  mb-3">
                                <input type="hidden" name="msg_id" value="<?php echo $message_detail->id; ?>">

                                <input id="__BVID__25" type="text" placeholder="Search phone number"
                                       class="form-control form-control" value="" name="phone_number">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-success">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <ul data-v-1cbf545e="" class="recipient-list mt-4">
                    <?php

                    foreach ($numbers as $nb){
                        if(substr($nb->phone_number, 0, 3) === '821') {
                            //$str = substr($num, 1);
                            $str = substr($nb->phone_number, 3);
                            $num = "01" . $str . "";
                        }else{
                            $num = $nb->phone_number;
                        }

                        echo '<li data-v-1cbf545e>';
                        echo '<span data-v-1cbf545e>' . $num . '</span>';
                        if ($nb->success == 0) {
                            echo '<span data-v-1cbf545e title="실패" class="status-label danger">실패</span>';
                        } elseif($nb->success == 2){
                            echo '<span data-v-1cbf545e title="대기" class="status-label bg-blue">대기</span>';
                        } elseif($nb->success == 3){
                            echo '<span data-v-1cbf545e title="대기" class="status-label warning">미성공</span>';
                        } else {
                            echo '<span data-v-1cbf545e title="성공" class="status-label success">성공</span>';
                        }
                        echo '</li>';
                    }
                    ?>
                </ul>

            </div>
        </div>
    </main>
</div>