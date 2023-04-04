<?php
include 'admin/db_connect.php';
?>
<style>
    #portfolio .img-fluid {
        width: calc(100%);
        height: 30vh;
        z-index: -1;
        position: relative;
        padding: 1em;
    }

    .alumni-list {
        cursor: pointer;
        border: unset;
        flex-direction: inherit;
    }

    .alumni-img {
        width: calc(30%);
        max-height: 30vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .alumni-list .card-body {
        width: calc(70%);
    }

    .alumni-img img {
        border-radius: 100%;
        max-height: calc(100%);
        max-width: calc(100%);
    }

    span.hightlight {
        background: yellow;
    }

    .carousel,
    .carousel-inner,
    .carousel-item {
        min-height: calc(100%)
    }

    header.masthead,
    header.masthead:before {
        min-height: 50vh !important;
        height: 50vh !important
    }

    .row-items {
        position: relative;
    }

    .card-left {
        left: 0;
    }

    .card-right {
        right: 0;
    }

    .rtl {
        direction: rtl;
    }

    .alumni-text {
        justify-content: center;
        align-items: center;
    }

    .masthead {
        min-height: 23vh !important;
        height: 23vh !important;
    }

    .masthead:before {
        min-height: 23vh !important;
        height: 23vh !important;
    }

    .alumni-list p {
        margin: unset;
    }
</style>

<div class="container-fluid mt-3 pt-2">

    <div class="row-items">
        <div class="col-lg-12">
            <div class="row">
                <?php
                $fpath = 'admin/assets/uploads';
                $alumni = $conn->query("SELECT a.*,c.course,Concat(a.lastname,', ',a.firstname,' ',a.middlename) as name from alumnus_bio a inner join courses c on c.id = a.course_id order by Concat(a.lastname,', ',a.firstname,' ',a.middlename) asc");
                while ($row = $alumni->fetch_assoc()):
                    ?>
                    <div class="col-md-4 item">
                        <div class="card alumni-list" data-id="<?php echo $row['id'] ?>">
                            <div class="alumni-img" card-img-top>

                                <img src="<?php echo $fpath . '/' . $row['avatar'] ?>" alt="">
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center h-100">
                                    <div class="">
                                        <div>
                                            <p class="filter-txt"><b>
                                                    <?php echo $row['name'] ?>
                                                </b>
                                            </p>
                                            <hr class="divider w-100" style="max-width: calc(100%)">
                                            <p class="filter-txt">Email: <b>
                                                    <?php echo $row['email'] ?>
                                                </b>
                                            </p>
                                            <p class="filter-txt">Khoa: <b>
                                                    <?php echo $row['course'] ?>
                                                </b>
                                            </p>
                                            <p class="filter-txt">Công tác ở trường từ: <b>
                                                    <?php echo $row['batch'] ?>
                                                </b>
                                            </p>
                                            <p class="filter-txt">Mã giáo viên: <b>
                                                    <?php echo $row['macb'] ?>
                                                </b>
                                            </p>
                                            <!-- <p class="filter-txt">Đang công tác ở: <b>
                                                    <?php echo $row['connected_to'] ?>
                                                </b>
                                            </p> -->
                                            <br>
                                            <?php
                                            $macb = $row['macb'];
                                            $query = "SELECT * FROM links WHERE macb='$macb'";
                                            $result = mysqli_query($conn, $query);
                                            if (mysqli_num_rows($result) > 0) {
                                                $link_row = mysqli_fetch_assoc($result);
                                                ?>
                                                    <button class="btn btn-primary" id="view-more-button"
                                                        onclick="window.location.href='<?php echo $link_row['link'] ?>'">Xem thêm
                                                    </button>
                                                    <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>