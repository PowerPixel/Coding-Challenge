var editor = ace.edit("editor");

function logCode() {
    console.log(editor.getValue())
}

function loadLanguage(selectNode) {
    
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/" + JSON.parse(selectNode.value)[0]);
    editor.setOptions({
        "showPrintMargin": false,
        "foldStyle": 'markbeginend',
        "enableBasicAutocompletion": true,
        "enableSnippets": true,
        "enableLiveAutocompletion": true
    });
}