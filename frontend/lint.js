const stylelint = require('stylelint');
const appSettings = require('./settings');

stylelint.lint({
    files: [`${appSettings.paths.core.modules}/**/*.scss`, `${appSettings.paths.project.modules}/**/*.scss`],
    syntax: "scss",
    formatter: "string",
}).then(function(data) {
    if (data.errored) {
        const messages = JSON.parse(JSON.stringify(data.output));
        process.stdout.write(messages);
        process.exit(1);
    }
}).catch(function(error) {
    console.error(error.stack);
});
