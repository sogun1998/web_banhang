<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
    include('./ket_noi.php');
    header('Content-Type: text/html; charset=UTF-8');
    ////Lấy thông tin người cần update
    $presentname = $_SESSION['login_user'];
    $result=pg_query($conn,"SELECT * FROM khach_hang WHERE ten_khach_hang = '$presentname'");
    if (!$result) {
         echo "An error occurred.\n";
        exit;
        }
    else {
        $arr=pg_fetch_array($result);
        // echo $arr["ten_khach_hang"];
    }
    //// lấy các nội dung mới

    $username   = addslashes($_POST['name']);
    $password   = addslashes($_POST['password']);
    $repassword   = addslashes($_POST['repassword']);
    $email      = addslashes($_POST['email']);
    $address   = addslashes($_POST['address']);
    $telephone   = addslashes($_POST['telephone']);
    //ma hóa mật khẩu
    $password = md5($password);
    //gán id cho new user
    //kiểm tra tên có trong database
     //Kiểm tra email đã có người dùng chưa
    if (!(pg_affected_rows(pg_query($conn,"SELECT email FROM khach_hang WHERE email='$email'")) == 0 || $arr['email']==$email))
    {
        echo "<script type='text/javascript'>alert('Email này đã có người dùng. Vui lòng chọn Email khác.'); window.history.back();</script>";
        exit;
    }
    //Kiểm tra nhập lại đúng password
    else if ($_POST['password'] != $_POST['repassword']) {
        echo "<script type='text/javascript'>alert('Vui lòng nhập lại đúng mật khẩu.'); window.history.back();</script>";
        exit;
    }
    echo $presentname;
    $updatemember = pg_query($conn,"
        UPDATE khach_hang
        SET 
            mat_khau = '$password',
            email = '$email',
            dia_chi = '$address',
            dien_thoai = '$telephone'
        WHERE ten_khach_hang = '$presentname'
    ");
    if ($updatemember)
        echo "<script type='text/javascript'>alert('Bạn đã cập nhật thành công thông tin. Bạn hãy đăng nhập lại để tận hưởng các dịch vụ của chúng tôi'); window.location.href='?thamso=logout';</script>";
    else
        echo "<script type='text/javascript'>alert('Có lỗi trong quá trình đăng ký.');";
}

 ?>

<head>
       <link rel="stylesheet" type="text/css" href="giao_dien/grid.css">
        <link rel="stylesheet" type="text/css" href="giao_dien/animate.css">
        <link rel="stylesheet" type="text/css" href="giao_dien/ionicons.min.css">
        <link rel="stylesheet" type="text/css" href="giao_dien/normalize.css">
        <link rel="stylesheet" type="text/css" href="giao_dien/register_form.css">
        </head>


 <section class="section-form" class="register_form" id="register">
            <div class="row">
                <h2>CẬP NHẬT THÔNG TIN KHÁCH HÀNG</h2>
                <?php echo "<h2 style= 'font-size: 24px;
    margin: 0 0';>Ten khach hang :   ".$_SESSION['login_user']."</h2>"; ?>
            </div>
            <div class="row">
                <form method="post" action="" class="contact-form" method="POST">
                    <div class="form-group">
                        <label for="name">Mật khẩu</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Mật khẩu">
                    </div>
                     <div class="form-group">
                        <label for="name">Nhập lại mật khẩu</label>
                        <input type="password" class="form-control" name="repassword" id="repassword" placeholder="Nhập lại mật khẩu">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Email" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input type="text" name="address" id="address" placeholder="Địa chỉ" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="telephone">Số điện thoại</label>
                        <input type="text" name="telephone" id="telephone" placeholder="Số điện thoại" required class="form-control">
                    </div>
                    <div class="form-group" style="text-align: center;">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-success">Cập nhật</button>
                    </div>

                </form>

            </div>
        </section>