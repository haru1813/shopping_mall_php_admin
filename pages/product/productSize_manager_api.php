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
    $harumarket_productSize_name = $_POST["harumarket_productSize_name"];

    if($harumarket_productSize_name == ""){
        message("상품 색상 이름을 입력하여 주십시오.","500");
        return;
    }

    session_start();
    $harumarket_productSize_insertUserIndex = $_SESSION['haruMarket_user_index'];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
    $pdo->beginTransaction();

    try{
        $sql = "insert into harumarket_productsize(";
        $sql .= "harumarket_productSize_name,";
        $sql .= "harumarket_productSize_insertUserIndex";
        $sql .= ") ";
        $sql .= "values(";
        $sql .= "?,";
        $sql .= "?";
        $sql .= ")";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(1, $harumarket_productSize_name);
        $stmt->bindParam(2, $harumarket_productSize_insertUserIndex);

        $stmt->execute();
    }
    catch(Exception $e){
        $pdo->rollBack();
        //message($e->getMessage() ,"500");
        message("크기 등록을 실패하였습니다.","500");
        return;
    }

    $pdo->commit();
    message("크기가 등록 되었습니다.","200");
}
if($type == "search"){
    $harumarket_productSize_name = $_POST["harumarket_productSize_name"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select
			t1.harumarket_productSize_index
        ,   t1.harumarket_productSize_name
        ,	DATE_FORMAT(t1.harumarket_productSize_insertTime, '%Y년 %m월 %d일 %H시 %i분') harumarket_productSize_insertTime
        ,	(select haruMarket_user_id from harumarket_user where haruMarket_user_index=t1.harumarket_productSize_insertUserIndex) harumarket_productSize_insertUserIndex
		,	DATE_FORMAT(t1.harumarket_productSize_updateTime, '%Y년 %m월 %d일 %H시 %i분') harumarket_productSize_updateTime
        ,	(select haruMarket_user_id from harumarket_user where haruMarket_user_index=t1.harumarket_productSize_updateUserIndex) harumarket_productSize_updateUserIndex
        from harumarket_productsize t1
        where ('$harumarket_productSize_name'='' or t1.harumarket_productSize_name like '%$harumarket_productSize_name%')
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
    $harumarket_productSize_index = $_POST["harumarket_productSize_index"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
    select
			t1.harumarket_productSize_name
        from harumarket_productsize t1
        where t1.harumarket_productSize_index = $harumarket_productSize_index
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
    $harumarket_productSize_index = $_POST["harumarket_productSize_index"];
    $harumarket_productSize_name = $_POST["harumarket_productSize_name"];
    
    if($harumarket_productSize_name == ""){
        message("사이즈 이름을 입력하여 주십시오.","500");
        return;
    }

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
    $pdo->beginTransaction();

    try{
        session_start();
        $harumarket_productSize_updateUserIndex = $_SESSION['haruMarket_user_index'];

        $sql = "update harumarket_productsize set ";
        $sql .= "harumarket_productSize_name=?,";

        $sql .= "harumarket_productSize_updateTime=now(),";
        $sql .= "harumarket_productSize_updateUserIndex=? ";
        $sql .= "where harumarket_productSize_index=?";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(1, $harumarket_productSize_name);
        $stmt->bindParam(2, $harumarket_productSize_updateUserIndex);
        $stmt->bindParam(3, $harumarket_productSize_index);

        $stmt->execute();
    }
    catch(Exception $e){
        $pdo->rollBack();
        //message($e->getMessage() ,"500");
        message("상품 크기 수정을 실패하였습니다.","500");
        return;
    }

    $pdo->commit();
    message("상품 크기가 수정되었습니다.","200");
}
?>