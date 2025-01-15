<?php
    session_start();

    if (isset($_SESSION['haruMarket_user_index'])){
        echo "<script>location.href = '/pages/main.php';</script>";
    }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>하루마켓 관리자</title>
    <link href="/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body style="overflow-x: hidden; overflow-y: hidden;">
    <div id="pc">
        <div class="container-fluid h-100 w-100">
            <div class="row h-100 w-100">
                <div class="col-12 h-100 w-100 d-flex justify-content-center align-items-center">
                    <div class="card mb-5">
                        <div class="card-header">
                            하루마켓 관리자 로그인
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="haruMarket_user_id" class="form-label">아이디</label>
                                <input type="text" class="form-control" id="haruMarket_user_id">
                            </div>
                            <div class="mb-3">
                                <label for="haruMarket_user_pw" class="form-label">비밀번호</label>
                                <input type="password" class="form-control" id="haruMarket_user_pw">
                            </div>
                            <a class="btn btn-primary" id="login">로그인</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="/assets/js/secure.js?v=<?php echo rand(); ?>"></script> -->
    <script src="/assets/js/common.js?v=<?php echo rand(); ?>"></script>
    <script src="/index.js?v=<?php echo rand(); ?>"></script>
</body>
</html>