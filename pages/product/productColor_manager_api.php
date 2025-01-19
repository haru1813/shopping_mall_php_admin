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

if($type == "insert"){
    $harumarket_productColor_name = $_POST["harumarket_productColor_name"];

    if($harumarket_productColor_name == ""){
        message("상품 색상 이름을 입력하여 주십시오.","500");
        return;
    }

    session_start();
    $harumarket_productColor_insertUserIndex = $_SESSION['haruMarket_user_index'];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
    $pdo->beginTransaction();

    try{
        $sql = "insert into harumarket_productcolor(";
        $sql .= "harumarket_productColor_name,";
        $sql .= "harumarket_productColor_insertUserIndex";
        $sql .= ") ";
        $sql .= "values(";
        $sql .= "?,";
        $sql .= "?";
        $sql .= ")";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(1, $harumarket_productColor_name);
        $stmt->bindParam(2, $harumarket_productColor_insertUserIndex);

        $stmt->execute();
    }
    catch(Exception $e){
        $pdo->rollBack();
        //message($e->getMessage() ,"500");
        message("색상 등록을 실패하였습니다.","500");
        return;
    }

    $pdo->commit();
    message("색상이 등록 되었습니다.","200");
}
if($type == "search"){
    $harumarket_productColor_name = $_POST["harumarket_productColor_name"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select
			t1.harumarket_productColor_index
        ,   t1.harumarket_productColor_name
        ,	DATE_FORMAT(t1.harumarket_productColor_insertTime, '%Y년 %m월 %d일 %H시 %i분') harumarket_productColor_insertTime
        ,	(select haruMarket_user_id from harumarket_user where haruMarket_user_index=t1.harumarket_productColor_insertUserIndex) harumarket_productColor_insertUserIndex
		,	DATE_FORMAT(t1.harumarket_productColor_updateTime, '%Y년 %m월 %d일 %H시 %i분') harumarket_productColor_updateTime
        ,	(select haruMarket_user_id from harumarket_user where haruMarket_user_index=t1.harumarket_productColor_updateUserIndex) harumarket_productColor_updateUserIndex
        from harumarket_productcolor t1
        where ('$harumarket_productColor_name'='' or t1.harumarket_productColor_name like '%$harumarket_productColor_name%')
    ";

    $result = mysqli_query($con, $sql);

    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    message($data,200);
    return;
}
if($type == "view"){
    $harumarket_productColor_index = $_POST["harumarket_productColor_index"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
    select
			t1.harumarket_productColor_name
        from harumarket_productColor t1
        where t1.harumarket_productColor_index = $harumarket_productColor_index
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
    $harumarket_productColor_index = $_POST["harumarket_productColor_index"];
    $harumarket_productColor_name = $_POST["harumarket_productColor_name"];
    
    if($harumarket_productColor_name == ""){
        message("색상 이름을 입력하여 주십시오.","500");
        return;
    }

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
    $pdo->beginTransaction();

    try{
        session_start();
        $harumarket_productColor_updateUserIndex = $_SESSION['haruMarket_user_index'];

        $sql = "update harumarket_productcolor set ";
        $sql .= "harumarket_productColor_name=?,";

        $sql .= "harumarket_productColor_updateTime=now(),";
        $sql .= "harumarket_productColor_updateUserIndex=? ";
        $sql .= "where harumarket_productColor_index=?";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(1, $harumarket_productColor_name);
        $stmt->bindParam(2, $harumarket_productColor_updateUserIndex);
        $stmt->bindParam(3, $harumarket_productColor_index);

        $stmt->execute();
    }
    catch(Exception $e){
        $pdo->rollBack();
        //message($e->getMessage() ,"500");
        message("상품 색상 수정을 실패하였습니다.","500");
        return;
    }

    $pdo->commit();
    message("상품 색상이 수정되었습니다.","200");
}
?>