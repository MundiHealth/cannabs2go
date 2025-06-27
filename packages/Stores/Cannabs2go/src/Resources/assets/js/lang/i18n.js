import Vue from "vue";
import VueI18n from "vue-i18n";
import ar from "vee-validate/dist/locale/ar.json";
import en from "vee-validate/dist/locale/en.json";
import pt_BR from "vee-validate/dist/locale/pt_BR.json";

Vue.use(VueI18n);

const i18n = new VueI18n({
    locale: "pt_BR",
    messages: {
        ar: {
            fields: {
                email: "البريد الاليكتروني",
                password: "كلمة السر"
            },
            validation: ar.messages
        },
        en: {
            fields: {
                email: "E-mail",
                password: "Password"
            },
            validation: en.messages
        },
        pt_BR: {
            validation: pt_BR.messages
        }
    }
});

export { i18n };