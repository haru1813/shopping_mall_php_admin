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
        document.getElementById('category_manager').classList.add('active');

        _this.grid_init();

        document.addEventListener('click', (event) => {
            if (event.target.id === 'insert') {
                _this.insert();
            }
            if (event.target.id === 'insert_process') {
                _this.insertProcess();
            }
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
                { key: "haruMarket_productCategory_name", label: "카테고리 이름", width:100 },
                { key: "haruMarket_productCategory_view", label: "노출 여부" },
                { key: "haruMarket_productCategory_insertTime", label: "등록 시간" ,width:170},
                { key: "haruMarket_productCategory_insertUserIndex", label: "등록 시도 계정" },
                { key: "haruMarket_productCategory_updateTime", label: "수정 시간" ,width:170},
                { key: "haruMarket_productCategory_updateUserIndex", label: "수정 시도 계정" },
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
        let haruMarket_productCategory_name = document.getElementById('haruMarket_productCategory_name').value;
        let haruMarket_productCategory_view = document.getElementById('haruMarket_productCategory_view').value;

        var formData = new FormData();
        formData.append("type", "search");
        formData.append("haruMarket_productCategory_name", haruMarket_productCategory_name);
        formData.append("haruMarket_productCategory_view", haruMarket_productCategory_view);

        data = ajax_send(formData,"./category_manager_api.php");
        this.firstGrid.setData(data.msg);
    },
    insert: function(){
        var myModal = new bootstrap.Modal(document.getElementById("category_manager_insertModal"), {});
        myModal.show();
    },
    insertProcess: function(){
        let insertForm = document.insertForm;

        let haruMarket_productCategory_name = insertForm.haruMarket_productCategory_name.value;
        let haruMarket_productCategory_view = insertForm.haruMarket_productCategory_view.value;

        if(haruMarket_productCategory_name == ""){
            toastr.error('카테고리 이름을 입력하여 주십시오.');
            insertForm.haruMarket_productCategory_name.focus();
            return;
        }
        if(haruMarket_productCategory_name.length >= 10){
            toastr.error('카테고리 이름은 10자 이내로 입력하여 주십시오.');
            insertForm.haruMarket_productCategory_name.focus();
            return;
        }
        if(haruMarket_productCategory_view == ""){
            toastr.error('홈페이지 노출 여부를 입력하여 주십시오.');
            insertForm.haruMarket_productCategory_view.focus();
            return;
        }
        
        var formData = new FormData();
        formData.append("type", "insert");
        formData.append("haruMarket_productCategory_name", haruMarket_productCategory_name);
        formData.append("haruMarket_productCategory_view", haruMarket_productCategory_view);

        data = ajax_send(formData,"./category_manager_api.php");

        if(data.code == "200"){
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
    update: function(){
        var checkedList = this.firstGrid.getList("selected");
        if (checkedList.length == 0 || checkedList.length > 1){
            toastr.error('수정할 카테고리를 한개 선택하여 주십시오.');
            return;
        }

        var selectedRows = this.firstGrid.getList('selected');
        let haruMarket_productCategory_index = selectedRows[0].haruMarket_productCategory_index;
        var formData = new FormData();
        formData.append("type", "view");
        formData.append("haruMarket_productCategory_index", haruMarket_productCategory_index);
        data = ajax_send(formData,"./category_manager_api.php");

        let updateForm = document.updateForm;
        updateForm.haruMarket_productCategory_name.value = data.msg[0].haruMarket_productCategory_name;
        updateForm.haruMarket_productCategory_view.value = data.msg[0].haruMarket_productCategory_view;

        var myModal = new bootstrap.Modal(document.getElementById("category_manager_updateModal"), {});
        myModal.show();
    },
    update_process: function(){
        var selectedRows = this.firstGrid.getList('selected');
        let haruMarket_productCategory_index = selectedRows[0].haruMarket_productCategory_index;

        let updateForm = document.updateForm;
        let haruMarket_productCategory_name = updateForm.haruMarket_productCategory_name.value;
        let haruMarket_productCategory_view = updateForm.haruMarket_productCategory_view.value;

        if(haruMarket_productCategory_name == ""){
            toastr.error('카테고리 이름을 입력하여 주십시오.');
            insertForm.haruMarket_productCategory_name.focus();
            return;
        }
        if(haruMarket_productCategory_name.length >= 10){
            toastr.error('카테고리 이름은 10자 이내로 입력하여 주십시오.');
            insertForm.haruMarket_productCategory_name.focus();
            return;
        }
        if(haruMarket_productCategory_view == ""){
            toastr.error('홈페이지 노출 여부를 입력하여 주십시오.');
            insertForm.haruMarket_productCategory_view.focus();
            return;
        }

        var formData = new FormData();
        formData.append("type", "update");
        formData.append("haruMarket_productCategory_index", haruMarket_productCategory_index);
        formData.append("haruMarket_productCategory_name", haruMarket_productCategory_name);
        formData.append("haruMarket_productCategory_view", haruMarket_productCategory_view);

        data = ajax_send(formData,"./category_manager_api.php");

        if(data.code == "200"){
            // var myModal = new bootstrap.Modal(document.getElementById("category_manager_updateModal"), {});
            // myModal.hide();
            document.getElementById('category_manager_updateModal').classList.remove('show');
            document.getElementById('category_manager_updateModal').style.display = 'none';
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

user_manager.init();