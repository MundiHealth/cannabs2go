window.jQuery = window.$ = $ = require("./vendors/jquery-1.12.4.min");
window.Vue = require("vue/dist/vue.min");
window.VeeValidate = require("vee-validate");
window.axios = require("axios");
window.slick = Slick = require("vue-slick");
window.BeerSlider = require("beerslider");
locales = require("./lang/locales.js");

require("./vendors/bootstrap.min");
require('./vendors/slick.min');
require("./vendors/popper.min");
require("./vendors/isotope.pkgd.min");
require("./main");

Vue.component("flash-wrapper", require("./components/flash-wrapper"));
Vue.component("flash", require("./components/flash"));

require("./bootstrap");
require("jquery-zoom/jquery.zoom.js");
require("jquery-mask-plugin");

const CPF = require('cpf-check');
window.CPF = CPF;

const WOW = require('wowjs');
window.wow = new WOW.WOW({
    live: false
});

Vue.use(VeeValidate, {
    dictionary: {
        ar: { messages: locales.messages.ar }
    }
});

Vue.prototype.$http = axios

window.eventBus = new Vue();

Vue.component("image-slider", require("./components/image-slider.vue"));
Vue.component("vue-slider", require("vue-slider-component"));

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
                    "alpha": (field) => "O campo " + field + " deve conter somente letras.",
                    "alpha_dash": (field) => "O campo " + field + " deve conter letras, números e traços.",
                    "alpha_num": (field) => "O campo " + field + " deve conter somente letras e números.",
                    "alpha_spaces": (field) => "O campo " + field + " só pode conter caracteres alfabéticos e espaços.",
                    "between": (field) => "O campo " + field + " deve estar entre {min} e {max}.",
                    "confirmed": (field) => "A confirmação do campo " + field + " deve ser igual.",
                    "digits": (field) => "O campo " + field + " deve ser numérico e ter exatamente {length} dígitos.",
                    "dimensions": (field) => "O campo " + field + " deve ter {width} pixels de largura por {height} pixels de altura.",
                    "email": (field) => "O campo " + field + " deve ser um email válido.",
                    "excluded": (field) => "O campo " + field + " deve ser um valor válido.",
                    "ext": (field) => "O campo " + field + " deve ser um arquivo válido.",
                    "image": (field) => "O campo " + field + " deve ser uma imagem.",
                    "integer": (field) => "O campo " + field + " deve ser um número inteiro.",
                    "is": (field) => "O valor inserido no campo " + field + " não é válido.",
                    "oneOf": (field) => "O campo " + field + " deve ter um valor válido.",
                    "length": (field) => "O tamanho do campo " + field + " deve ser {length}.",
                    "max": (field) => "O campo " + field + " não deve ter mais que {length} caracteres.",
                    "max_value": (field) => "O campo " + field + " precisa ser {max} ou menor.",
                    "mimes": (field) => "O campo " + field + " deve ser um tipo de arquivo válido.",
                    "min": (field) => "O campo " + field + " deve conter pelo menos {length} caracteres.",
                    "min_value": (field) => "O campo " + field + " precisa ser {min} ou maior.",
                    "numeric": (field) => "O campo " + field + " deve conter apenas números.",
                    "regex": (field) => "O campo " + field + " possui um formato inválido.",
                    "required": (field) => "O campo " + field + " é obrigatório.",
                    "required_if": (field) => "O campo " + field + " é obrigatório.",
                    "size": (field) => "O campo " + field + " deve ser menor que {size}KB."
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

    $('.cep').mask('99999-999');
    $('.cpf').mask('999.999.999-99').focusout(function(event){
        if (!CPF.validate(event.currentTarget.value)){
            $(this).val('').attr('placeholder', 'CPF Inválido.')
        }
    });
    $('.telefone').mask("(99) 99999-9999");
    // $('.telefone')
    //     .mask("(99) 99999-9999?9")
    //     .focusout(function (event) {
    //         var target, phone, element;
    //         target = (event.currentTarget) ? event.currentTarget : event.srcElement;
    //         phone = target.value.replace(/\D/g, '');
    //         element = $(target);
    //         element.unmask();
    //         if(phone.length > 10) {
    //             element.mask("(99) 99999-9999?9");
    //         } else {
    //             element.mask("(99) 9999-9999?9");
    //         }
    //     });

    // var options = {
    //     width: 400,
    //     zoomWidth: 500,
    //     offset: {vertical: 0, horizontal: 10},
    // };
    // new ImageZoom(document.getElementById("img-container"), options);
});