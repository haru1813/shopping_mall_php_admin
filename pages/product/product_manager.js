let user_manager = {
    firstGrid : new ax5.ui.grid(),
    init: function(){
        let _this = this;

        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        dropdownToggles.forEach(link => {
            dropdownToggles.forEach(link => link.classList.remove('show'));
        });

        document.getElementById('product').classList.add('show');

        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            navLinks.forEach(link => link.classList.remove('active'));
        });
        document.getElementById('product_manager').classList.add('active');

        _this.grid_init();

        document.addEventListener('click', (event) => {
            if (event.target.id === 'search') {
                _this.search();
            }
            if (event.target.id === 'update') {
                _this.update();
            }
        });

        _this.search();
    },
    grid_init:function(){
        this.firstGrid.setConfig({
            target: $('[data-ax5grid="first-grid"]'),
            columns: [
                { key: "haruMarket_user_id", label: "아이디" },
                { key: "haruMarket_user_postCode", label: "우편 번호" },
                { key: "haruMarket_user_basicAddress", label: "기본 주소" ,width:200},
                { key: "haruMarket_user_detailAddress", label: "상세 주소" },
                { key: "haruMarket_user_birthday", label: "생일" },
                { key: "haruMarket_user_gender", label: "성별" },
                { key: "haruMarket_user_name", label: "이름" },
                { key: "haruMarket_user_phone", label: "전화번호" },
                { key: "haruMarket_user_insertTime", label: "가입 시간" ,width:170},
                { key: "haruMarket_user_updateTime", label: "수정 시간" ,width:170},
                { key: "haruMarket_user_updateUserIndex", label: "수정 시도 계정" },
                { key: "haruMarket_user_role", label: "계정 권한" },
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
        let haruMarket_user_name = document.getElementById('haruMarket_user_name').value;
        let haruMarket_user_basicAddress = document.getElementById('haruMarket_user_basicAddress').value;
        let haruMarket_user_gender = document.getElementById('haruMarket_user_gender').value;

        var formData = new FormData();
        formData.append("type", "search");
        formData.append("haruMarket_user_id", haruMarket_user_id);
        formData.append("haruMarket_user_name", haruMarket_user_name);
        formData.append("haruMarket_user_basicAddress", haruMarket_user_basicAddress);
        formData.append("haruMarket_user_gender", haruMarket_user_gender);

        data = ajax_send(formData,"./user_manager_api.php");
        this.firstGrid.setData(data.msg);
    },
    update: function(){
        var checkedList = this.firstGrid.getList("selected");
        if (checkedList.length == 0 || checkedList.length > 1){
            toastr.error('수정할 유저는 한명만 선택하여 주십시오.');
            return;
        }

        var myModal = new bootstrap.Modal(document.getElementById("user_manager_updateModal"), {});
        myModal.show();
    },
}

user_manager.init();