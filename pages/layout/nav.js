let nav = {
    init: function(){
        let _this = this;
    },
    navClick:function(nav_item){
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            navLinks.forEach(link => link.classList.remove('active'));
        });

        console.log(nav_item);
        nav_item.classList.add('active');
    },
}

nav.init();