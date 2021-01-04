<div class="table-scrollable table-scrollable-borderless">

     <table class="table table-hover table-light">
          <thead>
               <tr class=" uppercase">
                    <th class="font-grey-salt">
                         <?php if ($type == 'day'): ?>
                              날짜
                         <?php else: ?>
                              월
                         <?php endif; ?>
                    </th>
                    <th  class="font-grey-salt">총 건수</th>
                    <th class="font-grey-salt">성공</th>
                    <th class="font-grey-salt">실패</th>

                    <th class="font-grey-salt">CASH</th>
               </tr>

          </thead>
          <tbody>
               <?php if (sizeof($rows) > 0){ ?>
                    <?php foreach ($rows as $row): ?>
                         <tr>
                              <td class="font-blue bold"><?php echo $row->created_date ?></td>
                              <td><?php echo $row->quantity_total ?></td>
                              <td><?php echo $row->delivered_total ?></td>
                              <td><?php echo $row->undelivered_total ?></td>

                              <td class="bold"><?php echo $row->cash ?>Cash</td>
                         </tr>
                    <?php endforeach; ?>
               <?php }else{ ?>
                    <tr>
                         <td class="7">                    결과 없습니다.</td>
                    </tr>
               <?php }?>

          </tbody>
     </table>
</div>
