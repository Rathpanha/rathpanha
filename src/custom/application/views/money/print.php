<!DOCTYPE HTML>
<html>
  <head>
    <title>តារាងរបាយការណ៍ប្រាក់សាងសង់ទីលានរទេះ(<?php sp($start_date . " - " . $end_date); ?>)</title>
    
    <link rel="stylesheet" href="/css/print-page.css"/>
    <style>
      @page {
        margin-left: 2cm;
        margin-right: 2cm;
      }
    </style>
  </head>
  
  <body>
    <center>
      <span class="muollight">ព្រះរាជាណាចក្រកម្ពុជា</span><br>
      <span class="muollight underline">ជាតិ សាសនា ព្រះមហាក្សត្រ</span><br><br><br>
      <span class="muollight">តារាងរបាយការណ៍<?php sp(Money::$types[$type]); ?></span>
    </center>
  
    <table>
      <thead>
        <tr>
          <th class="bold" style="width: 40px;">លរ</th>
          <th class="bold" style="width: 100px;">ថ្ងៃទី.ខែ.ឆ្នាំ</th>
          <th class="bold" style="width: 115px;">ចំណូល</th>
          <th class="bold" style="width: 115px;">ចំណាយ</th>
          <th class="bold" style="width: 115px;">ចំនួនបូកបន្ត</th>
          <th class="bold">ផ្សេងៗ</th>
        </tr>
      </thead>

      <tbody>
        <?php $amount_plus = 0; ?>
        <?php foreach($money_records->data as $key => $value) { ?>
          <?php $amount_plus += $value->money_amount_income; ?>
          <?php $amount_plus -= $value->money_amount_expense; ?>

          <tr>
            <td><?php sp($key + 1); ?></td>
            <td><?php sp(date("d-m-Y", strtotime($value->money_date))); ?></td>
            <td class="right"><?php sp(number_format($value->money_amount_income)); ?> ៛</td>
            <td class="right"><?php sp(number_format($value->money_amount_expense)); ?> ៛</td>
            <td class="right"><?php sp(number_format($amount_plus)); ?> ៛</td>
            <td class="left"><?php sp($value->money_note); ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  
    <footer>
      <div style="display: flex; width: 100%; margin-top: 2rem;">
        <div style="text-align: center;">
          ថ្ងៃទី​  ..........​ ខែ ............... ឆ្នាំ  ..........<br>
          <span class="muollight">អនុប្រធានទទួលបន្ទុក</span>
          <br><br><br>
          ..............................
        </div>

        <div style="flex-grow: 1;"></div>

        <div style="text-align: center;">
          ថ្ងៃទី​  ..........​ ខែ ............... ឆ្នាំ  ..........<br>
          <span class="muollight">អ្នកធ្វើរបាយការណ៍</span>
          <br><br><br>
          ..............................
        </div>
      </div>
    </footer>
  
    <script>
      (function() {
        window.print();
      })();
    </script>
  </body>
</html>