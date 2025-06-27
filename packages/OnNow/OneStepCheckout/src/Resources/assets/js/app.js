window.jQuery = window.$ = $ = require("jquery");
window.Vue = require("vue/dist/vue.min");
window.VeeValidate = require("vee-validate");
window.axios = require("axios");
locales = require("./lang/locales.js");
window.swal = require('sweetalert2')
window.valid = require('card-validator');
window.VueScrollTo = require('vue-scrollto');
window.VueTheMask = require('vue-the-mask');

Vue.component("flash-wrapper", require("./components/flash-wrapper"));
Vue.component("flash", require("./components/flash"));

require("./vendors/bootstrap.min");
require("./bootstrap");
require("ez-plus/src/jquery.ez-plus.js");
require("jquery-mask-plugin");

Vue.use(VeeValidate, {
    dictionary: {
        ar: { messages: locales.messages.ar }
    }
});

Vue.use(VueScrollTo);
Vue.use(VueTheMask);

Vue.prototype.$http = axios

const CPF = require('cpf-check');
window.CPF = CPF;

window.eventBus = new Vue();

$(document).ready(function () {
    const app = new Vue({
        el: "#app",

        data: {
            modalIds: {}
        },

        mounted: function () {
            this.addServerErrors();
            this.addFlashMessages();
            this.$validator.localize('en', {
                messages: {
                    required: (field) => 'O campo ' + field + ' é obrigatório',
                    "alpha": (field) => "O campo " + field + " deve conter somente letras",
                    "alpha_dash": (field) => "O campo " + field + " deve conter letras, números e traços",
                    "alpha_num": (field) => "O campo " + field + " deve conter somente letras e números",
                    "alpha_spaces": (field) => "O campo " + field + " só pode conter caracteres alfabéticos e espaços",
                    "between": (field) => "O campo " + field + " deve estar entre {min} e {max}",
                    "confirmed": (field) => "A confirmação do campo " + field + " deve ser igual",
                    "digits": (field) => "O campo " + field + " deve ser numérico e ter exatamente {length} dígitos",
                    "dimensions": (field) => "O campo " + field + " deve ter {width} pixels de largura por {height} pixels de altura",
                    "email": (field) => "O campo " + field + " deve ser um email válido",
                    "excluded": (field) => "O campo " + field + " deve ser um valor válido",
                    "ext": (field) => "O campo " + field + " deve ser um arquivo válido",
                    "image": (field) => "O campo " + field + " deve ser uma imagem",
                    "integer": (field) => "O campo " + field + " deve ser um número inteiro",
                    "is": (field) => "O valor inserido no campo " + field + " não é válido",
                    "oneOf": (field) => "O campo " + field + " deve ter um valor válido",
                    "length": (field) => "O tamanho do campo " + field + " deve ser {length}",
                    "max": (field) => "O campo " + field + " não deve ter mais que {length} caracteres",
                    "max_value": (field) => "O campo " + field + " precisa ser {max} ou menor",
                    "mimes": (field) => "O campo " + field + " deve ser um tipo de arquivo válido",
                    "min": (field) => "O campo " + field + " deve conter pelo menos {length} caracteres",
                    "min_value": (field) => "O campo " + field + " precisa ser {min} ou maior",
                    "numeric": (field) => "O campo " + field + " deve conter apenas números",
                    "regex": (field) => "O campo " + field + " possui um formato inválido",
                    "required": (field) => "O campo " + field + " é obrigatório",
                    "required_if": (field) => "O campo " + field + " é obrigatório",
                    "size": (field) => "O campo " + field + " deve ser menor que {size}KB"
                },
            });
            // this.$validator.localize(document.documentElement.lang);
        },

        methods: {
            onSubmit: function (e) {
                this.toggleButtonDisable(true);

                if(typeof tinyMCE !== 'undefined')
                    tinyMCE.triggerSave();

                this.$validator.validateAll().then(result => {
                    if (result) {
                        e.target.submit();
                    } else {
                        this.toggleButtonDisable(false);
                    }
                });
            },

            toggleButtonDisable (value) {
                var buttons = document.getElementsByTagName("button");

                for (var i = 0; i < buttons.length; i++) {
                    buttons[i].disabled = value;
                }
            },

            addServerErrors: function (scope = null) {
                for (var key in serverErrors) {
                    var inputNames = [];
                    key.split('.').forEach(function(chunk, index) {
                        if(index) {
                            inputNames.push('[' + chunk + ']')
                        } else {
                            inputNames.push(chunk)
                        }
                    })

                    var inputName = inputNames.join('');

                    const field = this.$validator.fields.find({
                        name: inputName,
                        scope: scope
                    });
                    if (field) {
                        this.$validator.errors.add({
                            id: field.id,
                            field: inputName,
                            msg: serverErrors[key][0],
                            scope: scope
                        });
                    }
                }
            },

            addFlashMessages: function () {
                const flashes = this.$refs.flashes;

                flashMessages.forEach(function (flash) {
                    flashes.addFlash(flash);
                }, this);
            },

            responsiveHeader: function () { },

            showModal(id) {
                this.$set(this.modalIds, id, true);
            }
        }
    });

    $('input[id="billing[postcode]"], input[id="shipping[postcode]"], .cep').mask('99999-999');

    $(".se-pre-con").fadeOut("slow");

    // main menu
    $('.toggle-nav').on('click', function(event) {
        $('body').stop(true,true).addClass('open-nav');
        $('.overlay').stop(true,true).addClass('active');
        event.stopPropagation();
    });

    $('.open-nav .main-menu::before').on('click', function(event) {
        $('body').stop(true,true).removeClass('open-nav');
        $('.overlay').stop(true,true).removeClass('active');
        event.stopPropagation();
    });

    $('.main-menu nav .fa-chevron-down').on('click', function(event) {
        $(this).next().stop(true,true).slideToggle('slow');
        event.stopPropagation();
    });

    $('.search-icon').on('click', function(event) {
        $('.search-open').stop(true,true).slideToggle('slow');
        event.stopPropagation();
    });

    $('.search-open .fa-times').on('click', function(event) {
        $('.search-open').stop(true,true).slideUp('slow');
        event.stopPropagation();
    });

    $('html').on('click', function(){
        $('body').removeClass('open-nav');
        $('.overlay').stop(true,true).removeClass('active');
        $('.main-menu nav .fa-chevron-down').next().slideUp();
    });

// sticky
    var wind = $(window);
    var sticky = $('#sticky-header');
    wind.on('scroll', function () {
        var scroll = wind.scrollTop();
        if (scroll < 100) {
            sticky.removeClass('sticky');
        } else {
            sticky.addClass('sticky');
        }
    });

    // browser window scroll (in pixels) after which the "back to top" link is shown
    var offset = 300,
        //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
        offset_opacity = 1200,
        //duration of the top scrolling animation (in ms)
        scroll_top_duration = 700,
        //grab the "back to top" link
        $back_to_top = $('.back-top');

    //hide or show the "back to top" link
    $(window).scroll(function(){
        ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('is-visible') : $back_to_top.removeClass('is-visible fade-out');
        if( $(this).scrollTop() > offset_opacity ) {
            $back_to_top.addClass('fade-out');
        }
    });

    //smooth scroll to top
    $back_to_top.on('click', function(event){
        event.preventDefault();
        $('body,html').animate({
                scrollTop: 0 ,
            }, scroll_top_duration
        );
    });
});