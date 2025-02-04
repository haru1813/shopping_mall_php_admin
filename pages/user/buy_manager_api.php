<?php
function message($message,$code = "999"){
    header('Content-Type: application/json');  
    $data = array("code" => $code, "msg" => $message);  
    $result = json_encode($data);
    echo $result;
}
?>
<?php
$type = $_POST["type"];

if($type == "search"){
    $haruMarket_user_id = $_POST["haruMarket_user_id"];
    $haruMarket_BuyMaster_order = $_POST["haruMarket_BuyMaster_order"];
    $haruMarket_BuyMaster_buyerName = $_POST["haruMarket_BuyMaster_buyerName"];
    $haruMarket_BuyMaster_buyerAddr = $_POST["haruMarket_BuyMaster_buyerAddr"];
    $haruMarket_BuyMaster_status = $_POST["haruMarket_BuyMaster_status"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select
                    t1.haruMarket_BuyMaster_index
                ,	t1.haruMarket_user_index
                ,	t2.haruMarket_user_id
                ,	t1.haruMarket_BuyMaster_order
                ,	t1.haruMarket_BuyMaster_buyerName
                ,	t1.haruMarket_BuyMaster_buyerPostcode
                ,	t1.haruMarket_BuyMaster_buyerAddr
                ,	t1.haruMarket_BuyMaster_buyerMethod
                ,	t1.haruMarket_BuyMaster_status
                ,	t1.haruMarket_BuyMaster_amount
                ,	DATE_FORMAT(t1.haruMarket_BuyMaster_insertTime, '%Y년 %m월 %d일 %H시 %i분') haruMarket_BuyMaster_insertTime
        from	harumarket_buymaster t1
        inner join	harumarket_user t2 on t1.haruMarket_user_index = t2.haruMarket_user_index
        where       ('$haruMarket_user_id'='' or t2.haruMarket_user_id like '%$haruMarket_user_id%')
        and         ('$haruMarket_BuyMaster_order'='' or t1.haruMarket_BuyMaster_order like '%$haruMarket_BuyMaster_order%')
        and         ('$haruMarket_BuyMaster_buyerName'='' or t1.haruMarket_BuyMaster_buyerName like '%$haruMarket_BuyMaster_buyerName%')
        and         ('$haruMarket_BuyMaster_buyerAddr'='' or t1.haruMarket_BuyMaster_buyerAddr like '%$haruMarket_BuyMaster_buyerAddr%')
        and         ('$haruMarket_BuyMaster_status'='' or t1.haruMarket_BuyMaster_status like '%$haruMarket_BuyMaster_status%')
    ";

    $result = mysqli_query($con, $sql);

    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    message($data,200);
    return;
}
if($type == "search2"){
    $haruMarket_BuyMaster_order = $_POST["haruMarket_BuyMaster_order"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select
                    t1.harumarket_buyDetail_index
                ,	t1.harumarket_product_index
                ,	t3.harumarket_product_name
                ,	t1.harumarket_productColor_index
                ,	t4.harumarket_productColor_name
                ,	t1.harumarket_productSize_index
                ,	t5.harumarket_productSize_name
                ,	t1.harumarket_buyDetail_account
                ,	t1.harumarket_buyDetail_amount
        from	harumarket_buydetail t1
        inner join	harumarket_user t2 on t1.haruMarket_user_index = t2.haruMarket_user_index
        inner join	harumarket_product t3 on t1.harumarket_product_index = t3.harumarket_product_index
        left join	harumarket_productcolor t4 on t1.harumarket_productColor_index = t4.harumarket_productColor_index
        left join	harumarket_productsize t5 on t1.harumarket_productSize_index = t5.harumarket_productSize_index
        where       t1.haruMarket_BuyMaster_order='$haruMarket_BuyMaster_order'
    ";

    $result = mysqli_query($con, $sql);

    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    message($data,200);
    return;
}
if($type == "update"){
    $haruMarket_BuyMaster_index = $_POST["haruMarket_BuyMaster_index"];
    $haruMarket_BuyMaster_status = $_POST["haruMarket_BuyMaster_status"];
    $sql = "";

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
    $pdo->beginTransaction();

    try{
        $sql = "update harumarket_buymaster set haruMarket_BuyMaster_status=? where haruMarket_BuyMaster_index=?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $haruMarket_BuyMaster_status);
        $stmt->bindParam(2, $haruMarket_BuyMaster_index);
        $stmt->execute();
    }
    catch(Exception $e){
        $pdo->rollBack();
        //message($e->getMessage() ,"500");
        message("수정을 실패하였습니다.","500");
        return;
    }

    $pdo->commit();
    message("수정을 성공하였습니다.","200");
}
?>