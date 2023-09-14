/* eslint-disable no-unused-vars, no-unused-expressions */
var DIALOGUE_PREFIX,
    BASE,
    CONFIRMYES,
    CONFIRMNO,
    TITLE,
    QUESTION,
    CSS_CLASSES;

DIALOGUE_PREFIX = 'powereduc-dialogue';
BASE = 'notificationBase';
CONFIRMYES = 'yesLabel';
CONFIRMNO = 'noLabel';
TITLE = 'title';
QUESTION = 'question';
CSS_CLASSES = {
    BASE: 'powereduc-dialogue-base',
    WRAP: 'powereduc-dialogue-wrap',
    HEADER: 'powereduc-dialogue-hd',
    BODY: 'powereduc-dialogue-bd',
    CONTENT: 'powereduc-dialogue-content',
    FOOTER: 'powereduc-dialogue-ft',
    HIDDEN: 'hidden',
    LIGHTBOX: 'powereduc-dialogue-lightbox'
};

// Set up the namespace once.
M.core = M.core || {};
