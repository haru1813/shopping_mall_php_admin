<?php
function message($message,$code = "999"){
    header('Content-Type: application/json');  
    $data = array("code" => $code, "msg" => $message);  
    $result = json_encode($data);
    echo $result;
}
function validateText($text) {
    $pattern = "/^[a-z0-9]{1,20}$/";
    return preg_match($pattern, $text);
}
function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
?>
<?php
$type = $_POST["type"];

if($type == "insert"){
    $haruMarket_productCategory_name = $_POST["haruMarket_productCategory_name"];
    $haruMarket_productCategory_view = $_POST["haruMarket_productCategory_view"];

    if($haruMarket_productCategory_name == ""){
        message("카테고리 이름을 입력하여 주십시오.","500");
        return;
    }

    if($haruMarket_productCategory_view == ""){
        message("홈페이지 노출 여부를 입력하여 주십시오.","500");
        return;
    }

    session_start();
    $haruMarket_productCategory_insertUserIndex = $_SESSION['haruMarket_user_index'];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
    $pdo->beginTransaction();

    try{
        $sql = "insert into harumarket_productcategory(";
        $sql .= "haruMarket_productCategory_name,";
        $sql .= "haruMarket_productCategory_view,";
        $sql .= "haruMarket_productCategory_insertUserIndex";
        $sql .= ") ";
        $sql .= "values(";
        $sql .= "?,";
        $sql .= "?,";
        $sql .= "?";
        $sql .= ")";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(1, $haruMarket_productCategory_name);
        $stmt->bindParam(2, $haruMarket_productCategory_view);
        $stmt->bindParam(3, $haruMarket_productCategory_insertUserIndex);

        $stmt->execute();
    }
    catch(Exception $e){
        $pdo->rollBack();
        message($e->getMessage() ,"500");
        //message("카테고리 등록을 실패하였습니다.","500");
        return;
    }

    $pdo->commit();
    message("카테고리가 등록 되었습니다.","200");
}
if($type == "search"){
    $haruMarket_productCategory_name = $_POST["haruMarket_productCategory_name"];
    $haruMarket_productCategory_view = $_POST["haruMarket_productCategory_view"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select
			t1.haruMarket_productCategory_index
        ,   t1.haruMarket_productCategory_name
        ,   if(t1.haruMarket_productCategory_view='1','노출','비노출') haruMarket_productCategory_view
        ,	DATE_FORMAT(t1.haruMarket_productCategory_insertTime, '%Y년 %m월 %d일 %H시 %i분') haruMarket_productCategory_insertTime
        ,	(select haruMarket_user_id from harumarket_user where haruMarket_user_index=t1.haruMarket_productCategory_insertUserIndex) haruMarket_productCategory_insertUserIndex
		,	DATE_FORMAT(t1.haruMarket_productCategory_updateTime, '%Y년 %m월 %d일 %H시 %i분') haruMarket_productCategory_updateTime
        ,	(select haruMarket_user_id from harumarket_user where haruMarket_user_index=t1.haruMarket_productCategory_updateUserIndex) haruMarket_productCategory_updateUserIndex
        from harumarket_productcategory t1
        where ('$haruMarket_productCategory_name'='' or t1.haruMarket_productCategory_name like '%$haruMarket_productCategory_name%')
        and ('$haruMarket_productCategory_view'='' or t1.haruMarket_productCategory_view = '$haruMarket_productCategory_view')
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
    $haruMarket_productCategory_index = $_POST["haruMarket_productCategory_index"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
    select
			t1.haruMarket_productCategory_name
		,	t1.haruMarket_productCategory_view
        from harumarket_productcategory t1
        where t1.haruMarket_productCategory_index = $haruMarket_productCategory_index
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
    $haruMarket_productCategory_index = $_POST["haruMarket_productCategory_index"];
    $haruMarket_productCategory_name = $_POST["haruMarket_productCategory_name"];
    $haruMarket_productCategory_view = $_POST["haruMarket_productCategory_view"];
    
    if($haruMarket_productCategory_name == ""){
        message("카테고리 이름을 입력하여 주십시오.","500");
        return;
    }

    if($haruMarket_productCategory_view == ""){
        message("홈페이지 노출 여부를 입력하여 주십시오.","500");
        return;
    }

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
    $pdo->beginTransaction();

    try{
        session_start();
        $haruMarket_productCategory_updateUserIndex = $_SESSION['haruMarket_user_index'];

        $sql = "update harumarket_productcategory set ";
        $sql .= "haruMarket_productCategory_name=?,";
        $sql .= "haruMarket_productCategory_view=?,";

        $sql .= "haruMarket_productCategory_updateTime=now(),";
        $sql .= "haruMarket_productCategory_updateUserIndex=? ";
        $sql .= "where haruMarket_productCategory_index=?";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(1, $haruMarket_productCategory_name);
        $stmt->bindParam(2, $haruMarket_productCategory_view);
        $stmt->bindParam(3, $haruMarket_productCategory_updateUserIndex);
        $stmt->bindParam(4, $haruMarket_productCategory_index);

        $stmt->execute();
    }
    catch(Exception $e){
        $pdo->rollBack();
        //message($e->getMessage() ,"500");
        message("카테고리 수정을 실패하였습니다.","500");
        return;
    }

    $pdo->commit();
    message("카테고리가 수정되었습니다.","200");
}
?>