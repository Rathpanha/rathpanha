<?php $this->show("/parts/header"); ?>

<div class="wrap-content">
  <div class="measure">
    <h3 class="m0"><?php echo lang("MONEY RECORD LIST"); ?></h3>
    
    <form method="GET" autocomplete="off">
      <input type="date" name="start_date" value="<?php echo $start_date; ?>"/> -
      <input type="date" name="end_date" value="<?php echo $end_date; ?>"/>
        
      <select name="type" required>
        <option value="1" <?php if($type === "1") { echo "selected"; } ?>>ប្រាក់សាងសង់ទីលានរទេះ</option>
        <option value="2" <?php if($type === "2") { echo "selected"; } ?>>ប្រាក់អគ្គិសនីនិងទឹក</option>
      </select>
        
      <?php if(!empty($_GET['start_date']) || !empty($_GET['end_date'])) { ?>
        <a class="btn red" href="/money/list?type=2"><i class="fas fa-times"></i></a>
      <?php } ?>
      <button class="btn"><i class="fas fa-search"></i></button>
      <a class="btn mint" target="_blank" href="/money/print?type=<?php echo $type ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>"><i class="fas fa-print"></i></a>
    </form>
    
    <?php if(!empty($money_records->data)) { ?>
      <div class="wrap-table myt1">
        <table class="list">
          <thead>
            <tr>
              <th>Nº</th>
              <th style="width: 100px;">Date</th>
              <th class="right" style="width: 200px;">Income</th>
              <th class="right" style="width: 200px;">Expense</th>
              <th class="right" style="width: 200px;">Amount Plus</th>
              <th>Note</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            <?php $amount_plus = 0; ?>
            <?php foreach($money_records->data as $key => $value) { ?>
              <?php $amount_plus += $value->money_amount_income; ?>
              <?php $amount_plus -= $value->money_amount_expense; ?>

              <tr>
                <td><?php sp($key + 1); ?></td>
                <td><?php sp($value->money_date); ?></td>
                <td class="right"><?php sp(number_format($value->money_amount_income)); ?> ៛</td>
                <td class="right"><?php sp(number_format($value->money_amount_expense)); ?> ៛</td>
                <td class="right"><?php sp(number_format($amount_plus)); ?> ៛</td>
                <td><?php sp($value->money_note); ?></td>
                <td><a href="/money/edit/<?php sp($value->money_id); ?>" class="btn btn-xsmall"><i class="fas fa-edit"></i></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    
      <center><?php echo $money_records->pagination; ?></center>
    <?php } else { ?>
      <label><?php sp(lang("There is no record in this month yet")) ?>.</label>
    <?php } ?>
  </div>
</div>

<?php $this->show("/parts/footer"); ?>