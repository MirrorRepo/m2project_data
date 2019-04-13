;try {
/* module-key = 'confluence.web.resources:moment', location = '/includes/js/dist/moment.js' */
(function(){function R(a,b){return function(c){return k(a.call(this,c),b)}}function pa(a,b){return function(c){return this.lang().ordinal(a.call(this,c),b)}}function S(){}function B(a){T(a);m(this,a)}function C(a){var a=U(a),b=a.year||0,c=a.month||0,d=a.week||0,f=a.day||0;this._milliseconds=+(a.millisecond||0)+1E3*(a.second||0)+6E4*(a.minute||0)+36E5*(a.hour||0);this._days=+f+7*d;this._months=+c+12*b;this._data={};this._bubble()}function m(a,b){for(var c in b)b.hasOwnProperty(c)&&(a[c]=b[c]);b.hasOwnProperty("toString")&&
(a.toString=b.toString);b.hasOwnProperty("valueOf")&&(a.valueOf=b.valueOf);return a}function s(a){return 0>a?Math.ceil(a):Math.floor(a)}function k(a,b,c){for(var d=Math.abs(a)+"";d.length<b;)d="0"+d;return(0<=a?c?"+":"":"-")+d}function D(a,b,c,d){var f=b._milliseconds,i=b._days,b=b._months,g,h;f&&a._d.setTime(+a._d+f*c);if(i||b)g=a.minute(),h=a.hour();i&&a.date(a.date()+i*c);b&&a.month(a.month()+b*c);f&&!d&&e.updateOffset(a);if(i||b)a.minute(g),a.hour(h)}function E(a){return"[object Array]"===Object.prototype.toString.call(a)}
function V(a,b,c){var d=Math.min(a.length,b.length),f=Math.abs(a.length-b.length),e=0,g;for(g=0;g<d;g++)(c&&a[g]!==b[g]||!c&&h(a[g])!==h(b[g]))&&e++;return e+f}function l(a){if(a)var b=a.toLowerCase().replace(/(.)s$/,"$1"),a=qa[a]||ra[b]||b;return a}function U(a){var b={},c,d;for(d in a)a.hasOwnProperty(d)&&(c=l(d))&&(b[c]=a[d]);return b}function sa(a){var b,c;if(0===a.indexOf("week"))b=7,c="day";else if(0===a.indexOf("month"))b=12,c="month";else return;e[a]=function(d,f){var i,g,h=e.fn._lang[a],
j=[];"number"===typeof d&&(f=d,d=void 0);g=function(a){a=e().utc().set(c,a);return h.call(e.fn._lang,a,d||"")};if(null!=f)return g(f);for(i=0;i<b;i++)j.push(g(i));return j}}function h(a){var a=+a,b=0;0!==a&&isFinite(a)&&(b=0<=a?Math.floor(a):Math.ceil(a));return b}function F(a){return 0===a%4&&0!==a%100||0===a%400}function T(a){var b;if(a._a&&-2===a._pf.overflow){b=0>a._a[t]||11<a._a[t]?t:1>a._a[q]||a._a[q]>(new Date(Date.UTC(a._a[o],a._a[t]+1,0))).getUTCDate()?q:0>a._a[n]||23<a._a[n]?n:0>a._a[u]||
59<a._a[u]?u:0>a._a[x]||59<a._a[x]?x:0>a._a[y]||999<a._a[y]?y:-1;if(a._pf._overflowDayOfYear&&(b<o||b>q))b=q;a._pf.overflow=b}}function W(a){a._pf={empty:!1,unusedTokens:[],unusedInput:[],overflow:-2,charsLeftOver:0,nullInput:!1,invalidMonth:null,invalidFormat:!1,userInvalidated:!1,iso:!1}}function X(a){null==a._isValid&&(a._isValid=!isNaN(a._d.getTime())&&0>a._pf.overflow&&!a._pf.empty&&!a._pf.invalidMonth&&!a._pf.nullInput&&!a._pf.invalidFormat&&!a._pf.userInvalidated,a._strict&&(a._isValid=a._isValid&&
0===a._pf.charsLeftOver&&0===a._pf.unusedTokens.length));return a._isValid}function G(a){return a?a.toLowerCase().replace("_","-"):a}function H(a,b){return b._isUTC?e(a).zone(b._offset||0):e(a).local()}function p(a){var b=0,c,d,f,i,g=function(a){if(!v[a]&&Y)try{require("./lang/"+a)}catch(b){}return v[a]};if(!a)return e.fn._lang;if(!E(a)){if(d=g(a))return d;a=[a]}for(;b<a.length;){i=G(a[b]).split("-");c=i.length;for(f=(f=G(a[b+1]))?f.split("-"):null;0<c;){if(d=g(i.slice(0,c).join("-")))return d;if(f&&
f.length>=c&&V(i,f,!0)>=c-1)break;c--}b++}return e.fn._lang}function I(a,b){if(!a.isValid())return a.lang().invalidDate();b=Z(b,a.lang());if(!J[b]){var c=J,d=b,f=b,e=f.match($),g,h;g=0;for(h=e.length;g<h;g++)e[g]=r[e[g]]?r[e[g]]:e[g].match(/\[[\s\S]/)?e[g].replace(/^\[|\]$/g,""):e[g].replace(/\\/g,"");c[d]=function(a){var b="";for(g=0;g<h;g++)b+=e[g]instanceof Function?e[g].call(a,f):e[g];return b}}return J[b](a)}function Z(a,b){function c(a){return b.longDateFormat(a)||a}var d=5;for(z.lastIndex=
0;0<=d&&z.test(a);)a=a.replace(z,c),z.lastIndex=0,d-=1;return a}function ta(a,b){var c=b._strict;switch(a){case "DDDD":return aa;case "YYYY":case "GGGG":case "gggg":return c?ua:va;case "YYYYYY":case "YYYYY":case "GGGGG":case "ggggg":return c?wa:xa;case "S":if(c)return ba;case "SS":if(c)return ca;case "SSS":case "DDD":return c?aa:ya;case "MMM":case "MMMM":case "dd":case "ddd":case "dddd":return za;case "a":case "A":return p(b._l)._meridiemParse;case "X":return Aa;case "Z":case "ZZ":return K;case "T":return Ba;
case "SSSS":return Ca;case "MM":case "DD":case "YY":case "GG":case "gg":case "HH":case "hh":case "mm":case "ss":case "ww":case "WW":return c?ca:da;case "M":case "D":case "d":case "H":case "h":case "m":case "s":case "w":case "W":case "e":case "E":return c?ba:da;default:var c=RegExp,d;d=a.replace("\\","").replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g,function(a,b,c,d,e){return b||c||d||e}).replace(/[-\/\\^$*+?.()|[\]{}]/g,"\\$&");return new c(d)}}function ea(a){var a=(a||"").match(K)||[],a=((a[a.length-
1]||[])+"").match(Da)||["-",0,0],b=+(60*a[1])+h(a[2]);return"+"===a[0]?-b:b}function L(a){var b,c=[],d,f,i,g,j;if(!a._d){d=new Date;d=a._useUTC?[d.getUTCFullYear(),d.getUTCMonth(),d.getUTCDate()]:[d.getFullYear(),d.getMonth(),d.getDate()];a._w&&(null==a._a[q]&&null==a._a[t])&&(b=function(b){var c=parseInt(b,10);return b?3>b.length?68<c?1900+c:2E3+c:c:null==a._a[o]?e().weekYear():a._a[o]},f=a._w,null!=f.GG||null!=f.W||null!=f.E?b=fa(b(f.GG),f.W||1,f.E,4,1):(i=p(a._l),g=null!=f.d?ga(f.d,i):null!=f.e?
parseInt(f.e,10)+i._week.dow:0,j=parseInt(f.w,10)||1,null!=f.d&&g<i._week.dow&&j++,b=fa(b(f.gg),j,g,i._week.doy,i._week.dow)),a._a[o]=b.year,a._dayOfYear=b.dayOfYear);if(a._dayOfYear){b=null==a._a[o]?d[o]:a._a[o];if(a._dayOfYear>(F(b)?366:365))a._pf._overflowDayOfYear=!0;b=ha(b,0,a._dayOfYear);a._a[t]=b.getUTCMonth();a._a[q]=b.getUTCDate()}for(b=0;3>b&&null==a._a[b];++b)a._a[b]=c[b]=d[b];for(;7>b;b++)a._a[b]=c[b]=null==a._a[b]?2===b?1:0:a._a[b];c[n]+=h((a._tzm||0)/60);c[u]+=h((a._tzm||0)%60);a._d=
(a._useUTC?ha:Ea).apply(null,c)}}function M(a){a._a=[];a._pf.empty=!0;var b=p(a._l),c=""+a._i,d,f,e,g,j=c.length,k=0;f=Z(a._f,b).match($)||[];for(b=0;b<f.length;b++){e=f[b];if(d=(c.match(ta(e,a))||[])[0])g=c.substr(0,c.indexOf(d)),0<g.length&&a._pf.unusedInput.push(g),c=c.slice(c.indexOf(d)+d.length),k+=d.length;if(r[e]){d?a._pf.empty=!1:a._pf.unusedTokens.push(e);g=a;var m=void 0,l=g._a;switch(e){case "M":case "MM":null!=d&&(l[t]=h(d)-1);break;case "MMM":case "MMMM":m=p(g._l).monthsParse(d);null!=
m?l[t]=m:g._pf.invalidMonth=d;break;case "D":case "DD":null!=d&&(l[q]=h(d));break;case "DDD":case "DDDD":null!=d&&(g._dayOfYear=h(d));break;case "YY":l[o]=h(d)+(68<h(d)?1900:2E3);break;case "YYYY":case "YYYYY":case "YYYYYY":l[o]=h(d);break;case "a":case "A":g._isPm=p(g._l).isPM(d);break;case "H":case "HH":case "h":case "hh":l[n]=h(d);break;case "m":case "mm":l[u]=h(d);break;case "s":case "ss":l[x]=h(d);break;case "S":case "SS":case "SSS":case "SSSS":l[y]=h(1E3*("0."+d));break;case "X":g._d=new Date(1E3*
parseFloat(d));break;case "Z":case "ZZ":g._useUTC=!0;g._tzm=ea(d);break;case "w":case "ww":case "W":case "WW":case "d":case "dd":case "ddd":case "dddd":case "e":case "E":e=e.substr(0,1);case "gg":case "gggg":case "GG":case "GGGG":case "GGGGG":e=e.substr(0,2),d&&(g._w=g._w||{},g._w[e]=d)}}else a._strict&&!d&&a._pf.unusedTokens.push(e)}a._pf.charsLeftOver=j-k;0<c.length&&a._pf.unusedInput.push(c);a._isPm&&12>a._a[n]&&(a._a[n]+=12);!1===a._isPm&&12===a._a[n]&&(a._a[n]=0);L(a);T(a)}function Ea(a,b,c,
d,f,e,g){b=new Date(a,b,c,d,f,e,g);1970>a&&b.setFullYear(a);return b}function ha(a){var b=new Date(Date.UTC.apply(null,arguments));1970>a&&b.setUTCFullYear(a);return b}function ga(a,b){if("string"===typeof a)if(isNaN(a)){if(a=b.weekdaysParse(a),"number"!==typeof a)return null}else a=parseInt(a,10);return a}function Fa(a,b,c,d,e){return e.relativeTime(b||1,!!c,a,d)}function A(a,b,c){b=c-b;c-=a.day();c>b&&(c-=7);c<b-7&&(c+=7);a=e(a).add("d",c);return{week:Math.ceil(a.dayOfYear()/7),year:a.year()}}function fa(a,
b,c,d,e){var i=(new Date(k(a,6,!0)+"-01-01")).getUTCDay(),b=7*(b-1)+((null!=c?c:e)-e)+(e-i+(i>d?7:0))+1;return{year:0<b?a:a-1,dayOfYear:0<b?b:(F(a-1)?366:365)+b}}function ia(a){var b=a._i,c=a._f;"undefined"===typeof a._pf&&W(a);if(null===b)return e.invalid({nullInput:!0});"string"===typeof b&&(a._i=b=p().preparse(b));if(e.isMoment(b))a=m({},b),a._d=new Date(+b._d);else if(c)if(E(c)){var b=a,d,f,i,g;if(0===b._f.length)b._pf.invalidFormat=!0,b._d=new Date(NaN);else{for(c=0;c<b._f.length;c++)if(g=0,
d=m({},b),W(d),d._f=b._f[c],M(d),X(d)&&(g+=d._pf.charsLeftOver,g+=10*d._pf.unusedTokens.length,d._pf.score=g,null==i||g<i))i=g,f=d;m(b,f||d)}}else M(a);else if(d=a,f=d._i,i=Ga.exec(f),void 0===f)d._d=new Date;else if(i)d._d=new Date(+i[1]);else if("string"===typeof f)if(i=d._i,b=Ha.exec(i)){d._pf.iso=!0;for(f=4;0<f;f--)if(b[f]){d._f=Ia[f-1]+(b[6]||" ");break}for(f=0;4>f;f++)if(ja[f][1].exec(i)){d._f+=ja[f][0];break}i.match(K)&&(d._f+="Z");M(d)}else d._d=new Date(i);else E(f)?(d._a=f.slice(0),L(d)):
"[object Date]"===Object.prototype.toString.call(f)||f instanceof Date?d._d=new Date(+f):"object"===typeof f?d._d||(f=U(d._i),d._a=[f.year,f.month,f.day,f.hour,f.minute,f.second,f.millisecond],L(d)):d._d=new Date(f);return new B(a)}function ka(a,b){e.fn[a]=e.fn[a+"s"]=function(a){var d=this._isUTC?"UTC":"";return null!=a?(this._d["set"+d+b](a),e.updateOffset(this),this):this._d["get"+d+b]()}}function Ja(a){e.duration.fn[a]=function(){return this._data[a]}}function la(a,b){e.duration.fn["as"+a]=function(){return+this/
b}}function N(a){var b=!1,c=e;"undefined"===typeof ender&&(a?(O.moment=function(){!b&&(console&&console.warn)&&(b=!0,console.warn("Accessing Moment through the global scope is deprecated, and will be removed in an upcoming release."));return c.apply(null,arguments)},m(O.moment,c)):O.moment=e)}for(var e,O=this,w=Math.round,j,o=0,t=1,q=2,n=3,u=4,x=5,y=6,v={},Y="undefined"!==typeof module&&module.exports&&"undefined"!==typeof require,Ga=/^\/?Date\((\-?\d+)/i,Ka=/(\-)?(?:(\d*)\.)?(\d+)\:(\d+)(?:\:(\d+)\.?(\d{3})?)?/,
La=/^(-)?P(?:(?:([0-9,.]*)Y)?(?:([0-9,.]*)M)?(?:([0-9,.]*)D)?(?:T(?:([0-9,.]*)H)?(?:([0-9,.]*)M)?(?:([0-9,.]*)S)?)?|([0-9,.]*)W)$/,$=/(\[[^\[]*\])|(\\)?(Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|mm?|ss?|S{1,4}|X|zz?|ZZ?|.)/g,z=/(\[[^\[]*\])|(\\)?(LT|LL?L?L?|l{1,4})/g,da=/\d\d?/,ya=/\d{1,3}/,va=/\d{1,4}/,xa=/[+\-]?\d{1,6}/,Ca=/\d+/,za=/[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i,
K=/Z|[\+\-]\d\d:?\d\d/gi,Ba=/T/i,Aa=/[\+\-]?\d+(\.\d{1,3})?/,ba=/\d/,ca=/\d\d/,aa=/\d{3}/,ua=/\d{4}/,wa=/[+\-]?\d{6}/,Ha=/^\s*\d{4}-(?:(\d\d-\d\d)|(W\d\d$)|(W\d\d-\d)|(\d\d\d))((T| )(\d\d(:\d\d(:\d\d(\.\d+)?)?)?)?([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/,Ia=["YYYY-MM-DD","GGGG-[W]WW","GGGG-[W]WW-E","YYYY-DDD"],ja=[["HH:mm:ss.SSSS",/(T| )\d\d:\d\d:\d\d\.\d{1,3}/],["HH:mm:ss",/(T| )\d\d:\d\d:\d\d/],["HH:mm",/(T| )\d\d:\d\d/],["HH",/(T| )\d\d/]],Da=/([\+\-]|\d\d)/gi,P=["Date","Hours","Minutes","Seconds","Milliseconds"],
Q={Milliseconds:1,Seconds:1E3,Minutes:6E4,Hours:36E5,Days:864E5,Months:2592E6,Years:31536E6},qa={ms:"millisecond",s:"second",m:"minute",h:"hour",d:"day",D:"date",w:"week",W:"isoWeek",M:"month",y:"year",DDD:"dayOfYear",e:"weekday",E:"isoWeekday",gg:"weekYear",GG:"isoWeekYear"},ra={dayofyear:"dayOfYear",isoweekday:"isoWeekday",isoweek:"isoWeek",weekyear:"weekYear",isoweekyear:"isoWeekYear"},J={},ma="DDD w W M D d".split(" "),na="MDHhmswW".split(""),r={M:function(){return this.month()+1},MMM:function(a){return this.lang().monthsShort(this,
a)},MMMM:function(a){return this.lang().months(this,a)},D:function(){return this.date()},DDD:function(){return this.dayOfYear()},d:function(){return this.day()},dd:function(a){return this.lang().weekdaysMin(this,a)},ddd:function(a){return this.lang().weekdaysShort(this,a)},dddd:function(a){return this.lang().weekdays(this,a)},w:function(){return this.week()},W:function(){return this.isoWeek()},YY:function(){return k(this.year()%100,2)},YYYY:function(){return k(this.year(),4)},YYYYY:function(){return k(this.year(),
5)},YYYYYY:function(){var a=this.year();return(0<=a?"+":"-")+k(Math.abs(a),6)},gg:function(){return k(this.weekYear()%100,2)},gggg:function(){return this.weekYear()},ggggg:function(){return k(this.weekYear(),5)},GG:function(){return k(this.isoWeekYear()%100,2)},GGGG:function(){return this.isoWeekYear()},GGGGG:function(){return k(this.isoWeekYear(),5)},e:function(){return this.weekday()},E:function(){return this.isoWeekday()},a:function(){return this.lang().meridiem(this.hours(),this.minutes(),!0)},
A:function(){return this.lang().meridiem(this.hours(),this.minutes(),!1)},H:function(){return this.hours()},h:function(){return this.hours()%12||12},m:function(){return this.minutes()},s:function(){return this.seconds()},S:function(){return h(this.milliseconds()/100)},SS:function(){return k(h(this.milliseconds()/10),2)},SSS:function(){return k(this.milliseconds(),3)},SSSS:function(){return k(this.milliseconds(),3)},Z:function(){var a=-this.zone(),b="+";0>a&&(a=-a,b="-");return b+k(h(a/60),2)+":"+
k(h(a)%60,2)},ZZ:function(){var a=-this.zone(),b="+";0>a&&(a=-a,b="-");return b+k(h(a/60),2)+k(h(a)%60,2)},z:function(){return this.zoneAbbr()},zz:function(){return this.zoneName()},X:function(){return this.unix()},Q:function(){return this.quarter()}},oa=["months","monthsShort","weekdays","weekdaysShort","weekdaysMin"];ma.length;)j=ma.pop(),r[j+"o"]=pa(r[j],j);for(;na.length;)j=na.pop(),r[j+j]=R(r[j],2);r.DDDD=R(r.DDD,3);m(S.prototype,{set:function(a){var b,c;for(c in a)b=a[c],"function"===typeof b?
this[c]=b:this["_"+c]=b},_months:"January February March April May June July August September October November December".split(" "),months:function(a){return this._months[a.month()]},_monthsShort:"Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" "),monthsShort:function(a){return this._monthsShort[a.month()]},monthsParse:function(a){var b,c;this._monthsParse||(this._monthsParse=[]);for(b=0;12>b;b++)if(this._monthsParse[b]||(c=e.utc([2E3,b]),c="^"+this.months(c,"")+"|^"+this.monthsShort(c,""),
this._monthsParse[b]=RegExp(c.replace(".",""),"i")),this._monthsParse[b].test(a))return b},_weekdays:"Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" "),weekdays:function(a){return this._weekdays[a.day()]},_weekdaysShort:"Sun Mon Tue Wed Thu Fri Sat".split(" "),weekdaysShort:function(a){return this._weekdaysShort[a.day()]},_weekdaysMin:"Su Mo Tu We Th Fr Sa".split(" "),weekdaysMin:function(a){return this._weekdaysMin[a.day()]},weekdaysParse:function(a){var b,c;this._weekdaysParse||
(this._weekdaysParse=[]);for(b=0;7>b;b++)if(this._weekdaysParse[b]||(c=e([2E3,1]).day(b),c="^"+this.weekdays(c,"")+"|^"+this.weekdaysShort(c,"")+"|^"+this.weekdaysMin(c,""),this._weekdaysParse[b]=RegExp(c.replace(".",""),"i")),this._weekdaysParse[b].test(a))return b},_longDateFormat:{LT:"h:mm A",L:"MM/DD/YYYY",LL:"MMMM D YYYY",LLL:"MMMM D YYYY LT",LLLL:"dddd, MMMM D YYYY LT"},longDateFormat:function(a){var b=this._longDateFormat[a];!b&&this._longDateFormat[a.toUpperCase()]&&(b=this._longDateFormat[a.toUpperCase()].replace(/MMMM|MM|DD|dddd/g,
function(a){return a.slice(1)}),this._longDateFormat[a]=b);return b},isPM:function(a){return"p"===(a+"").toLowerCase().charAt(0)},_meridiemParse:/[ap]\.?m?\.?/i,meridiem:function(a,b,c){return 11<a?c?"pm":"PM":c?"am":"AM"},_calendar:{sameDay:"[Today at] LT",nextDay:"[Tomorrow at] LT",nextWeek:"dddd [at] LT",lastDay:"[Yesterday at] LT",lastWeek:"[Last] dddd [at] LT",sameElse:"L"},calendar:function(a,b){var c=this._calendar[a];return"function"===typeof c?c.apply(b):c},_relativeTime:{future:"in %s",
past:"%s ago",s:"a few seconds",m:"a minute",mm:"%d minutes",h:"an hour",hh:"%d hours",d:"a day",dd:"%d days",M:"a month",MM:"%d months",y:"a year",yy:"%d years"},relativeTime:function(a,b,c,d){var e=this._relativeTime[c];return"function"===typeof e?e(a,b,c,d):e.replace(/%d/i,a)},pastFuture:function(a,b){var c=this._relativeTime[0<a?"future":"past"];return"function"===typeof c?c(b):c.replace(/%s/i,b)},ordinal:function(a){return this._ordinal.replace("%d",a)},_ordinal:"%d",preparse:function(a){return a},
postformat:function(a){return a},week:function(a){return A(a,this._week.dow,this._week.doy).week},_week:{dow:0,doy:6},_invalidDate:"Invalid date",invalidDate:function(){return this._invalidDate}});e=function(a,b,c,d){"boolean"===typeof c&&(d=c,c=void 0);return ia({_i:a,_f:b,_l:c,_strict:d,_isUTC:!1})};e.utc=function(a,b,c,d){"boolean"===typeof c&&(d=c,c=void 0);return ia({_useUTC:!0,_isUTC:!0,_l:c,_i:a,_f:b,_strict:d}).utc()};e.unix=function(a){return e(1E3*a)};e.duration=function(a,b){var c=a,d=
null,f;if(e.isDuration(a))c={ms:a._milliseconds,d:a._days,M:a._months};else if("number"===typeof a)c={},b?c[b]=a:c.milliseconds=a;else if(d=Ka.exec(a))f="-"===d[1]?-1:1,c={y:0,d:h(d[q])*f,h:h(d[n])*f,m:h(d[u])*f,s:h(d[x])*f,ms:h(d[y])*f};else if(d=La.exec(a))f="-"===d[1]?-1:1,c=function(a){a=a&&parseFloat(a.replace(",","."));return(isNaN(a)?0:a)*f},c={y:c(d[2]),M:c(d[3]),d:c(d[4]),h:c(d[5]),m:c(d[6]),s:c(d[7]),w:c(d[8])};d=new C(c);e.isDuration(a)&&a.hasOwnProperty("_lang")&&(d._lang=a._lang);return d};
e.version="2.5.0";e.defaultFormat="YYYY-MM-DDTHH:mm:ssZ";e.updateOffset=function(){};e.lang=function(a,b){if(!a)return e.fn._lang._abbr;if(b){var c=G(a);b.abbr=c;v[c]||(v[c]=new S);v[c].set(b)}else null===b?(delete v[a],a="en"):v[a]||p(a);return(e.duration.fn._lang=e.fn._lang=p(a))._abbr};e.langData=function(a){a&&(a._lang&&a._lang._abbr)&&(a=a._lang._abbr);return p(a)};e.isMoment=function(a){return a instanceof B};e.isDuration=function(a){return a instanceof C};for(j=oa.length-1;0<=j;--j)sa(oa[j]);
e.normalizeUnits=function(a){return l(a)};e.invalid=function(a){var b=e.utc(NaN);null!=a?m(b._pf,a):b._pf.userInvalidated=!0;return b};e.parseZone=function(a){return e(a).parseZone()};m(e.fn=B.prototype,{clone:function(){return e(this)},valueOf:function(){return+this._d+6E4*(this._offset||0)},unix:function(){return Math.floor(+this/1E3)},toString:function(){return this.clone().lang("en").format("ddd MMM DD YYYY HH:mm:ss [GMT]ZZ")},toDate:function(){return this._offset?new Date(+this):this._d},toISOString:function(){var a=
e(this).utc();return 0<a.year()&&9999>=a.year()?I(a,"YYYY-MM-DD[T]HH:mm:ss.SSS[Z]"):I(a,"YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]")},toArray:function(){return[this.year(),this.month(),this.date(),this.hours(),this.minutes(),this.seconds(),this.milliseconds()]},isValid:function(){return X(this)},isDSTShifted:function(){return this._a?this.isValid()&&0<V(this._a,(this._isUTC?e.utc(this._a):e(this._a)).toArray()):!1},parsingFlags:function(){return m({},this._pf)},invalidAt:function(){return this._pf.overflow},
utc:function(){return this.zone(0)},local:function(){this.zone(0);this._isUTC=!1;return this},format:function(a){a=I(this,a||e.defaultFormat);return this.lang().postformat(a)},add:function(a,b){var c;c="string"===typeof a?e.duration(+b,a):e.duration(a,b);D(this,c,1);return this},subtract:function(a,b){var c;c="string"===typeof a?e.duration(+b,a):e.duration(a,b);D(this,c,-1);return this},diff:function(a,b,c){var a=H(a,this),d=6E4*(this.zone()-a.zone()),f,b=l(b);"year"===b||"month"===b?(f=432E5*(this.daysInMonth()+
a.daysInMonth()),d=12*(this.year()-a.year())+(this.month()-a.month()),d+=(this-e(this).startOf("month")-(a-e(a).startOf("month")))/f,d-=6E4*(this.zone()-e(this).startOf("month").zone()-(a.zone()-e(a).startOf("month").zone()))/f,"year"===b&&(d/=12)):(f=this-a,d="second"===b?f/1E3:"minute"===b?f/6E4:"hour"===b?f/36E5:"day"===b?(f-d)/864E5:"week"===b?(f-d)/6048E5:f);return c?d:s(d)},from:function(a,b){return e.duration(this.diff(a)).lang(this.lang()._abbr).humanize(!b)},fromNow:function(a){return this.from(e(),
a)},calendar:function(){var a=H(e(),this).startOf("day"),a=this.diff(a,"days",!0);return this.format(this.lang().calendar(-6>a?"sameElse":-1>a?"lastWeek":0>a?"lastDay":1>a?"sameDay":2>a?"nextDay":7>a?"nextWeek":"sameElse",this))},isLeapYear:function(){return F(this.year())},isDST:function(){return this.zone()<this.clone().month(0).zone()||this.zone()<this.clone().month(5).zone()},day:function(a){var b=this._isUTC?this._d.getUTCDay():this._d.getDay();return null!=a?(a=ga(a,this.lang()),this.add({d:a-
b})):b},month:function(a){var b=this._isUTC?"UTC":"",c;if(null!=a){if("string"===typeof a&&(a=this.lang().monthsParse(a),"number"!==typeof a))return this;c=this.date();this.date(1);this._d["set"+b+"Month"](a);this.date(Math.min(c,this.daysInMonth()));e.updateOffset(this);return this}return this._d["get"+b+"Month"]()},startOf:function(a){a=l(a);switch(a){case "year":this.month(0);case "month":this.date(1);case "week":case "isoWeek":case "day":this.hours(0);case "hour":this.minutes(0);case "minute":this.seconds(0);
case "second":this.milliseconds(0)}"week"===a?this.weekday(0):"isoWeek"===a&&this.isoWeekday(1);return this},endOf:function(a){a=l(a);return this.startOf(a).add("isoWeek"===a?"week":a,1).subtract("ms",1)},isAfter:function(a,b){b="undefined"!==typeof b?b:"millisecond";return+this.clone().startOf(b)>+e(a).startOf(b)},isBefore:function(a,b){b="undefined"!==typeof b?b:"millisecond";return+this.clone().startOf(b)<+e(a).startOf(b)},isSame:function(a,b){b=b||"ms";return+this.clone().startOf(b)===+H(a,this).startOf(b)},
min:function(a){a=e.apply(null,arguments);return a<this?this:a},max:function(a){a=e.apply(null,arguments);return a>this?this:a},zone:function(a){var b=this._offset||0;if(null!=a)"string"===typeof a&&(a=ea(a)),16>Math.abs(a)&&(a*=60),this._offset=a,this._isUTC=!0,b!==a&&D(this,e.duration(b-a,"m"),1,!0);else return this._isUTC?b:this._d.getTimezoneOffset();return this},zoneAbbr:function(){return this._isUTC?"UTC":""},zoneName:function(){return this._isUTC?"Coordinated Universal Time":""},parseZone:function(){this._tzm?
this.zone(this._tzm):"string"===typeof this._i&&this.zone(this._i);return this},hasAlignedHourOffset:function(a){a=a?e(a).zone():0;return 0===(this.zone()-a)%60},daysInMonth:function(){var a=this.year(),b=this.month();return(new Date(Date.UTC(a,b+1,0))).getUTCDate()},dayOfYear:function(a){var b=w((e(this).startOf("day")-e(this).startOf("year"))/864E5)+1;return null==a?b:this.add("d",a-b)},quarter:function(){return Math.ceil((this.month()+1)/3)},weekYear:function(a){var b=A(this,this.lang()._week.dow,
this.lang()._week.doy).year;return null==a?b:this.add("y",a-b)},isoWeekYear:function(a){var b=A(this,1,4).year;return null==a?b:this.add("y",a-b)},week:function(a){var b=this.lang().week(this);return null==a?b:this.add("d",7*(a-b))},isoWeek:function(a){var b=A(this,1,4).week;return null==a?b:this.add("d",7*(a-b))},weekday:function(a){var b=(this.day()+7-this.lang()._week.dow)%7;return null==a?b:this.add("d",a-b)},isoWeekday:function(a){return null==a?this.day()||7:this.day(this.day()%7?a:a-7)},get:function(a){a=
l(a);return this[a]()},set:function(a,b){a=l(a);if("function"===typeof this[a])this[a](b);return this},lang:function(a){if(void 0===a)return this._lang;this._lang=p(a);return this}});for(j=0;j<P.length;j++)ka(P[j].toLowerCase().replace(/s$/,""),P[j]);ka("year","FullYear");e.fn.days=e.fn.day;e.fn.months=e.fn.month;e.fn.weeks=e.fn.week;e.fn.isoWeeks=e.fn.isoWeek;e.fn.toJSON=e.fn.toISOString;m(e.duration.fn=C.prototype,{_bubble:function(){var a=this._milliseconds,b=this._days,c=this._months,d=this._data;
d.milliseconds=a%1E3;a=s(a/1E3);d.seconds=a%60;a=s(a/60);d.minutes=a%60;a=s(a/60);d.hours=a%24;b+=s(a/24);d.days=b%30;c+=s(b/30);d.months=c%12;b=s(c/12);d.years=b},weeks:function(){return s(this.days()/7)},valueOf:function(){return this._milliseconds+864E5*this._days+2592E6*(this._months%12)+31536E6*h(this._months/12)},humanize:function(a){var b=+this,c;c=!a;var d=this.lang(),e=w(Math.abs(b)/1E3),i=w(e/60),g=w(i/60),h=w(g/24),j=w(h/365),e=45>e&&["s",e]||1===i&&["m"]||45>i&&["mm",i]||1===g&&["h"]||
22>g&&["hh",g]||1===h&&["d"]||25>=h&&["dd",h]||45>=h&&["M"]||345>h&&["MM",w(h/30)]||1===j&&["y"]||["yy",j];e[2]=c;e[3]=0<b;e[4]=d;c=Fa.apply({},e);a&&(c=this.lang().pastFuture(b,c));return this.lang().postformat(c)},add:function(a,b){var c=e.duration(a,b);this._milliseconds+=c._milliseconds;this._days+=c._days;this._months+=c._months;this._bubble();return this},subtract:function(a,b){var c=e.duration(a,b);this._milliseconds-=c._milliseconds;this._days-=c._days;this._months-=c._months;this._bubble();
return this},get:function(a){a=l(a);return this[a.toLowerCase()+"s"]()},as:function(a){a=l(a);return this["as"+a.charAt(0).toUpperCase()+a.slice(1)+"s"]()},lang:e.fn.lang,toIsoString:function(){var a=Math.abs(this.years()),b=Math.abs(this.months()),c=Math.abs(this.days()),d=Math.abs(this.hours()),e=Math.abs(this.minutes()),h=Math.abs(this.seconds()+this.milliseconds()/1E3);return!this.asSeconds()?"P0D":(0>this.asSeconds()?"-":"")+"P"+(a?a+"Y":"")+(b?b+"M":"")+(c?c+"D":"")+(d||e||h?"T":"")+(d?d+"H":
"")+(e?e+"M":"")+(h?h+"S":"")}});for(j in Q)Q.hasOwnProperty(j)&&(la(j,Q[j]),Ja(j.toLowerCase()));la("Weeks",6048E5);e.duration.fn.asMonths=function(){return(+this-31536E6*this.years())/2592E6+12*this.years()};e.lang("en",{ordinal:function(a){var b=a%10,b=1===h(a%100/10)?"th":1===b?"st":2===b?"nd":3===b?"rd":"th";return a+b}});Y?(module.exports=e,N(!0)):"function"===typeof define&&define.amd?define("moment",function(a,b,c){c.config&&(c.config()&&!0!==c.config().noGlobal)&&N(void 0===c.config().noGlobal);
return e}):N()}).call(this);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'confluence.web.resources:moment', location = '/includes/js/amd/shim/moment-amd.js' */
define("moment",function(){return moment});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'confluence.web.resources:date-time-formatting', location = '/includes/js/date-time-formatting.js' */
define("confluence/date-time-formatting",["ajs","moment"],function(c,g){var e={wholeMinutesBetween:function(a,b){return Math.floor((b.valueOf()-a.valueOf())/6E4)},roundedHoursBetween:function(a,b){return Math.round((b.valueOf()-a.valueOf())/36E5)},isYesterdayRelativeTo:function(a,b,c){a=new Date(a.valueOf()+c);b=new Date(b.valueOf()+c-864E5);return a.getUTCFullYear()==b.getUTCFullYear()&&a.getUTCMonth()==b.getUTCMonth()&&a.getUTCDate()==b.getUTCDate()},formatTime:function(a,b){return g(a.valueOf()+
b).utc().format("h:mm A")},formatDate:function(a,b){return g(a.valueOf()+b).utc().format("MMM DD, YYYY")},formatDateTime:function(a,b){return g(a.valueOf()+b).utc().format("MMM DD, YYYY HH:mm")},friendlyFormatDateTime:function(a,b,f){var d=b.valueOf()-a.valueOf();return 0>d?e.formatDateTime(a,f):0==d?"right now":4E3>d?"just a moment ago":6E4>d?"less than a minute ago":12E4>d?"a minute ago":3E6>d?c.format("{0} minutes ago",
e.wholeMinutesBetween(a,b)):54E5>d?"about an hour ago":18E6<d&&e.isYesterdayRelativeTo(a,b,f)?c.format("yesterday at {0}",e.formatTime(a,f)):864E5>d?c.format("about {0} hours ago",e.roundedHoursBetween(a,b)):e.formatDate(a,f)}};return e});require("confluence/module-exporter").exportModuleAsGlobal("confluence/date-time-formatting","AJS.DateTimeFormatting");
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:fileviewer-core', location = '/bower_components/atlassian-fileviewer/dist/fileviewer-templates.js' */
// This file was automatically generated from main_view.i18n.soy.
// Please don't edit this file by hand.

/**
 * @fileoverview Templates in namespace FileViewer.Templates.
 */

if (typeof FileViewer == 'undefined') { var FileViewer = {}; }
if (typeof FileViewer.Templates == 'undefined') { FileViewer.Templates = {}; }


FileViewer.Templates.fileView = function(opt_data, opt_ignored) {
  return '<div id="cp-header" class="aui-group"></div><div id="cp-body" class="aui-group"></div><div id="cp-footer"></div>';
};
if (goog.DEBUG) {
  FileViewer.Templates.fileView.soyTemplateName = 'FileViewer.Templates.fileView';
}


FileViewer.Templates.titleContainer = function(opt_data, opt_ignored) {
  return '<span class="' + soy.$$escapeHtml(opt_data.iconClass) + ' size-24 cp-file-icon"></span>' + soy.$$escapeHtml(opt_data.title);
};
if (goog.DEBUG) {
  FileViewer.Templates.titleContainer.soyTemplateName = 'FileViewer.Templates.titleContainer';
}


FileViewer.Templates.controlDownloadButton = function(opt_data, opt_ignored) {
  return '<a id="cp-control-panel-download" href="' + soy.$$escapeHtml(opt_data.src) + '" title="' + soy.$$escapeHtml("Download") + '" class="cp-icon" target="_blank" download></a>';
};
if (goog.DEBUG) {
  FileViewer.Templates.controlDownloadButton.soyTemplateName = 'FileViewer.Templates.controlDownloadButton';
}


FileViewer.Templates.controlCloseButton = function(opt_data, opt_ignored) {
  return '<a id="cp-control-panel-close" href="#" title="' + soy.$$escapeHtml("Close") + '" class="cp-icon"></a>';
};
if (goog.DEBUG) {
  FileViewer.Templates.controlCloseButton.soyTemplateName = 'FileViewer.Templates.controlCloseButton';
}


FileViewer.Templates.moreButton = function(opt_data, opt_ignored) {
  return '<a href="cp-more-menu" id="cp-control-panel-more" aria-owns="cp-more-menu" aria-haspopup="true" class="cp-icon aui-dropdown2-trigger aui-dropdown2-trigger-arrowless" title="' + soy.$$escapeHtml("More") + '">' + soy.$$escapeHtml("More") + '</a><div id="cp-more-menu" class="aui-dropdown2 aui-style-default"><ul class="aui-list-truncate"></ul></div>';
};
if (goog.DEBUG) {
  FileViewer.Templates.moreButton.soyTemplateName = 'FileViewer.Templates.moreButton';
}


FileViewer.Templates.moreMenuItem = function(opt_data, opt_ignored) {
  return '<li><a href="#">' + soy.$$escapeHtml(opt_data.text) + '</a></li>';
};
if (goog.DEBUG) {
  FileViewer.Templates.moreMenuItem.soyTemplateName = 'FileViewer.Templates.moreMenuItem';
}


FileViewer.Templates.fileComments = function(opt_data, opt_ignored) {
  return '<div id="cp-comments"/>';
};
if (goog.DEBUG) {
  FileViewer.Templates.fileComments.soyTemplateName = 'FileViewer.Templates.fileComments';
}


FileViewer.Templates.fileBodySpinner = function(opt_data, opt_ignored) {
  return '<div class="cp-spinner"></div>';
};
if (goog.DEBUG) {
  FileViewer.Templates.fileBodySpinner.soyTemplateName = 'FileViewer.Templates.fileBodySpinner';
}


FileViewer.Templates.fileBodyArrows = function(opt_data, opt_ignored) {
  return '<a href="#" class="cp-nav" id="cp-nav-left" disabled-title="' + soy.$$escapeHtml("You\'re viewing the least recent file") + '">' + soy.$$escapeHtml("Go to the previous file") + '</a><a href="#" class="cp-nav" id="cp-nav-right" disabled-title="' + soy.$$escapeHtml("You\'re viewing the most recent file") + '">' + soy.$$escapeHtml("Go to the next file") + '</a>';
};
if (goog.DEBUG) {
  FileViewer.Templates.fileBodyArrows.soyTemplateName = 'FileViewer.Templates.fileBodyArrows';
}
// This file was automatically generated from unknown-file-type-view.i18n.soy.
// Please don't edit this file by hand.

/**
 * @fileoverview Templates in namespace FileViewer.Templates.
 */

if (typeof FileViewer == 'undefined') { var FileViewer = {}; }
if (typeof FileViewer.Templates == 'undefined') { FileViewer.Templates = {}; }


FileViewer.Templates.unknownFileTypeViewer = function(opt_data, opt_ignored) {
  return '<div id="cp-unknown-file-type-view"><span class="file-icon size-96 ' + soy.$$escapeHtml(opt_data.iconClass) + '"></span><p class="title">' + soy.$$escapeHtml("We can\'t preview this file.") + '<br>' + soy.$$escapeHtml("You\'ll have to download the file to view it.") + '</p><a class="aui-button download-button" href="' + soy.$$escapeHtml(opt_data.src) + '" target="_blank" download><span class="aui-icon aui-icon-small icon-download"></span>' + soy.$$escapeHtml("Download") + '</a></div><span class="cp-baseline-extension"></span>';
};
if (goog.DEBUG) {
  FileViewer.Templates.unknownFileTypeViewer.soyTemplateName = 'FileViewer.Templates.unknownFileTypeViewer';
}
// This file was automatically generated from layers.i18n.soy.
// Please don't edit this file by hand.

/**
 * @fileoverview Templates in namespace FileViewer.Templates.
 */

if (typeof FileViewer == 'undefined') { var FileViewer = {}; }
if (typeof FileViewer.Templates == 'undefined') { FileViewer.Templates = {}; }


FileViewer.Templates.displayError = function(opt_data, opt_ignored) {
  return '<div id="cp-error-message">' + ((opt_data.icon) ? '<span class="file-icon size-96 ' + soy.$$escapeHtml(opt_data.icon) + '"></span>' : '<span class="file-icon size-96 cp-unknown-file-type-icon"></span>') + '<p class="title">' + soy.$$escapeHtml(opt_data.title) + '</p><p class="message">' + soy.$$escapeHtml(opt_data.message) + '</p>' + ((opt_data.srcBrowser) ? '<a class="aui-button download-button" href="' + soy.$$escapeHtml(opt_data.srcBrowser) + '" target="_blank"><span class="aui-icon aui-icon-small icon-download"></span>' + soy.$$escapeHtml("Open in browser") + '</a>' : '') + ((opt_data.srcDownload) ? '<a class="aui-button download-button" href="' + soy.$$escapeHtml(opt_data.srcDownload) + '" target="_blank" download><span class="aui-icon aui-icon-small icon-download"></span>' + soy.$$escapeHtml("Download") + '</a>' : '') + '</div><span class="cp-baseline-extension"></span>';
};
if (goog.DEBUG) {
  FileViewer.Templates.displayError.soyTemplateName = 'FileViewer.Templates.displayError';
}


FileViewer.Templates.passwordLayer = function(opt_data, opt_ignored) {
  return '<div id="cp-preview-password"><span class="cp-password-lock-icon"></span><div class="cp-password-base"><p class="title">' + soy.$$escapeHtml(opt_data.prompt) + '</p><input type="password" name="password" class="cp-password-input" placeholder="' + soy.$$escapeHtml("Password") + '" autocomplete="off"><button class="aui-button cp-password-button">' + soy.$$escapeHtml("OK") + '</button></div><div class="cp-password-fullscreen"><p class="title">' + soy.$$escapeHtml("This file is password protected.") + '</p><p class="message">' + soy.$$escapeHtml("Due to technical reasons you have to leave presentation mode to enter the password.") + '</p></div></div><span class="cp-baseline-extension"></span>';
};
if (goog.DEBUG) {
  FileViewer.Templates.passwordLayer.soyTemplateName = 'FileViewer.Templates.passwordLayer';
}


FileViewer.Templates.waitingMessage = function(opt_data, opt_ignored) {
  return '<div id="cp-waiting-message"><span class="file-icon size-96 cp-waiting-message-spinner"></span><p class="title">' + soy.$$escapeHtml(opt_data.header) + '</p><p class="message">' + soy.$$escapeHtml(opt_data.message) + '</p><a class="aui-button download-button" href="' + soy.$$escapeHtml(opt_data.src) + '" target="_blank" download><span class="aui-icon aui-icon-small icon-download"></span>' + soy.$$escapeHtml("Download") + '</a></div><span class="cp-baseline-extension"></span>';
};
if (goog.DEBUG) {
  FileViewer.Templates.waitingMessage.soyTemplateName = 'FileViewer.Templates.waitingMessage';
}


FileViewer.Templates.toolbar = function(opt_data, opt_ignored) {
  var output = '<div class="cp-toolbar">';
  var actionList55 = opt_data.actions;
  var actionListLen55 = actionList55.length;
  for (var actionIndex55 = 0; actionIndex55 < actionListLen55; actionIndex55++) {
    var actionData55 = actionList55[actionIndex55];
    output += '<a href="#" class="' + soy.$$escapeHtml(actionData55.className) + ' cp-icon" title="' + soy.$$escapeHtml(actionData55.title) + '">' + soy.$$escapeHtml(actionData55.title) + '</a>';
  }
  output += '</div>';
  return output;
};
if (goog.DEBUG) {
  FileViewer.Templates.toolbar.soyTemplateName = 'FileViewer.Templates.toolbar';
}

} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:fileviewer-core', location = '/bower_components/atlassian-fileviewer/dist/fileviewer.js' */
(function () {
    'use strict';

// holds module definitions used for setup and dependency tracking
var _modules = {};

// defines a new module with the given dependencies and factory function
var define = function (name, dependencies, factoryFn) {
    _modules[name] = {
      deps: dependencies,
      factory: factoryFn,
      value: null
    };
};

// recursively require module and its dependencies
// caches the results so that every module is instantiated only once
var require = function (name, mocks) {
    var module = require._normalizeMocks(mocks)[name] || _modules[name];
    if (!module) { throw new Error('module not found ' + name); }
    if (!module.value) {
      module.value = module.factory.apply(null, module.deps.map(function (name) {
        return require(name, mocks);
      }));
    }
    return module.value;
};

require._normalizeMocks = function (mocks) {
  if (!mocks) { return {}; }
  var normalizedMocks = {};
  Object.keys(mocks).forEach(function (key) {
    normalizedMocks[key] = {
      deps: [],
      factory: function () { return mocks[key]; },
      value: null
    };
  });
  return normalizedMocks;
};

// define FileViewer dependencies
define('jquery',     [], function () { return jQuery;   });
define('underscore', [], function () { return _;        });
define('backbone',   [], function () { return Backbone; });
define('ajs',        [], function () { return AJS;      });

define('Analytics', ['underscore'], function (_) {
    'use strict';

    /**
     * Augments data and forwards them to a configured analytics backend.
     *
     * An analytics backend is just a function that accepts a key and a data
     * object. It is also responsible for filtering incoming data.
     *
     * For all data send, this module fetches current file and view state
     * and adds them to the data. The added keys are
     * - fileType
     * - fileId (hashed version of the file src)
     * - fileState (value of view state)
     *
     * @param analyticsBackend
     * @param fileViewer
     * @param hasher
     * @returns {Analytics}
     * @constructor
     */
    var Analytics = function (backend, fileViewer, hasher) {
        this._backend = backend;
        this._fileViewer = fileViewer;
        this._hasher = hasher;
    };

    /**
     * Forwards an analytics event to the configured backend.
     * @param {string} key
     * @param {Object} data
     */
    Analytics.prototype.send = function (key, data) {
        if (!this._backend) { return; }
        var file = this._fileViewer.getCurrentFile();
        var attributes = (file && file.attributes) || {};
        var augmentedData = _.extend({
            fileType: attributes.type,
            fileId: this._hasher(attributes.src || ''),
            fileState: this._fileViewer.getView().getViewState()
        }, data);
        this._backend(key, augmentedData)
    };

    /**
     * Returns a partially applied analytics function for use inside of
     * promise handlers.
     * @param {string} key
     * @param {object} data
     * @returns {function}
     */
    Analytics.prototype.fn = function (key, data) {
        return this.send.bind(this, key, data);
    };

    return Analytics;
});




define('ArrowLayer', [
    'backbone', 'template-store-singleton'
], function (
    Backbone, templateStore
) {
    'use strict';

    /**
     * Controls to switch between multiple files in a collection.
     * @constructor
     */
    var ArrowLayer = Backbone.View.extend({

        className: 'cp-arrow-layer',

        events: {
            'click #cp-nav-left:not(.disabled)': 'gotoPrevious',
            'click #cp-nav-right:not(.disabled)': 'gotoNext'
        },

        initialize: function (options) {
            this._fileViewer = options.fileViewer;
            this.listenTo(this._fileViewer._fileState.collection, 'add reset', this.checkAndHideNavigation);
            this._visibleArrows = false;
            this._updateElements();
        },

        render: function () {
            this.$el.html(templateStore.get('fileBodyArrows')()).hide();
            this._updateElements();
            this.checkAndHideNavigation();

            this.$el.on("click", "a[href='#']", function(e) {
                e.preventDefault();
            });

            return this;
        },

        /**
         * Show next file in collection.
         */
        gotoNext: function () {
            this._fileViewer.showFileNext().always(
                this._fileViewer.analytics.fn('files.fileviewer-web.next', {
                    actionType: 'button',
                    mode: this._fileViewer.getMode()
                })
            );
        },

        /**
         * Show previous file in collection.
         */
        gotoPrevious: function () {
            this._fileViewer.showFilePrev().always(
                this._fileViewer.analytics.fn('files.fileviewer-web.prev', {
                    actionType: 'button',
                    mode: this._fileViewer.getMode()
                })
            );
        },

        /**
         * Enable disabled navigation arrow again and remove tooltip
         */
        enableArrow: function ($arrow) {
            $arrow.removeClass('disabled');
            $arrow.removeAttr('original-title');
        },

        /**
         * Disable navigation arrow and add tooltip
         * @param  {Object} options
         * @param  {Object} options.arrow
         * @param  {String} options.tooltipText
         * @param  {String} options.tooltipGravity
         */
        disableArrow: function (options) {
            options.arrow.addClass('disabled');
            options.arrow.attr('original-title', options.tooltipText);
            options.arrow.tooltip({ gravity: options.tooltipGravity });
        },

        /**
         * Returns true if either the left or right navigation arrow is shown
         * @return {Boolean}
         */
        showsArrow: function () {
            return this._visibleArrows;
        },

        /**
         * Check if controls should appear.
         * If there's only a single file in the collection, we don't show them.
         */
        checkAndHideNavigation: function () {
            if (this._fileViewer._fileState.collection.length <= 1) {
                this._visibleArrows = false;
                return this.$arrows.hide();
            }
            this.$arrows.show();
            this._visibleArrows = true;
            if (this._fileViewer.getConfig().enableListLoop) {
                return;
            }
            if (this._fileViewer.isShowingLastFile()) {
                this.disableArrow({
                    arrow: this.$arrowRight,
                    tooltipText: "You\'re viewing the most recent file",
                    tooltipGravity: 'e'
                });
            } else if (this._fileViewer.isShowingFirstFile()) {
                this.disableArrow({
                    arrow: this.$arrowLeft,
                    tooltipText: "You\'re viewing the least recent file",
                    tooltipGravity: 'w'
                });
            }
        },

        _updateElements: function () {
            this.$arrows = this.$el.find('.cp-nav');
            this.$arrowLeft = this.$el.find('#cp-nav-left');
            this.$arrowRight = this.$el.find('#cp-nav-right');
        }

    });

    return ArrowLayer;
});

define('assert',
    [],
    function() {

        /**
         * Throws an error if given predicate is falsy.
         *
         * @param {*} predicate
         * @param {string} description Used for the error message.
         */
        var assert = function (predicate, description) {
            description = description || 'untruthy value';

            if (!predicate) {
                throw new Error('Assertion failed: ' + description);
            }
        };

        return assert;
    }
);
define('asset-module-backend', [], function () {
    'use strict';

    return function (fileViewer) {

        /**
         * Assumes that all modules are included as static assets and therefore
         * already loaded. Uses FileViewer.getConfig().assets for the
         * module configuration.
         *
         * @param {String} moduleName
         * @return {Promise}
         */

        return function (moduleName) {
            if (moduleName === 'pdf-config') {
                return fileViewer.getConfig().assets['pdf-config'] || {};
            }
        };
    };

});
define('baseMode', ['jquery', 'keys'], function ($, keys) {
    'use strict';

    var baseMode = {

        activateHook: function (mainView) {
            mainView.$el.on('click #cp-file-body', mainView._onClickToBackground.bind(mainView));
            var $arrowLayer = mainView.fileContentView.getLayerForName('arrows').$el;
            $arrowLayer.toggle(this.showsArrowLayer);
        },

        deactivateHook: function (mainView) {
            mainView.$el.off('click #cp-file-body');
        },

        setup: function (mainView, viewer) {
            viewer && viewer.$el.on("click.contentView", viewer._clickedBackgroundToClose.bind(viewer));
            $(document).on('keydown.modeKeys', this._handleKeys.bind(mainView));
        },

        teardown: function (mainView, viewer) {
            viewer && viewer.$el.off("click.contentView");
            $(document).off('keydown.modeKeys');
        },

        showsArrowLayer: true,

        _handleKeys: function (e) {
            var contentView, viewer;

            if (this.fileContentView.isLayerInitialized('content')) {
                contentView = this.fileContentView.getLayerForName('content');
                viewer = contentView.getAttachedViewer();
            }

            if (!viewer || !(e.ctrlKey || e.metaKey)) { return; }

            if (e.which === keys.PLUS || e.which === keys.PLUS_NUMPAD || e.which === keys.PLUS_FF) {
                if (viewer.zoomIn) {
                    this._fileViewer.analytics.send('files.fileviewer-web.file.zoomin', {
                        actionType: 'hotkey'
                    });
                    viewer.zoomIn();
                }
                e.preventDefault();
            }

            if (e.which === keys.MINUS || e.which === keys.MINUS_NUMPAD || e.which === keys.MINUS_FF) {
                if (viewer.zoomOut) {
                    this._fileViewer.analytics.send('files.fileviewer-web.file.zoomout', {
                        actionType: 'hotkey'
                    });
                    viewer.zoomOut();
                }
                e.preventDefault();
            }

        },

        toolbarActions: [
            {
                title: "Zoom out",
                className: 'cp-toolbar-minus',
                predicate: function () {
                    return this._viewer && this._viewer.zoomOut;
                },
                handler: function () {
                    if (this._viewer && this._viewer.zoomOut) {
                        this._fileViewer.analytics.send('files.fileviewer-web.file.zoomout', {
                            actionType: 'button'
                        });
                        this._viewer.zoomOut();
                    }
                }
            },
            {
                title: "Zoom in",
                className: 'cp-toolbar-plus',
                predicate: function () {
                    return this._viewer && this._viewer.zoomIn;
                },
                handler: function () {
                    if (this._viewer && this._viewer.zoomIn) {
                        this._fileViewer.analytics.send('files.fileviewer-web.file.zoomin', {
                            actionType: 'button'
                        });
                        this._viewer.zoomIn();
                    }
                }
            },
            {
                title: "Fit to page width",
                className: 'cp-toolbar-fit',
                predicate: function () {
                    return this._viewer && this._viewer.zoomFit;
                },
                handler: function () {
                    if (this._viewer && this._viewer.zoomFit) {
                        this._fileViewer.analytics.send('files.fileviewer-web.file.fittowidth');
                        this._viewer.zoomFit();
                    }
                }
            },
            {
                title: "Start Presentation",
                className: 'cp-toolbar-presentation',
                predicate: function () {
                    return this._viewer && this._fileViewer.getConfig().enablePresentationMode;
                },
                handler: function () {
                    this._fileViewer.analytics.send('files.fileviewer-web.presentation.enter');
                    this._fileViewer.changeMode('PRESENTATION');
                }
            }
        ]
    };

    return baseMode;
});

define('BaseViewer', [
    'jquery', 'underscore', 'backbone'
], function ($, _, Backbone) {
    'use strict';

    /**
     * Base class for viewers.
     * @constructor
     */
    var BaseViewer = Backbone.View.extend({

        // Event listeners specific to this view namespaced to prevent collisions with its children.

        contentViewEvents: {
            'click.contentView': '_clickedBackgroundToClose',
            'mousedown.contentView': '_mousedownContentView'
        },

        // Merge events with children's event object to bind all event handlers

        initialize: function (options) {
            this.events = _.extend(this.events || {}, this.contentViewEvents);

            this._fileViewer = options.fileViewer;
            this._previewSrc = options.previewSrc;
            this._mousedownBackground = null;
        },

        teardown: function () {},

        // Listen to clicks to the background and eventually close the fileViewer.
        //
        // A viewer can specify getBackground if their background element isn't their contents

        _mousedownContentView: function (e) {
            var $background = this.getBackground ? this.getBackground() : this.$el;
            this._mousedownBackground = $(e.target).is($background);
        },

        _clickedBackgroundToClose: function (e) {
            // @TODO: Remove after cleaning modes setup, hooks etc.
            var mode = this._fileViewer._view._modes[this._fileViewer._view._mode];
            if (mode.disableClickBackgroundCloses) {
                return;
            }
            var $background = this.getBackground ? this.getBackground() : this.$el;
            if (this._mousedownBackground && $(e.target).is($background)){
                this._fileViewer.analytics.send('files.fileviewer-web.closed', {
                    actionType: 'element'
                });
                this._fileViewer.close();
            }
        },

        // This function is called whenever the viewport of the viewer changes size,
        // e.g. when a panel is opened or closed. Overwrite this function if you want
        // custom behaviour.
        handleResize: function () {}

    });

    return BaseViewer;
});

define('CloseButton', [
    'backbone', 'template-store-singleton'
], function (Backbone, templateStore) {
    'use strict';

    var CloseButton = Backbone.View.extend({

        className: 'fv-close-button',

        events: {
            'click': '_close'
        },

        tagName: 'span',

        initialize: function (options) {
            this._fileViewer = options.fileViewer;
        },

        render: function () {
            this.$el.html(templateStore.get('controlCloseButton')());

            this.$('a').tooltip({ gravity: 'n' });

            return this;
        },

        _close: function (e) {
            e.preventDefault();
            this._fileViewer.analytics.send('files.fileviewer-web.closed', {
                actionType: 'button'
            });
            this._fileViewer.close();
        }
    });

    return CloseButton;
});
define('defaultConfig', [], function() {
    /**
     * Current configuration options:
     * 
     * - appendTo {DOMNode} [$('body')] - DOM Element to append to
     * - enableListLoop {Boolean} [true] - Allow to navigate from end to start of file list and v.v.
     * - enablePresentationMode {Boolean} [true] - Allow switching to presentation mode
     * - files {Array} - File objects
     * - commentService {Object} - Comments service
     * - templateBackend {Function} - Provides templates for a given name
     * - moduleBackend {Function} - Provides modules for a given name
     * - pdfTransportFactory {Function} - cb(currentFile):Promise<PDFTransport>
     *
     * @exports defaultConfig
     */
    return {
        enableListLoop: true,
        enablePresentationMode: true,
        preloadImagesAfterCurrent: 2,
        preloadImagesBeforeCurrent: 0,
        viewers: ['image', 'document', 'video']
    };
});

define('constants-dictionary', [
    'assert'
], function (
    assert
) {
    'use strict';

    /**
     * A constants dictionary is a dictionary where you can only define a
     * given name once.
     */
    var ConstantsDictionary = function () {
        this._valuesByName = {};
        this._names = [];
    };

    /**
     * Define a name with the given value.
     * @param {string} name The name that is being defined.
     * @param {*} value Any value, even undefined.
     * @throws Error if name is already defined.
     */
    ConstantsDictionary.prototype.define = function (name, value) {
        assert(!this.isDefined(name), 'name is unique');
        this._valuesByName[name] = value;
        this._names.push(name);
    };

    /**
     * Lookup a name with the given value.
     * @param {string} name The name to lookup.
     * @throws Error if name is not yet defined.
     */
    ConstantsDictionary.prototype.lookup = function (name) {
        assert(this.isDefined(name), 'name is defined');
        return this._valuesByName[name];
    };

    /**
     * Check if a name is defined.
     * @param {string} name The name to check.
     * @return {boolean}
     */
    ConstantsDictionary.prototype.isDefined = function (name) {
        return name in this._valuesByName;
    };

    /**
     * Lists all definitions in the order they were defined. Returns an array of objects
     * with name and value properties.
     * @return {Array}
     */
    ConstantsDictionary.prototype.list = function () {
        return this._names.map(function (name) {
            return {
                name: name,
                value: this._valuesByName[name]
            };
        }, this);
    };

    return ConstantsDictionary;
});
define('djb2', [], function () {

    var toCharCode = function (str) { return str.charCodeAt(0); };
    var updateHash = function (prev, curr) { return ((prev << 5) + prev) + curr; };

    /**
     * Create a djb2 hash from the given string.
     * Based on this module https://github.com/wearefractal/djb2.
     * @param {String} str
     * @returns {Number}
     */
    var djb2 = function (str) {
        return str.split('').map(toCharCode).reduce(updateHash, 5381);
    };

    return djb2;
});
define('DownloadButton', [
    'backbone', 'template-store-singleton'
], function (Backbone, templateStore) {
    'use strict';

    var DownloadButton = Backbone.View.extend({

        tagName: 'span',

        events: {
            'click': '_triggerAnalytics'
        },

        initialize: function (options) {
            this._fileViewer = options.fileViewer;
            this._model = this._fileViewer.getCurrentFile();
        },

        render: function () {
            this.$el.html(templateStore.get('controlDownloadButton')({
                src: this._model.get('srcDownload') || this._model.get('src')
            }));

            this.$('a').tooltip({ gravity: 'n' });

            return this;
        },

        _triggerAnalytics: function () {
            this._fileViewer.trigger('fv.download');
            this._fileViewer.analytics.send('files.fileviewer-web.file.download', {
                actionType: 'button'
            });
        }

    }, {
        isDownloadable: function (fileViewer) {
            var file = fileViewer.getCurrentFile();
            return file && file.get('downloadable');
        }
    });

    return DownloadButton;
});

define('ErrorLayer', [
    'ajs', 'backbone', 'template-store-singleton'
], function (AJS, Backbone, templateStore) {
    'use strict';

    var ErrorLayer = Backbone.View.extend({

        className: 'cp-error-layer',

        initialize: function () {
            this.$el.hide();
        },

        showErrorMessage: function (err, file) {
            var title, description, icon, srcDownload, srcBrowser;
            title = err.title || "The file cannot be displayed";
            description = err.description || err.toString();
            icon = err.icon || false;
            srcBrowser = err.browser ? file.get('src') : false;
            srcDownload = err.download ? file.get('src') : false;
            this.$el.show().html(templateStore.get('displayError')({
                title: title,
                message: description,
                icon: icon,
                srcBrowser: srcBrowser,
                srcDownload: srcDownload
            }));
        }

    });

    return ErrorLayer;
});

define("file-state",
    [
        "backbone"
    ],
    function(
        Backbone
        ) {
        "use strict";

        var FileState = Backbone.Model.extend({

            defaults: {
                currentFileIndex: -1,
                isNewFileUploaded: false
            },

            setCollection: function(collection) {
                this.collection = collection;
            },

            setNext: function() {
                var currentFileIndex = this.get("currentFileIndex");
                if (currentFileIndex < (this.collection.length - 1)) {
                    this.set({currentFileIndex: this.get("currentFileIndex") + 1});
                } else {
                    this.set({currentFileIndex: 0});
                }
            },

            setPrev: function() {
                var currentFileIndex = this.get("currentFileIndex");
                if (currentFileIndex > 0) {
                    this.set({currentFileIndex: this.get("currentFileIndex") - 1});
                } else {
                    this.set({currentFileIndex: this.collection.length - 1});
                }
            },

            setNoCurrent: function () {
                this.set({ currentFileIndex: -1 });
            },

            setCurrentFileIndex: function(index) {
                if ((index > -1) && (index < this.collection.length)) {
                    return this.set({currentFileIndex: index});
                }
            },

            setCurrentWithCID: function(cid) {
                return this.setCurrentFileIndex(this.collection.getIndexWithCID(cid));
            },

            getCurrent: function() {
                var current = this.collection.at(this.get("currentFileIndex"));
                return (!!current) ? current : null;
            },

            selectWhere: function (selector) {
                if (selector) {
                    var selected = this.collection.findWhere(selector);
                    if (selected) {
                        this.setCurrentWithCID(selected.cid);
                    }
                } else if (this.collection.length >= 1) {
                    this.setCurrentFileIndex(0);
                }
            },

            replaceCurrent: function(file) {
                var idx = this.get("currentFileIndex");
                this.collection.remove(this.collection.at(idx));
                this.collection.add(file, {at: idx});
            }
            // hasFile or how to deal with non existing file?
        });

        return FileState;
    });
define("file-types", [
    ],
    function(
        ) {
        "use strict";

        var browserSupportedImageTypes = [
          "image/gif",
          "image/jpeg",
          "image/png",
          "image/svg+xml",
          "image/web",
          "image/bmp"
        ];

        var fileTypes = {
            isPDF: function (type) {
                var lowerType = type && type.toLowerCase() || "";
                return lowerType === "application/pdf";
            },

            isText: function (type) {
                var lowerType = type && type.toLowerCase() || "";
                return lowerType === "text/plain";
            },

            isCode: function (type) {
                var lowerType = type && type.toLowerCase() || "";
                return lowerType === "text/java"
                  || lowerType === "text/css"
                  || lowerType === "text/html"
                  || lowerType === "text/javascript"
                  || lowerType === "text/xml";
            },

            isMultimedia: function (type) {
                var lowerType = type && type.toLowerCase() || "";
                return /^video\/.*/i.test(type)
                  || /^audio\/.*/i.test(type)
                  || lowerType === "application/x-shockwave-flash"
                  || lowerType === "application/vnd.rn-realmedia"
                  || lowerType === "application/x-oleobject";
            },

            isArchive: function (type) {
                var lowerType = type && type.toLowerCase() || "";
                return lowerType === "application/zip"
                  || lowerType === "application/java-archive";
            },

            isImage: function (type) {
                return /^image\/.*/i.test(type);
            },

            isVideo: function (type) {
                var lowerType = type && type.toLowerCase() || "";
                return /^video\/.*/i.test(type) || lowerType === "video";
            },

            isAudio: function (type) {
                var lowerType = type && type.toLowerCase() || "";
                return /^audio\/.*/i.test(type) || lowerType === "audio";
            },

            isImageBrowserSupported: function (type) {
                return browserSupportedImageTypes.indexOf(type.toLowerCase()) !== -1;
            },

            isWordProcessing: function(type) {
                var lowerType = type && type.toLowerCase() || "";
                return lowerType === "application/msword"
                  || /^application\/vnd.ms-word.*/i.test(type)
                  || /^application\/vnd.openxmlformats-officedocument.wordprocessingml.*/i.test(type);
            },

            isSpreadsheet: function(type) {
                var lowerType = type && type.toLowerCase() || "";
                return lowerType === "application/msexcel"
                  || /^application\/vnd.ms-excel.*/i.test(type)
                  || /^application\/vnd.openxmlformats-officedocument.spreadsheet.*/i.test(type);
            },

            isPresentation: function(type) {
                var lowerType = type && type.toLowerCase() || "";
                return lowerType === "application/mspowerpoint"
                  || /^application\/vnd.ms-powerpoint.*/i.test(type)
                  || /^application\/vnd.openxmlformats-officedocument.presentationml.*/i.test(type);
            },

            matchAll: function () { return true; }
        };

        return fileTypes;
    });
define('file-viewer', [
    'jquery',
    'underscore',
    'backbone',
    'assert',
    'constants-dictionary',
    'MainView',
    'file-state',
    'files',
    'file',
    'soy-template-backend',
    'asset-module-backend',
    'template-store-singleton',
    'module-store-singleton',
    'viewer-registry',
    'file-types',
    'defaultConfig',
    'image-view-provider',
    'pdf-view-provider',
    'video-view-provider',
    'unknown-file-type-view-provider',
    'Analytics',
    'djb2'
],
/**
 * FileViewer is a pluggable utility to view files in your app. This module
 * provides the central object you need to interact with.
 */
function (
    $,
    _,
    Backbone,
    assert,
    ConstantsDictionary,
    MainView,
    FileState,
    Files,
    File,
    soyTemplateBackend,
    assetModuleBackend,
    templateStore,
    moduleStore,
    ViewerRegistry,
    fileTypes,
    defaultConfig,
    imageViewProvider,
    pdfViewProvider,
    videoViewProvider,
    unknownFileTypeViewProvider,
    Analytics,
    djb2
) {
    'use strict';

    /**
     * Core API to integrate FileViewer into a project.
     * @class
     * @param {object} config
     * @throws Error if config is invalid
     */
    var FileViewer = function (config) {
        config = _.defaults(config || {}, defaultConfig);
        config.appendTo = config.appendTo || $('body');

        templateStore.useBackend(config.templateBackend || soyTemplateBackend(this));
        moduleStore.useBackend(config.moduleBackend || assetModuleBackend(this));

        this._config = config;
        this._properties = new Backbone.Model();

        this._fileState = new FileState();
        this._viewerRegistry = new ViewerRegistry();
        this._analytics = new Analytics(config.analyticsBackend, this, djb2);

        if (config.viewers.indexOf('image') !== -1) {
            this._viewerRegistry.register(fileTypes.isImageBrowserSupported, imageViewProvider, 0);
        }
        if (config.viewers.indexOf('document') !== -1) {
            this._viewerRegistry.register(fileTypes.isPDF, pdfViewProvider, 0);
        }
        if (config.viewers.indexOf('video') !== -1) {
            this._viewerRegistry.register(fileTypes.isMultimedia, videoViewProvider, 0);
        }

        // set fallback viewer
        this._viewerRegistry.register(fileTypes.matchAll, unknownFileTypeViewProvider, 100);

        this._files = new Files(config.files || [], {
            service: config.commentService
        });
        this._fileState.setCollection(this._files);

        this._view = new MainView({ fileViewer: this });

        this._isOpen = false;

        FileViewer._plugins.list()
            .map(function (definition) { return definition.value; })
            .forEach(function (plugin) { plugin(this); }, this);
    };

    // privately expose available modules for debugging purposes
    FileViewer._modules = _modules;

    /**
     * Define a new module for the use with FileViewer.require().
     * Be careful with the naming, because module names can be overwritten.
     * @method
     * @param {String} moduleName
     * @param {Array} dependencies
     * @param {Function} factory
     */
    FileViewer.define = define;

    /**
     * Require a previously defined module by name.
     * @method
     * @param {String} moduleName
     * @return {*}
     */
    FileViewer.require = require;

    // Keeps track of registered plugins
    FileViewer._plugins = new ConstantsDictionary();

    FileViewer.VERSION = 'v1.2.1';

    /**
     * Register a new plugin for use with FileViewer.
     * @param {string} name
     * @param {function} plugin
     * @throws Error if plugin is invalid or name already exists.
     */
    FileViewer.registerPlugin = function (name, plugin) {
        assert(this.isPlugin(plugin), 'is a plugin');
        this._plugins.define(name, plugin);
    };

    /**
     * Returns if a plugin is enabled for use with FileViewer.
     * @param {string} name
     */
    FileViewer.isPluginEnabled = function (name) {
        return this._plugins.isDefined(name);
    };

    /**
     * Gets a plugin registered for use with FileViewer.
     * @param {string} name
     * @throws Error if plugin is invalid or name does not already exists.
     */
    FileViewer.getPlugin = function (name) {
        return this._plugins.lookup(name);
    };

    /**
     * Checks if the given object is a valid plugin.
     * @param {*} potentialPlugin
     * @return {boolean}
     */
    FileViewer.isPlugin = function (potentialPlugin) {
        return _.isFunction(potentialPlugin);
    };

    /**
     * Open this instance of FileViewer by appending it to the configured element. This needs to be called
     * before showing a file.
     *
     * When a fileQuery object is passed in, this file is shown and a special analytics event is triggered.
     * When you want to record, where this interaction is comming from, pass in
     * an additional analyticsSource
     *
     * @param {object} [fileQuery]
     * @param {string} [analyticsSource]
     * @fires fv.open
     */
    FileViewer.prototype.open = function (fileQuery, analyticsSource) {
        this._view.render().show().$el.appendTo(this._config.appendTo);
        this._view.delegateEvents();

        this._isOpen = true;
        this.trigger('fv.open');

        if (fileQuery) {
            this.showFileWithQuery(fileQuery).always(
                this.analytics.fn('files.fileviewer-web.opened', {source: analyticsSource})
            );
        }
    };

    /**
     * Shut down this instance of FileViewer by removing it from the configured element. Reset current file.
     *
     * @fires fv.close
     */
    FileViewer.prototype.close = function () {
        this._view._currentFile = null;
        this._view.undelegateEvents();
        this._view
            .hide()
            .$el.remove();

        this._isOpen = false;
        this.trigger('fv.close');
    };

    /**
     * Check if FileViewer is currently open.
     * @returns {boolean}
     */
    FileViewer.prototype.isOpen = function () {
        return this._isOpen;
    };

    /**
     * Return the current mode.
     * @returns {string}
     */
    FileViewer.prototype.getMode = function () {
        return this._view.getMode();
    };

    /**
     * Check if FileViewer is in the given mode.
     * @param {string} mode either 'BASE' or 'PRESENTATION'
     * @returns {boolean}
     */
    FileViewer.prototype.isInMode = function (mode) {
        return this._view.isInMode(mode);
    };

    /**
     * Change current view mode to the given mode.
     * @param {string} mode either 'BASE' or 'PRESENTATION'
     * @fires fv.changeMode
     */
    FileViewer.prototype.changeMode = function (mode) {
        this._view.setupMode(mode);
        this.trigger('fv.changeMode', mode);
    };

    /**
     * Check if current file is the first one in the files collection.
     * @return {Boolean}
     */
    FileViewer.prototype.isShowingFirstFile = function () {
        return this._fileState.attributes.currentFileIndex === 0;
    };

    /**
     * Check if current file is the last one in the files collection.
     * @return {Boolean}
     */
    FileViewer.prototype.isShowingLastFile = function () {
        return this._fileState.collection.length ===
            this._fileState.attributes.currentFileIndex + 1;
    };

    /**
     * Show the given file.
     *
     * THIS METHOD WILL NOT CHANGE THE STATE OF THE CURRENT FILE AND SHOULD NOT
     * BE CALLED DIRECTLY ANYMORE. CONSIDER IT AS A PRIVATE METHOD.
     *
     * @param {File} file
     * @return {Promise<file>} given file if a proper viewer was created.
     * @fires fv.showFile(file) after the viewer is created
     * @deprecated
     */
    FileViewer.prototype.showFile = function (file) {
        assert(this._isOpen, 'FileViewer is open');
        var triggerEvent = function (event) {
            return function () {
                this.trigger(event, file);
            }.bind(this);
        }.bind(this);
        this.trigger('fv.changeFile', file);
        return this._view.showFile(file)
          .done(triggerEvent("fv.showFile"))
          .fail(triggerEvent("fv.showFileError"));
    };

    /**
     * Returns the file being shown in this viewer.
     * @return {File} the file being shown
     */
    FileViewer.prototype.getCurrentFile = function() {
        // this file may not be the same as in fileState, e.g., a different version of file
        return this._view.getCurrentFile();
    };

    /**
     * ShowFile utility method; Show the first file matching the given selector. If no selector
     * given, it shows the first file in the collection.
     */
    FileViewer.prototype.showFileWhere = function (selector) {
        this._fileState.selectWhere(selector);
        return this.showFile(this._fileState.getCurrent());
    };

    /**
     * ShowFile utility method; Show the file matching the given backbone object id.
     * @todo remove this method
     */
    FileViewer.prototype.showFileWithCID = function (cid) {
        this._fileState.setCurrentWithCID(cid);
        return this.showFile(this._fileState.getCurrent());
    };

    /**
     * ShowFile utility method; Show the file matching the given id.
     * @todo remove this method
     */
    FileViewer.prototype.showFileWithId = function (id, ownerId) {
        var fileQuery = { id: id };

        if (ownerId) { fileQuery.ownerId = ownerId; }

        return this.showFileWithQuery(fileQuery);
    };

    /**
     * ShowFile utility method.  Show file with matching URL.  Used for
     * showing files that don't have an id (e.g. web images).
     */
    FileViewer.prototype.showFileWithSrc = function (src) {
        var fileQuery = { src: src };

        return this.showFileWithQuery(fileQuery);
    };

    /**
     * Check if the FileViewer supports native rendering of a given content type.
     * @param {string} contentType the content type to check if supported
     * @return {boolean} if it's supported
     */
    FileViewer.prototype.supports = function (contentType) {
        var previewer = this._viewerRegistry.get(contentType);
        return previewer && previewer !== unknownFileTypeViewProvider;
    };

    /**
     * ShowFile utility method.  Show file that matches the given attribute query.
     */
    FileViewer.prototype.showFileWithQuery = function (query) {
        var file = this._fileState.collection.findWhere(query);

        if (file) {
            this._fileState.setCurrentWithCID(file.cid);
        } else {
            this._fileState.setNoCurrent();
        }

        return this.showFile(file);
    };

    /*
     * ShowFile utility method; Show the next file in the collection.
     */
    FileViewer.prototype.showFileNext = function () {
        if (this.isShowingLastFile() && !this.getConfig().enableListLoop) {
            return $.when();
        }
        this._fileState.setNext();
        return this.showFile(this._fileState.getCurrent());
    };

    /*
     * ShowFile utility method; Show the previous file in the collection.
     */
    FileViewer.prototype.showFilePrev = function () {
        if (this.isShowingFirstFile() && !this.getConfig().enableListLoop) {
            return $.when();
        }
        this._fileState.setPrev();
        return this.showFile(this._fileState.getCurrent());
    };

    /**
     * Set the files in the FileViewer collection.
     *
     * This doesn't re-render the current file. If the file being shown is not
     * in the collection anymore, it will still be shown.
     * @param {array} files
     * @fires fv.updateFiles
     */
    FileViewer.prototype.updateFiles = function (files, matcher) {
        if (!(matcher && _.isFunction(matcher))) {
                this._files.reset(files);
        } else {
            var newModels = _.chain(files)
                .map(function (file) {
                    var matchedModel = this._files.find(function (collectionModel) {
                        return matcher(collectionModel.toJSON()) === matcher(file);
                    });
                    if (matchedModel) {
                        matchedModel.set(file);
                    } else {
                        return new File(file);
                    }
                }.bind(this))
                .compact()
                .value();

            this._files.add(newModels, {silent: true});
            this._files.trigger('reset', this._files);
        }

        this.trigger('fv.updateFiles');

        return this._files.toJSON();
    };

    /**
     * Support .on(), .off() and .trigger().
     */
    _.extend(FileViewer.prototype, Backbone.Events);

    /**
     * Returns the central view of FileViewer.
     * @return {MainView}
     *
     * @too kind of confusing, someone might expect it to return various views by name
     */
    FileViewer.prototype.getView = function () {
        return this._view;
    };

    /**
     * Returns the specified config.
     * @return {object}
     */
    FileViewer.prototype.getConfig = function () {
        return this._config;
    };

    /**
     * Returns the current files collection.
     * @return {array}
     */
    FileViewer.prototype.getFiles = function () {
        return this._files.toJSON();
    };

    /**
     * Add a file action to the viewer. These actions can be registered
     * asynchronously, and are reset when the user navigates to a new file.
     * Commonly, a plugin will listen to the change file event and register a file action
     * conditionally for the displayed file. If a file action shares a key with a file
     * action that currently exists, addFileAction will replace the old action with the
     * new action.
     *
     * Current configuration options:
     * 'key' Unique identifier for the file action
     * 'text' {String} the text display in the menu item
     * 'callback' {function} a callback to be called when the menu item is selected
     *
     * @param {object} opts
     * @throws Error if config is invalid or if no file is currently being viewed
     */
    FileViewer.prototype.addFileAction = function (opts) {
        assert(opts.key, 'has key');
        assert(opts.text, 'has text');
        assert(opts.callback, 'has a callback');
        this._view.fileControlsView.getLayerForName('moreButton').addFileAction(opts);
    };

    /**
     * Remove a file action from the viewer based on the key sent in the parameter
     *
     * Current configuration options:
     * 'key' Unique identifier for the file action you want to remove
     *
     * @param {object} opts
     * @throws Error if no key is provided or if no file is currently being viewed
     */
    FileViewer.prototype.removeFileAction = function (opts) {
        assert(opts.key, 'has key');
        this._view.fileControlsView.getLayerForName('moreButton').removeFileAction(opts);
    };

    /**
     * Allows non-core code to get and set their own values on an instance of FileViewer.
     *
     * @param {String} key
     * @param {*} value
     */
    FileViewer.prototype.set = function (key, value) {
        this._properties.set(key, value);
    };

    /**
     * Access plugin level properties.
     *
     * @param {String} key
     * @return {*}
     */
    FileViewer.prototype.get = function (key) {
        return this._properties.get(key);
    };

    /**
     * Instance of the analytics module, use this to send analytics from
     * your plugins.
     */
    Object.defineProperty(FileViewer.prototype, 'analytics', {
        get: function () { return this._analytics; }
    });

    return FileViewer;
});

define("file",
    [
        "backbone"
    ],
    function(
        Backbone
        ) {
        "use strict";

    var File = Backbone.Model.extend({
        defaults: {
            src: '',
            type: '',
            thumbnail: '',
            poster: '',
            title: '',
            downloadable: true
        }
    });

    return File;
});

define("files",
    [
        "backbone",
        "underscore",
        "file"
    ],
    function(
        Backbone,
        _,
        File) {

        "use strict";

        var Files = Backbone.Collection.extend({
            model: File,

            comparator: 'rank',

            getIndexWithCID: function(cid) {
                return this.indexOf(this.get({cid: cid}));
            }
        });

        return Files;

});
define("icon-utils", [
      "file-types"
  ],
  function (fileTypes) {
      "use strict";

      var iconUtils = {
          getCssClass: function (type) {
              var iconClass = "cp-unknown-file-type-icon";
              if (fileTypes.isImage(type)) {
                  iconClass = "cp-image-icon";
              } else if (fileTypes.isPDF(type)) {
                  iconClass = "cp-pdf-icon";
              } else if (fileTypes.isWordProcessing(type)) {
                  iconClass = "cp-document-icon";
              } else if (fileTypes.isSpreadsheet(type)) {
                  iconClass = "cp-spreadsheet-icon";
              } else if (fileTypes.isPresentation(type)) {
                  iconClass = "cp-presentation-icon";
              } else if (fileTypes.isText(type)) {
                  iconClass = "cp-text-icon";
              } else if (fileTypes.isCode(type)) {
                  iconClass = "cp-code-icon";
              } else if (fileTypes.isMultimedia(type)) {
                  iconClass = "cp-multimedia-icon";
              } else if (fileTypes.isArchive(type)) {
                  iconClass = "cp-archive-icon";
              }
              return iconClass;
          }
      };
      return iconUtils;
  });
define('image-view-provider', [
    'jquery',
    'file'
], function (
    $,
    File
) {
    'use strict';

    /**
     * Returns an image viewer.
     * @returns {Promise}
     */
    var imageViewProvider = function () {
        return $.Deferred().resolve(require('image-view'));
    };

    return imageViewProvider;
});
define('instance-manager',
    ['jquery'],
    function ($) {
        'use strict';

        /**
         * Ensures that there's only a single instance at the same time.
         * Accepts a createFn that is invoked and whose return value is
         * used as the instance.
         * @constructor
         * @param {Function} createFn
         * @param {Function} destroyFn
         */
        var InstanceManager = function (createFn, destroyFn) {
            this._createFn = createFn;
            this._destroyFn = destroyFn;
            this._instance = null;
            this._destroyDeferred = null;
        };

        /**
         * Promise a new instance. Resolves as soon as the previous one
         * is destroyed.
         * @return {Promise<Object>}
         */
        InstanceManager.prototype.create = function () {
            var args = arguments;
            var d = new $.Deferred();
            var destroyPromise = (this._destroyDeferred && this._destroyDeferred.promise()) || $.when();

            destroyPromise.then(function () {
                this._destroyDeferred = new $.Deferred();
                this._instance = this._createFn.apply(this._createFn, args);
                d.resolve(this._instance);
            }.bind(this));

            return d.promise();
        };

        /**
         * Destroy the current instance and unlock instance creation.
         */
        InstanceManager.prototype.destroy = function () {
            if (!this._destroyDeferred) {
                return;
            }
            this._destroyFn(this._instance);
            this._destroyDeferred.resolve();
        };

        return InstanceManager;

    }
);

define('keys', [], function() {
    return {
        F: 70,
        G: 71,
        P: 80,
        RETURN: 13,
        ESCAPE: 27,
        ARROW_LEFT: 37,
        ARROW_UP: 38,
        ARROW_RIGHT: 39,
        ARROW_DOWN: 40,
        PLUS: 187,
        MINUS: 189,
        PLUS_NUMPAD: 107,
        MINUS_NUMPAD: 109,
        PLUS_FF: 61,
        MINUS_FF: 173,
        SPACE: 32,
        ENTER: 13
    };
});

define('layer-container-view', [
    'underscore',
    'backbone',
    'assert',
    'constants-dictionary'
], function (
    _,
    Backbone,
    assert,
    ConstantsDictionary
) {
    'use strict';

    // utility functions for working with layers

    var invoke = function (fn) {
        return fn();
    };

    var pick = function (property, obj) {
        return obj[property];
    };

    var pickBoundFn = function (property, obj) {
        return _.isFunction(obj[property]) && obj[property].bind(obj);
    };

    /**
     * This view manages a collection of views which can be registered with a
     * given name. This view manages the lifecycle of its subviews.
     *
     * Subviews are always the View objects themselves, not instances of them.
     *
     * Subviews have two different states: ADDED and INITIALIZED. Whenever a
     * view is registered, it starts in state ADDED and stays there until
     * #initializeLayers() is called. Then it moves to INITIALIZED and stays
     * there until #teardownLayers() is called.
     *
     * When #render() is called on the collection, only INITIALIZED subviews are
     * rendered. Subviews can provide a teardown method that will be called
     * once the view is removed.
     *
     * Optionally, you can register subviews with a predicate to tell which
     * filetypes they support. It is invoked whenever the subviews are
     * initialized.
     */
    var FileContentLayerView = Backbone.View.extend({

        /**
         * @constructor
         * @param {object} options
         */
        initialize: function (options) {
            this._layerViewsByName = new ConstantsDictionary();
            this._layerViewRegistrations = [];
            this._layers = null;
            this._fileViewer = options.fileViewer;
        },

        /**
         * Checks if a layer with the given name exists.
         * @param {string} name
         * @return {bool}
         */
        hasLayerView: function (name) {
            return this._layerViewsByName.isDefined(name);
        },

        /**
         * Adds a view as a layer with a certain, unique name. Accepts an
         * options object as third parameter.
         *
         * Keys in options:
         *  - {function} [predicate] invoked at construction
         *  - {int} [weight=0] sorts layers at construction
         *
         * @param {string} name
         * @param {Backbone.View} LayerView
         * @param {object} [options]
         * @throws Error if name is already used.
         */
        addLayerView: function (name, LayerView, options) {
            assert(!this.hasLayerView(name), 'name is unique');

            options = _.extend({
                predicate: function () { return true; },
                weight: 0
            }, options);

            this._layerViewsByName.define(name, LayerView);
            this._layerViewRegistrations.push({
                LayerView: LayerView,
                name: name,
                predicate: options.predicate,
                weight: options.weight
            });
        },

        /**
         * Checks wether layers are currently initialized.
         * @return {bool}
         */
        areLayersInitialized: function () {
            return this._layers !== null;
        },

        /**
         * Return the number of initialized layers (after applying the predicate)/
         * @return {Integer}
         */
        countInitializedLayers: function () {
            return (this._layers || []).length;
        },

        /**
         * Initializes all currently registered layers.
         * @fires initializeLayers
         * @throws Error if layers are already initialized
         */
        initializeLayers: function () {
            this.initializeLayerSubset(_.pluck(this._layerViewRegistrations, 'name'));
        },

        /**
         * Initializes the given registered layers.
         * @param {array} names
         * @fires initializeLayers
         * @throws Error if layers are already initialized
         */
        initializeLayerSubset: function (names) {
            assert(!this.areLayersInitialized(), 'layers are uninitialized');

            this._layers = this._layerViewRegistrations
                                .filter(function (registration) {
                                    var isInSubset = (names.indexOf(registration.name) !== -1);
                                    return isInSubset && registration.predicate(this._fileViewer);
                                }, this)
                                .map(function (registration) {
                                    var view = new registration.LayerView({
                                        contentLayerView: this,
                                        fileViewer: this._fileViewer
                                    });
                                    return {
                                        view: view,
                                        name: registration.name,
                                        weight: registration.weight
                                    };
                                }, this);

            // sort by weight using the stable _.sortBy function to keep
            // registration order for same weights
            this._layers = _.sortBy(this._layers, function (layer) {
                return layer.weight * -1;
            });

            this.trigger('initializeLayers');

            this.render();
        },

        /**
         * Tears initialized layers down and removes them.
         * Won't throw if layers are not initialized.
         * @fires teardownLayers
         */
        teardownLayers: function () {
            if (this.areLayersInitialized()) {
                this._layers.map(_.partial(pick, 'view'))
                            .map(_.partial(pickBoundFn, 'teardown'))
                            .filter(_.isFunction)
                            .forEach(invoke);

                this._layers.map(_.partial(pick, 'view'))
                            .map(_.partial(pickBoundFn, 'remove'))
                            .filter(_.isFunction)
                            .forEach(invoke);

                this._layers = null;
            }

            this.trigger('teardownLayers');

            this.render();
        },

        /**
         * Utitily method. Calls teardownLayers() followed by initializeLayers().
         */
        reinitializeLayers: function () {
            this.teardownLayers();
            this.initializeLayers();
        },

        /**
         * Checks wether a layer with the given name is currently initialized.
         * @param {string} name
         * @return {bool}
         */
        isLayerInitialized: function (name) {
            if (!this.areLayersInitialized()) { return false; }

            return _.find(this._layers, function (layer) {
                return layer.name === name;
            }) ? true : false;
        },

        /**
         * Returns the instanciated LayerView object for the given name.
         * @param {string} name Name of the registered LayerView.
         * @return {layerView}
         * @throws {Error} if layer is not initialized
         */
        getLayerForName: function (name) {
            assert(this.areLayersInitialized(), 'layers are initialized');
            assert(this.hasLayerView(name), 'layer is defined');

            var layer = _.find(this._layers, function (layer) {
                return layer.name === name;
            });

            assert(layer, 'layer is initialized');

            return layer.view;
        },

        /**
         * Renders initialized layers.
         * Won't throw if layers are not initialized.
         * @fires renderLayers
         */
        render: function () {
            this.$el.empty();

            if (this.areLayersInitialized()) {
                this._layers.map(_.partial(pick, 'view'))
                            .map(_.partial(pickBoundFn, 'render'))
                            .forEach(invoke);

                this._layers.map(_.partial(pick, 'view'))
                            .map(_.partial(pick, '$el'))
                            .forEach(function ($layer) {
                                this.$el.append($layer);
                            }, this);
            }

            this.trigger('renderLayers');

            return this;
        }

    });

    return FileContentLayerView;
});
define("MainView",
    [
        "ajs",
        "backbone",
        "underscore",
        "jquery",
        "files",
        "file",
        "TitleView",
        "DownloadButton",
        "CloseButton",
        "MoreButton",
        "ViewerLayer",
        "panel-container-view",
        "layer-container-view",
        "ErrorLayer",
        "WaitingLayer",
        "PasswordLayer",
        "ArrowLayer",
        "ToolbarLayer",
        "SpinnerLayer",
        "template-store-singleton",
        "keys",
        "baseMode",
        "presentationMode"
    ],
    function(
        AJS,
        Backbone,
        _,
        $,
        Files,
        File,
        TitleView,
        DownloadButton,
        CloseButton,
        MoreButton,
        ViewerLayer,
        PanelContainerView,
        LayerContainerView,
        ErrorLayer,
        WaitingLayer,
        PasswordLayer,
        ArrowLayer,
        ToolbarLayer,
        SpinnerLayer,
        templateStore,
        keys,
        baseMode,
        presentationMode
    ) {
        "use strict";

        var rejectWithError = function (msg) {
            return new $.Deferred().reject(
                new Error(msg)
            ).promise();
        };

        /**
         * Core view of FileViewer.
         * @constructor
         * @param {Object} params
         */
        var MainView = Backbone.View.extend({

            id: "cp-container",

            initialize: function (params) {
                var options = _.extend({}, params);

                this._fileViewer = options.fileViewer;
                this._currentFile = null;
                this._viewState = null;

                this.$el.attr({
                    "role": "dialog",
                    "aria-labelledby": "cp-title-container"
                });

                this.fileTitleView = new PanelContainerView({
                    fileViewer: this._fileViewer,
                    id: "cp-title-container",
                    className: "aui-item"
                });

                this.fileControlsView = new LayerContainerView({
                    fileViewer: this._fileViewer,
                    id: "cp-file-controls",
                    className: "aui-item"
                });

                this.fileMetaView = new LayerContainerView({
                    fileViewer: this._fileViewer,
                    id: "cp-meta"
                });

                this.fileSinkView = new PanelContainerView({
                    id: 'cp-sink',
                    collection: this._fileViewer._fileState.collection,
                    fileViewer: this._fileViewer
                });

                this.fileSidebarView = new PanelContainerView({
                    id: "cp-sidebar",
                    fileViewer: this._fileViewer,
                    collection: this._fileViewer._fileState.collection
                });

                this.fileContentView = new LayerContainerView({
                    id: 'cp-file-body',
                    fileViewer: this._fileViewer
                });

                this.fileTitleView.addPanelView('title', TitleView);
                this.fileControlsView.addLayerView('downloadButton', DownloadButton, {
                    weight: 10,
                    predicate: DownloadButton.isDownloadable
                });
                this.fileControlsView.addLayerView('moreButton', MoreButton);
                this.fileControlsView.addLayerView('closeButton', CloseButton);
                this.fileContentView.addLayerView('content', ViewerLayer);
                this.fileContentView.addLayerView('error', ErrorLayer);
                this.fileContentView.addLayerView('password', PasswordLayer);
                this.fileContentView.addLayerView('toolbar', ToolbarLayer);
                this.fileContentView.addLayerView('waiting', WaitingLayer);
                this.fileContentView.addLayerView('spinner', SpinnerLayer);
                this.fileContentView.addLayerView('arrows', ArrowLayer);

                this.listenTo(this.fileSidebarView, 'togglePanel', this._updateContentWidth);
                this.listenTo(this.fileSinkView, 'togglePanel', this._updateContentHeight);

                this._navigationKeyLockCount = 0;
                this._showFileChain = $.when();

                this._mode = 'BASE';
                this._modes = {
                    'BASE': baseMode,
                    'PRESENTATION': presentationMode
                };

                this._fixTooltipCleanup();
            },

            /**
             * Show.
             * @return {MainView} this
             */
            show: function() {
                this.$el.show();
                $("body").addClass("no-scroll");

                $(document).on('keydown.disableDefaultKeys', this._disableKeyboardShortcuts.bind(this));
                $(document).on('keydown.navKeys', this._handleNavigationKeys.bind(this));

                return this;
            },

            /**
             * Hide.
             * @return {MainView} this
             */
            hide: function() {
                this.$el.hide();
                $("body").removeClass("no-scroll");

                $(document).off('keydown.disableDefaultKeys');
                $(document).off('keydown.navKeys');
                $(document).off('keydown.modeKeys');

                this._deactivateModeHook();
                this._modes[this._mode].teardown(this);
                this._teardownAll();

                return this;
            },

            /**
             * Render.
             * @return {MainView} this
             */
            render: function () {
                this.$el.empty().append(templateStore.get('fileView')());

                this.$header = this.$('#cp-header');
                this.$body = this.$('#cp-body');
                this.$footer = this.$('#cp-footer');

                this.$title = this.fileTitleView.render().$el.appendTo(this.$header);
                this.$controls = this.fileControlsView.render().$el.appendTo(this.$header);

                this.$content = this.fileContentView.render().$el.appendTo(this.$body);
                this.$sidebar = this.fileSidebarView.render().$el.appendTo(this.$body);

                this.$meta = this.fileMetaView.render().$el.appendTo(this.$footer);
                this.$sink = this.fileSinkView.render().$el.appendTo(this.$footer);

                this.$el.on("click", "a[href='#']", function (e) {
                    e.preventDefault();
                });

                return this;
            },

            /**
             * Show the given file. If one of the following conditions is true
             *
             *   1. file is invalid
             *   2. no viewer for that fileType is registered
             *   3. the viewer code can't be loaded
             *   4. the viewer couldn't be created
             *
             * then the returned promise is rejected. In that case, fileView changes
             * state and displays the error internally.
             *
             * @param {File} file
             * @return {Promise<File>} the given file
             */
            showFile: function (file) {

                var contentView, toolbarView, spinnerView, waitingView, errorView;

                // allow people to shut down themselves
                this.trigger('cancelShow');

                var fileViewed = new $.Deferred();

                this._showFileChain.pipe(function () {
                    var fileHandled = new $.Deferred();
                    $.when().pipe(function validateFile () {

                        this._currentFile = file;
                        this._viewState = null;
                        var validationResult;

                        if (file) {
                            this.trigger("fv.fileChange", file);
                            this._reinitializeAllSubviews();
                            contentView = this.fileContentView.getLayerForName('content');
                            toolbarView = this.fileContentView.getLayerForName('toolbar');
                            spinnerView = this.fileContentView.getLayerForName('spinner');
                            waitingView = this.fileContentView.getLayerForName('waiting');
                        } else {
                            this._viewState = 'fileNotFound';
                            this._reinitializeCoreSubviews();
                            validationResult = rejectWithError("The file does not exist");
                        }
                        errorView = this.fileContentView.getLayerForName('error');
                        this._deactivateModeHook();
                        this._activateModeHook();
                        return validationResult;
                    }.bind(this))
                    .pipe(function getConverted () {
                        var isPreviewGenerated = this._fileViewer.getConfig().isPreviewGenerated;
                        var generatePreview = this._fileViewer.getConfig().generatePreview;

                        spinnerView.startSpin();

                        if (this._fileViewer.supports(file.get("type"))) {
                            return $.when(file.get("src"), file.get("type"));
                        }

                        if (!(isPreviewGenerated && generatePreview)) {
                            return $.when(file.get("src"), file.get("type"));
                        }

                        return isPreviewGenerated(file).pipe(function (isGenerated, source, type) {
                            if (isGenerated) {
                                return $.when(source, type);
                            }

                            spinnerView.stopSpin();
                            waitingView.showMessage(
                                file,
                                "Your preview is on its way!",
                                "In a hurry? You can download the original right now"
                            );

                            return generatePreview(file).always(function () {
                                waitingView.clearMessage();
                                spinnerView.startSpin();
                            });
                        });

                    }.bind(this))
                    .pipe(function lookupViewer (previewSrc, previewType) {
                        var convertedFile = new File(file.toJSON());

                        convertedFile.set('type', previewType);
                        convertedFile.set('src', previewSrc);
                        file = convertedFile;

                        var loadViewer = this._fileViewer._viewerRegistry.get(previewType);

                        if (!loadViewer) {
                            return rejectWithError("Cannot find a viewer for the given file");
                        }
                        var dfd = $.Deferred();
                        loadViewer().then(function (Viewer) {
                            dfd.resolve(Viewer, previewSrc)
                        }).fail( function () {
                            dfd.fail(arguments);
                        });

                        return dfd.promise();
                    }.bind(this))
                    .pipe(function createViewer (Viewer, previewSrc) {

                        var readyDeferred = new $.Deferred();
                        var view = new Viewer({
                            previewSrc: previewSrc,
                            model: new File(file.toJSON()),
                            fileViewer: this._fileViewer
                        });

                        view.once('viewerReady', function () {
                            this._viewState = 'success';
                            toolbarView.setViewer(view);
                            this.setupMode(this._mode);
                            readyDeferred.resolve(file);
                        }.bind(this));
                        view.once('viewerFail', function (err) {
                            this._viewState = 'viewerError';
                            readyDeferred.reject(err);
                            this.setupMode(this._mode);
                        }.bind(this));

                        contentView.attachViewer(view);

                        view.render();

                        return readyDeferred.promise();

                    }.bind(this))
                    .always(function () {
                        spinnerView && spinnerView.stopSpin();
                        waitingView && waitingView.clearMessage();
                    }.bind(this))
                    .fail(function (err) {
                        fileViewed.reject(err);
                        if (err !== "cancelled") {
                            errorView.showErrorMessage(err, file);
                        }
                    }.bind(this))
                    .done(function() {
                        fileViewed.resolve(file);
                    })
                    .always(function () {
                        fileHandled.resolve();
                    }.bind(this));

                    return fileHandled.promise();
                }.bind(this));

                return fileViewed.promise();
            },

            /**
             * Return the currently shown file.
             * @returns {null|File} the file being shown
             */
            getCurrentFile: function () {
                return this._currentFile;
            },

            /**
             * Return the current view state.
             * Can be any of the following
             * loading, fileNotFound, viewerError, success
             * @returns {String}
             */
            getViewState: function () {
                return this._viewState || 'loading';
            },

            _reinitializeAllSubviews: function () {
                if (!this.fileTitleView.isAnyPanelInitialized()) {
                    this.fileTitleView.initializePanel();
                }
                this.fileTitleView.reinitializePanel();

                this.fileControlsView.reinitializeLayers();
                this.fileContentView.reinitializeLayers();
                this.fileSidebarView.reinitializePanel();
                this.fileMetaView.reinitializeLayers();
                this.fileSinkView.reinitializePanel();

                this._updateMetaBannerHeight();
            },

            _teardownAll: function () {
                this.fileTitleView.teardownPanel();
                this.fileSidebarView.teardownPanel();
                this.fileSinkView.teardownPanel();
                this.fileMetaView.teardownLayers();
                this.fileControlsView.teardownLayers();
                this.fileContentView.teardownLayers();
            },

            _reinitializeCoreSubviews: function () {
                this._teardownAll();

                this.fileControlsView.initializeLayerSubset(['closeButton']);
                this.fileContentView.initializeLayerSubset(['arrows', 'error']);
            },

            _handleNavigationKeys: function (e) {
                var numFiles = this._fileViewer._files.length;

                if (e.which === keys.ESCAPE && !this.isNavigationLocked()) {
                    this._fileViewer.analytics.send('files.fileviewer-web.closed', {
                        actionType: 'hotkey'
                    });
                    this._fileViewer.close();
                } else if (e.which === keys.ARROW_RIGHT && numFiles > 1  && !this.isNavigationLocked()) {
                    this._fileViewer.showFileNext().always(
                        this._fileViewer.analytics.fn('files.fileviewer-web.next', {
                            actionType: 'hotkey',
                            mode: this._fileViewer.getMode()
                        })
                    );
                } else if (e.which === keys.ARROW_LEFT && numFiles > 1  && !this.isNavigationLocked()) {
                    this._fileViewer.showFilePrev().always(
                        this._fileViewer.analytics.fn('files.fileviewer-web.prev', {
                            actionType: 'hotkey',
                            mode: this._fileViewer.getMode()
                        })
                    );
                }
            },

            /**
             * Lock navigation keys. Navigation keys will be disabled until all
             * locks are removed again with unlockNavigationKeys.
             */
            lockNavigationKeys: function () {
                this._navigationKeyLockCount += 1;
            },

            /**
             * Unlock navigation keys.
             */
            unlockNavigationKeys: function () {
                if (this._navigationKeyLockCount >= 1) {
                    this._navigationKeyLockCount -= 1;
                }
            },

            /**
             * Checks if the navigation is locked.
             */
            isNavigationLocked: function () {
                return this._navigationKeyLockCount !== 0;
            },

            _disableKeyboardShortcuts: function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch (e.which) {
                        case keys.F:
                        case keys.G:
                            // disable search keyboard shortcut
                            e.preventDefault();
                            break;
                        case keys.P:
                            // disable print keyboard shortcut
                            e.preventDefault();
                            break;
                    }
                }
            },

            _onClickToBackground: function (e) {
                // @TODO: Remove after cleaning modes setup, hooks etc.
                var mode = this._fileViewer._view._modes[this._fileViewer._view._mode];
                if (mode.disableClickBackgroundCloses) {
                    return;
                }
                var backgroundLayers = [
                    'cp-error-layer',
                    'cp-waiting-layer',
                    'cp-password-layer'
                ];
                if (backgroundLayers.indexOf(e.target.className) >= 0) {
                    this._fileViewer.analytics.send('files.fileviewer-web.closed', {
                        actionType: 'element'
                    });
                    this._fileViewer.close();
                }
            },

            _updateContentWidth: function (panelId, isExpanded) {
                this.$content && this.$content.toggleClass("narrow", isExpanded);
                this._resizeActiveViewer();
            },

            _updateContentHeight: function (panelId, isExpanded) {
                this.$content && this.$content.toggleClass('short', isExpanded);
                this.$sidebar && this.$sidebar.toggleClass('short', isExpanded);
                this._resizeActiveViewer();
            },

            _updateMetaBannerHeight: function () {
                var showsMetaView = this.fileMetaView.countInitializedLayers() > 0;
                this.fileContentView.$el.toggleClass("meta-banner", showsMetaView);
                this.fileSidebarView.$el.toggleClass("meta-banner", showsMetaView);
            },

            _resizeActiveViewer: function () {
                if (this.fileContentView.isLayerInitialized('content')) {
                    var contentView = this.fileContentView.getLayerForName('content');
                    var viewer = contentView.getAttachedViewer();
                    if (viewer) { viewer.handleResize(); }
                }
            },

            // aui tooltips (tipsy) are appended to body. A tooltip will thus stay alive
            // if the trigger element is removed. In here, we clean them up manually
            // whenever a file changes or the whole viewer is closed.
            _fixTooltipCleanup: function () {
                var removeAllTooltips = function () { $('.tipsy').remove(); };
                this._fileViewer.on('fv.changeFile', removeAllTooltips);
                this._fileViewer.on('fv.close', removeAllTooltips);
            },

            /**
             * Return the current mode.
             * @returns {string}
             */
            getMode: function () {
                return this._mode || '';
            },

            /**
             * Check if FileView is in the given mode.
             * @param {string} mode either 'BASE' or 'PRESENTATION'
             * @returns {boolean}
             */
            isInMode: function (mode) {
                return this._mode === mode;
            },

            /**
             * Change current view mode to the given mode.
             * @param {string} mode either 'BASE' or 'PRESENTATION'
             */
            setupMode: function (mode) {
                var toolbar = this.fileContentView.getLayerForName('toolbar');
                var viewer = toolbar._viewer;
                var $arrowLayer = this.fileContentView.getLayerForName('arrows').$el;

                var lastMode = this._mode;
                var isModeChanged = (lastMode !== mode);

                var modeObj = this._modes[mode];
                var lastModeObj = this._modes[lastMode];

                if (isModeChanged) {
                    this._deactivateModeHook();
                    this._mode = mode;
                    this._activateModeHook();
                } else {
                    this._mode = mode;
                }

                $(document).off('keydown.modeKeys');
                lastModeObj.teardown(this, viewer, isModeChanged);
                modeObj.setup(this, viewer);

                // update arrow layer
                $arrowLayer.toggle(modeObj.showsArrowLayer);

                // update toolbar actions
                toolbar.setActions(modeObj.toolbarActions);
                toolbar.render();

                // notify viewer
                if (viewer && viewer.setupMode) {
                    viewer.setupMode(mode, isModeChanged);
                }
            },

            _activateModeHook: function () {
                var mode = this._modes[this._mode];
                if (mode.activateHook) {
                    mode.activateHook(this);
                }
            },

            _deactivateModeHook: function () {
                var mode = this._modes[this._mode];
                if (mode.deactivateHook) {
                    mode.deactivateHook(this);
                }
            },

            updatePaginationButtons: function () {
                if (this.isInMode('PRESENTATION')) {
                    var toolbar = this.fileContentView.getLayerForName('toolbar');
                    if (!toolbar._viewer) {
                        return;
                    }

                    var $toolbarPrevPage = toolbar.$el.find('.cp-toolbar-prev-page');
                    var $toolbarNextPage = toolbar.$el.find('.cp-toolbar-next-page');

                    $toolbarPrevPage.toggleClass('inactive', false);
                    $toolbarNextPage.toggleClass('inactive', false);

                    if (!(toolbar._viewer.hasPreviousPage() || toolbar._viewer.hasNextPage())) {
                        $toolbarPrevPage.hide();
                        $toolbarNextPage.hide();
                    } else if (!toolbar._viewer.hasPreviousPage()) {
                        $toolbarPrevPage.toggleClass('inactive', true);
                    } else if (!toolbar._viewer.hasNextPage()) {
                        $toolbarNextPage.toggleClass('inactive', true);
                    }
                }
            }
        });

        return MainView;
});

define('module-store-singleton', [
    'module-store'
], function (
    ModuleStore
) {
    'use strict';

    /**
     * Global module store. This simplifies development until FileViewer core
     * stabilizes, the plugin interface is ready and the view hierarchy is
     * clear.
     *
     * @todo remove singleton
     */
    return new ModuleStore();
});
define('module-store', [
    'assert',
    'jquery',
    'underscore'
], function (
    assert,
    $,
    _
) {
    'use strict';

    /**
     * Provides modules by asking a previously configured backend.
     *
     * As modules can be loaded async, a promise is always returned.
     *
     * A backend is a function that accepts a module path and returns the
     * matched module. If no module is found, it returns undefined.
     *
     * @constructor
     */
    var ModuleStore = function () {
        this._backend = null;
    };

    /**
     * Checks if backend is a valid backend.
     * @param {*} backend
     * @return {bool}
     */
    ModuleStore.validBackend = function (backend) {
        return _.isFunction(backend);
    };

    /**
     * Asks its backend for the given modulePath and returns a promise.
     * @param {string} modulePath
     * @return {Promise}
     * @throws {Error} if backend is invalid
     */
    ModuleStore.prototype.get = function (modulePath) {
        assert(ModuleStore.validBackend(this._backend), 'backend is valid');
        return $.when(this._backend(modulePath));
    };

    /**
     * Sets a backend for this module store.
     * @param {function} backend
     * @throws {Error} if backend is invalid
     */
    ModuleStore.prototype.useBackend = function (backend) {
        assert(ModuleStore.validBackend(backend), 'backend is valid');
        this._backend = backend;
    };

    return ModuleStore;
});
define('MoreButton', [
    'jquery', 'underscore', 'backbone', 'template-store-singleton'
], function ($, _, Backbone, templateStore) {
    'use strict';

    var MoreButton = Backbone.View.extend({

        tagName: 'span',

        initialize: function (options) {
            this._fileViewer = options.fileViewer;
            this._fileActions = [];
        },

        render: function () {
            this.$el.html(templateStore.get('moreButton')());
            var $dropdown = this.$el.find('#cp-more-menu'),
                $menu = $dropdown.find('ul');

            // prevent the tooltip from showing when the menu is open
            $dropdown.on({
                'aui-dropdown2-show': function () {
                    this.$('a').tipsy('disable');
                }.bind(this),
                'aui-dropdown2-hide': function () {
                    this.$('a').tipsy('enable');
                }.bind(this)
            });

            var currentFile = this._fileViewer._fileState.getCurrent();

            this.$('a').tooltip({ gravity: 'n' });
            if (this._fileActions.length) {
                this._fileActions.forEach(function (item) {
                    var $item = $(templateStore.get('moreMenuItem')({text: item.text}));
                    $item.click(function (e) {
                        e.preventDefault();
                        item.callback(currentFile);
                    });
                    $menu.append($item);
                });
                this._show();
            } else {
                this._hide();
            }

            return this;
        },

        addFileAction: function (opts) {
            var match = _.findWhere(this._fileActions, {key: opts.key});

            if (match) {
                // overwrite the properties of the old action with the new ones
                _.extend(match, {
                    key: opts.key,
                    text: opts.text,
                    callback: opts.callback
                });
            } else {
                this._fileActions.push({
                    key: opts.key,
                    text: opts.text,
                    callback: opts.callback
                });
            }

            this.render();
        },

        removeFileAction: function (action) {
            var index = _.indexOf(this._fileActions, action);
            this._fileActions.splice(index, 1);

            this.render();
        },

        _show: function () {
            this.$el.css('display', 'inline');
        },

        _hide: function () {
            this.$el.css('display', 'none');
        }
    });

    return MoreButton;
});
define('panel-container-view', [
    'backbone',
    'assert',
    'constants-dictionary'
], function (
    Backbone,
    assert,
    ConstantsDictionary
) {
    'use strict';

    var PanelContainerView = Backbone.View.extend({

        className: 'panel-view',

        /**
         * @constructor
         * @param {object} options
         */
        initialize: function (options) {
            this._panelViewsByName = new ConstantsDictionary();
            this._currentPanel = null;
            this._currentPanelName = null;
            this._lastAddedPanelName = null;
            this._fileViewer = options.fileViewer;
        },

        /**
         * Checks if a panel with the given name exists.
         * @param {string} name
         * @return {bool}
         */
        hasPanelView: function (name) {
            return this._panelViewsByName.isDefined(name);
        },

        /**
         * Adds a View as a panel with a certain, unique name.
         * @param {string} name
         * @param {Backbone.View} PanelView
         * @throws Error if name is already used.
         */
        addPanelView: function (name, PanelView) {
            this._panelViewsByName.define(name, PanelView);
            this._lastAddedPanelName = name;
        },

        /**
         * Checks wether any panel is currently initialized.
         * @return {bool}
         */
        isAnyPanelInitialized: function () {
            return this.$el.is('.expanded');
        },

        /**
         * Checks wether a panel with the given name is currently initialized.
         * @param {string} name
         * @return {bool}
         */
        isPanelInitialized: function (name) {
            return this._currentPanelName === name;
        },

        /**
         * Initializes the panel with the given name. Then re-renders itself.
         * @param name {String} name of the panel to be initialized. If empty, then use the last added (using addPanelView) panel.
         * @fires initializePanel(panelName)
         * @fires togglePanel(panelName, isInitialized)
         * @throws Error if a panel is already initialized or the panel doesn't exist
         */
        initializePanel: function (name) {
            name = name || this._lastAddedPanelName;
            assert(this.isAnyPanelInitialized() === false, 'no panel is initialized');
            assert(this.hasPanelView(name) === true, 'panel exists');

            var PanelView = this._panelViewsByName.lookup(name);

            this._currentPanelName = name;
            this._currentPanel = new PanelView({
                collection: this.collection,
                fileViewer: this._fileViewer,
                panelView: this
            });

            this.$el.toggleClass('expanded', true);

            this.trigger('initializePanel', this._currentPanelName);
            this.trigger('togglePanel', this._currentPanelName, true);

            this.render();
        },

        /**
         * Tears the initialized panel down and removes it. Then re-renders itself.
         * Won't throw if there's no initialized panel.
         * @fires togglePanel(panelName, isInitialized)
         * @fires teardownPanel(panelName)
         */
        teardownPanel: function () {
            if (this._currentPanel) {
                if (this._currentPanel.teardown) {
                    this._currentPanel.teardown();
                }
                this._currentPanel.remove();
            }

            this.$el.toggleClass('expanded', false);

            this.trigger('togglePanel', this._currentPanelName, false);
            this.trigger('teardownPanel', this._currentPanelName);

            this._currentPanelName = null;
            this._currentPanel = null;

            this.render();
        },

        /**
         * Utility method. Recreates the current PanelView (if there is one).
         */
        reinitializePanel: function () {
            if (!this.isAnyPanelInitialized()) { return; }

            var previousPanel = this.getInitializedPanelName();
            this.teardownPanel();
            this.initializePanel(previousPanel);
        },

        /**
         * Returns the name of the instanciated PanelView.
         * @return {string} panelName
         * @throws {Error} if no panel is initialized
         */
        getInitializedPanelName: function () {
            assert(this.isAnyPanelInitialized(), 'a panel is initialized');
            return this._currentPanelName;
        },

        /**
         * Returns the instanciated PanelView.
         * @return {PanelView}
         * @throws {Error} if no panel is initialized
         */
        getInitializedPanel: function () {
            return this._currentPanel;
        },

        /**
         * Renders the initialized panel.
         * Won't throw if no panel is initialized.
         * @fires renderPanel(panelName)
         */
        render: function () {
            this.$el.empty();

            if (this.isAnyPanelInitialized()) {
                this._currentPanel.render();
                this._currentPanel.$el.appendTo(this.$el);
            }
            this.trigger('renderPanel', this._currentPanelName);

            return this;
        }

    });

    return PanelContainerView;
});
define('PasswordLayer', [
    'ajs',
    'backbone',
    'keys',
    'template-store-singleton'
], function (
    AJS,
    Backbone,
    keys,
    templateStore
) {
    'use strict';

    var pdfjsPasswordResponses = {
        NEED_PASSWORD: 1,
        INCORRECT_PASSWORD: 2
    };

    var fullscreenEvents = [
        'fullscreenchange',
        'webkitfullscreenchange',
        'mozfullscreenchange',
        'MSFullscreenChange'
    ].join(' ');

    var isFullscreen = function () {
        return (document.fullscreenElement ||
            document.mozFullScreen ||
            document.webkitIsFullScreen ||
            document.msFullscreenElement);
    };

    var PasswordLayer = Backbone.View.extend({

        className: 'cp-password-layer',

        events: {
            'keydown .cp-password-input': '_handleKeyDown',
            'click .cp-password-button': '_handleClick',
            'focus .cp-password-input': '_lockNavigation',
            'blur .cp-password-input': '_unlockNavigation'
        },

        initialize: function (options) {
            this._fileViewer = options.fileViewer;
            this.$el.hide();
        },

        teardown: function () {
            $(document).off(fullscreenEvents, this.updatePasswordLayer.bind(this));
        },

        /**
         * Show the password input layer
         * @param  {Number}   reason         Reason PDFJS why needs the password
         * @param  {Callback} updatePassword
         */
        showPasswordInput: function (reason, updatePassword) {
            $(document).on(fullscreenEvents, this.updatePasswordLayer.bind(this));
            this.updatePassword = updatePassword;
            this._fileViewer._view.fileContentView.getLayerForName('spinner').stopSpin();
            this.$el.show().html(templateStore.get('passwordLayer')({
                prompt: this._getPromptTitle(reason)
            }));
            this.updatePasswordLayer();
            this._showToolbar();
        },

        hidePasswordInput: function () {
            $(document).off(fullscreenEvents, this.updatePasswordLayer.bind(this));
            this.$el.empty();
            this.$el.hide();
        },

        /**
         * Update the passwordLayer depending on fullsccren/no fullscreen
         * Safari/Firefox can't handle keyboard inputs in fullscreen
         */
        updatePasswordLayer: function () {
            if (isFullscreen()) {
                this.$el.find('.cp-password-base').hide();
                this.$el.find('.cp-password-fullscreen').show();
            } else {
                this.$el.find('.cp-password-fullscreen').hide();
                this.$el.find('.cp-password-base').show();
            }
        },

        /**
         * Get i18n string for password prompt based on reason
         * @param  {Number} reason Reason PDFJS why needs the password
         * @return {String}
         */
        _getPromptTitle: function (reason) {
            var title = "Please enter the password to view this file.";
            if (reason === pdfjsPasswordResponses.INCORRECT_PASSWORD) {
                title = "Invalid password. Please try again.";
            }
            return title;
        },

        /**
         * Show passwordLayer and toolbar
         */
        _showToolbar: function () {
            var view    = this._fileViewer._view;
            var toolbar = view.fileContentView.getLayerForName('toolbar');
            var mode    = view._modes[view._mode];
            toolbar.setActions(mode.toolbarActions);
            toolbar.render();
        },

        /**
         * Check if password was given and call `updatePassword()`
         */
        _updatePassword: function () {
            var password = this.$el.find('.cp-password-input').val();
            if (password && password.length > 0) {
                this.hidePasswordInput();
                this.updatePassword(password);
            }
        },

        /**
         * Lock navigation keys
         */
        _lockNavigation: function () {
            this._fileViewer._view._navigationKeyLockCount++;
        },

        /**
         * Unlock navigation keys
         */
        _unlockNavigation: function () {
          this._fileViewer._view._navigationKeyLockCount--;
        },

        _handleClick: function (ev) {
            ev.preventDefault();
            this._updatePassword();
        },

        _handleKeyDown: function (ev) {
            if (ev.which === keys.RETURN) {
                ev.preventDefault();
                return this._updatePassword();
            }
            if (ev.which === keys.ESCAPE) {
                ev.preventDefault();
                return this._fileViewer.close();
            }
        }

    });

    return PasswordLayer;
});

define('pdf-view-provider', [
    'jquery',
    'file',
    'module-store-singleton'
], function (
    $,
    File,
    moduleStore
) {
    'use strict';

    var asyncViewerResource = null,
      asyncConfigResource = null;

    /**
     * Returns a pdf viewer.
     * @returns {Promise}
     */
    var pdfViewProvider = function () {
        if (!asyncViewerResource) {
            asyncViewerResource = moduleStore.get('pdf-viewer');
        }
        if (!asyncConfigResource) {
            asyncConfigResource = moduleStore.get('pdf-config');
        }

        var viewerInstance = $.Deferred();

        $.when(asyncViewerResource, asyncConfigResource).done(function (viewer, config) {
            var PDFViewer = require('pdf-view');

            PDFJS.workerSrc = config.workerSrc;
            PDFJS.cMapUrl = config.cMapUrl;

            viewerInstance.resolve(PDFViewer);
        });

        return viewerInstance.promise();
    };

    return pdfViewProvider;
});
define('presentationMode', ['jquery', 'keys'], function ($, keys) {
    'use strict';

    var requestFullscreen = function () {
        var fullscreenContainer = $('#cp-file-body')[0];

        if (fullscreenContainer.requestFullscreen) {
            fullscreenContainer.requestFullscreen();
        } else if (fullscreenContainer.mozRequestFullScreen) {
            fullscreenContainer.mozRequestFullScreen();
        } else if (fullscreenContainer.webkitRequestFullScreen) {
            fullscreenContainer.webkitRequestFullScreen();
        } else if (fullscreenContainer.msRequestFullscreen) {
            fullscreenContainer.msRequestFullscreen();
        }
    };

    var cancelFullscreen = function () {
        if (document.cancelFullscreen) {
            document.cancelFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    };

    var isFullscreen = function () {
        return (document.fullscreenElement ||
            document.mozFullScreen ||
            document.webkitIsFullScreen ||
            document.msFullscreenElement);
    };

    var onFullscreenChange = function (e) {
        // if user click Esc to exit fullscreen instead of clicking "exit presentation" button
        // then change view mode to 'BASE'
        if (!isFullscreen() && !this.isInMode('BASE')) {
            this._fileViewer.analytics.send('files.fileviewer-web.presentation.exit', {
                actionType: 'hotkey'
            });
            this._fileViewer.changeMode('BASE');
        }
    };

    var presentationMode = {

        activateHook: function (mainView) {
            $(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange',
                onFullscreenChange.bind(mainView));
            var $arrowLayer = mainView.fileContentView.getLayerForName('arrows').$el;
            $arrowLayer.toggle(this.showsArrowLayer);
        },

        deactivateHook: function (mainView) {
            $(document).off('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange',
                onFullscreenChange.bind(mainView));
        },

        setup: function (mainView, viewer) {
            this._originalScrollTop = $('body').scrollTop();
            $('#cp-file-body').addClass('presentation');
            $(document).on('keydown.modeKeys', this._handleKeys.bind(mainView));

            if (!isFullscreen()) { requestFullscreen(); }
        },

        teardown: function (mainView, viewer, isModeChanged) {
            $('#cp-file-body').removeClass('presentation');
            $(document).off('keydown.modeKeys');

            if (isModeChanged && isFullscreen()) { cancelFullscreen(); }
            // this is to fix an issue on Chrome that
            // when entering and exiting fullscreen mode, the document body got scrolled up
            $('body').scrollTop(this._originalScrollTop);
        },

        disableClickBackgroundCloses: true,

        showsArrowLayer: false,

        _handleKeys: function(e) {
            e.preventDefault();
            var contentView, viewer;

            if (this.fileContentView.isLayerInitialized('content')) {
                contentView = this.fileContentView.getLayerForName('content');
                viewer = contentView.getAttachedViewer();
            }
            if (!viewer) { return; }
            if (e.ctrlKey || e.metaKey) {
                return;
            }

            switch (e.which) {
                case keys.ARROW_UP:
                    if (viewer.goToPreviousPage) {
                        this._fileViewer.analytics.send('files.fileviewer-web.presentation.pageprev', {
                            actionType: 'hotkey'
                        });
                        viewer.goToPreviousPage();
                        this.updatePaginationButtons();
                    }
                    return;
                case keys.ARROW_DOWN:
                    if (viewer.goToNextPage) {
                        this._fileViewer.analytics.send('files.fileviewer-web.presentation.pagenext', {
                            actionType: 'hotkey'
                        });
                        viewer.goToNextPage();
                        this.updatePaginationButtons();
                    }
                    return;
            }

        },

        toolbarActions: [
            {
                title: "Previous page",
                className: 'cp-toolbar-prev-page',
                predicate: function () { return this._viewer && this._viewer.goToPreviousPage; },
                handler: function () {
                    if (this._viewer && this._viewer.goToPreviousPage) {
                        this._fileViewer.analytics.send('files.fileviewer-web.presentation.pageprev', {
                            actionType: 'button'
                        });
                        this._viewer.goToPreviousPage();
                        this._fileViewer.getView().updatePaginationButtons();
                    }
                }
            },
            {
                title: "Exit Presentation",
                className: 'cp-toolbar-presentation-exit',
                handler: function () {
                    this._fileViewer.analytics.send('files.fileviewer-web.presentation.exit', {
                        actionType: 'button'
                    });
                    this._fileViewer.changeMode('BASE');
                }
            },
            {
                title: "Next page",
                className: 'cp-toolbar-next-page',
                predicate: function () { return this._viewer && this._viewer.goToNextPage; },
                handler: function () {
                    if (this._viewer && this._viewer.goToNextPage) {
                        this._fileViewer.analytics.send('files.fileviewer-web.presentation.pagenext', {
                            actionType: 'button'
                        });
                        this._viewer.goToNextPage();
                        this._fileViewer.getView().updatePaginationButtons();
                    }
                }
            }
        ]
    };

    return presentationMode;
});

define('soy-template-backend', [], function () {
    'use strict';

    // Returns a value from a nested object, example:
    // obj = { a: { b: { c: 'x' } } }
    // getNestedProperty(obj, 'a.b.c') -> 'x'
    var getNestedProperty = function (obj, prop) {
        var levels = prop.split('.');
        var i;
        for (i = 0; i < levels.length; i++) {
            obj = obj[levels[i]];
        }
        return obj;
    };

    return function (fileViewer) {
        /**
         * Picks the specified template url from the auto-generated template object.
         * @param {string} templateUrl
         * @return {function}
         */
        return function (templateUrl) {
            return getNestedProperty(FileViewer.Templates, templateUrl);
        };
    };
});
define('SpinnerLayer', [
    'backbone', 'template-store-singleton'
], function (Backbone, templateStore) {
    'use strict';

    // Spinner rendering
    var SPINNER_SIZE = 'large';
    var SPINNER_STYLE = {
        color: '#fff',
        zIndex: 'auto'
    };

    /**
     * Loading spinner in the middle of the file content.
     * @constructor
     */
    var SpinnerLayer = Backbone.View.extend({

        className: 'cp-spinner-layer',

        initialize: function () {
            this._updateElements();
        },

        render: function () {
            this.$el.html(templateStore.get('fileBodySpinner')());
            this._updateElements();
            return this;
        },

        /**
         * Instruct the spinner to start.
         */
        startSpin: function () {
            this.$spinner.spin(SPINNER_SIZE, SPINNER_STYLE);
        },

        /**
         * Instruct the spinner to stop.
         */
        stopSpin: function () {
            this.$spinner.spin(false);
        },

        _updateElements: function () {
            this.$spinner = this.$el.find('.cp-spinner');
        }

    });

    return SpinnerLayer;
});
define('template-store-singleton', [
    'template-store'
], function (
    TemplateStore
) {
    'use strict';

    /**
     * Global template store. This simplifies development until FileViewer core
     * stabilizes, the plugin interface is ready and the view hierarchy is
     * clear.
     *
     * @todo remove singleton
     */
    return new TemplateStore();
});
define('template-store', [
    'assert',
    'underscore'
], function (
    assert,
    _
) {
    'use strict';

    /**
     * Provides templates by asking a previously configured backend.
     *
     * A backend is a function that accepts a template path and returns the
     * matched template. If no template is found, it returns undefined.
     *
     * @constructor
     */
    var TemplateStore = function () {
        this._backend = null;
    };

    /**
     * Checks if backend is a valid backend.
     * @param {*} backend
     * @return {bool}
     */
    TemplateStore.validBackend = function (backend) {
        return _.isFunction(backend);
    };

    /**
     * Asks its backend for the given templateUrl.
     * @param {string} templateUrl
     * @return {*}
     * @throws {Error} if backend is invalid
     */
    TemplateStore.prototype.get = function (templateUrl) {
        assert(TemplateStore.validBackend(this._backend), 'backend is valid');
        return this._backend(templateUrl);
    };

    /**
     * Sets a backend for this template store.
     * @param {function} backend
     * @throws {Error} if backend is invalid
     */
    TemplateStore.prototype.useBackend = function (backend) {
        assert(TemplateStore.validBackend(backend), 'backend is valid');
        this._backend = backend;
    };

    return TemplateStore;
});
define('TitleView', [
    'backbone', 'icon-utils', 'template-store-singleton'
], function (Backbone, iconUtils, templateStore) {
    'use strict';

    var TitleView = Backbone.View.extend({

        initialize: function (options) {
            this._fileViewer = options.fileViewer;
        },

        render: function () {
            var model = this._fileViewer.getCurrentFile();
            if (!model) { return; }

            this.$el.html(templateStore.get('titleContainer')({
                title: model.get('title'),
                iconClass: iconUtils.getCssClass(model.get('type'))
            }));

            return this;
        }

    });

    return TitleView;
});
define('ToolbarLayer', [
    'jquery',
    'underscore',
    'backbone',
    'template-store-singleton'
], function (
    $,
    _,
    Backbone,
    templateStore
) {
    'use strict';

    // Amount of time to wait before hiding the controls when the mouse stops moving.
    var HIDE_CONTROLS_TIMEOUT = 500;

    // Amount of time between checking if the mouse is still moving.
    // Should be smaller than HIDE_CONTROLS_TIMEOUT to prevent flickering.
    var THROTTLE_MOUSEMOVE = HIDE_CONTROLS_TIMEOUT - 100;

    /**
     * Showing a toolbar in the lower part of the viewer.
     * @constructor
     */
    var ToolbarLayer = Backbone.View.extend({

        className: 'cp-toolbar-layer',

        initialize: function (options) {
            this._fileViewer = options.fileViewer;
            this._viewer = null;
            this._toggleControlsTimeout = null;
            this._controlsAreFadingOut = false;
            this._actions = [];

            $('#cp-file-body').on('mousemove.toolbarLayer', this._showControlsOnMove.bind(this));
        },

        teardown: function () {
            $(document).off('keydown.toolbarLayer');
            $('#cp-file-body').off('mousemove.toolbarLayer');
        },

        render: function () {
            this.$el.html(templateStore.get('toolbar')({
                actions: this._actions
            }));
            this.$el.find('a').tooltip({gravity: 's', aria: true});
            this.$toolbar = this.$('.cp-toolbar');

            var listeners = {};
            this._actions.forEach(function (action) {
                listeners['click .' + action.className] = action.handler;

                if (action.predicate && !action.predicate.call(this)) {
                    this.$toolbar.find('.' + action.className).hide();
                }
            }, this);
            this.delegateEvents(listeners);

            this.$toolbar.css('margin-left', -this.$toolbar.width() / 2);

            this.$toolbar.on('click', 'a[href=\'#\']', function(e) {
                e.preventDefault();
            });

            return this;
        },

        setActions: function (actions) {
            this._actions = actions;
        },

        setViewer: function (viewer) {
            this._viewer = viewer;
            this.render();
        },

        // Show / hide controls based on mouse movements:
        // - Show the controls when the mouse is moving over the content view.
        // - Hide the controls after a short delay when the mouse stops moving.
        // - Keep the controls open if the mouse is hovering over them.

        _showControlsOnMove : _.throttle(function () {
            if (!this.$toolbar) { return; }
            if (this._controlsAreFadingOut) { return; }

            this.$toolbar.show();
            clearTimeout(this._toggleControlsTimeout);
            this._toggleControlsTimeout = this._setHideTimer();

        }, THROTTLE_MOUSEMOVE),

        _setHideTimer: function () {

            return setTimeout(function () {
                if (this.$toolbar.is(':hover')) { return; }

                this.$toolbar.find('a').each(this._removeTooltipForElement);

                this._controlsAreFadingOut = true;
                setTimeout(function () {
                    this._controlsAreFadingOut = false;
                }.bind(this), HIDE_CONTROLS_TIMEOUT + 100);

                this.$toolbar.fadeOut();
            }.bind(this), HIDE_CONTROLS_TIMEOUT);
        },

        _removeTooltipForElement: function (pos, el) {
            var tipsyId = $(el).attr('aria-describedby');
            if (tipsyId) { $('#' + tipsyId).fadeOut(); }
        }

    });

    return ToolbarLayer;
});

define('unknown-file-type-view-provider', [
    'jquery',
    'unknown-file-type-view'
],
function (
    $,
    UnknownFileTypeView
) {
    'use strict';

    var unknownFileTypeViewProvider = function () {
        return $.Deferred().resolve(UnknownFileTypeView);
    };

    return unknownFileTypeViewProvider;
});
define('unknown-file-type-view', [
    'ajs',
    'BaseViewer',
    'template-store-singleton',
    "icon-utils"
],
function(
    AJS,
    BaseViewer,
    templateStore,
    iconUtils
) {
    'use strict';

    var UnknownFileTypeView = BaseViewer.extend({

        id: 'cp-unknown-file-type-view-wrapper',

        events: {
            'click .download-button': '_handleDownloadButton'
        },

        initialize: function() {
            BaseViewer.prototype.initialize.apply(this, arguments);
        },

        teardown: function() {
            this.off();
            this.remove();
        },

        render: function() {
            this.$el.html(templateStore.get('unknownFileTypeViewer')({
                iconClass: iconUtils.getCssClass(this.model.get('type')),
                src: this.model.get('srcDownload') || this.model.get('src')
            }));

            var fileView = this._fileViewer.getView();

            // kill sidebar view.
            if (fileView.fileSidebarView.isAnyPanelInitialized()) {
                fileView.fileSidebarView.teardownPanel();
            }

            this.trigger('viewerReady');

            return this;
        },

        setupMode: function(mode) {
            if (mode === 'BASE') {
                $('.cp-toolbar-layer').hide();
            }
        },

        _handleDownloadButton: function () {
            this._fileViewer.trigger('fv.download');
            this._triggerAnalytics();
        },

        _triggerAnalytics: function () {
            this._fileViewer.analytics.send('files.fileviewer-web.file.download', {
                actionType: 'cta'
            });
        }

    });

    return UnknownFileTypeView;
});

define('url', [], function() {
    'use strict';
    return {
        /**
         * Adds an objects keys and values as query parameters to an given URL.
         * @param {string} [url]
         * @param {object} [param]
         * @return {string}
         */
        addQueryParamToUrl: function (url, param) {
            param = param || {};
            url = url.split('?');
            var queryArray = url[1] && url[1].split('&');
            queryArray = queryArray || [];
            Object.keys(param).forEach(function (key, val) {
                queryArray.push(key + '=' + param[key]);
            });
            if (queryArray.length === 0) {
                return url[0];
            }
            return url[0] + '?' + queryArray.join('&');
        }
    };
});

define('video-view-provider', [
    'jquery',
    'file'
], function (
    $,
    File
) {
    'use strict';

    /**
     * Returns a video viewer.
     * @returns {Promise}
     */
    var videoViewProvider = function () {
        return $.Deferred().resolve(require('video-view'));
    };

    return videoViewProvider;
});
define('viewer-registry',
    [
        'underscore',
        'assert'
    ],
    function(
        _,
        assert
    ) {
        'use strict';

        var createMatchFn = function (expected) {
            return function (current) {
                return current === expected;
            };
        };

        /**
         * ViewerRegistry is responsible for mapping file types to content viewers.
         *
         * When FileViewer is asked to view a file, it uses the file's type and asks
         * its ViewerRegistry for the proper viewer. In addition, ViewerRegistry is
         * exposed to the outside world. Therefore viewers and plugins can register
         * themself without touching FileViwer core.
         *
         * A viewer is a backbone view and is registered via a function that wraps this
         * view into a promise.
         *
         * Multiple viewers for the same filetype are weighted and can thus be overriden.
         * The default weight is 10 with a lower weight meaning higher priority.
         */
        var ViewerRegistry = function () {
            this._handlers = [];
        };

        /**
         * Checks for a valid viewer (is a function).
         *
         * @param {*} previewer
         * @return {boolean}
         */
        ViewerRegistry.isValidPreviewer = function (previewer) {
            return _.isFunction(previewer);
        };

        /**
         * Checks for a valid weight (a number).
         *
         * @param {*} weight
         * @return {boolean}
         */
        ViewerRegistry.isValidWeight = function (weight) {
            return typeof weight === 'number' && !isNaN(weight);
        };

        /**
         * Register a new viewer for a given filetype with an optional weight.
         *
         * fileType can either be a string which is then directly matched or a
         * predicate function that get's handed the current file type and then
         * can return true / false.
         *
         * @param {string|function} fileType
         * @param {function} previewer
         * @param {integer} [weight=10]
         * @thors {Error}
         */
        ViewerRegistry.prototype.register = function (fileType, previewer, weight) {
            var matchesFileType = typeof fileType === 'function' ? fileType : createMatchFn(fileType);

            weight = weight || 10;

            assert(ViewerRegistry.isValidPreviewer(previewer), 'previewer is valid');
            assert(ViewerRegistry.isValidWeight(weight), 'weight is valid');

            this._handlers.push({
                matchesFileType: matchesFileType,
                previewer: previewer,
                weight: weight
            });

            this._updateWeighting();
        };

        /**
         * Get the viewer with the lowest weight for the given fileType.
         *
         * Returns undefined if no viewer is found.
         *
         * @param {string} fileType
         * @return {object} previewer
         */
        ViewerRegistry.prototype.get = function (fileType) {
            var handler = _.find(this._handlers, function (handler) {
                return handler.matchesFileType(fileType);
            });

            return handler && handler.previewer;
        };

        ViewerRegistry.prototype._updateWeighting = function () {
            // Sorts handlers by weight - needs to be called after a new handler is inserted.
            this._handlers = _.sortBy(this._handlers, function (handler) {
                return handler.weight;
            });
        };

        return ViewerRegistry;
    }
);

define('ViewerLayer', [
    'backbone',
], function (Backbone) {
    'use strict';

    var ViewerLayer = Backbone.View.extend({

        className: 'cp-viewer-layer',

        initialize: function (options) {
            this._viewer = null;
        },

        attachViewer: function (viewer) {
            this._viewer = viewer;
            this.$el.prepend(viewer.$el);
        },

        getAttachedViewer: function () {
            return this._viewer;
        },

        teardown: function () {
            if (this._viewer) {
                if (this._viewer.teardown) {
                    this._viewer.teardown();
                }
                this._viewer.$el.remove();
            }
        }
    });

    return ViewerLayer;
});
define('WaitingLayer', [
    'backbone', 'template-store-singleton'
], function (Backbone, templateStore) {
    'use strict';

    var WaitingLayer = Backbone.View.extend({

        className: 'cp-waiting-layer',

        initialize: function () {
            this.$el.hide();
        },

        showMessage: function (file, header, message) {
            this.$el.show().html(templateStore.get('waitingMessage')({
                src: file.get('srcDownload') || file.get('src'),
                header: header,
                message: message
            }));
            this.$el.find('.cp-waiting-message-spinner').spin('large', {
                color: '#fff',
                zIndex: 'auto'
            });
        },

        clearMessage: function () {
            this.$el.find('.cp-waiting-message-spinner').spin(false);
            this.$el.hide();
        }

    });

    return WaitingLayer;
});

    // assemble core module by injecting all dependencies
    var FileViewer = require('file-viewer');

    FileViewer.Templates = window.FileViewer.Templates;

    // export FileViewer using CommonJS, AMD and the window object
    if (typeof module !== "undefined" && module.exports) {
        module.exports = FileViewer;
    }

    if (window.define) {
        window.define(
            'FileViewer',
            ['jquery', 'underscore', 'backbone', 'ajs'],
            function () { return FileViewer; }
        );
    }

    window.FileViewer = FileViewer;

}());
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:fileviewer-core', location = '/bower_components/atlassian-fileviewer/dist/fileviewer-image-templates.js' */
// This file was automatically generated from image-view.i18n.soy.
// Please don't edit this file by hand.

/**
 * @fileoverview Templates in namespace FileViewer.Templates.
 */

if (typeof FileViewer == 'undefined') { var FileViewer = {}; }
if (typeof FileViewer.Templates == 'undefined') { FileViewer.Templates = {}; }


FileViewer.Templates.previewBody = function(opt_data, opt_ignored) {
  return '<div class="cp-image-container" /><span class="cp-baseline-extension"></span>';
};
if (goog.DEBUG) {
  FileViewer.Templates.previewBody.soyTemplateName = 'FileViewer.Templates.previewBody';
}

} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:fileviewer-core', location = '/bower_components/atlassian-fileviewer/dist/fileviewer-image.js' */
(function (FileViewer) {
    'use strict';

    // use FileViewer's internal module system
    var define  = FileViewer.define;
    var require = FileViewer.require;

define("image-view",
    [
        "ajs",
        "backbone",
        "underscore",
        "jquery",
        "file",
        "BaseViewer",
        "template-store-singleton"
    ],
    function(
        AJS,
        Backbone,
        _,
        $,
        File,
        BaseViewer,
        templateStore
    ) {
        "use strict";

        var ImageView = BaseViewer.extend({

            id: "cp-image-preview",

            tagName: "div",

            initialize: function() {
                BaseViewer.prototype.initialize.apply(this, arguments);

                this.bindPanEvents();
                this.MIN_HEIGHT = 100;
                this.ZOOM_IN_FACTOR = 1.25;
                this.ZOOM_OUT_FACTOR = 0.80;
                this._isFitWidth = false;
                this._footerView = this._fileViewer.getView().fileSinkView;
            },

            renderAnnotations: function(PinsView) {
                var current = this._fileViewer.getCurrentFile();
                var annotations = current.get("annotations");
                if (current && PinsView) {
                    this.pinsView = new PinsView({
                        fileViewer: this._fileViewer,
                        container: this.$el.find(".cp-image-container"),
                        collection: annotations
                    });
                    this.pinsView.render();
                }

                annotations.on("selected", function (item) {
                    var $pin, positionTop, positionLeft;
                    if (!item) { return; }

                    $pin = this.$el.find("span.cp-active-annotation.selected");
                    if (!$pin.length) { return; }

                    positionTop = $pin.position().top - (this.$el.height() / 2);
                    positionLeft = $pin.position().left - (this.$el.width() / 2);

                    this.$el.animate({
                        'scrollTop': positionTop,
                        'scrollLeft': positionLeft
                    });

                }.bind(this));
            },

            bindPanEvents: function() {
                var previous = {x: 0, y: 0},
                    view = this;

                var scroll = function(e) {
                    var $el = view.$el;
                    $el.scrollLeft($el.scrollLeft() + previous.x - e.clientX);
                    $el.scrollTop($el.scrollTop() + previous.y - e.clientY);
                    previous = { x: e.clientX, y: e.clientY };
                    e.preventDefault();
                };

                var unpan = function(e) {
                    view.$el.off("mousemove", "#cp-img", scroll);
                    view.$image.removeClass("panning");
                    e.preventDefault();
                };

                var pan = function(e) {
                    $(window).one("mouseup", unpan);
                    view.$el.on("mousemove", "#cp-img", scroll);
                    view.$image.addClass("panning");
                    previous = { x: e.clientX, y: e.clientY };
                    e.preventDefault();
                };

                this.$el.on("mousedown", "#cp-img", pan);
            },

            zoomFit: function() {
                if(this._isFitWidth) {
                    this.scaleToFit();
                } else {
                    this._fitWidth();
                }
                this._fixContainerSize();
                this.makePannable();
            },

            _fitWidth: function() {
                this._stopFit();
                var $imageContainer = this.$el.find(".cp-image-container");
                $imageContainer.css("width", "100%");
                this.$image.css("width", "100%");
                this.$image.css("height", "auto");
                $imageContainer.addClass("cp-fit-width");
                this._isFitWidth = true;
            },

            _fitHeight: function() {
                this._stopFit();
                var $imageContainer = this.$el.find(".cp-image-container");
                $imageContainer.css("height", "100%");
                this.$image.css("width", "auto");
                this.$image.css("height", "100%");
                $imageContainer.addClass("cp-fit-height");
                $(window).on("resize.cp-repaint", _.throttle(this._forceRepaint.bind(this), 50));
                this.listenTo(this._footerView, "togglePanel" , this._forceRepaint.bind(this));
            },

            _forceRepaint: function () {
                var el = this.$image[0];
                el.style.display='none';
                el.offsetHeight; // referencing to force repaint
                el.style.display='';
            },

            _stopFit: function() {
                this._isFitWidth = false;
                var $imageContainer = this.$el.find(".cp-image-container");
                $imageContainer.removeClass("cp-fit-width cp-fit-height");
                $(window).off("resize.cp-repaint");
                this.stopListening(this._footerView, "togglePanel");
            },

            /**
             * Set size of the images container to the image size.
             * This is a workaround for `HC-11712 as` it's
             * original fix `e31eac8ac51` caused a new issue: `FIL-555`.
             */
            _fixContainerSize: function () {
                var $container = this.$el.find(".cp-image-container");
                var $image = this.$el.find("#cp-img");
                $container.width($image.width());
                $container.height($image.height());
            },

            scaleToFit: function() {
                this._stopFit();

                var viewportWidth = this.$el.width();
                var viewportHeight = this.$el.height();

                if ((this.imageWidth > viewportWidth) || (this.imageHeight > viewportHeight)) {
                    if (viewportWidth/this.imageWidth < viewportHeight/this.imageHeight) {
                        this._fitWidth();
                    } else {
                       this._fitHeight();
                    }
                } else {
                    this.$image.css("width", this.imageWidth);
                    this.$image.css("height", "auto");
                }
                this._fixContainerSize();
            },

            changeZoom: function(newHeight) {
                this._stopFit();

                var viewportWidth = this.$el.width();
                var viewportHeight = this.$el.height();

                var oldWidth = this.$image.width();
                var oldHeight = this.$image.height();
                var containerPosition = this.$el.find(".cp-image-container").position();

                //find the position of the pixel in the centre of the viewport
                var oldPixelCentreWidth = (viewportWidth/2) + Math.abs(containerPosition.left);
                var oldPixelCentreHeight = (viewportHeight/2) + Math.abs(containerPosition.top);

                this.$image.css("height", newHeight);
                this.$image.css("width", "auto");

                //calculate the new pixel centre after the image has been scaled
                var newPixelCentreWidth = (oldPixelCentreWidth/oldWidth) * this.$image.width();
                var newPixelCentreHeight = (oldPixelCentreHeight/oldHeight) * this.$image.height();

                //move the scrollbar to the new pixel and then center the viewport on it
                this.$el.scrollLeft(newPixelCentreWidth - (viewportWidth/2));
                this.$el.scrollTop(newPixelCentreHeight - (viewportHeight/2));
                this._fixContainerSize();
            },

            zoomIn: function() {
                this.changeZoom(this.$image.height() * this.ZOOM_IN_FACTOR);
                this.makePannable();
            },

            zoomOut: function() {
                var heightValue = this.$image.height();
                if (heightValue >= this.MIN_HEIGHT) {
                    this.changeZoom(heightValue * this.ZOOM_OUT_FACTOR);
                }
                this.makePannable();
            },

            makePannable: function() {
                if ((this.$el.width() < this.$image.width()) || (this.$el.height() < this.$image.height())) {
                    this.$image.addClass("pannable");
                } else {
                    this.$image.removeClass("pannable");
                }
            },

            teardown: function() {
                BaseViewer.prototype.teardown.apply(this);
                $(window).off("resize.cp-repaint");
                this.pinsView && this.pinsView.remove().off();
            },

            getBackground: function () {
                return this.$el.add(".cp-image-container");
            },

            render: function() {
                this.$el.html($(templateStore.get('previewBody')()));

                this.addImage();
                return this;
            },

            addImage: function() {
                // This extra work makes the image size the same as the viewport size.
                var $img = $("<img/>")
                    .attr("id", "cp-img")
                    .attr("src", this._previewSrc)
                    .attr("alt", this.model.get("title"));
                $img.off("load");
                $img.on("load", _.partial(this.scaleAndAppendImage, this));

                $img.on("load", function () { this.trigger('viewerReady') }.bind(this));
                $img.on('error', function () {
                    var err = new Error('Image failed loading');
                    err.title = "Ouch! We can\'t load the image.";
                    err.description = this.model.get('src');
                    err.icon = 'cp-image-icon';
                    this.trigger('viewerFail', err);
                }.bind(this));
            },

            scaleAndAppendImage: function(view) {
                var $image = $(this);

                view.imageHeight = this.height;
                view.imageWidth = this.width;
                view.$image = $image;

                $image.css("display", "none"); // For the fade in.

                var $imageContainer = view.$el.find(".cp-image-container");
                $imageContainer.append(view.$image);
                $imageContainer.addClass("cp-annotatable");

                // Ensure the whole image is displayed by fitting to the larger side.
                view.scaleToFit();
                view.$image.fadeIn(200);

                view.trigger("cp.imageAppended");
            },

            setupMode: function(mode, isModeChanged) {
                if (isModeChanged) {
                    this.scaleGraduallyToFit();
                }
            },

            scaleGraduallyToFit: function() {
                // When browser change to fullscreen mode, the screen size is changed many times.
                // Here we scale 10 times every 100ms to make the page scaling to full screen smoothly
                var times = 0;
                var fullScreenInProgress = setInterval(function() {
                    times++;
                    if (times === 11) {
                        clearInterval(fullScreenInProgress);
                    }
                    this.scaleToFit();
                }.bind(this), 100);
            }

        });

        return ImageView;
    });

}(function () {
  var FileViewer;

    if (typeof module !== "undefined" && ('exports' in module)) {
      FileViewer = require('./fileviewer.js');
    } else if (window.require) {
      FileViewer = window.FileViewer;
    } else {
      FileViewer = window.FileViewer;
    }

    return FileViewer;
}()));

} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:confluence-previews-js', location = '/js/amd/confluence-amd.js' */
define("confluence/legacy",function(){return Confluence});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:confluence-previews-js', location = '/js/confluence/async-module-backend.js' */
define("cp/confluence/async-module-backend",["jquery","ajs"],function(f,b){var a={"pdf-viewer":"wr!com.atlassian.confluence.plugins.confluence-previews:confluence-previews-pdf"};var d="com.atlassian.confluence.plugins.confluence-previews:confluence-previews-pdf-worker";var c=function(h){var g=b.Meta.get("static-resource-url-prefix");return g+"/download/resources/"+d+"/"+h};function e(){var g=new f.Deferred();f.ajax({url:b.contextPath()+"/rest/webResources/1.0/resources",type:"POST",contentType:"application/json",dataType:"json",data:JSON.stringify({r:[d],c:[],xc:[],xr:[]})}).done(function(l){var h;for(var k in l.resources){var j=l.resources[k].url;if(j&&j.indexOf(d)!==-1){h=j;break}}if(h){var m=c("bcmaps/");g.resolve({workerSrc:h,cMapUrl:m})}else{g.reject()}}).fail(g.reject.bind(g));return g.promise()}return function(g){if(a[g]){return WRM.require(a[g])}else{if(g==="pdf-config"){return e()}}}});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:confluence-previews-js', location = '/js/confluence/conversion-poller-backend.js' */
define("cp/confluence/conversion-poller-backend",["jquery","underscore","ajs"],function(d,c,b){function a(e){this._type=e;if(this._type==="thumbnail"){this._bulkUrl=b.contextPath()+"/rest/documentConversion/0.1/conversion/thumbnail/results";this._singleUrlBase=b.contextPath()+"/rest/documentConversion/0.1/conversion/thumbnail/"}else{this._bulkUrl=b.contextPath()+"/rest/documentConversion/0.1/conversion/convert/results";this._singleUrlBase=b.contextPath()+"/rest/documentConversion/0.1/conversion/convert/"}this._pollers={};this._timerId=0;this._interval=a.INITIAL_INTERVAL;this._debouncedChange=c.debounce(this._change,100)}a.INITIAL_INTERVAL=1000;a.MAX_INTERVAL=10000;a.BACKOFF_PERCENT=1.5;a.prototype.add=function(g,f){if(g&&!this._pollers[g]){var e=d.Deferred();this._pollers[g]={_dfd:e,_version:f};this._debouncedChange()}return this._pollers[g]._dfd.promise()};a.prototype.remove=function(e){var f=this._pollers[e];if(f){f._dfd.reject("cancelled");delete this._pollers[e]}};a.prototype._doPoll=function(){if(this._pollType==="single"){this._pollSingle()}else{if(this._pollType==="multiple"){this._pollMultiple()}}};a.prototype._backoff=function(){var e=this._interval*a.BACKOFF_PERCENT;this._interval=e>a.MAX_INTERVAL?a.MAX_INTERVAL:e;this._timerId=setTimeout(this._change.bind(this),this._interval)};a.prototype._change=function(){var f=this._getAttachmentIds();var e=!(f.length===0);this._cancel();if(!e){delete this._pollType;this._interval=1000}else{this._changeType();this._doPoll()}};a.prototype._changeType=function(){var g=this._getAttachmentIds();var f=g.length===1;var e=g.length>1;if(f&&this._pollType!=="single"){this._pollType="single"}else{if(e&&this._pollType!=="multiple"){this._pollType="multiple"}}};a.prototype._cancel=function(){clearTimeout(this._timerId);this._xhr&&this._xhr.abort();delete this._xhr};a.prototype._getAttachmentIds=function(){return Object.keys(this._pollers)};a.prototype._getIdsAndVersions=function(){var e=this._pollers;return c.map(this._getAttachmentIds(),function(f){return{id:f,v:e[f]._version}})};a.prototype._pollSingle=function(){var f=this._getAttachmentIds()[0];var g=this._pollers[f];var e=g._version;this._xhr=this._getSingle(f,e).always(function(){delete this._xhr}.bind(this)).done(function(i,j,h){if(h.status===202){this._backoff();g._dfd.notify("converting")}else{g._dfd.resolve(this._singleUrlBase+f+"/"+e,h.getResponseHeader("Content-Type"));delete this._pollers[f];this._change()}}.bind(this)).fail(function(h,j,i){if(h.status==429){this._backoff();g._dfd.notify("busy");return}if(i==="abort"){return}g._dfd.reject();delete this._pollers[f];this._change()}.bind(this))};a.prototype._getSingle=function(f,e){return d.ajax(this._singleUrlBase+f+"/"+e,{type:"HEAD",dataType:"json"})};a.prototype._pollMultiple=function(){this._xhr=d.ajax(this._bulkUrl,{type:"POST",dataType:"json",contentType:"application/json; charset=utf-8",data:JSON.stringify(this._getIdsAndVersions())}).always(function(){delete this._xhr}.bind(this)).done(function(e){c(e).each(function(g,h){var i=this._pollers[h];if(!i){return}if(g==200){var f=i._version;if(this._type!=="thumbnail"){this._getSingle(h,f).done(function(k,l,j){i._dfd.resolve(this._singleUrlBase+h+"/"+f,j.getResponseHeader("Content-Type"));delete this._pollers[h]}.bind(this))}else{i._dfd.resolve(this._singleUrlBase+h+"/"+f,"image/jpg");delete this._pollers[h]}}else{if(g>=400&&g!=429){i._dfd.reject();delete this._pollers[h]}}}.bind(this));this._backoff()}.bind(this))};return a});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:confluence-previews-js', location = '/js/confluence/conversion-poller.js' */
define("cp/confluence/conversion-poller",["cp/confluence/conversion-poller-backend","jquery"],function(a,e){var b={};var c={};function d(k,g,i,f){if(!b[i]){b[i]=new a(i)}this.backend=b[i];this._attachmentId=k;this._version=g;var h=JSON.stringify({a:k,v:g,t:i});var j=c[h];if(j){this._promise=j.success?e.when(j.url,j.type):e.Deferred().reject(j.reason)}else{this._promise=this.backend.add(this._attachmentId,this._version);this._promise.then(function(l,m){c[h]={success:true,url:l,type:m}},function(l){if(l!=="cancelled"){c[h]={success:false,reason:l}}},f)}}d.prototype.stop=function(){this.backend.remove(this._attachmentId)};d.prototype.promise=function(){return this._promise};return d});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:confluence-previews-js', location = '/js/service/comments-service.js' */
define("cp/service/comments-service",["underscore","ajs","jquery"],function(e,c,g){function d(i,j){this.url=c.contextPath()+"/rest/files/1.0/files/"+i+"/comments";this.version=j}var b=function(i,j){return function(k){return c.defaultIfUndefined(k,{rootObject:i,defaultValue:j})}};var f=function(i){var k=b(i,"");var l=b(i,undefined);var j=l("history.createdDate")||new Date();return{id:k("id"),author:{name:k("history.createdBy.displayName"),avatar:k("history.createdBy.profilePicture.path"),profile:c.contextPath()+"/display/~"+k("history.createdBy.username")},comment:k("body.view.value"),editorFormat:k("body.editor.value"),date:j,hasDeletePermission:i.hasDeletePermission,hasEditPermission:i.hasEditPermission,hasReplyPermission:i.hasReplyPermission,hasResolvePermission:i.hasResolvePermission}};var h=function(i){var k=b(i,undefined);var j=b(i,false);return e.extend({pageNumber:k("anchor.page"),position:[k("anchor.x"),k("anchor.y")],resolved:j("resolved.value")},f(i))};var a=function(l,j){var k=l.changedAttributes();if(k.hasOwnProperty("resolved")&&j){return{resolved:l.get("resolved")}}var i={parentId:l.get("parentId"),commentBody:l.get("editorFormat")};if(l.get("position")||l.get("pageNumber")){i=e.extend({},i,{anchor:{x:l.get("position")[0],y:l.get("position")[1],page:l.get("pageNumber"),type:"pin"}})}return i};d.prototype._makeUrl=function(i){if(!i){i=""}return this.url+i+(this.version?("?attachmentVersion="+this.version):"")};d.prototype.getAnnotations=function(k){var i=g.Deferred();var j=e.extend({},k);g.ajax({url:this._makeUrl(),type:"GET",data:{limit:j.limit,start:j.start},dataType:"json"}).then(function(l){var m=e.map(l.results,h);i.resolve(m)}).fail(function(l,n,m){i.reject(l,n,m)});return i.promise()};d.prototype.getReplies=function(k){var i=g.Deferred();var j=e.extend({},k);g.ajax({url:this._makeUrl("/"+k.parentId),type:"GET",data:{limit:j.limit,start:j.start},dataType:"json"}).then(function(n){var o=b(n,[]);var l=o("children");var m=e.map(l,f);i.resolve(m)}).fail(function(l,n,m){i.reject(l,n,m)});return i.promise()};d.prototype.save=function(l){var i=g.Deferred();var k=l.get("id")?"PUT":"POST";var j=(k==="PUT")?this._makeUrl("/"+l.get("id")):this._makeUrl();g.ajax({url:j,type:k,data:JSON.stringify(a(l,(k==="PUT"))),dataType:"json",contentType:"application/json; charset=utf-8"}).then(function(m){i.resolve(f(m))}).fail(function(m,o,n){i.reject(m,o,n)});return i.promise()};d.prototype.remove=function(j){var i=g.Deferred();g.ajax({url:this._makeUrl("/"+j.get("id")),type:"DELETE",dataType:"json"}).then(function(){i.resolve()}).fail(function(k,m,l){i.reject(k,m,l)});return i.promise()};return d});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:confluence-previews-js', location = '/js/service/versions-service.js' */
define("cp/service/versions-service",["ajs","jquery","underscore"],function(a,g,c){var b=a.contextPath();var f=function(h){if(h.id===-1){return{}}var j=h.previewContents.THUMBNAIL;var i=a.DarkFeatures.isEnabled("previews.conversion-service");var k=j&&i?j.downloadUrl:h.downloadUrl;return{src:b+h.downloadUrl,type:h.contentType,contentType:h.contentType,thumbnail:b+k,title:h.fileName,name:h.fileName,id:h.id,ownerId:h.containerId&&h.containerId.toString(),version:h.version,hasUploadAttachmentVersionPermission:h.hasUploadAttachmentVersionPermission}};var e=function(j,h,i){return g.ajax({url:b+"/rest/files/1.0/files/content/"+j+"/byAttachmentId",type:"GET",dataType:"json",contentType:"application/json; charset=utf-8",data:{attachmentId:h,attachmentVersion:i}}).pipe(function(k){return f(k)})};function d(){}d.prototype.getAllFileVersions=function(h){var i=b+"/rest/files/1.0/files/"+h+"/versions";return g.ajax(i).pipe(function(k){var j=k.results;return c.sortBy(c.map(j,function(l){return{id:l.id,version:l.version.number,message:l.version.message,countComments:l.countComments,ownerId:l.ownerId}}),function(l){return 0-l.version})})};d.prototype.getFileVersion=function(j,h,i){return e(j,h,i)};return d});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:confluence-previews-js', location = '/js/service/files-service.js' */
define("cp/service/files-service",["ajs","jquery","underscore"],function(a,f,c){var b=a.contextPath();var e=function(g){if(g.id===-1){return{}}var i=g.previewContents.THUMBNAIL;var h=a.DarkFeatures.isEnabled("previews.conversion-service");var j=null;if(i&&h){j=b+i.downloadUrl}return{src:b+g.downloadUrl,srcDownload:b+g.downloadUrl+"&download=true",type:g.contentType,thumbnail:j,title:g.fileName,name:g.fileName,id:g.id.toString(),ownerId:g.containerId&&g.containerId.toString(),version:g.version,hasReplyPermission:g.hasReplyPermission,hasUploadAttachmentVersionPermission:g.hasUploadAttachmentVersionPermission}};function d(g){this.url=b+"/rest/files/1.0/files/content/"+g}d.prototype.getFiles=function(i){var g=f.Deferred();var h=c.extend({},i);f.ajax({url:this.url,type:"GET",data:{"max-results":h.limit,"start-index":h.start},dataType:"json"}).then(function(k){var j=c.map(k.results,e);g.resolve(j)}).fail(function(j,l,k){g.reject(j,l,k)});return g.promise()};d.prototype.getFilesWithId=function(h){var g=f.Deferred();f.ajax({url:this.url+"/byAttachmentIds",type:"POST",data:JSON.stringify({attachmentIds:h}),dataType:"json",contentType:"application/json; charset=utf-8"}).then(function(j){var i=c.map(j.results,e);g.resolve(i)}).fail(function(i,k,j){g.reject(i,k,j)});return g.promise()};d.prototype.getFileWithId=function(g){return this.getFilesWithId([g]).pipe(function(h){return h[0]})};d.prototype.getFilesWithoutId=function(h){var g=f.Deferred();f.ajax({url:this.url+"/minusAttachmentIds",type:"POST",data:JSON.stringify({attachmentIds:h}),dataType:"json",contentType:"application/json; charset=utf-8"}).then(function(j){var i=c.map(j.results,e);g.resolve(i)}).fail(function(i,k,j){g.reject(i,k,j)});return g.promise()};return d});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:confluence-previews-js', location = '/js/confluence/file-preview-loader.js' */
define("cp/confluence/file-preview-loader",["jquery","underscore","ajs","cp/confluence/preview-support","cp/confluence/async-module-backend","FileViewer","cp/confluence/conversion-poller","cp/service/files-service","cp/service/comments-service","cp/service/versions-service"],function(q,I,h,G,H,c,n,a,k,E){var v,e,A,b=false;var u=function(K,L){h.trigger("analyticsEvent",{name:K,data:L})};var r=c.require("file-types");function C(K){return K.attr("data-image-src")||K.attr("data-file-src")||K.attr("src")||K.attr("href")}function x(K){return K.attr("data-linked-resource-content-type")||K.attr("data-mime-type")||"image/web"}function o(L,N){var K=q(L);var M=C(K);var O=K.attr("data-linked-resource-default-alias");return{src:M,srcDownload:M+"&download=true",thumbnail:M,type:x(K),title:O||M,name:O,rank:N,id:K.attr("data-linked-resource-id"),version:K.attr("data-linked-resource-version"),ownerId:K.attr("data-linked-resource-container-id"),isRemoteLink:K.hasClass("confluence-external-resource")}}function s(L){var K=0;return I.map(L,function(M){return o(M,K++)})}function J(K){if(c.isPluginEnabled("annotation")){K.once("fv.showFile",function(){c.getPlugin("annotation").showAnnotationsPanel(K)})}}function w(N,M){var L=q(N);var O;if(v&&b&&e===M.viewMode){M.enablePermalinks=true;p(A,M);O=q.when()}else{v&&v.close();O=F(N,M);b=true}if(!N){return}var R=L.attr("data-linked-resource-id"),K=L.attr("data-linked-resource-container-id"),Q=L.attr("data-image-src")||L.attr("data-file-src")||L.attr("src");var P=(R&&K)?{id:R,ownerId:K}:{src:Q};v.open(P,"main");if(M.autoShowAnnotationPanel){J(v)}}function f(K){if(K.id&&K.ownerId){return K.ownerId+"-"+K.id}return K.src}var m={showPreviewerForComment:function(R,Q,O){var P=q(R);var L=Q.find(G.getFileSelectorString());var M=I.uniq(L,function(U){return U.src||U.href});A=s(M);O.enablePermalinks=false;m.setupPreviewerForComment(O);var N=P.attr("data-linked-resource-id"),T=P.attr("data-linked-resource-container-id"),K=P.attr("data-image-src")||P.attr("data-file-src")||P.attr("src");var S=(N&&T)?{id:N,ownerId:T}:{src:K};v.open(S,"comments");if(O.autoShowAnnotationPanel){J(v)}},setupPreviewerForComment:function(L){var M=q.when();var K=h.Meta.get("page-id");if(K){M=y(K,true)}p(i(A),L);M.then(function(N){v.updateFiles(i(N),f)});return M}};function D(L,K){var M=l(L,K);M.open({id:M.getFiles()[0].id},K&&K.source)}function l(L,K){var M=I.isArray(L)?L:s(q(L));K.enablePermalinks=false;p(M,K);return v}var g;var t=function(M){g&&g.stop();var N=M.get("id");var L=M.get("version");var K=q.Deferred();if(!N){return q.when(true,M.get("src"),M.get("type"))}g=new n(N,L,"conversion",function(O){if(O==="converting"||O==="busy"){K.resolve(false,M.get("src"),M.get("type"))}});g.promise().then(function(P,O){if(K.state()!=="pending"){return}K.resolve(true,P,O)}).fail(function(O){if(K.state()!=="pending"){return}if(O==="cancelled"){K.reject(O)}else{K.resolve(true,M.get("src"),M.get("type"))}});return K.promise()};var B=function(M){g&&g.stop();var N=M.get("id");var L=M.get("version");var K=q.Deferred();g=new n(N,L,"conversion");g.promise().done(function(P,O){K.resolve(P,O)}).fail(function(O){if(O!=="cancelled"){K.resolve(M.get("src"),M.get("type"))}else{K.reject(O)}});return K.promise()};var d=function(N){var P=N.get("type"),L=N.get("src"),M=N.get("id"),Q=N.get("isRemoteLink"),S=q.Deferred();if(!Q&&r.isImageBrowserSupported(P)){var K=L.replace("/attachments/","/thumbnails/");S.resolve(K,"image/jpeg")}else{if(M){var O=N.get("version");var R=new n(M,O,"thumbnail");R.promise().done(function(U,T){S.resolve(U,T)}).fail(function(){S.reject()})}else{S.resolve(L,P)}}return S.promise()};function j(L,K){e=K.viewMode;var N={appendTo:q("body"),files:L,filesService:a,commentService:k,versionsService:E,moduleBackend:H,enableAnnotations:h.DarkFeatures.isEnabled("file-annotations"),enablePermalinks:h.DarkFeatures.isEnabled("previews.sharing"),enableMiniMode:true,enableShareButton:true,enableVersionNavigation:true,viewers:["image","document"],analyticsBackend:u};if(K&&K.viewMode===G.VIEW_MODE.SIMPLE){N.enableAnnotations=false;N.enableMiniMode=false;N.enableShareButton=false;N.enableVersionNavigation=false}if(h.DarkFeatures.isEnabled("previews.conversion-service")){N.isPreviewGenerated=t;N.generatePreview=B;N.generateThumbnail=d}v=new c(N);var M=v.getView();M.show=I.compose(M.show,function(O){h.trigger("remove-bindings.keyboardshortcuts");return O});M.hide=I.compose(M.hide,function(O){h.trigger("add-bindings.keyboardshortcuts");return O});return v}function p(L,K){if(!v||e!==K.viewMode){v&&v.close();j(L,K)}v.updateFiles(L);if(c.isPluginEnabled("permalink")){c.getPlugin("permalink").setRoutingEnabled(K.enablePermalinks)}}function F(N,M){var Q=function(){M.enablePermalinks=true;p(i(A),M);if(c.isPluginEnabled("permalink")){c.getPlugin("permalink").startRouting()}};var L=I.uniq(q(G.getFileSelectorString()),function(R){return q(R).attr("data-linked-resource-id")||R.src});A=s(L);var P=h.Meta.get("user-timezone-offset");if(!P){h.Meta.set("user-timezone-offset",0)}var O;var K=h.Meta.get("page-id");if(K){O=y(K)}else{O=q.when()}if(N){Q();O.then(function(){v.updateFiles(i(A),f)})}else{O.then(Q)}return O}function i(K){return I.uniq(K,f)}var z=function(L){var M=h.DarkFeatures.isEnabled("previews.trigger-all-file-types");var K=h.DarkFeatures.isEnabled("previews.conversion-service");if(!M&&!K){L=I.filter(L,function(N){return r.isImage(N.type)||(r.isPDF(N.type)&&G.isPDFSupported())})}A=i(L.concat(A));return A};function y(M,L){var O=I.filter(A,function(R){return !!R.id}),P=I.pluck(O,"id"),Q=M,K=new a(Q);var N=[];if(P.length){N.push(K.getFilesWithId(P));if(!L){N.push(K.getFilesWithoutId(P))}}else{N.push(K.getFiles())}return q.when.apply(q,N).done(function(){var R=I.reduce(arguments,function(T,S){return T.concat(S)});return z(R)})}return{showPreviewer:w,showPreviewerForSingleFile:D,setupPreviewForSingleFile:l,showPreviewerForComment:m.showPreviewerForComment}});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.extra.officeconnector:file-viewer-plugin', location = 'javascript/edit-in-office-plugin.js' */
define("office-connector/edit-in-office-plugin",["jquery","ajs","office-connector/edit-in-office"],function(c,h,f){var i=function(j){j.on("fv.showFile fv.showFileError",function(k){if(k&&b(k.get("src"))&&d()){j.addFileAction({key:"edit-in-office",text:"Edit in Office",callback:g})}})};var d=function(){return h.Meta.get("content-type")==="page"||h.Meta.get("content-type")==="blogpost"};var b=function(k){var l="";if(k){var m=k.substring(0,k.lastIndexOf("?"));l=f.getProgID(m)}var j=(l!=="");return j&&(a()||e())};var a=function(){var j,k=(window.ActiveXObject!==undefined);if(k){try{j=new ActiveXObject("SharePoint.OpenDocuments.1")}catch(l){}}return j};var e=function(){return window.URLLauncher||window.InstallTrigger};var g=function(j){var l=j.get("attachmentId")||j.get("id");var k=h.contextPath();c.getJSON(k+"/rest/office/1.0/metadata/"+l).done(function(o){var p=k+o.webDavUrl;var n=o.usePathAuth;var m=getProgID(p);return f.doEditInOffice(k,p,m,n)})};return i});var FileViewer=require("FileViewer");var EditInOfficePlugin=require("office-connector/edit-in-office-plugin");FileViewer.registerPlugin("editInOffice",EditInOfficePlugin);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-ui-interactions', location = 'js-vendor/jquery/jquery-ui/jquery.ui.droppable.js' */
/*
 * jQuery UI Droppable 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Droppables
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 *	jquery.ui.mouse.js
 *	jquery.ui.draggable.js
 */
(function(A,B){A.widget("ui.droppable",{widgetEventPrefix:"drop",options:{accept:"*",activeClass:false,addClasses:true,greedy:false,hoverClass:false,scope:"default",tolerance:"intersect"},_create:function(){var D=this.options,C=D.accept;this.isover=0;this.isout=1;this.accept=A.isFunction(C)?C:function(E){return E.is(C)};this.proportions={width:this.element[0].offsetWidth,height:this.element[0].offsetHeight};A.ui.ddmanager.droppables[D.scope]=A.ui.ddmanager.droppables[D.scope]||[];A.ui.ddmanager.droppables[D.scope].push(this);(D.addClasses&&this.element.addClass("ui-droppable"))},destroy:function(){var C=A.ui.ddmanager.droppables[this.options.scope];for(var D=0;D<C.length;D++){if(C[D]==this){C.splice(D,1)}}this.element.removeClass("ui-droppable ui-droppable-disabled").removeData("droppable").unbind(".droppable");return this},_setOption:function(C,D){if(C=="accept"){this.accept=A.isFunction(D)?D:function(E){return E.is(D)}}A.Widget.prototype._setOption.apply(this,arguments)},_activate:function(D){var C=A.ui.ddmanager.current;if(this.options.activeClass){this.element.addClass(this.options.activeClass)}(C&&this._trigger("activate",D,this.ui(C)))},_deactivate:function(D){var C=A.ui.ddmanager.current;if(this.options.activeClass){this.element.removeClass(this.options.activeClass)}(C&&this._trigger("deactivate",D,this.ui(C)))},_over:function(D){var C=A.ui.ddmanager.current;if(!C||(C.currentItem||C.element)[0]==this.element[0]){return }if(this.accept.call(this.element[0],(C.currentItem||C.element))){if(this.options.hoverClass){this.element.addClass(this.options.hoverClass)}this._trigger("over",D,this.ui(C))}},_out:function(D){var C=A.ui.ddmanager.current;if(!C||(C.currentItem||C.element)[0]==this.element[0]){return }if(this.accept.call(this.element[0],(C.currentItem||C.element))){if(this.options.hoverClass){this.element.removeClass(this.options.hoverClass)}this._trigger("out",D,this.ui(C))}},_drop:function(D,E){var C=E||A.ui.ddmanager.current;if(!C||(C.currentItem||C.element)[0]==this.element[0]){return false}var F=false;this.element.find(":data(droppable)").not(".ui-draggable-dragging").each(function(){var G=A.data(this,"droppable");if(G.options.greedy&&!G.options.disabled&&G.options.scope==C.options.scope&&G.accept.call(G.element[0],(C.currentItem||C.element))&&A.ui.intersect(C,A.extend(G,{offset:G.element.offset()}),G.options.tolerance)){F=true;return false}});if(F){return false}if(this.accept.call(this.element[0],(C.currentItem||C.element))){if(this.options.activeClass){this.element.removeClass(this.options.activeClass)}if(this.options.hoverClass){this.element.removeClass(this.options.hoverClass)}this._trigger("drop",D,this.ui(C));return this.element}return false},ui:function(C){return{draggable:(C.currentItem||C.element),helper:C.helper,position:C.position,offset:C.positionAbs}}});A.extend(A.ui.droppable,{version:"1.8.24"});A.ui.intersect=function(P,J,N){if(!J.offset){return false}var E=(P.positionAbs||P.position.absolute).left,D=E+P.helperProportions.width,M=(P.positionAbs||P.position.absolute).top,L=M+P.helperProportions.height;var G=J.offset.left,C=G+J.proportions.width,O=J.offset.top,K=O+J.proportions.height;switch(N){case"fit":return(G<=E&&D<=C&&O<=M&&L<=K);break;case"intersect":return(G<E+(P.helperProportions.width/2)&&D-(P.helperProportions.width/2)<C&&O<M+(P.helperProportions.height/2)&&L-(P.helperProportions.height/2)<K);break;case"pointer":var H=((P.positionAbs||P.position.absolute).left+(P.clickOffset||P.offset.click).left),I=((P.positionAbs||P.position.absolute).top+(P.clickOffset||P.offset.click).top),F=A.ui.isOver(I,H,O,G,J.proportions.height,J.proportions.width);return F;break;case"touch":return((M>=O&&M<=K)||(L>=O&&L<=K)||(M<O&&L>K))&&((E>=G&&E<=C)||(D>=G&&D<=C)||(E<G&&D>C));break;default:return false;break}};A.ui.ddmanager={current:null,droppables:{"default":[]},prepareOffsets:function(F,H){var C=A.ui.ddmanager.droppables[F.options.scope]||[];var G=H?H.type:null;var I=(F.currentItem||F.element).find(":data(droppable)").andSelf();droppablesLoop:for(var E=0;E<C.length;E++){if(C[E].options.disabled||(F&&!C[E].accept.call(C[E].element[0],(F.currentItem||F.element)))){continue}for(var D=0;D<I.length;D++){if(I[D]==C[E].element[0]){C[E].proportions.height=0;continue droppablesLoop}}C[E].visible=C[E].element.css("display")!="none";if(!C[E].visible){continue}if(G=="mousedown"){C[E]._activate.call(C[E],H)}C[E].offset=C[E].element.offset();C[E].proportions={width:C[E].element[0].offsetWidth,height:C[E].element[0].offsetHeight}}},drop:function(C,D){var E=false;A.each(A.ui.ddmanager.droppables[C.options.scope]||[],function(){if(!this.options){return }if(!this.options.disabled&&this.visible&&A.ui.intersect(C,this,this.options.tolerance)){E=this._drop.call(this,D)||E}if(!this.options.disabled&&this.visible&&this.accept.call(this.element[0],(C.currentItem||C.element))){this.isout=1;this.isover=0;this._deactivate.call(this,D)}});return E},dragStart:function(C,D){C.element.parents(":not(body,html)").bind("scroll.droppable",function(){if(!C.options.refreshPositions){A.ui.ddmanager.prepareOffsets(C,D)}})},drag:function(C,D){if(C.options.refreshPositions){A.ui.ddmanager.prepareOffsets(C,D)}A.each(A.ui.ddmanager.droppables[C.options.scope]||[],function(){if(this.options.disabled||this.greedyChild||!this.visible){return }var G=A.ui.intersect(C,this,this.options.tolerance);var I=!G&&this.isover==1?"isout":(G&&this.isover==0?"isover":null);if(!I){return }var H;if(this.options.greedy){var F=this.options.scope;var E=this.element.parents(":data(droppable)").filter(function(){return A.data(this,"droppable").options.scope===F});if(E.length){H=A.data(E[0],"droppable");H.greedyChild=(I=="isover"?1:0)}}if(H&&I=="isover"){H.isover=0;H.isout=1;H._out.call(H,D)}this[I]=1;this[I=="isout"?"isover":"isout"]=0;this[I=="isover"?"_over":"_out"].call(this,D);if(H&&I=="isout"){H.isout=0;H.isover=1;H._over.call(H,D)}})},dragStop:function(C,D){C.element.parents(":not(body,html)").unbind("scroll.droppable");if(!C.options.refreshPositions){A.ui.ddmanager.prepareOffsets(C,D)}}}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-ui-interactions', location = 'js-vendor/jquery/jquery-ui/jquery.ui.resizable.js' */
/*
 * jQuery UI Resizable 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Resizables
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.mouse.js
 *	jquery.ui.widget.js
 */
(function(C,D){C.widget("ui.resizable",C.ui.mouse,{widgetEventPrefix:"resize",options:{alsoResize:false,animate:false,animateDuration:"slow",animateEasing:"swing",aspectRatio:false,autoHide:false,containment:false,ghost:false,grid:false,handles:"e,s,se",helper:false,maxHeight:null,maxWidth:null,minHeight:10,minWidth:10,zIndex:1000},_create:function(){var F=this,J=this.options;this.element.addClass("ui-resizable");C.extend(this,{_aspectRatio:!!(J.aspectRatio),aspectRatio:J.aspectRatio,originalElement:this.element,_proportionallyResizeElements:[],_helper:J.helper||J.ghost||J.animate?J.helper||"ui-resizable-helper":null});if(this.element[0].nodeName.match(/canvas|textarea|input|select|button|img/i)){this.element.wrap(C('<div class="ui-wrapper" style="overflow: hidden;"></div>').css({position:this.element.css("position"),width:this.element.outerWidth(),height:this.element.outerHeight(),top:this.element.css("top"),left:this.element.css("left")}));this.element=this.element.parent().data("resizable",this.element.data("resizable"));this.elementIsWrapper=true;this.element.css({marginLeft:this.originalElement.css("marginLeft"),marginTop:this.originalElement.css("marginTop"),marginRight:this.originalElement.css("marginRight"),marginBottom:this.originalElement.css("marginBottom")});this.originalElement.css({marginLeft:0,marginTop:0,marginRight:0,marginBottom:0});this.originalResizeStyle=this.originalElement.css("resize");this.originalElement.css("resize","none");this._proportionallyResizeElements.push(this.originalElement.css({position:"static",zoom:1,display:"block"}));this.originalElement.css({margin:this.originalElement.css("margin")});this._proportionallyResize()}this.handles=J.handles||(!C(".ui-resizable-handle",this.element).length?"e,s,se":{n:".ui-resizable-n",e:".ui-resizable-e",s:".ui-resizable-s",w:".ui-resizable-w",se:".ui-resizable-se",sw:".ui-resizable-sw",ne:".ui-resizable-ne",nw:".ui-resizable-nw"});if(this.handles.constructor==String){if(this.handles=="all"){this.handles="n,e,s,w,se,sw,ne,nw"}var K=this.handles.split(",");this.handles={};for(var G=0;G<K.length;G++){var I=C.trim(K[G]),E="ui-resizable-"+I;var H=C('<div class="ui-resizable-handle '+E+'"></div>');H.css({zIndex:J.zIndex});if("se"==I){H.addClass("ui-icon ui-icon-gripsmall-diagonal-se")}this.handles[I]=".ui-resizable-"+I;this.element.append(H)}}this._renderAxis=function(P){P=P||this.element;for(var M in this.handles){if(this.handles[M].constructor==String){this.handles[M]=C(this.handles[M],this.element).show()}if(this.elementIsWrapper&&this.originalElement[0].nodeName.match(/textarea|input|select|button/i)){var N=C(this.handles[M],this.element),O=0;O=/sw|ne|nw|se|n|s/.test(M)?N.outerHeight():N.outerWidth();var L=["padding",/ne|nw|n/.test(M)?"Top":/se|sw|s/.test(M)?"Bottom":/^e$/.test(M)?"Right":"Left"].join("");P.css(L,O);this._proportionallyResize()}if(!C(this.handles[M]).length){continue}}};this._renderAxis(this.element);this._handles=C(".ui-resizable-handle",this.element).disableSelection();this._handles.mouseover(function(){if(!F.resizing){if(this.className){var L=this.className.match(/ui-resizable-(se|sw|ne|nw|n|e|s|w)/i)}F.axis=L&&L[1]?L[1]:"se"}});if(J.autoHide){this._handles.hide();C(this.element).addClass("ui-resizable-autohide").hover(function(){if(J.disabled){return }C(this).removeClass("ui-resizable-autohide");F._handles.show()},function(){if(J.disabled){return }if(!F.resizing){C(this).addClass("ui-resizable-autohide");F._handles.hide()}})}this._mouseInit()},destroy:function(){this._mouseDestroy();var E=function(G){C(G).removeClass("ui-resizable ui-resizable-disabled ui-resizable-resizing").removeData("resizable").unbind(".resizable").find(".ui-resizable-handle").remove()};if(this.elementIsWrapper){E(this.element);var F=this.element;F.after(this.originalElement.css({position:F.css("position"),width:F.outerWidth(),height:F.outerHeight(),top:F.css("top"),left:F.css("left")})).remove()}this.originalElement.css("resize",this.originalResizeStyle);E(this.originalElement);return this},_mouseCapture:function(F){var G=false;for(var E in this.handles){if(C(this.handles[E])[0]==F.target){G=true}}return !this.options.disabled&&G},_mouseStart:function(G){var J=this.options,F=this.element.position(),E=this.element;this.resizing=true;this.documentScroll={top:C(document).scrollTop(),left:C(document).scrollLeft()};if(E.is(".ui-draggable")||(/absolute/).test(E.css("position"))){E.css({position:"absolute",top:F.top,left:F.left})}this._renderProxy();var K=B(this.helper.css("left")),H=B(this.helper.css("top"));if(J.containment){K+=C(J.containment).scrollLeft()||0;H+=C(J.containment).scrollTop()||0}this.offset=this.helper.offset();this.position={left:K,top:H};this.size=this._helper?{width:E.outerWidth(),height:E.outerHeight()}:{width:E.width(),height:E.height()};this.originalSize=this._helper?{width:E.outerWidth(),height:E.outerHeight()}:{width:E.width(),height:E.height()};this.originalPosition={left:K,top:H};this.sizeDiff={width:E.outerWidth()-E.width(),height:E.outerHeight()-E.height()};this.originalMousePosition={left:G.pageX,top:G.pageY};this.aspectRatio=(typeof J.aspectRatio=="number")?J.aspectRatio:((this.originalSize.width/this.originalSize.height)||1);var I=C(".ui-resizable-"+this.axis).css("cursor");C("body").css("cursor",I=="auto"?this.axis+"-resize":I);E.addClass("ui-resizable-resizing");this._propagate("start",G);return true},_mouseDrag:function(E){var H=this.helper,G=this.options,M={},P=this,J=this.originalMousePosition,N=this.axis;var Q=(E.pageX-J.left)||0,O=(E.pageY-J.top)||0;var I=this._change[N];if(!I){return false}var L=I.apply(this,[E,Q,O]),K=C.browser.msie&&C.browser.version<7,F=this.sizeDiff;this._updateVirtualBoundaries(E.shiftKey);if(this._aspectRatio||E.shiftKey){L=this._updateRatio(L,E)}L=this._respectSize(L,E);this._propagate("resize",E);H.css({top:this.position.top+"px",left:this.position.left+"px",width:this.size.width+"px",height:this.size.height+"px"});if(!this._helper&&this._proportionallyResizeElements.length){this._proportionallyResize()}this._updateCache(L);this._trigger("resize",E,this.ui());return false},_mouseStop:function(H){this.resizing=false;var I=this.options,M=this;if(this._helper){var G=this._proportionallyResizeElements,E=G.length&&(/textarea/i).test(G[0].nodeName),F=E&&C.ui.hasScroll(G[0],"left")?0:M.sizeDiff.height,K=E?0:M.sizeDiff.width;var N={width:(M.helper.width()-K),height:(M.helper.height()-F)},J=(parseInt(M.element.css("left"),10)+(M.position.left-M.originalPosition.left))||null,L=(parseInt(M.element.css("top"),10)+(M.position.top-M.originalPosition.top))||null;if(!I.animate){this.element.css(C.extend(N,{top:L,left:J}))}M.helper.height(M.size.height);M.helper.width(M.size.width);if(this._helper&&!I.animate){this._proportionallyResize()}}C("body").css("cursor","auto");this.element.removeClass("ui-resizable-resizing");this._propagate("stop",H);if(this._helper){this.helper.remove()}return false},_updateVirtualBoundaries:function(G){var J=this.options,I,H,F,K,E;E={minWidth:A(J.minWidth)?J.minWidth:0,maxWidth:A(J.maxWidth)?J.maxWidth:Infinity,minHeight:A(J.minHeight)?J.minHeight:0,maxHeight:A(J.maxHeight)?J.maxHeight:Infinity};if(this._aspectRatio||G){I=E.minHeight*this.aspectRatio;F=E.minWidth/this.aspectRatio;H=E.maxHeight*this.aspectRatio;K=E.maxWidth/this.aspectRatio;if(I>E.minWidth){E.minWidth=I}if(F>E.minHeight){E.minHeight=F}if(H<E.maxWidth){E.maxWidth=H}if(K<E.maxHeight){E.maxHeight=K}}this._vBoundaries=E},_updateCache:function(E){var F=this.options;this.offset=this.helper.offset();if(A(E.left)){this.position.left=E.left}if(A(E.top)){this.position.top=E.top}if(A(E.height)){this.size.height=E.height}if(A(E.width)){this.size.width=E.width}},_updateRatio:function(H,G){var I=this.options,J=this.position,F=this.size,E=this.axis;if(A(H.height)){H.width=(H.height*this.aspectRatio)}else{if(A(H.width)){H.height=(H.width/this.aspectRatio)}}if(E=="sw"){H.left=J.left+(F.width-H.width);H.top=null}if(E=="nw"){H.top=J.top+(F.height-H.height);H.left=J.left+(F.width-H.width)}return H},_respectSize:function(L,G){var J=this.helper,I=this._vBoundaries,Q=this._aspectRatio||G.shiftKey,P=this.axis,S=A(L.width)&&I.maxWidth&&(I.maxWidth<L.width),M=A(L.height)&&I.maxHeight&&(I.maxHeight<L.height),H=A(L.width)&&I.minWidth&&(I.minWidth>L.width),R=A(L.height)&&I.minHeight&&(I.minHeight>L.height);if(H){L.width=I.minWidth}if(R){L.height=I.minHeight}if(S){L.width=I.maxWidth}if(M){L.height=I.maxHeight}var F=this.originalPosition.left+this.originalSize.width,O=this.position.top+this.size.height;var K=/sw|nw|w/.test(P),E=/nw|ne|n/.test(P);if(H&&K){L.left=F-I.minWidth}if(S&&K){L.left=F-I.maxWidth}if(R&&E){L.top=O-I.minHeight}if(M&&E){L.top=O-I.maxHeight}var N=!L.width&&!L.height;if(N&&!L.left&&L.top){L.top=null}else{if(N&&!L.top&&L.left){L.left=null}}return L},_proportionallyResize:function(){var J=this.options;if(!this._proportionallyResizeElements.length){return }var G=this.helper||this.element;for(var F=0;F<this._proportionallyResizeElements.length;F++){var H=this._proportionallyResizeElements[F];if(!this.borderDif){var E=[H.css("borderTopWidth"),H.css("borderRightWidth"),H.css("borderBottomWidth"),H.css("borderLeftWidth")],I=[H.css("paddingTop"),H.css("paddingRight"),H.css("paddingBottom"),H.css("paddingLeft")];this.borderDif=C.map(E,function(K,M){var L=parseInt(K,10)||0,N=parseInt(I[M],10)||0;return L+N})}if(C.browser.msie&&!(!(C(G).is(":hidden")||C(G).parents(":hidden").length))){continue}H.css({height:(G.height()-this.borderDif[0]-this.borderDif[2])||0,width:(G.width()-this.borderDif[1]-this.borderDif[3])||0})}},_renderProxy:function(){var F=this.element,I=this.options;this.elementOffset=F.offset();if(this._helper){this.helper=this.helper||C('<div style="overflow:hidden;"></div>');var E=C.browser.msie&&C.browser.version<7,G=(E?1:0),H=(E?2:-1);this.helper.addClass(this._helper).css({width:this.element.outerWidth()+H,height:this.element.outerHeight()+H,position:"absolute",left:this.elementOffset.left-G+"px",top:this.elementOffset.top-G+"px",zIndex:++I.zIndex});this.helper.appendTo("body").disableSelection()}else{this.helper=this.element}},_change:{e:function(G,F,E){return{width:this.originalSize.width+F}},w:function(H,F,E){var J=this.options,G=this.originalSize,I=this.originalPosition;return{left:I.left+F,width:G.width-F}},n:function(H,F,E){var J=this.options,G=this.originalSize,I=this.originalPosition;return{top:I.top+E,height:G.height-E}},s:function(G,F,E){return{height:this.originalSize.height+E}},se:function(G,F,E){return C.extend(this._change.s.apply(this,arguments),this._change.e.apply(this,[G,F,E]))},sw:function(G,F,E){return C.extend(this._change.s.apply(this,arguments),this._change.w.apply(this,[G,F,E]))},ne:function(G,F,E){return C.extend(this._change.n.apply(this,arguments),this._change.e.apply(this,[G,F,E]))},nw:function(G,F,E){return C.extend(this._change.n.apply(this,arguments),this._change.w.apply(this,[G,F,E]))}},_propagate:function(F,E){C.ui.plugin.call(this,F,[E,this.ui()]);(F!="resize"&&this._trigger(F,E,this.ui()))},plugins:{},ui:function(){return{originalElement:this.originalElement,element:this.element,helper:this.helper,position:this.position,size:this.size,originalSize:this.originalSize,originalPosition:this.originalPosition}}});C.extend(C.ui.resizable,{version:"1.8.24"});C.ui.plugin.add("resizable","alsoResize",{start:function(F,G){var E=C(this).data("resizable"),I=E.options;var H=function(J){C(J).each(function(){var K=C(this);K.data("resizable-alsoresize",{width:parseInt(K.width(),10),height:parseInt(K.height(),10),left:parseInt(K.css("left"),10),top:parseInt(K.css("top"),10)})})};if(typeof (I.alsoResize)=="object"&&!I.alsoResize.parentNode){if(I.alsoResize.length){I.alsoResize=I.alsoResize[0];H(I.alsoResize)}else{C.each(I.alsoResize,function(J){H(J)})}}else{H(I.alsoResize)}},resize:function(G,I){var F=C(this).data("resizable"),J=F.options,H=F.originalSize,L=F.originalPosition;var K={height:(F.size.height-H.height)||0,width:(F.size.width-H.width)||0,top:(F.position.top-L.top)||0,left:(F.position.left-L.left)||0},E=function(M,N){C(M).each(function(){var Q=C(this),R=C(this).data("resizable-alsoresize"),P={},O=N&&N.length?N:Q.parents(I.originalElement[0]).length?["width","height"]:["width","height","top","left"];C.each(O,function(S,U){var T=(R[U]||0)+(K[U]||0);if(T&&T>=0){P[U]=T||null}});Q.css(P)})};if(typeof (J.alsoResize)=="object"&&!J.alsoResize.nodeType){C.each(J.alsoResize,function(M,N){E(M,N)})}else{E(J.alsoResize)}},stop:function(E,F){C(this).removeData("resizable-alsoresize")}});C.ui.plugin.add("resizable","animate",{stop:function(I,N){var O=C(this).data("resizable"),J=O.options;var H=O._proportionallyResizeElements,E=H.length&&(/textarea/i).test(H[0].nodeName),F=E&&C.ui.hasScroll(H[0],"left")?0:O.sizeDiff.height,L=E?0:O.sizeDiff.width;var G={width:(O.size.width-L),height:(O.size.height-F)},K=(parseInt(O.element.css("left"),10)+(O.position.left-O.originalPosition.left))||null,M=(parseInt(O.element.css("top"),10)+(O.position.top-O.originalPosition.top))||null;O.element.animate(C.extend(G,M&&K?{top:M,left:K}:{}),{duration:J.animateDuration,easing:J.animateEasing,step:function(){var P={width:parseInt(O.element.css("width"),10),height:parseInt(O.element.css("height"),10),top:parseInt(O.element.css("top"),10),left:parseInt(O.element.css("left"),10)};if(H&&H.length){C(H[0]).css({width:P.width,height:P.height})}O._updateCache(P);O._propagate("resize",I)}})}});C.ui.plugin.add("resizable","containment",{start:function(F,P){var R=C(this).data("resizable"),J=R.options,L=R.element;var G=J.containment,K=(G instanceof C)?G.get(0):(/parent/.test(G))?L.parent().get(0):G;if(!K){return }R.containerElement=C(K);if(/document/.test(G)||G==document){R.containerOffset={left:0,top:0};R.containerPosition={left:0,top:0};R.parentData={element:C(document),left:0,top:0,width:C(document).width(),height:C(document).height()||document.body.parentNode.scrollHeight}}else{var N=C(K),I=[];C(["Top","Right","Left","Bottom"]).each(function(T,S){I[T]=B(N.css("padding"+S))});R.containerOffset=N.offset();R.containerPosition=N.position();R.containerSize={height:(N.innerHeight()-I[3]),width:(N.innerWidth()-I[1])};var O=R.containerOffset,E=R.containerSize.height,M=R.containerSize.width,H=(C.ui.hasScroll(K,"left")?K.scrollWidth:M),Q=(C.ui.hasScroll(K)?K.scrollHeight:E);R.parentData={element:K,left:O.left,top:O.top,width:H,height:Q}}},resize:function(G,P){var S=C(this).data("resizable"),I=S.options,F=S.containerSize,O=S.containerOffset,M=S.size,N=S.position,Q=S._aspectRatio||G.shiftKey,E={top:0,left:0},H=S.containerElement;if(H[0]!=document&&(/static/).test(H.css("position"))){E=O}if(N.left<(S._helper?O.left:0)){S.size.width=S.size.width+(S._helper?(S.position.left-O.left):(S.position.left-E.left));if(Q){S.size.height=S.size.width/S.aspectRatio}S.position.left=I.helper?O.left:0}if(N.top<(S._helper?O.top:0)){S.size.height=S.size.height+(S._helper?(S.position.top-O.top):S.position.top);if(Q){S.size.width=S.size.height*S.aspectRatio}S.position.top=S._helper?O.top:0}S.offset.left=S.parentData.left+S.position.left;S.offset.top=S.parentData.top+S.position.top;var L=Math.abs((S._helper?S.offset.left-E.left:(S.offset.left-E.left))+S.sizeDiff.width),R=Math.abs((S._helper?S.offset.top-E.top:(S.offset.top-O.top))+S.sizeDiff.height);var K=S.containerElement.get(0)==S.element.parent().get(0),J=/relative|absolute/.test(S.containerElement.css("position"));if(K&&J){L-=S.parentData.left}if(L+S.size.width>=S.parentData.width){S.size.width=S.parentData.width-L;if(Q){S.size.height=S.size.width/S.aspectRatio}}if(R+S.size.height>=S.parentData.height){S.size.height=S.parentData.height-R;if(Q){S.size.width=S.size.height*S.aspectRatio}}},stop:function(F,M){var O=C(this).data("resizable"),G=O.options,K=O.position,L=O.containerOffset,E=O.containerPosition,H=O.containerElement;var I=C(O.helper),P=I.offset(),N=I.outerWidth()-O.sizeDiff.width,J=I.outerHeight()-O.sizeDiff.height;if(O._helper&&!G.animate&&(/relative/).test(H.css("position"))){C(this).css({left:P.left-E.left-L.left,width:N,height:J})}if(O._helper&&!G.animate&&(/static/).test(H.css("position"))){C(this).css({left:P.left-E.left-L.left,width:N,height:J})}}});C.ui.plugin.add("resizable","ghost",{start:function(G,H){var E=C(this).data("resizable"),I=E.options,F=E.size;E.ghost=E.originalElement.clone();E.ghost.css({opacity:0.25,display:"block",position:"relative",height:F.height,width:F.width,margin:0,left:0,top:0}).addClass("ui-resizable-ghost").addClass(typeof I.ghost=="string"?I.ghost:"");E.ghost.appendTo(E.helper)},resize:function(F,G){var E=C(this).data("resizable"),H=E.options;if(E.ghost){E.ghost.css({position:"relative",height:E.size.height,width:E.size.width})}},stop:function(F,G){var E=C(this).data("resizable"),H=E.options;if(E.ghost&&E.helper){E.helper.get(0).removeChild(E.ghost.get(0))}}});C.ui.plugin.add("resizable","grid",{resize:function(E,M){var O=C(this).data("resizable"),H=O.options,K=O.size,I=O.originalSize,J=O.originalPosition,N=O.axis,L=H._aspectRatio||E.shiftKey;H.grid=typeof H.grid=="number"?[H.grid,H.grid]:H.grid;var G=Math.round((K.width-I.width)/(H.grid[0]||1))*(H.grid[0]||1),F=Math.round((K.height-I.height)/(H.grid[1]||1))*(H.grid[1]||1);if(/^(se|s|e)$/.test(N)){O.size.width=I.width+G;O.size.height=I.height+F}else{if(/^(ne)$/.test(N)){O.size.width=I.width+G;O.size.height=I.height+F;O.position.top=J.top-F}else{if(/^(sw)$/.test(N)){O.size.width=I.width+G;O.size.height=I.height+F;O.position.left=J.left-G}else{O.size.width=I.width+G;O.size.height=I.height+F;O.position.top=J.top-F;O.position.left=J.left-G}}}}});var B=function(E){return parseInt(E,10)||0};var A=function(E){return !isNaN(parseInt(E,10))}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-ui-interactions', location = 'js-vendor/jquery/jquery-ui/jquery.ui.selectable.js' */
/*
 * jQuery UI Selectable 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Selectables
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.mouse.js
 *	jquery.ui.widget.js
 */
(function(A,B){A.widget("ui.selectable",A.ui.mouse,{options:{appendTo:"body",autoRefresh:true,distance:0,filter:"*",tolerance:"touch"},_create:function(){var C=this;this.element.addClass("ui-selectable");this.dragged=false;var D;this.refresh=function(){D=A(C.options.filter,C.element[0]);D.addClass("ui-selectee");D.each(function(){var E=A(this);var F=E.offset();A.data(this,"selectable-item",{element:this,$element:E,left:F.left,top:F.top,right:F.left+E.outerWidth(),bottom:F.top+E.outerHeight(),startselected:false,selected:E.hasClass("ui-selected"),selecting:E.hasClass("ui-selecting"),unselecting:E.hasClass("ui-unselecting")})})};this.refresh();this.selectees=D.addClass("ui-selectee");this._mouseInit();this.helper=A("<div class='ui-selectable-helper'></div>")},destroy:function(){this.selectees.removeClass("ui-selectee").removeData("selectable-item");this.element.removeClass("ui-selectable ui-selectable-disabled").removeData("selectable").unbind(".selectable");this._mouseDestroy();return this},_mouseStart:function(E){var C=this;this.opos=[E.pageX,E.pageY];if(this.options.disabled){return }var D=this.options;this.selectees=A(D.filter,this.element[0]);this._trigger("start",E);A(D.appendTo).append(this.helper);this.helper.css({left:E.clientX,top:E.clientY,width:0,height:0});if(D.autoRefresh){this.refresh()}this.selectees.filter(".ui-selected").each(function(){var F=A.data(this,"selectable-item");F.startselected=true;if(!E.metaKey&&!E.ctrlKey){F.$element.removeClass("ui-selected");F.selected=false;F.$element.addClass("ui-unselecting");F.unselecting=true;C._trigger("unselecting",E,{unselecting:F.element})}});A(E.target).parents().andSelf().each(function(){var G=A.data(this,"selectable-item");if(G){var F=(!E.metaKey&&!E.ctrlKey)||!G.$element.hasClass("ui-selected");G.$element.removeClass(F?"ui-unselecting":"ui-selected").addClass(F?"ui-selecting":"ui-unselecting");G.unselecting=!F;G.selecting=F;G.selected=F;if(F){C._trigger("selecting",E,{selecting:G.element})}else{C._trigger("unselecting",E,{unselecting:G.element})}return false}})},_mouseDrag:function(J){var D=this;this.dragged=true;if(this.options.disabled){return }var F=this.options;var E=this.opos[0],I=this.opos[1],C=J.pageX,H=J.pageY;if(E>C){var G=C;C=E;E=G}if(I>H){var G=H;H=I;I=G}this.helper.css({left:E,top:I,width:C-E,height:H-I});this.selectees.each(function(){var K=A.data(this,"selectable-item");if(!K||K.element==D.element[0]){return }var L=false;if(F.tolerance=="touch"){L=(!(K.left>C||K.right<E||K.top>H||K.bottom<I))}else{if(F.tolerance=="fit"){L=(K.left>E&&K.right<C&&K.top>I&&K.bottom<H)}}if(L){if(K.selected){K.$element.removeClass("ui-selected");K.selected=false}if(K.unselecting){K.$element.removeClass("ui-unselecting");K.unselecting=false}if(!K.selecting){K.$element.addClass("ui-selecting");K.selecting=true;D._trigger("selecting",J,{selecting:K.element})}}else{if(K.selecting){if((J.metaKey||J.ctrlKey)&&K.startselected){K.$element.removeClass("ui-selecting");K.selecting=false;K.$element.addClass("ui-selected");K.selected=true}else{K.$element.removeClass("ui-selecting");K.selecting=false;if(K.startselected){K.$element.addClass("ui-unselecting");K.unselecting=true}D._trigger("unselecting",J,{unselecting:K.element})}}if(K.selected){if(!J.metaKey&&!J.ctrlKey&&!K.startselected){K.$element.removeClass("ui-selected");K.selected=false;K.$element.addClass("ui-unselecting");K.unselecting=true;D._trigger("unselecting",J,{unselecting:K.element})}}}});return false},_mouseStop:function(E){var C=this;this.dragged=false;var D=this.options;A(".ui-unselecting",this.element[0]).each(function(){var F=A.data(this,"selectable-item");F.$element.removeClass("ui-unselecting");F.unselecting=false;F.startselected=false;C._trigger("unselected",E,{unselected:F.element})});A(".ui-selecting",this.element[0]).each(function(){var F=A.data(this,"selectable-item");F.$element.removeClass("ui-selecting").addClass("ui-selected");F.selecting=false;F.selected=true;F.startselected=true;C._trigger("selected",E,{selected:F.element})});this._trigger("stop",E);this.helper.remove();return false}});A.extend(A.ui.selectable,{version:"1.8.24"})})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-ui-widgets', location = 'js-vendor/jquery/jquery-ui/jquery.ui.accordion.js' */
/*
 * jQuery UI Accordion 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Accordion
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 */
(function(A,B){A.widget("ui.accordion",{options:{active:0,animated:"slide",autoHeight:true,clearStyle:false,collapsible:false,event:"click",fillSpace:false,header:"> li > :first-child,> :not(li):even",icons:{header:"ui-icon-triangle-1-e",headerSelected:"ui-icon-triangle-1-s"},navigation:false,navigationFilter:function(){return this.href.toLowerCase()===location.href.toLowerCase()}},_create:function(){var C=this,D=C.options;C.running=0;C.element.addClass("ui-accordion ui-widget ui-helper-reset").children("li").addClass("ui-accordion-li-fix");C.headers=C.element.find(D.header).addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-all").bind("mouseenter.accordion",function(){if(D.disabled){return }A(this).addClass("ui-state-hover")}).bind("mouseleave.accordion",function(){if(D.disabled){return }A(this).removeClass("ui-state-hover")}).bind("focus.accordion",function(){if(D.disabled){return }A(this).addClass("ui-state-focus")}).bind("blur.accordion",function(){if(D.disabled){return }A(this).removeClass("ui-state-focus")});C.headers.next().addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom");if(D.navigation){var E=C.element.find("a").filter(D.navigationFilter).eq(0);if(E.length){var F=E.closest(".ui-accordion-header");if(F.length){C.active=F}else{C.active=E.closest(".ui-accordion-content").prev()}}}C.active=C._findActive(C.active||D.active).addClass("ui-state-default ui-state-active").toggleClass("ui-corner-all").toggleClass("ui-corner-top");C.active.next().addClass("ui-accordion-content-active");C._createIcons();C.resize();C.element.attr("role","tablist");C.headers.attr("role","tab").bind("keydown.accordion",function(G){return C._keydown(G)}).next().attr("role","tabpanel");C.headers.not(C.active||"").attr({"aria-expanded":"false","aria-selected":"false",tabIndex:-1}).next().hide();if(!C.active.length){C.headers.eq(0).attr("tabIndex",0)}else{C.active.attr({"aria-expanded":"true","aria-selected":"true",tabIndex:0})}if(!A.browser.safari){C.headers.find("a").attr("tabIndex",-1)}if(D.event){C.headers.bind(D.event.split(" ").join(".accordion ")+".accordion",function(G){C._clickHandler.call(C,G,this);G.preventDefault()})}},_createIcons:function(){var C=this.options;if(C.icons){A("<span></span>").addClass("ui-icon "+C.icons.header).prependTo(this.headers);this.active.children(".ui-icon").toggleClass(C.icons.header).toggleClass(C.icons.headerSelected);this.element.addClass("ui-accordion-icons")}},_destroyIcons:function(){this.headers.children(".ui-icon").remove();this.element.removeClass("ui-accordion-icons")},destroy:function(){var C=this.options;this.element.removeClass("ui-accordion ui-widget ui-helper-reset").removeAttr("role");this.headers.unbind(".accordion").removeClass("ui-accordion-header ui-accordion-disabled ui-helper-reset ui-state-default ui-corner-all ui-state-active ui-state-disabled ui-corner-top").removeAttr("role").removeAttr("aria-expanded").removeAttr("aria-selected").removeAttr("tabIndex");this.headers.find("a").removeAttr("tabIndex");this._destroyIcons();var D=this.headers.next().css("display","").removeAttr("role").removeClass("ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content ui-accordion-content-active ui-accordion-disabled ui-state-disabled");if(C.autoHeight||C.fillHeight){D.css("height","")}return A.Widget.prototype.destroy.call(this)},_setOption:function(C,D){A.Widget.prototype._setOption.apply(this,arguments);if(C=="active"){this.activate(D)}if(C=="icons"){this._destroyIcons();if(D){this._createIcons()}}if(C=="disabled"){this.headers.add(this.headers.next())[D?"addClass":"removeClass"]("ui-accordion-disabled ui-state-disabled")}},_keydown:function(F){if(this.options.disabled||F.altKey||F.ctrlKey){return }var G=A.ui.keyCode,E=this.headers.length,C=this.headers.index(F.target),D=false;switch(F.keyCode){case G.RIGHT:case G.DOWN:D=this.headers[(C+1)%E];break;case G.LEFT:case G.UP:D=this.headers[(C-1+E)%E];break;case G.SPACE:case G.ENTER:this._clickHandler({target:F.target},F.target);F.preventDefault()}if(D){A(F.target).attr("tabIndex",-1);A(D).attr("tabIndex",0);D.focus();return false}return true},resize:function(){var C=this.options,E;if(C.fillSpace){if(A.browser.msie){var D=this.element.parent().css("overflow");this.element.parent().css("overflow","hidden")}E=this.element.parent().height();if(A.browser.msie){this.element.parent().css("overflow",D)}this.headers.each(function(){E-=A(this).outerHeight(true)});this.headers.next().each(function(){A(this).height(Math.max(0,E-A(this).innerHeight()+A(this).height()))}).css("overflow","auto")}else{if(C.autoHeight){E=0;this.headers.next().each(function(){E=Math.max(E,A(this).height("").height())}).height(E)}}return this},activate:function(C){this.options.active=C;var D=this._findActive(C)[0];this._clickHandler({target:D},D);return this},_findActive:function(C){return C?typeof C==="number"?this.headers.filter(":eq("+C+")"):this.headers.not(this.headers.not(C)):C===false?A([]):this.headers.filter(":eq(0)")},_clickHandler:function(C,G){var L=this.options;if(L.disabled){return }if(!C.target){if(!L.collapsible){return }this.active.removeClass("ui-state-active ui-corner-top").addClass("ui-state-default ui-corner-all").children(".ui-icon").removeClass(L.icons.headerSelected).addClass(L.icons.header);this.active.next().addClass("ui-accordion-content-active");var I=this.active.next(),F={options:L,newHeader:A([]),oldHeader:L.active,newContent:A([]),oldContent:I},D=(this.active=A([]));this._toggle(D,I,F);return }var H=A(C.currentTarget||G),J=H[0]===this.active[0];L.active=L.collapsible&&J?false:this.headers.index(H);if(this.running||(!L.collapsible&&J)){return }var E=this.active,D=H.next(),I=this.active.next(),F={options:L,newHeader:J&&L.collapsible?A([]):H,oldHeader:this.active,newContent:J&&L.collapsible?A([]):D,oldContent:I},K=this.headers.index(this.active[0])>this.headers.index(H[0]);this.active=J?A([]):H;this._toggle(D,I,F,J,K);E.removeClass("ui-state-active ui-corner-top").addClass("ui-state-default ui-corner-all").children(".ui-icon").removeClass(L.icons.headerSelected).addClass(L.icons.header);if(!J){H.removeClass("ui-state-default ui-corner-all").addClass("ui-state-active ui-corner-top").children(".ui-icon").removeClass(L.icons.header).addClass(L.icons.headerSelected);H.next().addClass("ui-accordion-content-active")}return },_toggle:function(C,I,G,J,K){var M=this,N=M.options;M.toShow=C;M.toHide=I;M.data=G;var D=function(){if(!M){return }return M._completed.apply(M,arguments)};M._trigger("changestart",null,M.data);M.running=I.size()===0?C.size():I.size();if(N.animated){var F={};if(N.collapsible&&J){F={toShow:A([]),toHide:I,complete:D,down:K,autoHeight:N.autoHeight||N.fillSpace}}else{F={toShow:C,toHide:I,complete:D,down:K,autoHeight:N.autoHeight||N.fillSpace}}if(!N.proxied){N.proxied=N.animated}if(!N.proxiedDuration){N.proxiedDuration=N.duration}N.animated=A.isFunction(N.proxied)?N.proxied(F):N.proxied;N.duration=A.isFunction(N.proxiedDuration)?N.proxiedDuration(F):N.proxiedDuration;var L=A.ui.accordion.animations,E=N.duration,H=N.animated;if(H&&!L[H]&&!A.easing[H]){H="slide"}if(!L[H]){L[H]=function(O){this.slide(O,{easing:H,duration:E||700})}}L[H](F)}else{if(N.collapsible&&J){C.toggle()}else{I.hide();C.show()}D(true)}I.prev().attr({"aria-expanded":"false","aria-selected":"false",tabIndex:-1}).blur();C.prev().attr({"aria-expanded":"true","aria-selected":"true",tabIndex:0}).focus()},_completed:function(C){this.running=C?0:--this.running;if(this.running){return }if(this.options.clearStyle){this.toShow.add(this.toHide).css({height:"",overflow:""})}this.toHide.removeClass("ui-accordion-content-active");if(this.toHide.length){this.toHide.parent()[0].className=this.toHide.parent()[0].className}this._trigger("change",null,this.data)}});A.extend(A.ui.accordion,{version:"1.8.24",animations:{slide:function(K,I){K=A.extend({easing:"swing",duration:300},K,I);if(!K.toHide.size()){K.toShow.animate({height:"show",paddingTop:"show",paddingBottom:"show"},K);return }if(!K.toShow.size()){K.toHide.animate({height:"hide",paddingTop:"hide",paddingBottom:"hide"},K);return }var D=K.toShow.css("overflow"),H=0,E={},G={},F=["height","paddingTop","paddingBottom"],C;var J=K.toShow;C=J[0].style.width;J.width(J.parent().width()-parseFloat(J.css("paddingLeft"))-parseFloat(J.css("paddingRight"))-(parseFloat(J.css("borderLeftWidth"))||0)-(parseFloat(J.css("borderRightWidth"))||0));A.each(F,function(L,N){G[N]="hide";var M=(""+A.css(K.toShow[0],N)).match(/^([\d+-.]+)(.*)$/);E[N]={value:M[1],unit:M[2]||"px"}});K.toShow.css({height:0,overflow:"hidden"}).show();K.toHide.filter(":hidden").each(K.complete).end().filter(":visible").animate(G,{step:function(L,M){if(M.prop=="height"){H=(M.end-M.start===0)?0:(M.now-M.start)/(M.end-M.start)}K.toShow[0].style[M.prop]=(H*E[M.prop].value)+E[M.prop].unit},duration:K.duration,easing:K.easing,complete:function(){if(!K.autoHeight){K.toShow.css("height","")}K.toShow.css({width:C,overflow:D});K.complete()}})},bounceslide:function(C){this.slide(C,{easing:C.down?"easeOutBounce":"swing",duration:C.down?1000:200})}}})})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-ui-widgets', location = 'js-vendor/jquery/jquery-ui/jquery.ui.autocomplete.js' */
/*
 * jQuery UI Autocomplete 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Autocomplete
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 *	jquery.ui.position.js
 */
(function(A,B){var C=0;A.widget("ui.autocomplete",{options:{appendTo:"body",autoFocus:false,delay:300,minLength:1,position:{my:"left top",at:"left bottom",collision:"none"},source:null},pending:0,_create:function(){var D=this,F=this.element[0].ownerDocument,E;this.isMultiLine=this.element.is("textarea");this.element.addClass("ui-autocomplete-input").attr("autocomplete","off").attr({role:"textbox","aria-autocomplete":"list","aria-haspopup":"true"}).bind("keydown.autocomplete",function(G){if(D.options.disabled||D.element.propAttr("readOnly")){return }E=false;var H=A.ui.keyCode;switch(G.keyCode){case H.PAGE_UP:D._move("previousPage",G);break;case H.PAGE_DOWN:D._move("nextPage",G);break;case H.UP:D._keyEvent("previous",G);break;case H.DOWN:D._keyEvent("next",G);break;case H.ENTER:case H.NUMPAD_ENTER:if(D.menu.active){E=true;G.preventDefault()}case H.TAB:if(!D.menu.active){return }D.menu.select(G);break;case H.ESCAPE:D.element.val(D.term);D.close(G);break;default:clearTimeout(D.searching);D.searching=setTimeout(function(){if(D.term!=D.element.val()){D.selectedItem=null;D.search(null,G)}},D.options.delay);break}}).bind("keypress.autocomplete",function(G){if(E){E=false;G.preventDefault()}}).bind("focus.autocomplete",function(){if(D.options.disabled){return }D.selectedItem=null;D.previous=D.element.val()}).bind("blur.autocomplete",function(G){if(D.options.disabled){return }clearTimeout(D.searching);D.closing=setTimeout(function(){D.close(G);D._change(G)},150)});this._initSource();this.menu=A("<ul></ul>").addClass("ui-autocomplete").appendTo(A(this.options.appendTo||"body",F)[0]).mousedown(function(G){var H=D.menu.element[0];if(!A(G.target).closest(".ui-menu-item").length){setTimeout(function(){A(document).one("mousedown",function(I){if(I.target!==D.element[0]&&I.target!==H&&!A.ui.contains(H,I.target)){D.close()}})},1)}setTimeout(function(){clearTimeout(D.closing)},13)}).menu({focus:function(H,I){var G=I.item.data("item.autocomplete");if(false!==D._trigger("focus",H,{item:G})){if(/^key/.test(H.originalEvent.type)){D.element.val(G.value)}}},selected:function(I,J){var H=J.item.data("item.autocomplete"),G=D.previous;if(D.element[0]!==F.activeElement){D.element.focus();D.previous=G;setTimeout(function(){D.previous=G;D.selectedItem=H},1)}if(false!==D._trigger("select",I,{item:H})){D.element.val(H.value)}D.term=D.element.val();D.close(I);D.selectedItem=H},blur:function(G,H){if(D.menu.element.is(":visible")&&(D.element.val()!==D.term)){D.element.val(D.term)}}}).zIndex(this.element.zIndex()+1).css({top:0,left:0}).hide().data("menu");if(A.fn.bgiframe){this.menu.element.bgiframe()}D.beforeunloadHandler=function(){D.element.removeAttr("autocomplete")};A(window).bind("beforeunload",D.beforeunloadHandler)},destroy:function(){this.element.removeClass("ui-autocomplete-input").removeAttr("autocomplete").removeAttr("role").removeAttr("aria-autocomplete").removeAttr("aria-haspopup");this.menu.element.remove();A(window).unbind("beforeunload",this.beforeunloadHandler);A.Widget.prototype.destroy.call(this)},_setOption:function(D,E){A.Widget.prototype._setOption.apply(this,arguments);if(D==="source"){this._initSource()}if(D==="appendTo"){this.menu.element.appendTo(A(E||"body",this.element[0].ownerDocument)[0])}if(D==="disabled"&&E&&this.xhr){this.xhr.abort()}},_initSource:function(){var D=this,F,E;if(A.isArray(this.options.source)){F=this.options.source;this.source=function(H,G){G(A.ui.autocomplete.filter(F,H.term))}}else{if(typeof this.options.source==="string"){E=this.options.source;this.source=function(H,G){if(D.xhr){D.xhr.abort()}D.xhr=A.ajax({url:E,data:H,dataType:"json",success:function(J,I){G(J)},error:function(){G([])}})}}else{this.source=this.options.source}}},search:function(E,D){E=E!=null?E:this.element.val();this.term=this.element.val();if(E.length<this.options.minLength){return this.close(D)}clearTimeout(this.closing);if(this._trigger("search",D)===false){return }return this._search(E)},_search:function(D){this.pending++;this.element.addClass("ui-autocomplete-loading");this.source({term:D},this._response())},_response:function(){var E=this,D=++C;return function(F){if(D===C){E.__response(F)}E.pending--;if(!E.pending){E.element.removeClass("ui-autocomplete-loading")}}},__response:function(D){if(!this.options.disabled&&D&&D.length){D=this._normalize(D);this._suggest(D);this._trigger("open")}else{this.close()}},close:function(D){clearTimeout(this.closing);if(this.menu.element.is(":visible")){this.menu.element.hide();this.menu.deactivate();this._trigger("close",D)}},_change:function(D){if(this.previous!==this.element.val()){this._trigger("change",D,{item:this.selectedItem})}},_normalize:function(D){if(D.length&&D[0].label&&D[0].value){return D}return A.map(D,function(E){if(typeof E==="string"){return{label:E,value:E}}return A.extend({label:E.label||E.value,value:E.value||E.label},E)})},_suggest:function(D){var E=this.menu.element.empty().zIndex(this.element.zIndex()+1);this._renderMenu(E,D);this.menu.deactivate();this.menu.refresh();E.show();this._resizeMenu();E.position(A.extend({of:this.element},this.options.position));if(this.options.autoFocus){this.menu.next(new A.Event("mouseover"))}},_resizeMenu:function(){var D=this.menu.element;D.outerWidth(Math.max(D.width("").outerWidth()+1,this.element.outerWidth()))},_renderMenu:function(F,E){var D=this;A.each(E,function(G,H){D._renderItem(F,H)})},_renderItem:function(D,E){return A("<li></li>").data("item.autocomplete",E).append(A("<a></a>").text(E.label)).appendTo(D)},_move:function(E,D){if(!this.menu.element.is(":visible")){this.search(null,D);return }if(this.menu.first()&&/^previous/.test(E)||this.menu.last()&&/^next/.test(E)){this.element.val(this.term);this.menu.deactivate();return }this.menu[E](D)},widget:function(){return this.menu.element},_keyEvent:function(E,D){if(!this.isMultiLine||this.menu.element.is(":visible")){this._move(E,D);D.preventDefault()}}});A.extend(A.ui.autocomplete,{escapeRegex:function(D){return D.replace(/[-[\]{}()*+?.,\\^$|#\s]/g,"\\$&")},filter:function(F,D){var E=new RegExp(A.ui.autocomplete.escapeRegex(D),"i");return A.grep(F,function(G){return E.test(G.label||G.value||G)})}})}(jQuery));(function(A){A.widget("ui.menu",{_create:function(){var B=this;this.element.addClass("ui-menu ui-widget ui-widget-content ui-corner-all").attr({role:"listbox","aria-activedescendant":"ui-active-menuitem"}).click(function(C){if(!A(C.target).closest(".ui-menu-item a").length){return }C.preventDefault();B.select(C)});this.refresh()},refresh:function(){var C=this;var B=this.element.children("li:not(.ui-menu-item):has(a)").addClass("ui-menu-item").attr("role","menuitem");B.children("a").addClass("ui-corner-all").attr("tabindex",-1).mouseenter(function(D){C.activate(D,A(this).parent())}).mouseleave(function(){C.deactivate()})},activate:function(E,D){this.deactivate();if(this.hasScroll()){var F=D.offset().top-this.element.offset().top,B=this.element.scrollTop(),C=this.element.height();if(F<0){this.element.scrollTop(B+F)}else{if(F>=C){this.element.scrollTop(B+F-C+D.height())}}}this.active=D.eq(0).children("a").addClass("ui-state-hover").attr("id","ui-active-menuitem").end();this._trigger("focus",E,{item:D})},deactivate:function(){if(!this.active){return }this.active.children("a").removeClass("ui-state-hover").removeAttr("id");this._trigger("blur");this.active=null},next:function(B){this.move("next",".ui-menu-item:first",B)},previous:function(B){this.move("prev",".ui-menu-item:last",B)},first:function(){return this.active&&!this.active.prevAll(".ui-menu-item").length},last:function(){return this.active&&!this.active.nextAll(".ui-menu-item").length},move:function(E,D,C){if(!this.active){this.activate(C,this.element.children(D));return }var B=this.active[E+"All"](".ui-menu-item").eq(0);if(B.length){this.activate(C,B)}else{this.activate(C,this.element.children(D))}},nextPage:function(D){if(this.hasScroll()){if(!this.active||this.last()){this.activate(D,this.element.children(".ui-menu-item:first"));return }var E=this.active.offset().top,C=this.element.height(),B=this.element.children(".ui-menu-item").filter(function(){var F=A(this).offset().top-E-C+A(this).height();return F<10&&F>-10});if(!B.length){B=this.element.children(".ui-menu-item:last")}this.activate(D,B)}else{this.activate(D,this.element.children(".ui-menu-item").filter(!this.active||this.last()?":first":":last"))}},previousPage:function(D){if(this.hasScroll()){if(!this.active||this.first()){this.activate(D,this.element.children(".ui-menu-item:last"));return }var E=this.active.offset().top,C=this.element.height(),B=this.element.children(".ui-menu-item").filter(function(){var F=A(this).offset().top-E+C-A(this).height();return F<10&&F>-10});if(!B.length){B=this.element.children(".ui-menu-item:first")}this.activate(D,B)}else{this.activate(D,this.element.children(".ui-menu-item").filter(!this.active||this.first()?":last":":first"))}},hasScroll:function(){return this.element.height()<this.element[A.fn.prop?"prop":"attr"]("scrollHeight")},select:function(B){this._trigger("selected",B,{item:this.active})}})}(jQuery));
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-ui-widgets', location = 'js-vendor/jquery/jquery-ui/jquery.ui.button.js' */
/*
 * jQuery UI Button 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Button
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 */
(function(F,B){var K,E,A,H,I="ui-button ui-widget ui-state-default ui-corner-all",C="ui-state-hover ui-state-active ",G="ui-button-icons-only ui-button-icon-only ui-button-text-icons ui-button-text-icon-primary ui-button-text-icon-secondary ui-button-text-only",J=function(){var L=F(this).find(":ui-button");setTimeout(function(){L.button("refresh")},1)},D=function(M){var L=M.name,N=M.form,O=F([]);if(L){if(N){O=F(N).find("[name='"+L+"']")}else{O=F("[name='"+L+"']",M.ownerDocument).filter(function(){return !this.form})}}return O};F.widget("ui.button",{options:{disabled:null,text:true,label:null,icons:{primary:null,secondary:null}},_create:function(){this.element.closest("form").unbind("reset.button").bind("reset.button",J);if(typeof this.options.disabled!=="boolean"){this.options.disabled=!!this.element.propAttr("disabled")}else{this.element.propAttr("disabled",this.options.disabled)}this._determineButtonType();this.hasTitle=!!this.buttonElement.attr("title");var L=this,N=this.options,O=this.type==="checkbox"||this.type==="radio",P="ui-state-hover"+(!O?" ui-state-active":""),M="ui-state-focus";if(N.label===null){N.label=this.buttonElement.html()}this.buttonElement.addClass(I).attr("role","button").bind("mouseenter.button",function(){if(N.disabled){return }F(this).addClass("ui-state-hover");if(this===K){F(this).addClass("ui-state-active")}}).bind("mouseleave.button",function(){if(N.disabled){return }F(this).removeClass(P)}).bind("click.button",function(Q){if(N.disabled){Q.preventDefault();Q.stopImmediatePropagation()}});this.element.bind("focus.button",function(){L.buttonElement.addClass(M)}).bind("blur.button",function(){L.buttonElement.removeClass(M)});if(O){this.element.bind("change.button",function(){if(H){return }L.refresh()});this.buttonElement.bind("mousedown.button",function(Q){if(N.disabled){return }H=false;E=Q.pageX;A=Q.pageY}).bind("mouseup.button",function(Q){if(N.disabled){return }if(E!==Q.pageX||A!==Q.pageY){H=true}})}if(this.type==="checkbox"){this.buttonElement.bind("click.button",function(){if(N.disabled||H){return false}F(this).toggleClass("ui-state-active");L.buttonElement.attr("aria-pressed",L.element[0].checked)})}else{if(this.type==="radio"){this.buttonElement.bind("click.button",function(){if(N.disabled||H){return false}F(this).addClass("ui-state-active");L.buttonElement.attr("aria-pressed","true");var Q=L.element[0];D(Q).not(Q).map(function(){return F(this).button("widget")[0]}).removeClass("ui-state-active").attr("aria-pressed","false")})}else{this.buttonElement.bind("mousedown.button",function(){if(N.disabled){return false}F(this).addClass("ui-state-active");K=this;F(document).one("mouseup",function(){K=null})}).bind("mouseup.button",function(){if(N.disabled){return false}F(this).removeClass("ui-state-active")}).bind("keydown.button",function(Q){if(N.disabled){return false}if(Q.keyCode==F.ui.keyCode.SPACE||Q.keyCode==F.ui.keyCode.ENTER){F(this).addClass("ui-state-active")}}).bind("keyup.button",function(){F(this).removeClass("ui-state-active")});if(this.buttonElement.is("a")){this.buttonElement.keyup(function(Q){if(Q.keyCode===F.ui.keyCode.SPACE){F(this).click()}})}}}this._setOption("disabled",N.disabled);this._resetButton()},_determineButtonType:function(){if(this.element.is(":checkbox")){this.type="checkbox"}else{if(this.element.is(":radio")){this.type="radio"}else{if(this.element.is("input")){this.type="input"}else{this.type="button"}}}if(this.type==="checkbox"||this.type==="radio"){var L=this.element.parents().filter(":last"),N="label[for='"+this.element.attr("id")+"']";this.buttonElement=L.find(N);if(!this.buttonElement.length){L=L.length?L.siblings():this.element.siblings();this.buttonElement=L.filter(N);if(!this.buttonElement.length){this.buttonElement=L.find(N)}}this.element.addClass("ui-helper-hidden-accessible");var M=this.element.is(":checked");if(M){this.buttonElement.addClass("ui-state-active")}this.buttonElement.attr("aria-pressed",M)}else{this.buttonElement=this.element}},widget:function(){return this.buttonElement},destroy:function(){this.element.removeClass("ui-helper-hidden-accessible");this.buttonElement.removeClass(I+" "+C+" "+G).removeAttr("role").removeAttr("aria-pressed").html(this.buttonElement.find(".ui-button-text").html());if(!this.hasTitle){this.buttonElement.removeAttr("title")}F.Widget.prototype.destroy.call(this)},_setOption:function(L,M){F.Widget.prototype._setOption.apply(this,arguments);if(L==="disabled"){if(M){this.element.propAttr("disabled",true)}else{this.element.propAttr("disabled",false)}return }this._resetButton()},refresh:function(){var L=this.element.is(":disabled");if(L!==this.options.disabled){this._setOption("disabled",L)}if(this.type==="radio"){D(this.element[0]).each(function(){if(F(this).is(":checked")){F(this).button("widget").addClass("ui-state-active").attr("aria-pressed","true")}else{F(this).button("widget").removeClass("ui-state-active").attr("aria-pressed","false")}})}else{if(this.type==="checkbox"){if(this.element.is(":checked")){this.buttonElement.addClass("ui-state-active").attr("aria-pressed","true")}else{this.buttonElement.removeClass("ui-state-active").attr("aria-pressed","false")}}}},_resetButton:function(){if(this.type==="input"){if(this.options.label){this.element.val(this.options.label)}return }var P=this.buttonElement.removeClass(G),N=F("<span></span>",this.element[0].ownerDocument).addClass("ui-button-text").html(this.options.label).appendTo(P.empty()).text(),M=this.options.icons,L=M.primary&&M.secondary,O=[];if(M.primary||M.secondary){if(this.options.text){O.push("ui-button-text-icon"+(L?"s":(M.primary?"-primary":"-secondary")))}if(M.primary){P.prepend("<span class='ui-button-icon-primary ui-icon "+M.primary+"'></span>")}if(M.secondary){P.append("<span class='ui-button-icon-secondary ui-icon "+M.secondary+"'></span>")}if(!this.options.text){O.push(L?"ui-button-icons-only":"ui-button-icon-only");if(!this.hasTitle){P.attr("title",N)}}}else{O.push("ui-button-text-only")}P.addClass(O.join(" "))}});F.widget("ui.buttonset",{options:{items:":button, :submit, :reset, :checkbox, :radio, a, :data(button)"},_create:function(){this.element.addClass("ui-buttonset")},_init:function(){this.refresh()},_setOption:function(L,M){if(L==="disabled"){this.buttons.button("option",L,M)}F.Widget.prototype._setOption.apply(this,arguments)},refresh:function(){var L=this.element.css("direction")==="rtl";this.buttons=this.element.find(this.options.items).filter(":ui-button").button("refresh").end().not(":ui-button").button().end().map(function(){return F(this).button("widget")[0]}).removeClass("ui-corner-all ui-corner-left ui-corner-right").filter(":first").addClass(L?"ui-corner-right":"ui-corner-left").end().filter(":last").addClass(L?"ui-corner-left":"ui-corner-right").end().end()},destroy:function(){this.element.removeClass("ui-buttonset");this.buttons.map(function(){return F(this).button("widget")[0]}).removeClass("ui-corner-left ui-corner-right").end().button("destroy");F.Widget.prototype.destroy.call(this)}})}(jQuery));
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-ui-widgets', location = 'js-vendor/jquery/jquery-ui/jquery.ui.dialog.js' */
/*
 * jQuery UI Dialog 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Dialog
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 *  jquery.ui.button.js
 *	jquery.ui.draggable.js
 *	jquery.ui.mouse.js
 *	jquery.ui.position.js
 *	jquery.ui.resizable.js
 */
(function(D,E){var B="ui-dialog ui-widget ui-widget-content ui-corner-all ",A={buttons:true,height:true,maxHeight:true,maxWidth:true,minHeight:true,minWidth:true,width:true},C={maxHeight:true,maxWidth:true,minHeight:true,minWidth:true};D.widget("ui.dialog",{options:{autoOpen:true,buttons:{},closeOnEscape:true,closeText:"close",dialogClass:"",draggable:true,hide:null,height:"auto",maxHeight:false,maxWidth:false,minHeight:150,minWidth:150,modal:false,position:{my:"center",at:"center",collision:"fit",using:function(G){var F=D(this).css(G).offset().top;if(F<0){D(this).css("top",G.top-F)}}},resizable:true,show:null,stack:true,title:"",width:300,zIndex:1000},_create:function(){this.originalTitle=this.element.attr("title");if(typeof this.originalTitle!=="string"){this.originalTitle=""}this.options.title=this.options.title||this.originalTitle;var N=this,O=N.options,L=O.title||"&#160;",G=D.ui.dialog.getTitleId(N.element),M=(N.uiDialog=D("<div></div>")).appendTo(document.body).hide().addClass(B+O.dialogClass).css({zIndex:O.zIndex}).attr("tabIndex",-1).css("outline",0).keydown(function(P){if(O.closeOnEscape&&!P.isDefaultPrevented()&&P.keyCode&&P.keyCode===D.ui.keyCode.ESCAPE){N.close(P);P.preventDefault()}}).attr({role:"dialog","aria-labelledby":G}).mousedown(function(P){N.moveToTop(false,P)}),I=N.element.show().removeAttr("title").addClass("ui-dialog-content ui-widget-content").appendTo(M),H=(N.uiDialogTitlebar=D("<div></div>")).addClass("ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix").prependTo(M),K=D('<a href="#"></a>').addClass("ui-dialog-titlebar-close ui-corner-all").attr("role","button").hover(function(){K.addClass("ui-state-hover")},function(){K.removeClass("ui-state-hover")}).focus(function(){K.addClass("ui-state-focus")}).blur(function(){K.removeClass("ui-state-focus")}).click(function(P){N.close(P);return false}).appendTo(H),J=(N.uiDialogTitlebarCloseText=D("<span></span>")).addClass("ui-icon ui-icon-closethick").text(O.closeText).appendTo(K),F=D("<span></span>").addClass("ui-dialog-title").attr("id",G).html(L).prependTo(H);if(D.isFunction(O.beforeclose)&&!D.isFunction(O.beforeClose)){O.beforeClose=O.beforeclose}H.find("*").add(H).disableSelection();if(O.draggable&&D.fn.draggable){N._makeDraggable()}if(O.resizable&&D.fn.resizable){N._makeResizable()}N._createButtons(O.buttons);N._isOpen=false;if(D.fn.bgiframe){M.bgiframe()}},_init:function(){if(this.options.autoOpen){this.open()}},destroy:function(){var F=this;if(F.overlay){F.overlay.destroy()}F.uiDialog.hide();F.element.unbind(".dialog").removeData("dialog").removeClass("ui-dialog-content ui-widget-content").hide().appendTo("body");F.uiDialog.remove();if(F.originalTitle){F.element.attr("title",F.originalTitle)}return F},widget:function(){return this.uiDialog},close:function(I){var F=this,H,G;if(false===F._trigger("beforeClose",I)){return }if(F.overlay){F.overlay.destroy()}F.uiDialog.unbind("keypress.ui-dialog");F._isOpen=false;if(F.options.hide){F.uiDialog.hide(F.options.hide,function(){F._trigger("close",I)})}else{F.uiDialog.hide();F._trigger("close",I)}D.ui.dialog.overlay.resize();if(F.options.modal){H=0;D(".ui-dialog").each(function(){if(this!==F.uiDialog[0]){G=D(this).css("z-index");if(!isNaN(G)){H=Math.max(H,G)}}});D.ui.dialog.maxZ=H}return F},isOpen:function(){return this._isOpen},moveToTop:function(J,I){var F=this,H=F.options,G;if((H.modal&&!J)||(!H.stack&&!H.modal)){return F._trigger("focus",I)}if(H.zIndex>D.ui.dialog.maxZ){D.ui.dialog.maxZ=H.zIndex}if(F.overlay){D.ui.dialog.maxZ+=1;F.overlay.$el.css("z-index",D.ui.dialog.overlay.maxZ=D.ui.dialog.maxZ)}G={scrollTop:F.element.scrollTop(),scrollLeft:F.element.scrollLeft()};D.ui.dialog.maxZ+=1;F.uiDialog.css("z-index",D.ui.dialog.maxZ);F.element.attr(G);F._trigger("focus",I);return F},open:function(){if(this._isOpen){return }var G=this,H=G.options,F=G.uiDialog;G.overlay=H.modal?new D.ui.dialog.overlay(G):null;G._size();G._position(H.position);F.show(H.show);G.moveToTop(true);if(H.modal){F.bind("keydown.ui-dialog",function(K){if(K.keyCode!==D.ui.keyCode.TAB){return }var J=D(":tabbable",this),L=J.filter(":first"),I=J.filter(":last");if(K.target===I[0]&&!K.shiftKey){L.focus(1);return false}else{if(K.target===L[0]&&K.shiftKey){I.focus(1);return false}}})}D(G.element.find(":tabbable").get().concat(F.find(".ui-dialog-buttonpane :tabbable").get().concat(F.get()))).eq(0).focus();G._isOpen=true;G._trigger("open");return G},_createButtons:function(I){var H=this,F=false,G=D("<div></div>").addClass("ui-dialog-buttonpane ui-widget-content ui-helper-clearfix"),J=D("<div></div>").addClass("ui-dialog-buttonset").appendTo(G);H.uiDialog.find(".ui-dialog-buttonpane").remove();if(typeof I==="object"&&I!==null){D.each(I,function(){return !(F=true)})}if(F){D.each(I,function(K,M){M=D.isFunction(M)?{click:M,text:K}:M;var L=D('<button type="button"></button>').click(function(){M.click.apply(H.element[0],arguments)}).appendTo(J);D.each(M,function(N,O){if(N==="click"){return }if(N in L){L[N](O)}else{L.attr(N,O)}});if(D.fn.button){L.button()}});G.appendTo(H.uiDialog)}},_makeDraggable:function(){var F=this,I=F.options,J=D(document),H;function G(K){return{position:K.position,offset:K.offset}}F.uiDialog.draggable({cancel:".ui-dialog-content, .ui-dialog-titlebar-close",handle:".ui-dialog-titlebar",containment:"document",start:function(K,L){H=I.height==="auto"?"auto":D(this).height();D(this).height(D(this).height()).addClass("ui-dialog-dragging");F._trigger("dragStart",K,G(L))},drag:function(K,L){F._trigger("drag",K,G(L))},stop:function(K,L){I.position=[L.position.left-J.scrollLeft(),L.position.top-J.scrollTop()];D(this).removeClass("ui-dialog-dragging").height(H);F._trigger("dragStop",K,G(L));D.ui.dialog.overlay.resize()}})},_makeResizable:function(K){K=(K===E?this.options.resizable:K);var G=this,J=G.options,F=G.uiDialog.css("position"),I=(typeof K==="string"?K:"n,e,s,w,se,sw,ne,nw");function H(L){return{originalPosition:L.originalPosition,originalSize:L.originalSize,position:L.position,size:L.size}}G.uiDialog.resizable({cancel:".ui-dialog-content",containment:"document",alsoResize:G.element,maxWidth:J.maxWidth,maxHeight:J.maxHeight,minWidth:J.minWidth,minHeight:G._minHeight(),handles:I,start:function(L,M){D(this).addClass("ui-dialog-resizing");G._trigger("resizeStart",L,H(M))},resize:function(L,M){G._trigger("resize",L,H(M))},stop:function(L,M){D(this).removeClass("ui-dialog-resizing");J.height=D(this).height();J.width=D(this).width();G._trigger("resizeStop",L,H(M));D.ui.dialog.overlay.resize()}}).css("position",F).find(".ui-resizable-se").addClass("ui-icon ui-icon-grip-diagonal-se")},_minHeight:function(){var F=this.options;if(F.height==="auto"){return F.minHeight}else{return Math.min(F.minHeight,F.height)}},_position:function(G){var H=[],I=[0,0],F;if(G){if(typeof G==="string"||(typeof G==="object"&&"0" in G)){H=G.split?G.split(" "):[G[0],G[1]];if(H.length===1){H[1]=H[0]}D.each(["left","top"],function(K,J){if(+H[K]===H[K]){I[K]=H[K];H[K]=J}});G={my:H.join(" "),at:H.join(" "),offset:I.join(" ")}}G=D.extend({},D.ui.dialog.prototype.options.position,G)}else{G=D.ui.dialog.prototype.options.position}F=this.uiDialog.is(":visible");if(!F){this.uiDialog.show()}this.uiDialog.css({top:0,left:0}).position(D.extend({of:window},G));if(!F){this.uiDialog.hide()}},_setOptions:function(I){var G=this,F={},H=false;D.each(I,function(J,K){G._setOption(J,K);if(J in A){H=true}if(J in C){F[J]=K}});if(H){this._size()}if(this.uiDialog.is(":data(resizable)")){this.uiDialog.resizable("option",F)}},_setOption:function(I,J){var G=this,F=G.uiDialog;switch(I){case"beforeclose":I="beforeClose";break;case"buttons":G._createButtons(J);break;case"closeText":G.uiDialogTitlebarCloseText.text(""+J);break;case"dialogClass":F.removeClass(G.options.dialogClass).addClass(B+J);break;case"disabled":if(J){F.addClass("ui-dialog-disabled")}else{F.removeClass("ui-dialog-disabled")}break;case"draggable":var H=F.is(":data(draggable)");if(H&&!J){F.draggable("destroy")}if(!H&&J){G._makeDraggable()}break;case"position":G._position(J);break;case"resizable":var K=F.is(":data(resizable)");if(K&&!J){F.resizable("destroy")}if(K&&typeof J==="string"){F.resizable("option","handles",J)}if(!K&&J!==false){G._makeResizable(J)}break;case"title":D(".ui-dialog-title",G.uiDialogTitlebar).html(""+(J||"&#160;"));break}D.Widget.prototype._setOption.apply(G,arguments)},_size:function(){var J=this.options,G,I,F=this.uiDialog.is(":visible");this.element.show().css({width:"auto",minHeight:0,height:0});if(J.minWidth>J.width){J.width=J.minWidth}G=this.uiDialog.css({height:"auto",width:J.width}).height();I=Math.max(0,J.minHeight-G);if(J.height==="auto"){if(D.support.minHeight){this.element.css({minHeight:I,height:"auto"})}else{this.uiDialog.show();var H=this.element.css("height","auto").height();if(!F){this.uiDialog.hide()}this.element.height(Math.max(H,I))}}else{this.element.height(Math.max(J.height-G,0))}if(this.uiDialog.is(":data(resizable)")){this.uiDialog.resizable("option","minHeight",this._minHeight())}}});D.extend(D.ui.dialog,{version:"1.8.24",uuid:0,maxZ:0,getTitleId:function(F){var G=F.attr("id");if(!G){this.uuid+=1;G=this.uuid}return"ui-dialog-title-"+G},overlay:function(F){this.$el=D.ui.dialog.overlay.create(F)}});D.extend(D.ui.dialog.overlay,{instances:[],oldInstances:[],maxZ:0,events:D.map("focus,mousedown,mouseup,keydown,keypress,click".split(","),function(F){return F+".dialog-overlay"}).join(" "),create:function(G){if(this.instances.length===0){setTimeout(function(){if(D.ui.dialog.overlay.instances.length){D(document).bind(D.ui.dialog.overlay.events,function(H){if(D(H.target).zIndex()<D.ui.dialog.overlay.maxZ){return false}})}},1);D(document).bind("keydown.dialog-overlay",function(H){if(G.options.closeOnEscape&&!H.isDefaultPrevented()&&H.keyCode&&H.keyCode===D.ui.keyCode.ESCAPE){G.close(H);H.preventDefault()}});D(window).bind("resize.dialog-overlay",D.ui.dialog.overlay.resize)}var F=(this.oldInstances.pop()||D("<div></div>").addClass("ui-widget-overlay")).appendTo(document.body).css({width:this.width(),height:this.height()});if(D.fn.bgiframe){F.bgiframe()}this.instances.push(F);return F},destroy:function(F){var G=D.inArray(F,this.instances);if(G!=-1){this.oldInstances.push(this.instances.splice(G,1)[0])}if(this.instances.length===0){D([document,window]).unbind(".dialog-overlay")}F.remove();var H=0;D.each(this.instances,function(){H=Math.max(H,this.css("z-index"))});this.maxZ=H},height:function(){var G,F;if(D.browser.msie&&D.browser.version<7){G=Math.max(document.documentElement.scrollHeight,document.body.scrollHeight);F=Math.max(document.documentElement.offsetHeight,document.body.offsetHeight);if(G<F){return D(window).height()+"px"}else{return G+"px"}}else{return D(document).height()+"px"}},width:function(){var F,G;if(D.browser.msie){F=Math.max(document.documentElement.scrollWidth,document.body.scrollWidth);G=Math.max(document.documentElement.offsetWidth,document.body.offsetWidth);if(F<G){return D(window).width()+"px"}else{return F+"px"}}else{return D(document).width()+"px"}},resize:function(){var F=D([]);D.each(D.ui.dialog.overlay.instances,function(){F=F.add(this)});F.css({width:0,height:0}).css({width:D.ui.dialog.overlay.width(),height:D.ui.dialog.overlay.height()})}});D.extend(D.ui.dialog.overlay.prototype,{destroy:function(){D.ui.dialog.overlay.destroy(this.$el)}})}(jQuery));
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-ui-widgets', location = 'js-vendor/jquery/jquery-ui/jquery.ui.progressbar.js' */
/*
 * jQuery UI Progressbar 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Progressbar
 *
 * Depends:
 *   jquery.ui.core.js
 *   jquery.ui.widget.js
 */
(function(A,B){A.widget("ui.progressbar",{options:{value:0,max:100},min:0,_create:function(){this.element.addClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").attr({role:"progressbar","aria-valuemin":this.min,"aria-valuemax":this.options.max,"aria-valuenow":this._value()});this.valueDiv=A("<div class='ui-progressbar-value ui-widget-header ui-corner-left'></div>").appendTo(this.element);this.oldValue=this._value();this._refreshValue()},destroy:function(){this.element.removeClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").removeAttr("role").removeAttr("aria-valuemin").removeAttr("aria-valuemax").removeAttr("aria-valuenow");this.valueDiv.remove();A.Widget.prototype.destroy.apply(this,arguments)},value:function(C){if(C===B){return this._value()}this._setOption("value",C);return this},_setOption:function(C,D){if(C==="value"){this.options.value=D;this._refreshValue();if(this._value()===this.options.max){this._trigger("complete")}}A.Widget.prototype._setOption.apply(this,arguments)},_value:function(){var C=this.options.value;if(typeof C!=="number"){C=0}return Math.min(this.options.max,Math.max(this.min,C))},_percentage:function(){return 100*this._value()/this.options.max},_refreshValue:function(){var D=this.value();var C=this._percentage();if(this.oldValue!==D){this.oldValue=D;this._trigger("change")}this.valueDiv.toggle(D>this.min).toggleClass("ui-corner-right",D===this.options.max).width(C.toFixed(0)+"%");this.element.attr("aria-valuenow",D)}});A.extend(A.ui.progressbar,{version:"1.8.24"})})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-ui-widgets', location = 'js-vendor/jquery/jquery-ui/jquery.ui.slider.js' */
/*
 * jQuery UI Slider 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Slider
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.mouse.js
 *	jquery.ui.widget.js
 */
(function(B,C){var A=5;B.widget("ui.slider",B.ui.mouse,{widgetEventPrefix:"slide",options:{animate:false,distance:0,max:100,min:0,orientation:"horizontal",range:false,step:1,value:0,values:null},_create:function(){var E=this,J=this.options,I=this.element.find(".ui-slider-handle").addClass("ui-state-default ui-corner-all"),H="<a class='ui-slider-handle ui-state-default ui-corner-all' href='#'></a>",D=(J.values&&J.values.length)||1,G=[];this._keySliding=false;this._mouseSliding=false;this._animateOff=true;this._handleIndex=null;this._detectOrientation();this._mouseInit();this.element.addClass("ui-slider ui-slider-"+this.orientation+" ui-widget ui-widget-content ui-corner-all"+(J.disabled?" ui-slider-disabled ui-disabled":""));this.range=B([]);if(J.range){if(J.range===true){if(!J.values){J.values=[this._valueMin(),this._valueMin()]}if(J.values.length&&J.values.length!==2){J.values=[J.values[0],J.values[0]]}}this.range=B("<div></div>").appendTo(this.element).addClass("ui-slider-range ui-widget-header"+((J.range==="min"||J.range==="max")?" ui-slider-range-"+J.range:""))}for(var F=I.length;F<D;F+=1){G.push(H)}this.handles=I.add(B(G.join("")).appendTo(E.element));this.handle=this.handles.eq(0);this.handles.add(this.range).filter("a").click(function(K){K.preventDefault()}).hover(function(){if(!J.disabled){B(this).addClass("ui-state-hover")}},function(){B(this).removeClass("ui-state-hover")}).focus(function(){if(!J.disabled){B(".ui-slider .ui-state-focus").removeClass("ui-state-focus");B(this).addClass("ui-state-focus")}else{B(this).blur()}}).blur(function(){B(this).removeClass("ui-state-focus")});this.handles.each(function(K){B(this).data("index.ui-slider-handle",K)});this.handles.keydown(function(O){var L=B(this).data("index.ui-slider-handle"),P,M,K,N;if(E.options.disabled){return }switch(O.keyCode){case B.ui.keyCode.HOME:case B.ui.keyCode.END:case B.ui.keyCode.PAGE_UP:case B.ui.keyCode.PAGE_DOWN:case B.ui.keyCode.UP:case B.ui.keyCode.RIGHT:case B.ui.keyCode.DOWN:case B.ui.keyCode.LEFT:O.preventDefault();if(!E._keySliding){E._keySliding=true;B(this).addClass("ui-state-active");P=E._start(O,L);if(P===false){return }}break}N=E.options.step;if(E.options.values&&E.options.values.length){M=K=E.values(L)}else{M=K=E.value()}switch(O.keyCode){case B.ui.keyCode.HOME:K=E._valueMin();break;case B.ui.keyCode.END:K=E._valueMax();break;case B.ui.keyCode.PAGE_UP:K=E._trimAlignValue(M+((E._valueMax()-E._valueMin())/A));break;case B.ui.keyCode.PAGE_DOWN:K=E._trimAlignValue(M-((E._valueMax()-E._valueMin())/A));break;case B.ui.keyCode.UP:case B.ui.keyCode.RIGHT:if(M===E._valueMax()){return }K=E._trimAlignValue(M+N);break;case B.ui.keyCode.DOWN:case B.ui.keyCode.LEFT:if(M===E._valueMin()){return }K=E._trimAlignValue(M-N);break}E._slide(O,L,K)}).keyup(function(L){var K=B(this).data("index.ui-slider-handle");if(E._keySliding){E._keySliding=false;E._stop(L,K);E._change(L,K);B(this).removeClass("ui-state-active")}});this._refreshValue();this._animateOff=false},destroy:function(){this.handles.remove();this.range.remove();this.element.removeClass("ui-slider ui-slider-horizontal ui-slider-vertical ui-slider-disabled ui-widget ui-widget-content ui-corner-all").removeData("slider").unbind(".slider");this._mouseDestroy();return this},_mouseCapture:function(F){var G=this.options,J,L,E,H,N,K,M,I,D;if(G.disabled){return false}this.elementSize={width:this.element.outerWidth(),height:this.element.outerHeight()};this.elementOffset=this.element.offset();J={x:F.pageX,y:F.pageY};L=this._normValueFromMouse(J);E=this._valueMax()-this._valueMin()+1;N=this;this.handles.each(function(O){var P=Math.abs(L-N.values(O));if(E>P){E=P;H=B(this);K=O}});if(G.range===true&&this.values(1)===G.min){K+=1;H=B(this.handles[K])}M=this._start(F,K);if(M===false){return false}this._mouseSliding=true;N._handleIndex=K;H.addClass("ui-state-active").focus();I=H.offset();D=!B(F.target).parents().andSelf().is(".ui-slider-handle");this._clickOffset=D?{left:0,top:0}:{left:F.pageX-I.left-(H.width()/2),top:F.pageY-I.top-(H.height()/2)-(parseInt(H.css("borderTopWidth"),10)||0)-(parseInt(H.css("borderBottomWidth"),10)||0)+(parseInt(H.css("marginTop"),10)||0)};if(!this.handles.hasClass("ui-state-hover")){this._slide(F,K,L)}this._animateOff=true;return true},_mouseStart:function(D){return true},_mouseDrag:function(F){var D={x:F.pageX,y:F.pageY},E=this._normValueFromMouse(D);this._slide(F,this._handleIndex,E);return false},_mouseStop:function(D){this.handles.removeClass("ui-state-active");this._mouseSliding=false;this._stop(D,this._handleIndex);this._change(D,this._handleIndex);this._handleIndex=null;this._clickOffset=null;this._animateOff=false;return false},_detectOrientation:function(){this.orientation=(this.options.orientation==="vertical")?"vertical":"horizontal"},_normValueFromMouse:function(E){var D,H,G,F,I;if(this.orientation==="horizontal"){D=this.elementSize.width;H=E.x-this.elementOffset.left-(this._clickOffset?this._clickOffset.left:0)}else{D=this.elementSize.height;H=E.y-this.elementOffset.top-(this._clickOffset?this._clickOffset.top:0)}G=(H/D);if(G>1){G=1}if(G<0){G=0}if(this.orientation==="vertical"){G=1-G}F=this._valueMax()-this._valueMin();I=this._valueMin()+G*F;return this._trimAlignValue(I)},_start:function(F,E){var D={handle:this.handles[E],value:this.value()};if(this.options.values&&this.options.values.length){D.value=this.values(E);D.values=this.values()}return this._trigger("start",F,D)},_slide:function(H,G,F){var D,E,I;if(this.options.values&&this.options.values.length){D=this.values(G?0:1);if((this.options.values.length===2&&this.options.range===true)&&((G===0&&F>D)||(G===1&&F<D))){F=D}if(F!==this.values(G)){E=this.values();E[G]=F;I=this._trigger("slide",H,{handle:this.handles[G],value:F,values:E});D=this.values(G?0:1);if(I!==false){this.values(G,F,true)}}}else{if(F!==this.value()){I=this._trigger("slide",H,{handle:this.handles[G],value:F});if(I!==false){this.value(F)}}}},_stop:function(F,E){var D={handle:this.handles[E],value:this.value()};if(this.options.values&&this.options.values.length){D.value=this.values(E);D.values=this.values()}this._trigger("stop",F,D)},_change:function(F,E){if(!this._keySliding&&!this._mouseSliding){var D={handle:this.handles[E],value:this.value()};if(this.options.values&&this.options.values.length){D.value=this.values(E);D.values=this.values()}this._trigger("change",F,D)}},value:function(D){if(arguments.length){this.options.value=this._trimAlignValue(D);this._refreshValue();this._change(null,0);return }return this._value()},values:function(E,H){var G,D,F;if(arguments.length>1){this.options.values[E]=this._trimAlignValue(H);this._refreshValue();this._change(null,E);return }if(arguments.length){if(B.isArray(arguments[0])){G=this.options.values;D=arguments[0];for(F=0;F<G.length;F+=1){G[F]=this._trimAlignValue(D[F]);this._change(null,F)}this._refreshValue()}else{if(this.options.values&&this.options.values.length){return this._values(E)}else{return this.value()}}}else{return this._values()}},_setOption:function(E,F){var D,G=0;if(B.isArray(this.options.values)){G=this.options.values.length}B.Widget.prototype._setOption.apply(this,arguments);switch(E){case"disabled":if(F){this.handles.filter(".ui-state-focus").blur();this.handles.removeClass("ui-state-hover");this.handles.propAttr("disabled",true);this.element.addClass("ui-disabled")}else{this.handles.propAttr("disabled",false);this.element.removeClass("ui-disabled")}break;case"orientation":this._detectOrientation();this.element.removeClass("ui-slider-horizontal ui-slider-vertical").addClass("ui-slider-"+this.orientation);this._refreshValue();break;case"value":this._animateOff=true;this._refreshValue();this._change(null,0);this._animateOff=false;break;case"values":this._animateOff=true;this._refreshValue();for(D=0;D<G;D+=1){this._change(null,D)}this._animateOff=false;break}},_value:function(){var D=this.options.value;D=this._trimAlignValue(D);return D},_values:function(D){var G,F,E;if(arguments.length){G=this.options.values[D];G=this._trimAlignValue(G);return G}else{F=this.options.values.slice();for(E=0;E<F.length;E+=1){F[E]=this._trimAlignValue(F[E])}return F}},_trimAlignValue:function(G){if(G<=this._valueMin()){return this._valueMin()}if(G>=this._valueMax()){return this._valueMax()}var D=(this.options.step>0)?this.options.step:1,F=(G-this._valueMin())%D,E=G-F;if(Math.abs(F)*2>=D){E+=(F>0)?D:(-D)}return parseFloat(E.toFixed(5))},_valueMin:function(){return this.options.min},_valueMax:function(){return this.options.max},_refreshValue:function(){var G=this.options.range,F=this.options,M=this,E=(!this._animateOff)?F.animate:false,H,D={},I,K,J,L;if(this.options.values&&this.options.values.length){this.handles.each(function(O,N){H=(M.values(O)-M._valueMin())/(M._valueMax()-M._valueMin())*100;D[M.orientation==="horizontal"?"left":"bottom"]=H+"%";B(this).stop(1,1)[E?"animate":"css"](D,F.animate);if(M.options.range===true){if(M.orientation==="horizontal"){if(O===0){M.range.stop(1,1)[E?"animate":"css"]({left:H+"%"},F.animate)}if(O===1){M.range[E?"animate":"css"]({width:(H-I)+"%"},{queue:false,duration:F.animate})}}else{if(O===0){M.range.stop(1,1)[E?"animate":"css"]({bottom:(H)+"%"},F.animate)}if(O===1){M.range[E?"animate":"css"]({height:(H-I)+"%"},{queue:false,duration:F.animate})}}}I=H})}else{K=this.value();J=this._valueMin();L=this._valueMax();H=(L!==J)?(K-J)/(L-J)*100:0;D[M.orientation==="horizontal"?"left":"bottom"]=H+"%";this.handle.stop(1,1)[E?"animate":"css"](D,F.animate);if(G==="min"&&this.orientation==="horizontal"){this.range.stop(1,1)[E?"animate":"css"]({width:H+"%"},F.animate)}if(G==="max"&&this.orientation==="horizontal"){this.range[E?"animate":"css"]({width:(100-H)+"%"},{queue:false,duration:F.animate})}if(G==="min"&&this.orientation==="vertical"){this.range.stop(1,1)[E?"animate":"css"]({height:H+"%"},F.animate)}if(G==="max"&&this.orientation==="vertical"){this.range[E?"animate":"css"]({height:(100-H)+"%"},{queue:false,duration:F.animate})}}}});B.extend(B.ui.slider,{version:"1.8.24"})}(jQuery));
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-ui-widgets', location = 'js-vendor/jquery/jquery-ui/jquery.ui.tabs.js' */
/*
 * jQuery UI Tabs 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Tabs
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 */
(function(D,F){var C=0,B=0;function E(){return ++C}function A(){return ++B}D.widget("ui.tabs",{options:{add:null,ajaxOptions:null,cache:false,cookie:null,collapsible:false,disable:null,disabled:[],enable:null,event:"click",fx:null,idPrefix:"ui-tabs-",load:null,panelTemplate:"<div></div>",remove:null,select:null,show:null,spinner:"<em>Loading&#8230;</em>",tabTemplate:"<li><a href='#{href}'><span>#{label}</span></a></li>"},_create:function(){this._tabify(true)},_setOption:function(G,H){if(G=="selected"){if(this.options.collapsible&&H==this.options.selected){return }this.select(H)}else{this.options[G]=H;this._tabify()}},_tabId:function(G){return G.title&&G.title.replace(/\s/g,"_").replace(/[^\w\u00c0-\uFFFF-]/g,"")||this.options.idPrefix+E()},_sanitizeSelector:function(G){return G.replace(/:/g,"\\:")},_cookie:function(){var G=this.cookie||(this.cookie=this.options.cookie.name||"ui-tabs-"+A());return D.cookie.apply(null,[G].concat(D.makeArray(arguments)))},_ui:function(H,G){return{tab:H,panel:G,index:this.anchors.index(H)}},_cleanup:function(){this.lis.filter(".ui-state-processing").removeClass("ui-state-processing").find("span:data(label.tabs)").each(function(){var G=D(this);G.html(G.data("label.tabs")).removeData("label.tabs")})},_tabify:function(R){var S=this,I=this.options,H=/^#.+/;this.list=this.element.find("ol,ul").eq(0);this.lis=D(" > li:has(a[href])",this.list);this.anchors=this.lis.map(function(){return D("a",this)[0]});this.panels=D([]);this.anchors.each(function(V,T){var U=D(T).attr("href");var W=U.split("#")[0],X;if(W&&(W===location.toString().split("#")[0]||(X=D("base")[0])&&W===X.href)){U=T.hash;T.href=U}if(H.test(U)){S.panels=S.panels.add(S.element.find(S._sanitizeSelector(U)))}else{if(U&&U!=="#"){D.data(T,"href.tabs",U);D.data(T,"load.tabs",U.replace(/#.*$/,""));var Z=S._tabId(T);T.href="#"+Z;var Y=S.element.find("#"+Z);if(!Y.length){Y=D(I.panelTemplate).attr("id",Z).addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").insertAfter(S.panels[V-1]||S.list);Y.data("destroy.tabs",true)}S.panels=S.panels.add(Y)}else{I.disabled.push(V)}}});if(R){this.element.addClass("ui-tabs ui-widget ui-widget-content ui-corner-all");this.list.addClass("ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all");this.lis.addClass("ui-state-default ui-corner-top");this.panels.addClass("ui-tabs-panel ui-widget-content ui-corner-bottom");if(I.selected===F){if(location.hash){this.anchors.each(function(U,T){if(T.hash==location.hash){I.selected=U;return false}})}if(typeof I.selected!=="number"&&I.cookie){I.selected=parseInt(S._cookie(),10)}if(typeof I.selected!=="number"&&this.lis.filter(".ui-tabs-selected").length){I.selected=this.lis.index(this.lis.filter(".ui-tabs-selected"))}I.selected=I.selected||(this.lis.length?0:-1)}else{if(I.selected===null){I.selected=-1}}I.selected=((I.selected>=0&&this.anchors[I.selected])||I.selected<0)?I.selected:0;I.disabled=D.unique(I.disabled.concat(D.map(this.lis.filter(".ui-state-disabled"),function(U,T){return S.lis.index(U)}))).sort();if(D.inArray(I.selected,I.disabled)!=-1){I.disabled.splice(D.inArray(I.selected,I.disabled),1)}this.panels.addClass("ui-tabs-hide");this.lis.removeClass("ui-tabs-selected ui-state-active");if(I.selected>=0&&this.anchors.length){S.element.find(S._sanitizeSelector(S.anchors[I.selected].hash)).removeClass("ui-tabs-hide");this.lis.eq(I.selected).addClass("ui-tabs-selected ui-state-active");S.element.queue("tabs",function(){S._trigger("show",null,S._ui(S.anchors[I.selected],S.element.find(S._sanitizeSelector(S.anchors[I.selected].hash))[0]))});this.load(I.selected)}D(window).bind("unload",function(){S.lis.add(S.anchors).unbind(".tabs");S.lis=S.anchors=S.panels=null})}else{I.selected=this.lis.index(this.lis.filter(".ui-tabs-selected"))}this.element[I.collapsible?"addClass":"removeClass"]("ui-tabs-collapsible");if(I.cookie){this._cookie(I.selected,I.cookie)}for(var L=0,Q;(Q=this.lis[L]);L++){D(Q)[D.inArray(L,I.disabled)!=-1&&!D(Q).hasClass("ui-tabs-selected")?"addClass":"removeClass"]("ui-state-disabled")}if(I.cache===false){this.anchors.removeData("cache.tabs")}this.lis.add(this.anchors).unbind(".tabs");if(I.event!=="mouseover"){var K=function(U,T){if(T.is(":not(.ui-state-disabled)")){T.addClass("ui-state-"+U)}};var N=function(U,T){T.removeClass("ui-state-"+U)};this.lis.bind("mouseover.tabs",function(){K("hover",D(this))});this.lis.bind("mouseout.tabs",function(){N("hover",D(this))});this.anchors.bind("focus.tabs",function(){K("focus",D(this).closest("li"))});this.anchors.bind("blur.tabs",function(){N("focus",D(this).closest("li"))})}var G,M;if(I.fx){if(D.isArray(I.fx)){G=I.fx[0];M=I.fx[1]}else{G=M=I.fx}}function J(T,U){T.css("display","");if(!D.support.opacity&&U.opacity){T[0].style.removeAttribute("filter")}}var O=M?function(T,U){D(T).closest("li").addClass("ui-tabs-selected ui-state-active");U.hide().removeClass("ui-tabs-hide").animate(M,M.duration||"normal",function(){J(U,M);S._trigger("show",null,S._ui(T,U[0]))})}:function(T,U){D(T).closest("li").addClass("ui-tabs-selected ui-state-active");U.removeClass("ui-tabs-hide");S._trigger("show",null,S._ui(T,U[0]))};var P=G?function(U,T){T.animate(G,G.duration||"normal",function(){S.lis.removeClass("ui-tabs-selected ui-state-active");T.addClass("ui-tabs-hide");J(T,G);S.element.dequeue("tabs")})}:function(U,T,V){S.lis.removeClass("ui-tabs-selected ui-state-active");T.addClass("ui-tabs-hide");S.element.dequeue("tabs")};this.anchors.bind(I.event+".tabs",function(){var U=this,W=D(U).closest("li"),T=S.panels.filter(":not(.ui-tabs-hide)"),V=S.element.find(S._sanitizeSelector(U.hash));if((W.hasClass("ui-tabs-selected")&&!I.collapsible)||W.hasClass("ui-state-disabled")||W.hasClass("ui-state-processing")||S.panels.filter(":animated").length||S._trigger("select",null,S._ui(this,V[0]))===false){this.blur();return false}I.selected=S.anchors.index(this);S.abort();if(I.collapsible){if(W.hasClass("ui-tabs-selected")){I.selected=-1;if(I.cookie){S._cookie(I.selected,I.cookie)}S.element.queue("tabs",function(){P(U,T)}).dequeue("tabs");this.blur();return false}else{if(!T.length){if(I.cookie){S._cookie(I.selected,I.cookie)}S.element.queue("tabs",function(){O(U,V)});S.load(S.anchors.index(this));this.blur();return false}}}if(I.cookie){S._cookie(I.selected,I.cookie)}if(V.length){if(T.length){S.element.queue("tabs",function(){P(U,T)})}S.element.queue("tabs",function(){O(U,V)});S.load(S.anchors.index(this))}else{throw"jQuery UI Tabs: Mismatching fragment identifier."}if(D.browser.msie){this.blur()}});this.anchors.bind("click.tabs",function(){return false})},_getIndex:function(G){if(typeof G=="string"){G=this.anchors.index(this.anchors.filter("[href$='"+G+"']"))}return G},destroy:function(){var G=this.options;this.abort();this.element.unbind(".tabs").removeClass("ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible").removeData("tabs");this.list.removeClass("ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all");this.anchors.each(function(){var H=D.data(this,"href.tabs");if(H){this.href=H}var I=D(this).unbind(".tabs");D.each(["href","load","cache"],function(J,K){I.removeData(K+".tabs")})});this.lis.unbind(".tabs").add(this.panels).each(function(){if(D.data(this,"destroy.tabs")){D(this).remove()}else{D(this).removeClass(["ui-state-default","ui-corner-top","ui-tabs-selected","ui-state-active","ui-state-hover","ui-state-focus","ui-state-disabled","ui-tabs-panel","ui-widget-content","ui-corner-bottom","ui-tabs-hide"].join(" "))}});if(G.cookie){this._cookie(null,G.cookie)}return this},add:function(J,I,H){if(H===F){H=this.anchors.length}var G=this,L=this.options,N=D(L.tabTemplate.replace(/#\{href\}/g,J).replace(/#\{label\}/g,I)),M=!J.indexOf("#")?J.replace("#",""):this._tabId(D("a",N)[0]);N.addClass("ui-state-default ui-corner-top").data("destroy.tabs",true);var K=G.element.find("#"+M);if(!K.length){K=D(L.panelTemplate).attr("id",M).data("destroy.tabs",true)}K.addClass("ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide");if(H>=this.lis.length){N.appendTo(this.list);K.appendTo(this.list[0].parentNode)}else{N.insertBefore(this.lis[H]);K.insertBefore(this.panels[H])}L.disabled=D.map(L.disabled,function(P,O){return P>=H?++P:P});this._tabify();if(this.anchors.length==1){L.selected=0;N.addClass("ui-tabs-selected ui-state-active");K.removeClass("ui-tabs-hide");this.element.queue("tabs",function(){G._trigger("show",null,G._ui(G.anchors[0],G.panels[0]))});this.load(0)}this._trigger("add",null,this._ui(this.anchors[H],this.panels[H]));return this},remove:function(G){G=this._getIndex(G);var I=this.options,J=this.lis.eq(G).remove(),H=this.panels.eq(G).remove();if(J.hasClass("ui-tabs-selected")&&this.anchors.length>1){this.select(G+(G+1<this.anchors.length?1:-1))}I.disabled=D.map(D.grep(I.disabled,function(L,K){return L!=G}),function(L,K){return L>=G?--L:L});this._tabify();this._trigger("remove",null,this._ui(J.find("a")[0],H[0]));return this},enable:function(G){G=this._getIndex(G);var H=this.options;if(D.inArray(G,H.disabled)==-1){return }this.lis.eq(G).removeClass("ui-state-disabled");H.disabled=D.grep(H.disabled,function(J,I){return J!=G});this._trigger("enable",null,this._ui(this.anchors[G],this.panels[G]));return this},disable:function(H){H=this._getIndex(H);var G=this,I=this.options;if(H!=I.selected){this.lis.eq(H).addClass("ui-state-disabled");I.disabled.push(H);I.disabled.sort();this._trigger("disable",null,this._ui(this.anchors[H],this.panels[H]))}return this},select:function(G){G=this._getIndex(G);if(G==-1){if(this.options.collapsible&&this.options.selected!=-1){G=this.options.selected}else{return this}}this.anchors.eq(G).trigger(this.options.event+".tabs");return this},load:function(J){J=this._getIndex(J);var H=this,L=this.options,G=this.anchors.eq(J)[0],I=D.data(G,"load.tabs");this.abort();if(!I||this.element.queue("tabs").length!==0&&D.data(G,"cache.tabs")){this.element.dequeue("tabs");return }this.lis.eq(J).addClass("ui-state-processing");if(L.spinner){var K=D("span",G);K.data("label.tabs",K.html()).html(L.spinner)}this.xhr=D.ajax(D.extend({},L.ajaxOptions,{url:I,success:function(N,M){H.element.find(H._sanitizeSelector(G.hash)).html(N);H._cleanup();if(L.cache){D.data(G,"cache.tabs",true)}H._trigger("load",null,H._ui(H.anchors[J],H.panels[J]));try{L.ajaxOptions.success(N,M)}catch(O){}},error:function(O,M,N){H._cleanup();H._trigger("load",null,H._ui(H.anchors[J],H.panels[J]));try{L.ajaxOptions.error(O,M,J,G)}catch(N){}}}));H.element.dequeue("tabs");return this},abort:function(){this.element.queue([]);this.panels.stop(false,true);this.element.queue("tabs",this.element.queue("tabs").splice(-2,2));if(this.xhr){this.xhr.abort();delete this.xhr}this._cleanup();return this},url:function(H,G){this.anchors.eq(H).removeData("cache.tabs").data("load.tabs",G);return this},length:function(){return this.anchors.length}});D.extend(D.ui.tabs,{version:"1.8.24"});D.extend(D.ui.tabs.prototype,{rotation:null,rotate:function(I,K){var G=this,L=this.options;var H=G._rotate||(G._rotate=function(M){clearTimeout(G.rotation);G.rotation=setTimeout(function(){var N=L.selected;G.select(++N<G.anchors.length?N:0)},I);if(M){M.stopPropagation()}});var J=G._unrotate||(G._unrotate=!K?function(M){if(M.clientX){G.rotate(null)}}:function(M){H()});if(I){this.element.bind("tabsshow",H);this.anchors.bind(L.event+".tabs",J);H()}else{clearTimeout(G.rotation);this.element.unbind("tabsshow",H);this.anchors.unbind(L.event+".tabs",J);delete this._rotate;delete this._unrotate}return this}})})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-effects', location = 'js-vendor/jquery/jquery-ui/jquery.effects.core.js' */
/*
 * jQuery UI Effects 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/
 */
jQuery.effects||(function(H,E){H.effects={};H.each(["backgroundColor","borderBottomColor","borderLeftColor","borderRightColor","borderTopColor","borderColor","color","outlineColor"],function(O,N){H.fx.step[N]=function(P){if(!P.colorInit){P.start=M(P.elem,N);P.end=K(P.end);P.colorInit=true}P.elem.style[N]="rgb("+Math.max(Math.min(parseInt((P.pos*(P.end[0]-P.start[0]))+P.start[0],10),255),0)+","+Math.max(Math.min(parseInt((P.pos*(P.end[1]-P.start[1]))+P.start[1],10),255),0)+","+Math.max(Math.min(parseInt((P.pos*(P.end[2]-P.start[2]))+P.start[2],10),255),0)+")"}});function K(O){var N;if(O&&O.constructor==Array&&O.length==3){return O}if(N=/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(O)){return[parseInt(N[1],10),parseInt(N[2],10),parseInt(N[3],10)]}if(N=/rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(O)){return[parseFloat(N[1])*2.55,parseFloat(N[2])*2.55,parseFloat(N[3])*2.55]}if(N=/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(O)){return[parseInt(N[1],16),parseInt(N[2],16),parseInt(N[3],16)]}if(N=/#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(O)){return[parseInt(N[1]+N[1],16),parseInt(N[2]+N[2],16),parseInt(N[3]+N[3],16)]}if(N=/rgba\(0, 0, 0, 0\)/.exec(O)){return A.transparent}return A[H.trim(O).toLowerCase()]}function M(P,N){var O;do{O=(H.curCSS||H.css)(P,N);if(O!=""&&O!="transparent"||H.nodeName(P,"body")){break}N="backgroundColor"}while(P=P.parentNode);return K(O)}var A={aqua:[0,255,255],azure:[240,255,255],beige:[245,245,220],black:[0,0,0],blue:[0,0,255],brown:[165,42,42],cyan:[0,255,255],darkblue:[0,0,139],darkcyan:[0,139,139],darkgrey:[169,169,169],darkgreen:[0,100,0],darkkhaki:[189,183,107],darkmagenta:[139,0,139],darkolivegreen:[85,107,47],darkorange:[255,140,0],darkorchid:[153,50,204],darkred:[139,0,0],darksalmon:[233,150,122],darkviolet:[148,0,211],fuchsia:[255,0,255],gold:[255,215,0],green:[0,128,0],indigo:[75,0,130],khaki:[240,230,140],lightblue:[173,216,230],lightcyan:[224,255,255],lightgreen:[144,238,144],lightgrey:[211,211,211],lightpink:[255,182,193],lightyellow:[255,255,224],lime:[0,255,0],magenta:[255,0,255],maroon:[128,0,0],navy:[0,0,128],olive:[128,128,0],orange:[255,165,0],pink:[255,192,203],purple:[128,0,128],violet:[128,0,128],red:[255,0,0],silver:[192,192,192],white:[255,255,255],yellow:[255,255,0],transparent:[255,255,255]};var F=["add","remove","toggle"],C={border:1,borderBottom:1,borderColor:1,borderLeft:1,borderRight:1,borderTop:1,borderWidth:1,margin:1,padding:1};function G(){var Q=document.defaultView?document.defaultView.getComputedStyle(this,null):this.currentStyle,R={},O,P;if(Q&&Q.length&&Q[0]&&Q[Q[0]]){var N=Q.length;while(N--){O=Q[N];if(typeof Q[O]=="string"){P=O.replace(/\-(\w)/g,function(S,T){return T.toUpperCase()});R[P]=Q[O]}}}else{for(O in Q){if(typeof Q[O]==="string"){R[O]=Q[O]}}}return R}function B(O){var N,P;for(N in O){P=O[N];if(P==null||H.isFunction(P)||N in C||(/scrollbar/).test(N)||(!(/color/i).test(N)&&isNaN(parseFloat(P)))){delete O[N]}}return O}function I(N,P){var Q={_:0},O;for(O in P){if(N[O]!=P[O]){Q[O]=P[O]}}return Q}H.effects.animateClass=function(N,O,Q,P){if(H.isFunction(Q)){P=Q;Q=null}return this.queue(function(){var U=H(this),R=U.attr("style")||" ",V=B(G.call(this)),T,S=U.attr("class")||"";H.each(F,function(W,X){if(N[X]){U[X+"Class"](N[X])}});T=B(G.call(this));U.attr("class",S);U.animate(I(V,T),{queue:false,duration:O,easing:Q,complete:function(){H.each(F,function(W,X){if(N[X]){U[X+"Class"](N[X])}});if(typeof U.attr("style")=="object"){U.attr("style").cssText="";U.attr("style").cssText=R}else{U.attr("style",R)}if(P){P.apply(this,arguments)}H.dequeue(this)}})})};H.fn.extend({_addClass:H.fn.addClass,addClass:function(O,N,Q,P){return N?H.effects.animateClass.apply(this,[{add:O},N,Q,P]):this._addClass(O)},_removeClass:H.fn.removeClass,removeClass:function(O,N,Q,P){return N?H.effects.animateClass.apply(this,[{remove:O},N,Q,P]):this._removeClass(O)},_toggleClass:H.fn.toggleClass,toggleClass:function(P,O,N,R,Q){if(typeof O=="boolean"||O===E){if(!N){return this._toggleClass(P,O)}else{return H.effects.animateClass.apply(this,[(O?{add:P}:{remove:P}),N,R,Q])}}else{return H.effects.animateClass.apply(this,[{toggle:P},O,N,R])}},switchClass:function(N,P,O,R,Q){return H.effects.animateClass.apply(this,[{add:P,remove:N},O,R,Q])}});H.extend(H.effects,{version:"1.8.24",save:function(O,P){for(var N=0;N<P.length;N++){if(P[N]!==null){O.data("ec.storage."+P[N],O[0].style[P[N]])}}},restore:function(O,P){for(var N=0;N<P.length;N++){if(P[N]!==null){O.css(P[N],O.data("ec.storage."+P[N]))}}},setMode:function(N,O){if(O=="toggle"){O=N.is(":hidden")?"show":"hide"}return O},getBaseline:function(O,P){var Q,N;switch(O[0]){case"top":Q=0;break;case"middle":Q=0.5;break;case"bottom":Q=1;break;default:Q=O[0]/P.height}switch(O[1]){case"left":N=0;break;case"center":N=0.5;break;case"right":N=1;break;default:N=O[1]/P.width}return{x:N,y:Q}},createWrapper:function(N){if(N.parent().is(".ui-effects-wrapper")){return N.parent()}var O={width:N.outerWidth(true),height:N.outerHeight(true),"float":N.css("float")},R=H("<div></div>").addClass("ui-effects-wrapper").css({fontSize:"100%",background:"transparent",border:"none",margin:0,padding:0}),Q=document.activeElement;try{Q.id}catch(P){Q=document.body}N.wrap(R);if(N[0]===Q||H.contains(N[0],Q)){H(Q).focus()}R=N.parent();if(N.css("position")=="static"){R.css({position:"relative"});N.css({position:"relative"})}else{H.extend(O,{position:N.css("position"),zIndex:N.css("z-index")});H.each(["top","left","bottom","right"],function(S,T){O[T]=N.css(T);if(isNaN(parseInt(O[T],10))){O[T]="auto"}});N.css({position:"relative",top:0,left:0,right:"auto",bottom:"auto"})}return R.css(O).show()},removeWrapper:function(N){var O,P=document.activeElement;if(N.parent().is(".ui-effects-wrapper")){O=N.parent().replaceWith(N);if(N[0]===P||H.contains(N[0],P)){H(P).focus()}return O}return N},setTransition:function(O,Q,N,P){P=P||{};H.each(Q,function(S,R){var T=O.cssUnit(R);if(T[0]>0){P[R]=T[0]*N+T[1]}});return P}});function D(O,N,P,Q){if(typeof O=="object"){Q=N;P=null;N=O;O=N.effect}if(H.isFunction(N)){Q=N;P=null;N={}}if(typeof N=="number"||H.fx.speeds[N]){Q=P;P=N;N={}}if(H.isFunction(P)){Q=P;P=null}N=N||{};P=P||N.duration;P=H.fx.off?0:typeof P=="number"?P:P in H.fx.speeds?H.fx.speeds[P]:H.fx.speeds._default;Q=Q||N.complete;return[O,N,P,Q]}function L(N){if(!N||typeof N==="number"||H.fx.speeds[N]){return true}if(typeof N==="string"&&!H.effects[N]){return true}return false}H.fn.extend({effect:function(Q,P,S,U){var O=D.apply(this,arguments),R={options:O[1],duration:O[2],callback:O[3]},T=R.options.mode,N=H.effects[Q];if(H.fx.off||!N){if(T){return this[T](R.duration,R.callback)}else{return this.each(function(){if(R.callback){R.callback.call(this)}})}}return N.call(this,R)},_show:H.fn.show,show:function(O){if(L(O)){return this._show.apply(this,arguments)}else{var N=D.apply(this,arguments);N[1].mode="show";return this.effect.apply(this,N)}},_hide:H.fn.hide,hide:function(O){if(L(O)){return this._hide.apply(this,arguments)}else{var N=D.apply(this,arguments);N[1].mode="hide";return this.effect.apply(this,N)}},__toggle:H.fn.toggle,toggle:function(O){if(L(O)||typeof O==="boolean"||H.isFunction(O)){return this.__toggle.apply(this,arguments)}else{var N=D.apply(this,arguments);N[1].mode="toggle";return this.effect.apply(this,N)}},cssUnit:function(N){var O=this.css(N),P=[];H.each(["em","px","%","pt"],function(Q,R){if(O.indexOf(R)>0){P=[parseFloat(O),R]}});return P}});var J={};H.each(["Quad","Cubic","Quart","Quint","Expo"],function(O,N){J[N]=function(P){return Math.pow(P,O+2)}});H.extend(J,{Sine:function(N){return 1-Math.cos(N*Math.PI/2)},Circ:function(N){return 1-Math.sqrt(1-N*N)},Elastic:function(N){return N===0||N===1?N:-Math.pow(2,8*(N-1))*Math.sin(((N-1)*80-7.5)*Math.PI/15)},Back:function(N){return N*N*(3*N-2)},Bounce:function(P){var N,O=4;while(P<((N=Math.pow(2,--O))-1)/11){}return 1/Math.pow(4,3-O)-7.5625*Math.pow((N*3-2)/22-P,2)}});H.each(J,function(O,N){H.easing["easeIn"+O]=N;H.easing["easeOut"+O]=function(P){return 1-N(1-P)};H.easing["easeInOut"+O]=function(P){return P<0.5?N(P*2)/2:N(P*-2+2)/-2+1}})})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-effects', location = 'js-vendor/jquery/jquery-ui/jquery.effects.blind.js' */
/*
 * jQuery UI Effects Blind 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Blind
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(A,B){A.effects.blind=function(C){return this.queue(function(){var E=A(this),D=["position","top","bottom","left","right"];var I=A.effects.setMode(E,C.options.mode||"hide");var H=C.options.direction||"vertical";A.effects.save(E,D);E.show();var K=A.effects.createWrapper(E).css({overflow:"hidden"});var F=(H=="vertical")?"height":"width";var J=(H=="vertical")?K.height():K.width();if(I=="show"){K.css(F,0)}var G={};G[F]=I=="show"?J:0;K.animate(G,C.duration,C.options.easing,function(){if(I=="hide"){E.hide()}A.effects.restore(E,D);A.effects.removeWrapper(E);if(C.callback){C.callback.apply(E[0],arguments)}E.dequeue()})})}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-effects', location = 'js-vendor/jquery/jquery-ui/jquery.effects.bounce.js' */
/*
 * jQuery UI Effects Bounce 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Bounce
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(A,B){A.effects.bounce=function(C){return this.queue(function(){var F=A(this),L=["position","top","bottom","left","right"];var K=A.effects.setMode(F,C.options.mode||"effect");var N=C.options.direction||"up";var D=C.options.distance||20;var E=C.options.times||5;var H=C.duration||250;if(/show|hide/.test(K)){L.push("opacity")}A.effects.save(F,L);F.show();A.effects.createWrapper(F);var G=(N=="up"||N=="down")?"top":"left";var P=(N=="up"||N=="left")?"pos":"neg";var D=C.options.distance||(G=="top"?F.outerHeight(true)/3:F.outerWidth(true)/3);if(K=="show"){F.css("opacity",0).css(G,P=="pos"?-D:D)}if(K=="hide"){D=D/(E*2)}if(K!="hide"){E--}if(K=="show"){var I={opacity:1};I[G]=(P=="pos"?"+=":"-=")+D;F.animate(I,H/2,C.options.easing);D=D/2;E--}for(var J=0;J<E;J++){var O={},M={};O[G]=(P=="pos"?"-=":"+=")+D;M[G]=(P=="pos"?"+=":"-=")+D;F.animate(O,H/2,C.options.easing).animate(M,H/2,C.options.easing);D=(K=="hide")?D*2:D/2}if(K=="hide"){var I={opacity:0};I[G]=(P=="pos"?"-=":"+=")+D;F.animate(I,H/2,C.options.easing,function(){F.hide();A.effects.restore(F,L);A.effects.removeWrapper(F);if(C.callback){C.callback.apply(this,arguments)}})}else{var O={},M={};O[G]=(P=="pos"?"-=":"+=")+D;M[G]=(P=="pos"?"+=":"-=")+D;F.animate(O,H/2,C.options.easing).animate(M,H/2,C.options.easing,function(){A.effects.restore(F,L);A.effects.removeWrapper(F);if(C.callback){C.callback.apply(this,arguments)}})}F.queue("fx",function(){F.dequeue()});F.dequeue()})}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-effects', location = 'js-vendor/jquery/jquery-ui/jquery.effects.clip.js' */
/*
 * jQuery UI Effects Clip 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Clip
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(A,B){A.effects.clip=function(C){return this.queue(function(){var G=A(this),K=["position","top","bottom","left","right","height","width"];var J=A.effects.setMode(G,C.options.mode||"hide");var L=C.options.direction||"vertical";A.effects.save(G,K);G.show();var D=A.effects.createWrapper(G).css({overflow:"hidden"});var F=G[0].tagName=="IMG"?D:G;var H={size:(L=="vertical")?"height":"width",position:(L=="vertical")?"top":"left"};var E=(L=="vertical")?F.height():F.width();if(J=="show"){F.css(H.size,0);F.css(H.position,E/2)}var I={};I[H.size]=J=="show"?E:0;I[H.position]=J=="show"?0:E/2;F.animate(I,{queue:false,duration:C.duration,easing:C.options.easing,complete:function(){if(J=="hide"){G.hide()}A.effects.restore(G,K);A.effects.removeWrapper(G);if(C.callback){C.callback.apply(G[0],arguments)}G.dequeue()}})})}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-effects', location = 'js-vendor/jquery/jquery-ui/jquery.effects.drop.js' */
/*
 * jQuery UI Effects Drop 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Drop
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(A,B){A.effects.drop=function(C){return this.queue(function(){var F=A(this),E=["position","top","bottom","left","right","opacity"];var J=A.effects.setMode(F,C.options.mode||"hide");var I=C.options.direction||"left";A.effects.save(F,E);F.show();A.effects.createWrapper(F);var G=(I=="up"||I=="down")?"top":"left";var D=(I=="up"||I=="left")?"pos":"neg";var K=C.options.distance||(G=="top"?F.outerHeight(true)/2:F.outerWidth(true)/2);if(J=="show"){F.css("opacity",0).css(G,D=="pos"?-K:K)}var H={opacity:J=="show"?1:0};H[G]=(J=="show"?(D=="pos"?"+=":"-="):(D=="pos"?"-=":"+="))+K;F.animate(H,{queue:false,duration:C.duration,easing:C.options.easing,complete:function(){if(J=="hide"){F.hide()}A.effects.restore(F,E);A.effects.removeWrapper(F);if(C.callback){C.callback.apply(this,arguments)}F.dequeue()}})})}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-effects', location = 'js-vendor/jquery/jquery-ui/jquery.effects.explode.js' */
/*
 * jQuery UI Effects Explode 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Explode
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(A,B){A.effects.explode=function(C){return this.queue(function(){var J=C.options.pieces?Math.round(Math.sqrt(C.options.pieces)):3;var F=C.options.pieces?Math.round(Math.sqrt(C.options.pieces)):3;C.options.mode=C.options.mode=="toggle"?(A(this).is(":visible")?"hide":"show"):C.options.mode;var I=A(this).show().css("visibility","hidden");var K=I.offset();K.top-=parseInt(I.css("marginTop"),10)||0;K.left-=parseInt(I.css("marginLeft"),10)||0;var H=I.outerWidth(true);var D=I.outerHeight(true);for(var G=0;G<J;G++){for(var E=0;E<F;E++){I.clone().appendTo("body").wrap("<div></div>").css({position:"absolute",visibility:"visible",left:-E*(H/F),top:-G*(D/J)}).parent().addClass("ui-effects-explode").css({position:"absolute",overflow:"hidden",width:H/F,height:D/J,left:K.left+E*(H/F)+(C.options.mode=="show"?(E-Math.floor(F/2))*(H/F):0),top:K.top+G*(D/J)+(C.options.mode=="show"?(G-Math.floor(J/2))*(D/J):0),opacity:C.options.mode=="show"?0:1}).animate({left:K.left+E*(H/F)+(C.options.mode=="show"?0:(E-Math.floor(F/2))*(H/F)),top:K.top+G*(D/J)+(C.options.mode=="show"?0:(G-Math.floor(J/2))*(D/J)),opacity:C.options.mode=="show"?1:0},C.duration||500)}}setTimeout(function(){C.options.mode=="show"?I.css({visibility:"visible"}):I.css({visibility:"visible"}).hide();if(C.callback){C.callback.apply(I[0])}I.dequeue();A("div.ui-effects-explode").remove()},C.duration||500)})}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-effects', location = 'js-vendor/jquery/jquery-ui/jquery.effects.fade.js' */
/*
 * jQuery UI Effects Fade 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Fade
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(A,B){A.effects.fade=function(C){return this.queue(function(){var D=A(this),E=A.effects.setMode(D,C.options.mode||"hide");D.animate({opacity:E},{queue:false,duration:C.duration,easing:C.options.easing,complete:function(){(C.callback&&C.callback.apply(this,arguments));D.dequeue()}})})}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-effects', location = 'js-vendor/jquery/jquery-ui/jquery.effects.fold.js' */
/*
 * jQuery UI Effects Fold 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Fold
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(A,B){A.effects.fold=function(C){return this.queue(function(){var F=A(this),L=["position","top","bottom","left","right"];var I=A.effects.setMode(F,C.options.mode||"hide");var P=C.options.size||15;var O=!(!C.options.horizFirst);var H=C.duration?C.duration/2:A.fx.speeds._default/2;A.effects.save(F,L);F.show();var E=A.effects.createWrapper(F).css({overflow:"hidden"});var J=((I=="show")!=O);var G=J?["width","height"]:["height","width"];var D=J?[E.width(),E.height()]:[E.height(),E.width()];var K=/([0-9]+)%/.exec(P);if(K){P=parseInt(K[1],10)/100*D[I=="hide"?0:1]}if(I=="show"){E.css(O?{height:0,width:P}:{height:P,width:0})}var N={},M={};N[G[0]]=I=="show"?D[0]:P;M[G[1]]=I=="show"?D[1]:0;E.animate(N,H,C.options.easing).animate(M,H,C.options.easing,function(){if(I=="hide"){F.hide()}A.effects.restore(F,L);A.effects.removeWrapper(F);if(C.callback){C.callback.apply(F[0],arguments)}F.dequeue()})})}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-effects', location = 'js-vendor/jquery/jquery-ui/jquery.effects.highlight.js' */
/*
 * jQuery UI Effects Highlight 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Highlight
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(A,B){A.effects.highlight=function(C){return this.queue(function(){var E=A(this),D=["backgroundImage","backgroundColor","opacity"],G=A.effects.setMode(E,C.options.mode||"show"),F={backgroundColor:E.css("backgroundColor")};if(G=="hide"){F.opacity=0}A.effects.save(E,D);E.show().css({backgroundImage:"none",backgroundColor:C.options.color||"#ffff99"}).animate(F,{queue:false,duration:C.duration,easing:C.options.easing,complete:function(){(G=="hide"&&E.hide());A.effects.restore(E,D);(G=="show"&&!A.support.opacity&&this.style.removeAttribute("filter"));(C.callback&&C.callback.apply(this,arguments));E.dequeue()}})})}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-effects', location = 'js-vendor/jquery/jquery-ui/jquery.effects.pulsate.js' */
/*
 * jQuery UI Effects Pulsate 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Pulsate
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(A,B){A.effects.pulsate=function(C){return this.queue(function(){var G=A(this),J=A.effects.setMode(G,C.options.mode||"show"),I=((C.options.times||5)*2)-1,H=C.duration?C.duration/2:A.fx.speeds._default/2,D=G.is(":visible"),E=0;if(!D){G.css("opacity",0).show();E=1}if((J=="hide"&&D)||(J=="show"&&!D)){I--}for(var F=0;F<I;F++){G.animate({opacity:E},H,C.options.easing);E=(E+1)%2}G.animate({opacity:E},H,C.options.easing,function(){if(E==0){G.hide()}(C.callback&&C.callback.apply(this,arguments))});G.queue("fx",function(){G.dequeue()}).dequeue()})}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-effects', location = 'js-vendor/jquery/jquery-ui/jquery.effects.scale.js' */
/*
 * jQuery UI Effects Scale 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Scale
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(A,B){A.effects.puff=function(C){return this.queue(function(){var G=A(this),H=A.effects.setMode(G,C.options.mode||"hide"),F=parseInt(C.options.percent,10)||150,E=F/100,D={height:G.height(),width:G.width()};A.extend(C.options,{fade:true,mode:H,percent:H=="hide"?F:100,from:H=="hide"?D:{height:D.height*E,width:D.width*E}});G.effect("scale",C.options,C.duration,C.callback);G.dequeue()})};A.effects.scale=function(C){return this.queue(function(){var H=A(this);var E=A.extend(true,{},C.options);var K=A.effects.setMode(H,C.options.mode||"effect");var I=parseInt(C.options.percent,10)||(parseInt(C.options.percent,10)==0?0:(K=="hide"?0:100));var J=C.options.direction||"both";var D=C.options.origin;if(K!="effect"){E.origin=D||["middle","center"];E.restore=true}var G={height:H.height(),width:H.width()};H.from=C.options.from||(K=="show"?{height:0,width:0}:G);var F={y:J!="horizontal"?(I/100):1,x:J!="vertical"?(I/100):1};H.to={height:G.height*F.y,width:G.width*F.x};if(C.options.fade){if(K=="show"){H.from.opacity=0;H.to.opacity=1}if(K=="hide"){H.from.opacity=1;H.to.opacity=0}}E.from=H.from;E.to=H.to;E.mode=K;H.effect("size",E,C.duration,C.callback);H.dequeue()})};A.effects.size=function(C){return this.queue(function(){var D=A(this),O=["position","top","bottom","left","right","width","height","overflow","opacity"];var N=["position","top","bottom","left","right","overflow","opacity"];var K=["width","height","overflow"];var Q=["fontSize"];var L=["borderTopWidth","borderBottomWidth","paddingTop","paddingBottom"];var G=["borderLeftWidth","borderRightWidth","paddingLeft","paddingRight"];var H=A.effects.setMode(D,C.options.mode||"effect");var J=C.options.restore||false;var F=C.options.scale||"both";var P=C.options.origin;var E={height:D.height(),width:D.width()};D.from=C.options.from||E;D.to=C.options.to||E;if(P){var I=A.effects.getBaseline(P,E);D.from.top=(E.height-D.from.height)*I.y;D.from.left=(E.width-D.from.width)*I.x;D.to.top=(E.height-D.to.height)*I.y;D.to.left=(E.width-D.to.width)*I.x}var M={from:{y:D.from.height/E.height,x:D.from.width/E.width},to:{y:D.to.height/E.height,x:D.to.width/E.width}};if(F=="box"||F=="both"){if(M.from.y!=M.to.y){O=O.concat(L);D.from=A.effects.setTransition(D,L,M.from.y,D.from);D.to=A.effects.setTransition(D,L,M.to.y,D.to)}if(M.from.x!=M.to.x){O=O.concat(G);D.from=A.effects.setTransition(D,G,M.from.x,D.from);D.to=A.effects.setTransition(D,G,M.to.x,D.to)}}if(F=="content"||F=="both"){if(M.from.y!=M.to.y){O=O.concat(Q);D.from=A.effects.setTransition(D,Q,M.from.y,D.from);D.to=A.effects.setTransition(D,Q,M.to.y,D.to)}}A.effects.save(D,J?O:N);D.show();A.effects.createWrapper(D);D.css("overflow","hidden").css(D.from);if(F=="content"||F=="both"){L=L.concat(["marginTop","marginBottom"]).concat(Q);G=G.concat(["marginLeft","marginRight"]);K=O.concat(L).concat(G);D.find("*[width]").each(function(){var S=A(this);if(J){A.effects.save(S,K)}var R={height:S.height(),width:S.width()};S.from={height:R.height*M.from.y,width:R.width*M.from.x};S.to={height:R.height*M.to.y,width:R.width*M.to.x};if(M.from.y!=M.to.y){S.from=A.effects.setTransition(S,L,M.from.y,S.from);S.to=A.effects.setTransition(S,L,M.to.y,S.to)}if(M.from.x!=M.to.x){S.from=A.effects.setTransition(S,G,M.from.x,S.from);S.to=A.effects.setTransition(S,G,M.to.x,S.to)}S.css(S.from);S.animate(S.to,C.duration,C.options.easing,function(){if(J){A.effects.restore(S,K)}})})}D.animate(D.to,{queue:false,duration:C.duration,easing:C.options.easing,complete:function(){if(D.to.opacity===0){D.css("opacity",D.from.opacity)}if(H=="hide"){D.hide()}A.effects.restore(D,J?O:N);A.effects.removeWrapper(D);if(C.callback){C.callback.apply(this,arguments)}D.dequeue()}})})}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-effects', location = 'js-vendor/jquery/jquery-ui/jquery.effects.shake.js' */
/*
 * jQuery UI Effects Shake 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Shake
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(A,B){A.effects.shake=function(C){return this.queue(function(){var F=A(this),L=["position","top","bottom","left","right"];var K=A.effects.setMode(F,C.options.mode||"effect");var N=C.options.direction||"left";var D=C.options.distance||20;var E=C.options.times||3;var H=C.duration||C.options.duration||140;A.effects.save(F,L);F.show();A.effects.createWrapper(F);var G=(N=="up"||N=="down")?"top":"left";var P=(N=="up"||N=="left")?"pos":"neg";var I={},O={},M={};I[G]=(P=="pos"?"-=":"+=")+D;O[G]=(P=="pos"?"+=":"-=")+D*2;M[G]=(P=="pos"?"-=":"+=")+D*2;F.animate(I,H,C.options.easing);for(var J=1;J<E;J++){F.animate(O,H,C.options.easing).animate(M,H,C.options.easing)}F.animate(O,H,C.options.easing).animate(I,H/2,C.options.easing,function(){A.effects.restore(F,L);A.effects.removeWrapper(F);if(C.callback){C.callback.apply(this,arguments)}});F.queue("fx",function(){F.dequeue()});F.dequeue()})}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-effects', location = 'js-vendor/jquery/jquery-ui/jquery.effects.slide.js' */
/*
 * jQuery UI Effects Slide 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Slide
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(A,B){A.effects.slide=function(C){return this.queue(function(){var F=A(this),E=["position","top","bottom","left","right"];var J=A.effects.setMode(F,C.options.mode||"show");var I=C.options.direction||"left";A.effects.save(F,E);F.show();A.effects.createWrapper(F).css({overflow:"hidden"});var G=(I=="up"||I=="down")?"top":"left";var D=(I=="up"||I=="left")?"pos":"neg";var K=C.options.distance||(G=="top"?F.outerHeight(true):F.outerWidth(true));if(J=="show"){F.css(G,D=="pos"?(isNaN(K)?"-"+K:-K):K)}var H={};H[G]=(J=="show"?(D=="pos"?"+=":"-="):(D=="pos"?"-=":"+="))+K;F.animate(H,{queue:false,duration:C.duration,easing:C.options.easing,complete:function(){if(J=="hide"){F.hide()}A.effects.restore(F,E);A.effects.removeWrapper(F);if(C.callback){C.callback.apply(this,arguments)}F.dequeue()}})})}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-effects', location = 'js-vendor/jquery/jquery-ui/jquery.effects.transfer.js' */
/*
 * jQuery UI Effects Transfer 1.8.24
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Transfer
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(A,B){A.effects.transfer=function(C){return this.queue(function(){var G=A(this),I=A(C.options.to),F=I.offset(),H={top:F.top,left:F.left,height:I.innerHeight(),width:I.innerWidth()},E=G.offset(),D=A('<div class="ui-effects-transfer"></div>').appendTo(document.body).addClass(C.options.className).css({top:E.top,left:E.left,height:G.innerHeight(),width:G.innerWidth(),position:"absolute"}).animate(H,C.duration,C.options.easing,function(){D.remove();(C.callback&&C.callback.apply(G[0],arguments));G.dequeue()})})}})(jQuery);
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.auiplugin:jquery-ui-other', location = 'js-vendor/jquery/jquery.ui.menu.js' */
(function(A){A.widget("ui.menu",{_create:function(){var B=this;this.element.addClass("ui-menu ui-widget ui-widget-content ui-corner-all").attr({role:"listbox","aria-activedescendant":"ui-active-menuitem"}).click(function(C){if(!A(C.target).closest(".ui-menu-item a").length){return }C.preventDefault();B.select(C)});this.refresh()},refresh:function(){var C=this;var B=this.element.children("li:not(.ui-menu-item):has(a)").addClass("ui-menu-item").attr("role","menuitem");B.children("a").addClass("ui-corner-all").attr("tabindex",-1).mouseenter(function(D){C.activate(D,A(this).parent())}).mouseleave(function(){C.deactivate()})},activate:function(E,D){this.deactivate();if(this.hasScroll()){var F=D.offset().top-this.element.offset().top,B=this.element.attr("scrollTop"),C=this.element.height();if(F<0){this.element.attr("scrollTop",B+F)}else{if(F>C){this.element.attr("scrollTop",B+F-C+D.height())}}}this.active=D.eq(0).children("a").addClass("ui-state-hover").attr("id","ui-active-menuitem").end();this._trigger("focus",E,{item:D})},deactivate:function(){if(!this.active){return }this.active.children("a").removeClass("ui-state-hover").removeAttr("id");this._trigger("blur");this.active=null},next:function(B){this.move("next",".ui-menu-item:first",B)},previous:function(B){this.move("prev",".ui-menu-item:last",B)},first:function(){return this.active&&!this.active.prev().length},last:function(){return this.active&&!this.active.next().length},move:function(E,D,C){if(!this.active){this.activate(C,this.element.children(D));return }var B=this.active[E+"All"](".ui-menu-item").eq(0);if(B.length){this.activate(C,B)}else{this.activate(C,this.element.children(D))}},nextPage:function(D){if(this.hasScroll()){if(!this.active||this.last()){this.activate(D,this.element.children(":first"));return }var E=this.active.offset().top,C=this.element.height(),B=this.element.children("li").filter(function(){var F=A(this).offset().top-E-C+A(this).height();return F<10&&F>-10});if(!B.length){B=this.element.children(":last")}this.activate(D,B)}else{this.activate(D,this.element.children(!this.active||this.last()?":first":":last"))}},previousPage:function(C){if(this.hasScroll()){if(!this.active||this.first()){this.activate(C,this.element.children(":last"));return }var D=this.active.offset().top,B=this.element.height();result=this.element.children("li").filter(function(){var E=A(this).offset().top-D+B-A(this).height();return E<10&&E>-10});if(!result.length){result=this.element.children(":first")}this.activate(C,result)}else{this.activate(C,this.element.children(!this.active||this.first()?":last":":first"))}},hasScroll:function(){return this.element.height()<this.element.attr("scrollHeight")},select:function(B){this._trigger("selected",B,{item:this.active})}})}(jQuery));
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/templates/annotation.soy' */
// This file was automatically generated from annotation.soy.
// Please don't edit this file by hand.

/**
 * @fileoverview Templates in namespace FileViewer.Templates.Annotation.
 */

if (typeof FileViewer == 'undefined') { var FileViewer = {}; }
if (typeof FileViewer.Templates == 'undefined') { FileViewer.Templates = {}; }
if (typeof FileViewer.Templates.Annotation == 'undefined') { FileViewer.Templates.Annotation = {}; }


FileViewer.Templates.Annotation.controlAnnotationButton = function(opt_data, opt_ignored) {
  return '<a href="#" id="cp-control-panel-annotations" class="cp-icon" title="' + soy.$$escapeHtml("Comments") + '">' + soy.$$escapeHtml("Comments") + '.<div class="counter">0</div></a>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.controlAnnotationButton.soyTemplateName = 'FileViewer.Templates.Annotation.controlAnnotationButton';
}


FileViewer.Templates.Annotation.blankAnnotation = function(opt_data, opt_ignored) {
  return '<div id="cp-blank-annotation"><h5>' + soy.$$escapeHtml("Review and collaborate on this file") + '</h5><p>' + soy.$$escapeHtml("You can comment on any part of this file, just drag a pin to where you want to add the first comment.") + '</p><p>' + soy.$$escapeHtml("@Mention team members in your comment to get their attention.") + '</p></div>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.blankAnnotation.soyTemplateName = 'FileViewer.Templates.Annotation.blankAnnotation';
}


FileViewer.Templates.Annotation.annotationHeader = function(opt_data, opt_ignored) {
  return '<div class="cp-error"/><a id="cp-annotation-next" title="' + soy.$$escapeHtml("Next comment") + '" class="cp-small-icon" href="#">' + soy.$$escapeHtml("Next comment") + '</a><a id="cp-annotation-previous" title="' + soy.$$escapeHtml("Previous comment") + '" class="cp-small-icon" href="#">' + soy.$$escapeHtml("Previous comment") + '</a>' + ((opt_data.current != 0) ? '<span id="cp-annotation-count">' + soy.$$escapeHtml(AJS.format("{0} of {1}",opt_data.current,opt_data.total)) + '</span>' : '') + ((opt_data.canDelete && ! opt_data.resolved) ? '<a id="cp-annotation-more" href="#cp-annotations-more-menu" aria-owns="cp-annotations-more-menu" aria-haspopup="true" class="aui-dropdown2-trigger aui-dropdown2-trigger-arrowless">' + aui.icons.icon({useIconFont: true, size: 'small', icon: 'more', accessibilityText: "More", extraClasses: 'cp-small-icon up'}) + '</a><div id="cp-annotations-more-menu" class="aui-dropdown2 aui-style-default"><ul class="aui-list-truncate"><li><a href="#" id="cp-annotation-delete">' + soy.$$escapeHtml("Delete") + '</a></li></ul></div>' : '');
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.annotationHeader.soyTemplateName = 'FileViewer.Templates.Annotation.annotationHeader';
}


FileViewer.Templates.Annotation.annotationUserHeader = function(opt_data, opt_ignored) {
  return '<div class="' + soy.$$escapeHtml(opt_data.small == true ? 'cp-annotation-user-small' : 'cp-annotation-user') + '"><img src="' + soy.$$escapeHtml(opt_data.author.avatar) + '"></img><a href="' + soy.$$escapeHtml(opt_data.author.profile) + '">' + soy.$$escapeHtml(opt_data.author.name) + '</a></div>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.annotationUserHeader.soyTemplateName = 'FileViewer.Templates.Annotation.annotationUserHeader';
}


FileViewer.Templates.Annotation.addAnnotation = function(opt_data, opt_ignored) {
  return '<div class="cp-error"/><div class="cp-annotation-adding">' + FileViewer.Templates.Annotation.annotationUserHeader(opt_data) + FileViewer.Templates.Annotation.annotationTextarea(null) + '</div>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.addAnnotation.soyTemplateName = 'FileViewer.Templates.Annotation.addAnnotation';
}


FileViewer.Templates.Annotation.annotationTextarea = function(opt_data, opt_ignored) {
  return '<div class="cp-add-annotation cp-editor">' + FileViewer.Templates.Annotation.editorLoader(null) + '</div>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.annotationTextarea.soyTemplateName = 'FileViewer.Templates.Annotation.annotationTextarea';
}


FileViewer.Templates.Annotation.topLevelAnnotation = function(opt_data, opt_ignored) {
  return '<div id="cp-top-level-annotation" data-commentId=' + soy.$$escapeHtml(opt_data.id) + '>' + FileViewer.Templates.Annotation.annotationUserHeader(opt_data) + '<div id="cp-annotation-main-comment" class="cp-annotation-comment  wiki-content"><p>' + soy.$$filterNoAutoescape(opt_data.comment) + '</p></div><ul class="cp-annotation-actions">' + ((opt_data.canEdit && ! opt_data.resolved) ? '<li><a class="cp-annotation-edit" href="#">' + soy.$$escapeHtml("Edit") + '</a></li>' : '') + ((opt_data.canResolve) ? '<li><a class="cp-annotation-resolve" href="#">' + ((opt_data.resolved) ? soy.$$escapeHtml("Unresolve") : soy.$$escapeHtml("Resolve")) + '</a></li>' : '') + ((! opt_data.resolved) ? '<span class="cp-annotation-comment-like"></span>' : '') + '<li class="nobullet">' + soy.$$escapeHtml(AJS.DateTimeFormatting.friendlyFormatDateTime(new Date(opt_data.date), new Date(), Number(AJS.Meta.get('user-timezone-offset')))) + '</li></ul></id>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.topLevelAnnotation.soyTemplateName = 'FileViewer.Templates.Annotation.topLevelAnnotation';
}


FileViewer.Templates.Annotation.likes = function(opt_data, opt_ignored) {
  return '<li>' + ((opt_data.hasLiked) ? '<a class="cp-annotation-unlike" href="#">' + soy.$$escapeHtml("Unlike") + '</a>' : '<a class="cp-annotation-like" href="#">' + soy.$$escapeHtml("Like") + '</a>') + '</li>' + ((opt_data.likes > 0) ? '<li><span class="cp-annotation-like-summary"><span class="cp-annotation-like-icon aui-icon aui-icon-small aui-iconfont-like-small"></span><span class="cp-annotation-count">' + soy.$$escapeHtml(opt_data.likes) + '</span></span></li>' : '');
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.likes.soyTemplateName = 'FileViewer.Templates.Annotation.likes';
}


FileViewer.Templates.Annotation.annotationReply = function(opt_data, opt_ignored) {
  return FileViewer.Templates.Annotation.annotationUserHeader({author: opt_data.author, small: true}) + '<div class="cp-annotation-comment wiki-content" data-commentId=' + soy.$$escapeHtml(opt_data.id) + '><p>' + soy.$$filterNoAutoescape(opt_data.comment) + '</p></div><ul class="cp-annotation-actions">' + ((! opt_data.resolved) ? ((opt_data.canEdit) ? '<li><a class="cp-annotation-edit" href="#">' + soy.$$escapeHtml("Edit") + '</a></li>' : '') + ((opt_data.canDelete) ? '<li><a class="cp-annotation-delete" href="#">' + soy.$$escapeHtml("Delete") + '</a></li>' : '') + '<span class="cp-annotation-reply-like"></span>' : '') + '<li class="nobullet">' + soy.$$escapeHtml(AJS.DateTimeFormatting.friendlyFormatDateTime(new Date(opt_data.date), new Date(), Number(AJS.Meta.get('user-timezone-offset')))) + '</li></ul>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.annotationReply.soyTemplateName = 'FileViewer.Templates.Annotation.annotationReply';
}


FileViewer.Templates.Annotation.annotationLike = function(opt_data, opt_ignored) {
  return '<a href="#">' + ((opt_data.liked) ? soy.$$escapeHtml("Unlike") : soy.$$escapeHtml("Like")) + '</a>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.annotationLike.soyTemplateName = 'FileViewer.Templates.Annotation.annotationLike';
}


FileViewer.Templates.Annotation.annotationReplyInput = function(opt_data, opt_ignored) {
  return '<div id="cp-annotation-reply-input">' + ((! opt_data.resolved && opt_data.canReply) ? FileViewer.Templates.Annotation.annotationUserHeader({author: opt_data.author, small: true}) + FileViewer.Templates.Annotation.replyInputBox(null) : '') + '</div>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.annotationReplyInput.soyTemplateName = 'FileViewer.Templates.Annotation.annotationReplyInput';
}


FileViewer.Templates.Annotation.replyInputBox = function(opt_data, opt_ignored) {
  return '<input placeholder="' + soy.$$escapeHtml("Reply") + '"></input>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.replyInputBox.soyTemplateName = 'FileViewer.Templates.Annotation.replyInputBox';
}


FileViewer.Templates.Annotation.resolved = function(opt_data, opt_ignored) {
  return '<div id="cp-annotation-resolved"><p>' + soy.$$escapeHtml("Resolved") + '</p><div class="cp-resolved-info">' + soy.$$escapeHtml("Resolved feedback can be shown from the tools menu.") + '</div></div>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.resolved.soyTemplateName = 'FileViewer.Templates.Annotation.resolved';
}


FileViewer.Templates.Annotation.editorLoader = function(opt_data, opt_ignored) {
  return '<form class="aui"><div class="loading-container" /></form>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.editorLoader.soyTemplateName = 'FileViewer.Templates.Annotation.editorLoader';
}


FileViewer.Templates.Annotation.fileControlAnnotate = function(opt_data, opt_ignored) {
  return '<a href="#" id=\'cp-file-control-annotate\' class=\'cp-icon\' title="' + soy.$$escapeHtml("Drag this pin to add a comment") + '">' + soy.$$escapeHtml("Drag this pin to add a comment") + '</a>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Annotation.fileControlAnnotate.soyTemplateName = 'FileViewer.Templates.Annotation.fileControlAnnotate';
}

} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/utils/editor-utils.js' */
define("cp/component/utils/editor-utils",["jquery","underscore","ajs","backbone","exports"],function(d,i,f,h,c){var g=["dateautocomplete","confluencemacrobrowser","propertypanel","jiraconnector","dfe"];var a=["autoresize"];function e(){return i.clone(g)}function b(){return i.clone(a)}function j(){var k=f.Rte&&f.Rte.getEditor();if(k&&k.getContent()!==""){k.setDirty(true)}if(k&&k.isDirty()&&!d(".quick-comment-body .editor-container").length){return window.confirm("You have an unsaved comment on this page. Are you sure you want to continue? You will lose any unsaved changes.")}return true}c.getUnsupportedRtePlugins=e;c.getSupportedRtePlugins=b;c.confirmProcess=j});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/utils/editor.js' */
define("cp/component/utils/editor",["jquery","underscore","ajs","cp/component/utils/editor-utils","exports","FileViewer"],function(c,q,e,h,s,a){var b;var l;var k;var g;var f;function n(t,u){if(!e.Confluence.EditorLoader.resourcesLoaded()){this.$form.find(".loading-container").spin("small")}b=a.prototype.close;u.close=function(){if(h.confirmProcess()){r();return b.apply(this,arguments)}};l=a.prototype.showFileNext;u.showFileNext=function(){if(h.confirmProcess()){r();return l.apply(this,arguments)}};k=a.prototype.showFilePrev;u.showFilePrev=function(){if(h.confirmProcess()){r();return k.apply(this,arguments)}};g=a.prototype.showFileWithCID;u.showFileWithCID=function(){if(h.confirmProcess()){r();return g.apply(this,arguments)}};f=a.prototype.showFile;u.showFile=function(){if(h.confirmProcess()){r();return f.apply(this,arguments)}};t&&t()}function j(t){e.Meta.set("content-type","comment");e.Meta.set("min-editor-height",80);e.Meta.set("use-inline-tasks","false");t&&t()}function i(u,t){t.$form.find(".loading-container").hide();t.$form.find("#rte-button-preview").hide();t.$form.find("#rte-button-publish").text("Save").removeAttr("title");t.$form.find("#rte-spinner").parent().addClass("rte-button-spinner").appendTo("#rte-savebar .toolbar-split .toolbar-split-right");t.$form.find("#toolbar-hints-draft-status").hide();t.$form.find("#wysiwygTextarea_ifr").height(e.Meta.get("min-editor-height"));e.Meta.set("min-editor-height",undefined);if(this.hideCancelButton){t.$form.find("#rte-button-cancel").hide()}u&&u();e.Confluence.QuickEdit.QuickEditPage.disable()}function o(t,u){u.close=b;u.showFileNext=l;u.showFilePrev=k;u.showFileWithCID=g;u.showFile=f;t&&t()}function m(t){return e.Confluence.QuickEdit.activateEditor({preActivate:q.partial(n,t.preActivate,t._fileViewer),preInitialise:q.partial(j,t.preInitialise),postInitialise:q.partial(c.proxy(i,t),t.postInitialise),toolbar:false,$container:t.container,$form:t.form,saveHandler:t.saveHandler,cancelHandler:t.cancelHandler,fetchContent:t.fetchContent(),closeAnyExistingEditor:true,postDeactivate:q.partial(o,t.postDeactivate,t._fileViewer),plugins:h.getSupportedRtePlugins(),excludePlugins:h.getUnsupportedRtePlugins()})}function r(){if(e.Rte&&e.Rte.getEditor()){if(!c(".quick-comment-body .editor-container").length){return e.Confluence.QuickEdit.deactivateEditor()}}else{return c.Deferred().resolve()}}function p(){return e.Rte.Content.getHtml()}function d(t){c(".ic-sidebar .rte-button-spinner").toggleClass("aui-icon-wait",t)}s.init=m;s.remove=r;s.getContent=p;s.setEditorBusy=d});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/utils/editor-view.js' */
define("cp/component/utils/editor-view",["backbone","underscore","jquery","cp/component/utils/editor","cp/component/utils/editor-utils"],function(f,c,d,a,e){var b=f.View.extend({initialize:function(g){this.editorSetup=g.editorSetup;this.preActivate=g.preActivate;this.preInitialise=g.preInitialise;this.postInitialise=g.postInitialise;this.container=g.container;this.saveHandler=g.saveHandler;this.cancelHandler=g.cancelHandler;this.postDeactivate=g.postDeactivate;this.content=g.content;this.errorCallback=g.error;this.restoreCallback=g.restoreCallback;this.successCallback=g.success;this._fileViewer=g.fileViewer;this.editorSetup&&this.editorSetup()},render:function(){a.init({preActivate:this.preActivate,preInitialise:this.preInitialise,postInitialise:this.postInitialise,container:this.container,form:this.container.find("form.aui"),saveHandler:this.saveHandler,cancelHandler:this.cancelHandler,fetchContent:function(){var g=new d.Deferred();g.resolve({editorContent:this.content});return g}.bind(this),closeAnyExistingEditor:true,postDeactivate:this.postDeactivate,_fileViewer:this._fileViewer}).fail(function(){this.errorCallback()}.bind(this));return this},getContent:function(){return a.getContent()},remove:function(){a.remove();return this},checkIfOpen:function(){return e.confirmProcess()}});return b});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/annotation-button-view.js' */
define("cp/component/annotation/annotation-button-view",["jquery","backbone","FileViewer","cp/component/utils/editor-utils"],function(d,f,c,e){var a=c.require("template-store-singleton");var b=f.View.extend({events:{click:"_toggleAnnotations"},tagName:"span",initialize:function(g){this._fileViewer=g.fileViewer;this._model=this._fileViewer.getCurrentFile();this._annotations=this._model.get("annotations");this.listenTo(this._annotations,"add reset sync change:resolved remove filterUpdated",this._updateAnnotationCount)},render:function(){this.$el.html(a.get("Annotation.controlAnnotationButton")());this._updateAnnotationCount();if(d.fn.tooltip){this.$("a").tooltip({gravity:"n"})}return this},_toggleAnnotations:function(){if(this._fileViewer.getView().fileSidebarView.isAnyPanelInitialized()){if(e.confirmProcess()){this._fileViewer.trigger("cp.close-editor");this._fileViewer.getView().fileSidebarView.teardownPanel()}}else{this._annotations.getCurrentOrNext();this._fileViewer.getView().fileSidebarView.initializePanel("annotations")}},_updateAnnotationCount:function(){var g=this._annotations.getCount();this.$(".counter").text(g>9?"9+":g)}});return b});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/comments.js' */
define("cp/component/annotation/comments",["backbone","underscore","cp/component/annotation/comment"],function(e,a,c){var b=function(f){return function(g){for(var h in f){if(f[h]!==g.get(h)){return false}}return true}};var d=e.Collection.extend({model:c,initialize:function(f,g){this._current=null;this.service=g&&g.service;this._currentFilter={resolved:false};if(g&&g.fileModel){this.fileModel=g.fileModel}this.listenTo(this,"remove",this.selectNextIfRemoved)},comparator:function(h){var f=h.get("position");var g=h.get("pageNumber");return[g,f[1],f[0]]},selectNextIfRemoved:function(f){if(this._current===f){this.next()}},fetchComments:function(){if(this.size()===0){return this.fetch()}else{return $.when()}},sync:function(i,h){if(!this.service){return}if(i==="read"){var g=h.service.getAnnotations(),f=this;g&&g.done(function(j){j=a.map(j,function(k){return new c(k,{service:f.service})});h.reset(j,{silent:true});h.trigger("sync",h)});return g}},currentIndexOfWhere:function(g,f){return f?this.where(f).indexOf(g):this.indexOf(g)},nextWhere:function(h){var g=this.indexOf(this._current);var f=this.chain().rest(g+1).filter(b(h)).first().value();f=f||this.chain().filter(b(h)).first().value();this.setSelected(f);return f},prevWhere:function(h){var g=this.indexOf(this._current);var f=this.chain().first(Math.max(g,0)).filter(b(h)).last().value();f=f||this.chain().filter(b(h)).last().value();this.setSelected(f);return f},currentIndexOf:function(f){return this.currentIndexOfWhere(f,this._currentFilter)},next:function(){return this.nextWhere(this._currentFilter)},prev:function(){return this.prevWhere(this._currentFilter)},getCurrent:function(){return this._current},getCurrentOrNext:function(){if(!this._current||!this.isFiltered(this._current)){this._current=this.next()}return this.getCurrent()},isFiltered:function(f){var g=b(this.getFilter());return g(f)},selectCommentWithId:function(g,f){var h=this.findWhere({id:g});if(h&&h.get("resolved")){this.setFilter()}if(f){h.replies.selectReplyWithId(f)}this.setSelected(h);this.trigger("pinSelected")},setSelected:function(g,f){this.invoke("set",{selected:false});this._current=null;if(g){g.set({selected:true});this._current=g;g.replies.fetch();!f&&this.trigger("selected",g)}else{!f&&this.trigger("unselected")}},setResolved:function(f){f.set({resolved:true})},getCountWhere:function(f){return f?this.where(f).length:this.size()},getCount:function(){return this.getCountWhere(this._currentFilter)},setFilter:function(f){this._currentFilter=f;this.trigger("filterUpdated");return this},getFilter:function(){return this._currentFilter}});return d});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/comment.js' */
define("cp/component/annotation/comment",["cp/component/annotation/replies","cp/component/annotation/likes","ajs","backbone"],function(b,d,a,e){var c=e.Model.extend({defaults:{author:{name:"",avatar:"",profile:""},comment:"",date:new Date(),pageNumber:1,position:[0.5,0.5],resolved:false,selected:false,hasEditPermission:true,hasResolvePermission:true,hasDeletePermission:true,hasReplyPermission:true},initialize:function(f,g){this.service=g.service;if(this.service){this.replies=new b(undefined,{service:this.service,parentModel:this})}else{this.replies=new b()}this.likes=new d([],{contentId:this.get("id"),replies:this.replies.models});this.on("change:id",this.createLikes);this.listenTo(this.replies,"reset sync",this.createLikes);this.createLikes();this.set("fileModel",f.fileModel)},createLikes:function(){if(!this.replies.isSynced()){return}if(this.get("id")!==undefined){this.likes.setReplies(this.replies.models);this.likes.fetch()}},setResolved:function(f){this.save({resolved:f})},isNew:function(){return this.get("isNew")},sync:function(i,g,f){if(!this.service){return}if(i==="create"||i==="update"){var h=g.service.save(g);h.done(function(j){g.set(j);f.success()}).fail(function(){f.error()});return h}else{if(i==="delete"){var h=g.service.remove(g);h.done(function(){f.success()}).fail(function(){f.error()});return h}}}});return c});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/replies.js' */
define("cp/component/annotation/replies",["backbone","underscore","cp/component/annotation/reply"],function(d,b,a){var c=d.Collection.extend({initialize:function(e,f){this.parentModel=f.parentModel;this.service=f&&f.service;this.synced=false;this._skipFetch=false},sync:function(j,h,e){var i=h.parentModel&&h.parentModel.get("id");if(e.force){this._skipFetch=false}if(!this.service||!i||this._skipFetch){return}if(j==="read"){this._skipFetch=true;var g=h.service.getReplies({parentId:i}),f=this;g.done(function(k){k=b.map(k,function(l){return new a(l,{service:f.service})});this.synced=true;h.reset(k)}.bind(this)).fail(function(){this.synced=false;this._skipFetch=false}.bind(this))}},addReply:function(g,e){var f=new a(g,{service:this.service});this.setSelected(f);this.add(f);f.save(null,{wait:true,error:e.error})},selectReplyWithId:function(e){if(!this.isSynced()){this.listenToOnce(this,"reset",function(){this.setSelected(this.findWhere({id:e}))})}else{this.setSelected(this.findWhere({id:e}))}},setSelected:function(e){this.invoke("set",{selected:false});if(e){e.set("selected",true)}},isSynced:function(){return this.synced}});return c});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/reply.js' */
define("cp/component/annotation/reply",["backbone","cp/component/annotation/likes"],function(c,b){var a=c.Model.extend({defaults:{author:"",comment:"",date:new Date(),resolved:false,hasEditPermission:false,hasDeletePermission:false},initialize:function(d,e){this.service=e.service},sync:function(g,e,d){if(!this.service){return}if(g==="create"||g==="update"){var f=e.service.save(e);f.done(function(h){e.set(h);d.success()}).fail(function(){d.error()});return f}else{if(g==="delete"){var f=e.service.remove(e);f.done(function(h){d.success()}).fail(function(){d.error()});return f}}}});return a});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/annotation-view.js' */
define("cp/component/annotation/annotation-view",["backbone","underscore","jquery","ajs","cp/component/annotation/annotation-header-view","cp/component/annotation/comment-view","cp/component/annotation/add-annotation-view","FileViewer"],function(g,h,d,f,i,a,e,b){var j=b.require("template-store-singleton");var c=g.View.extend({id:"cp-annotations",tagName:"div",initialize:function(k){this._fileViewer=k.fileViewer;this.fileSidebarView=k.panelView;this.model=this._fileViewer.getCurrentFile();this.annotations=this.model.get("annotations");this.listenTo(this.annotations,"reset sync selected unselected add remove",this.render);this.listenTo(this.annotations,"pinSelected",this.show);this.listenTo(this.annotations,"filterUpdated",this.updateWithFiltered);this.listenTo(this._fileViewer,"cp.close-editor",this._closeEditor);this.show();this.render()},teardown:function(){this.hide();this.commentView&&this.commentView.off().remove();this.addAnnotationView&&this.addAnnotationView.teardown()&&this.addAnnotationView.off().remove()},hide:function(){d("#cp-control-panel-annotations").removeClass("focused");this.annotations.setSelected();this._fileViewer._fileState.trigger("cp.hideAnnotations")},show:function(){d("#cp-control-panel-annotations").addClass("focused")},addAnnotation:function(l){if(!this.canOpenNewEditor()){d("#cp-file-control-annotate").draggable("option","disabled",false);return}this.show();this.annotations.setSelected();var k=this._fileViewer.getCurrentFile().createAnnotation({author:this.currentUser,position:[l.x,l.y],pageNumber:l.pageNumber,isNew:true});this.annotations.setSelected(k,true);this.addAnnotationView=new e({annotation:k,collection:this.annotations,fileViewer:this._fileViewer,annotationView:this});this.$el.html(this.addAnnotationView.$el);this.addAnnotationView.render();this.$el.find("textarea.cp-add-annotation").focus()},render:function(){if(this.annotations){var k=this.annotations.getCurrent();if(!k){this.$el.html(j.get("Annotation.blankAnnotation")())}else{this.headerView=new i({model:this.model,annotationView:this});this.commentView=new a({model:k,annotationView:this});this.$el.empty().append(this.headerView.render().$el).append(this.commentView.render().el)}}return this},_generateError:function(k){this.headerView._generateError(k)},canOpenNewEditor:function(){return !this._editorView||this._editorView.checkIfOpen()},isCommentVisible:function(k){return this.annotations.isFiltered(k)},clearErrorFlags:function(){this.headerView._clearError()},_closeEditor:function(){this._editorView&&this._editorView.remove()},updateWithFiltered:function(){this.annotations.getCurrentOrNext();this.render()}});return c});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/pin-view.js' */
define("cp/component/annotation/pin-view",["backbone","jquery","cp/component/annotation/comment","cp/component/utils/editor-utils"],function(e,b,c,d){var a=e.View.extend({model:c,tagName:"span",className:"cp-icon cp-active-annotation",events:{click:"clickPin"},clickPin:function(){if(d.confirmProcess()){var f=this._fileViewer.getView().fileSidebarView;if(this.model.get("selected")&&f.isPanelInitialized("annotations")){this.closeSidebar()}else{this.showPin();this._fileViewer.trigger("cp.close-editor")}}},closeSidebar:function(){this.collection.setSelected();this._fileViewer.trigger("cp.close-editor");this._fileViewer.getView().fileSidebarView.teardownPanel()},showPin:function(){this.collection.setSelected(this.model);this.collection.trigger("pinSelected");this._fileViewer._fileState.trigger("cp.showAnnotations")},initialize:function(f){this._fileViewer=f.fileViewer;this.calculatePosition=f.calculatePosition;this.listenTo(this.model,"sync",this.render);this.listenTo(this.model,"change:resolved",this.setResolved);this.listenTo(this.model,"change:selected",this.setAnimate)},setResolved:function(){var f=this.model.get("resolved");this.$el.toggleClass("resolved",f)},setSelected:function(){var f=this.model.get("selected");this.$el.toggleClass("selected",f)},setAnimate:function(){var f=this.model.get("selected");this.setSelected();this.$el.toggleClass("animate",f)},setPosition:function(){var g;if(this.calculatePosition){g=this.calculatePosition(this.model.toJSON())}else{var h=this.model.get("position");var f=h[0]*100;var i=h[1]*100;g={x:f+"%",y:i+"%"}}this.$el.css("top",g.y);this.$el.css("left",g.x)},render:function(){this.$el.attr("data-comment-id",this.model.get("id"));this.setPosition();this.setResolved();this.setSelected();return this}});return a});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/pins-view.js' */
define("cp/component/annotation/pins-view",["backbone","jquery","underscore","cp/component/annotation/comments","cp/component/annotation/pin-view"],function(g,d,b,f,a){var c=function(h){return function(i){for(var j in h){if(h[j]!==i.get(j)){return false}}return true}};var e=g.View.extend({collection:f,initialize:function(h){this.container=h.container;this.filter=h.filter;this.calculatePosition=h.calculatePosition;this.collection=h.collection;this.annotationPins=[];this._fileViewer=h.fileViewer;this.listenTo(this.collection,"reset sync add remove",this.markRetrieved);this.listenTo(this.collection,"reset sync add remove",this.render);this.listenTo(this.collection,"filterUpdated",this.render)},markRetrieved:function(){d(this.container).attr("data-pins-retrieved",true)},render:function(){this.unbindAnnotationPins();var i=this.filter?b.filter(this.collection.models,this.filter):this.collection.models,h=this;b.chain(i).filter(c(this.collection.getFilter())).each(function(j){var k=new a({calculatePosition:h.calculatePosition,model:j,collection:h.collection,fileViewer:this._fileViewer});h.annotationPins.push(k);d(k.render().el).prependTo(h.container)},this)},unbindAnnotationPins:function(){while(this.annotationPins.length>0){var h=this.annotationPins.pop();h.remove().off()}},off:function(i,j,h){this.unbindAnnotationPins();return g.Collection.prototype.off.call(this,i,j,h)}});return e});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/reply-view.js' */
define("cp/component/annotation/reply-view",["backbone","underscore","jquery","cp/component/annotation/reply","cp/component/utils/editor-view","cp/component/annotation/likes-view","FileViewer"],function(f,g,d,b,i,a,c){var h=c.require("template-store-singleton");var e=f.View.extend({model:b,tagName:"div",className:"cp-annotation-reply",events:{"click .cp-annotation-edit":"editReply","click .cp-annotation-delete":"deleteReply"},initialize:function(j){this.listenTo(this.model,"change",this.render);this.listenTo(this.model,"remove",this.remove);this._annotationView=j.annotationView;this._parentView=j.commentView},render:function(){if(!this.model.get("id")){return this}this.$el.html(h.get("Annotation.annotationReply")({id:this.model.get("id"),canEdit:this.model.get("hasEditPermission"),canDelete:this.model.get("hasDeletePermission"),author:this.model.get("author"),comment:this.model.get("comment"),date:this.model.get("date"),resolved:this._parentView._isResolved()}));if(this.model.get("selected")){this.$el.addClass("selected")}else{this.$el.removeClass("selected")}this.showLikes();return this},showLikes:function(){var j=new a({el:this.$el.find(".cp-annotation-reply-like"),id:this.model.get("id"),collection:this._parentView.model.likes,_annotationView:this._annotationView});j.render()},editReply:function(){if(!this._annotationView.canOpenNewEditor()){return}var j=this.model.get("editorFormat");this.editorView=this._annotationView._editorView=new i({editorSetup:function(){var k=d(h.get("Annotation.editorLoader")());this.$el.find(".cp-annotation-comment").replaceWith(k);this.$el.find(".cp-annotation-actions").hide()}.bind(this),container:this.$el,saveHandler:g.bind(this.saveReply,this),cancelHandler:g.bind(this.restore,this),postDeactivate:g.bind(this.restore,this),content:j,errorCallback:g.bind(this._handleEditorError,this),restoreCallback:g.bind(this.restore,this),fileViewer:this._annotationView._fileViewer});this.editorView.render()},saveReply:function(j){j&&j.preventDefault();if(this.editorView.getContent()===""){this._generateError("You cannot save an empty comment.");return}this._annotationView.clearErrorFlags();this.model.set({editorFormat:this.editorView.getContent()},{silent:true});this.model.save(null,{wait:true,success:this.restore.bind(this),error:this._handleError.bind(this)});this.editorView&&this.editorView.remove()},restore:function(j){j&&j.preventDefault&&j.preventDefault();this.editorView&&this.editorView.remove();this.render()},deleteReply:function(){var j=window.confirm("Are you sure you want to delete the reply?");if(j){this.model.destroy({wait:true,error:this._handleError.bind(this)})}},_handleError:function(){this._generateError("Error: There was a problem saving your changes.")},_handleEditorError:function(){this._generateError("Error: Could not open the editor.")},_generateError:function(j){this._annotationView._generateError(j)}});return e});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/comment-view.js' */
define("cp/component/annotation/comment-view",["backbone","underscore","jquery","ajs","cp/component/annotation/comment","cp/component/annotation/reply-view","FileViewer","cp/component/annotation/likes-view","cp/component/utils/editor-view"],function(h,i,e,g,d,f,c,a,k){var j=c.require("template-store-singleton");var b=h.View.extend({model:d,tagName:"div",className:"cp-comment-view cp-editor",events:{"click input":"convertToEditor","click #cp-top-level-annotation .cp-annotation-edit":"editComment","click .cp-annotation-resolve":"resolve"},initialize:function(l){this.listenTo(this.model.replies,"reset add",this.showReplies);this.listenTo(this.model,"change",this.render);this.listenTo(this.model,"likesReady",this.showLikes);this.currentUser={name:g.Meta.get("current-user-fullname"),avatar:g.contextPath()+g.Meta.get("current-user-avatar-url"),profile:g.contextPath()+"/display/~"+g.Meta.get("remote-user")};this._annotationView=l.annotationView},renderComment:function(){return j.get("Annotation.topLevelAnnotation")({id:this.model.get("id"),author:this.model.get("author"),comment:this.model.get("comment"),canEdit:this.model.get("hasEditPermission"),canResolve:this.model.get("hasResolvePermission"),resolved:this.model.get("resolved"),date:this.model.get("date")})},renderTopLevelAnnotation:function(){this.$el.find("#cp-top-level-annotation").replaceWith(this.renderComment());this.showLikes()},render:function(){if(!this.model.get("id")){return this}if(this._annotationView.isCommentVisible(this.model)){this.$el.html(this.renderComment());e(j.get("Annotation.annotationReplyInput")({author:this.currentUser,canReply:this.model.get("hasReplyPermission"),resolved:this.model.get("resolved")})).appendTo(this.$el);this.showReplies();this.showLikes()}else{if(this.model.get("resolved")){this.$el.html(j.get("Annotation.resolved")())}}return this},editComment:function(m){if(!this._annotationView.canOpenNewEditor()){return}var l=this.model.get("editorFormat");this.editorView=this._annotationView._editorView=new k({editorSetup:function(){var n=e(j.get("Annotation.editorLoader")());this.$el.find("#cp-annotation-main-comment").replaceWith(n);this.$el.find("#cp-top-level-annotation .cp-annotation-actions").hide()}.bind(this),container:this.$el.find("#cp-top-level-annotation"),form:this.$el.find("form.aui"),saveHandler:i.bind(this.saveEdit,this),cancelHandler:i.bind(this.completedHandler,this),content:l,postDeactivate:i.bind(this.restoreCommentOnly,this),errorCallback:i.bind(this._handleEditorError,this),restoreCallback:i.bind(this.completedHandler,this),fileViewer:this._annotationView._fileViewer});this.editorView.render()},saveEdit:function(l){l&&l.preventDefault();if(this.editorView.getContent()===""){this._generateError("You cannot save an empty comment.");return}this.model.set({editorFormat:this.editorView.getContent()},{silent:true});this.model.save(null,{wait:true,success:this.restoreActions.bind(this),error:this._handleError.bind(this)});this.editorView&&this.editorView.remove()},completedHandler:function(l){this.restoreActions();l.preventDefault()},restoreActions:function(){this.$el.find("#cp-top-level-annotation .cp-annotation-actions").show();this.editorView&&this.editorView.remove()},restoreCommentOnly:function(l){this.$el.find("#cp-top-level-annotation .cp-annotation-actions").show();this.renderTopLevelAnnotation()},showLikes:function(){var l=this.model.likes;var m=new a({el:this.$el.find(".cp-annotation-comment-like"),id:this.model.get("id"),collection:l,_annotationView:this._annotationView});m.render()},convertToInputBox:function(l){l&&l.preventDefault();var m=e(j.get("Annotation.replyInputBox")());this.$el.find("form.aui").replaceWith(m);this.editorView&&this.editorView.remove()},restoreAfterEditorDeactivate:function(l){var m=e(j.get("Annotation.replyInputBox")());this.$el.find("form.aui.fadeIn").replaceWith(m)},convertToEditor:function(){if(!this._annotationView.canOpenNewEditor()){return}this.editorView=this._annotationView._editorView=new k({editorSetup:function(){var l=e(j.get("Annotation.editorLoader")());this.$el.find("input").replaceWith(l)}.bind(this),container:this.$el,saveHandler:i.bind(this.saveReply,this),cancelHandler:i.bind(this.convertToInputBox,this),content:"",postDeactivate:i.bind(this.restoreAfterEditorDeactivate,this),errorCallback:i.bind(this._handleEditorError,this),restoreCallback:function(){e("input").blur()},fileViewer:this._annotationView._fileViewer});this.editorView.render()},resolve:function(){if(this.model.get("resolved")){g.trigger("analyticsEvent",{name:"confluence-spaces.previews.annotation.unresolve",data:{fileType:this._annotationView._fileViewer.getCurrentFile().get("type"),commentId:this.model.get("id"),replyCount:this.model.replies.length}});this.model.setResolved(false)}else{if(!this._annotationView.canOpenNewEditor()){return}g.trigger("analyticsEvent",{name:"confluence-spaces.previews.annotation.resolve",data:{fileType:this._annotationView._fileViewer.getCurrentFile().get("type"),commentId:this.model.get("id"),replyCount:this.model.replies.length}});this.model.setResolved(true);this._annotationView._closeEditor()}},saveReply:function(m){m&&m.preventDefault();var l=this.model.replies;if(this.editorView.getContent()===""){this._generateError("You cannot save an empty comment.");return}this._annotationView.clearErrorFlags();l.addReply({author:this.currentUser,editorFormat:this.editorView.getContent(),parentId:this.model.get("id")},{error:this._handleError.bind(this)});g.trigger("analyticsEvent",{name:"confluence-spaces.previews.annotation.reply",data:{commentId:this.model.get("id")}});this.convertToInputBox()},showReplies:function(){this.$el.find(".cp-annotation-reply").remove();var m=this.model.replies,l=this;i.each(m.models,function(o){var n=new f({model:o,annotationView:l._annotationView,commentView:l});l.$el.find("#cp-annotation-reply-input").before(n.render().el)})},_handleError:function(){this._generateError("Error: There was a problem saving your changes.")},_handleEditorError:function(){this._generateError("Error: Could not open the editor.")},_generateError:function(l){this._annotationView._generateError(l)},_isResolved:function(){return this.model.get("resolved")}});return b});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/annotation-header-view.js' */
define("cp/component/annotation/annotation-header-view",["backbone","underscore","jquery","ajs","FileViewer"],function(g,b,f,a,d){var c=d.require("template-store-singleton");var e=g.View.extend({tagName:"div",className:"cp-annotation-header",events:{"click #cp-annotation-next":"next","click #cp-annotation-previous":"previous"},initialize:function(h){this.annotations=this.model.get("annotations");this.current=this.annotations.getCurrent();this._annotationView=h.annotationView;this.listenTo(this.annotations,"filterUpdated",this.render)},next:function(){this.annotations.next()},previous:function(){this.annotations.prev()},render:function(){this.$el.html(c.get("Annotation.annotationHeader")({current:this.annotations.currentIndexOf(this.current)+1,total:this.annotations.getCount(),canDelete:this.current.get("hasDeletePermission"),resolved:this.current.get("resolved")}));f(".tipsy").remove()&&f.fn.tooltip&&this.$el.find("a").tooltip();var h=b.bind(this.deleteComment,this);this.$el.find("#cp-annotations-more-menu").on({"aui-dropdown2-show":function(){f("body").on("click","#cp-annotation-delete",h)},"aui-dropdown2-hide":function(){f("body").off("click","#cp-annotation-delete",h)}});return this},deleteComment:function(h){h.preventDefault();var i=window.confirm("Are you sure you want to delete the comment?");if(i){this._annotationView._closeEditor();this.annotations.getCurrent().destroy({wait:true,error:this._handleError.bind(this)})}},_handleError:function(){this._generateError("Error: There was a problem saving your changes.")},_generateError:function(h){this._clearError();a.messages.warning(".cp-error",{body:h})},_clearError:function(){f(".cp-error").empty()}});return e});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/add-annotation-view.js' */
define("cp/component/annotation/add-annotation-view",["backbone","underscore","jquery","ajs","cp/component/utils/editor-view","cp/component/utils/editor-utils","FileViewer"],function(g,h,b,f,j,c,a){var i=a.require("template-store-singleton");var e=a.prototype.changeMode;var d=g.View.extend({tagName:"div",id:"cp-add-annotation",events:{},initialize:function(k){this._fileViewer=k.fileViewer;this._annotationView=k.annotationView;this.currentUser={name:f.Meta.get("current-user-fullname"),avatar:f.contextPath()+f.Meta.get("current-user-avatar-url"),profile:f.contextPath()+"/display/~"+f.Meta.get("remote-user")};this._annotation=k.annotation;this.listenTo(this._fileViewer._fileState,"cp.hideAnnotations",this.clearAnnotation);this.listenTo(k.fileViewer,"fv.close",this.clearAnnotation);this.listenTo(this.collection,"pinSelected",this.teardown)},render:function(){this.editorView=this._annotationView._editorView=new j({editorSetup:function(){this.$el.html(i.get("Annotation.addAnnotation")({author:this.currentUser}))}.bind(this),container:this.$el,saveHandler:h.bind(this.saveAnnotation,this),cancelHandler:h.bind(this.cancelAnnotation,this),content:"",restoreCallback:h.bind(this.cancelAnnotation,this),fileViewer:this._fileViewer});this.editorView.render();var k=this;this._fileViewer.changeMode=function(){if(c.confirmProcess()){k.cancelAnnotation();return e.apply(this,arguments)}};return this},cancelAnnotation:function(k){k&&k.preventDefault();this.removeNewAnnotation();this.collection.setSelected(this.collection.getCurrentOrNext())},removeNewAnnotation:function(){this.clearAnnotation();this._annotation.destroy();this.editorView&&this.editorView.remove();this._fileViewer.changeMode=e},clearAnnotation:function(){this._fileViewer.getView().$el.find("#cp-file-control-annotate").draggable("option","disabled",false)},saveAnnotation:function(k){k&&k.preventDefault();if(this.editorView.getContent()===""){this._generateError("You cannot save an empty comment.");return}this._annotation.set("editorFormat",this.editorView.getContent(),{silent:true});this._annotation.set("isNew",false);this._annotation.save();this.editorView&&this.editorView.remove();this.clearAnnotation();f.trigger("analyticsEvent",{name:"confluence-spaces.previews.annotation.comment",data:{fileType:this._fileViewer.getCurrentFile().get("type"),attachmentId:this._fileViewer.getCurrentFile().get("id")}});this.collection.setSelected(this._annotation);this._fileViewer.changeMode=e},teardown:function(){if(this._annotation.isNew()){this.removeNewAnnotation()}else{this.clearAnnotation()}return this},_generateError:function(k){b(".cp-error").empty();f.messages.warning(".cp-error",{body:k})}});return d});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/likes.js' */
define("cp/component/annotation/likes",["backbone","underscore","jquery","cp/component/annotation/like","ajs"],function(f,c,d,b,a){var e=f.Collection.extend({model:b,initialize:function(h,g){this.contentId=g.contentId;this.replies=g.replies?g.replies:[];this._skipFetch=false},addLike:function(h,g){var i=c.find(this.models,function(j){return j.get("content_id")===h});if(!i){i=new b();this.add(i)}i.save(null,{id:h,wait:true,error:g.error})},removeLike:function(h,g){var i=c.find(this.models,function(j){return j.get("content_id")===h});i.id="";i.destroy({id:h,wait:true})},sync:function(k,j,h){if(h.force){this._skipFetch=false}if(this._skipFetch||!j.contentId){return}if(k==="read"){this._skipFetch=true;var i=this._getCommentIds();var g=d.Deferred();d.ajax({url:a.contextPath()+"/rest/likes/1.0/content/likes",type:"POST",data:JSON.stringify(i),contentType:"application/json"}).then(function(m){var l=c.map(m,function(n){return new b(n)});j.reset(l);g.resolve(l)}).fail(function(l,n,m){this._skipFetch=false;g.reject(l,n,m)}.bind(this))}},setReplies:function(g){this.replies=g},_getCommentIds:function(){var g=[];g.push(this.contentId);if(this.replies){c.each(this.replies,function(h){g.push(h.get("id"))})}return{ids:g}}});return e});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/like.js' */
define("cp/component/annotation/like",["backbone","jquery","ajs"],function(d,c,a){var b=d.Model.extend({defaults:{content_id:"",content_type:"",likes:[],summary:""},sync:function(g,f,e){if(g!=="create"&&g!=="update"&&g!=="delete"){throw"Unsupported method in likes model: "+g}return c.ajax({url:a.contextPath()+"/rest/likes/1.0/content/"+e.id+"/likes",type:g==="create"||g==="update"?"POST":"DELETE",contentType:"application/json"}).done(function(h){f.set(h);f.trigger("sync",f,h,e)}).error(function(){e.error&&e.error()})}});return b});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/likes-view.js' */
define("cp/component/annotation/likes-view",["backbone","jquery","underscore","ajs","cp/component/annotation/comments","FileViewer","cp/component/annotation/likes"],function(g,e,h,f,d,c,b){var i=c.require("template-store-singleton");var a=g.View.extend({collection:b,tagName:"span",className:"cp-annotation-like",events:{"click .cp-annotation-like":"like","click .cp-annotation-unlike":"unlike"},initialize:function(j){this.collection=j.collection;this.commentId=j.id;this._annotationView=j._annotationView;this.collection&&this.listenTo(this.collection,"reset add remove sync",this.render)},render:function(){this.$el.empty();if(this.collection===undefined){return}var k=h.find(this.collection.models,function(m){return m.attributes.content_id===this.commentId}.bind(this));var l=!!k&&h.some(k.get("likes"),function(m){return m.user.name===f.Meta.get("remote-user")});var j=k?k.get("likes").length:0;this.$el.html(i.get("Annotation.likes")({likes:j,hasLiked:l}));return this},like:function(){f.trigger("analyticsEvent",{name:"confluence-spaces.previews.annotation.like",data:{fileType:this._annotationView._fileViewer.getCurrentFile().get("type"),commentId:this.commentId}});this.collection.addLike(this.commentId,{error:this._handleError.bind(this)})},unlike:function(){this.collection.removeLike(this.commentId)},_handleError:function(){this._annotationView._generateError("Error: Unable to save your like.")}});return a});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/content-view.js' */
define("cp/component/annotation/content-view",["FileViewer","backbone","underscore","jquery"],function(a,g,h,d){var c=500;var b=c-100;var i={PLUS:187,MINUS:189,PLUS_NUMPAD:107,MINUS_NUMPAD:109,PLUS_FF:61,MINUS_FF:173};var e=a.require("BaseViewer");var f={annotationEvents:{"mousemove.contentView.show":"_showControlsOnMove","mousemove.contentView.hide":"_hideControlsOnMove"},initialize:function(){this.events=h.extend(this.events||{},this.annotationEvents);this._toggleControlsTimeout=null;this._autoToggleControls=true;d(document).on("keydown.viewerZoom",this._handleKeyboardZoom.bind(this))},_showControlsOnMove:h.throttle(function(){if(!this._autoToggleControls){return}this.showControls()},b),_hideControlsOnMove:h.throttle(function(){if(!this._autoToggleControls){return}this.hideControls()},b),showControls:function(){if(!this.getControlsElement){return}clearTimeout(this._toggleControlsTimeout);this.getControlsElement().show()},hideControls:function(){if(!this.getControlsElement){return}this._toggleControlsTimeout=this._setHideTimer()},_setHideTimer:function(){return setTimeout(function(){if(this.getControlsElement().is(":hover")){return}this.getControlsElement().fadeOut()}.bind(this),c)},autoToggleControls:function(j){this._autoToggleControls=j;if(!this._autoToggleControls){clearTimeout(this._toggleControlsTimeout)}},_handleKeyboardZoom:function(j){var k=(j.ctrlKey||j.metaKey);if(this.zoomIn&&k&&(j.which===i.PLUS||j.which===i.PLUS_NUMPAD||j.which===i.PLUS_FF)){this.zoomIn();j.preventDefault()}if(this.zoomOut&&k&&(j.which===i.MINUS||j.which===i.MINUS_NUMPAD||j.which===i.MINUS_FF)){this.zoomOut();j.preventDefault()}}};Object.keys(f).forEach(function(j){e[j]=f[j]});return e});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:annotation-plugin', location = '/js/component/annotation/annotation-plugin.js' */
define("cp/component/annotation/annotation-plugin",["FileViewer","cp/component/annotation/annotation-view","cp/component/annotation/annotation-button-view","cp/component/annotation/pins-view","cp/component/annotation/comments","cp/component/annotation/comment","cp/component/annotation/content-view","underscore","jquery"],function(b,e,l,f,d,c,g,j,h){var k=b.require("template-store-singleton");var i=b.require("unknown-file-type-view");var a=function(s){var r=s.getConfig();if(!r.enableAnnotations||!r.commentService){return}var z=r.commentService;g.prototype.annotationOptions={dropTarget:".cp-annotatable"};s.getView().fileSidebarView.addPanelView("annotations",e);var A=s.getView().fileControlsView;var o=s.getView().fileSidebarView;var w=function(){var B=s.getCurrentFile();return !B.get("isRemoteLink")};A.addLayerView("annotationButton",l,{predicate:w,weight:5});var q=a.showAnnotationsPanel;s._fileState.on("cp.showAnnotations",j.partial(q,s));var p=function(B){if(B.createAnnotation){return}B.set("annotations",new d([],{service:new z(B.get("id"),B.get("version")),fileModel:B}));if(b.isPluginEnabled("permalink")){var C=b.getPlugin("permalink");B.get("annotations").on("selected",function(D){if(D.get("id")){C.setRouteForPin(B,D)}else{D.on("change:id",function(){C.setRouteForPin(B,D)})}})}B.on("change:id",function(){this.get("annotations").service=new z(B.get("id"),B.get("version"))});B.createAnnotation=function(G){var F=j.extend(G,{fileModel:this});var H=this.get("annotations");var E=new z(B.get("id"),B.get("version"));var D=new c(F,{service:E});H.add(D);return D}.bind(B)};s.getView().on("fv.fileChange",p);var y=function(C){var B=s.getCurrentFile();if(B.get("annotations").where({resolved:true}).length>0){C.addFileAction({key:"resolved.toggle",text:"Show resolved comments",callback:function(){B.get("annotations").setFilter();x(C)}.bind(this)})}};var x=function(C){var B=s.getCurrentFile();C.addFileAction({key:"resolved.toggle",text:"Hide resolved comments",callback:function(){B.get("annotations").setFilter({resolved:false});y(C)}.bind(this)})};var v=function(B,D){var C=D.getFilter();if(j.isEqual(C,{resolved:false})){y(B)}else{x(B)}};var u;s.close=j.wrap(s.close,function(B){if(u){return}B.apply(s,Array.prototype.slice.call(arguments,1))});s.showFile=j.wrap(s.showFile,function(B){if(u){return}return B.apply(s,Array.prototype.slice.call(arguments,1))});var n=false;var m=function(T){var G=s.getView().fileContentView.getLayerForName("content")._viewer;if(!w()||G instanceof i){if(G instanceof i){A.getLayerForName("annotationButton").$el.hide()}o.teardownPanel();return}var M=h(".cp-toolbar");var N=M.find("#cp-file-control-annotate");if(N.length===0&&(T.get("hasReplyPermission")||T.get("hasReplyPermission")===undefined)){N=h(k.get("Annotation.fileControlAnnotate")());h.fn.tooltip&&N.tooltip({gravity:"s"});N.appendTo(M);M.css("margin-left",-M.width()/2)}T.trigger("cp.control-added",{plugin:"annotation"});G=j.extend(G,g);if(!n&&!h(".cp-annotatable .cp-active-annotation").length){G.renderAnnotations&&G.renderAnnotations(f);n=true}var S=A.getLayerForName("moreButton");var B=T.get("annotations");v(S,B);B.on("sync change:resolved filterUpdated",j.partial(v,S,B));B.fetchComments().done(function(){if(s.getView().fileSidebarView.isPanelInitialized("annotations")){B.getCurrentOrNext()}});var O=G.annotationOptions.dropTarget;var F=G.annotationOptions.annotationCreated;var D=function(Y,ab){ab.helper.addClass("active");var Z=h(this);var X=Z.offset();var ae=Y.pageX-X.left;var ac=Y.pageY-X.top;var ad=ae/Z.width();var aa=ac/Z.height();var V;if(F){V=F(this,Y)}V=j.extend({},V,{x:ad,y:aa});var W=(V.x*100)+"%";var U=(V.y*100)+"%";Z.closest(O).append(ab.helper.detach());ab.helper.css({left:W,top:U});s._fileState.trigger("cp.showAnnotations");s.getView().$el.find("#cp-file-control-annotate,#cp-control-panel-annotations").draggable("option","disabled",true);o.getInitializedPanel("annotations").addAnnotation(V)};var L=s.getView().$el.find("#cp-file-control-annotate");var I=L.draggable({appendTo:s.getView().el,helper:function(){return h("<div class='annotation-pin'></div>")},cursor:"-webkit-grabbing",cursorAt:{left:0,top:0},scroll:false,stack:"img",revert:"invalid",start:function(){u=true;G.autoToggleControls(false);G.hideControls();h(O).droppable({tolerance:"pointer",drop:D})},stop:function(){u=false;G.showControls();G.autoToggleControls(true);h(O).droppable("destroy")}});var J=I.data("draggable");if(J&&J._mouseUp&&J._mouseMove&&J._trigger&&J._clear){var E;var H=function(U){if(!u&&!J.options.disabled){J._mouseStart.call(J,U);u=true;E=U;C()}};var R=function(U){if(h(U.target).is(N)){return}if(u&&!J.options.disabled){J._mouseDownEvent=E;J._mouseUp.call(J,U);u=false;K()}};var Q=function(U){if(u&&!J.options.disabled){J._mouseStarted=true;J._mouseMove.call(J,U)}};var P=function(U){if(u&&!J.options.disabled&&U.keyCode===27){J._trigger("stop",U);J._clear()}};var C=function(){h(document).on("mousemove",Q);h(O).on("click",R);h(document).on("click",R);h(document).on("keyup",P)};var K=function(){h(document).off("mousemove",Q);h(O).off("click",R);h(document).off("click",R);h(document).off("keyup",P)};N.click(H)}};var t=function(C){var D=h(".cp-toolbar");var F=D.find("#cp-file-control-annotate");var E=h(".annotationLayer");var B=h(".cp-active-annotation");if(s.isInMode("PRESENTATION")){F.hide();E.hide();B.hide()}else{m(C);F.show();E.show();B.show()}};s.on("fv.showFile",function(B){n=false;t(B)});s.on("fv.changeMode",function(){t(s.getCurrentFile())})};a.showAnnotationsPanel=function(n){var m=n.getView().fileSidebarView;if(!m.isPanelInitialized("annotations")){if(m.isAnyPanelInitialized()){m.teardownPanel()}m.initializePanel("annotations")}};return a});(function(){var b=require("FileViewer");var a=require("cp/component/annotation/annotation-plugin");b.registerPlugin("annotation",a)}());
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:upload-plugin', location = '/js/amd/plupload-amd.js' */
define("plupload",function(){return plupload});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:upload-plugin', location = '/js/service/upload-service.js' */
define("cp/service/upload-service",["ajs","jquery","plupload","cp/service/files-service"],function(i,e,g,a){var b="application/x-upload-data";var c=i.contextPath();var f=i.Meta.get("drag-and-drop-entity-id"),j=i.Meta.get("atl-token"),h=i.Meta.get("global-settings-attachment-max-size");function d(k){this.previewingAttachment=k;this.filesService=new a(k.get("ownerId"))}d.prototype.getMetaMaxSize=function(){return h};d.prototype.getUploadUrl=function(){return c+"/plugins/drag-and-drop/upload.action"};d.prototype.buildUploadParams=function(k){var l={},m=k.name.split(".").pop();l.pageId=this.previewingAttachment.get("ownerId");l.filename=this.previewingAttachment.get("title");l.size=k.size;if(f){l.dragAndDropEntityId=f}l.mimeType=g.mimeTypes[m.toLowerCase()]||b;l.atl_token=j;l.withEditorPlaceholder=false;return l};d.prototype.parseResponse=function(k){return e.parseJSON(k).data};d.prototype.handleError=function(m){var n="";if(m.response){try{var l=e.parseJSON(m.response);n=l.actionErrors[0]}catch(o){n=m.message}}else{n=m.message;if(m.code===g.FILE_SIZE_ERROR){var p=m.file.name;var k=i.DragAndDropUtils.niceSize(h).toString();n=i.format("{0} is too big to upload. Files must be less than {1}.",p,k)}else{if(m.code===g.FILE_EXTENSION_ERROR){n="You can only upload a file of the same type"}}}return n};d.prototype.promiseFileModel=function(l){var k=(this.previewingAttachment.getLatestVersion?this.previewingAttachment.getLatestVersion():this.previewingAttachment).get("id");return this.filesService.getFileWithId(k)};d.prototype.addVersionChangeComment=function(q,o,k,m){var p=o.get("id");var l=c+"/rest/api/content/"+o.get("ownerId")+"/child/attachment/"+p;var n={id:p,version:{number:o.get("version")+1},metadata:{comment:q}};e.ajax({url:l,type:"PUT",data:JSON.stringify(n),dataType:"json",contentType:"application/json; charset=utf-8"}).done(k).fail(function(r){m(JSON.parse(r.responseText).message)})};return d});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:upload-plugin', location = 'js/component/upload/upload-button-view.js' */
define("cp/component/upload/upload-button-view",["jquery","backbone","FileViewer","ajs","cp/component/upload/upload-utils"],function(f,g,e,b,a){var d=e.require("template-store-singleton");var c=g.View.extend({tagName:"span",events:{click:"_onClick"},initialize:function(i){this._fileViewer=i.fileViewer;var h=this._fileViewer.getView().fileControlsView;this.listenTo(h,"renderLayers",this._initUploader)},render:function(){var h=this._fileViewer.getCurrentFile();if(!h){return this}if(h.get("hasUploadAttachmentVersionPermission")){this.$el.html(d.get("controlUploadButton")());if(f.fn.tooltip){this.$("a").tooltip({gravity:"n"})}}else{this.stopListening().listenTo(h,"change:hasUploadAttachmentVersionPermission",this._onUploadNewVersionPermissionChanged)}return this},teardown:function(){this.stopListening();this._killExistingUploader()},_onClick:function(){b.trigger("analyticsEvent",{name:"confluence-spaces.previews.upload.click"})},_onUploadNewVersionPermissionChanged:function(h){if(h.get("hasUploadAttachmentVersionPermission")){this.render();this._initUploader()}},_initUploader:function(){var h=this._fileViewer.getCurrentFile();if(h&&h.get("hasUploadAttachmentVersionPermission")){this._killExistingUploader();this.uploader=a.createUploader(this._fileViewer,this.$("#cp-control-panel-upload")[0])}},_killExistingUploader:function(){if(this.uploader){this.uploader.off().destroy();this.uploader=null}}});return c});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:upload-plugin', location = 'js/component/upload/attachment-uploader.js' */
define("cp/component/upload/attachment-uploader",["jquery","plupload","ajs"],function(e,c,b){var a=function(){this._workIdToBytesUploaded={};this._totalBytes=0};a.prototype={update:function(h,g,f){if(!(h in this._workIdToBytesUploaded)){this._totalBytes+=f}this._workIdToBytesUploaded[h]=g},percentComplete:function(){var f=0;e.each(this._workIdToBytesUploaded,function(g,h){f+=h});return Math.round(f*100/this._totalBytes)}};var d=function(h,q,l,n){var i=Backbone.Model.extend({initialize:function(){e(window).on("resize.attachmentUploader",function(){if(p){p.refresh()}})},cancelUpload:function(){g&&p&&p.removeFile(g);g=null},destroy:function(){e(window).off("resize.attachmentUploader");if(p){p.destroy()}}});var g=null,j=null,m=new i();function k(){var s=new c.Uploader({runtimes:"html5",dragdrop:false,browse_button:h.id,multipart:false,stop_propagation:true,max_file_size:parseInt(n.getMetaMaxSize(),10),inputFileClazz:"file-preview-input-file",filters:l?f(l.get("title")):null,multi_selection:false,container:null});var r=new o();s.init();s.bind("Started",r.handleStarted);s.bind("FilesAdded",r.handleFilesAdded);s.bind("BeforeUpload",r.handleBeforeUpload);s.bind("UploadProgress",r.handleUploadProgress);s.bind("FileUploaded",r.handleFileUploaded);s.bind("Error",r.handleError);s.bind("UploadComplete",r.handleUploadComplete);return s}function f(r){var u=[];var t=(r.indexOf(".")!==-1)?r.split(".").pop():null;if(t){var v=c.mimeTypes[t.toLowerCase()];var s=(v)?c.mineTypeToExtensionsMap[v]:[t];u.push({title:"filter",extensions:s.join(",")})}return u}function o(){}o.prototype.handleStarted=function(){m.trigger("cp.uploader.uploadStarted")};o.prototype.handleFilesAdded=function(r,s){m.trigger("cp.uploader.filesAdded",s[0]);r.start()};o.prototype.handleBeforeUpload=function(r,t){j=new a();g=t;var s=n.getUploadUrl(),u=n.buildUploadParams(t);r.settings.url=c.buildUrl(s,u)};o.prototype.handleUploadProgress=function(r,s){j.update(s.id,s.loaded,s.size);var t=j.percentComplete()/100;m.trigger("cp.uploader.uploadProgress",t)};o.prototype.handleFileUploaded=function(s,t,r){if(s.getFile(t.id)){m.trigger("cp.uploader.fileUploaded",t,r)}};o.prototype.handleError=function(r,s){m.trigger("cp.uploader.error",n.handleError(s));g=null};o.prototype.handleUploadComplete=function(r,s){j=null;g=null};var p=k();return m};return d});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:upload-plugin', location = '/js/component/upload/upload-new-version-dialog-view.js' */
define("cp/component/upload/upload-new-version-dialog-view",["jquery","backbone","underscore","ajs","FileViewer"],function(c,g,h,f,b){var i=b.require("template-store-singleton");var d=b.require("file");var a=1;var e=g.View.extend({id:"upload-new-version-dialog",tagName:"section",className:"aui-layer aui-dialog2 aui-dialog2-small",events:{"click .close-button":"_closeDialog","click .cancel-button":"_cancelDialog"},initialize:function(j){this._fileViewer=j.fileViewer;this.uploader=j.uploader;if(this.uploader){this.listenTo(this.uploader,"cp.uploader.filesAdded",this._handleFileAdded);this.listenTo(this.uploader,"cp.uploader.uploadProgress",this._handleUploadProgress);this.listenTo(this.uploader,"cp.uploader.fileUploaded",this._handleFileUploaded);this.listenTo(this.uploader,"cp.uploader.error",this._handleError)}this.uploadService=j.uploadService;this.$el.attr({role:"dialog","aria-hidden":"true","data-aui-remove-on-hide":"true","data-aui-modal":"true"})},render:function(){this.$el.html(i.get("dialogUploadNewVersion")());this._updateElements();this.bodyInlineCSSOverflowValue=c("body")[0].style.overflow;this.dialog=f.dialog2(this.$el).show();this._fileViewer.getView().lockNavigationKeys();return this},isVisible:function(){return this.$el.is(":visible")},_updateElements:function(){this.$header=this.$(".aui-dialog2-header-main");this.$progressBar=this.$(".aui-progress-indicator");this.$cancelButton=this.$(".cancel-button");this.$closeButton=this.$(".close-button");this.$fileNameDiv=this.$(".file-name");this.$fileNameText=this.$(".file-name-text");this.$icon=this.$(".aui-icon");this.$msg=this.$("#upload-new-version-error-msg");this.$comment=this.$("#version-comment");this.$spinner=this.$(".spinner")},_toggleCancelButton:function(j){this.$cancelButton.toggleClass("hidden",!j);this.$closeButton.toggleClass("hidden",j)},_toggleEnableButton:function(k,j){k.attr("aria-disabled",!j);k.prop("disabled",!j)},_closeDialog:function(){var j=this.$comment.val();if(j){if(j.length<=255){this._toggleEnableButton(this.$closeButton,false);this.$spinner.spin();this.uploadService.addVersionChangeComment(this.$comment.val(),this._fileViewer.getCurrentFile(),h.bind(this._kill,this),h.bind(this._handleError,this));f.trigger("analyticsEvent",{name:"confluence-spaces.previews.upload.submit-comment"})}else{var k="The comment is longer than 255 characters.";this._handleLongCommentError(k)}}else{this._kill()}},_cancelDialog:function(){this.uploader.cancelUpload();this._kill();f.trigger("analyticsEvent",{name:"confluence-spaces.previews.upload.cancel"})},_kill:function(){if(this.uploader){this.stopListening(this.uploader)}this.dialog.hide();c("body")[0].style.overflow=this.bodyInlineCSSOverflowValue;this._fileViewer.getView().unlockNavigationKeys()},_handleFileAdded:function(k){this.$fileNameText.text(k.name);this._showIcon(k);f.progressBars&&f.progressBars.setIndeterminate(this.$progressBar);var j=this._fileViewer.getCurrentFile();var l=j?j.get("title"):"";f.trigger("analyticsEvent",{name:"confluence-spaces.previews.upload.start",data:{uploadSameName:l===k.name}})},_handleUploadProgress:function(j){if(!j){return}if(j===a){this._toggleEnableButton(this.$cancelButton,false)}f.progressBars&&f.progressBars.update(this.$progressBar,j)},_handleFileUploaded:function(k,j){this.uploadService.promiseFileModel(j).done(h.bind(function(l){this._toggleCancelButton(false);this.$header.text("Your upload is complete");this._fileViewer._fileState.replaceCurrent(new d(l));this._fileViewer.showFile(this._fileViewer._fileState.getCurrent());this._fileViewer._fileState.set("isNewFileUploaded",true)},this))},_handleError:function(j){this.$msg.empty();f.messages.warning("#upload-new-version-error-msg",{body:i.get("uploadErrorMessage")({message:j}),closeable:false});this.$msg.removeClass("hidden");this.$fileNameDiv.hide();this.$progressBar.hide();this.$comment.val("");this.$comment.hide();this._toggleCancelButton(false);this._toggleEnableButton(this.$closeButton,true);this.$spinner.spinStop();this.$header.text("Your upload has failed");f.trigger("analyticsEvent",{name:"confluence-spaces.previews.upload.failed"})},_handleLongCommentError:function(j){this.$msg.empty();f.messages.warning("#upload-new-version-error-msg",{body:i.get("uploadErrorMessage")({message:j}),closeable:true});this.$msg.removeClass("hidden")},_showIcon:function(k){var l=k.nativeFile&&k.nativeFile.type;var j=f.Confluence.FileTypesUtils.getAUIIconFromMime(l);this.$icon.addClass(j)}});return e});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:upload-plugin', location = 'js/component/upload/upload-utils.js' */
define("cp/component/upload/upload-utils",["underscore","backbone","cp/component/upload/upload-new-version-dialog-view","cp/component/upload/attachment-uploader","cp/service/upload-service"],function(b,f,d,c,a){var e=function(j,g){var i=new a(j.getCurrentFile());var h=new c(g,g,j.getCurrentFile(),i);h.on("cp.uploader.uploadStarted",function(){this.uploadNewVersionDialog=new d({uploader:h,uploadService:i,fileViewer:j});this.uploadNewVersionDialog.render()});return h};return{createUploader:e}});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:upload-plugin', location = '/templates/upload.soy' */
// This file was automatically generated from upload.soy.
// Please don't edit this file by hand.

/**
 * @fileoverview Templates in namespace FileViewer.Templates.
 */

if (typeof FileViewer == 'undefined') { var FileViewer = {}; }
if (typeof FileViewer.Templates == 'undefined') { FileViewer.Templates = {}; }


FileViewer.Templates.controlUploadButton = function(opt_data, opt_ignored) {
  return '<a id="cp-control-panel-upload" href="#" title="' + soy.$$escapeHtml("Upload a new version") + '" class="cp-icon"></a>';
};
if (goog.DEBUG) {
  FileViewer.Templates.controlUploadButton.soyTemplateName = 'FileViewer.Templates.controlUploadButton';
}


FileViewer.Templates.dialogUploadNewVersion = function(opt_data, opt_ignored) {
  return '<header class="aui-dialog2-header upload-new-version-dialog-header"><h1 class="aui-dialog2-header-main">' + soy.$$escapeHtml("Uploading a new version") + '</h1></header><!-- Main dialog content --><div class="aui-dialog2-content"><div class="file-name"><span class="aui-icon aui-icon-small">File</span><p class="file-name-text"></p></div><div class="aui-progress-indicator"><span class="aui-progress-indicator-value"></span></div><div id="upload-new-version-error-msg" class="hidden"></div><form action="#" class="aui"><textarea class="textarea" name="comment" id="version-comment" placeholder="' + soy.$$escapeHtml("What did you change?") + '"></textarea></form><div class="dialog-actions"><span class="spinner"></span><button class="aui-button close-button hidden">' + soy.$$escapeHtml("Done") + '</button><button class="aui-button cancel-button">' + soy.$$escapeHtml("Cancel") + '</button></div></div>';
};
if (goog.DEBUG) {
  FileViewer.Templates.dialogUploadNewVersion.soyTemplateName = 'FileViewer.Templates.dialogUploadNewVersion';
}


FileViewer.Templates.uploadErrorMessage = function(opt_data, opt_ignored) {
  return '<!-- upload error message --><p class="error-msg">' + soy.$$escapeHtml(opt_data.message) + '</p>';
};
if (goog.DEBUG) {
  FileViewer.Templates.uploadErrorMessage.soyTemplateName = 'FileViewer.Templates.uploadErrorMessage';
}

} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:upload-plugin', location = 'js/component/upload/upload-plugin.js' */
define("cp/component/upload/upload-plugin",["underscore","FileViewer","cp/component/upload/upload-button-view"],function(b,c,a){var d=function(h){var e=h.getView().fileControlsView;var g=function(){h._fileState.get("isNewFileUploaded")&&document.location.reload(true)};var f=function(){var i=h.getCurrentFile();return !$("#insert-image-dialog").is(":visible")&&!i.get("isRemoteLink")};h.close=b.wrap(h.close,function(i){i.apply(h,Array.prototype.slice.call(arguments,1));g()});e.addLayerView("uploadButton",a,{predicate:f,weight:40})};return d});(function(){var a=require("FileViewer");var b=require("cp/component/upload/upload-plugin");a.registerPlugin("upload",b)}());
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:version-navigation-plugin', location = 'templates/versions.soy' */
// This file was automatically generated from versions.soy.
// Please don't edit this file by hand.

/**
 * @fileoverview Templates in namespace FileViewer.Templates.Versions.
 */

if (typeof FileViewer == 'undefined') { var FileViewer = {}; }
if (typeof FileViewer.Templates == 'undefined') { FileViewer.Templates = {}; }
if (typeof FileViewer.Templates.Versions == 'undefined') { FileViewer.Templates.Versions = {}; }


FileViewer.Templates.Versions.versionTitle = function(opt_data, opt_ignored) {
  return '<span class="cp-title"><span class="' + soy.$$escapeHtml(opt_data.iconClass) + ' size-24 cp-file-icon"></span><span class="cp-file-title">' + soy.$$escapeHtml(opt_data.title) + '</span><span class="cp-version">v.' + soy.$$escapeHtml(opt_data.version) + ' ' + ((opt_data.isCurrent) ? '[' + soy.$$escapeHtml("Current") + ']' : '') + '</span></span>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Versions.versionTitle.soyTemplateName = 'FileViewer.Templates.Versions.versionTitle';
}


FileViewer.Templates.Versions.versionHistory = function(opt_data, opt_ignored) {
  var output = '<ul class="versionFiles">';
  var versionList18 = opt_data.versions;
  var versionListLen18 = versionList18.length;
  for (var versionIndex18 = 0; versionIndex18 < versionListLen18; versionIndex18++) {
    var versionData18 = versionList18[versionIndex18];
    output += '<li class="' + ((versionData18.version == opt_data.selectedVersion) ? 'current' : '') + '" data-cid="' + soy.$$escapeHtml(versionData18.id) + '">' + ((versionData18.version == opt_data.selectedVersion) ? '<span class="title">' + soy.$$escapeHtml("Version") + ' ' + soy.$$escapeHtml(versionData18.version) + '</span>' : '<a class="title" href="#">' + soy.$$escapeHtml("Version") + ' ' + soy.$$escapeHtml(versionData18.version) + '</a>') + ((versionData18.message) ? '<p class="description">' + soy.$$escapeHtml(versionData18.message) + '</p>' : '') + ((versionData18.countComments > 0) ? '<span class="comment-count" title="' + soy.$$escapeHtml("comments") + '"><span class="counter">' + ((versionData18.countComments > 9) ? '9+' : soy.$$escapeHtml(versionData18.countComments)) + '</span></span>' : '') + '</li>';
  }
  output += '</ul>';
  return output;
};
if (goog.DEBUG) {
  FileViewer.Templates.Versions.versionHistory.soyTemplateName = 'FileViewer.Templates.Versions.versionHistory';
}


FileViewer.Templates.Versions.versionNavigationDialog = function(opt_data, opt_ignored) {
  return '<section class="versions-container"><div class="spinner-wrap" /></section>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Versions.versionNavigationDialog.soyTemplateName = 'FileViewer.Templates.Versions.versionNavigationDialog';
}


FileViewer.Templates.Versions.viewCurrentVersion = function(opt_data, opt_ignored) {
  return '<a class=\'view-latest-version\' href=\'#\'>' + soy.$$escapeHtml("See the latest one") + '</a>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Versions.viewCurrentVersion.soyTemplateName = 'FileViewer.Templates.Versions.viewCurrentVersion';
}


FileViewer.Templates.Versions.reloadLatestVersion = function(opt_data, opt_ignored) {
  return '<a class=\'reload-latest-version\' href=\'#\'>' + soy.$$escapeHtml("Reload") + '</a>';
};
if (goog.DEBUG) {
  FileViewer.Templates.Versions.reloadLatestVersion.soyTemplateName = 'FileViewer.Templates.Versions.reloadLatestVersion';
}

} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:version-navigation-plugin', location = 'js/component/versions/version-file-enricher.js' */
define("cp/component/versions/version-file-enricher",["underscore","cp/component/versions/versions","cp/service/versions-service"],function(d,b,e){function c(g,f){if(g.getLatestVersion){return g}var h={getLatestVersion:function(){return this},isLatestVersion:function(){return true}};var i={getLatestVersion:function(){return f.getLatestVersion()},isLatestVersion:function(){return f.getLatestVersion()===this}};d.extend(g,f?i:h);g.set("versions",new b([],{versionsService:new e(),fileModel:g.getLatestVersion()}));return g}var a={enrich:c};return a});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:version-navigation-plugin', location = 'js/component/versions/file-version.js' */
define("cp/component/versions/file-version",["backbone","cp/component/versions/version-file-enricher"],function(c,a){var b=c.Model.extend({initialize:function(d,e){this.versionsService=e.versionsService;this.fileModel=e.fileModel},toJSON:function(){var d=c.Model.prototype.toJSON.apply(this,arguments);d.cid=this.cid;return d},getFileVersion:function(){if(+this.get("version")===+this.fileModel.get("version")){return $.Deferred().resolve(this.fileModel)}return this.versionsService.getFileVersion(this.fileModel.get("ownerId"),this.fileModel.get("id"),this.get("version")).pipe(function(d){var e=this.fileModel.clone();e.set(_.omit(d,"id"));return a.enrich(e,this)}.bind(this))},getLatestVersion:function(){return this.fileModel}});return b});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:version-navigation-plugin', location = 'js/component/versions/version-message-view.js' */
define("cp/component/versions/version-message-view",["backbone","ajs","FileViewer"],function(f,b,e){var d=e.require("template-store-singleton");var a=e.require("file");var c=f.View.extend({events:{"click a.view-latest-version":"_onViewLatest","click a.reload-latest-version":"_onReloadLatest","click span.icon-close":"_onCloseWarning"},initialize:function(g){this._fileViewer=g.fileViewer;this._filesService=this._fileViewer.getConfig().filesService;this.$el.attr("id","cp-version-message")},render:function(){var g=this._fileViewer.getCurrentFile();if(g.getLatestVersion().get("stale")){this.$el.html(b.messages.generic({title:"New file version uploaded.",body:d.get("Versions.reloadLatestVersion")(),closeable:false})).show()}else{if(!g.isLatestVersion()){this.$el.html(b.messages.generic({title:"This is an older version of this file.",body:d.get("Versions.viewCurrentVersion")(),closeable:true})).show()}}return this},teardown:function(){this.$el.hide()},_onViewLatest:function(){var g=this._fileViewer.getCurrentFile();this._fileViewer.showFile(g.getLatestVersion());b.trigger("analyticsEvent",{name:" confluence-spaces.previews.versions.warning-view-latest"})},_onReloadLatest:function(){var h=this._fileViewer.getCurrentFile();var g=new this._filesService(h.get("ownerId"));g.getFileWithId(h.getLatestVersion().get("id")).done(function(i){i=new a(i);this._fileViewer._fileState.replaceCurrent(i);this._fileViewer._fileState.set("isNewFileUploaded",true);this._fileViewer.showFile(i)}.bind(this));b.trigger("analyticsEvent",{name:" confluence-spaces.previews.versions.warning-reload-latest"})},_onCloseWarning:function(){b.trigger("analyticsEvent",{name:"confluence-spaces.previews.versions.close-warning"})}});return c});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:version-navigation-plugin', location = 'js/component/versions/version-navigation-dialog-view.js' */
define("cp/component/versions/version-navigation-dialog-view",["ajs","backbone","jquery","underscore","FileViewer","cp/component/versions/file-version","cp/component/versions/versions"],function(e,f,c,g,b,a,h){var i=b.require("template-store-singleton");var d=f.View.extend({dialogId:"cp-dialog-version",events:{"click .versionFiles li:not(.current)":"_onClickFileVersion"},initialize:function(j){if(j){this._fileViewer=j.fileViewer;this.$btnTrigger=j.$btnTrigger;this._file=j.fileViewer.getCurrentFile()}this.dialog=e.InlineDialog(this.$btnTrigger.find("span.cp-file-icon"),this.dialogId,function(l,k,m){l.append(this.$el.detach());this.render();m()}.bind(this),{hideDelay:null,offsetY:0,noBind:true,hideCallback:function(){this.$btnTrigger.removeClass("active")}.bind(this)});this._fileViewer.once("fv.close",this.teardown.bind(this));this.$btnTrigger.on("click.versionnav",function(){if(this.$el.is(":visible")){this.dialog.hide();e.trigger("analyticsEvent",{name:"confluence-spaces.previews.versions.click-title-to-close"})}else{this.dialog.show();this.$btnTrigger.addClass("active")}}.bind(this))},teardown:function(){this.$btnTrigger.off("click.versionnav");this.dialog.hide();c("#inline-dialog-cp-dialog-version").remove()},render:function(){this.$el.html(i.get("Versions.versionNavigationDialog")());this.$(".spinner-wrap").spin("medium",{top:0,left:0});var j=this._file.getLatestVersion();this._file.get("versions").fetchVersions(true).done(function(k){if(+k[0].version>+j.get("version")){this._file.getLatestVersion().set("stale",true);this._fileViewer.getView().fileContentView.getLayerForName("version-message").render();k=g.filter(k,function(l){return l.version<=j.get("version")})}this.$(".versions-container").html(i.get("Versions.versionHistory")({versions:new f.Collection(k).toJSON(),selectedVersion:this._fileViewer.getCurrentFile().get("version")}))}.bind(this)).fail(function(){this.$(".versions-container").html(e.messages.warning({title:"Can\'t show history",body:"We can\'t show the history right now. Give it another try later.",closeable:false}))}.bind(this));e.trigger("analyticsEvent",{name:"confluence-spaces.previews.versions.open",data:{fileType:this._file.get("type")}});return this},_onClickFileVersion:function(m){m.preventDefault();var j=this._file.get("versions").get(c(m.currentTarget).attr("data-cid"));j.getFileVersion().done(function(n){this._fileViewer.showFile(n)}.bind(this));var k=j.get("version");var l=this._file.getLatestVersion().get("version");this._triggerClickFileVersionAnalyticsEvent(k,l)},_triggerClickFileVersionAnalyticsEvent:function(k,m){var j="confluence-spaces.previews.versions.view-previous";var l=m-k;if(l>=4){j+="4-and-older"}else{if(l>0){j+=l}}if(l>0){e.trigger("analyticsEvent",{name:j})}}});return d});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:version-navigation-plugin', location = 'js/component/versions/version-title-view.js' */
define("cp/component/versions/version-title-view",["backbone","FileViewer","cp/component/versions/version-navigation-dialog-view"],function(f,e,b){var d=e.require("template-store-singleton");var c=e.require("icon-utils");var a=f.View.extend({initialize:function(g){this._fileViewer=g.fileViewer;this.options=g},render:function(){var g=this._fileViewer.getCurrentFile();if(!g){return this}if(g.get("version")&&g.get("id")){this.$el.html(d.get("Versions.versionTitle")({title:g.get("title"),version:g.get("version"),iconClass:c.getCssClass(g.get("type")),isCurrent:g.isLatestVersion()}));this.versionsNavigationDialog=new b({$btnTrigger:this.$(".cp-title"),fileViewer:this._fileViewer})}else{this.$el.html(d.get("titleContainer")({title:g.get("title"),iconClass:c.getCssClass(g.get("type"))}))}return this},teardown:function(){if(this.versionsNavigationDialog){this.versionsNavigationDialog.teardown();this.versionsNavigationDialog=undefined}}});return a});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:version-navigation-plugin', location = 'js/component/versions/versions.js' */
define("cp/component/versions/versions",["backbone"],function(b){var a=b.Collection.extend({model:function(d,c){var e=require("cp/component/versions/file-version");return new e(d,{versionsService:c.collection.service,fileModel:c.collection.latestVersion})},initialize:function(c,d){this.service=d.versionsService;this.latestVersion=d.fileModel},sync:function(e,d){if(!this.service){return}if(e==="read"){var c=this.service.getAllFileVersions(this.latestVersion.get("id"),this.latestVersion.get("ownerId"));c&&c.done(function(f){d.reset(f,{silent:true});d.trigger("sync",d)});return c}},fetchVersions:function(c){if(this.size()===0||c){return this.fetch()}else{return $.when()}}});return a});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:version-navigation-plugin', location = 'js/component/versions/versions-navigation-plugin.js' */
define("cp/component/versions/versions-navigation-plugin",["underscore","FileViewer","cp/component/versions/version-title-view","cp/component/versions/version-file-enricher","cp/component/versions/version-message-view","cp/component/versions/versions"],function(e,g,d,a,f,b){var c=function(i){if(!i.getConfig().enableVersionNavigation){return}var h=i.getView().fileTitleView;h.addPanelView("version-title",d);i.getView().on("fv.fileChange",a.enrich);i.getView().fileContentView.addLayerView("version-message",f)};c.showFileForPreviousVersion=function(k,i,h){var j=a.enrich(i);return j.get("versions").fetchVersions().pipe(function(){var l=i.get("versions").findWhere({version:+h});if(!l){return $.when(i)}return l.getFileVersion()}).pipe(function(l){return k.showFile(l)})};return c});(function(){try{if(AJS.DarkFeatures.isEnabled("previews.versions")){var c=require("FileViewer");var a=require("cp/component/versions/versions-navigation-plugin");c.registerPlugin("versionNavigation",a)}}catch(b){}}());
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:permalink-plugin', location = '/js/component/permalink/file-router.js' */
define("cp/component/permalink/file-router",["jquery","backbone","confluence/jsUri","cp/component/versions/versions-navigation-plugin","cp/service/files-service"],function(e,k,d,l,c){var g=window.encodeURIComponent;var a=window.decodeURIComponent;var j=AJS.DarkFeatures.isEnabled("previews.sharing.pushstate")&&history.pushState;var f=function(m){return m.path()+m.query()+(m.anchor()?"#"+m.anchor():"")};var i=function(r,s){if(!r){return b()}var w=r.get("ownerId");var q;if(r.isLatestVersion&&!r.isLatestVersion()){q=r.getLatestVersion().get("id")}else{q=r.get("id")}var v=r.get("version");var u=s&&s.get("id");var n=r.get("src");var o=r.get("name");var m;if(!s){m=w?(w+"/"+q):g(n)}else{m=w+"/"+q+"/"+v+"/"+u}var x=o?("/"+g(o)):"";if(j){var t="/"+m+x;var p=new d(window.location.href);p=p.replaceQueryParam("preview",t);return f(p)}else{return"#!/preview/"+m+x}};var b=function(){if(j){var m=new d(window.location.href).deleteQueryParam("preview");return f(m)}else{return""}};var h=k.Router.extend({routes:{"!/preview/:ownerId/:id(/:name)":"handleViewer","!/preview/:ownerId/:id/:version/:commentId(/:replyId)(/:name)":"handleLinkForPin","!/preview/*src":"handleWebLink","":"handleCloseViewer","*path":"handleUrl"},initialize:function(m){if(k.History.started){return}this._enabled=true;this._fileViewer=m.fileViewer;this.on("route:handleViewer",function(o,p){this.selectFileById(o,p)});this.on("route:handleLinkForPin",function(p,v,q,s,o){var u=this;var r=this._fileViewer.getCurrentFile();var t=function(w,x){var y=w.get("annotations");if(y){u._fileViewer._fileState.trigger("cp.showAnnotations");if(x){u.listenToOnce(y,x,function(){y.selectCommentWithId(s,o)})}else{y.selectCommentWithId(s,o)}}};if(this._fileViewer.isOpen()&&r&&r.get("ownerId")===p&&r.get("id")===v&&r.get("version")==q){t(r)}else{this.selectFileById(p,v,q).done(function(w){t(w,"sync")})}});this.on("route:handleWebLink",function(o){this.disableListeners();if(!this._fileViewer.isOpen()){this._fileViewer.open()}this._fileViewer.showFileWithSrc(o);this.enableListeners()});var n=function(){if(!j){return}var o=new d(window.location.href);if(o.getQueryParamValue("preview")){e(window).off("popstate",n);if(!this._fileViewer||!this._fileViewer.getCurrentFile()){k.history.loadUrl("!/preview"+a(o.getQueryParamValue("preview")))}}else{if(m.fileViewer.isOpen()){m.fileViewer.close()}e(window).off("popstate",n);e(window).on("popstate",n)}}.bind(this);this.on("route:handleUrl",n);this.on("route:handleCloseViewer",function(){this._fileViewer.close()});this.enableListeners()},start:function(){if(!k.History.started){k.history.start({pushState:j})}},setEnabled:function(m){this._enabled=m},selectFileById:function(m,p,n){this.disableListeners();if(!this._fileViewer.isOpen()){this._fileViewer.open()}function o(r){this._fileViewer._fileState.setCurrentWithCID(r.cid);var q;if(!n||n==r.get("version")){q=this._fileViewer.showFile(r)}else{q=l.showFileForPreviousVersion(this._fileViewer,r,n)}this.enableListeners();return q}return this._selectFileById(m,p,n).then(o.bind(this)).fail(function(){this._fileViewer._fileState.setNoCurrent()}.bind(this))},_selectFileById:function(n,s,o){var r=e.Deferred();var q=this.getCollection();var p=q.findWhere({id:s,ownerId:n});if(p){r.resolve(p)}else{var m=new c(n);m.getFilesWithId([s]).then(function(t){q.add(t);var u=q.findWhere({id:s,ownerId:n});if(u){r.resolve(u)}else{r.reject()}})}return r},getCollection:function(){return this._fileViewer._fileState.collection},enableListeners:function(){this.listenTo(this._fileViewer,"fv.changeFile fv.close",this._setRoute);this.listenTo(this._fileViewer.getView().fileSidebarView,"initializePanel",this._setRouteOnSidebarOpen);this.listenTo(this._fileViewer.getView().fileSidebarView,"teardownPanel",this._setRouteOnSidebarClose)},disableListeners:function(){this.stopListening(this._fileViewer,"fv.changeFile fv.close",this._setRoute);this.stopListening(this._fileViewer.getView().fileSidebarView,"initializePanel",this._setRouteOnSidebarOpen);this.stopListening(this._fileViewer.getView().fileSidebarView,"teardownPanel",this._setRouteOnSidebarClose)},_setRoute:function(p,m,o){if(this._enabled){var n=i(p,m);this.navigate(n,{trigger:!n||(j&&!new d(n).getQueryParamValue("preview")),replace:!!m||o||(p&&p.isLatestVersion&&!p.isLatestVersion())})}},_setRouteOnSidebarOpen:function(o){if("annotations"===o){var n=this._fileViewer.getCurrentFile();var m=n.get("annotations").getCurrent();m&&this._setRoute(n,m)}},_setRouteOnSidebarClose:function(m){if("annotations"===m){this._setRoute(this._fileViewer.getCurrentFile(),null,true)}}});return h});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:permalink-plugin', location = '/js/component/permalink/permalink-plugin.js' */
define("cp/component/permalink/permalink-plugin",["FileViewer","cp/component/permalink/file-router"],function(b,d){var a;var c=function(e){if(!e.getConfig().enablePermalinks){return}a=new d({fileViewer:e})};c.setRoutingEnabled=function(e){if(a){a.setEnabled(e)}};c.startRouting=function(){a.start()};c.setRouteForPin=function(f,e){if(a){a._setRoute(f,e)}};return c});(function(){var a=require("FileViewer");var b=require("cp/component/permalink/permalink-plugin");a.registerPlugin("permalink",b)}());
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:share-plugin', location = '/templates/share-button.soy' */
// This file was automatically generated from share-button.soy.
// Please don't edit this file by hand.

/**
 * @fileoverview Templates in namespace FileViewer.Templates.
 */

if (typeof FileViewer == 'undefined') { var FileViewer = {}; }
if (typeof FileViewer.Templates == 'undefined') { FileViewer.Templates = {}; }


FileViewer.Templates.controlShareButton = function(opt_data, opt_ignored) {
  return '<a id="cp-control-panel-share" href="#" title="' + soy.$$escapeHtml("Share") + '" class="cp-icon"></a>';
};
if (goog.DEBUG) {
  FileViewer.Templates.controlShareButton.soyTemplateName = 'FileViewer.Templates.controlShareButton';
}


FileViewer.Templates.sharePreviewPopup = function(opt_data, opt_ignored) {
  return '<form action="#" method="post" class="aui share-content-popup"><div class="field-group"><div class="autocomplete-user-target"><input class="text autocomplete-sharepage" id="users" data-max="10" data-dropdown-target=".autocomplete-user-target" data-none-message="' + soy.$$escapeHtml("No matches") + '" placeholder="' + soy.$$escapeHtml("User name, group or email") + '"/></div><ol class="recipients"></ol></div><div class="field-group"><textarea class="textarea" id="note" placeholder="' + soy.$$escapeHtml("Add an optional note") + '"/></div><div class="field-group button-panel"><div class="progress-messages-icon"></div><div class="progress-messages"></div><input class="button submit" type="submit" value="' + soy.$$escapeHtml("Share") + '" disabled/><a class="close-dialog" href="#">' + soy.$$escapeHtml("Cancel") + '</a></div></form>';
};
if (goog.DEBUG) {
  FileViewer.Templates.sharePreviewPopup.soyTemplateName = 'FileViewer.Templates.sharePreviewPopup';
}


FileViewer.Templates.recipientUser = function(opt_data, opt_ignored) {
  return '<li data-userkey="' + soy.$$escapeHtml(opt_data.userKey) + '" style="display: none" class="recipient-user"><img src="' + soy.$$escapeHtml(opt_data.thumbnailLink.href) + '" title="' + soy.$$escapeHtml(opt_data.title) + '"/><span class="title" title="' + soy.$$escapeHtml(opt_data.title) + '">' + soy.$$escapeHtml(opt_data.title) + '</span><span class="remove-recipient"/></li>';
};
if (goog.DEBUG) {
  FileViewer.Templates.recipientUser.soyTemplateName = 'FileViewer.Templates.recipientUser';
}


FileViewer.Templates.recipientEmail = function(opt_data, opt_ignored) {
  return '<li data-email="' + soy.$$escapeHtml(opt_data.email) + '" style="display: none" class="recipient-email"><img src="' + soy.$$escapeHtml(opt_data.icon) + '" title="' + soy.$$escapeHtml(opt_data.email) + '"/><span class="title" title="' + soy.$$escapeHtml(opt_data.email) + '">' + soy.$$escapeHtml(opt_data.email) + '</span><span class="remove-recipient"/></li>';
};
if (goog.DEBUG) {
  FileViewer.Templates.recipientEmail.soyTemplateName = 'FileViewer.Templates.recipientEmail';
}


FileViewer.Templates.recipientGroup = function(opt_data, opt_ignored) {
  return '<li data-group="' + soy.$$escapeHtml(opt_data.title) + '" style="display: none" class="recipient-group"><span><img src="' + soy.$$escapeHtml(opt_data.thumbnailLink.href) + '" title="' + soy.$$escapeHtml(opt_data.title) + '"/><span>' + soy.$$escapeHtml(opt_data.title) + '</span><span class="remove-recipient"/></span></li>';
};
if (goog.DEBUG) {
  FileViewer.Templates.recipientGroup.soyTemplateName = 'FileViewer.Templates.recipientGroup';
}

} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:share-plugin', location = '/js/component/share-button/share-button-plugin.js' */
define("cp/component/share-button/share-button-plugin",["jquery","ajs","backbone","FileViewer"],function(f,h,i,b){var j=b.require("template-store-singleton");var a={};a.autocompleteUser=function(n){n=n||document.body;var o=h.$,k=/^([a-zA-Z0-9_\.\-\+\!#\$%&'\*/=\?\^_`{|}~])+\@.*/;var m=function(s){if(!s||!s.result){throw new Error("Invalid JSON format")}var p=[];for(var q=0;q<s.result.length;q++){var r=s.result[q];if(r.type=="group"){r=l(r)}}p.push(s.result);return p};function l(p){if(p.name=="confluence-users"||p.name=="confluence-administrators"){return p}p.title=p.name;p.group=p.name;p.thumbnailLink={href:h.contextPath()+"/download/resources/com.atlassian.confluence.plugins.share-page:mail-page-resources/images/group.png",type:"image/png",rel:"thumbnail"};p.link=[{href:h.contextPath(),rel:"self"}];return p}o("input.autocomplete-sharepage[data-autocomplete-user-bound!=true]",n).each(function(){var r=o(this).attr("data-autocomplete-sharepage-bound","true").attr("autocomplete","off");var q=r.attr("data-max")||10,t=r.attr("data-alignment")||"left",s=r.attr("data-dropdown-target"),p=null;if(s){p=o(s)}else{p=o("<div></div>");r.after(p)}p.addClass("aui-dd-parent autocomplete");r.quicksearch(h.REST.getBaseUrl()+"search/user-or-group.json",function(){r.trigger("open.autocomplete-sharepage")},{makeParams:function(u){return{"max-results":q,query:u.replace("{|}","")}},dropdownPlacement:function(u){p.append(u)},makeRestMatrixFromData:m,addDropdownData:function(v){var u=o.trim(r.val());if(k.test(u)){v.push([{name:u,email:u,href:"#",icon:h.contextPath()+"/download/resources/com.atlassian.confluence.plugins.share-page:mail-page-resources/images/envelope.png"}])}if(!v.length){var w=r.attr("data-none-message");if(w){v.push([{name:w,className:"no-results",href:"#"}])}}return v},ajsDropDownOptions:{alignment:t,displayHandler:function(u){if(u.restObj&&u.restObj.username){return u.name+" ("+u.restObj.username+")"}return u.name},selectionHandler:function(w,v){if(v.find(".search-for").length){r.trigger("selected.autocomplete-sharepage",{searchFor:r.val()});return}if(v.find(".no-results").length){this.hide();w.preventDefault();return}var u=o("span:eq(0)",v).data("properties");if(!u.email){u=u.restObj}r.trigger("selected.autocomplete-sharepage",{content:u});this.hide();w.preventDefault()}}})})};var c={width:250,hideDelay:3600000,calculatePositions:function(l,s,A,w){var t;var C;var y;var p=-7;var q;var u;var B=s.target.offset();var k=s.target.outerWidth();var n=B.left+k/2;var x=(window.pageYOffset||document.documentElement.scrollTop)+f(window).height();var o=10;y=B.top+s.target.outerHeight()+w.offsetY;t=B.left+w.offsetX;var r=B.top>l.height();var m=(y+l.height())<x;u=(!m&&r)||(w.onTop&&r);var v=f(window).width()-(t+w.width+o);if(u){y=B.top-l.height()-8;var z=w.displayShadow?(h.$.browser.msie?10:9):0;p=l.height()-z}q=n-t+w.arrowOffsetX;if(w.isRelativeToMouse){if(v<0){C=o;t="auto";q=A.x-(f(window).width()-w.width)}else{t=A.x-20;C="auto";q=A.x-t}}else{if(v<0){C=o;t="auto";q=n-(f(window).width()-l.outerWidth())+o}else{if(w.width<=k/2){q=w.width/2;t=n-w.width/2}}}return{displayAbove:u,popupCss:{left:t,right:C,top:y},arrowCss:{position:"absolute",left:q,right:"auto",top:p}}}};var d=function(p,l,o){var n=function(){var s=a.identifier;var t=s+".inline-dialog-check";f("body").unbind("mousedown."+t)};var q=function(s){this._fileViewer.getView().unlockNavigationKeys();a.current.hide();n();if(s){setTimeout(function(){p.empty()},300)}return false}.bind(this);var m=function(){var s=a.identifier;var t=s+".inline-dialog-check";f("body").bind("mousedown."+t,function(v){var u=f(v.target);if(u.closest("#inline-dialog-"+s+" .contents").length===0){q()}})};if(p.find("input").length){o();m();return}p.append(j.get("sharePreviewPopup")());a.autocompleteUser();f(document).on("keydown.shareDialogEscape",function(s){if(s.keyCode==27){s.preventDefault();s.stopPropagation();f(document).off("keydown.shareDialogEscape");return false}return true});p.find(".close-dialog").click(function(s){s.preventDefault();q(true)});p.find("form").submit(function(x){x.preventDefault();var v=f(this).closest(".aui-inline-dialog");var z=[],y=[],s=[];v.find(".recipients li").each(function(C,D){var A=f(D).attr("data-userKey");var B=f(D).attr("data-email");var E=f(D).attr("data-group");if(A){z.push(A)}if(B){y.push(B)}if(E){s.push(E)}});if(z.length<=0&&y.length<=0&&s.length<=0){return false}f("button, input, textarea",this).attr("disabled","disabled");v.find(".progress-messages-icon").removeClass("error");v.find(".progress-messages").text("Sending");v.find(".progress-messages").attr("title","Sending");var u=new Spinner({length:3,width:1,radius:3,color:"#666",className:"cp-share-dialog-spinner"}).spin();v.find(".progress-messages-icon").append(u.el);v.find(".progress-messages-icon").css("position","absolute").css("left","0").css("margin-top","3px");v.find(".progress-messages").css("padding-left",20);var t=v.find("#note");var w={users:z,emails:y,groups:s,note:t.hasClass("placeholded")?"":t.val(),entityId:a.attachmentId,contextualPageId:h.Data.get("content-id"),entityType:"attachment"};f.ajax({type:"POST",contentType:"application/json; charset=utf-8",url:h.contextPath()+"/rest/share-page/latest/share",data:JSON.stringify(w),dataType:"text",success:function(){setTimeout(function(){u.stop();v.find(".progress-messages-icon").addClass("done");v.find(".progress-messages").text("Sent");v.find(".progress-messages").attr("title","Sent");setTimeout(function(){v.find(".progress-messages").text("");v.find(".progress-messages-icon").removeClass("done");v.find("#note").val("");v.find("#users").val("");v.find(".recipient-user").remove();v.find(".recipient-email").remove();v.find(".recipient-group").remove();f("button,input,textarea",v).removeAttr("disabled");q()},1000)},500)},error:function(B,A){u.stop();v.find(".progress-messages-icon").addClass("error");v.find(".progress-messages").text("Error sending");v.find(".progress-messages").attr("title","Error sending"+": "+A);f("button,input,textarea",v).removeAttr("disabled")}});return false});var r=p.find("#users");var k=p.find("input.submit");r.bind("selected.autocomplete-sharepage",function(v,u){var w=function(z,y,A){var C=p.find(".recipients"),B,x;B="li[data-"+z+'="'+A[z]+'"]';if(C.find(B).length>0){C.find(B).hide()}else{C.append(y)}x=C.find(B);x.find(".remove-recipient").click(function(){x.remove();if(C.find("li").length==0){k.attr("disabled","true")}a.current.refresh();r.focus();return false});x.fadeIn(200)};var t,s;if(u.content.email){t="email";s=j.get("recipientEmail")(u.content)}else{if(u.content.type=="group"){t="group";s=j.get("recipientGroup")(u.content)}else{t="userKey";s=j.get("recipientUser")(u.content)}}w(t,s,u.content);a.current.refresh();k.removeAttr("disabled");r.val("");return false});r.bind("open.autocomplete-sharepage",function(t,s){if(f("a:not(.no-results)",h.dropDown.current.links).length>0){h.dropDown.current.moveDown()}});r.keypress(function(s){return s.keyCode!=13});f(document).bind("showLayer",function(u,t,s){if(t==="inlineDialog"&&s.popup===a.current){s.popup.find("#users").focus()}});f(l).parents().filter(function(){return this.scrollTop>0}).scrollTop(0);o();m()};var e=i.View.extend({events:{click:"displayShareDialog"},tagName:"span",initialize:function(k){this._fileViewer=k.fileViewer},teardown:function(){if(a.current){a.current.remove();a.current=null}},render:function(){this.$el.html(j.get("controlShareButton")());if(f.fn.tooltip){this.$("a").tooltip({gravity:"n"})}return this},displayShareDialog:function(){var l=c||{};l.hideCallback=function(){this._fileViewer.getView().unlockNavigationKeys()}.bind(this);var k="#cp-control-panel-share";this._fileViewer.getView().lockNavigationKeys();a.identifier="sharePreviewPopup";a.attachmentId=this._fileViewer.getCurrentFile().get("id");a.current=h.InlineDialog(k,a.identifier,d.bind(this),l);a.current.show();return}});var g=function(k){if(!k.getConfig().enableShareButton){return}k.getView().fileControlsView.addLayerView("shareButton",e,{weight:2,predicate:function(l){return !l.getCurrentFile().get("isRemoteLink")}})};return g});(function(){var b=require("FileViewer");var a=require("cp/component/share-button/share-button-plugin");b.registerPlugin("sharebutton",a)}());
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:minimode-plugin', location = '/bower_components/atlassian-fileviewer/dist/fileviewer-minimode-templates.js' */
// This file was automatically generated from minimode.i18n.soy.
// Please don't edit this file by hand.

/**
 * @fileoverview Templates in namespace FileViewer.Templates.
 */

if (typeof FileViewer == 'undefined') { var FileViewer = {}; }
if (typeof FileViewer.Templates == 'undefined') { FileViewer.Templates = {}; }


FileViewer.Templates.minimodeBanner = function(opt_data, opt_ignored) {
  return '<div id="cp-info"><a href="#" id="cp-files-label" aria-label="' + soy.$$escapeHtml("Show all files") + '"><span class="cp-files-collapser up">' + soy.$$escapeHtml("Show all files") + '</span><span class="cp-files-collapser down hidden">' + soy.$$escapeHtml("Hide all files") + '</span>' + aui.icons.icon({useIconFont: true, size: 'small', icon: 'arrows-up', accessibilityText: "Show all files", extraClasses: 'cp-files-collapser up'}) + aui.icons.icon({useIconFont: true, size: 'small', icon: 'arrows-down', accessibilityText: "Hide all files", extraClasses: 'cp-files-collapser down hidden'}) + '</a></div>';
};
if (goog.DEBUG) {
  FileViewer.Templates.minimodeBanner.soyTemplateName = 'FileViewer.Templates.minimodeBanner';
}


FileViewer.Templates.minimode = function(opt_data, opt_ignored) {
  return '<ol id="cp-thumbnails"/>';
};
if (goog.DEBUG) {
  FileViewer.Templates.minimode.soyTemplateName = 'FileViewer.Templates.minimode';
}


FileViewer.Templates.thumbnail = function(opt_data, opt_ignored) {
  return '<figure role="group" class="cp-thumbnail-group"><div class="cp-thumbnail-img"><a href="#" class="cp-thumbnail-img-container size-48 ' + soy.$$escapeHtml(opt_data.iconClass) + ' has-thumbnail"><img src="' + soy.$$escapeHtml(opt_data.thumbnailSrc) + '" alt="' + soy.$$escapeHtml(AJS.format("View a larger version of {0}",opt_data.title)) + '" /></a></div><figcaption class="cp-thumbnail-title" aria-label="' + soy.$$escapeHtml(opt_data.title) + '">' + soy.$$escapeHtml(opt_data.title) + '</figcaption></figure>';
};
if (goog.DEBUG) {
  FileViewer.Templates.thumbnail.soyTemplateName = 'FileViewer.Templates.thumbnail';
}


FileViewer.Templates.placeholderThumbnail = function(opt_data, opt_ignored) {
  return '<figure role="group" class="cp-thumbnail-group"><div class="cp-thumbnail-img"><a href="#" class="cp-thumbnail-img-container size-48 ' + soy.$$escapeHtml(opt_data.iconClass) + '"></a></div><figcaption class="cp-thumbnail-title" aria-label="' + soy.$$escapeHtml(opt_data.title) + '">' + soy.$$escapeHtml(opt_data.title) + '</figcaption></figure>';
};
if (goog.DEBUG) {
  FileViewer.Templates.placeholderThumbnail.soyTemplateName = 'FileViewer.Templates.placeholderThumbnail';
}

} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:minimode-plugin', location = '/bower_components/atlassian-fileviewer/dist/fileviewer-minimode.js' */
(function (FileViewer) {
    'use strict';

    // use FileViewer's internal module system
    var define  = FileViewer.define;
    var require = FileViewer.require;

define("minimode/MinimodePanel",
    [
        "jquery",
        "ajs",
        "backbone",
        "minimode/ThumbnailView",
        "template-store-singleton"
    ],
    function(
        $,
        AJS,
        Backbone,
        FileThumbnailView,
        templateStore
    ) {
        "use strict";

        var FileMinimodeView = Backbone.View.extend({

            id: "cp-footer-minimode",

            initialize: function(options) {
                this.subviews = [];
                this._fileViewer = options.fileViewer;
                this._panelView = options.panelView;
                this.listenTo(this.collection, 'add reset', this.render);
                this.listenTo(this._panelView, 'renderPanel', this._forceChromeRepaint);
                this.listenTo(this._panelView, 'renderPanel', this.scrollToSelected);
                this.$minimode = $(templateStore.get('minimode')());
                this.$minimode.appendTo(this.$el);
            },

            closeOldSubviews: function() {
                while (this.subviews.length > 0) {
                    var view = this.subviews.pop();
                    view.remove();
                    view.unbind();
                }
            },

            render: function() {
                this.closeOldSubviews();

                this.collection.each(function(model) {
                    var view = new FileThumbnailView({
                        model: model,
                        fileViewer: this._fileViewer,
                        panelView: this._panelView
                    });
                    this.subviews.push(view);
                    $(view.render().el).appendTo(this.$minimode);
                }, this);

                return this;
            },

            scrollToSelected: function() {
                var file = this._fileViewer.getCurrentFile();
                this.subviews.forEach(function (view) {
                    if(view.model === file) {
                        var topPos = view.$el.get(0).offsetTop - 59;
                        if ((topPos) && this.$el.scrollTop !== topPos) {
                            this.$el.find("#cp-thumbnails").scrollTop(topPos);
                        }
                    }
                }.bind(this));
            },

            _forceChromeRepaint: function() {
                // Chrome doesn't respect the 100% height on images once the container is resized.
                var $img = $("#cp-img");
                if ($img.length) {
                    var $preview = $img.closest("#cp-image-preview"),
                        left = $preview.scrollLeft(),
                        top = $preview.scrollTop();
                    $img.css('display', 'none').height();
                    $img.css('display', 'inline-block');
                    $preview.scrollLeft(left);
                    $preview.scrollTop(top);
                }
            }

        });

        return FileMinimodeView;
    }
);
define('minimode/minimodePlugin', [
    'minimode/MinimodeToggle',
    'minimode/MinimodePanel'
], function (
    MinimodeToggle,
    MinimodePanel
) {
    'use strict';

    var minimodePlugin = function (fileViewer) {
        var fileView = fileViewer.getView();
        var sinkView = fileView.fileSinkView;
        var metaView = fileView.fileMetaView;

        if (!fileViewer.getConfig().enableMiniMode) {
            return;
        }

        metaView.addLayerView('minimodeToggle', MinimodeToggle, {
            predicate: MinimodeToggle.predicate
        });
        sinkView.addPanelView('minimode', MinimodePanel);
    };

    return minimodePlugin;
});
define('minimode/MinimodeToggle', [
    'backbone', 'template-store-singleton'
], function (Backbone, templateStore) {
    'use strict';

    var MinimodeToggle = Backbone.View.extend({

        events: {
            'click #cp-files-label': '_toggleMinimode'
        },

        initialize: function (options) {
            this._fileViewer = options.fileViewer;
            this._sinkView = this._fileViewer.getView().fileSinkView;
        },

        render: function () {
            this.$el.html(templateStore.get('minimodeBanner')());
            this._setShowAllFilesVisible();
            return this;
        },

        _toggleMinimode: function () {

            var analytics = this._fileViewer.analytics;

            if (this._sinkView.isPanelInitialized('minimode')) {
                this._sinkView.teardownPanel('minimode');
                analytics.send('files.fileviewer-web.minimode.closed');
            } else {
                this._sinkView.initializePanel('minimode');
                analytics.send('files.fileviewer-web.minimode.opened');
            }

            this._setShowAllFilesVisible();
        },

        _setShowAllFilesVisible: function () {
            var visible = this._sinkView.isPanelInitialized('minimode');
            this.$('.cp-files-collapser.up').toggleClass('hidden', visible);
            this.$('.cp-files-collapser.down').toggleClass('hidden', !visible);
        }

    }, {

        predicate: function (fileViewer) {
            return fileViewer._fileState.collection.length > 1;
        }

    });

    return MinimodeToggle;
});

define("minimode/ThumbnailView",
    [
        "ajs",
        "backbone",
        "jquery",
        "underscore",
        "file-types",
        "icon-utils",
        "template-store-singleton"
    ],
    function(
        AJS,
        Backbone,
        $,
        _,
        fileTypes,
        iconUtils,
        templateStore
    ) {
        "use strict";

        var ThumbnailView = Backbone.View.extend({

            className: "cp-thumbnail",

            tagName: "li",

            events: {
                "click" : "jumpToFile"
            },

            initialize: function(options) {
                this._fileViewer = options.fileViewer;
                this.listenTo(this.model, 'change', this.render);
                this.listenTo(options.panelView, 'renderPanel', this.setSelected);
            },

            jumpToFile: function() {
                this._fileViewer.showFileWithCID(this.model.cid).always(
                    this._fileViewer.analytics.fn('files.fileviewer-web.minimode.thumbnail.clicked')
                );
            },

            setSelected: function() {
                // this may not be the same as file being shown, e.g., a different version of file is shown
                var file = this._fileViewer._fileState.getCurrent();
                if (file === this.model) {
                    this.$el.addClass("selected");
                } else if (this.$el.hasClass("selected")) {
                    this.$el.removeClass("selected");
                }
            },

            onThumbLoadError: function (ev) {
                var el = $(ev.target);
                el.parent().removeClass('has-thumbnail');
                el.remove();
            },

            render: function() {
                var type = this.model.get("type"),
                    thumbnailSrc = this.model.get("thumbnail"),
                    isImage = fileTypes.isImage(type);

                var generateThumbnail = this._fileViewer.getConfig().generateThumbnail;

                var $thumbnail = $(templateStore.get('placeholderThumbnail')({
                    iconClass: iconUtils.getCssClass(type),
                    title: this.model.get("title")
                }));

                this.$el.empty().append($thumbnail);

                if (thumbnailSrc && generateThumbnail) {
                    generateThumbnail(this.model).done(function (thumbSrc) {
                        $thumbnail.replaceWith(templateStore.get('thumbnail')({
                            iconClass: iconUtils.getCssClass(type),
                            thumbnailSrc: thumbSrc,
                            title: this.model.get("title")
                        }));
                        this.$el.find('img').error(this.onThumbLoadError);
                    }.bind(this));
                } else if (isImage || thumbnailSrc) {
                    $thumbnail.replaceWith(templateStore.get('thumbnail')({
                        iconClass: iconUtils.getCssClass(type),
                        thumbnailSrc: thumbnailSrc || this.model.get("src"),
                        title: this.model.get("title")
                    }));
                    this.$el.find('img').error(this.onThumbLoadError);
                }

                return this;
            }

        });

        return ThumbnailView;
    });

(function() {
    'use strict';
    var FileViewer = require("file-viewer");
    var minimodePlugin = require("minimode/minimodePlugin");
    FileViewer.registerPlugin('minimode', minimodePlugin);
}());
}(function () {
  var FileViewer;

    if (typeof module !== "undefined" && ('exports' in module)) {
      FileViewer = require('./fileviewer.js');
    } else if (window.require) {
      FileViewer = window.FileViewer;
    } else {
      FileViewer = window.FileViewer;
    }

    return FileViewer;
}()));

} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:feature-discovery-plugin', location = 'js/component/feature-discovery/discovery-dialog.js' */
define("cp/component/feature-discovery/discovery-dialog",["jquery","underscore","FileViewer","aui/inline-dialog2"],function(f,b,d){var c=d.require("template-store-singleton");var e=function(h,g){return function(){h.trigger(g,arguments)}};var a=function(g){this.$anchor=f(g.anchor);this.$appendTo=f(g.appendTo);this.key=g.key;this.text=g.text;this.dialog=null;this.$anchor.attr({"aria-controls":"cp-feature-discovery","data-aui-trigger":true});var i=f(c.get("FeatureDiscovery.featureDiscovery")({text:this.text}));i.find(".cp-feature-discovery-confirm").click(function(j){this.dismiss(true);j.preventDefault()}.bind(this));var h=i[0];this.$appendTo.append(h);skate.init(h);h.show();this.dialog=h;b.extend(this,Backbone.Events);this.dialog.addEventListener("aui-layer-hide",e(this,"hide"));this.dialog.addEventListener("aui-layer-show",e(this,"show"));return this};a.prototype.is=function(g){return this.key===g};a.prototype.on=function(h,i){var g=h;if(h==="hide"){g="aui-layer-hide"}else{if(h==="show"){g="aui-layer-show"}}this.dialog.addEventListener(g,i)};a.prototype.dismiss=function(g){this.dialog.hide();this.dialog.remove();g&&this.trigger("user-dismissed-dialog",this.key)};return a});
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:feature-discovery-plugin', location = '/templates/feature-discovery.soy' */
// This file was automatically generated from feature-discovery.soy.
// Please don't edit this file by hand.

/**
 * @fileoverview Templates in namespace FileViewer.Templates.FeatureDiscovery.
 */

if (typeof FileViewer == 'undefined') { var FileViewer = {}; }
if (typeof FileViewer.Templates == 'undefined') { FileViewer.Templates = {}; }
if (typeof FileViewer.Templates.FeatureDiscovery == 'undefined') { FileViewer.Templates.FeatureDiscovery = {}; }


FileViewer.Templates.FeatureDiscovery.featureDiscovery = function(opt_data, opt_ignored) {
  return '<aui-inline-dialog2 id="cp-feature-discovery" class="aui-layer aui-inline-dialog" data-aui-alignment="bottom center" data-aui-responds-to="toggle" data-aui-persistent="true" data-aui-focus="false"><div class="aui-inline-dialog-contents"><p>' + soy.$$escapeHtml(opt_data.text) + '</p><button class="aui-button aui-button-link cp-feature-discovery-confirm">' + soy.$$escapeHtml("Dismiss") + '</button></div></aui-inline-dialog2>';
};
if (goog.DEBUG) {
  FileViewer.Templates.FeatureDiscovery.featureDiscovery.soyTemplateName = 'FileViewer.Templates.FeatureDiscovery.featureDiscovery';
}

} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
;try {
/* module-key = 'com.atlassian.confluence.plugins.confluence-previews:feature-discovery-plugin', location = 'js/component/feature-discovery/feature-discovery-plugin.js' */
define("cp/component/feature-discovery/feature-discovery-plugin",["cp/component/feature-discovery/discovery-dialog","underscore","ajs","confluence/legacy"],function(e,h,f,g){var d=null;var c=g.FeatureDiscovery.forPlugin("com.atlassian.confluence.plugins.confluence-previews");var a=function(j){if(d===null){return}if(!j.key||j.key&&d.is(j.key)){d.dismiss(j.persist)}};var b=function(k){var j=k.key;var l=$(k.anchor);if(l.length===0||!l.is(":visible")||l.closest("body").length===0||!c.shouldShow(j)){return}c.addDiscoveryView(k.key);a({persist:false});d=new e(k);d.on("user-dismissed-dialog",function(m){c.markDiscovered(m)});return d};var i=function(o){var m=f.Meta.get("remote-user");var k="view-annotations";var n="add-annotations";var l=[k,n];var j=m&&h(l).without(c.listDiscovered()).length!==0;if(!j){return}o.on("fv.showFile",function(t){a({persist:false});var v=t.get("annotations");var s=o.supports(t.get("type"));var u=t.get("isRemoteLink");if(!v||!s||u){return}var r=o.getView().fileSidebarView;var q=o.getView().fileControlsView;var p=q.getLayerForName("annotationButton");var w=o.getView().fileContentView.getLayerForName("content")._viewer;v.on("sync",function(){var x=v.getCount();var y=r.isPanelInitialized("annotations");if(x&&!y){b({key:k,anchor:p.$("a"),text:"Ooh, comments!  See what people are saying about this file.",appendTo:o.getView().$el})}else{var A=w.$("#cp-file-control-annotate");w.showControls();var z=b({key:n,anchor:A,text:"This little pin wants to help you collaborate. Drag it anywhere to add a comment.",appendTo:o.getView().$el});if(z){w.autoToggleControls(false);w.showControls();A.mousedown(function(){a({key:n,persist:true})});z.on("hide",function(){w.autoToggleControls(true)})}}})});o.on("fv.changeFile fv.close",function(){a({persist:false})});o.getView().fileSidebarView.on("togglePanel",function(q,p){if(q!=="annotations"||p===false){return}a({key:"view-annotations",persist:true});a({persist:false})});o.getView().fileSinkView.on("togglePanel",function(){a({persist:false})})};return i});(function(){var b=require("FileViewer");var a=require("cp/component/feature-discovery/feature-discovery-plugin");b.registerPlugin("featureDiscovery",a)}());
} catch (err) {
    if (console && console.log && console.error) {
        console.log("Error running batched script.");
        console.error(err);
    }
}

;
