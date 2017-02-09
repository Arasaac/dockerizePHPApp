// I18N constants

// LANG: "en", ENCODING: UTF-8 | ISO-8859-1
// Author: Mihai Bazon, http://dynarch.com/mishoo

// FOR TRANSLATORS:
//
//   1. PLEASE PUT YOUR CONTACT INFO IN THE ABOVE LINE
//      (at least a valid email address)
//
//   2. PLEASE TRY TO USE UTF-8 FOR ENCODING;
//      (if this is not possible, please include a comment
//       that states what encoding is necessary.)

HTMLArea.I18N = {

	// the following should be the filename without .js extension
	// it will be used for automatically load plugin language.
	lang: "en",

	tooltips: {
		bold:           "Negrita",
		italic:         "Cursiva",
		underline:      "Subrayado",
		strikethrough:  "Tachado",
		subscript:      "Subindice",
		superscript:    "Superindice",
		justifyleft:    "Alinear Izquierda",
		justifycenter:  "Alinear Centrado",
		justifyright:   "Alinear Derecha",
		justifyfull:    "Justificado",
		orderedlist:    "Lista ordenada",
		unorderedlist:  "Lista sin ordenar",
		outdent:        "Disminuir sangria",
		indent:         "Aumentar sangria",
		forecolor:      "Color del texto",
		hilitecolor:    "Color de fondo",
		horizontalrule: "Linea horizontal",
		createlink:     "Insertar enlace Web",
		insertimage:    "Insertar/Modificar Imagen",
		inserttable:    "Insertar Tabla",
		htmlmode:       "Ver documento en HTML",
		popupeditor:    "Ampliar Editor",
		about:          "Acerca de",
		showhelp:       "Ayuda",
		textindicator:  "Estilo actual",
		undo:           "Deshacer",
		redo:           "Rehacer",
		cut:            "Cortar",
		copy:           "Copiar",
		paste:          "Pegar",
		lefttoright:    "Dirección Izquierda a Derecha",
		righttoleft:    "Dirección Derecha a Izquierda"
	},

	buttons: {
		"ok":           "OK",
		"cancel":       "Cancelar"
	},

	msg: {
		"Path":         "Ruta",
		"TEXT_MODE":    "Esta en modo TEXTO. Use el boton [<>] para cambiar a WYSIWIG.",

		"IE-sucks-full-screen" :
		// translate here
		"The full screen mode is known to cause problems with Internet Explorer, " +
		"due to browser bugs that we weren't able to workaround.  You might experience garbage " +
		"display, lack of editor functions and/or random browser crashes.  If your system is Windows 9x " +
		"it's very likely that you'll get a 'General Protection Fault' and need to reboot.\n\n" +
		"You have been warned.  Please press OK if you still want to try the full screen editor.",

		"Moz-Clipboard" :
		"Unprivileged scripts cannot access Cut/Copy/Paste programatically " +
		"for security reasons.  Click OK to see a technical note at mozilla.org " +
		"which shows you how to allow a script to access the clipboard."
	},

	dialogs: {
		"Cancel"                                            : "Cancelar",
		"Insert/Modify Link"                                : "Insertar/Modificar Enlace",
		"New window (_blank)"                               : "Nueva Ventana (_blank)",
		"None (use implicit)"                               : "Ninguno (use implicit)",
		"OK"                                                : "OK",
		"Other"                                             : "Otro",
		"Same frame (_self)"                                : "Mismo frame (_self)",
		"Target:"                                           : "Target:",
		"Title (tooltip):"                                  : "Titulo (tooltip):",
		"Top frame (_top)"                                  : "Frame superior (_top)",
		"URL:"                                              : "URL:",
		"You must enter the URL where this link points to"  : "Debe introducir la URL al que apunt el enlace"
	}
};
