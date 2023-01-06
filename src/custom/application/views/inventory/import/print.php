<!DOCTYPE HTML>
<html>
  <head>
    <title>ទីលានរទេះ <?php sp(date("d-m-Y", strtotime($date))); ?></title>
    
    <link rel="stylesheet" href="/css/print-page.css?2"/>
    <style>
      .fn-red {
        color: #F00 !important;
      }
    </style>
  </head>
  
  <body>
    <center>
      <span class="muollight">ទីលានរទេះ <?php sp(date("d-m-Y", strtotime($date))); ?></span><br><br>
    </center>
  
    <table>
      <thead>
        <tr>
          <th class="bold" style="width: 50px;">លរ</th>
          <th class="bold" style="width: 150px;">ឈ្មោះម្ចាស់</th>
          <th class="bold" style="width: 50px;">ធំ</th>
          <th class="bold" style="width: 50px;">តូច</th>
          <th class="bold">ទំនិញ</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach($imports->data as $key => $value) { ?>
          <tr>
            <td><?php sp($key + 1); ?></td>
            <td class="left"><?php echo !empty($value->merchant_name) ? $value->merchant_name : "<span class='fn-red'>មិនមាន<span>"; ?></td>
            <td><?php sp(number_format($value->import_cart_big)); ?></td>
            <td><?php sp(number_format($value->import_cart_small)); ?></td>
            <td class="left no-ellipsis">
              <?php echo InventoryImport::convertInventoryNameToHTML($value->inventories); ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  
    <footer>

    </footer>
  
    <script>
      (function() {
        window.print();
      })();
    </script>
  </body>
</html>