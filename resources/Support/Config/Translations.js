import vuetifyEN from 'vuetify/es5/locale/en'
import textEN from '../../../lang/frontend/en/text.json'
import wordEN from '../../../lang/frontend/en/word.json'
import vuetifyNL from 'vuetify/es5/locale/nl'
import textNL from '../../../lang/frontend/nl/text.json'
import wordNL from '../../../lang/frontend/nl/word.json'

export default {
	en: {
		...vuetifyEN,
		...textEN,
		...wordEN
	},
	nl: {
		...vuetifyNL,
		...textNL,
		...wordNL
	},
}
