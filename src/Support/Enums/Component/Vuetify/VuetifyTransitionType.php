<?php

namespace Support\Enums\Component\Vuetify;

enum VuetifyTransitionType: string
{
    case FAB = 'fab-transition';
    case FADE = 'fade-transition';
    case SCALE = 'scale-transition';
    case EXPAND = 'expand-transition';
    case SCROLL_X = 'scroll-x-transition';
    case SCROLL_Y = 'scroll-y-transition';
    case SCROLL_X_REVERSE = 'scroll-x-reverse-transition';
    case SCROLL_Y_REVERSE = 'scroll-y-reverse-transition';
    case SLIDE_X = 'slide-x-transition';
    case SLIDE_Y = 'slide-y-transition';
    case SLIDE_X_REVERSE = 'slide-x-reverse-transition';
    case SLIDE_Y_REVERSE = 'slide-y-reverse-transition';
    case MODAL_TOP = 'dialog-top-transition';
    case MODAL_BOTTOM = 'dialog-bottom-transition';
}
