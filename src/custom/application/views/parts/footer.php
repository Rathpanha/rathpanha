      <footer>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        <div class="px2 py1" style="font-size: 0.9rem;">
          Contact: <a href="tel:089320122">089 320 122</a><br>
          Email: <a href="mailto:dev@rathpanha.com">dev@rathpanha.com</a><br>
            Copyright © 2018 Rathpanha. All rights reserved.<br>
            <?php 
                $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
                echo "Page generated in " . number_format($time, 4) . " seconds with " . DatabaseConnection::getTotalOfQuery() . " database query.";
            ?>
        </div>
    </footer>    
  </body>
</html>
