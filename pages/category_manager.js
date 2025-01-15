let category_manager = {
    init: function(){
        let _this = this;

        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            navLinks.forEach(link => link.classList.remove('active'));
        });

        document.getElementById('category_manager').classList.add('active');
    },
    navClick:function(){
        
    },
}

category_manager.init();