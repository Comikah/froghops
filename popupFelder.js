// Pop Up Box mit Kommentarfeld, wenn Umbenennen-Button angeklickt wird

function aendereFile(fileId, fileName){
    bootbox.prompt({
        title: "Bitte neuen Dateinamen eingeben",
        value: fileName,
        inputType: "text",
        buttons: {
            confirm: {
                label: '&Auml;ndern',
                className: 'btn-success'
            },
            cancel: {
                label: 'Abbrechen',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result) {
                request = $.ajax({
                    url: "umbenennen2.php",
                    type: "post",
                    data: "id=" + fileId + "&name=" + result,
                    success: function() {
                        window.location = "dashboard.php";
                    }
                });
            }
        }
    });
}


// Pop Up Box mit Emailfeld, wenn Link versenden angeklickt wird

function versendeLink(HASH){
    bootbox.prompt({
        title: "Bitte Emailadresse eintragen",
        inputType: "text",
        buttons: {
            confirm: {
                label: 'Versenden',
                className: 'btn-success'
            },
            cancel: {
                label: 'Abbrechen',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result) {
                request = $.ajax({
                    url: "linkverschicken.php",
                    type: "post",
                    data: "id=" + HASH + "&email=" + result,
                    success: function() {
                        window.location = "dashboard.php";
                    }
                });
            }
        }
    });
}




// Pop Up Box mit Sicherheitsabfrage, wenn löschen-Button angeklickt wird


function loescheFile(fileId){
    bootbox.confirm({
        message: "Datei wirklich l&ouml;schen?",
        buttons: {
            confirm: {
                label: 'Ja',
                className: 'btn-success'
            },
            cancel: {
                label: 'Nein',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result) {
                request = $.ajax({
                    url: "loeschen.php",
                    type: "post",
                    data: "id=" + fileId,
                    success: function() {
                        window.location = "dashboard.php";
                    }
                });
            }
        }
    });
}


// POP UP Box mit Link Anzeige

function zeigeLink (HASH){
    bootbox.alert('<a target="new" href="'+ "https://mars.iuk.hdm-stuttgart.de/~sd103/datei_runterladen.php?id=" + HASH + '">'
        + "https://mars.iuk.hdm-stuttgart.de/~sd103/datei_runterladen.php?id=" + HASH + '</a>');

}



// Pop Up Box für die Notiz - Zeigt Inhalt und Textfeld zum ändern

function zeigeNotiz(fileId, fileName){
    bootbox.prompt({
        title: "Verwalte deine Notiz",
        value: fileName,
        inputType: "text",
        buttons: {
            confirm: {
                label: '&Auml;ndern',
                className: 'btn-success'
            },
            cancel: {
                label: 'Zur&uuml;ck',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result) {
                request = $.ajax({
                    url: "notiz.php",
                    type: "post",
                    data: "id=" + fileId + "&notiz=" + result,
                    success: function() {
                        window.location = "dashboard.php";
                    }
                });
            }
        }
    });
}

