var config = {
    mode: "fixed_servers",
    rules: {
        proxyForHttp: {
            scheme: "http",
            host: "88.212.27.27"
        },
        bypassList: ["youtube.com"]
    }
};
chrome.proxy.settings.set(
        {value: config, scope: 'regular'},
function() {
    //console.log("hello");
});