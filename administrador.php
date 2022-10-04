<?php include 'api/funcoes.php'; ?>
<?php include 'api/head.php'; ?>
<?php include 'api/menu.php'; ?>    

    <div class="container">
        <?php for($i=0;$i<100;$i++){ ?>
        <div class="row">
          <div class="col-sm">
            <?php echo $i; ?>One of three columns
          </div>
          <div class="col-sm">
            One of three columns
          </div>
          <div class="col-sm">
            One of three columns
          </div>
        </div>
        <?php } ?>
    </div>
<?php include 'api/foot.php'; ?>