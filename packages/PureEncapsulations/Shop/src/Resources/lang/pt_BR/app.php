<?php

return [
    'layouts' => [
        'my-account' => 'Minha Conta',
        'profile' => 'Perfil',
        'address' => 'Endereço',
        'reviews' => 'Avaliação',
        'wishlist' => 'Lista de Desejos',
        'orders' => 'Pedidos',
    ],

    'common' => [
        'error' => 'Algo deu errado, por favor, tente novamente mais tarde.',
        'no-result-found' => 'Nenhum resultado foi encontrado para esta busca.'
    ],

    'home' => [
        'page-title' => config('app.name') . ' - Home',
        'featured-products' => 'Produtos em Destaque',
        'new-products' => 'Novos Produtos',
        'verify-email' => 'Verifique sua Conta de E-mail',
        'resend-verify-email' => 'Reenviar Email de Verificação'
    ],

    'header' => [
        'title' => 'Conta',
        'dropdown-text' => 'Gerenciar Carrinho, Pedidos & Lista de Desejos',
        'sign-in' => 'Entrar',
        'sign-up' => 'Criar Conta',
        'account' => 'Conta',
        'cart' => 'Carrinho',
        'profile' => 'Perfil',
        'wishlist' => 'Lista de Desejos',
        'cart' => 'Carrinho',
        'logout' => 'Sair',
        'search-text' => 'Pesquisar produtos aqui'
    ],

    'minicart' => [
        'view-cart' => 'Carrinho',
        'checkout' => 'Finalizar',
        'cart' => 'Carrinho',
        'zero' => '0'
    ],

    'footer' => [
        'subscribe-newsletter' => 'Assinar Newsletter',
        'subscribe' => 'Assinar',
        'locale' => 'Idioma',
        'currency' => 'Moeda',
    ],

    'subscription' => [
        'unsubscribe' => 'Cancelar Inscrição',
        'subscribe' => 'Inscrever-se',
        'subscribed' => 'Você está inscrito para receber e-mails sobre novidades.',
        'not-subscribed' => 'Você não pode se inscrever, tente novamente após algum tempo.',
        'already' => 'Você já está inscrito em nossa lista de assinaturas.',
        'unsubscribed' => 'Você não está inscrito em nossa lista de assinaturas.',
        'already-unsub' => 'Você não está mais inscrito em nossa lista de assinaturas.',
        'not-subscribed' => 'Erro! Email não pode ser enviado, por favor, tente novamente mais tarde.'
    ],

    'search' => [
        'no-results' => 'Nenhum resultado encontrado',
        'page-title' => 'Buscar',
        'found-results' => 'Resultados da pesquisa encontrados',
        'found-result' => 'Resultado da pesquisa encontrado'
    ],

    'reviews' => [
        'title' => 'Título',
        'add-review-page-title' => 'Adicionar Avaliação',
        'write-review' => 'Escreva uma avaliação',
        'review-title' => 'Dê um título a sua avaliação',
        'product-review-page-title' => 'Avaliação do Produto',
        'rating-reviews' => 'Notas & Avaliação',
        'submit' => 'Enviar',
        'delete-all' => 'Todas Avaliações foram excluídas com sucesso',
        'ratingreviews' => ':rating Nota & :review Avaliação',
        'star' => 'Estrela',
        'percentage' => ':percentage %',
        'id-star' => 'estrela',
        'name' => 'Nome'
    ],

    'customer' => [
        'signup-text' => [
            'account_exists' => 'Já tenho uma conta',
            'title' => 'Entrar'
        ],

        'signup-form' => [
            'page-title' => 'Cliente - Formulário de Cadastro',
            'title' => 'Cadastrar',
            'firstname' => 'Nome',
            'lastname' => 'Sobrenome',
            'email' => 'Email',
            'password' => 'Senha',
            'confirm_pass' => 'Confirmar Senha',
            'button_title' => 'Cadastrar',
            'agree' => 'Concordo que a MyPharma2Go compartilhe meus Dados Pessoais com as empresas fabricantes e/ou afiliadas dos produtos comprados, para me mandarem comunicações de marketing. Seu consentimento para este fim é voluntário e você é livre para retirá-lo a qualquer momento. Se você decidir que não deseja mais receber referidas comunicações, você pode revogar o seu consentimento a qualquer tempo, seguindo as instruções fornecidas em tais comunicações. Para mais informações, acesse a nossa ',
            'terms' => 'Política de Privacidade',
            'conditions' => 'Condições',
            'using' => 'usando este site',
            'agreement' => 'Acordo',
            'success' => 'Sua conta foi criada com sucesso, um e-mail de verificação foi enviado para sua caixa de e-mail.',
            'success-verify-email-not-sent' => 'Conta criada com sucesso, mas o e-mail de verificação não foi enviado.',
            'failed' => 'Erro! Não  possível criar sua conta, tente novamente mais tarde.',
            'already-verified' => 'Sua conta já foi confirmada.',
            'verification-not-sent' => 'Erro! Problema ao enviar e-mail de verificação, tente novamente mais tarde.',
            'verification-sent' => 'E-mail de verificação enviado.',
            'verified' => 'Sua conta foi verificada, tente entrar agora.',
            'verify-failed' => 'Não podemos verificar sua conta de e-mail.',
            'dont-have-account' => 'Você não tem conta conosco.',
        ],

        'login-text' => [
            'no_account' => 'Não possui conta?',
            'title' => 'Cadastre-se agora.',
        ],

        'login-form' => [
            'page-title' => 'Cliente - Login',
            'title' => 'Entrar',
            'email' => 'Email',
            'password' => 'Senha',
            'forgot_pass' => 'Esqueceu sua Senha?',
            'button_title' => 'Entrar',
            'remember' => 'Lembrar de mim',
            'footer' => '© Copyright :year Webkul Software, Todos os direitos reservados',
            'invalid-creds' => 'Por favor, verifique seus dados e tente novamente.',
            'verify-first' => 'Verifique seu e-mail primeiro.',
            'resend-verification' => 'Reenviar email de verificação.'
        ],

        'forgot-password' => [
            'title' => 'Recuperar Senha',
            'email' => 'Email',
            'submit' => 'Enviar',
            'page_title' => 'Esqueci minha Senha'
        ],

        'reset-password' => [
            'title' => 'Redefinir Senha',
            'email' => 'Email registrado',
            'password' => 'Senha',
            'confirm-password' => 'Confirmar Senha',
            'back-link-title' => 'Voltar para Login',
            'submit-btn-title' => 'Redefinir Senha'
        ],

        'account' => [
            'dashboard' => 'Cliente - Perfil',
            'menu' => 'Menu',

            'profile' => [
                'index' => [
                    'page-title' => 'Cliente - Perfil',
                    'title' => 'Perfil',
                    'edit' => 'Editar',
                ],

                'edit' => [
                    'page-title' => 'Cliente - Editar Perfil'
                ],

                'edit-success' => 'Perfil atualizado com sucesso.',
                'edit-fail' => 'Erro! O perfil não pode ser atualizado, por favor, tente novamente mais tarde.',
                'unmatch' => 'A senha antiga não corresponde.',
                'fname' => 'Nome',
                'lname' => 'Sobrenome',
                'gender' => 'Gênero',
                'dob' => 'Data de Nascimento',
                'phone' => 'Celular',
                'email' => 'Email',
                'opassword' => 'Senha antiga',
                'password' => 'Senha',
                'cpassword' => 'Confirmar Senha',
                'submit' => 'Atualizar Perfil',

                'edit-profile' => [
                    'title' => 'Editar Perfil',
                    'page-title' => 'Cliente - Editar Perfil'
                ]
            ],

            'address' => [
                'index' => [
                    'page-title' => 'Cliente - Endereço',
                    'title' => 'Endereço',
                    'add' => 'Adicionar Endereço',
                    'edit' => 'Editar',
                    'empty' => 'Você não tem nenhum endereço salvo aqui, por favor tente criá-lo clicando no link abaixo',
                    'create' => 'Criar Endereço',
                    'delete' => 'Deletar',
                    'make-default' => 'Definir como Padrão',
                    'default' => 'Padrão',
                    'contact' => 'Contato',
                    'taxvat' => 'CPF',
                    'confirm-delete' =>  'Você realmente deseja excluir este endereço?',
                    'default-delete' => 'O endereço padrão não pode ser alterado.',
                    'enter-password' => 'Enter Your Password.',
                ],

                'create' => [
                    'page-title' => 'Cliente - Adicionar Endereço',
                    'title' => 'Novo Endereço',
                    'address1' => 'Endereço',
                    'street-address' => 'Endereço',
                    'number' => 'Número',
                    'complement' => 'Complemento',
                    'neighborhood' => 'Bairro',
                    'state' => 'Estado (sigla)',
                    'select-state' => 'Selecione Estado',
                    'city' => 'Cidade',
                    'postcode' => 'CEP',
                    'country' => 'País',
                    'phone' => 'Celular',
                    'taxvat' => 'CPF',
                    'submit' => 'Salvar Endereço',
                    'success' => 'Endereço foi adicionado com sucesso.',
                    'error' => 'Endereço não pode ser adicionado.'
                ],

                'edit' => [
                    'page-title' => 'Cliente - Editar Endereço',
                    'title' => 'Editar Endereço',
                    'submit' => 'Salvar Endereço',
                    'success' => 'Endereço atualizado com sucesso.'
                ],
                'delete' => [
                    'success' => 'Endereço excluído com sucesso.',
                    'failure' => 'Endereço não pode ser adicionado.',
                    'wrong-password' => 'Senha Inválida!'
                ]
            ],

            'order' => [
                'index' => [
                    'page-title' => 'Cliente - Pedidos',
                    'title' => 'Pedidos',
                    'order_id' => 'Pedido ID',
                    'date' => 'Data',
                    'status' => 'Status',
                    'total' => 'Total'
                ],

                'view' => [
                    'page-tile' => 'Pedido #:order_id',
                    'view_order' => 'Visualizar Pedido',
                    'info' => 'Informação',
                    'placed-on' => 'Criado em',
                    'products-ordered' => 'Produtos Pedidos',
                    'invoices' => 'Faturas',
                    'shipments' => 'Entregas',
                    'SKU' => 'SKU',
                    'product-name' => 'Nome',
                    'qty' => 'Qtd',
                    'item-status' => 'Item Status',
                    'item-ordered' => 'Pedidos (:qty_ordered)',
                    'item-invoice' => 'Faturados (:qty_invoiced)',
                    'item-shipped' => 'Enviados (:qty_shipped)',
                    'item-canceled' => 'Cancelados (:qty_canceled)',
                    'item-refunded' => 'Refunded (:qty_refunded)',
                    'price' => 'Preço',
                    'total' => 'Total',
                    'subtotal' => 'Subtotal',
                    'shipping-handling' => 'Entrega & Manuseio',
                    'tax' => 'Taxas Aduaneiras',
                    'discount' => 'Desconto',
                    'tax-percent' => '% de Imposto',
                    'tax-amount' => 'Valor de Imposto',
                    'discount-amount' => 'Valor de Desconto',
                    'grand-total' => 'Total',
                    'total-paid' => 'Total Pago',
                    'total-refunded' => 'Total Estornado',
                    'total-due' => 'Total Devido',
                    'shipping-address' => 'Endereço de Entrega',
                    'billing-address' => 'Endereço de Cobrança',
                    'shipping-method' => 'Método de Entrega',
                    'payment-method' => 'Método de Pagamento',
                    'individual-invoice' => 'Fatura #:invoice_id',
                    'individual-shipment' => 'Entrega #:shipment_id',
                    'print' => 'Imprimir',
                    'invoice-id' => 'Fatura Id',
                    'order-id' => 'Pedido Id',
                    'order-date' => 'Data do Pedido',
                    'bill-to' => 'Cobrança de',
                    'ship-to' => 'Enviar para',
                    'contact' => 'Contato',
                    'refunds' => 'Cancelamentos',
                    'individual-refund' => 'Cancelamento #:refund_id',
                    'adjustment-refund' => 'Ajuste de Cancelamento',
                    'adjustment-fee' => 'Taxa de Ajuste',
                ]
            ],

            'wishlist' => [
                'page-title' => 'Cliente - Lista de Desejos',
                'title' => 'Lista de Desejos',
                'deleteall' => 'Excluir Tudo',
                'moveall' => 'Adicionar todos ao Carrinho',
                'move-to-cart' => 'Adicionar ao Carrinho',
                'error' => 'Não é possível adicionar o produto à lista de Desejos devido a problemas desconhecidos. Por favor tente mais tarde',
                'add' => 'Item adicionado com sucesso a Lista de Desejos',
                'remove' => 'Item removido com sucesso da Lista de Desejos',
                'moved' => 'Item movido com sucesso para Lista de Desejos',
                'move-error' => 'Item não pode ser movido para Lista de Desejos, por favor, tente novamente mais tarde',
                'success' => 'Item adicionado com sucesso a Lista de Desejos',
                'failure' => 'Item não pode ser adicionado à Lista de Desejos, por favor, tente novamente mais tarde',
                'already' => 'Item já presente em sua lista de desejos',
                'removed' => 'Item removido com sucesso da Lista de Desejos',
                'remove-fail' => 'Item não pode ser removido da lista de desejos, por favor, tente novamente mais tarde',
                'empty' => 'Você não tem nenhum item em sua Lista de Desejos',
                'remove-all-success' => 'Todos os itens da sua lista de desejos foram removidos',
            ],

            'downloadable_products' => [
                'title' => 'Produtos para Download',
                'order-id' => 'ID do Pedido',
                'date' => 'Data',
                'name' => 'Título',
                'status' => 'Status',
                'pending' => 'Pendente',
                'available' => 'Disponível',
                'expired' => 'Expirado',
                'remaining-downloads' => 'Downloads Restantes',
                'unlimited' => 'Ilimitado',
                'download-error' => 'O link para download expirou.'
            ],

            'review' => [
                'index' => [
                    'title' => 'Avaliação',
                    'page-title' => 'Cliente - Avaliação'
                ],

                'view' => [
                    'page-tile' => 'Avaliação #:id',
                ]
            ]
        ]
    ],

    'products' => [
        'layered-nav-title' => 'Filtros',
        'price-label' => 'À partir de ',
        'remove-filter-link-title' => 'Limpar Todos',
        'sort-by' => 'Ordernar por',
        'from-a-z' => 'De A-Z',
        'from-z-a' => 'De Z-A',
        'newest-first' => 'Mais Recentes',
        'oldest-first' => 'Mais Antigos',
        'cheapest-first' => 'Menor Preço',
        'expensive-first' => 'Maior Preço',
        'show' => 'Visualiar',
        'pager-info' => 'Mostrando :showing de um :total de Itens',
        'description' => 'Descrição',
        'details' => 'Detalhes',
        'video' => 'Vídeo',
        'nutritional-table' => 'Tabela Nutricional',
        'common-questions' => 'Perguntas Frequentes',
        'download-info' => 'Download Informações do Produto',
        'icons' => 'Entenda os Ícones',
        'capsule_size' => 'Tamanho da Cápsula',
        'size' => 'Tamanho',
        'capsule' => 'Cápsula',
        'specification' => 'Especificação',
        'total-reviews' => ':total Avaliação',
        'total-rating' => ':total_rating Notas & :total_reviews Avaliações',
        'by' => 'Por :name',
        'up-sell-title' => 'Encontramos outros produtos que você possa gostar!',
        'related-product-title' => 'Produtos Relacionados',
        'cross-sell-title' => 'Mais escolhas',
        'reviews-title' => 'Classificações & Avaliação',
        'write-review-btn' => 'Escreva uma Avaliação',
        'choose-option' => 'Escolha uma opção',
        'sale' => 'Promoção',
        'new' => 'Novo',
        'empty' => 'Nenhum produto disponível nesta categoria.',
        'add-to-cart' => 'Adicionar ao Carrinho',
        'buy-now' => 'Comprar Agora',
        'whoops' => 'Oppss!',
        'quantity' => 'Quantidade',
        'in-stock' => 'Em Estoque',
        'out-of-stock' => 'Fora de Estoque',
        'view-all' => 'Ver Tudo',
        'select-above-options' => 'Por favor, selecione as opções acima primeiro.',
        'less-quantity' => 'Quantidade não pode ser inferior a um.',
        'starting-at' => 'Começando às',
        'customize-options' => 'Personalizar Opções',
        'choose-selection' => 'Escolha uma Seleção',
        'your-customization' => 'Sua Personalização',
        'total-amount' => 'Valor Total',
        'available' => 'Produto indisponível',
        'launch' => 'Breve lançamento!',
        'none' => 'Nenhum'
    ],

    // 'reviews' => [
    //     'empty' => 'Você ainda não avaliou qualquer produto'
    // ]

    'buynow' => [
        'no-options' => 'Por favor, selecione as opções antes de comprar este produto.'
    ],


    'checkout' => [
        'cart' => [
            'integrity' => [
                'missing_fields' =>'Você precisa preencher/selecionar os campos obrigatórios antes de adicionar este produto ao carrinho.',
                'missing_options' =>'Você precisa selecionar uma opção antes de adicionar este produto ao carrinho.',
                'missing_links' => 'Faltam links para download para este produto.',
                'qty_missing' => 'Você deve incluir pelo menos uma unidade no carrinho.'
            ],

            'create-error' => 'Encontrou algum problema ao criar o carrinho.',
            'title' => 'Carrinho de Compras',
            'empty' => 'Seu carrinho de compras está vazio.',
            'empty-msg' => 'Adicione produtos ao seu carrinho clicando no botão "Comprar" na página de produtos.',
            'update-cart' => 'Atualizar',
            'continue-shopping' => 'Continuar Comprando',
            'proceed-to-checkout' => 'Finalizar Compra',
            'clean-cart' => 'Limpar',
            'remove' => 'Remover',
            'remove-link' => 'Remover',
            'move-to-wishlist' => 'Mover para Lista de Desejos',
            'move-to-wishlist-success' => 'Item Movido para Lista de Desejos',
            'move-to-wishlist-error' => 'Não foi possivel mover item para lista de desejos, por favor, tente novamente mais tarde.',
            'add-config-warning' => 'Por favor, selecione a opção antes de adicionar ao carrinho.',
            'quantity' => [
                'quantity' => 'Quantidade',
                'success' => 'Item(s) no carrinho atualizados com sucesso!',
                'illegal' => 'Quantidade não pode ser menor que um.',
                'inventory_warning' => 'A quantidade solicitada não está disponível, por favor, tente novamente mais tarde.',
                'error' => 'Não é possível atualizar o item(s) no momento, por favor, tente novamente mais tarde.'
            ],

            'item' => [
                'error_remove' => 'Nenhum item para remover do carrinho.',
                'success' => 'Item foi adicionado com sucesso ao carrinho.',
                'success-remove' => 'Item foi removido com sucesso do carrinho.',
                'error-add' => 'Item não pode ser adicionado ao carrinho, por favor, tente novamente mais tarde.',
            ],

            'quantity-error' => 'Quantidade solicitada não está disponível.',
            'cart-subtotal' => 'Subtotal do carrinho',
            'cart-remove-action' => 'Você realmente quer fazer isso?',
            'partial-cart-update' => 'Apenas alguns produtos foram atualizados.'
        ],

        'onepage' => [
            'title' => 'Finalização Compra',
            'information' => 'Informação',
            'shipping' => 'Entrega',
            'payment' => 'Pagamento',
            'complete' => 'Completo',
            'billing-address' => 'Endereço de Cobrança',
            'sign-in' => 'Entrar',
            'first-name' => 'Nome (Paciente)',
            'last-name' => 'Sobrenome (Paciente)',
            'email' => 'E-mail',
            'address1' => 'Endereço',
            'address2' => 'Endereço 2',
            'number' => 'Número',
            'complement' => 'Complemento',
            'neighborhood' => 'Bairro',
            'city' => 'Cidade',
            'state' => 'Estado (sigla)',
            'select-state' => 'Selecione uma região, estado e cidade',
            'postcode' => 'CEP',
            'phone' => 'Celular',
            'taxvat' => 'CPF (Paciente)',
            'country' => 'País',
            'apply-coupon' => 'Aplicar',
            'order-summary' => 'Resumo do Pedido',
            'shipping-address' => 'Endereço de Entrega',
            'use_for_shipping' => 'Entregar neste endereço',
            'continue' => 'Continuar',
            'shipping-method' => 'Selecione o Método de Entrega',
            'payment-methods' => 'Selecione o Método de Pagamento',
            'payment-method' => 'Método de Pagamento',
            'summary' => 'Resumo do Pedido',
            'price' => 'Preço',
            'quantity' => 'Quantidade',
            'contact' => 'Contato',
            'place-order' => 'Enviar Pedido',
            'new-address' => 'Adicionar Novo Endereço',
            'save_as_address' => 'Salvar Endereço',
            'back' => 'Voltar'
        ],

        'total' => [
            'order-summary' => 'Resumo do Pedido',
            'sub-total' => 'Itens',
            'grand-total' => 'Total',
            'delivery-charges' => 'Frete',
            'tax' => 'Taxas Aduaneiras',
            'discount' => 'Desconto',
            'price' => 'Preço',
            'disc-amount' => 'Desconto',
            'new-grand-total' => 'New Grand Total',
            'coupon' => 'Cupom',
            'coupon-applied' => 'Cupom aplicado',
            'remove-coupon' => 'Remover cupom',
            'cannot-apply-coupon' => 'Cupom inválido'
        ],

        'success' => [
            'title' => 'Pedido efetuado com sucesso!',
            'thanks' => 'Obrigado pelo seu pedido!',
            'order-id-info' => 'O ID do seu pedido é #:order_id',
            'info' => 'Você receberá um e-mail com detalhes do seu pedido e informações de rastreamento.',
            'details' => 'Detalhes',
            'prescription' => 'Prescrição',
            'payment' => 'Pagamento',
            'payment-info' => 'Você selecionou boleto como forma de pagamento, portanto, lembre-se que seu pedido só será despachado após o pagamento do mesmo. Para efetuar o pagamento, copie o código de barras abaixo ou clique no botão para imprimir.',
            'code-bar' => 'Código de Barras',
            'printing' => 'Imprimir Boleto'
        ],

        'failure' => [
            'title' => 'Não foi possível concluir seu pedido!',
            'message' => 'Infelizmente não foi possível processar seu pagamento. Verifique o erro abaixo.',
            'error-code-info' => 'O código do erro é #:error.',
            'error-info' => 'Por favor, retorne e confira os dados do seu cadastro e/ou pedido.',
            'info' => 'Para maiores informações entre em contato através do e-mail :support_email.'
        ],

        'prescription' => [
            'success' => [
                'title-breadcrumb' => 'Prescrição recebida!',
                'title' => 'Prescrição recebida com sucesso!',
                'message' => 'Sua prescrição foi recebida com sucesso, portanto nós já podemos dar continuidade ao seu pedido. Em breve você receberá mais informações no e-mail cadastrado.',
                'info' => 'Caso tenha alguma dúvida, entre em contato através do e-mail :support_email. '

            ],

            'failure' => [
                'title' => 'Erro ao enviar prescrição!',
                'message' => 'Infelizmente não foi possível receber sua prescrição. Verifique as possíveis formas de nos enviá-la abaixo.',
                'info' => 'Para maiores informações entre em contato através do e-mail :support_email. '
            ],
        ],
    ],

    'mail' => [
        'order' => [
            'subject' => 'Confirmação de Novo Pedido',
            'heading' => 'Confirmação de Pedido',
            'dear' => 'Caro(a) :customer_name',
            'greeting' => 'Obrigado pelo seu pedido :order_id realizado em :created_at.',
            'greeting-admin' => 'O pedido :order_id foi realizado em :created_at.',
            'prescription' => 'Para finalizar sua compra é necessário o envio da prescrição para o WhatsApp (11) 99868-0834 ou e-mail :prescription_email. Seu pedido só será despachado após a confirmação do pagamento.',
            'summary' => 'Resumo do Pedido',
            'shipping-address' => 'Endereço de Entrega',
            'billing-address' => 'Endereço de Cobrança',
            'contact' => 'Contato',
            'shipping' => 'Método de Entrega',
            'payment' => 'Método de Pagamento',
            'price' => 'Preço',
            'quantity' => 'Quantidade',
            'subtotal' => 'Subtotal',
            'shipping-handling' => 'Envio & Manuseio',
            'tax' => 'Taxas Aduaneiras',
            'discount' => 'Desconto',
            'grand-total' => 'Total',
            'final-summary' => 'Obrigado por mostrar o seu interesse em nossa loja. Enviaremos o número de rastreamento assim que for despachado.',
            'help' => 'Se você precisar de algum tipo de ajuda, por favor entre em contato conosco :support_email.',
            'thanks' => 'Muito obrigado(a)!'
        ],

        'cancel' => [
            'heading' => 'Cancelamento do seu pedido :order_id',
            'subject' => 'Cancelamento do Pedido',
            'greeting' => 'O seu pedido :order_id realizado em :created_at foi cancelado.',
            'help' => 'Infelizmente seu pedido foi cancelado, para maiores informações entre em contato conosco :support_email.',
            'thanks' => 'Agradecemos sua compreensão!',
        ],

        'invoice' => [
            'heading' => 'Sua fatura #:invoice_id para o pedido #:order_id',
            'subject' => 'Fatura do seu pedido #:order_id',
            'greeting' => 'O seu pagamento foi aprovado e seu pedido :order_id foi faturado.',
            'summary' => 'Resumo da Fatura',
        ],

        'refund' => [
            'heading' => 'O seu Cancelamento #:refund_id para o pedido #:order_id',
            'subject' => 'Cancelamento do seu pedido #:order_id',
            'greeting' => 'O seu pedido :order_id foi Cancelado com sucesso.',
            'summary' => 'Resumo do Cancelamento',
            'adjustment-refund' => 'Ajuste de Cancelamento',
            'adjustment-fee' => 'Taxa de Ajuste'
        ],

        'shipment' => [
            'heading' => 'A entrega do seu pedido #:order_id foi liberada!',
            'subject' => 'Entrega do seu pedido #:order_id',
            'greeting' => 'Sua compra embarcou para o Brasil com sucesso! Em breve, você receberá novas informações sobre a sua entrega, pedimos que aguarde!',
            'summary' => 'Resumo da Entrega',
            'carrier' => 'Transportadora',
            'tracking-number' => 'Código de Rastreio'
        ],

        'forget-password' => [
            'subject' => 'Redefinição de Senha',
            'dear' => 'Caro(a) :name',
            'info' => 'Você está recebendo este e-mail pois recebemos uma solicitação de redefinição de senha para sua conta.',
            'reset-password' => 'Redefinir Senha',
            'final-summary' => 'Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.',
            'thanks' => 'Muito obrigado(a)!'
        ],

        'confirmation-prescription' => [
            'subject' => 'Confirmação de Recebimento de Prescrição',
            'dear' => 'Prazado(a)',
            'info' => 'A prescrição médica para o pedido :order_id foi recebida com sucesso.',
            'thanks' => 'Muito obrigado(a)!'
        ],

        'customer' => [
            'new' => [
                'dear' => 'Caro(a) :customer_name',
                'username-email' => 'Usuário/E-mail',
                'subject' => 'Novo Cliente Cadastrado',
                'password' => 'Senha',
                'summary' => 'Sua conta foi criada. Os detalhes da sua conta estão abaixo: ',
                'thanks' => 'Muito obrigado(a)!'
            ],

            'registration' => [
                'subject' => 'Novo Cliente Cadastrado',
                'customer-registration' => 'Cliente Cadastrado com Sucesso',
                'dear' => 'Caro(a) :customer_name',
                'greeting' => 'Bem-vindo e obrigado por se registrar conosco!',
                'summary' => 'Sua conta foi criada com sucesso e você pode fazer login usando seu endereço de e-mail e credenciais de senha. Ao fazer o login, você poderá acessar outros serviços, incluindo a revisão de pedidos anteriores, listas de desejos e a edição das informações da sua conta.',
                'thanks' => 'Muito obrigado(a)!',
            ],

            'verification' => [
                'heading' => config('app.name') . ' - Verificação de E-mail',
                'subject' => 'Verificação de E-mail',
                'verify' => 'Confirmar Minha Conta',
                'summary' => 'Estamos enviando esta mensagem para verificar se o endereço de e-mail digitado é seu. Por favor, clique no botão abaixo para confirmar sua conta.'
            ],

            'subscription' => [
                'subject' => 'Assinatura de E-mail',
                'greeting' => ' Bem-vindo a ' . config('app.name') . ' - Assinatura de E-mail',
                'unsubscribe' => 'Cancelar Assinatura',
                'summary' => 'Obrigado(a) por se registrar em nossa newsletter. Já faz um tempo desde que você leu os e-mails de ' . config('app.name') . ', e não queremos sobrecarregar sua caixa de entrada. Se você não deseja mais receber nossas novidades, clique no botão abaixo.'
            ]
        ]
    ],

    'webkul' => [
        'copy-right' => '© Copyright :year Webkul Software, Todos os Direitos Reservados',
    ],

    'response' => [
        'create-success' => ':name criado com sucesso.',
        'update-success' => ':name atualizado com sucesso.',
        'delete-success' => ':name excluído com sucesso.',
        'submit-success' => ':name enviado com sucesso.'
    ],
];
