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

if($type == "harumarket_OpsionSelect"){
    $table_name = $_POST["table_name"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "select * from $table_name;";

    $result = mysqli_query($con, $sql);

    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    message($data,200);
    return;
}
if($type == "insert"){
    $haruMarket_productCategory_index = $_POST["haruMarket_productCategory_index"];
    $harumarket_product_name = $_POST["harumarket_product_name"];
    $harumarket_product_colorView = $_POST["harumarket_product_colorView"];
    $harumarket_product_sizeView = $_POST["harumarket_product_sizeView"];
    $harumarket_product_colorIndexs = $_POST["harumarket_product_colorIndexs"];
    $harumarket_product_sizeIndexs = $_POST["harumarket_product_sizeIndexs"];

    $target_dir = "./"; 
    $target_file = $target_dir . basename($_FILES["harumarket_product_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["harumarket_product_picture"]["tmp_name"], $target_file);
    $harumarket_product_picture = file_get_contents($target_file);
    
    $harumarket_product_content = $_POST["harumarket_product_content"];

    $harumarket_product_view = $_POST["harumarket_product_view"];
    $harumarket_product_originPrice = $_POST["harumarket_product_originPrice"];
    $harumarket_product_salePrice = $_POST["harumarket_product_salePrice"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
    $pdo->beginTransaction();

    try{
        session_start();
        $harumarket_product_insertUserIndex = $_SESSION['haruMarket_user_index'];

        $sql = "insert into harumarket_product(";
        $sql .= "haruMarket_productCategory_index,";
        $sql .= "harumarket_product_name,";
        $sql .= "harumarket_product_colorView,";
        $sql .= "harumarket_product_sizeView,";
        $sql .= "harumarket_product_colorIndexs,";
        $sql .= "harumarket_product_sizeIndexs,";
        $sql .= "harumarket_product_picture,";
        $sql .= "harumarket_product_content,";
        $sql .= "harumarket_product_insertUserIndex,";
        $sql .= "harumarket_product_view,";
        $sql .= "harumarket_product_originPrice,";
        $sql .= "harumarket_product_salePrice";
        $sql .= ") values(?,?,?,?,?,?,?,?,?,?,?,?);";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(1, $haruMarket_productCategory_index);
        $stmt->bindParam(2, $harumarket_product_name);
        $stmt->bindParam(3, $harumarket_product_colorView);
        $stmt->bindParam(4, $harumarket_product_sizeView);
        $stmt->bindParam(5, $harumarket_product_colorIndexs);
        $stmt->bindParam(6, $harumarket_product_sizeIndexs);
        $stmt->bindParam(7, $harumarket_product_picture);
        $stmt->bindParam(8, $harumarket_product_content);
        $stmt->bindParam(9, $harumarket_product_insertUserIndex);
        $stmt->bindParam(10, $harumarket_product_view);
        $stmt->bindParam(11, $harumarket_product_originPrice);
        $stmt->bindParam(12, $harumarket_product_salePrice);

        $stmt->execute();
    }
    catch(Exception $e){
        $pdo->rollBack();
        //message($e->getMessage() ,"500");
        message("상품 등록을 실패하였습니다.","500");
        return;
    }

    unlink($target_file);
    $pdo->commit();
    message("상품을 등록하였습니다.","200");
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