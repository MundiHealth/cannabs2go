<?php
    $page = 'contato';
	$title = 'Contato';
	$description = 'Fale com nossa equipe para tirar dúvidas e descobrir soluções personalizadas.';

include 'include/head.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $publico = $_POST['publico'];
    $mensagem = $_POST['mensagem'];

    $to = "contato@mypharma2go.com";
    $subject = "Novo contato de $nome";
    $body = "Nome: $nome\nE-mail: $email\nTelefone: $telefone\nPúblico-alvo: $publico\nMensagem:\n$mensagem";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "<script>alert('Mensagem enviada com sucesso!');</script>";
    } else {
        echo "<script>alert('Falha ao enviar a mensagem. Tente novamente mais tarde.');</script>";
    }
}
?>

<body class="contact">

    <?php include 'include/header.php'; ?>

    <main>
        <section class="hero">
            <div class="container">
                <div class="content" data-aos="zoom-in" data-aos-duration="2000">
                    <h1>Fale Conosco <span>Entre em Contato com a MyPharma2Go</span></h1>
                </div>
            </div>
        </section>

        <section class="intro">
            <div class="container">
                <div class="content">
                    <div class="-form">
                        <h2>Na MyPharma2Go, estamos prontos para ouvir você!</h2>

                        <p>Entre em contato com nossa equipe e descubra como podemos ajudá-lo a acessar os tratamentos mais avançados do mundo. Seja para tirar dúvidas, solicitar informações ou obter suporte, estamos ao seu lado em todas as etapas. Para garantir um atendimento personalizado, informe seu perfil no formulário abaixo.</p>

                        <form action="" method="post">
                            <fieldset>
                                <div class="field">
                                    <label for="nome">Nome:</label>
                                    <input type="text" name="nome" id="nome" required>
                                </div>
                                <div class="field -half">
                                    <div>
                                        <label for="email">E-mail:</label>
                                        <input type="email" name="email" id="email" required>
                                    </div>
                                    <div>
                                        <label for="telefone">Telefone:</label>
                                        <input type="tel" name="telefone"  id="telefone">
                                    </div>
                                </div>

                                <div class="field">
                                    <label for="publico">Identifique-se:</label>
                                    <select name="publico" id="publico" required>
                                        <option>Selecione...</option>
                                        <option value="industrias_farmaceuticas">Indústrias Farmacêuticas</option>
                                        <option value="operadoras_saude">Operadoras de Saúde e Autogestão</option>
                                        <option value="hospitais">Hospitais Públicos e Privados</option>
                                        <option value="farmacias_drogarias">Farmácias e Drogarias</option>
                                        <option value="associacoes_doencas_raras">Associações de Apoio a Pacientes e Doenças Raras</option>
                                        <option value="sus">Sistema Público de Saúde</option>
                                        <option value="prescritores">Prescritores</option>
                                        <option value="pacientes">Pacientes</option>
                                        <option value="outros">Outros</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label for="mensagem">Mensagem:</label>
                                    <textarea name="mensagem" id="mensagem" required></textarea>
                                </div>
                                <div class="field">
                                    <button type="submit" class="button">enviar</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                    <div class="-contact">
                        <div>
                            <h3>Localização</h3>
                            <p>Nossos escritórios estão localizados nos Estados Unidos e na Europa, mas atendemos o Brasil com total proximidade e eficiência. Entre em contato durante nosso horário de atendimento para suporte imediato.</p>
                        </div>

                        <div>
                            <h3>Contato</h3>
                            <ul>
                                <li><i class="fa-brands fa-whatsapp"></i> <a href="https://api.whatsapp.com/send/?phone=5511998680834" target="_blank">+55 11 9 9868 0834</a></li>
                                <li><i class="fa-solid fa-envelope"></i> <a href="mailto:atendimento@mypharma2go.com">atendimento@mypharma2go.com</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'include/footer.php' ?>

</body>
</html>