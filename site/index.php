<?php
    $page = 'home';
	$title = 'Home';
	$description = 'MyPharma2Go conecta você aos tratamentos mais avançados do mundo. Importação rápida, segura e sem burocracia. Saiba mais.';

	include 'include/head.php';
?>

<body class="home">

    <?php include 'include/header.php'; ?>

    <main>
        <section class="hero">
            <div class="container">
                <div class="content" data-aos="zoom-in" data-aos-duration="2000">
                    <p><span>Rápido, seguro e acessível.</span></p>
                    <p>Conectando o Brasil aos tratamentos mais avançados do mundo,</p>
                    <p><small>com segurança logística e regulatória, eficiência e compliance.</small></p>
                </div>
            </div>
        </section>

        <section class="about">
            <div class="container">
                <div class="content">
                    <div class="-image" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
                        <img src="assets/img/home/sobre-a-mypharma2go.png" alt="Sobre a MyPharma2GO">
                    </div>

                    <div class="-text">
                        <h1>Sua melhor opção para medicamentos e tratamentos importados</h1>

                        <p>A <strong>MyPharma2Go</strong> é uma empresa de origem americana especializada em serviços e soluções no segmento da saúde.</p>

                        <p>Com o propósito de conectar o Brasil aos tratamentos mais inovadores do mundo, a MyPharma2Go oferece uma solução completa para acesso a medicamentos especiais e suplementos de última geração.</p>

                        <p>Nossa operação cumpre com as mais rígidas normas legais, regulatórias e de compliance, garantindo rapidez, segurança e economia.</p>

                        <ul>
                            <li>Medicamentos e suplementos importados e inovadores;</li>
                            <li>Quase uma década atendendo clientes brasileiros;</li>
                            <li>Acesso porta-a-porta, desde a aprovação regulatória até a entrega final dos produtos.</li>
                        </ul>

                        <a href="quem-somos" class="button">saiba mais</a>
                    </div>
                </div>
            </div>
        </section>  
        
        <section class="public" id="public">
            <div class="container">
                <div class="intro">
                    <h2>Públicos que atendemos</h2>
                    <h3>Soluções personalizadas para cada necessidade.</h3>

                    <p>Atendemos diferentes perfis com soluções personalizadas que conectam o Brasil aos medicamentos e suplementos mais inovadores do mercado global.</p>

                    <p><strong>Encontre a solução ideal para você!</strong></p>
                </div>

                <div class="items">
                    <div class="-item" data-aos="fade-in" data-aos-delay="50" data-aos-duration="1500">
                        <img src="assets/img/icon-industria-farmaceutica.svg" alt="Indústria Farmacêutica">

                        <h4>Indústria Farmacêutica</h4>
                        <p>Lance seus produtos internacionais no Brasil antes do registro ANVISA.</p>
                        <a href="industria-farmaceutica" class="button-white">saiba mais</a>
                    </div>

                    <div class="-item" data-aos="fade-in" data-aos-delay="100" data-aos-duration="1500">
                        <img src="assets/img/icon-operadoras-de-saude.svg" alt="Operadoras de Saúde e Autogestão">

                        <h4>Operadoras de Saúde e Autogestão</h4>
                        <p>Reduza custos e otimize o acesso a medicamentos exclusivos para seus beneficiários.</p>
                        <a href="operadoras-saude" class="button-white">saiba mais</a>
                    </div>

                    <div class="-item" data-aos="fade-in" data-aos-delay="150" data-aos-duration="1500">
                        <img src="assets/img/icon-hospitais-publicos-e-privados.svg" alt="Hospitais Públicos e Privados">

                        <h4>Hospitais Públicos e Privados</h4>
                        <p>Garanta o fornecimento de medicamentos de última geração para tratamentos avançados.</p>
                        <a href="hospitais" class="button-white">saiba mais</a>
                    </div>

                    <div class="-item" data-aos="fade-in" data-aos-delay="200" data-aos-duration="1500">
                        <img src="assets/img/icon-farmacias-e-drogarias.svg" alt="Farmácias e Drogarias">

                        <h4>Farmácias e Drogarias</h4>
                        <p>Garanta um diferencial competitivo inédito e aumente sua rentabilidade ao explorar um mercado virgem e de grande demanda.</p>
                        <a href="farmacias-drogarias" class="button-white">saiba mais</a>
                    </div>

                    <div class="-item" data-aos="fade-in" data-aos-delay="250" data-aos-duration="1500">
                        <img src="assets/img/icon-associacoes-apoio-doencas-raras.svg" alt="Associações de Apoio a Pacientes e Doenças Raras">

                        <h4>Associações de Apoio a Pacientes e Doenças Raras</h4>
                        <p>Facilite o acesso de seus associados a medicamentos inovadores ainda não disponíveis no Brasil.</p>
                        <a href="associacoes-doencas-raras" class="button-white">saiba mais</a>
                    </div>

                    <div class="-item" data-aos="fade-in" data-aos-delay="300" data-aos-duration="1500">
                        <img src="assets/img/icon-sistema-publico-de-saude.svg" alt="Sistema Público de Saúde">

                        <h4>Sistema Público de Saúde</h4>
                        <p>Atenda demandas regulatórias e judiciais com medicamentos importados de forma segura.</p>
                        <a href="sistema-publico-saude" class="button-white">saiba mais</a>
                    </div>

                    <div class="-item" data-aos="fade-in" data-aos-delay="350" data-aos-duration="1500">
                        <img src="assets/img/icon-prescritores.svg" alt="Prescritores">

                        <h4>Prescritores</h4>
                        <p>Prescreva tratamentos de ponta e ofereça aos seus pacientes soluções globais.</p>
                        <a href="prescritores-medicos" class="button-white">saiba mais</a>
                    </div>

                    <div class="-item" data-aos="fade-in" data-aos-delay="400" data-aos-duration="1500">
                        <img src="assets/img/icon-pacientes.svg" alt="Pacientes">

                        <h4>Pacientes</h4>
                        <p>Tenha acesso rápido e seguro a medicamentos importados recomendados pelo seu médico ou nutricionista.</p>
                        <a href="pacientes" class="button-white">saiba mais</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="profile">
            <div class="container">
                <a href="#public">
                    <img src="assets/img/icon-arrow-top.svg" alt="">
                </a>
                
                <p>Identifique seu perfil e descubra como a MyPharma2Go pode conectá-lo aos melhores tratamentos do mundo.</p>
            </div>
        </section>

        <section class="data">
            <div class="container">
                <div class="intro">
                    <h2>Por que escolher a MyPharma2Go?</h2>
                    <p>Com quase uma década conectando o Brasil ao mercado global de saúde, transformamos vidas e fortalecemos o acesso a soluções inovadoras no setor médico.</p>
                </div>
                
                <div class="items">
                    <div class="-item" data-aos="fade-down" data-aos-duration="2000" data-aos-delay="100">
                        <p><span>420 mil</span> pacientes atendidos</p>
                    </div>

                    <div class="-item" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="200">
                        <p>mais de <span>5.500</span> SKUs disponíveis</p>
                    </div>

                    <div class="-item" data-aos="fade-down" data-aos-duration="2000" data-aos-delay="300">
                        <p><span>23 mil</span> médicos parceiros</p>
                    </div>

                    <div class="-item" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="400">
                        <p><span>Parcerias</span> internacionais sólidas</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'include/footer.php' ?>

</body>
</html>