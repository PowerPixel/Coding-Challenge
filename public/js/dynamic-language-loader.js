function logCode() {
    console.log(document.querySelector("#editor").value)
}

function loadLanguage(selectNode) {
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/" + selectNode.value);
    editor.setOptions({
        "showPrintMargin": false,
        "foldStyle": 'markbeginend',
        "enableBasicAutocompletion": true,
        "enableSnippets": true,
        "enableLiveAutocompletion": true
    });
}