<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/nav.php";?>
<div class="row">
    <div class="col-12 pb-0" id="search">
        <div class="card h-100">
            <div class="card-header">
                상품 색상 관리
            </div>
            <div class="card-body p-0">
                <div class="card-title h-100">
                    <div class="container-fluid pt-1">
                        <div class="row">
                            <div class="col-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">색상 이름</span>
                                    <input id="harumarket_productColor_name" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="position-absolute bottom-0 w-100 p-1">
                        <button class="btn btn-primary btn-sm" type="button" id="search">조회</button>
                        <button class="btn btn-success btn-sm" type="button" id="insert">등록</button>
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
<!-- 등록 모달창 -->
<form name="insertForm">
    <div class="modal" tabindex="-1" id="productColor_manager_insertModal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">상품 색상 등록</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid pt-1">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">상품 색상 이름</span>
                                    <input name="harumarket_productColor_name" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                    <button type="button" class="btn btn-success" id="insert_process">등록</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- 수정 모달창 -->
<form name="updateForm">
<div class="modal" tabindex="-1" id="productColor_manager_updateModal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">상품 색상 수정</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid pt-1">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">상품 색상 이름</span>
                                    <input name="harumarket_productColor_name" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
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

<script src="./productColor_manager.js?v=<?php echo rand(); ?>"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/footer.php";?>