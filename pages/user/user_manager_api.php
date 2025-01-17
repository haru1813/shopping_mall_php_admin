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

if($type == "search"){
    $haruMarket_user_id = $_POST["haruMarket_user_id"];
    $haruMarket_user_name = $_POST["haruMarket_user_name"];
    $haruMarket_user_basicAddress = $_POST["haruMarket_user_basicAddress"];
    $haruMarket_user_gender = $_POST["haruMarket_user_gender"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
        select
			t1.haruMarket_user_index
		,	t1.haruMarket_user_id
		,	t1.haruMarket_user_postCode
		,	t1.haruMarket_user_basicAddress
		,	t1.haruMarket_user_detailAddress
		,	t1.haruMarket_user_birthday
		,	if(t1.haruMarket_user_gender='male','남자','여자') haruMarket_user_gender
		,	t1.haruMarket_user_name
		,	t1.haruMarket_user_phone
		,	DATE_FORMAT(t1.haruMarket_user_insertTime, '%Y년 %m월 %d일 %H시 %i분') haruMarket_user_insertTime
		,	DATE_FORMAT(t1.haruMarket_user_updateTime, '%Y년 %m월 %d일 %H시 %i분') haruMarket_user_updateTime
		,	(select haruMarket_user_id from harumarket_user where haruMarket_user_index=t1.haruMarket_user_updateUserIndex) haruMarket_user_updateUserIndex
        ,   t1.haruMarket_user_role
        from harumarket_user t1
        where ('$haruMarket_user_id'='' or t1.haruMarket_user_id like '%$haruMarket_user_id%')
        and ('$haruMarket_user_name'='' or t1.haruMarket_user_name like '%$haruMarket_user_name%')
        and ('$haruMarket_user_basicAddress'='' or t1.haruMarket_user_basicAddress like '%$haruMarket_user_basicAddress%')
        and ('$haruMarket_user_gender'='' or t1.haruMarket_user_gender = '$haruMarket_user_gender')
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
    $haruMarket_user_index = $_POST["haruMarket_user_index"];

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');

    $sql = "
    select
			t1.haruMarket_user_index
		,	t1.haruMarket_user_id
		,	t1.haruMarket_user_postCode
		,	t1.haruMarket_user_basicAddress
		,	t1.haruMarket_user_detailAddress
		,	t1.haruMarket_user_birthday
		,	t1.haruMarket_user_gender
		,	t1.haruMarket_user_name
		,	t1.haruMarket_user_phone
		,	DATE_FORMAT(t1.haruMarket_user_insertTime, '%Y년 %m월 %d일 %H시 %i분') haruMarket_user_insertTime
		,	DATE_FORMAT(t1.haruMarket_user_updateTime, '%Y년 %m월 %d일 %H시 %i분') haruMarket_user_updateTime
		,	(select haruMarket_user_id from harumarket_user where haruMarket_user_index=t1.haruMarket_user_updateUserIndex) haruMarket_user_updateUserIndex
        ,   t1.haruMarket_user_role
        from harumarket_user t1
        where t1.haruMarket_user_index = $haruMarket_user_index
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
    $haruMarket_user_index = $_POST["haruMarket_user_index"];
    $haruMarket_user_id = $_POST["haruMarket_user_id"];
    $haruMarket_user_name = $_POST["haruMarket_user_name"];
    $haruMarket_user_gender = $_POST["haruMarket_user_gender"];
    $haruMarket_user_birthday = $_POST["haruMarket_user_birthday"];
    $haruMarket_user_phone = $_POST["haruMarket_user_phone"];
    $haruMarket_user_postCode = $_POST["haruMarket_user_postCode"];
    $haruMarket_user_basicAddress = $_POST["haruMarket_user_basicAddress"];
    $haruMarket_user_detailAddress = $_POST["haruMarket_user_detailAddress"];
    $haruMarket_user_role = $_POST["haruMarket_user_role"];

    if($haruMarket_user_id == ""){
        message("아이디를 입력하여 주십시오.","500");
        return;
    }
    if(!validateText($haruMarket_user_id)){
        message("아이디는 영소문자 또는 숫자만 포함하여 4~20자(20자) 입력하여주십시오.","500");
        return;
    }
    if($haruMarket_user_name == ""){
        message("이름을 입력하여 주십시오.","500");
        return;
    }
    if($haruMarket_user_gender == ""){
        message("성별을 입력하여 주십시오.","500");
        return;
    }
    if($haruMarket_user_birthday == ""){
        message("성일을 입력하여 주십시오.","500");
        return;
    }
    if($haruMarket_user_phone == ""){
        message("핸드폰 번호를 입력하여 주십시오.","500");
        return;
    }
    if($haruMarket_user_role == ""){
        message("권한을 입력하여 주십시오.","500");
        return;
    }
    if($haruMarket_user_postCode == "" || $haruMarket_user_basicAddress == "" || $haruMarket_user_detailAddress == ""){
        message("주소를 입력하여 주십시오.","500");
        return;
    }

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect1.php');
    $sql = "SELECT * FROM harumarket_user where haruMarket_user_index='$haruMarket_user_index';";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    
    $total_rows = mysqli_num_rows($result);
    if($total_rows != 0){
        $haruMarket_user_id_check = $row["haruMarket_user_id"];
        if($haruMarket_user_id != $haruMarket_user_id_check){
            message("이미 존재하는 아이디입니다. 다른 아이디를 입력하여 주십시오.","500");
            return;
        }
    }

    include($_SERVER["DOCUMENT_ROOT"].'/db/db_connect2.php');
    $pdo->beginTransaction();

    try{
        session_start();
        $haruMarket_user_updateUserIndex = $_SESSION['haruMarket_user_index'];

        $sql = "update harumarket_user set ";
        $sql .= "haruMarket_user_id=?,";
        $sql .= "haruMarket_user_name=?,";
        $sql .= "haruMarket_user_gender=?,";
        $sql .= "haruMarket_user_birthday=?,";
        $sql .= "haruMarket_user_phone=?,";
        $sql .= "haruMarket_user_postCode=?,";
        $sql .= "haruMarket_user_basicAddress=?,";
        $sql .= "haruMarket_user_detailAddress=?,";
        $sql .= "haruMarket_user_role=?,";

        $sql .= "haruMarket_user_updateTime=now(),";
        $sql .= "haruMarket_user_updateUserIndex=? ";
        $sql .= "where haruMarket_user_index=?";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(1, $haruMarket_user_id);
        $stmt->bindParam(2, $haruMarket_user_name);
        $stmt->bindParam(3, $haruMarket_user_gender);
        $stmt->bindParam(4, $haruMarket_user_birthday);
        $stmt->bindParam(5, $haruMarket_user_phone);
        $stmt->bindParam(6, $haruMarket_user_postCode);
        $stmt->bindParam(7, $haruMarket_user_basicAddress);
        $stmt->bindParam(8, $haruMarket_user_detailAddress);
        $stmt->bindParam(9, $haruMarket_user_role);
        $stmt->bindParam(10, $haruMarket_user_updateUserIndex);
        $stmt->bindParam(11, $haruMarket_user_index);

        $stmt->execute();
    }
    catch(Exception $e){
        $pdo->rollBack();
        //message($e->getMessage() ,"500");
        message("회원 정보가 수정을 실패하였습니다.","500");
        return;
    }

    $pdo->commit();
    message("회원 정보가 수정되었습니다.","200");
}
?>