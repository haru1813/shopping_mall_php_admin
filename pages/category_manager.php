<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/nav.php";?>
<div class="row">
    <div class="col-12 pb-0" id="search">
        <div class="card h-100">
                <div class="card-header">
                    카테고리 관리
                </div>
                <div class="card-body p-0">
                    <div class="card-title h-100">
                        <div class="container-fluid pt-1">
                            <div class="row">
                                <div class="col-3">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text" id="basic-addon1">아이디</span>
                                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text" id="basic-addon1">이름</span>
                                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text" id="basic-addon1">주소</span>
                                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group input-group-sm">
                                    <label class="input-group-text" for="inputGroupSelect01">성별</label>
                                        <select class="form-select" id="inputGroupSelect01" style="height:31px;">
                                            <option selected>선택</option>
                                            <option value="1">남자</option>
                                            <option value="2">여자</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="position-absolute bottom-0 w-100 p-1">
                            <button class="btn btn-primary btn-sm" type="button">조회</button>
                            <button class="btn btn-primary btn-sm" type="button">수정</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="col-12" id="result">
        <div class="container-fluid">
            <div class="col-12">

            </div>
        </div>
    </div>
</div>
<script src="./category_manager.js?v=<?php echo rand(); ?>"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/footer.php";?>