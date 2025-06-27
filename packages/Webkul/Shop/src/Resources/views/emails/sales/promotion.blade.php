@component('shop::emails.layouts.master')
    <tr>
        <td bgcolor="#eef4fa" align="center" style="padding: 30px 0 30px 0;">
            <a href="{{ config('app.url') }}">
                @include ('shop::emails.layouts.logo')
            </a>
        </td>
    </tr>

    <tr>
        <td bgcolor="#ffffff" style="padding: 30px 30px 30px 30px;">
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="font-size: 16px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                        Caro Cliente,
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 14px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif; padding: 10px 0 10px 0;">
                        <strong>OPORTUNIDADE MOUNJARO FRASCO-AMPOLA PROJETO VERÃO</strong><br><br>

                        <strong>DISPONÍVEL PARA COMPRA DE 27/11 à 6/12.</strong><br><br>

                        <strong>R$ 5.499,00</strong> caixa com 4 ampolas (2.5 / 5 / 7.5 / 10 / 12.5 / 15 mg) – Origem Alemanha<br><br>

                        <strong>PEDIDO MÍNIMO:</strong> 2 (DUAS) CAIXAS<br>
                        <strong>PEDIDO MÁXIMO:</strong> 6 (SEIS) CAIXAS<br><br>

                        <strong>Entrega garantida até início de Janeiro!!!!</strong><br><br>

                        <strong>Pagamento:</strong><br>
                        - O pagamento pode ser no boleto à vista, PIX ou cartão de crédito (acrescidos de IOF de 0,38%), podendo ser parcelado em até 3x.<br><br>

                        Para o pedido, enviar os seguintes dados do paciente:<br>
                        <ul>
                            <li>Nome Completo (como no CPF)</li>
                            <li>CPF</li>
                            <li>E-mail</li>
                            <li>Telefone</li>
                            <li>Data de nascimento DD/MM/AAAA</li>
                            <li>Endereço Completo com CEP</li>
                            <li>Forma de pagamento</li>
                            <li>Opção desejada (quantidade)</li>
                        </ul><br>

                        Precisaremos, por favor, da prescrição, de cópia de CNH/RG e comprovante de endereço para fins do processo de importação. O comprovante de endereço tem que ser o mesmo do titular do pedido e endereço de entrega.<br><br>

                        Para garantir seu pedido, basta responder este email ou <a href="https://wa.me/5511970755951?text=MOUNJARO%20VER%C3%83O%202025">whatsapp +55 11 97075-5951</a> com a frase <strong>MOUNJARO VERÃO 2025</strong> e os dados solicitados acima. Com os dados, geramos o link de pagamento e disparamos o envio.<br><br>

                        Os valores informados valem para pagamento à vista.<br>
                        Outras formas de pagamento estarão sujeitas a juros e taxas de cartão.<br>
                        Os valores informados poderão ser revistos a qualquer momento devido a variação cambial e disponibilidade de estoque.<br><br>

                        <strong>OBS.:</strong> NÃO VENDEMOS TIRZEPATIDA MANIPULADA OU EM QUALQUER OUTRA APRESENTAÇÃO QUE NÃO SEJA A ORIGINAL DO FABRICANTE.
                    </td>
                </tr>
                <tr>
                    <td style="padding:30px 0 0 0;"></td>
                </tr>

                <tr>
                    <td style="padding:0 0 30px 0;"></td>
                </tr>

                <tr>
                    <td style="font-size: 12px;color: #5E5E5E;line-height: 24px;font-family: montserrat, sans-serif;padding: 10px 0 10px 0;">
                        ESTA CAMPANHA É ADMINISTRADA PELA MUNDIHEALTH EUROPA. OPERAÇÃO, LINKS DE PAGAMENTO E LOGÍSTICA INDEPENDENTES DA MYPHARMA2GO QUE ATUA APENAS COMO PARCEIRA COMERCIAL.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endcomponent