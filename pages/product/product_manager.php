<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/head.php";?>
<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/nav.php";?>
<div class="row">
    <div class="col-12 pb-0" id="search">
        <div class="card h-100">
            <div class="card-header">
                상품 관리
            </div>
            <div class="card-body p-0">
                <div class="card-title h-100">
                    <div class="container-fluid pt-1">
                        <div class="row">
                            <div class="col-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">카테고리 이름</span>
                                    <input id="haruMarket_productCategory_name" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group input-group-sm">
                                <label class="input-group-text" for="inputGroupSelect01">홈페이지 노출 여부</label>
                                    <select id="haruMarket_productCategory_view" class="form-select" style="height:31px;">
                                        <option value="" selected>선택</option>
                                        <option value="1">노출</option>
                                        <option value="0">비노출</option>
                                    </select>
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
    <div class="modal" tabindex="-1" id="product_manager_insertModal">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">상품 등록</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid pt-1">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="" name="harumarket_product_view">
                                    <label class="form-check-label" for="harumarket_product_view">
                                        상품 화면 노출 여부
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text" for="inputGroupSelect01">카테고리</label>
                                    <select name="haruMarket_productCategory_index" class="form-select" style="height:31px;">
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">상품 이름</span>
                                    <input name="harumarket_product_name" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">상품 가격</span>
                                    <input name="harumarket_product_originPrice" type="int" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">상품 할인 가격</span>
                                    <input name="harumarket_product_salePrice" type="int" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label mt-3">상품 사진</label>
                                <div class="mb-3">
                                    <input class="form-control" type="file" name="harumarket_product_picture" id="formFile">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <img src="./basic.png" class="img-thumbnail" width="200" id="previewImage">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="" name="harumarket_product_colorView" id="harumarket_product_colorView_if">
                                    <label class="form-check-label" for="harumarket_product_colorView">
                                        상품 색상
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <ul class="list-group list-group-horizontal" id="harumarket_productColor_if" style="visibility: hidden;">
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="" name="harumarket_product_sizeView" id="harumarket_product_sizeView_if">
                                    <label class="form-check-label" for="harumarket_product_sizeView">
                                        상품 크기
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <ul class="list-group list-group-horizontal" id="harumarket_productSize_if" style="visibility: hidden;">
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label mt-3">상품 상세</label>
                                <div id="harumarket_product_content_if"></div>
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
    <div class="modal" tabindex="-1" id="category_manager_updateModal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">카테고리 수정</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid pt-1">
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="basic-addon1">카테고리 이름</span>
                                    <input name="haruMarket_productCategory_name" type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1" style="height:31px;">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text" for="inputGroupSelect01">홈페이지 노출 여부</label>
                                    <select name="haruMarket_productCategory_view" class="form-select" style="height:31px;">
                                        <option value="" selected>선택</option>
                                        <option value="1">노출</option>
                                        <option value="0">비노출</option>
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

<script src="./product_manager.js?v=<?php echo rand(); ?>"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/pages/layout/footer.php";?>