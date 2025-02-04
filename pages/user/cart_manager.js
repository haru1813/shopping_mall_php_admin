let cart_manager = {
    firstGrid : new ax5.ui.grid(),
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
        document.getElementById('cart_manager').classList.add('active');

        _this.grid_init();

        document.addEventListener('click', (event) => {
            if (event.target.id === 'search') {
                _this.search();
            }
            if (event.target.id === 'delete') {
                _this.delete();
            }
        });

        _this.search();
    },
    grid_init:function(){
        this.firstGrid.setConfig({
            target: $('[data-ax5grid="first-grid"]'),
            columns: [
                { key: "haruMarket_user_id", label: "아이디" },
                { key: "harumarket_product_name", label: "상품 이름", width:250 },
                { key: "harumarket_productColor_name", label: "상품 색상" },
                { key: "harumarket_productSize_name", label: "상품 크기" },
                { key: "harumarket_userBasket_account", label: "상품 개수" },
                { key: "harumarket_product_salePrice", label: "상품 가격" },
                { key: "harumarket_userBasket_insertTime", label: "등록 시간" ,width:170},
            ],
            header: {
                align: "center",
                selector: false,
            },
            showLineNumber: true,
            showRowSelector: true,
            multipleSelect: false
        });
    },
    search: function(){
        let haruMarket_user_id = document.getElementById('haruMarket_user_id').value;
        let harumarket_product_name = document.getElementById('harumarket_product_name').value;

        var formData = new FormData();
        formData.append("type", "search");
        formData.append("haruMarket_user_id", haruMarket_user_id);
        formData.append("harumarket_product_name", harumarket_product_name);

        data = ajax_send(formData,"./cart_manager_api.php");
        this.firstGrid.setData(data.msg);
    },
    delete: function(){
        var checkedList = this.firstGrid.getList("selected");
        if (checkedList.length == 0){
            toastr.error('삭제할 장바구니를 한개 이상 선택하여 주십시오.');
            return;
        }

        checkedList.forEach(data => {
            formData = new FormData();
            formData.append("type", "delete");
            formData.append("harumarket_userBasket_index", data.harumarket_userBasket_index);
            data = ajax_send(formData,"./cart_manager_api.php");

            if(data.code=="200"){
                toastr.success(data.msg);
            }
            else{
                toastr.error(data.msg);
            }
        });

        cart_manager.search();
    },
}

cart_manager.init();