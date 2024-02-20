import { createI18n } from 'vue-i18n'
import en from './locales/en.json'
import fr from './locales/fr.json'
import ar from './locales/ar.json'
import es from './locales/es.json'
import fa from './locales/fa.json'

const messages = {
    en,
    fr,
    ar,
    es,
    fa
}


const locale = localStorage.getItem("locale");
const i18n = createI18n({
    locale: locale || "en",
    fallbackLocale: "en",
    messages: messages
});

export default i18n;