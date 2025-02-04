<?php
    session_start();

    if (!isset($_SESSION['haruMarket_user_index'])){
        echo "<script>location.href = '/index.php';</script>";
    }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>하루마켓 관리자</title>
    <link rel="stylesheet" href="/node_modules/ax5ui-grid/dist/ax5grid.css"/>
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/node_modules/bootstrap-icons/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="/node_modules/toastr/build/toastr.min.css"/>
    <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
    
    <script type="text/javascript" src="/assets/js/common.js?v=<?php echo rand(); ?>"></script>
    <script type="text/javascript" src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="/node_modules/toastr/build/toastr.min.js"></script>
    <script type="text/javascript" src="/node_modules/ax5core/dist/ax5core.min.js"></script>
    <script type="text/javascript" src="/node_modules/ax5ui-grid/dist/ax5grid.min.js"></script>
    <script type="text/javascript" src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
</head>