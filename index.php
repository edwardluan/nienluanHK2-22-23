<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include('admin/db_connect.php');
ob_start();
$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
foreach ($query as $key => $value) {
  if (!is_numeric($key))
    $_SESSION['system'][$key] = $value;
}
ob_end_flush();
include('header.php');


?>

<style>
  header.masthead {
    background: url(admin/assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>);
    background-repeat: no-repeat;
    background-size: cover;
  }

  #viewer_modal .btn-close {
    position: absolute;
    z-index: 999999;
    /*right: -4.5em;*/
    background: unset;
    color: white;
    border: unset;
    font-size: 27px;
    top: 0;
  }

  #viewer_modal .modal-dialog {
    width: 80%;
    max-width: unset;
    height: calc(90%);
    max-height: unset;
  }

  #viewer_modal .modal-content {
    background: black;
    border: unset;
    height: calc(100%);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  #viewer_modal img,
  #viewer_modal video {
    max-height: calc(100%);
    max-width: calc(100%);
  }

  body,
  footer {
    background: #000000e6 !important;
  }


  a.jqte_tool_label.unselectable {
    height: auto !important;
    min-width: 4rem !important;
    padding: 5px
  }

  /*
a.jqte_tool_label.unselectable {
    height: 22px !important;
}*/
</style>

<body id="page-top">
  <!-- Navigation-->
  <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body text-white">
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav" style="display: flex;">
    <div class="container" style="display: flex; align-items: center;">
      <img
        src="https://upload.wikimedia.org/wikipedia/vi/thumb/6/6c/Logo_Dai_hoc_Can_Tho.svg/800px-Logo_Dai_hoc_Can_Tho.svg.png"
        alt="Logo" style="height: 50px; width: auto;">
      <a class="navbar-brand js-scroll-trigger" href="./" style="margin-left: 10px;">
        <?php echo $_SESSION['system']['name'] ?>
      </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
        data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
        aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto my-2 my-lg-0">
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=home">Trang chủ</a></li>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=alumni_list">Viên chức</a>
          </li>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=forum">Diễn đàn</a></li>
          <?php if (isset($_SESSION['login_id'])): ?>
            <!-- <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=forum">Diễn đàn</a></li> -->
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=about">Thông tin</a></li>
          <?php if (!isset($_SESSION['login_id'])): ?>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#" id="login">Đăng nhập</a></li>
          <?php else: ?>
            <li class="nav-item">
              <div class="dropdown mr-4">
                <a href="#" class="nav-link js-scroll-trigger" id="account_settings" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <?php echo $_SESSION['login_name'] ?> <i class="fa fa-angle-down"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
                  <a class="dropdown-item" href="index.php?page=my_account" id="manage_my_account"><i
                      class="fa fa-cog"></i>Quản lý tài khoản</a>
                  <a class="dropdown-item" href="admin/ajax.php?action=logout2"><i class="fa fa-power-off"></i>Đăng
                    xuất</a>
                </div>
              </div>
            </li>
          <?php endif; ?>


        </ul>
      </div>
      <div id="language-switcher" style="display: flex; align-items: center; margin-left: auto;">
        <br><a href="#" class="language-link" data-lang="vi"><img
            src="https://cdn.countryflags.com/thumbs/vietnam/flag-round-250.png" alt="Vietnamese Flag"
            style="height: 25px; width: auto;"></a><br>
        <a href="#" class="language-link" data-lang="en"><img
            src="https://cdn.countryflags.com/thumbs/united-kingdom/flag-round-250.png" alt="English Flag"
            style="height: 25px; width: auto;"></a>
        <script>
          var languageLinks = document.querySelectorAll('.language-link');
          for (var i = 0; i < languageLinks.length; i++) {
            languageLinks[i].addEventListener('click', function (e) {
              e.preventDefault();
              var lang = this.getAttribute('data-lang');
              window.location.href = window.location.href.split('?')[0] + '?lang=' + lang;
            });
          }
        </script>

      </div>

    </div>
  </nav>


  <?php
  $page = isset($_GET['page']) ? $_GET['page'] : "home";
  include $page . '.php';
  ?>


  <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Xác nhận</h5>
        </div>
        <div class="modal-body">
          <div id="delete_content"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='confirm' onclick="">Tiếp tục</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Lưu</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy bỏ</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="fa fa-arrow-righ t"></span>
          </button>
        </div>
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
        <img src="" alt="">
      </div>
    </div>
  </div>
  <div id="preloader"></div>
  <style>
    /* cố định footer ở cuối trang */
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    main {
      flex: 1;
    }
  </style>

  <main>
    <!-- Nội dung trang web ở đây -->
  </main>

  <footer class="py-5 mt-auto" style="background-color: transparent;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h2 class="mt-0 text-white">Thông tin liên hệ</h2>
          <hr class="divider my-4" />
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
          <i class="fas fa-phone fa-3x mb-3 text-muted"></i>
          <div class="text-white">
            <?php echo $_SESSION['system']['contact'] ?>
          </div>
        </div>
        <div class="col-lg-4 mr-auto text-center">
          <i class="fas fa-envelope fa-3x mb-3 text-muted"></i>
          <a class="d-block" href="mailto:<?php echo $_SESSION['system']['email'] ?>"><?php echo $_SESSION['system']['email'] ?></a>
        </div>
      </div>
    </div>
    <br>
    <div class="container">
      <div class="small text-center text-muted">Copyright © 2023 -
        <?php echo $_SESSION['system']['name'] ?>
      </div>
    </div>
  </footer>




  <?php include('footer.php') ?>
</body>
<script type="text/javascript">
  $('#login').click(function () {
    uni_modal("Login", 'login.php')
  })
</script>
<?php $conn->close() ?>

</html>