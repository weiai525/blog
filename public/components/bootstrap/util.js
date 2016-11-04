define("components/bootstrap/util",function(n,t,e){var i=n("components/jquery/jquery");!function(n,i){if("function"==typeof define&&define.amd)define(["exports","module"],i);else if("undefined"!=typeof t&&"undefined"!=typeof e)i(t,e);else{var r={exports:{}};i(r.exports,r),n.util=r.exports}}(this,function(n,t){"use strict";var e=function(n){function t(n){return{}.toString.call(n).match(/\s([a-zA-Z]+)/)[1].toLowerCase()}function e(n){return(n[0]||n).nodeType}function i(){return{bindType:u.end,delegateType:u.end,handle:function(t){return n(t.target).is(this)?t.handleObj.handler.apply(this,arguments):void 0}}}function r(){if(window.QUnit)return!1;var n=document.createElement("bootstrap");for(var t in a)if(void 0!==n.style[t])return{end:a[t]};return!1}function o(t){var e=this,i=!1;return n(this).one(d.TRANSITION_END,function(){i=!0}),setTimeout(function(){i||d.triggerTransitionEnd(e)},t),this}function s(){u=r(),n.fn.emulateTransitionEnd=o,d.supportsTransitionEnd()&&(n.event.special[d.TRANSITION_END]=i())}var u=!1,a={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"},d={TRANSITION_END:"bsTransitionEnd",getUID:function(n){do n+=~~(1e6*Math.random());while(document.getElementById(n));return n},getSelectorFromElement:function(n){var t=n.getAttribute("data-target");return t||(t=n.getAttribute("href")||"",t=/^#[a-z]/i.test(t)?t:null),t},reflow:function(n){new Function("bs","return bs")(n.offsetHeight)},triggerTransitionEnd:function(t){n(t).trigger(u.end)},supportsTransitionEnd:function(){return Boolean(u)},typeCheckConfig:function(n,i,r){for(var o in r)if(r.hasOwnProperty(o)){var s=r[o],u=i[o],a=void 0;if(a=u&&e(u)?"element":t(u),!new RegExp(s).test(a))throw new Error(n.toUpperCase()+": "+('Option "'+o+'" provided type "'+a+'" ')+('but expected type "'+s+'".'))}}};return s(),d}(i);t.exports=e})});