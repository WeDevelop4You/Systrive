import {format, parse, isValid as _isValid} from "date-fns";
import FormComponentBase from "../FormComponentBase";

export default {
    extends: FormComponentBase,

    data() {
        return {
            modal: false,

            date: '',
            time: '',

            format: '',
            timeFormat: '',
            dateFormat: '',

            parseFormat: '',
            parseTimeFormat: 'HH:mm:ss',
            parseDateFormat: 'yyyy-MM-dd',
        }
    },

    computed: {
        formatter() {
            return this.getValue
                ? format(this.parse(this.getValue), this.format)
                : null
        },

        isValid() {
            return _isValid(this.parse(this.get()))
        }
    },

    created() {
        this.dateFormat = this.component.data.dateFormat
        this.timeFormat = this.component.data.timeFormat

        switch (this.type) {
            case 'time':
                this.format = this.timeFormat
                this.parseFormat = this.parseTimeFormat
                break
            case 'date':
                this.format = this.dateFormat
                this.parseFormat = this.parseDateFormat
                break
            case 'datetime':
                this.format = `${this.dateFormat} ${this.timeFormat}`
                this.parseFormat = `${this.parseDateFormat} ${this.parseTimeFormat}`
                break
        }
    },

    methods: {
        init() {
            let value = this.getValue

            if (!value) {
                this.date = ''
                this.time = '00:00:00'
            } else {
                if (typeof value === 'string' || value instanceof String) {
                    value = this.parse(value)
                }

                this.time = format(value, this.parseTimeFormat)
                this.date = format(value, this.parseDateFormat)
            }
        },

        parse(value) {
            return parse(value, this.parseFormat, new Date())
        },

        getTime() {
            if (this.time.length === 5) {
                return `${this.time}:00`
            }

            return this.time
        },

        get() {
            switch (this.type) {
                case 'time':
                    return this.getTime()
                case 'date':
                    return this.date
                case 'datetime':
                    return `${this.date} ${this.getTime()}`
            }
        },

        open() {
            if (!this.component.attributes.readonly) {
                this.init()

                this.modal = true
            }
        },

        save() {
            this.setValue(this.get())

            this.close()
        },

        close () {
            this.modal = false
        },

        reset() {
            this.setValue(null)
        }
    }
}
