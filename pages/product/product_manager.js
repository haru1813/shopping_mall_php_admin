let user_manager = {
    firstGrid : new ax5.ui.grid(),
    harumarket_product_content_if : new toastui.Editor({
        el: document.querySelector('#harumarket_product_content_if'),
        previewStyle: 'vertical',
        initialEditType: 'wysiwyg',
        height: '75vh',
        initialValue: ""
    }),
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
        _this.option_init();

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

        document.addEventListener('change', (event) => {
            if (event.target.id === 'formFile') {
                const formFile = document.getElementById('formFile');
                const file = formFile.files[0];
                const fileName = file.name;
                const fileExtension = fileName.split('.').pop().toLowerCase();
                if (fileExtension != 'webp'){
                    formFile.value='';
                    toastr.error('파일의 형식은 webp만 가능합니다.');
                    return;
                }

                _this.image_upload(event,file);
            }

            if (event.target.id === 'harumarket_product_colorView_if'){
                if (event.target.checked){
                    const harumarket_productColor_if = document.querySelector('#harumarket_productColor_if');
                    harumarket_productColor_if.style.visibility = "visible";
                }
                else{
                    const harumarket_productColor_if = document.querySelector('#harumarket_productColor_if');
                    harumarket_productColor_if.style.visibility = "hidden";
                }
            }

            if (event.target.id === 'harumarket_product_sizeView_if'){
                if (event.target.checked){
                    const harumarket_productSize_if = document.querySelector('#harumarket_productSize_if'); 
                    harumarket_productSize_if.style.visibility = "visible";
                }
                else{
                    const harumarket_productSize_if = document.querySelector('#harumarket_productSize_if');
                    harumarket_productSize_if.style.visibility = "hidden";
                }
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
    option_init:function(){
        const harumarket_productColor_if = document.querySelector('#harumarket_productColor_if'); 
        harumarket_productColor_if.innerHTML = '';

        var formData = new FormData();
        formData.append("type", "harumarket_OpsionSelect");
        formData.append("table_name", "harumarket_productcolor");
        data = ajax_send(formData,"./product_manager_api.php");

        data.msg.forEach(function(item) {
            harumarket_productColor_if.innerHTML += `
                <li class="list-group-item">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" value="${item.harumarket_productColor_index}">
                        <label class="form-check-label mb-0">
                            ${item.harumarket_productColor_name}
                        </label>
                    </div>
                </li>
            `;
        });

        const harumarket_productSize_if = document.querySelector('#harumarket_productSize_if'); 
        harumarket_productSize_if.innerHTML = '';

        formData.append("type", "harumarket_OpsionSelect");
        formData.append("table_name", "harumarket_productsize");
        data = ajax_send(formData,"./product_manager_api.php");

        data.msg.forEach(function(item) {
            harumarket_productSize_if.innerHTML += `
                <li class="list-group-item">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" value="${item.harumarket_productSize_index}">
                        <label class="form-check-label mb-0">
                            ${item.harumarket_productSize_name}
                        </label>
                    </div>
                </li>
            `;
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
        var formData = new FormData();
        formData.append("type", "harumarket_OpsionSelect");
        formData.append("table_name", "harumarket_productcategory");
        data = ajax_send(formData,"./product_manager_api.php");

        let insertForm = document.insertForm;
        
        let option = document.createElement('option');
        option.value = '';
        option.text = '선택';
        insertForm.haruMarket_productCategory_index.appendChild(option);

        data.msg.forEach(function(item) {
            option = document.createElement('option');
            option.value = item.haruMarket_productCategory_index;
            option.text = item.haruMarket_productCategory_name;
            insertForm.haruMarket_productCategory_index.appendChild(option);
        });

        var myModal = new bootstrap.Modal(document.getElementById("product_manager_insertModal"), {});
        myModal.show();
    },
    insertProcess: function(){
        let insertForm = document.insertForm;

        let harumarket_product_view = insertForm.harumarket_product_view.checked;

        let haruMarket_productCategory_index = insertForm.haruMarket_productCategory_index.value;
        if(haruMarket_productCategory_index == ""){
            toastr.error('카테고리를 선택하여 주십시오.');
            insertForm.haruMarket_productCategory_index.focus();
            return;
        }

        let harumarket_product_name = insertForm.harumarket_product_name.value;
        if(harumarket_product_name == ""){
            toastr.error('상품 이름을 입력하여 주십시오.');
            insertForm.harumarket_product_name.focus();
            return;
        }
        if(harumarket_product_name.length > 100){
            toastr.error('상품 이름은 100자 밑으로 입력하여 주십시오.');
            insertForm.harumarket_product_name.focus();
            return;
        }
        let harumarket_product_originPrice = insertForm.harumarket_product_originPrice.value;
        if(harumarket_product_originPrice == ""){
            toastr.error('상품 가격을 입력하여 주십시오.');
            insertForm.harumarket_product_originPrice.focus();
            return;
        }
        let harumarket_product_salePrice = insertForm.harumarket_product_salePrice.value;
        if(harumarket_product_salePrice == ""){
            toastr.error('상품 할인 가격을 입력하여 주십시오.');
            insertForm.harumarket_product_salePrice.focus();
            return;
        }

        let harumarket_product_picture = insertForm.harumarket_product_picture.files[0];
        if(!harumarket_product_picture){
            toastr.error('상품 사진을 등록하여 주십시오.');
            insertForm.harumarket_product_picture.focus();
            return;
        }

        let harumarket_product_colorView = insertForm.harumarket_product_colorView.checked;
        let harumarket_product_sizeView = insertForm.harumarket_product_sizeView.checked;

        if(!harumarket_product_colorView && !harumarket_product_sizeView){
            toastr.error('상품 색상이나 크기 둘 중에 하나는 선택하여 주십시오.');
            return;
        }

        let harumarket_product_colorIndexs = "";
        if(harumarket_product_colorView){
            const ul = document.getElementById("harumarket_productColor_if");
            const checkboxes = ul.querySelectorAll('input[type="checkbox"]:checked');
            const checkedValues = [];
            checkboxes.forEach(checkbox => {
                checkedValues.push(checkbox.value);
            });
            
            harumarket_product_colorIndexs = `{${checkedValues.join(',')}}`;
        }
        let harumarket_product_sizeIndexs = "";
        if(harumarket_product_sizeView){
            const ul = document.getElementById("harumarket_productSize_if");
            const checkboxes = ul.querySelectorAll('input[type="checkbox"]:checked');
            const checkedValues = [];
            checkboxes.forEach(checkbox => {
                checkedValues.push(checkbox.value);
            });
            
            harumarket_product_sizeIndexs = `{${checkedValues.join(',')}}`;
        }

        let harumarket_product_content = this.harumarket_product_content_if.getHTML();
        if(harumarket_product_content == "<p><br></p>"){
            toastr.error('상품 상세 설명을 작성하여 주십시오.');
            return;
        }

        var formData = new FormData();
        formData.append("type", "insert");
        formData.append("haruMarket_productCategory_index", haruMarket_productCategory_index);
        formData.append("harumarket_product_name", harumarket_product_name);
        formData.append("harumarket_product_colorView", harumarket_product_colorView);
        formData.append("harumarket_product_sizeView", harumarket_product_sizeView);
        formData.append("harumarket_product_colorIndexs", harumarket_product_colorIndexs);
        formData.append("harumarket_product_sizeIndexs", harumarket_product_sizeIndexs);
        formData.append("harumarket_product_picture", harumarket_product_picture);
        formData.append("harumarket_product_content", harumarket_product_content);

        formData.append("harumarket_product_view", harumarket_product_view);
        formData.append("harumarket_product_originPrice", harumarket_product_originPrice);
        formData.append("harumarket_product_salePrice", harumarket_product_salePrice);
        
        data = ajax_send(formData,"./product_manager_api.php");

        if(data.code == "200"){
            toastr.success(data.msg);
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
    image_upload: function(event,file){
        if(file){
            const reader = new FileReader();

            const previewImage = document.getElementById('previewImage');

            reader.onload = (event) => {
                previewImage.src = event.target.result;
            };

            reader.readAsDataURL(file);
        }
    },
}

user_manager.init();