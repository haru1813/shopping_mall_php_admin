let user_manager = {
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
        document.getElementById('user_manager').classList.add('active');

        _this.grid_init();

        document.addEventListener('click', (event) => {
            if (event.target.id === 'search') {
                _this.search();
            }
            if (event.target.id === 'update') {
                _this.update();
            }
            //address_search
            if (event.target.id === 'address_search') {
                _this.addressSearch();
            }
            //update_process
            if (event.target.id === 'update_process') {
                _this.updateProcess();
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

        var selectedRows = this.firstGrid.getList('selected');
        let haruMarket_user_index = selectedRows[0].haruMarket_user_index;
        var formData = new FormData();
        formData.append("type", "view");
        formData.append("haruMarket_user_index", haruMarket_user_index);
        data = ajax_send(formData,"./user_manager_api.php");

        let updateForm = document.updateForm;
        updateForm.haruMarket_user_id.value = data.msg[0].haruMarket_user_id;
        updateForm.haruMarket_user_name.value = data.msg[0].haruMarket_user_name;
        updateForm.haruMarket_user_gender.value = data.msg[0].haruMarket_user_gender;
        updateForm.haruMarket_user_birthday.value = data.msg[0].haruMarket_user_birthday;
        updateForm.haruMarket_user_phone.value = data.msg[0].haruMarket_user_phone;
        updateForm.haruMarket_user_postCode.value = data.msg[0].haruMarket_user_postCode;
        updateForm.haruMarket_user_basicAddress.value = data.msg[0].haruMarket_user_basicAddress;
        updateForm.haruMarket_user_detailAddress.value = data.msg[0].haruMarket_user_detailAddress;
        updateForm.haruMarket_user_role.value = data.msg[0].haruMarket_user_role;

        var myModal = new bootstrap.Modal(document.getElementById("user_manager_updateModal"), {});
        myModal.show();
    },
    addressSearch: function(){
        new daum.Postcode({
            oncomplete: function(data) {
                var roadAddr = data.roadAddress; // 도로명 주소 변수
                var jibunAddress = data.jibunAddress; // 지번 주소 변수
                var extraRoadAddr = ''; // 참고 항목 변수

                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }

                let updateForm = document.updateForm;
                updateForm.haruMarket_user_postCode.value = data.zonecode;
                if(roadAddr == ""){
                    updateForm.haruMarket_user_basicAddress.value = roadAddr;
                }
                else{
                    updateForm.haruMarket_user_basicAddress.value = jibunAddress;
                }
            }
        }).open();
    },
    updateProcess: function(){
        let updateForm = document.updateForm;

        let haruMarket_user_id = updateForm.haruMarket_user_id.value;
        let haruMarket_user_name = updateForm.haruMarket_user_name.value;
        let haruMarket_user_gender = updateForm.haruMarket_user_gender.value;
        let haruMarket_user_birthday = updateForm.haruMarket_user_birthday.value;
        let haruMarket_user_phone = updateForm.haruMarket_user_phone.value;
        let haruMarket_user_postCode = updateForm.haruMarket_user_postCode.value;
        let haruMarket_user_basicAddress = updateForm.haruMarket_user_basicAddress.value;
        let haruMarket_user_detailAddress = updateForm.haruMarket_user_detailAddress.value;
        let haruMarket_user_role = updateForm.haruMarket_user_role.value;

        if(haruMarket_user_id == ""){
            toastr.error('아이디를 입력하여 주십시오.');
            updateForm.haruMarket_user_id.focus();
            return;
        }
        if(!this.validataTest(haruMarket_user_id)){
            toastr.error('아이디는 영소문자 또는 숫자만 포함하여 4~20자(20자) 입력하여주십시오.');
            updateForm.haruMarket_user_id.focus();
            return;
        }
        if(haruMarket_user_name == ""){
            toastr.error('이름을 입력하여 주십시오.');
            updateForm.haruMarket_user_name.focus();
            return;
        }
        if(haruMarket_user_gender == ""){
            toastr.error('성별을 입력하여 주십시오.');
            updateForm.haruMarket_user_gender.focus();
            return;
        }
        if(haruMarket_user_birthday == ""){
            toastr.error('생일을 입력하여 주십시오.');
            updateForm.haruMarket_user_birthday.focus();
            return;
        }
        if(haruMarket_user_phone == ""){
            toastr.error('핸드폰번호를 입력하여 주십시오.');
            updateForm.haruMarket_user_phone.focus();
            return;
        }
        if(!this.isNumber(haruMarket_user_phone)){
            toastr.error('핸드폰번호는 숫자만 입력하여 주십시오.');
            updateForm.haruMarket_user_phone.focus();
            return;
        }
        if(haruMarket_user_role == ""){
            toastr.error('권한을 입력하여 주십시오.');
            updateForm.haruMarket_user_role.focus();
            return;
        }

        if(haruMarket_user_postCode == "" || haruMarket_user_basicAddress == ""){
            toastr.error('우편번호 버튼을 클릭하여 주소를 검색하여 주십시오.');
            return;
        }
        if(haruMarket_user_detailAddress == ""){
            toastr.error('상세 주소가 입력되지 않았습니다.');
            updateForm.haruMarket_user_detailAddress.focus();
            return;
        }
        if(haruMarket_user_detailAddress.length > 30){
            toastr.error('상세 주소는 30자를 넘지 않도록 입력하여 주십시오.');
            updateForm.haruMarket_user_detailAddress.focus();
            return;
        }

        var selectedRows = this.firstGrid.getList('selected');
        let haruMarket_user_index = selectedRows[0].haruMarket_user_index;

        var formData = new FormData();
        formData.append("type", "update");
        formData.append("haruMarket_user_index", haruMarket_user_index);
        formData.append("haruMarket_user_id", haruMarket_user_id);
        formData.append("haruMarket_user_name", haruMarket_user_name);
        formData.append("haruMarket_user_gender", haruMarket_user_gender);
        formData.append("haruMarket_user_birthday", haruMarket_user_birthday);
        formData.append("haruMarket_user_phone", haruMarket_user_phone);
        formData.append("haruMarket_user_postCode", haruMarket_user_postCode);
        formData.append("haruMarket_user_basicAddress", haruMarket_user_basicAddress);
        formData.append("haruMarket_user_detailAddress", haruMarket_user_detailAddress);
        formData.append("haruMarket_user_role", haruMarket_user_role);

        data = ajax_send(formData,"./user_manager_api.php");

        if(data.code == "200"){
            document.getElementById('user_manager_updateModal').classList.remove('show');
            document.getElementById('user_manager_updateModal').style.display = 'none';
            const modalBackdrop = document.getElementsByClassName('modal-backdrop');
            modalBackdrop[0].parentNode.removeChild(modalBackdrop[0]);

            toastr.success(data.msg);
            this.search();
        }
        else{
            toastr.error(data.msg);
        }
    },
    validataTest: function(text){
        const regex = /^[a-z0-9]{1,20}$/;
        return regex.test(text);
    },
    isNumber:function(text){
        return !isNaN(text);
    },
}

user_manager.init();