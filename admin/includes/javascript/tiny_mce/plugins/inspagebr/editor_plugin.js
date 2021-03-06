tinyMCE.importPluginLanguagePack('inspagebr');

var TinyMCE_PageBreakPlugin = {
	getInfo : function() {
		return {
			longname : 'Inserting ShopOS',
			author : 'ShopOS',
			authorurl : 'http://www.shopos.ru/',
			version : tinyMCE.majorVersion + "." + tinyMCE.minorVersion
		}
	},

	getControlHTML : function(cn) {
		switch (cn) {
			case "inspagebr":
				return tinyMCE.getButtonHTML(cn, 'lang_insert_inspagebr_desc', '{$pluginurl}/images/inspagebr.gif', 'mceInsertPageBR');
		}

		return "";
	},

	/**
	 * Executes the mceAdvanceHr command.
	 */
	execCommand : function(editor_id, element, command, user_interface, value) {
		// Handle commands
		switch (command) {
			case "mceInsertPageBR":
				var template = new Array();

				template['file']   = '../../plugins/inspagebr/insertpagebr.htm'; // Relative to theme
				template['width']  = 500;
				template['height'] = 256;

				template['width']  += tinyMCE.getLang('lang_inspagebr_delta_width', 0);
				template['height'] += tinyMCE.getLang('lang_inspagebr_delta_height', 0);

				tinyMCE.openWindow(template, {editor_id : editor_id, inline : "yes", mceDo : 'insert'});

				return true;
		}

		// Pass to next handler in chain
		return false;
	},

	handleNodeChange : function(editor_id, node, undo_index, undo_levels, visual_aid, any_selection) {
		if (node == null)
			return;

		do {
			if (node.nodeName == "HR") {
				tinyMCE.switchClass(editor_id + '_inspagebr', 'mceButtonSelected');
				return true;
			}
		} while ((node = node.parentNode));

		tinyMCE.switchClass(editor_id + '_inspagebr', 'mceButtonNormal');

		return true;
	}
};

tinyMCE.addPlugin("inspagebr", TinyMCE_PageBreakPlugin);
