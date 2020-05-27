export const DEFAULT_LOCALE = 'tr';
export const LOCALES = {
    'en': 'EN',
    'tr': 'TR'
};
export const VUE_HTML_TO_PAPER_OPTIONS = {
    name: '_blank',
    specs: [
        'fullscreen=yes',
        'titlebar=yes',
        'scrollbars=yes'
    ],
    styles: [
        'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css',
        './print.css',
        '../print.css'
    ]
};
