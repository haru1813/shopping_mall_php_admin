<?php
function message($message,$code = "999"){
    header('Content-Type: application/json');  
    $data = array("code" => $code, "msg" => $message);  
    $result = json_encode($data);
    echo $result;
}
function textToArray($text) {
    preg_match_all('/\d+/', $text, $matches);
    return array_map('intval', $matches[0]);
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
    $harumarket_product_picture = $_POST["harumarket_product_picture"];
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

    $pdo->commit();
    message("상품을 등록하였습니다.","200");
}
if($type == "search"){
    $harumarket_product_view = $_POST["harumarket_product_view"];
    $haruMarket_productCategory_index = $_POST["haruMarket_productCategory_index"];
    $harumarket_product_name = $_POST["harumarket_product_name"];
    $harumarket_product_colorView = $_POST["harumarket_product_colorView"];
    $harumarket_product_sizeView = $_POST["harumarket_product_sizeView"];
    $harumarket_product_colorIndexs = $_POST["harumarket_product_colorIndexs"];
    $harumarket_product_sizeIndexs = $_POST["harumarket_product_sizeIndexs"];

    $harumarket_product_originPrice_min = $_POST["harumarket_product_originPrice_min"];
    $harumarket_product_originPrice_max = $_POST["harumarket_product_originPrice_max"];
    $harumarket_product_salePrice_min = $_POST["harumarket_product_salePrice_min"];
    $harumarket_product_salePrice_max = $_POST["harumarket_product_salePrice_max"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select
            t1.harumarket_product_index
		,	t2.haruMarket_productCategory_name
		,	t1.harumarket_product_name
		,	FORMAT(t1.harumarket_product_originPrice,0) harumarket_product_originPrice
		,	FORMAT(t1.harumarket_product_salePrice,0) harumarket_product_salePrice
		,	if(t1.harumarket_product_view=1,'노출','비노출') harumarket_product_view
		,	if(t1.harumarket_product_colorView=1,'노출','비노출') harumarket_product_colorView
		,	if(t1.harumarket_product_sizeView=1,'노출','비노출') harumarket_product_sizeView
		,	t1.harumarket_product_colorIndexs
		,	t1.harumarket_product_sizeIndexs
		,	DATE_FORMAT(t1.harumarket_product_insertTime, '%Y년 %m월 %d일 %H시 %i분') harumarket_product_insertTime
		,	(select haruMarket_user_id from harumarket_user where haruMarket_user_index=t1.harumarket_product_insertUserIndex) harumarket_product_insertUserIndex
		,	DATE_FORMAT(t1.harumarket_product_updateTime, '%Y년 %m월 %d일 %H시 %i분') harumarket_product_updateTime
		,	(select haruMarket_user_id from harumarket_user where haruMarket_user_index=t1.harumarket_product_updateUserIndex) harumarket_product_updateUserIndex
        from	harumarket_product t1
        inner join	harumarket_productcategory t2 on t1.haruMarket_productCategory_index=t2.haruMarket_productCategory_index
        where 
        ('$harumarket_product_view'='' or t1.harumarket_product_view = '$harumarket_product_view') and
        ('$haruMarket_productCategory_index'='' or t1.haruMarket_productCategory_index = '$haruMarket_productCategory_index') and
        ('$harumarket_product_name'='' or t1.harumarket_product_name like '%$harumarket_product_name%') and
        ('$harumarket_product_colorView'='' or t1.harumarket_product_colorView = '$harumarket_product_colorView') and
        ('$harumarket_product_sizeView'='' or t1.harumarket_product_sizeView = '$harumarket_product_sizeView') and
        ('$harumarket_product_colorIndexs'='' or t1.harumarket_product_colorIndexs like '%$harumarket_product_colorIndexs%') and
        ('$harumarket_product_sizeIndexs'='' or t1.harumarket_product_sizeIndexs like '%$harumarket_product_sizeIndexs%') and
        (('$harumarket_product_originPrice_min'='' or '$harumarket_product_originPrice_max'='') or t1.harumarket_product_originPrice between '$harumarket_product_originPrice_min' and '$harumarket_product_originPrice_max') and
        (('$harumarket_product_salePrice_min'='' or '$harumarket_product_salePrice_max'='') or t1.harumarket_product_salePrice between '$harumarket_product_salePrice_min' and '$harumarket_product_salePrice_max');
    ";

    $result = mysqli_query($con, $sql);
    $sql2="";

    $data = array();
    while($row = $result->fetch_assoc()) {
        $harumarket_product_colorIndexs = "";
        if($row["harumarket_product_colorIndexs"] != ""){
            
            $array = textToArray($row["harumarket_product_colorIndexs"]);
            
            foreach ($array as $harumarket_productColor_index){
                $sql2 = "select harumarket_productColor_name from harumarket_productcolor where harumarket_productColor_index=$harumarket_productColor_index";
                $result2 = mysqli_query($con, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $harumarket_product_colorIndexs .= $row2["harumarket_productColor_name"]." ";
            }

            $row["harumarket_product_colorIndexs"] = $harumarket_product_colorIndexs;
        }

        $harumarket_product_sizeIndexs = "";
        if($row["harumarket_product_sizeIndexs"] != ""){
            $array = textToArray($row["harumarket_product_sizeIndexs"]);
            foreach ($array as $harumarket_productSize_index){
                $sql2 = "select harumarket_productSize_name from harumarket_productsize where harumarket_productSize_index=$harumarket_productSize_index";
                $result2 = mysqli_query($con, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $harumarket_product_sizeIndexs .= $row2["harumarket_productSize_name"]." ";
            }

            $row["harumarket_product_sizeIndexs"] = $harumarket_product_sizeIndexs;
        }
        

        $data[] = $row;
    }

    message($data,200);
    return;
}
if($type == "view"){
    $harumarket_product_index = $_POST["harumarket_product_index"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select
			t2.haruMarket_productCategory_name
        ,   t1.haruMarket_productCategory_index
		,	t1.harumarket_product_name
		,	t1.harumarket_product_originPrice
		,	t1.harumarket_product_salePrice
		,	if(t1.harumarket_product_view=1,'노출','비노출') harumarket_product_view
		,	if(t1.harumarket_product_colorView=1,'노출','비노출') harumarket_product_colorView
		,	if(t1.harumarket_product_sizeView=1,'노출','비노출') harumarket_product_sizeView
		,	t1.harumarket_product_colorIndexs
		,	t1.harumarket_product_sizeIndexs
		,	DATE_FORMAT(t1.harumarket_product_insertTime, '%Y년 %m월 %d일 %H시 %i분') harumarket_product_insertTime
		,	(select haruMarket_user_id from harumarket_user where haruMarket_user_index=t1.harumarket_product_insertUserIndex) harumarket_product_insertUserIndex
		,	DATE_FORMAT(t1.harumarket_product_updateTime, '%Y년 %m월 %d일 %H시 %i분') harumarket_product_updateTime
		,	(select haruMarket_user_id from harumarket_user where haruMarket_user_index=t1.harumarket_product_updateUserIndex) harumarket_product_updateUserIndex
        ,   t1.harumarket_product_picture
        ,   t1.harumarket_product_content
        from	harumarket_product t1
        inner join	harumarket_productcategory t2 on t1.haruMarket_productCategory_index=t2.haruMarket_productCategory_index
        where t1.harumarket_product_index = $harumarket_product_index;
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
    $harumarket_product_index = $_POST["harumarket_product_index"];
    $haruMarket_productCategory_index = $_POST["haruMarket_productCategory_index"];
    $harumarket_product_name = $_POST["harumarket_product_name"];
    $harumarket_product_colorView = $_POST["harumarket_product_colorView"];
    $harumarket_product_sizeView = $_POST["harumarket_product_sizeView"];
    $harumarket_product_colorIndexs = $_POST["harumarket_product_colorIndexs"];
    $harumarket_product_sizeIndexs = $_POST["harumarket_product_sizeIndexs"];
    $harumarket_product_picture = $_POST["harumarket_product_picture"];
    $harumarket_product_content = $_POST["harumarket_product_content"];
    $harumarket_product_view = $_POST["harumarket_product_view"];
    $harumarket_product_originPrice = $_POST["harumarket_product_originPrice"];
    $harumarket_product_salePrice = $_POST["harumarket_product_salePrice"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
    $pdo->beginTransaction();

    try{
        session_start();
        $harumarket_product_updateUserIndex = $_SESSION['haruMarket_user_index'];

        $sql = "update harumarket_product set ";
        $sql .= "haruMarket_productCategory_index=?,";
        $sql .= "harumarket_product_name=?,";
        $sql .= "harumarket_product_colorView=?,";
        $sql .= "harumarket_product_sizeView=?,";
        $sql .= "harumarket_product_colorIndexs=?,";
        $sql .= "harumarket_product_sizeIndexs=?,";
        $sql .= "harumarket_product_picture=?,";
        $sql .= "harumarket_product_content=?,";
        $sql .= "harumarket_product_view=?,";
        $sql .= "harumarket_product_originPrice=?,";
        $sql .= "harumarket_product_salePrice=?,";

        $sql .= "harumarket_product_updateTime=now(),";
        $sql .= "harumarket_product_updateUserIndex=? ";
        $sql .= "where harumarket_product_index=?";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(1, $haruMarket_productCategory_index);
        $stmt->bindParam(2, $harumarket_product_name);
        $stmt->bindParam(3, $harumarket_product_colorView);
        $stmt->bindParam(4, $harumarket_product_sizeView);
        $stmt->bindParam(5, $harumarket_product_colorIndexs);
        $stmt->bindParam(6, $harumarket_product_sizeIndexs);
        $stmt->bindParam(7, $harumarket_product_picture);
        $stmt->bindParam(8, $harumarket_product_content);
        $stmt->bindParam(9, $harumarket_product_view);
        $stmt->bindParam(10, $harumarket_product_originPrice);
        $stmt->bindParam(11, $harumarket_product_salePrice);
        
        $stmt->bindParam(12, $harumarket_product_updateUserIndex);
        $stmt->bindParam(13, $harumarket_product_index);

        $stmt->execute();
    }
    catch(Exception $e){
        $pdo->rollBack();
        //message($e->getMessage() ,"500");
        message("상품이 수정을 실패하였습니다.","500");
        return;
    }

    $pdo->commit();
    message("상품이 수정되었습니다.","200");
}
if($type == "insert_mecro"){
    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "select * from harumarket_product;";

    $result = mysqli_query($con, $sql);

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
    $pdo->beginTransaction();

    while($row = $result->fetch_assoc()) {
        //$data[] = $row;
        $haruMarket_productCategory_index = $row["haruMarket_productCategory_index"];
        $harumarket_product_name = $row["harumarket_product_name"];
        $harumarket_product_colorView = $row["harumarket_product_colorView"];
        $harumarket_product_sizeView = $row["harumarket_product_sizeView"];
        $harumarket_product_colorIndexs = $row["harumarket_product_colorIndexs"];
        $harumarket_product_sizeIndexs = $row["harumarket_product_sizeIndexs"];
        $harumarket_product_picture = $row["harumarket_product_picture"];
        $harumarket_product_content = $row["harumarket_product_content"];
        $harumarket_product_view = $row["harumarket_product_view"];
        $harumarket_product_originPrice = $row["harumarket_product_originPrice"];
        $harumarket_product_salePrice = $row["harumarket_product_salePrice"];

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
    }

    $pdo->commit();
    message("상품을 등록하였습니다.","200");
}
?>