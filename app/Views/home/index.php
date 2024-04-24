<!DOCTYPE html>
<html lang="en">
<?= view('shared/head') ?>

<body>
  <div class="wrapper">
    <?= view('home/navbar') ?>
    <div class="content-wrapper p-4 text-navy">
      <div class="card my-3">
        <div class="row gutter-0">
          <div class="col-lg-8 d-none d-lg-block">
            <img src=<?= $image_url ?> >
          </div>
        </div>
      </div>
      <div class="card my-3">
        <div class="row gutter-0">
          <div class="col-lg-8 d-none d-lg-block">
            <img src=<?= $image_url ?> >
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>