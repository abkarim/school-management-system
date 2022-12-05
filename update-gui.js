/**
 * This file get contents from gui-development/build
 * Replace contents in root 
 */

const fs = require('fs');
const fse = require('fs-extra');

const CURRENT_DIRECTORY = __dirname;

const colors = {
    reset: "\x1b[0m",
    fg: {
        black: "\x1b[30m"
    },
    bg: {
        green: "\x1b[42m",
        red: "\x1b[41m",
        yellow: "\x1b[43m",
        blue: "\x1b[44m"
    }
}

/**
 * Print message to console
 * @param {string} text console text
 * @param {string} type - success [success, warning, error]
 */
function print(text, type = 'success') {
    let bg = colors.bg.green;
    let fg = colors.fg.black;

    if (type === 'info') bg = colors.bg.blue;
    if (type === 'warning') bg = colors.bg.yellow;
    if (type === 'error') bg = colors.bg.red;

    console.log(bg, fg, text, colors.reset);
}

print("updating files, please wait ...", 'info')

/**
 * Get build folder
 */
if (!fs.existsSync(CURRENT_DIRECTORY + '/gui-development/build')) {
    print("/gui-development/build directory not found. First build with npm build in /gui-development, then run this command", 'error');
    process.exit(1)
}

/**
 * Copy index.html file into index.php
 */
let htmlData = fs.readFileSync(CURRENT_DIRECTORY + '/gui-development/build/index.html', 'utf-8');
let indexFileData = fs.readFileSync(CURRENT_DIRECTORY + '/index.php', 'utf-8');
indexFileData = indexFileData.replace(/<!doctype(.*\s*)+/, htmlData);
fs.writeFileSync(CURRENT_DIRECTORY + '/index.php', indexFileData);

/**
 * Copy static folder
 */
fse.copySync(CURRENT_DIRECTORY + '/gui-development/build/static', CURRENT_DIRECTORY + '/public/static/', { overwrite: true })

/**
 * Copy manifest.json
 */
fse.copySync(CURRENT_DIRECTORY + '/gui-development/build/manifest.json', CURRENT_DIRECTORY + '/public/manifest.json', {overwrite: true});
fse.copySync(CURRENT_DIRECTORY + '/gui-development/build/asset-manifest.json', CURRENT_DIRECTORY + '/public/asset-manifest.json', {overwrite: true});

/**
 * Copy robots.txt file
 */
fse.copySync(CURRENT_DIRECTORY + '/gui-development/build/robots.txt', CURRENT_DIRECTORY + '/public/robots.txt', {overwrite: true});


print('done');