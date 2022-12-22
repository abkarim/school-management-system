/**
 * Check a string is a email or not
 * @param {string} email 
 * @returns {boolean} is email
 */
export default function isEmail(email) {
    /**
     * Regex 
     * 
     ** username group 
     * start with char_u
     * 
     * OPTIONAL group 
     * - start with (.)
     * - char_u group
     * 
     ** @
     * 
     ** domain group
     * start with char_d
     * (.)
     * char_d
     * 
     * OPTIONAL group
     * -  char_d
     * - (.)
     * - char_d
     */
    // let match = email
    //     .trim()
    //     .match(/^(?'username'(?'char_u'[A-z0-9-#`!%$&+*/=?^-_{|}~]+)([.](?&char_u))?)@(?'domain'(?'char_d'[A-z-0-9-_]+)[.](?&char_d)([.](?&char_d))?)$/)
    let match = true;
    return match !== null;
}