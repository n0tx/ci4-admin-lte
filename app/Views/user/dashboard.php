<!DOCTYPE html>
<html lang="en">
<?= view('shared/head') ?>

<body>
  <div class="wrapper">
    <?= view('user/navbar') ?>
    <div class="content-wrapper p-4">
      <div class="container" style="max-width: 720px;">
        <div class="card">
          <div class="card-body text-center">
            <h1 class="mb-4">Welcome to Portal!</h1>
            <div class="btn-group btn-block">
              <a href="/user/finance/" class="btn btn-outline-primary py-4">
                <i class="fas fa-2x fa-info"></i><br>
                Financial Performance
              </a>
              <a href="/user/manage/" class="btn btn-outline-primary py-4">
                <i class="fas fa-2x fa-users"></i><br>
                Users
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>