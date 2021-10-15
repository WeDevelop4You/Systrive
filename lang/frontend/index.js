export default {
    en: {
        ...require('vuetify/es5/locale/en'),
        ...require('./en/word.json'),
        ...require('./en/text.json'),
    },

    nl: {
        ...require('vuetify/es5/locale/nl'),
        ...require('./nl/word.json'),
        ...require('./nl/text.json'),
    }
}
