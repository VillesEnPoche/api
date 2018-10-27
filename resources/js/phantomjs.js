var fs = require("fs"),
    page = require('webpage').create(),
    system = require('system');

page.viewportSize = {width: system.args[2], height: system.args[3]};

if (system.args[5] === 'true') {
    page.clipRect = {top: 50, left: 50, width: system.args[2] - 100, height: system.args[3] - 100};
}

page.open(system.args[1], function () {
    page.render(system.args[4]);
    phantom.exit();
});