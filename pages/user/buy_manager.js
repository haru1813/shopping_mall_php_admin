let buy_manager = {
    firstGrid : new ax5.ui.grid(),
    secondGrid : new ax5.ui.grid(),
    init: function(){
        let _this = this;

        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        dropdownToggles.forEach(link => {
            dropdownToggles.forEach(link => link.classList.remove('show'));
        });

        document.getElementById('user').classList.add('show');

        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            navLinks.forEach(link => link.classList.remove('active'));
        });
        document.getElementById('buy_manager').classList.add('active');

        _this.grid_init();

        document.addEventListener('click', (event) => {
            if (event.target.id === 'search') {
                _this.search();
            }
            if (event.target.id === 'update') {
                _this.update();
            }
            if (event.target.id === 'update_process') {
                _this.update_process();
            }
        });

        _this.search();
    },
    grid_init:function(){
        this.firstGrid.setConfig({
            target: $('[data-ax5grid="first-grid"]'),
            columns: [
                { key: "haruMarket_user_id", label: "아이디" },
                { key: "haruMarket_BuyMaster_order", label: "주문 번호", width:250 },
                { key: "haruMarket_BuyMaster_buyerName", label: "이름" },
                { key: "haruMarket_BuyMaster_buyerPostcode", label: "우편 번호" },
                { key: "haruMarket_BuyMaster_buyerAddr", label: "주소" },
                { key: "haruMarket_BuyMaster_buyerMethod", label: "결제 방법" },
                { key: "haruMarket_BuyMaster_status", label: "주문 상태" },
                { key: "haruMarket_BuyMaster_amount", label: "결제 금액" },
                { key: "haruMarket_BuyMaster_insertTime", label: "결제 시간" ,width:170},
            ],
            header: {
                align: "center",
                selector: false,
            },
            showLineNumber: true,
            showRowSelector: true,
            multipleSelect: false,
            body: {
                onClick: function (e) {
                    // 클릭된 row의 데이터
                    const rowData = this.list[this.dindex];
                
                    // 원하는 동작 수행
                    //console.log(rowData); // 콘솔에 row 데이터 출력

                    let haruMarket_BuyMaster_order = rowData.haruMarket_BuyMaster_order;

                    var formData = new FormData();
                    formData.append("type", "search2");
                    formData.append("haruMarket_BuyMaster_order", haruMarket_BuyMaster_order);

                    data = ajax_send(formData,"./buy_manager_api.php");
                    buy_manager.secondGrid.setData(data.msg);
                }
            }
        });
        this.secondGrid.setConfig({
            target: $('[data-ax5grid="second-grid"]'),
            columns: [
                { key: "harumarket_product_name", label: "상품 이름", width:250 },
                { key: "harumarket_productColor_name", label: "상품 색상" },
                { key: "harumarket_productSize_name", label: "상품 크기" },
                { key: "harumarket_buyDetail_account", label: "상품 개수" },
                { key: "harumarket_buyDetail_amount", label: "결제 금액" },
            ],
            header: {
                align: "center",
                selector: false,
            },
            showLineNumber: true,
            showRowSelector: false,
            multipleSelect: false
        });
    },
    search: function(){
        let haruMarket_user_id = document.getElementById('haruMarket_user_id').value;
        let haruMarket_BuyMaster_order = document.getElementById('haruMarket_BuyMaster_order').value;
        let haruMarket_BuyMaster_buyerName = document.getElementById('haruMarket_BuyMaster_buyerName').value;
        let haruMarket_BuyMaster_buyerAddr = document.getElementById('haruMarket_BuyMaster_buyerAddr').value;
        let haruMarket_BuyMaster_status = document.getElementById('haruMarket_BuyMaster_status').value;

        var formData = new FormData();
        formData.append("type", "search");
        formData.append("haruMarket_user_id", haruMarket_user_id);
        formData.append("haruMarket_BuyMaster_order", haruMarket_BuyMaster_order);
        formData.append("haruMarket_BuyMaster_buyerName", haruMarket_BuyMaster_buyerName);
        formData.append("haruMarket_BuyMaster_buyerAddr", haruMarket_BuyMaster_buyerAddr);
        formData.append("haruMarket_BuyMaster_status", haruMarket_BuyMaster_status);

        data = ajax_send(formData,"./buy_manager_api.php");
        this.firstGrid.setData(data.msg);
        this.secondGrid.setData([]);
    },
    update:function(){
        var checkedList = this.firstGrid.getList("selected");
        if (checkedList.length == 0 || checkedList.length > 1){
            toastr.error('수정할 주문 번호를 한개 선택하여 주십시오.');
            return;
        }

        let updateForm = document.updateForm;
        updateForm.haruMarket_BuyMaster_status.value = checkedList[0].haruMarket_BuyMaster_status;

        var myModal = new bootstrap.Modal(document.getElementById("buy_manager_updateModal"), {});
        myModal.show();
    },
    update_process:function(){
        var selectedRows = this.firstGrid.getList('selected');
        let haruMarket_BuyMaster_index = selectedRows[0].haruMarket_BuyMaster_index;
        let updateForm = document.updateForm;
        let haruMarket_BuyMaster_status = updateForm.haruMarket_BuyMaster_status.value;

        var formData = new FormData();
        formData.append("type", "update");
        formData.append("haruMarket_BuyMaster_index", haruMarket_BuyMaster_index);
        formData.append("haruMarket_BuyMaster_status", haruMarket_BuyMaster_status);

        data = ajax_send(formData,"./buy_manager_api.php");

        if(data.code == "200"){
            document.getElementById('buy_manager_updateModal').classList.remove('show');
            document.getElementById('buy_manager_updateModal').style.display = 'none';
            const modalBackdrop = document.getElementsByClassName('modal-backdrop');
            modalBackdrop[0].parentNode.removeChild(modalBackdrop[0]);

            toastr.success(data.msg);
            this.search();
        }
        else{
            toastr.error(data.msg);
        }
    },
}

buy_manager.init();