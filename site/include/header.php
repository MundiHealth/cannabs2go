<!-- loading -->
<div class="se-pre-con"></div>

<header>
    <div class="header">
        <div class="container">
            <div class="header-nav">
                <div class="logo">
                    <a href="index">
                        <img src="assets/img/logo-mypharma2go.svg" alt="MyPharma2GO">
                    </a>
                </div>

                <nav>
                    <div> 
                        <span>menu</span> <i class="fa-solid fa-xmark"></i> 
                    </div>
    
                    <ul class="menu">
                        <li class="<?php echo ($page == 'home')? 'active' : '';?>">
                            <a href="index" >Home</a>
                        </li>
                        <li class="<?php echo ($page == 'quem-somos')? 'active' : '';?>">
                            <a href="quem-somos">Quem Somos</a>
                        </li>

                        <li class="<?php echo ($page == 'servicos')? 'active' : '';?>">
                            <a href="servicos">Serviços</a>
                        </li>

                        <li class="<?php echo ($page == 'publico-alvo')? 'active' : '';?>">
                            <a href="publicos-atendidos">Públicos Atendidos</a>
                        </li>

                        <li class="<?php echo ($page == 'blog')? 'active' : '';?>">
                            <a href="blog">Blog</a>
                        </li>

                        <li class="<?php echo ($page == 'ecommerce')? 'active' : '';?>">
                            <a href="e-commerce">E-commerce</a>
                        </li>

                        <li class="<?php echo ($page == 'contato')? 'active' : '';?>">
                            <a href="contato">Contato</a>
                        </li>
                    </ul>
                </nav>

                <div class="toggle-nav">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
        </div>
    </div>
</header>