<?php

    namespace Support\Enums\Vuetify;

    use Illuminate\Support\Facades\Auth;

    enum VuetifyColors : string
    {
        case PRIMARY = 'primary';
        case SECONDARY = 'secondary';
        case ACCENT = 'accent';
        case ERROR = 'error';
        case INFO = 'info';
        case SUCCESS = 'success';
        case WARNING = 'warning';
        case TRANSPARENT = 'transparent';
        case NONE = 'undefined';

        case DARK_BACKGROUND = '#121212';
        case DARK_HEADER = '#272727';

        case LIGHT_HEADER = '#f5f5f5';

        /**
         * @param VuetifyColors $dark
         * @param VuetifyColors $light
         *
         * @return VuetifyColors
         */
        public static function theme(self $dark, self $light): VuetifyColors
        {
            $isDark = Auth::user()->profile->preferences->get('dark_mode', true);

            return $isDark ? $dark : $light;
        }
    }
