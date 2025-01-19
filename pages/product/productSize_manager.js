let productSize_manager = {
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
        document.getElementById('productSize_manager').classList.add('active');

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
                { key: "harumarket_productSize_name", label: "크기 이름", width:150 },
                { key: "harumarket_productSize_insertTime", label: "등록 시간" ,width:170},
                { key: "harumarket_productSize_insertUserIndex", label: "등록 시도 계정" },
                { key: "haruMarket_productSize_updateTime", label: "수정 시간" ,width:170},
                { key: "haruMarket_productSize_updateUserIndex", label: "수정 시도 계정" },
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
        let harumarket_productSize_name = document.getElementById('harumarket_productSize_name').value;

        var formData = new FormData();
        formData.append("type", "search");
        formData.append("harumarket_productSize_name", harumarket_productSize_name);

        data = ajax_send(formData,"./productSize_manager_api.php");
        this.firstGrid.setData(data.msg);
    },
    insert: function(){
        var myModal = new bootstrap.Modal(document.getElementById("productSize_manager_insertModal"), {});
        myModal.show();
    },
    insertProcess: function(){
        let insertForm = document.insertForm;

        let harumarket_productSize_name = insertForm.harumarket_productSize_name.value;

        if(harumarket_productSize_name == ""){
            toastr.error('상품 색상 이름을 입력하여 주십시오.');
            insertForm.harumarket_productSize_name.focus();
            return;
        }

        if(harumarket_productSize_name.length >= 10){
            toastr.error('상품 색상 이름은 10글자 이내로 작성하여 주십시오.');
            insertForm.harumarket_productSize_name.focus();
            return;
        }
        
        var formData = new FormData();
        formData.append("type", "insert");
        formData.append("harumarket_productSize_name", harumarket_productSize_name);

        data = ajax_send(formData,"./productSize_manager_api.php");

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
            toastr.error('수정할 크기를 한개 선택하여 주십시오.');
            return;
        }

        var selectedRows = this.firstGrid.getList('selected');
        let harumarket_productSize_index = selectedRows[0].harumarket_productSize_index;
        var formData = new FormData();
        formData.append("type", "view");
        formData.append("harumarket_productSize_index", harumarket_productSize_index);
        data = ajax_send(formData,"./productSize_manager_api.php");

        let updateForm = document.updateForm;
        updateForm.harumarket_productSize_name.value = data.msg[0].harumarket_productSize_name;

        var myModal = new bootstrap.Modal(document.getElementById("productSize_manager_updateModal"), {});
        myModal.show();
    },
    update_process: function(){
        var selectedRows = this.firstGrid.getList('selected');
        let harumarket_productSize_index = selectedRows[0].harumarket_productSize_index;

        let updateForm = document.updateForm;
        let harumarket_productSize_name = updateForm.harumarket_productSize_name.value;

        if(harumarket_productSize_name == ""){
            toastr.error('상품 크기 이름을 입력하여 주십시오.');
            insertForm.harumarket_productSize_name.focus();
            return;
        }

        if(harumarket_productSize_name.length >= 10){
            toastr.error('상품 크기 이름은 10글자 이내로 작성하여 주십시오.');
            insertForm.harumarket_productSize_name.focus();
            return;
        }

        var formData = new FormData();
        formData.append("type", "update");
        formData.append("harumarket_productSize_index", harumarket_productSize_index);
        formData.append("harumarket_productSize_name", harumarket_productSize_name);

        data = ajax_send(formData,"./productSize_manager_api.php");

        if(data.code == "200"){
            document.getElementById('productSize_manager_updateModal').classList.remove('show');
            document.getElementById('productSize_manager_updateModal').style.display = 'none';
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

productSize_manager.init();