let product_manager = {
    firstGrid : new ax5.ui.grid(),
    harumarket_product_content_if : new toastui.Editor({
        el: document.querySelector('#harumarket_product_content_if'),
        previewStyle: 'vertical',
        initialEditType: 'wysiwyg',
        height: '75vh',
        initialValue: ""
    }),
    harumarket_product_picture_if : new toastui.Editor({
        el: document.querySelector('#harumarket_product_picture_if'),
        previewStyle: 'vertical',
        initialEditType: 'wysiwyg',
        height: '50vh',
        initialValue: ""
    }),
    harumarket_product_content_uf : new toastui.Editor({
        el: document.querySelector('#harumarket_product_content_uf'),
        previewStyle: 'vertical',
        initialEditType: 'wysiwyg',
        height: '75vh',
        initialValue: ""
    }),
    harumarket_product_picture_uf : new toastui.Editor({
        el: document.querySelector('#harumarket_product_picture_uf'),
        previewStyle: 'vertical',
        initialEditType: 'wysiwyg',
        height: '50vh',
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
            if (event.target.id === 'insert_mecro') {
                _this.insert_mecro();
            }
        });

        document.addEventListener('change', (event) => {
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

            console.log(event.target.id);

            if (event.target.id === 'harumarket_product_colorView_uf'){
                if (event.target.checked){
                    const harumarket_product_colorView_uf = document.querySelector('#harumarket_productColor_uf');
                    harumarket_product_colorView_uf.style.visibility = "visible";
                }
                else{
                    const harumarket_product_colorView_uf = document.querySelector('#harumarket_productColor_uf');
                    harumarket_product_colorView_uf.style.visibility = "hidden";
                }
            }

            if (event.target.id === 'harumarket_product_sizeView_uf'){
                if (event.target.checked){
                    const harumarket_product_sizeView_uf = document.querySelector('#harumarket_productSize_uf'); 
                    harumarket_product_sizeView_uf.style.visibility = "visible";
                }
                else{
                    const harumarket_product_sizeView_uf = document.querySelector('#harumarket_productSize_uf');
                    harumarket_product_sizeView_uf.style.visibility = "hidden";
                }
            }
        });

        _this.search();
    },
    grid_init:function(){
        this.firstGrid.setConfig({
            target: $('[data-ax5grid="first-grid"]'),
            columns: [
                { key: "harumarket_product_index", label: "인덱스"},
                { key: "haruMarket_productCategory_name", label: "카테고리 이름", width:100 },
                { key: "harumarket_product_name", label: "상품 이름", width:250 },
                { key: "harumarket_product_originPrice", label: "상품 가격"},
                { key: "harumarket_product_salePrice", label: "상품 할인 가격"},
                { key: "harumarket_product_view", label: "상품 화면 노출 여부", width:120},
                { key: "harumarket_product_advertiseView", label: "상품 광고 노출 여부", width:120},
                { key: "harumarket_product_colorView", label: "상품 색상 노출 여부", width:120},
                { key: "harumarket_product_colorIndexs", label: "상품 색상", width:200},
                { key: "harumarket_product_sizeView", label: "상품 크기 노출 여부", width:120},
                { key: "harumarket_product_sizeIndexs", label: "상품 크기", width:200},
                { key: "harumarket_product_insertTime", label: "등록 시간" ,width:170},
                { key: "harumarket_product_insertUserIndex", label: "등록 시도 계정" },
                { key: "harumarket_product_updateTime", label: "수정 시간" ,width:170},
                { key: "harumarket_product_updateUserIndex", label: "수정 시도 계정" },
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
        //haruMarket_productCategory_index
        formData = new FormData();
        formData.append("type", "harumarket_OpsionSelect");
        formData.append("table_name", "harumarket_productcategory");
        data = ajax_send(formData,"./product_manager_api.php");
        const haruMarket_productCategory_index = document.querySelector('#haruMarket_productCategory_index'); 
        let option = document.createElement('option');
        option.value = '';
        option.text = '선택';
        haruMarket_productCategory_index.appendChild(option);
        data.msg.forEach(function(item) {
            option = document.createElement('option');
            option.value = item.haruMarket_productCategory_index;
            option.text = item.haruMarket_productCategory_name;
            haruMarket_productCategory_index.appendChild(option);
        });
        //harumarket_product_colorIndexs
        formData = new FormData();
        formData.append("type", "harumarket_OpsionSelect");
        formData.append("table_name", "harumarket_productcolor");
        data = ajax_send(formData,"./product_manager_api.php");
        const harumarket_product_colorIndexs = document.querySelector('#harumarket_product_colorIndexs'); 
        option = document.createElement('option');
        option.value = '';
        option.text = '선택';
        harumarket_product_colorIndexs.appendChild(option);
        data.msg.forEach(function(item) {
            option = document.createElement('option');
            option.value = item.harumarket_productColor_index;
            option.text = item.harumarket_productColor_name;
            harumarket_product_colorIndexs.appendChild(option);
        });
        //harumarket_product_sizeIndexs
        formData = new FormData();
        formData.append("type", "harumarket_OpsionSelect");
        formData.append("table_name", "harumarket_productsize");
        data = ajax_send(formData,"./product_manager_api.php");
        const harumarket_product_sizeIndexs = document.querySelector('#harumarket_product_sizeIndexs'); 
        option = document.createElement('option');
        option.value = '';
        option.text = '선택';
        harumarket_product_sizeIndexs.appendChild(option);
        data.msg.forEach(function(item) {
            option = document.createElement('option');
            option.value = item.harumarket_productSize_index;
            option.text = item.harumarket_productSize_name;
            harumarket_product_sizeIndexs.appendChild(option);
        });

        // 입력 참 옵션
        formData = new FormData();
        formData.append("type", "harumarket_OpsionSelect");
        formData.append("table_name", "harumarket_productcategory");
        data = ajax_send(formData,"./product_manager_api.php");

        let insertForm = document.insertForm;
        
        option = document.createElement('option');
        option.value = '';
        option.text = '선택';
        insertForm.haruMarket_productCategory_index.appendChild(option);

        data.msg.forEach(function(item) {
            option = document.createElement('option');
            option.value = item.haruMarket_productCategory_index;
            option.text = item.haruMarket_productCategory_name;
            insertForm.haruMarket_productCategory_index.appendChild(option);
        });

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

        // 수정 창 옵션
        formData = new FormData();
        formData.append("type", "harumarket_OpsionSelect");
        formData.append("table_name", "harumarket_productcategory");
        data = ajax_send(formData,"./product_manager_api.php");

        let updateForm = document.updateForm;
        
        option = document.createElement('option');
        option.value = '';
        option.text = '선택';
        updateForm.haruMarket_productCategory_index.appendChild(option);

        data.msg.forEach(function(item) {
            option = document.createElement('option');
            option.value = item.haruMarket_productCategory_index;
            option.text = item.haruMarket_productCategory_name;
            updateForm.haruMarket_productCategory_index.appendChild(option);
        });

        const harumarket_productColor_uf = document.querySelector('#harumarket_productColor_uf'); 
        harumarket_productColor_uf.innerHTML = '';

        var formData = new FormData();
        formData.append("type", "harumarket_OpsionSelect");
        formData.append("table_name", "harumarket_productcolor");
        data = ajax_send(formData,"./product_manager_api.php");

        data.msg.forEach(function(item) {
            harumarket_productColor_uf.innerHTML += `
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

        const harumarket_productSize_uf = document.querySelector('#harumarket_productSize_uf'); 
        harumarket_productSize_uf.innerHTML = '';

        formData.append("type", "harumarket_OpsionSelect");
        formData.append("table_name", "harumarket_productsize");
        data = ajax_send(formData,"./product_manager_api.php");

        data.msg.forEach(function(item) {
            harumarket_productSize_uf.innerHTML += `
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
        let harumarket_product_view = document.getElementById('harumarket_product_view').value;
        let haruMarket_productCategory_index = document.getElementById('haruMarket_productCategory_index').value;
        let harumarket_product_name = document.getElementById('harumarket_product_name').value;
        let harumarket_product_colorView = document.getElementById('harumarket_product_colorView').value;
        let harumarket_product_sizeView = document.getElementById('harumarket_product_sizeView').value;
        let harumarket_product_colorIndexs = document.getElementById('harumarket_product_colorIndexs').value;
        let harumarket_product_sizeIndexs = document.getElementById('harumarket_product_sizeIndexs').value;
        let harumarket_product_originPrice_min = document.getElementById('harumarket_product_originPrice_min').value;
        let harumarket_product_originPrice_max = document.getElementById('harumarket_product_originPrice_max').value;
        let harumarket_product_salePrice_min = document.getElementById('harumarket_product_salePrice_min').value;
        let harumarket_product_salePrice_max = document.getElementById('harumarket_product_salePrice_max').value;
        let harumarket_product_advertiseView = document.getElementById('harumarket_product_advertiseView').value;

        var formData = new FormData();
        formData.append("type", "search");
        formData.append("harumarket_product_view", harumarket_product_view);
        formData.append("haruMarket_productCategory_index", haruMarket_productCategory_index);
        formData.append("harumarket_product_name", harumarket_product_name);
        formData.append("harumarket_product_colorView", harumarket_product_colorView);
        formData.append("harumarket_product_sizeView", harumarket_product_sizeView);
        formData.append("harumarket_product_colorIndexs", harumarket_product_colorIndexs);
        formData.append("harumarket_product_sizeIndexs", harumarket_product_sizeIndexs);
        formData.append("harumarket_product_originPrice_min", harumarket_product_originPrice_min);
        formData.append("harumarket_product_originPrice_max", harumarket_product_originPrice_max);
        formData.append("harumarket_product_salePrice_min", harumarket_product_salePrice_min);
        formData.append("harumarket_product_salePrice_max", harumarket_product_salePrice_max);
        formData.append("harumarket_product_advertiseView", harumarket_product_advertiseView);

        data = ajax_send(formData,"./product_manager_api.php");
        this.firstGrid.setData(data.msg);
    },
    insert: function(){
        var myModal = new bootstrap.Modal(document.getElementById("product_manager_insertModal"), {});
        myModal.show();
    },
    insertProcess: function(){
        let insertForm = document.insertForm;

        let harumarket_product_view = 0;

        if(insertForm.harumarket_product_view.checked){
            harumarket_product_view = 1;
        }
        else{
            harumarket_product_view = 0;
        }

        let harumarket_product_advertiseView = 0;

        if(insertForm.harumarket_product_advertiseView.checked){
            harumarket_product_advertiseView = 1;
        }
        else{
            harumarket_product_advertiseView = 0;
        }

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

        let harumarket_product_colorView = 0;

        if(insertForm.harumarket_product_colorView.checked){
            harumarket_product_colorView = 1;
        }
        else{
            harumarket_product_colorView = 0;
        }

        let harumarket_product_sizeView = 0;

        if(insertForm.harumarket_product_sizeView.checked){
            harumarket_product_sizeView = 1;
        }
        else{
            harumarket_product_sizeView = 0;
        }


        if(harumarket_product_colorView==0 && harumarket_product_sizeView==0){
            toastr.error('상품 색상이나 크기 둘 중에 하나는 선택하여 주십시오.');
            return;
        }

        let harumarket_product_colorIndexs = "";
        if(harumarket_product_colorView==1){
            const ul = document.getElementById("harumarket_productColor_if");
            const checkboxes = ul.querySelectorAll('input[type="checkbox"]:checked');
            const checkedValues = [];
            checkboxes.forEach(checkbox => {
                checkedValues.push(checkbox.value);
            });
            
            harumarket_product_colorIndexs = `{${checkedValues.join(',')}}`;
        }
        if(harumarket_product_colorView==1 && harumarket_product_colorIndexs=="{}"){
            toastr.error('상품 색상의 종류를 선택하여 주십시오.');
            return;
        }

        let harumarket_product_sizeIndexs = "";
        if(harumarket_product_sizeView==1){
            const ul = document.getElementById("harumarket_productSize_if");
            const checkboxes = ul.querySelectorAll('input[type="checkbox"]:checked');
            const checkedValues = [];
            checkboxes.forEach(checkbox => {
                checkedValues.push(checkbox.value);
            });
            
            harumarket_product_sizeIndexs = `{${checkedValues.join(',')}}`;
        }
        if(harumarket_product_sizeView==1 && harumarket_product_sizeIndexs=="{}"){
            toastr.error('상품 크기의 종류를 선택하여 주십시오.');
            return;
        }

        let harumarket_product_picture = this.harumarket_product_picture_if.getHTML();
        if(this.harumarket_product_picture_if.getMarkdown() == ""){
            toastr.error('상품 사진을 등록하여 주십시오.');
            return;
        }

        let harumarket_product_content = this.harumarket_product_content_if.getHTML();
        if(this.harumarket_product_content_if.getMarkdown() == ""){
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

        formData.append("harumarket_product_advertiseView", harumarket_product_advertiseView);
        
        data = ajax_send(formData,"./product_manager_api.php");

        if(data.code == "200"){
            toastr.success(data.msg);
            product_manager.search();
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
            toastr.error('수정할 상품을 한개 선택하여 주십시오.');
            return;
        }

        var selectedRows = this.firstGrid.getList('selected');
        let harumarket_product_index = selectedRows[0].harumarket_product_index;
        var formData = new FormData();
        formData.append("type", "view");
        formData.append("harumarket_product_index", harumarket_product_index);
        data = ajax_send(formData,"./product_manager_api.php");

        let updateForm = document.updateForm;

        if(data.msg[0].harumarket_product_view == "노출"){
            updateForm.harumarket_product_view.checked = true;
        }
        else
        {
            updateForm.harumarket_product_view.checked = false;
        }

        if(data.msg[0].harumarket_product_advertiseView == "노출"){
            updateForm.harumarket_product_advertiseView.checked = true;
        }
        else
        {
            updateForm.harumarket_product_advertiseView.checked = false;
        }

        updateForm.haruMarket_productCategory_index.value = data.msg[0].haruMarket_productCategory_index;
        updateForm.harumarket_product_name.value = data.msg[0].harumarket_product_name;
        updateForm.harumarket_product_originPrice.value = data.msg[0].harumarket_product_originPrice;
        updateForm.harumarket_product_salePrice.value = data.msg[0].harumarket_product_salePrice;

        if(data.msg[0].harumarket_product_colorView == "노출"){
            updateForm.harumarket_product_colorView.checked = true;
            const harumarket_product_colorView_uf = document.querySelector('#harumarket_productColor_uf');
            harumarket_product_colorView_uf.style.visibility = "visible";

            let arr = data.msg[0].harumarket_product_colorIndexs.slice(1, -1).split(',');
            arr.forEach(function(harumarket_productColor_index) {
                //console.log(harumarket_productColor_index); // 각 숫자를 콘솔에 출력
                const ulElement = document.getElementById('harumarket_productColor_uf');
                const checkboxes = ulElement.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    //console.log(checkbox.value); // 체크박스의 value 값 출력
                    if(checkbox.value == harumarket_productColor_index){
                        checkbox.checked = true;
                    }
                });
            });
        }
        else
        {
            updateForm.harumarket_product_colorView.checked = false;
            const harumarket_product_colorView_uf = document.querySelector('#harumarket_productColor_uf');
            harumarket_product_colorView_uf.style.visibility = "hidden";
        }

        if(data.msg[0].harumarket_product_sizeView == "노출"){
            updateForm.harumarket_product_sizeView.checked = true;
            const harumarket_productSize_uf = document.querySelector('#harumarket_productSize_uf');
            harumarket_productSize_uf.style.visibility = "visible";

            let arr = data.msg[0].harumarket_product_sizeIndexs.slice(1, -1).split(',');
            arr.forEach(function(harumarket_product_sizeView_index) {
                //console.log(harumarket_productColor_index); // 각 숫자를 콘솔에 출력
                const ulElement = document.getElementById('harumarket_productSize_uf');
                const checkboxes = ulElement.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    //console.log(checkbox.value); // 체크박스의 value 값 출력
                    if(checkbox.value == harumarket_product_sizeView_index){
                        checkbox.checked = true;
                    }
                });
            });
        }
        else{
            updateForm.harumarket_product_sizeView.checked = false;
            const harumarket_productSize_uf = document.querySelector('#harumarket_productSize_uf');
            harumarket_productSize_uf.style.visibility = "hidden";
        }

        this.harumarket_product_picture_uf.setHTML(data.msg[0].harumarket_product_picture);
        this.harumarket_product_content_uf.setHTML(data.msg[0].harumarket_product_content);

        var myModal = new bootstrap.Modal(document.getElementById("product_manager_updateModal"), {});
        myModal.show();
    },
    update_process: function(){
        var selectedRows = this.firstGrid.getList('selected');
        let harumarket_product_index = selectedRows[0].harumarket_product_index;

        let updateForm = document.updateForm;

        let harumarket_product_view = 0;

        if(updateForm.harumarket_product_view.checked){
            harumarket_product_view = 1;
        }
        else{
            harumarket_product_view = 0;
        }

        let harumarket_product_advertiseView = 0;

        if(updateForm.harumarket_product_advertiseView.checked){
            harumarket_product_advertiseView = 1;
        }
        else{
            harumarket_product_advertiseView = 0;
        }

        let haruMarket_productCategory_index = updateForm.haruMarket_productCategory_index.value;
        if(haruMarket_productCategory_index == ""){
            toastr.error('카테고리를 선택하여 주십시오.');
            updateForm.haruMarket_productCategory_index.focus();
            return;
        }
        let harumarket_product_name = updateForm.harumarket_product_name.value;
        if(harumarket_product_name == ""){
            toastr.error('상품 이름을 입력하여 주십시오.');
            updateForm.harumarket_product_name.focus();
            return;
        }
        if(harumarket_product_name.length > 100){
            toastr.error('상품 이름은 100자 밑으로 입력하여 주십시오.');
            updateForm.harumarket_product_name.focus();
            return;
        }
        let harumarket_product_originPrice = updateForm.harumarket_product_originPrice.value;
        if(harumarket_product_originPrice == ""){
            toastr.error('상품 가격을 입력하여 주십시오.');
            updateForm.harumarket_product_originPrice.focus();
            return;
        }
        let harumarket_product_salePrice = updateForm.harumarket_product_salePrice.value;
        if(harumarket_product_salePrice == ""){
            toastr.error('상품 할인 가격을 입력하여 주십시오.');
            updateForm.harumarket_product_salePrice.focus();
            return;
        }

        let harumarket_product_colorView = 0;

        if(updateForm.harumarket_product_colorView.checked){
            harumarket_product_colorView = 1;
        }
        else{
            harumarket_product_colorView = 0;
        }

        let harumarket_product_sizeView = 0;

        if(updateForm.harumarket_product_sizeView.checked){
            harumarket_product_sizeView = 1;
        }
        else{
            harumarket_product_sizeView = 0;
        }

        if(harumarket_product_colorView==0 && harumarket_product_sizeView==0){
            toastr.error('상품 색상이나 크기 둘 중에 하나는 선택하여 주십시오.');
            return;
        }

        let harumarket_product_colorIndexs = "";
        if(harumarket_product_colorView==1){
            const ul = document.getElementById("harumarket_productColor_uf");
            const checkboxes = ul.querySelectorAll('input[type="checkbox"]:checked');
            const checkedValues = [];
            checkboxes.forEach(checkbox => {
                checkedValues.push(checkbox.value);
            });
            
            harumarket_product_colorIndexs = `{${checkedValues.join(',')}}`;
        }
        if(harumarket_product_colorView==1 && harumarket_product_colorIndexs=="{}"){
            toastr.error('상품 색상의 종류를 선택하여 주십시오.');
            return;
        }

        let harumarket_product_sizeIndexs = "";
        if(harumarket_product_sizeView==1){
            const ul = document.getElementById("harumarket_productSize_uf");
            const checkboxes = ul.querySelectorAll('input[type="checkbox"]:checked');
            const checkedValues = [];
            checkboxes.forEach(checkbox => {
                checkedValues.push(checkbox.value);
            });
            
            harumarket_product_sizeIndexs = `{${checkedValues.join(',')}}`;
        }
        if(harumarket_product_sizeView==1 && harumarket_product_sizeIndexs=="{}"){
            toastr.error('상품 크기의 종류를 선택하여 주십시오.');
            return;
        }

        let harumarket_product_picture = this.harumarket_product_picture_uf.getHTML();
        if(this.harumarket_product_picture_uf.getMarkdown() == ""){
            toastr.error('상품 사진을 등록하여 주십시오.');
            return;
        }

        let harumarket_product_content = this.harumarket_product_content_uf.getHTML();
        if(this.harumarket_product_content_uf.getMarkdown() == ""){
            toastr.error('상품 상세 설명을 작성하여 주십시오.');
            return;
        }

        var formData = new FormData();
        formData.append("type", "update");
        formData.append("harumarket_product_index", harumarket_product_index);
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
        formData.append("harumarket_product_advertiseView", harumarket_product_advertiseView);
        
        data = ajax_send(formData,"./product_manager_api.php");

        if(data.code == "200"){
            toastr.success(data.msg);
            product_manager.search();

            document.getElementById('product_manager_updateModal').classList.remove('show');
            document.getElementById('product_manager_updateModal').style.display = 'none';
            const modalBackdrop = document.getElementsByClassName('modal-backdrop');
            modalBackdrop[0].parentNode.removeChild(modalBackdrop[0]);
        }
        else{
            toastr.error(data.msg);
        }
    },
    insert_mecro : function(){
        var formData = new FormData();
        formData.append("type", "insert_mecro");
        data = ajax_send(formData,"./product_manager_api.php");

        if(data.code == "200"){
            toastr.success(data.msg);
            product_manager.search();
        }
        else{
            toastr.error(data.msg);
        }
    },
}

product_manager.init();