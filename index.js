let index = {
    init: function(){
        let _this = this;
        document.getElementById("login").addEventListener("click", () => {
            _this.login();
        });
    },
    login: function(){
        let haruMarket_user_id = document.getElementById('haruMarket_user_id').value;
        let haruMarket_user_pw = document.getElementById('haruMarket_user_pw').value;

        if(haruMarket_user_id == ""){
            toastr.error('아이디를 입력하여 주십시오.');
            document.getElementById('haruMarket_user_id').focus();
            return;
        }
        if(haruMarket_user_pw == ""){
            toastr.error('비밀번호를 입력하여 주십시오.');
            document.getElementById('haruMarket_user_pw').focus();
            return;
        }

        let formData = new FormData();
        formData.append("type", "login");
        formData.append("haruMarket_user_id", haruMarket_user_id);
        formData.append("haruMarket_user_pw", haruMarket_user_pw);
        data = ajax_send(formData,"./index_api.php");

        if(data.code == "200"){
            location.href = "/pages/main.php";
        }
        else{
            toastr.error(data.msg);
        }
    },
}

index.init();