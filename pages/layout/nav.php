<body style="overflow-x: hidden; overflow-y: hidden;">
    <div id="pc">
        <div class="container-fluid h-100 w-100 p-0 m-0">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">하루마켓 관리자</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="user">
                                유저 관리
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/pages/user/user_manager.php" id="user_manager">유저 관리</a></li>
                                <li><a class="dropdown-item" href="/pages/user/cart_manager.php" id="cart_manager">장바구니 관리</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="product">
                                상품 관리
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/pages/product/category_manager.php" id="category_manager">상품 카테고리 관리</a></li>
                                <li><a class="dropdown-item" href="/pages/product/product_manager.php" id="product_manager">상품 관리</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <button class="btn btn-outline-success">로그아웃</button>
                    </form>
                    </div>
                </div>
            </nav>