<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/nav.php";?>
<div class="row">
    <div class="col-12 pb-0" id="search">
        <div class="card h-100">
            <div class="card-header">
                장바구니 관리
            </div>
            <div class="card-body p-0">
                <div class="card-title h-100">
                    <div class="container-fluid pt-1">
                        <div class="row">
                            <div class="col-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">아이디</span>
                                    <input id="haruMarket_user_id" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">이름</span>
                                    <input id="haruMarket_user_name" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">주소</span>
                                    <input id="haruMarket_user_basicAddress" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group input-group-sm">
                                <label class="input-group-text" for="inputGroupSelect01">성별</label>
                                    <select id="haruMarket_user_gender" class="form-select" id="inputGroupSelect01" style="height:31px;">
                                        <option value="" selected>선택</option>
                                        <option value="male">남자</option>
                                        <option value="female">여자</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="position-absolute bottom-0 w-100 p-1">
                        <button class="btn btn-primary btn-sm" type="button" id="search">조회</button>
                        <button class="btn btn-warning btn-sm" type="button" id="update">수정</button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="col-12 mt-2" id="result">
        <div class="container-fluid h-100">
            <div class="col-12 w-100 h-100 align-items-center">
                <div data-ax5grid="first-grid"
                    data-ax5grid-config="{
                        showLineNumber: true,
                        showRowSelector: true,
                        multipleSelect: true
                    }"
                    style="height: calc(70vh);"></div>
            </div>
        </div>
    </div>
</div>
<!-- 수정 모달창 -->
<div class="modal" tabindex="-1" id="user_manager_updateModal">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">유저 정보 수정</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid pt-1">
                    <div class="row">
                        <div class="col-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text" id="basic-addon1">아이디</span>
                                <input id="haruMarket_user_id2" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text" id="basic-addon1">이름</span>
                                <input id="haruMarket_user_name2" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group input-group-sm">
                                <label class="input-group-text" for="inputGroupSelect01">성별</label>
                                <select id="haruMarket_user_gender2" class="form-select" id="inputGroupSelect01" style="height:31px;">
                                    <option value="" selected>선택</option>
                                    <option value="male">남자</option>
                                    <option value="female">여자</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text" id="basic-addon1">생일</span>
                                <input id="haruMarket_user_basicAddress2" type="date" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text" id="basic-addon1">핸드폰 번호</span>
                                <input id="haruMarket_user_basicAddress2" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                            </div>
                        </div>
                    </div>

                    <label class="form-label mt-3">주소</label>
                    <div class="row">
                        <div class="col-3">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="우편 번호" style="height:31px;">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon2" style="height:31px;">검색</button>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="기본 주소" style="height:31px;">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="상세 주소" style="height:31px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                <button type="button" class="btn btn-warning">수정</button>
            </div>
        </div>
    </div>
</div>
<script src="./cart_manager.js?v=<?php echo rand(); ?>"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/footer.php";?>