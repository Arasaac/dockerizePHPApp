var tinymce_options = {
  mode : "textareas",
  theme : "simple"
};

var tinymce_advanced_options = {
  mode : "textareas",
  theme : "advanced"
};

var tinymce_advanced_with_save_options = {
  mode : "textareas",
  theme : "advanced",
  theme_advanced_buttons1 : 'bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink',
  theme_advanced_buttons2 : 'save,cancel',
  theme_advanced_buttons3 : '',
  theme_advanced_toolbar_location : "top",
  theme_advanced_toolbar_align : "left",
  theme_advanced_path_location : "bottom",
  plugins: 'save'
};

tinyMCE.init(tinymce_advanced_options);
tinyMCE.init(tinymce_advanced_with_save_options);
tinyMCE.init(tinymce_options);