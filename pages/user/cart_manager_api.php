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
    $harumarket_product_name = $_POST["harumarket_product_name"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select
                            t1.harumarket_userBasket_index
                        ,	t1.haruMarket_user_index
                        ,	t2.haruMarket_user_id
                        ,	t1.harumarket_product_index
                        ,	t3.harumarket_product_name
                        ,	t1.harumarket_productColor_index
                        ,	t4.harumarket_productColor_name
                        ,	t1.harumarket_productSize_index
                        ,	t5.harumarket_productSize_name
                        ,	t1.harumarket_userBasket_account
                        ,	t3.harumarket_product_salePrice
                        ,	DATE_FORMAT(t1.harumarket_userBasket_insertTime, '%Y년 %m월 %d일 %H시 %i분') harumarket_userBasket_insertTime
        from			harumarket_userbasket t1
        inner join	harumarket_user t2 on t1.haruMarket_user_index = t2.haruMarket_user_index
        inner join	harumarket_product t3 on t1.harumarket_product_index = t3.harumarket_product_index
        left join	harumarket_productcolor t4 on t1.harumarket_productColor_index = t4.harumarket_productColor_index
        left join	harumarket_productsize t5 on t1.harumarket_productSize_index = t5.harumarket_productSize_index
        where       ('$haruMarket_user_id'='' or t2.haruMarket_user_id like '%$haruMarket_user_id%')
        and         ('$harumarket_product_name'='' or t3.harumarket_product_name like '%$harumarket_product_name%')
    ";

    $result = mysqli_query($con, $sql);

    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    message($data,200);
    return;
}
if($type == "delete"){
    $harumarket_userBasket_index = $_POST["harumarket_userBasket_index"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
    $pdo->beginTransaction();

    try{
        $sql = "delete from harumarket_userbasket where harumarket_userBasket_index=?;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $harumarket_userBasket_index);
        $stmt->execute();
    }
    catch(Exception $e){
        $pdo->rollBack();
        //message($e->getMessage() ,"500");
        message("삭제를 실패하였습니다.","500");
        return;
    }

    $pdo->commit();
    message("삭제 되었습니다.","200");
}
?>