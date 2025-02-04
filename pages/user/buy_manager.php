<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/nav.php";?>
<div class="row">
    <div class="col-12 pb-0" id="search">
        <div class="card h-100">
            <div class="card-header">
                결제 관리
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
                                    <span class="input-group-text" id="basic-addon1">주문 번호</span>
                                    <input id="haruMarket_BuyMaster_order" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">이름</span>
                                    <input id="haruMarket_BuyMaster_buyerName" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">주소</span>
                                    <input id="haruMarket_BuyMaster_buyerAddr" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group input-group-sm mt-1">
                                <label class="input-group-text" for="inputGroupSelect01">주문 상태</label>
                                    <select id="haruMarket_BuyMaster_status" class="form-select" style="height:31px;">
                                        <option value="" selected>선택</option>
                                        <option value="결제완료">결제완료</option>
                                        <option value="배송준비중">배송준비중</option>
                                        <option value="배송중">배송중</option>
                                        <option value="배송완료">배송완료</option>
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
            <div class="row">
                <div class="col-6 w-50 h-100 align-items-center">
                    <div data-ax5grid="first-grid"
                        style="height: calc(70vh);"></div>
                </div>
                <div class="col-6 w-50 h-100 align-items-center">
                    <div data-ax5grid="second-grid"
                        style="height: calc(70vh);"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 수정 모달창 -->
<form name="updateForm">
<div class="modal" tabindex="-1" id="buy_manager_updateModal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">주문 상태 수정</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid pt-1">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">주문 상태</span>
                                    <select name="haruMarket_BuyMaster_status" class="form-select" style="height:31px;">
                                        <option value="" selected>선택</option>
                                        <option value="결제완료">결제완료</option>
                                        <option value="배송준비중">배송준비중</option>
                                        <option value="배송중">배송중</option>
                                        <option value="배송완료">배송완료</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                    <button type="button" class="btn btn-warning" id="update_process">수정</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="./buy_manager.js?v=<?php echo rand(); ?>"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/footer.php";?>