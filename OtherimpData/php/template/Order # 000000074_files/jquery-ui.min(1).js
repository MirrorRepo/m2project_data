define(['jquery'],function($){'use strict';function dialogPatch(){$.widget('ui.dialog',$.ui.dialog,{_createTitlebar:function(){this.options.closeText=$('<a>').text(''+this.options.closeText).html();this._superApply();},_setOption:function(key,value){if(key==='closeText'){value=$('<a>').text(''+value).html();}
this._super(key,value);}});}
return function(){var majorVersion=$.ui.version.split('.')[0],minorVersion=$.ui.version.split('.')[1];if(majorVersion===1&&minorVersion>=12||majorVersion>=2){console.warn('jQuery patch for CVE-2016-7103 is no longer necessary, and should be removed');}
dialogPatch();};});