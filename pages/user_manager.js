let user_manager = {
    firstGrid : new ax5.ui.grid(),
    init: function(){
        let _this = this;

        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            navLinks.forEach(link => link.classList.remove('active'));
        });

        document.getElementById('user_manager').classList.add('active');

        _this.grid_init();

        document.addEventListener('click', (event) => {
            if (event.target.id === 'search') {
                _this.search();
            }
        });
    },
    grid_init:function(){
        this.firstGrid.setConfig({
            target: $('[data-ax5grid="first-grid"]'),
            columns: [
                { key: "haruMarket_user_id", label: "아이디" },
                { key: "haruMarket_user_postCode", label: "우편 번호" },
                { key: "haruMarket_user_basicAddress", label: "기본 주소" },
                { key: "haruMarket_user_detailAddress", label: "상세 주소" },
                { key: "haruMarket_user_birthday", label: "생일" },
                { key: "haruMarket_user_gender", label: "성별" },
                { key: "haruMarket_user_name", label: "이름" },
                { key: "haruMarket_user_phone", label: "전화번호" },
                { key: "haruMarket_user_insertTime", label: "가입 시간" },
                { key: "haruMarket_user_updateTime", label: "수정 시간" },
                { key: "haruMarket_user_updateUserIndex", label: "수정 시도 계정" },
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

       
    },
}

user_manager.init();