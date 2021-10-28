export default {
    en: {
        ...require('vuetify/es5/locale/en'),
        ...require('./en/text.json'),
        ...require('./en/word.json'),
        ...require('./en/text.json'),
    },
    nl: {
        ...require('vuetify/es5/locale/nl'),
        ...require('./nl/text.json'),
        ...require('./nl/word.json'),
    },
}