/*Ajax Form*/
(function(c) { if (typeof define === 'function' && define.amd) { define(['jquery'], c) } else if (typeof module === 'object' && module.exports) { module.exports = function(a, b) { if (typeof b === 'undefined') { if (typeof window !== 'undefined') { b = require('jquery') } else { b = require('jquery')(a) } }
            c(b); return b } } else { c(jQuery) } }(function($) { 'use strict'; var V = /\r?\n/g; var W = {};
    W.fileapi = $('<input type="file">').get(0).files !== undefined;
    W.formdata = (typeof window.FormData !== 'undefined'); var X = !!$.fn.prop;
    $.fn.attr2 = function() { if (!X) { return this.attr.apply(this, arguments) } var a = this.prop.apply(this, arguments); if ((a && a.jquery) || typeof a === 'string') { return a } return this.attr.apply(this, arguments) };
    $.fn.ajaxSubmit = function(A, B, C, D) { if (!this.length) { log('ajaxSubmit: skipping submit process - no element selected'); return this } var E, action, url, $form = this; if (typeof A === 'function') { A = { success: A } } else if (typeof A === 'string' || (A === false && arguments.length > 0)) { A = { 'url': A, 'data': B, 'dataType': C }; if (typeof D === 'function') { A.success = D } } else if (typeof A === 'undefined') { A = {} }
        E = A.method || A.type || this.attr2('method');
        action = A.url || this.attr2('action');
        url = (typeof action === 'string') ? $.trim(action) : '';
        url = url || window.location.href || ''; if (url) { url = (url.match(/^([^#]+)/) || [])[1] }
        A = $.extend(true, { url: url, success: $.ajaxSettings.success, type: E || $.ajaxSettings.type, iframeSrc: /^https/i.test(window.location.href || '') ? 'javascript:false' : 'about:blank' }, A); var F = {};
        this.trigger('form-pre-serialize', [this, A, F]); if (F.veto) { log('ajaxSubmit: submit vetoed via form-pre-serialize trigger'); return this } if (A.beforeSerialize && A.beforeSerialize(this, A) === false) { log('ajaxSubmit: submit aborted via beforeSerialize callback'); return this } var G = A.traditional; if (typeof G === 'undefined') { G = $.ajaxSettings.traditional } var H = []; var I, a = this.formToArray(A.semantic, H, A.filtering); if (A.data) { var J = $.isFunction(A.data) ? A.data(a) : A.data;
            A.extraData = J;
            I = $.param(J, G) } if (A.beforeSubmit && A.beforeSubmit(a, this, A) === false) { log('ajaxSubmit: submit aborted via beforeSubmit callback'); return this }
        this.trigger('form-submit-validate', [a, this, A, F]); if (F.veto) { log('ajaxSubmit: submit vetoed via form-submit-validate trigger'); return this } var q = $.param(a, G); if (I) { q = (q ? (q + '&' + I) : I) } if (A.type.toUpperCase() === 'GET') { A.url += (A.url.indexOf('?') >= 0 ? '&' : '?') + q;
            A.data = null } else { A.data = q } var K = []; if (A.resetForm) { K.push(function() { $form.resetForm() }) } if (A.clearForm) { K.push(function() { $form.clearForm(A.includeHidden) }) } if (!A.dataType && A.target) { var L = A.success || function() {};
            K.push(function(a, b, c) { var d = arguments,
                    fn = A.replaceTarget ? 'replaceWith' : 'html';
                $(A.target)[fn](a).each(function() { L.apply(this, d) }) }) } else if (A.success) { if ($.isArray(A.success)) { $.merge(K, A.success) } else { K.push(A.success) } }
        A.success = function(a, b, c) { var d = A.context || this; for (var i = 0, max = K.length; i < max; i++) { K[i].apply(d, [a, b, c || $form, $form]) } }; if (A.error) { var M = A.error;
            A.error = function(a, b, c) { var d = A.context || this;
                M.apply(d, [a, b, c, $form]) } } if (A.complete) { var N = A.complete;
            A.complete = function(a, b) { var c = A.context || this;
                N.apply(c, [a, b, $form]) } } var O = $('input[type=file]:enabled', this).filter(function() { return $(this).val() !== '' }); var P = O.length > 0; var Q = 'multipart/form-data'; var R = ($form.attr('enctype') === Q || $form.attr('encoding') === Q); var S = W.fileapi && W.formdata;
        log('fileAPI :' + S); var T = (P || R) && !S; var U; if (A.iframe !== false && (A.iframe || T)) { if (A.closeKeepAlive) { $.get(A.closeKeepAlive, function() { U = fileUploadIframe(a) }) } else { U = fileUploadIframe(a) } } else if ((P || R) && S) { U = fileUploadXhr(a) } else { U = $.ajax(A) }
        $form.removeData('jqxhr').data('jqxhr', U); for (var k = 0; k < H.length; k++) { H[k] = null }
        this.trigger('form-submit-notify', [this, A]); return this;

        function deepSerialize(a) { var b = $.param(a, A.traditional).split('&'); var c = b.length; var d = []; var i, part; for (i = 0; i < c; i++) { b[i] = b[i].replace(/\+/g, ' ');
                part = b[i].split('=');
                d.push([decodeURIComponent(part[0]), decodeURIComponent(part[1])]) } return d }

        function fileUploadXhr(a) { var f = new FormData(); for (var i = 0; i < a.length; i++) { f.append(a[i].name, a[i].value) } if (A.extraData) { var g = deepSerialize(A.extraData); for (i = 0; i < g.length; i++) { if (g[i]) { f.append(g[i][0], g[i][1]) } } }
            A.data = null; var s = $.extend(true, {}, $.ajaxSettings, A, { contentType: false, processData: false, cache: false, type: E || 'POST' }); if (A.uploadProgress) { s.xhr = function() { var e = $.ajaxSettings.xhr(); if (e.upload) { e.upload.addEventListener('progress', function(a) { var b = 0; var c = a.loaded || a.position; var d = a.total; if (a.lengthComputable) { b = Math.ceil(c / d * 100) }
                            A.uploadProgress(a, c, d, b) }, false) } return e } }
            s.data = null; var h = s.beforeSend;
            s.beforeSend = function(a, o) { if (A.formData) { o.data = A.formData } else { o.data = f } if (h) { h.call(this, a, o) } }; return $.ajax(s) }

        function fileUploadIframe(a) { var l = $form[0],
                el, i, s, g, id, $io, io, xhr, sub, n, timedOut, timeoutHandle; var m = $.Deferred();
            m.abort = function(a) { xhr.abort(a) }; if (a) { for (i = 0; i < H.length; i++) { el = $(H[i]); if (X) { el.prop('disabled', false) } else { el.removeAttr('disabled') } } }
            s = $.extend(true, {}, $.ajaxSettings, A);
            s.context = s.context || s;
            id = 'jqFormIO' + new Date().getTime(); var o = l.ownerDocument; var p = $form.closest('body'); if (s.iframeTarget) { $io = $(s.iframeTarget, o);
                n = $io.attr2('name'); if (!n) { $io.attr2('name', id) } else { id = n } } else { $io = $('<iframe name="' + id + '" src="' + s.iframeSrc + '" />', o);
                $io.css({ position: 'absolute', top: '-1000px', left: '-1000px' }) }
            io = $io[0];
            xhr = { aborted: 0, responseText: null, responseXML: null, status: 0, statusText: 'n/a', getAllResponseHeaders: function() {}, getResponseHeader: function() {}, setRequestHeader: function() {}, abort: function(a) { var e = (a === 'timeout' ? 'timeout' : 'aborted');
                    log('aborting upload... ' + e);
                    this.aborted = 1; try { if (io.contentWindow.document.execCommand) { io.contentWindow.document.execCommand('Stop') } } catch (ignore) {}
                    $io.attr('src', s.iframeSrc);
                    xhr.error = e; if (s.error) { s.error.call(s.context, xhr, e, a) } if (g) { $.event.trigger('ajaxError', [xhr, s, e]) } if (s.complete) { s.complete.call(s.context, xhr, e) } } };
            g = s.global; if (g && $.active++ === 0) { $.event.trigger('ajaxStart') } if (g) { $.event.trigger('ajaxSend', [xhr, s]) } if (s.beforeSend && s.beforeSend.call(s.context, xhr, s) === false) { if (s.global) { $.active-- }
                m.reject(); return m } if (xhr.aborted) { m.reject(); return m }
            sub = l.clk; if (sub) { n = sub.name; if (n && !sub.disabled) { s.extraData = s.extraData || {};
                    s.extraData[n] = sub.value; if (sub.type === 'image') { s.extraData[n + '.x'] = l.clk_x;
                        s.extraData[n + '.y'] = l.clk_y } } } var q = 1; var r = 2;

            function getDoc(a) { var b = null; try { if (a.contentWindow) { b = a.contentWindow.document } } catch (err) { log('cannot get iframe.contentWindow document: ' + err) } if (b) { return b } try { b = a.contentDocument ? a.contentDocument : a.document } catch (err) { log('cannot get iframe.contentDocument: ' + err);
                    b = a.document } return b } var u = $('meta[name=csrf-token]').attr('content'); var v = $('meta[name=csrf-param]').attr('content'); if (v && u) { s.extraData = s.extraData || {};
                s.extraData[v] = u }

            function doSubmit() { var t = $form.attr2('target'),
                    a = $form.attr2('action'),
                    Q = 'multipart/form-data',
                    et = $form.attr('enctype') || $form.attr('encoding') || Q;
                l.setAttribute('target', id); if (!E || /post/i.test(E)) { l.setAttribute('method', 'POST') } if (a !== s.url) { l.setAttribute('action', s.url) } if (!s.skipEncodingOverride && (!E || /post/i.test(E))) { $form.attr({ encoding: 'multipart/form-data', enctype: 'multipart/form-data' }) } if (s.timeout) { timeoutHandle = setTimeout(function() { timedOut = true;
                        cb(q) }, s.timeout) }

                function checkState() { try { var a = getDoc(io).readyState;
                        log('state = ' + a); if (a && a.toLowerCase() === 'uninitialized') { setTimeout(checkState, 50) } } catch (e) { log('Server abort: ', e, ' (', e.name, ')');
                        cb(r); if (timeoutHandle) { clearTimeout(timeoutHandle) }
                        timeoutHandle = undefined } } var b = []; try { if (s.extraData) { for (var n in s.extraData) { if (s.extraData.hasOwnProperty(n)) { if ($.isPlainObject(s.extraData[n]) && s.extraData[n].hasOwnProperty('name') && s.extraData[n].hasOwnProperty('value')) { b.push($('<input type="hidden" name="' + s.extraData[n].name + '">', o).val(s.extraData[n].value).appendTo(l)[0]) } else { b.push($('<input type="hidden" name="' + n + '">', o).val(s.extraData[n]).appendTo(l)[0]) } } } } if (!s.iframeTarget) { $io.appendTo(p) } if (io.attachEvent) { io.attachEvent('onload', cb) } else { io.addEventListener('load', cb, false) }
                    setTimeout(checkState, 15); try { l.submit() } catch (err) { var c = document.createElement('form').submit;
                        c.apply(l) } } finally { l.setAttribute('action', a);
                    l.setAttribute('enctype', et); if (t) { l.setAttribute('target', t) } else { $form.removeAttr('target') }
                    $(b).remove() } } if (s.forceSync) { doSubmit() } else { setTimeout(doSubmit, 10) } var w, doc, domCheckCount = 50,
                callbackProcessed;

            function cb(e) { if (xhr.aborted || callbackProcessed) { return }
                doc = getDoc(io); if (!doc) { log('cannot access response document');
                    e = r } if (e === q && xhr) { xhr.abort('timeout');
                    m.reject(xhr, 'timeout'); return } if (e === r && xhr) { xhr.abort('server abort');
                    m.reject(xhr, 'error', 'server abort'); return } if (!doc || doc.location.href === s.iframeSrc) { if (!timedOut) { return } } if (io.detachEvent) { io.detachEvent('onload', cb) } else { io.removeEventListener('load', cb, false) } var c = 'success',
                    errMsg; try { if (timedOut) { throw 'timeout'; } var d = s.dataType === 'xml' || doc.XMLDocument || $.isXMLDoc(doc);
                    log('isXml=' + d); if (!d && window.opera && (doc.body === null || !doc.body.innerHTML)) { if (--domCheckCount) { log('requeing onLoad callback, DOM not available');
                            setTimeout(cb, 250); return } } var f = doc.body ? doc.body : doc.documentElement;
                    xhr.responseText = f ? f.innerHTML : null;
                    xhr.responseXML = doc.XMLDocument ? doc.XMLDocument : doc; if (d) { s.dataType = 'xml' }
                    xhr.getResponseHeader = function(a) { var b = { 'content-type': s.dataType }; return b[a.toLowerCase()] }; if (f) { xhr.status = Number(f.getAttribute('status')) || xhr.status;
                        xhr.statusText = f.getAttribute('statusText') || xhr.statusText } var h = (s.dataType || '').toLowerCase(); var i = /(json|script|text)/.test(h); if (i || s.textarea) { var j = doc.getElementsByTagName('textarea')[0]; if (j) { xhr.responseText = j.value;
                            xhr.status = Number(j.getAttribute('status')) || xhr.status;
                            xhr.statusText = j.getAttribute('statusText') || xhr.statusText } else if (i) { var k = doc.getElementsByTagName('pre')[0]; var b = doc.getElementsByTagName('body')[0]; if (k) { xhr.responseText = k.textContent ? k.textContent : k.innerText } else if (b) { xhr.responseText = b.textContent ? b.textContent : b.innerText } } } else if (h === 'xml' && !xhr.responseXML && xhr.responseText) { xhr.responseXML = x(xhr.responseText) } try { w = z(xhr, h, s) } catch (err) { c = 'parsererror';
                        xhr.error = errMsg = (err || c) } } catch (err) { log('error caught: ', err);
                    c = 'error';
                    xhr.error = errMsg = (err || c) } if (xhr.aborted) { log('upload aborted');
                    c = null } if (xhr.status) { c = ((xhr.status >= 200 && xhr.status < 300) || xhr.status === 304) ? 'success' : 'error' } if (c === 'success') { if (s.success) { s.success.call(s.context, w, 'success', xhr) }
                    m.resolve(xhr.responseText, 'success', xhr); if (g) { $.event.trigger('ajaxSuccess', [xhr, s]) } } else if (c) { if (typeof errMsg === 'undefined') { errMsg = xhr.statusText } if (s.error) { s.error.call(s.context, xhr, c, errMsg) }
                    m.reject(xhr, 'error', errMsg); if (g) { $.event.trigger('ajaxError', [xhr, s, errMsg]) } } if (g) { $.event.trigger('ajaxComplete', [xhr, s]) } if (g && !--$.active) { $.event.trigger('ajaxStop') } if (s.complete) { s.complete.call(s.context, xhr, c) }
                callbackProcessed = true; if (s.timeout) { clearTimeout(timeoutHandle) }
                setTimeout(function() { if (!s.iframeTarget) { $io.remove() } else { $io.attr('src', s.iframeSrc) }
                    xhr.responseXML = null }, 100) } var x = $.parseXML || function(s, a) { if (window.ActiveXObject) { a = new ActiveXObject('Microsoft.XMLDOM');
                    a.async = 'false';
                    a.loadXML(s) } else { a = (new DOMParser()).parseFromString(s, 'text/xml') } return (a && a.documentElement && a.documentElement.nodeName !== 'parsererror') ? a : null }; var y = $.parseJSON || function(s) { return window['eval']('(' + s + ')') }; var z = function(a, b, s) { var c = a.getResponseHeader('content-type') || '',
                    xml = ((b === 'xml' || !b) && c.indexOf('xml') >= 0),
                    w = xml ? a.responseXML : a.responseText; if (xml && w.documentElement.nodeName === 'parsererror') { if ($.error) { $.error('parsererror') } } if (s && s.dataFilter) { w = s.dataFilter(w, b) } if (typeof w === 'string') { if ((b === 'json' || !b) && c.indexOf('json') >= 0) { w = y(w) } else if ((b === 'script' || !b) && c.indexOf('javascript') >= 0) { $.globalEval(w) } } return w }; return m } };
    $.fn.ajaxForm = function(a, b, c, d) { if (typeof a === 'string' || (a === false && arguments.length > 0)) { a = { 'url': a, 'data': b, 'dataType': c }; if (typeof d === 'function') { a.success = d } }
        a = a || {};
        a.delegation = a.delegation && $.isFunction($.fn.on); if (!a.delegation && this.length === 0) { var o = { s: this.selector, c: this.context }; if (!$.isReady && o.s) { log('DOM not ready, queuing ajaxForm');
                $(function() { $(o.s, o.c).ajaxForm(a) }); return this }
            log('terminating; zero elements found by selector' + ($.isReady ? '' : ' (DOM not ready)')); return this } if (a.delegation) { $(document).off('submit.form-plugin', this.selector, doAjaxSubmit).off('click.form-plugin', this.selector, captureSubmittingElement).on('submit.form-plugin', this.selector, a, doAjaxSubmit).on('click.form-plugin', this.selector, a, captureSubmittingElement); return this } return this.ajaxFormUnbind().on('submit.form-plugin', a, doAjaxSubmit).on('click.form-plugin', a, captureSubmittingElement) };

    function doAjaxSubmit(e) { var a = e.data; if (!e.isDefaultPrevented()) { e.preventDefault();
            $(e.target).closest('form').ajaxSubmit(a) } }

    function captureSubmittingElement(e) { var a = e.target; var b = $(a); if (!b.is('[type=submit],[type=image]')) { var t = b.closest('[type=submit]'); if (t.length === 0) { return }
            a = t[0] } var c = a.form;
        c.clk = a; if (a.type === 'image') { if (typeof e.offsetX !== 'undefined') { c.clk_x = e.offsetX;
                c.clk_y = e.offsetY } else if (typeof $.fn.offset === 'function') { var d = b.offset();
                c.clk_x = e.pageX - d.left;
                c.clk_y = e.pageY - d.top } else { c.clk_x = e.pageX - a.offsetLeft;
                c.clk_y = e.pageY - a.offsetTop } }
        setTimeout(function() { c.clk = c.clk_x = c.clk_y = null }, 100) }
    $.fn.ajaxFormUnbind = function() { return this.off('submit.form-plugin click.form-plugin') };
    $.fn.formToArray = function(b, c, d) { var a = []; if (this.length === 0) { return a } var e = this[0]; var f = this.attr('id'); var g = (b || typeof e.elements === 'undefined') ? e.getElementsByTagName('*') : e.elements; var h; if (g) { g = $.makeArray(g) } if (f && (b || /(Edge|Trident)\//.test(navigator.userAgent))) { h = $(':input[form="' + f + '"]').get(); if (h.length) { g = (g || []).concat(h) } } if (!g || !g.length) { return a } if ($.isFunction(d)) { g = $.map(g, d) } var i, j, n, v, el, max, jmax; for (i = 0, max = g.length; i < max; i++) { el = g[i];
            n = el.name; if (!n || el.disabled) { continue } if (b && e.clk && el.type === 'image') { if (e.clk === el) { a.push({ name: n, value: $(el).val(), type: el.type });
                    a.push({ name: n + '.x', value: e.clk_x }, { name: n + '.y', value: e.clk_y }) } continue }
            v = $.fieldValue(el, true); if (v && v.constructor === Array) { if (c) { c.push(el) } for (j = 0, jmax = v.length; j < jmax; j++) { a.push({ name: n, value: v[j] }) } } else if (W.fileapi && el.type === 'file') { if (c) { c.push(el) } var k = el.files; if (k.length) { for (j = 0; j < k.length; j++) { a.push({ name: n, value: k[j], type: el.type }) } } else { a.push({ name: n, value: '', type: el.type }) } } else if (v !== null && typeof v !== 'undefined') { if (c) { c.push(el) }
                a.push({ name: n, value: v, type: el.type, required: el.required }) } } if (!b && e.clk) { var l = $(e.clk),
                input = l[0];
            n = input.name; if (n && !input.disabled && input.type === 'image') { a.push({ name: n, value: l.val() });
                a.push({ name: n + '.x', value: e.clk_x }, { name: n + '.y', value: e.clk_y }) } } return a };
    $.fn.formSerialize = function(a) { return $.param(this.formToArray(a)) };
    $.fn.fieldSerialize = function(b) { var a = [];
        this.each(function() { var n = this.name; if (!n) { return } var v = $.fieldValue(this, b); if (v && v.constructor === Array) { for (var i = 0, max = v.length; i < max; i++) { a.push({ name: n, value: v[i] }) } } else if (v !== null && typeof v !== 'undefined') { a.push({ name: this.name, value: v }) } }); return $.param(a) };
    $.fn.fieldValue = function(a) { for (var b = [], i = 0, max = this.length; i < max; i++) { var c = this[i]; var v = $.fieldValue(c, a); if (v === null || typeof v === 'undefined' || (v.constructor === Array && !v.length)) { continue } if (v.constructor === Array) { $.merge(b, v) } else { b.push(v) } } return b };
    $.fieldValue = function(b, c) { var n = b.name,
            t = b.type,
            tag = b.tagName.toLowerCase(); if (typeof c === 'undefined') { c = true } if (c && (!n || b.disabled || t === 'reset' || t === 'button' || (t === 'checkbox' || t === 'radio') && !b.checked || (t === 'submit' || t === 'image') && b.form && b.form.clk !== b || tag === 'select' && b.selectedIndex === -1)) { return null } if (tag === 'select') { var d = b.selectedIndex; if (d < 0) { return null } var a = [],
                ops = b.options; var e = (t === 'select-one'); var f = (e ? d + 1 : ops.length); for (var i = (e ? d : 0); i < f; i++) { var g = ops[i]; if (g.selected && !g.disabled) { var v = g.value; if (!v) { v = (g.attributes && g.attributes.value && !(g.attributes.value.specified)) ? g.text : g.value } if (e) { return v }
                    a.push(v) } } return a } return $(b).val().replace(V, '\r\n') };
    $.fn.clearForm = function(a) { return this.each(function() { $('input,select,textarea', this).clearFields(a) }) };
    $.fn.clearFields = $.fn.clearInputs = function(a) { var b = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i; return this.each(function() { var t = this.type,
                tag = this.tagName.toLowerCase(); if (b.test(t) || tag === 'textarea') { this.value = '' } else if (t === 'checkbox' || t === 'radio') { this.checked = false } else if (tag === 'select') { this.selectedIndex = -1 } else if (t === 'file') { if (/MSIE/.test(navigator.userAgent)) { $(this).replaceWith($(this).clone(true)) } else { $(this).val('') } } else if (a) { if ((a === true && /hidden/.test(t)) || (typeof a === 'string' && $(this).is(a))) { this.value = '' } } }) };
    $.fn.resetForm = function() { return this.each(function() { var a = $(this); var b = this.tagName.toLowerCase(); switch (b) {
                case 'input':
                    this.checked = this.defaultChecked;
                case 'textarea':
                    this.value = this.defaultValue; return true;
                case 'option':
                case 'optgroup':
                    var c = a.parents('select'); if (c.length && c[0].multiple) { if (b === 'option') { this.selected = this.defaultSelected } else { a.find('option').resetForm() } } else { c.resetForm() } return true;
                case 'select':
                    a.find('option').each(function(i) { this.selected = this.defaultSelected; if (this.defaultSelected && !a[0].multiple) { a[0].selectedIndex = i; return false } }); return true;
                case 'label':
                    var d = $(a.attr('for')); var e = a.find('input,select,textarea'); if (d[0]) { e.unshift(d[0]) }
                    e.resetForm(); return true;
                case 'form':
                    if (typeof this.reset === 'function' || (typeof this.reset === 'object' && !this.reset.nodeType)) { this.reset() } return true;
                default:
                    a.find('form,input,label,select,textarea').resetForm(); return true } }) };
    $.fn.enable = function(b) { if (typeof b === 'undefined') { b = true } return this.each(function() { this.disabled = !b }) };
    $.fn.selected = function(b) { if (typeof b === 'undefined') { b = true } return this.each(function() { var t = this.type; if (t === 'checkbox' || t === 'radio') { this.checked = b } else if (this.tagName.toLowerCase() === 'option') { var a = $(this).parent('select'); if (b && a[0] && a[0].type === 'select-one') { a.find('option').selected(false) }
                this.selected = b } }) };
    $.fn.ajaxSubmit.debug = false;

    function log() { if (!$.fn.ajaxSubmit.debug) { return } var a = '[jquery.form] ' + Array.prototype.join.call(arguments, ''); if (window.console && window.console.log) { window.console.log(a) } else if (window.opera && window.opera.postError) { window.opera.postError(a) } } }));
/*cookie*/
(function(a) { if (typeof define === 'function' && define.amd) { define(['jquery'], a) } else if (typeof exports === 'object') { module.exports = a(require('jquery')) } else { a(jQuery) } }(function($) { var g = /\+/g;

    function encode(s) { return h.raw ? s : encodeURIComponent(s) }

    function decode(s) { return h.raw ? s : decodeURIComponent(s) }

    function stringifyCookieValue(a) { return encode(h.json ? JSON.stringify(a) : String(a)) }

    function parseCookieValue(s) { if (s.indexOf('"') === 0) { s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\') } try { s = decodeURIComponent(s.replace(g, ' ')); return h.json ? JSON.parse(s) : s } catch (e) {} }

    function read(s, a) { var b = h.raw ? s : parseCookieValue(s); return $.isFunction(a) ? a(b) : b } var h = $.cookie = function(a, b, c) { if (arguments.length > 1 && !$.isFunction(b)) { c = $.extend({}, h.defaults, c); if (typeof c.expires === 'number') { var d = c.expires,
                    t = c.expires = new Date();
                t.setMilliseconds(t.getMilliseconds() + d * 864e+5) } return (document.cookie = [encode(a), '=', stringifyCookieValue(b), c.expires ? '; expires=' + c.expires.toUTCString() : '', c.path ? '; path=' + c.path : '', c.domain ? '; domain=' + c.domain : '', c.secure ? '; secure' : ''].join('')) } var e = a ? undefined : {},
            cookies = document.cookie ? document.cookie.split('; ') : [],
            i = 0,
            l = cookies.length; for (; i < l; i++) { var f = cookies[i].split('='),
                name = decode(f.shift()),
                cookie = f.join('='); if (a === name) { e = read(cookie, b); break } if (!a && (cookie = read(cookie)) !== undefined) { e[name] = cookie } } return e };
    h.defaults = {};
    $.removeCookie = function(a, b) { $.cookie(a, '', $.extend({}, b, { expires: -1 })); return !$.cookie(a) } }));
/* Custom File Input */
(function($) { "use strict"; var nextId = 0; var Filestyle = function(element, options) { this.options = options;
        this.$elementFilestyle = [];
        this.$element = $(element) };
    Filestyle.prototype = { clear: function() { this.$element.val('');
            this.$elementFilestyle.find(':text').val('');
            this.$elementFilestyle.find('.label').remove() }, destroy: function() { this.$element.removeAttr('style').removeData('filestyle');
            this.$elementFilestyle.remove() }, disabled: function(value) { if (value === true || value === false) { this.options.disabled = value;
                this.$element.prop('disabled', this.options.disabled);
                this.$elementFilestyle.find('label').prop('disabled', this.options.disabled); if (this.options.disabled) { this.$elementFilestyle.find('label').css('opacity', '0.65') } else { this.$elementFilestyle.find('label').css('opacity', '1') } } else { return this.options.disabled } }, dragdrop: function(value) { if (value === true || value === false) { this.options.dragdrop = value } else { return this.options.dragdrop } }, buttonBefore: function(value) { if (value === true) { if (!this.options.buttonBefore) { this.options.buttonBefore = value; if (this.options.input) { this.$elementFilestyle.remove();
                        this.constructor();
                        this.pushNameFiles() } } } else if (value === false) { if (this.options.buttonBefore) { this.options.buttonBefore = value; if (this.options.input) { this.$elementFilestyle.remove();
                        this.constructor();
                        this.pushNameFiles() } } } else { return this.options.buttonBefore } }, input: function(value) { if (value === true) { if (!this.options.input) { this.options.input = value; if (this.options.buttonBefore) { this.$elementFilestyle.append(this.htmlInput()) } else { this.$elementFilestyle.prepend(this.htmlInput()) }
                    this.pushNameFiles();
                    this.$elementFilestyle.find('.group-span-filestyle').addClass('input-group-btn') } } else if (value === false) { if (this.options.input) { this.options.input = value;
                    this.$elementFilestyle.find(':text').remove();
                    this.$elementFilestyle.find('.group-span-filestyle').removeClass('input-group-btn') } } else { return this.options.input } }, size: function(value) { if (value !== undefined) { this.options.size = value; var btn = this.$elementFilestyle.find('label'),
                    input = this.$elementFilestyle.find('input');
                btn.removeClass('btn-lg btn-sm');
                input.removeClass('form-control-lg form-control-sm'); if (this.options.size !== 'nr') { btn.addClass('btn-' + this.options.size);
                    input.addClass('form-control-' + this.options.size) } } else { return this.options.size } }, placeholder: function(value) { if (value !== undefined) { this.options.placeholder = value;
                this.$elementFilestyle.find('input').attr('placeholder', value) } else { return this.options.placeholder } }, text: function(value) { if (value !== undefined) { this.options.text = value;
                this.$elementFilestyle.find('label .text').html(this.options.text) } else { return this.options.text } }, btnClass: function(value) { if (value !== undefined) { this.options.btnClass = value;
                this.$elementFilestyle.find('label').attr({ 'class': 'btn ' + this.options.btnClass + ' btn-' + this.options.size }) } else { return this.options.btnClass } }, badge: function(value) { if (value === true) { this.options.badge = value; var files = this.pushNameFiles();
                this.$elementFilestyle.find('label').append(' <span class="label ' + this.options.badgeName + '">' + files.length + '</label>') } else if (value === false) { this.options.badge = value;
                this.$elementFilestyle.find('.label').remove() } else { return this.options.badge } }, badgeName: function(value) { if (value !== undefined) { this.options.badgeName = value;
                this.$elementFilestyle.find('.label').attr({ 'class': 'label ' + this.options.badgeName }) } else { return this.options.badgeName } }, htmlIcon: function(value) { if (value !== undefined) { this.options.htmlIcon = value } return (this.options.htmlIcon) ? '<i class="' + this.options.htmlIcon + '"></i>' : this.options.htmlIcon }, htmlInput: function() { if (this.options.input) { return '<input type="text" placeholder="' + this.options.placeholder + '" disabled> ' } else { return '' } }, pushNameFiles: function() { var content = '',
                files = []; if (this.$element[0].files === undefined) { files[0] = { 'name': this.$element[0] && this.$element[0].value } } else { files = this.$element[0].files } for (var i = 0; i < files.length; i++) { content += files[i].name.split("\\").pop() + ', ' } if (content !== '') { this.$elementFilestyle.find(':text').val(content.replace(/\, $/g, '')) } else { this.$elementFilestyle.find(':text').val('') } return files }, constructor: function() { var _self = this,
                html = '',
                id = _self.$element.attr('id'),
                files = [],
                btn = '',
                $label; if (id === '' || !id) { id = 'filestyle-' + nextId;
                _self.$element.attr({ 'id': id });
                nextId++ }
            btn = '<div class="group-span-filestyle ' + (_self.options.input ? 'input-group-btn' : '') + '">' + '<label for="' + id + '" class="wojo button ' + _self.options.btnClass + ' ' + (_self.options.size === 'nr' ? '' : 'btn-' + _self.options.size) + '" ' + (_self.options.disabled || _self.$element.attr('disabled') ? ' disabled="true"' : '') + '>' + _self.htmlIcon() + '<span class="buttonText">' + _self.options.text + '</span>' + '</label>' + '</div>';
            html = _self.options.buttonBefore ? btn + _self.htmlInput() : _self.htmlInput() + btn;
            _self.$elementFilestyle = $('<div class="wojo file"><div name="filedrag"></div>' + html + '</div>');
            _self.$elementFilestyle.find('.group-span-filestyle').attr('tabindex', "0").keypress(function(e) { if (e.keyCode === 13 || e.charCode === 32) { _self.$elementFilestyle.find('label').click(); return false } });
            _self.$element.css({ 'position': 'absolute', 'width': 'auto', 'clip': 'rect(0px 0px 0px 0px)' }).attr('tabindex', "-1").after(_self.$elementFilestyle);
            _self.$elementFilestyle.find(_self.options.buttonBefore ? 'label' : ':input').css({ 'border-top-left-radius': '.25rem', 'border-bottom-left-radius': '.25rem' });
            _self.$elementFilestyle.find('[name="filedrag"]').css({ position: 'absolute', width: '100%', height: _self.$elementFilestyle.height() + 'px', 'z-index': -1 }); if (_self.options.disabled || _self.$element.attr('disabled')) { _self.$element.attr('disabled', 'true'); if (_self.options.disabled) { _self.$elementFilestyle.find('label').css('opacity', '0.65') } else { _self.$elementFilestyle.find('label').css('opacity', '1') } }
            _self.$element.change(function() { var files = _self.pushNameFiles(); if (_self.options.badge) { if (_self.$elementFilestyle.find('.label').length === 0) { _self.$elementFilestyle.find('label').append(' <span class="label ' + _self.options.badgeName + '">' + files.length + '</span>') } else if (files.length === 0) { _self.$elementFilestyle.find('.label').remove() } else { _self.$elementFilestyle.find('.label').html(files.length) } } else { _self.$elementFilestyle.find('.label').remove() }
                _self.options.onChange(files) }); if (window.navigator.userAgent.search(/firefox/i) > -1) { _self.$elementFilestyle.find('label').click(function() { _self.$element.click(); return false }) }
            $(document).on('dragover', function(e) { e.preventDefault();
                e.stopPropagation(); if (_self.options.dragdrop) { $('[name="filedrag"]').css('z-index', '9') } }).on('drop', function(e) { e.preventDefault();
                e.stopPropagation(); if (_self.options.dragdrop) { $('[name="filedrag"]').css('z-index', '-1') } });
            _self.$elementFilestyle.find('[name="filedrag"]').on('dragover', function(e) { e.preventDefault();
                e.stopPropagation() }).on('dragenter', function(e) { e.preventDefault();
                e.stopPropagation() }).on('drop', function(e) { if (e.originalEvent.dataTransfer && !_self.options.disabled && _self.options.dragdrop) { if (e.originalEvent.dataTransfer.files.length) { e.preventDefault();
                        e.stopPropagation();
                        _self.$element[0].files = e.originalEvent.dataTransfer.files; var files = _self.pushNameFiles(); if (_self.options.badge) { if (_self.$elementFilestyle.find('.label').length === 0) { _self.$elementFilestyle.find('label').append(' <span class="label ' + _self.options.badgeName + '">' + files.length + '</span>') } else if (files.length === 0) { _self.$elementFilestyle.find('.label').remove() } else { _self.$elementFilestyle.find('.label').html(files.length) } } else { _self.$elementFilestyle.find('.label').remove() }
                        $('[name="filedrag"]').css('z-index', '-1') } } }) } }; var old = $.fn.filestyle;
    $.fn.filestyle = function(option, value) { var get = '',
            element = this.each(function() { if ($(this).attr('type') === 'file') { var $this = $(this),
                        data = $this.data('filestyle'),
                        options = $.extend({}, $.fn.filestyle.defaults, option, typeof option === 'object' && option); if (!data) { $this.data('filestyle', (data = new Filestyle(this, options)));
                        data.constructor() } if (typeof option === 'string') { get = data[option](value) } } }); if (typeof get !== undefined) { return get } else { return element } };
    $.fn.filestyle.defaults = { 'text': 'Choose file', 'htmlIcon': '', 'btnClass': 'primary', 'size': 'nr', 'input': true, 'badge': true, 'badgeName': 'badge-light', 'buttonBefore': false, 'dragdrop': true, 'disabled': false, 'placeholder': '', 'onChange': function() {} };
    $.fn.filestyle.noConflict = function() { $.fn.filestyle = old; return this };
    $(function() { $('.filestyle').each(function() { var $this = $(this),
                options = { 'input': $this.attr('data-input') !== 'false', 'htmlIcon': $this.attr('data-icon'), 'buttonBefore': $this.attr('data-buttonBefore') === 'true', 'disabled': $this.attr('data-disabled') === 'true', 'size': $this.attr('data-size'), 'text': $this.attr('data-text'), 'btnClass': $this.attr('data-btnClass'), 'badge': $this.attr('data-badge') === 'true', 'dragdrop': $this.attr('data-dragdrop') !== 'false', 'badgeName': $this.attr('data-badgeName'), 'placeholder': $this.attr('data-placeholder') };
            $this.filestyle(options) }) }) })(window.jQuery);
/*transitions*/
(function(factory) { if (typeof define === 'function' && define.amd) { define(['jquery'], factory) } else if (typeof module === 'object' && module.exports) { module.exports = function(root, jQuery) { if (jQuery === undefined) { if (typeof window !== 'undefined') { jQuery = require('jquery') } else { jQuery = require('jquery')(root) } }
            factory(jQuery); return jQuery } } else { factory(jQuery) } }(function($) { 'use strict';

    function animate(el, options) { var animationEnd = 'animationend mozAnimationEnd MSAnimationEnd oanimationend webkitAnimationEnd';
        $(el).removeClass('hidden').addClass('animate ' + options.animation).on(animationEnd, function() { $(this).off(animationEnd);
            $(el).removeClass('animate ' + options.animation);
            options.complete.call(el) }) }
    $.fn.transition = function(animation) { var options = {}; if (typeof arguments[1] === 'object') { options = arguments[1] } else if (typeof arguments[1] === 'function') { options.complete = arguments[1] } else if (typeof arguments[1] === 'number') { options.duration = arguments[1]; if (typeof arguments[2] === 'function') options.complete = arguments[2] }
        options = $.extend(true, { animation: animation, complete: function() {}, delay: 0, duration: 1000 }, options);
        $(this).each(function() { var el = this; if (typeof $(el).attr("data-duration") === "undefined" || $(el).attr("data-duration") === false) { $(el).css({ '-webkit-animation-duration': options.duration + 'ms', 'animation-duration': options.duration + 'ms' }) } var delay; if (typeof $(el).attr("data-delay") !== "undefined" || $(el).attr("data-delay") !== false) { delay = $(el).attr("data-delay") } else { delay = options.delay }
            setTimeout(function() { animate(el, options) }, delay) }); return this } }));
/*wProgress Bars*/
(function($, e, f, g) { "use strict"; var h = 'wProgress'; var i; var j = false; var k;

    function Plugin(a, b) { this.element = a;
        this._name = h;
        this._defaults = $.fn.wProgress.defaults;
        this.options = $.extend({}, this._defaults, $(this.element).data('wprogress'), b);
        this.init() }
    $.extend(Plugin.prototype, { init: function() { if (this.getTransitionSupport()) { j = true;
                k = this.getTransitionPrefix() }
            this.appendHTML();
            this.setEventHandlers();
            this.initializeItems() }, appendHTML: function() { var a = $(".bar", this.element).attr('data-percent'); if (!this.options.tooltip) { $(".tip", this.element).css('display', 'none') } if (!this.options.label) { $(".label", this.element).css('display', 'none') }
            $(".tip", this.element).text(a + this.options.symbol);
            $(".label", this.element).text(a) }, initializeItems: function() { var a = $(".bar", this.element).attr('data-percent'); var b = this.calculateFill(a);
            this.animateFill(b) }, calculateFill: function(a) { a = a * 0.01; var b = $(this.element).width() * a; return b }, setEventHandlers: function() { var a = this; if (a.options.animateOnResize) { $(e).on("resize", function() { clearTimeout(i);
                    i = setTimeout(function() { a.refill() }, 300) }) } }, getTransition: function(a, b, c) { var d; if (c === 'width') { d = { width: a } } else if (c === 'left') { d = { left: a } }
            b = b / 1000;
            d[k] = c + ' ' + b + 's ease-in-out'; return d }, animateFill: function(a) { var b = this;
            $(".bar", this.element).stop().animate({ width: '+=' + a }, b.options.duration, function() { b.callback() }) }, refill: function() { $(".bar", this.element).css('width', 0);
            this.initializeItems() }, getTransitionSupport: function() { var a = f.body || f.documentElement,
                thisStyle = a.style; var b = thisStyle.transition !== g || thisStyle.WebkitTransition !== g || thisStyle.MozTransition !== g || thisStyle.MsTransition !== g || thisStyle.OTransition !== g; return b }, getTransitionPrefix: function() { if (/webkit/.test(navigator.userAgent.toLowerCase())) { return '-webkit-transition' } else { return 'transition' } }, callback: function() { var a = this.options.onFinish; if (typeof a === 'function') { a.call(this.element) } } });
    $.fn.wProgress = function(a) { this.each(function() { if (!$.data(this, "plugin_" + h)) { $.data(this, "plugin_" + h, new Plugin(this, a)) } }); return this };
    $.fn.wProgress.defaults = { tooltip: true, label: true, duration: 1000, animateOnResize: true, onFinish: function() {}, symbol: "%" } })(jQuery, window, document);
/*wNotice*/
(function($) { "use strict";
    $.wNotice = function(a, b, c) { return $.fn.wNotice(a, b, c) };
    $.fn.wNotice = function(a, b, c) { var d = { duplicates: true, autoclose: 5000, title: "", type: "" }; if (!a) { a = this.html() } if (b) { $.extend(d, b) } var e = true; var f = "no"; var g = Math.floor(Math.random() * 99999);
        $(".sticky-note").each(function() { if ($(this).html() == a && $(this).is(":visible")) { f = "yes"; if (!d.duplicates) { e = false } } if ($(this).attr("id") === g) { g = Math.floor(Math.random() * 9999999) } }); if (!$("body").find("#wojo-overlay").html()) { $("body").append('<div id="wojo-overlay"></div>') } if (e) { $("#wojo-overlay").prepend('<div class="wojo hidden notice ' + d.type + '" id="' + g + '"></div>');
            $("#" + g).append('<div class="wojo attached transparent mini progress"><span class="bar" data-percent="100"></span></div><div class="content"><span>' + d.title + '</span><a class="notice-close" data-id="' + g + '"title="Close"><i class="icon delete"></i></a><p class="sticky-note" data-id="' + g + '">' + a + "</p></div>");
            $("#" + g).transition('scaleIn', { duration: 400 });
            $("#" + g + ' .progress').wProgress({ duration: d.autoclose, onFinish: function() { $("#" + g).transition('scaleOut', { delay: 0, duration: 200, complete: function() { $("#" + g).remove() } }) }, });
            e = true }
        $(".wojo.notice").ready(function() { if (d.autoclose) { setTimeout(function() { $("#" + g).transition('scaleOut', { duration: 400 }) }, d.autoclose) } });
        $(".wojo.notice").click(function() { $(this).dequeue().transition('fadeOut', { delay: 0, duration: 200, complete: function() { $("#" + g).remove() } }) }); var h = { id: g, duplicate: f, displayed: e, type: d.type, title: d.title }; if (c) { c(h) } else { return (h) } } })(jQuery);
/* image upload preview */
(function(a) { if (typeof define === "function" && define.amd) { define(["jquery"], a) } else { if (typeof exports === "object") { a(require("jquery")) } else { a(jQuery) } } }(function($) { var q = { className: "", text: "Drop a file", previewImage: true, value: null, classes: { main: "wavatar-dropzone", enter: "wavatar-enter", reject: "wavatar-reject", accept: "wavatar-accept", focus: "wavatar-focus" }, validators: { maxSize: null, width: null, maxWidth: null, minWidth: null, height: null, maxHeight: null, minHeight: null }, init: function() {}, enter: function() {}, leave: function() {}, reject: function() {}, accept: function() {}, format: function(a) { return a } };
    $.wavatar = function(m, n) { this.settings = $.extend(true, {}, q, $.wavatar.defaults, n);
        this.$input = $(m); var o = this,
            settings = o.settings,
            $input = o.$input; if (!$input.is('input[type="file"]')) { return } if (!$.wavatar.isBrowserCompatible()) { return } var p = function() { var k, $container, value;
            $container = $('<div class="' + settings.classes.main + ' ' + $input.data('class') + '" />').on("dragover.wavatar", function() { $(this).addClass(settings.classes.enter); if ($.isFunction(settings.enter)) { settings.enter.apply(this) } }).on("dragleave.wavatar", function() { $(this).removeClass(settings.classes.enter); if ($.isFunction(settings.leaved)) { settings.leaved.apply(this) } }).addClass(settings.className);
            $input.wrap($container).before("<div>" + settings.text + "</div>");
            k = $input.parent("." + settings.classes.main);
            value = settings.value || $input.data("value"); if ($input.data("exist")) { basename = $input.data("exist").replace(/\\/g, "/").replace(/.*\//, ""), formatted = settings.format(basename); var l = new Image();
                l.src = $input.data("exist");
                l.onload = function() { k.find("div").html($(l).fadeIn()) };
                l.onerror = function() { k.find("div").html("<span>" + formatted + "</span>") };
                k.addClass(settings.classes.accept) } if (value) { o.preview(value) } if ($.isFunction(settings.init)) { settings.init.apply($input, [value]) }
            $input.on("focus.wavatar", function() { k.addClass(settings.classes.focus) }).on("blur.wavatar", function() { k.removeClass(settings.classes.focus) }).on("change.wavatar", function() { var d = this.files[0]; if (!d) { return } var f = d.name.replace(/\\/g, "/").replace(/.*\//, ""),
                    extension = d.name.split(".").pop(),
                    formatted = settings.format(f);
                d.extension = extension; var g = $input.attr("accept"),
                    accepted = false,
                    valid = true,
                    errors = { mimeType: false, maxSize: false, width: false, minWidth: false, maxWidth: false, height: false, minHeight: false, maxHeight: false }; if (g) { var h = g.split(/[,|]/);
                    $.each(h, function(i, c) { c = $.trim(c); if (d.type === c) { accepted = true; return false } if (c.indexOf("/*") !== false) { var a = c.replace("/*", ""),
                                b = d.type.replace(/(\/.*)$/g, ""); if (a === b) { accepted = true; return false } } }); if (accepted === false) { errors.mimeType = true } } else { accepted = true }
                k.removeClass(settings.classes.reject + " " + settings.classes.accept); if (accepted !== true) { $input.val("");
                    k.addClass(settings.classes.reject); if ($.isFunction(settings.reject)) { settings.reject.apply($input, [d, errors]) } return false } var j = new FileReader(d);
                j.readAsDataURL(d);
                j.onload = function(e) { var a = new Image(),
                        isImage;
                    d.data = e.target.result;
                    a.src = d.data;
                    setTimeout(function() { isImage = (a.width && a.height); if (settings.validators.maxSize && d.size > settings.validators.maxSize) { valid = false;
                            errors.maxSize = true } if (isImage) { d.width = a.width;
                            d.height = a.height; if (settings.validators.width && a.width !== settings.validators.width) { valid = false;
                                errors.width = true } if (settings.validators.maxWidth && a.width > settings.validators.maxWidth) { valid = false;
                                errors.maxWidth = true } if (settings.validators.minWidth && a.width < settings.validators.minWidth) { valid = false;
                                errors.minWidth = true } if (settings.validators.height && a.height !== settings.validators.height) { valid = false;
                                errors.height = true } if (settings.validators.maxHeight && a.height > settings.validators.maxHeight) { valid = false;
                                errors.maxHeight = true } if (settings.validators.minHeight && a.height < settings.validators.minHeight) { valid = false;
                                errors.minHeight = true } } if (valid === true) { k.find("img").remove(); if (isImage && settings.previewImage === true) { k.find("div").html($(a).fadeIn()) } else { k.find("div").html("<span>" + formatted + "</span>") }
                            k.addClass(settings.classes.accept); if ($.isFunction(settings.accept)) { settings.accept.apply($input, [d]) } } else { $input.val("");
                            k.addClass(settings.classes.reject); if ($.isFunction(settings.reject)) { settings.reject.apply($input, [d, errors]) } } }, 250) } }) };
        p() };
    $.wavatar.prototype.preview = function(a, b) { var c = this.settings,
            $input = this.$input,
            $wavatar = $input.parent("." + c.classes.main),
            basename = a.replace(/\\/g, "/").replace(/.*\//, ""),
            formatted = c.format(basename); var d = new Image();
        d.src = a;
        d.onload = function() { $wavatar.find("div").html($(d).fadeIn()); if ($.isFunction(b)) { b.apply(this) } };
        d.onerror = function() { $wavatar.find("div").html("<span>" + formatted + "</span>"); if ($.isFunction(b)) { b.apply(this) } };
        $wavatar.addClass(c.classes.accept) };
    $.wavatar.prototype.destroy = function() { var a = this.settings,
            $input = this.$input;
        $input.parent("." + a.classes.main).replaceWith($input);
        $input.off("*.wavatar");
        $input.removeData("wavatar") };
    $.wavatar.prototype.options = function(a) { var b = this.settings; if (!a) { return b }
        $.extend(true, this.settings, a) };
    $.wavatar.prototype.container = function() { var a = this.settings,
            $input = this.$input; return $input.parent("." + a.classes.main) };
    $.wavatar.isBrowserCompatible = function() { return !!(window.File && window.FileList && window.FileReader) };
    $.wavatar.defaults = q;
    $.fn.wavatar = function(a) { var b = arguments,
            plugin = $(this).data("wavatar"); if (!plugin) { return $(this).data("wavatar", new $.wavatar(this, a)) } if (plugin[a]) { return plugin[a].apply(plugin, Array.prototype.slice.call(b, 1)) } else { $.error("wavatar error-Method " + a + " does not exist.") } } }));
/*wTabs*/
(function($, e, f, g) { "use strict"; var h = 'wTabs';

    function Plugin(a, b) { this.element = a;
        this._name = h;
        this._defaults = $.fn.wTabs.defaults;
        this.options = $.extend({}, this._defaults, $(this.element).data('wtabs'), b);
        this.init() }
    $.extend(Plugin.prototype, { init: function() { this._initTabs();
            this.bindEvents() }, _initTabs: function() { $(this.element).attr("id", this.makeid); var a = $(this.element).attr("id");
            $("#" + a + " .tab").children().hide();
            $("#" + a + " .nav").children(":first").addClass("active");
            $("#" + a + " .tab").children(":first").addClass("active").show() }, bindEvents: function() { var c = $(this.element).attr("id");
            $("#" + c).on('click', '.nav li a', function() { $("#" + c + " .nav li").removeClass("active");
                $(this).parent().addClass("active");
                $("#" + c + " .tab").children().hide(); var a = $(this).data("tab"); var b = $("#" + c + " .tab .item[data-tab=" + a + "]");
                $("#" + c + " .tab").children().removeClass('active');
                b.addClass('active').show() }) }, makeid: function() { var a = ""; var b = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"; for (var i = 0; i < 2; i++) { a += b.charAt(Math.floor(Math.random() * b.length)) } var c = ""; var d = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"; for (var k = 0; k < 5; k++) { c += d.charAt(Math.floor(Math.random() * d.length)) } return a + c }, });
    $.fn.wTabs = function(a) { this.each(function() { if (!$.data(this, "plugin_" + h)) { $.data(this, "plugin_" + h, new Plugin(this, a)) } }); return this };
    $.fn.wTabs.defaults = {} })(jQuery, window, document);
/*wAccordion*/
(function($, f, g, h) { "use strict"; var i = 'wAccordion';

    function Plugin(a, b) { this.element = a;
        this._name = i;
        this._defaults = $.fn.wAccordion.defaults;
        this.options = $.extend({}, this._defaults, $(this.element).data('waccordion'), b);
        this.init() }
    $.extend(Plugin.prototype, { init: function() { var a = this; var b = $(this.element).find("section .summary"); var c = $(this.element).find("section"); var d = $(this.element).find(".details"); if (this.options.collapsed === true) { $(d).css('display', 'none') }
            $(b).click(function(e) { e = $(this).siblings(".details");
                e.slideToggle(a.options.slidingSpeed, function() { a.options.onSlideToggle(); if ($(this).is(":visible")) { $(this).parent().addClass("active") } else { $(this).parent().removeClass("active") } });
                c.removeClass("active"); if (a.options.closeOther === true) { $(".details").not(e).slideUp(a.options.slidingSpeed) } }) }, });
    $.fn.wAccordion = function(a) { this.each(function() { if (!$.data(this, "plugin_" + i)) { $.data(this, "plugin_" + i, new Plugin(this, a)) } }); return this };
    $.fn.wAccordion.defaults = { slidingSpeed: 300, collapsed: true, closeOther: false, onSlideToggle: function() {}, } })(jQuery, window, document);
/*wTags*/
(function($) { "use strict"; var o = { tagClass: function(a) { return 'label' }, focusClass: 'focus', itemValue: function(a) { return a ? a.toString() : a }, itemText: function(a) { return this.itemValue(a) }, itemTitle: function(a) { return null }, freeInput: true, addOnBlur: true, maxTags: 3, maxChars: undefined, confirmKeys: [13, 44], delimiter: ',', delimiterRegex: null, cancelConfirmKeysOnEmpty: false, onTagExists: function(a, b) { b.hide().fadeIn() }, trimValue: false, allowDuplicates: false, triggerChange: true };

    function WojoTags(a, b) { this.isInit = true;
        this.itemsArray = [];
        this.$element = $(a);
        this.$element.hide();
        this.objectItems = b && b.itemValue;
        this.placeholderText = a.hasAttribute('placeholder') ? this.$element.attr('placeholder') : '';
        this.inputSize = Math.max(1, this.placeholderText.length);
        this.$container = $('<div class="wojo icon input"><i class="icon tags"></i></div>');
        this.$input = $('<input type="text" placeholder="' + this.placeholderText + '"/>').appendTo(this.$container);
        this.$element.before(this.$container);
        this.build(b);
        this.isInit = false }
    WojoTags.prototype = { constructor: WojoTags, add: function(b, c, d) { var e = this; if (e.options.maxTags && e.itemsArray.length >= e.options.maxTags) return; if (b !== false && !b) return; if (typeof b === "string" && e.options.trimValue) { b = $.trim(b) } if (typeof b === "object" && !e.objectItems) throw ("Can't add objects when itemValue option is not set"); if (b.toString().match(/^\s*$/)) return; if (typeof b === "string" && this.$element[0].tagName === 'INPUT') { var f = (e.options.delimiterRegex) ? e.options.delimiterRegex : e.options.delimiter; var g = b.split(f); if (g.length > 1) { for (var i = 0; i < g.length; i++) { this.add(g[i], true) } if (!c) e.pushVal(e.options.triggerChange); return } } var h = e.options.itemValue(b),
                itemText = e.options.itemText(b),
                tagClass = e.options.tagClass(b),
                itemTitle = e.options.itemTitle(b); var j = $.grep(e.itemsArray, function(a) { return e.options.itemValue(a) === h })[0]; if (j && !e.options.allowDuplicates) { if (e.options.onTagExists) { var k = $(".tag", e.$container).filter(function() { return $(this).data("item") === j });
                    e.options.onTagExists(b, k) } return } if (e.items().toString().length + b.length + 1 > e.options.maxInputLength) return; var l = $.Event('beforeItemAdd', { item: b, cancel: false, options: d });
            e.$element.trigger(l); if (l.cancel) return;
            e.itemsArray.push(b); var m = $('<span class="tag ' + htmlEncode(tagClass) + (itemTitle !== null ? ('" title="' + itemTitle) : '') + '">' + htmlEncode(itemText) + '<span data-role="remove"></span></span>');
            m.data('item', b);
            e.findInputWrapper().before(m);
            m.after(' '); var n = ($('option[value="' + encodeURIComponent(h) + '"]', e.$element).length || $('option[value="' + htmlEncode(h) + '"]', e.$element).length); if (!c) e.pushVal(e.options.triggerChange); if (e.options.maxTags === e.itemsArray.length || e.items().toString().length === e.options.maxInputLength) e.$container.addClass('disabled'); if (this.isInit) { e.$element.trigger($.Event('itemAddedOnInit', { item: b, options: d })) } else { e.$element.trigger($.Event('itemAdded', { item: b, options: d })) } }, remove: function(b, c, d) { var e = this; if (e.objectItems) { if (typeof b === "object") b = $.grep(e.itemsArray, function(a) { return e.options.itemValue(a) == e.options.itemValue(b) });
                else b = $.grep(e.itemsArray, function(a) { return e.options.itemValue(a) == b });
                b = b[b.length - 1] } if (b) { var f = $.Event('beforeItemRemove', { item: b, cancel: false, options: d });
                e.$element.trigger(f); if (f.cancel) return;
                $('.tag', e.$container).filter(function() { return $(this).data('item') === b }).remove(); if ($.inArray(b, e.itemsArray) !== -1) e.itemsArray.splice($.inArray(b, e.itemsArray), 1) } if (!c) e.pushVal(e.options.triggerChange); if (e.options.maxTags > e.itemsArray.length) e.$container.removeClass('disabled');
            e.$element.trigger($.Event('itemRemoved', { item: b, options: d })) }, removeAll: function() { var a = this;
            $('.tag', a.$container).remove(); while (a.itemsArray.length > 0) a.itemsArray.pop();
            a.pushVal(a.options.triggerChange) }, refresh: function() { var b = this;
            $('.tag', b.$container).each(function() { var a = $(this),
                    item = a.data('item'),
                    itemValue = b.options.itemValue(item),
                    itemText = b.options.itemText(item),
                    tagClass = b.options.tagClass(item);
                a.attr('class', null);
                a.addClass('tag ' + htmlEncode(tagClass));
                a.contents().filter(function() { return this.nodeType == 3 })[0].nodeValue = htmlEncode(itemText) }) }, items: function() { return this.itemsArray }, pushVal: function() { var b = this,
                val = $.map(b.items(), function(a) { return b.options.itemValue(a).toString() });
            b.$element.val(val, true); if (b.options.triggerChange) b.$element.trigger('change') }, build: function(h) { var i = this;
            i.options = $.extend({}, o, h); if (i.objectItems) i.options.freeInput = false;
            makeOptionItemFunction(i.options, 'itemValue');
            makeOptionItemFunction(i.options, 'itemText');
            makeOptionFunction(i.options, 'tagClass');
            i.$container.on('click', $.proxy(function(a) { if (!i.$element.attr('disabled')) { i.$input.removeAttr('disabled') }
                i.$input.focus() }, i)); if (i.options.addOnBlur && i.options.freeInput) { i.$input.on('focusout', $.proxy(function(a) {}, i)) }
            i.$container.on({ focusin: function() { i.$container.addClass(i.options.focusClass) }, focusout: function() { i.$container.removeClass(i.options.focusClass) }, });
            i.$container.on('keydown', 'input', $.proxy(function(a) { var b = $(a.target),
                    $inputWrapper = i.findInputWrapper(); if (i.$element.attr('disabled')) { i.$input.attr('disabled', 'disabled'); return } switch (a.which) {
                    case 8:
                        if (doGetCaretPosition(b[0]) === 0) { var c = $inputWrapper.prev(); if (c.length) { i.remove(c.data('item')) } } break;
                    case 46:
                        if (doGetCaretPosition(b[0]) === 0) { var d = $inputWrapper.next(); if (d.length) { i.remove(d.data('item')) } } break;
                    case 37:
                        var e = $inputWrapper.prev(); if (b.val().length === 0 && e[0]) { e.before($inputWrapper);
                            b.focus() } break;
                    case 39:
                        var f = $inputWrapper.next(); if (b.val().length === 0 && f[0]) { f.after($inputWrapper);
                            b.focus() } break;
                    default:
                } var g = b.val().length,
                    wordSpace = Math.ceil(g / 5),
                    size = g + wordSpace + 1;
                b.attr('size', Math.max(this.inputSize, b.val().length)) }, i));
            i.$container.on('keypress', 'input', $.proxy(function(a) { var b = $(a.target); if (i.$element.attr('disabled')) { i.$input.attr('disabled', 'disabled'); return } var c = b.val(),
                    maxLengthReached = i.options.maxChars && c.length >= i.options.maxChars; if (i.options.freeInput && (keyCombinationInList(a, i.options.confirmKeys) || maxLengthReached)) { if (c.length !== 0) { i.add(maxLengthReached ? c.substr(0, i.options.maxChars) : c);
                        b.val('') } if (i.options.cancelConfirmKeysOnEmpty === false) { a.preventDefault() } } var d = b.val().length,
                    wordSpace = Math.ceil(d / 5),
                    size = d + wordSpace + 1;
                b.attr('size', Math.max(this.inputSize, b.val().length)) }, i));
            i.$container.on('click', '[data-role=remove]', $.proxy(function(a) { if (i.$element.attr('disabled')) { return }
                i.remove($(a.target).closest('.tag').data('item')) }, i)); if (i.options.itemValue === o.itemValue) { i.add(i.$element.val()) } }, destroy: function() { var a = this;
            a.$container.off('keypress', 'input');
            a.$container.off('click', '[role=remove]');
            a.$container.remove();
            a.$element.removeData('wTags');
            a.$element.show() }, focus: function() { this.$input.focus() }, input: function() { return this.$input }, findInputWrapper: function() { var a = this.$input[0],
                container = this.$container[0]; while (a && a.parentNode !== container) a = a.parentNode; return $(a) } };
    $.fn.wTags = function(c, d, e) { var f = [];
        this.each(function() { var a = $(this).data('wTags'); if (!a) { a = new WojoTags(this, c);
                $(this).data('wTags', a);
                f.push(a);
                $(this).val($(this).val()) } else if (!c && !d) { f.push(a) } else if (a[c] !== undefined) { if (a[c].length === 3 && e !== undefined) { var b = a[c](d, null, e) } else { var b = a[c](d) } if (b !== undefined) f.push(b) } }); if (typeof c == 'string') { return f.length > 1 ? f : f[0] } else { return f } };
    $.fn.wTags.Constructor = WojoTags;

    function makeOptionItemFunction(b, c) { if (typeof b[c] !== 'function') { var d = b[c];
            b[c] = function(a) { return a[d] } } }

    function makeOptionFunction(a, b) { if (typeof a[b] !== 'function') { var c = a[b];
            a[b] = function() { return c } } } var p = $('<div />');

    function htmlEncode(a) { if (a) { return p.text(a).html() } else { return '' } }

    function doGetCaretPosition(a) { var b = 0; if (document.selection) { a.focus(); var c = document.selection.createRange();
            c.moveStart('character', -a.value.length);
            b = c.text.length } else if (a.selectionStart || a.selectionStart == '0') { b = a.selectionStart } return (b) }

    function keyCombinationInList(d, e) { var f = false;
        $.each(e, function(a, b) { if (typeof(b) === 'number' && d.which === b) { f = true; return false } if (d.which === b.which) { var c = !b.hasOwnProperty('altKey') || d.altKey === b.altKey,
                    shift = !b.hasOwnProperty('shiftKey') || d.shiftKey === b.shiftKey,
                    ctrl = !b.hasOwnProperty('ctrlKey') || d.ctrlKey === b.ctrlKey; if (c && shift && ctrl) { f = true; return false } } }); return f } })(window.jQuery);
/*Dropdowns*/
(function($) { "use strict"; var c;
    $.fn.wDropdown = function(a, b) { switch (a) {
            case 'attach':
                return $(this).attr('data-dropdown', b);
            case 'detach':
                return $(this).removeAttr('data-dropdown');
            case 'show':
                return c(null, $(this));
            case 'hide':
                $.wDropdown.hideAll(); return $(this);
            case 'enable':
                return $(this).removeClass('dropdown-disabled');
            case 'disable':
                return $(this).addClass('dropdown-disabled') } };
    $.wDropdown = function() {};
    $.wDropdown.attachAll = function() { $('body').off('click.dropdown').on('click.dropdown', '[data-dropdown]', c);
        $('[data-dropdown]').off('click.dropdown').on('click.dropdown', c);
        $('html').off('click.dropdown').on('click.dropdown', $.wDropdown.hideAll);
        $(window).off('resize.dropdown').on('resize.dropdown', $.wDropdown.hideAll); return true };
    $.wDropdown.hideAll = function(e, a) { var b, hideExceptionID, targetGroup, trigger; if (e === null) { e = null } if (a === null) { a = null }
        targetGroup = e ? $(e.target).parents().addBack() : null; if (targetGroup && targetGroup.hasClass('dropdown') && !targetGroup.is('A')) { return }
        b = '.wojo.dropdown';
        trigger = '[data-dropdown]';
        hideExceptionID = ''; if (a) { hideExceptionID = $(a).attr('id'); if (!$('[data-dropdown="#' + hideExceptionID + '"]').hasClass('open')) { b = '.wojo.dropdown:not(#' + hideExceptionID + ')';
                trigger = '[data-dropdown!="#' + hideExceptionID + '"]' } }
        $('body').find(b).removeClass('active').end().find(trigger).removeClass('open'); return true };
    $.wDropdown.ANCHOR_POSITIONS = ['top-left', 'top-center', 'top-right', 'right-top', 'right-center', 'right-bottom', 'bottom-left', 'bottom-center', 'bottom-right', 'left-top', 'left-center', 'left-bottom'];
    $.wDropdown.defaults = { anchorPosition: 'center' };
    c = function(e, a) { var b, $dropdown, $trigger, $menu, addAnchorX, addAnchorY, addX, addY, anchorPosition, anchorSide, bottomTrigger, hasAnchor, heightDropdown, heightTrigger, i, isDisabled, isOpen, left, leftTrigger, len, position, positionParts, ref, rightTrigger, top, topTrigger, widthDropdown, widthTrigger; if (e === null) { e = null }
        $trigger = a ? a : $(this);
        $dropdown = $($trigger.data('dropdown'));
        $menu = $dropdown.children();
        b = $dropdown.find('.pointer');
        hasAnchor = $dropdown.hasClass('pointing');
        isOpen = $trigger.hasClass('active');
        isDisabled = $trigger.hasClass('dropdown-disabled');
        widthDropdown = $dropdown.outerWidth();
        widthTrigger = $trigger.outerWidth();
        heightDropdown = $dropdown.outerHeight();
        heightTrigger = $trigger.outerHeight();
        topTrigger = a ? $trigger.offset().top : $trigger.position().top;
        leftTrigger = a ? $trigger.offset().left : $trigger.position().left; if ($trigger.hasClass('dropdown-use-offset')) { topTrigger = $trigger.offset().top;
            leftTrigger = $trigger.offset().left }
        bottomTrigger = topTrigger + heightTrigger;
        rightTrigger = leftTrigger + widthTrigger; if ($dropdown.length < 1) { return console.log('[wDropdown] Could not find dropdown: ' + $(this).data('dropdown')) } if (b.length < 1 && hasAnchor) { b = $('<div class="pointer"></div>');
            $dropdown.prepend(b) } if (e !== null) { e.preventDefault();
            e.stopPropagation() } if (isOpen || isDisabled) { return false }
        $dropdown.on('click', 'a.item', function() { $dropdown.children('a.item').removeClass('active');
            $(this).addClass('active'); if (typeof $(this).attr('data-value') !== "undefined") { $dropdown.find('input[type=hidden]').val($(this).attr('data-value')) } if (typeof $(this).attr('data-html') !== "undefined") { $trigger.find('.text').text($(this).attr('data-html')) } });
        $.wDropdown.hideAll(null, $trigger.data('dropdown'));
        anchorPosition = $.wDropdown.defaults.anchorPosition;
        ref = $.wDropdown.ANCHOR_POSITIONS; for (i = 0, len = ref.length; i < len; i++) { position = ref[i]; if ($dropdown.hasClass(position)) { anchorPosition = position } }
        top = 0;
        left = 0;
        positionParts = anchorPosition.split('-');
        anchorSide = positionParts[0];
        anchorPosition = positionParts[1]; if (anchorSide === 'top' || anchorSide === 'bottom') { switch (anchorPosition) {
                case 'left':
                    left = leftTrigger; break;
                case 'center':
                    left = leftTrigger - widthDropdown / 2 + widthTrigger / 2; break;
                case 'right':
                    left = rightTrigger - widthDropdown } } if (anchorSide === 'left' || anchorSide === 'right') { switch (anchorPosition) {
                case 'top':
                    top = topTrigger; break;
                case 'center':
                    top = topTrigger - heightDropdown / 2 + heightTrigger / 2; break;
                case 'bottom':
                    top = topTrigger + heightTrigger - heightDropdown } } switch (anchorSide) {
            case 'top':
                top = topTrigger + heightTrigger; break;
            case 'right':
                left = leftTrigger - widthDropdown; break;
            case 'bottom':
                top = topTrigger - heightDropdown; break;
            case 'left':
                left = leftTrigger + widthTrigger }
        addX = parseInt($dropdown.data('add-x'));
        addY = parseInt($dropdown.data('add-y')); if (!isNaN(addX)) { left += addX } if (!isNaN(addY)) { top += addY }
        addAnchorX = parseInt($trigger.data('add-anchor-x'));
        addAnchorY = parseInt($trigger.data('add-anchor-y')); if (!isNaN(addAnchorX)) { b.css({ marginLeft: addAnchorX }) } if (!isNaN(addAnchorY)) { b.css({ marginTop: addAnchorY }) }
        $dropdown.css({ top: top, left: left, display: 'block', "minWidth": $trigger.outerWidth() });
        $dropdown.addClass('active');
        $trigger.addClass('open'); return $trigger }; return $(function() { return $.wDropdown.attachAll() }) })(jQuery);
/*Modal*/
(function(factory) { if (typeof module === "object" && typeof module.exports === "object") { factory(require("jquery"), window, document) } else { factory(jQuery, window, document) } }(function($, window, document, undefined) { var modals = [],
        getCurrent = function() { return modals.length ? modals[modals.length - 1] : null },
        selectCurrent = function() { var i, selected = false; for (i = modals.length - 1; i >= 0; i--) { if (modals[i].$blocker) { modals[i].$blocker.toggleClass('current', !selected).toggleClass('behind', selected);
                    selected = true } } };
    $.modal = function(el, options) { var remove, target;
        this.$body = $('body');
        this.options = $.extend({}, $.modal.defaults, options);
        this.$blocker = null; if (this.options.closeExisting)
            while ($.modal.isActive()) $.modal.close();
        modals.push(this); if (el.is('a')) { target = el.attr('href');
            this.anchor = el; if (/^#/.test(target)) { this.$elm = $(target); if (this.$elm.length !== 1) return null;
                this.$body.append(this.$elm);
                this.open() } } else { this.$elm = el;
            this.anchor = el;
            this.$body.append(this.$elm);
            this.open() } };
    $.modal.prototype = { constructor: $.modal, open: function() { var m = this;
            this.block();
            this.anchor.blur();
            this.show();
            $(document).off('keydown.modal').on('keydown.modal', function(event) { var current = getCurrent(); if (event.which === 27 && current.options.escapeClose) current.close() }); if (this.options.clickClose) this.$blocker.click(function(e) { if (e.target === this) $.modal.close() }) }, close: function() { modals.pop();
            this.unblock();
            this.hide(); if (!$.modal.isActive()) $(document).off('keydown.modal') }, block: function() { this.$elm.trigger($.modal.BEFORE_BLOCK, [this._ctx()]);
            this.$body.addClass("modal-open");
            this.$blocker = $('<div class="dimmer current"></div>').appendTo(this.$body);
            selectCurrent();
            this.$elm.trigger($.modal.BLOCK, [this._ctx()]) }, unblock: function(now) { this.$blocker.children().appendTo(this.$body);
            this.$blocker.remove();
            this.$blocker = null;
            selectCurrent(); if (!$.modal.isActive()) { this.$body.removeClass("modal-open") } }, show: function() { this.$elm.trigger($.modal.BEFORE_OPEN, [this._ctx()]);
            this.$elm.attr({ "data-delay": this.options.delay, "data-duration": this.options.speed });
            this.$elm.addClass("animate " + this.options.inAnimation); if (this.options.showClose) { this.closeButton = $('<button type="button" class="close" data="modal:close" aria-label="Close">' + this.options.closeText + '</button>');
                this.$elm.find(".header").append(this.closeButton) }
            this.$elm.appendTo(this.$blocker);
            this.$elm.css('display', 'block');
            this.$elm.trigger($.modal.OPEN, [this._ctx()]) }, hide: function() { this.$elm.trigger($.modal.BEFORE_CLOSE, [this._ctx()]);
            this.$elm.removeClass("animate " + this.options.inAnimation); if (this.closeButton) this.closeButton.remove(); var _this = this;
            this.$elm.hide(0, function() { _this.$elm.trigger($.modal.AFTER_CLOSE, [_this._ctx()]); if (_this.options.destroy) { _this.$elm.remove() } });
            this.$elm.trigger($.modal.CLOSE, [this._ctx()]) }, _ctx: function() { return { elm: this.$elm, $elm: this.$elm, $blocker: this.$blocker, options: this.options, $anchor: this.anchor } } };
    $.modal.close = function(event) { if (!$.modal.isActive()) return; if (event) event.preventDefault(); var current = getCurrent();
        current.close(); return current.$elm };
    $.modal.isActive = function() { return modals.length > 0 };
    $.modal.getCurrent = getCurrent;
    $.modal.defaults = { closeExisting: true, escapeClose: false, clickClose: false, closeText: '&times;', showClose: true, destroy: true, delay: 40, speed: 200, inAnimation: "fadeInTop", outAnimation: "fadeOutTop" };
    $.modal.BEFORE_BLOCK = 'modal:before-block';
    $.modal.BLOCK = 'modal:block';
    $.modal.BEFORE_OPEN = 'modal:before-open';
    $.modal.OPEN = 'modal:open';
    $.modal.BEFORE_CLOSE = 'modal:before-close';
    $.modal.CLOSE = 'modal:close';
    $.modal.AFTER_CLOSE = 'modal:after-close';
    $.fn.modal = function(options) { if (this.length === 1) { new $.modal(this, options) } return this };
    $(document).on('click.wojo.modal', 'button[data="modal:close"]', $.modal.close);
    $(document).on('click', '[data="modal:open"]', function(event) { event.preventDefault();
        $($(this).attr("data-modal")).modal($(this).data("options")) }) }));
/*Browser Detect*/
! function(a) { "function" == typeof define && define.amd ? define(["jquery"], function(b) { return a(b) }) : "object" == typeof module && "object" == typeof module.exports ? module.exports = a(require("jquery")) : a(window.jQuery) }(function(a) { "use strict";

    function b(a) { void 0 === a && (a = window.navigator.userAgent), a = a.toLowerCase(); var b = /(edge)\/([\w.]+)/.exec(a) || /(opr)[\/]([\w.]+)/.exec(a) || /(chrome)[ \/]([\w.]+)/.exec(a) || /(iemobile)[\/]([\w.]+)/.exec(a) || /(version)(applewebkit)[ \/]([\w.]+).*(safari)[ \/]([\w.]+)/.exec(a) || /(webkit)[ \/]([\w.]+).*(version)[ \/]([\w.]+).*(safari)[ \/]([\w.]+)/.exec(a) || /(webkit)[ \/]([\w.]+)/.exec(a) || /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(a) || /(msie) ([\w.]+)/.exec(a) || a.indexOf("trident") >= 0 && /(rv)(?::| )([\w.]+)/.exec(a) || a.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(a) || [],
            c = /(ipad)/.exec(a) || /(ipod)/.exec(a) || /(windows phone)/.exec(a) || /(iphone)/.exec(a) || /(kindle)/.exec(a) || /(silk)/.exec(a) || /(android)/.exec(a) || /(win)/.exec(a) || /(mac)/.exec(a) || /(linux)/.exec(a) || /(cros)/.exec(a) || /(playbook)/.exec(a) || /(bb)/.exec(a) || /(blackberry)/.exec(a) || [],
            d = {},
            e = { browser: b[5] || b[3] || b[1] || "", version: b[2] || b[4] || "0", versionNumber: b[4] || b[2] || "0", platform: c[0] || "" }; if (e.browser && (d[e.browser] = !0, d.version = e.version, d.versionNumber = parseInt(e.versionNumber, 10)), e.platform && (d[e.platform] = !0), (d.android || d.bb || d.blackberry || d.ipad || d.iphone || d.ipod || d.kindle || d.playbook || d.silk || d["windows phone"]) && (d.mobile = !0), (d.cros || d.mac || d.linux || d.win) && (d.desktop = !0), (d.chrome || d.opr || d.safari) && (d.webkit = !0), d.rv || d.iemobile) { var f = "msie";
            e.browser = f, d[f] = !0 } if (d.edge) { delete d.edge; var g = "msedge";
            e.browser = g, d[g] = !0 } if (d.safari && d.blackberry) { var h = "blackberry";
            e.browser = h, d[h] = !0 } if (d.safari && d.playbook) { var i = "playbook";
            e.browser = i, d[i] = !0 } if (d.bb) { var j = "blackberry";
            e.browser = j, d[j] = !0 } if (d.opr) { var k = "opera";
            e.browser = k, d[k] = !0 } if (d.safari && d.android) { var l = "android";
            e.browser = l, d[l] = !0 } if (d.safari && d.kindle) { var m = "kindle";
            e.browser = m, d[m] = !0 } if (d.safari && d.silk) { var n = "silk";
            e.browser = n, d[n] = !0 } return d.name = e.browser, d.platform = e.platform, d } return window.jQBrowser = b(window.navigator.userAgent), window.jQBrowser.uaMatch = b, a && (a.browser = window.jQBrowser), window.jQBrowser });
/*color picker*/
(function($, h, j, k) { "use strict"; var l = 'wColorPicker';

    function Plugin(a, b) { this.element = a;
        this._name = l;
        this._defaults = $.fn.wColorPicker.defaults;
        this.options = $.extend({}, this._defaults, b);
        this.init() }
    $.extend(Plugin.prototype, { init: function() { var b = [];
            $.each(this.options.palette.map(function(x) { return x.toUpperCase() }), function(i, a) { if ($.inArray(a, b) === -1) { b.push(a) } });
            this.palette = b;
            this.bindEvents() }, bindEvents: function() { var c = this;
            $(c.element).on('click' + '.' + c._name, function(b) { b.preventDefault();
                c._show();
                $(".customColorHash", c._defaults.elementClass).val(c.color);
                $(c._defaults.elementClass).on('click', ' .item', function(a) { c.color = $(a.target).attr('hexValue');
                    c.callback();
                    c._appendToStorage($(a.target).attr('hexValue'));
                    c._onChange();
                    c._hide(); return false });
                $(c._defaults.elementClass).on('click', '.button.reset', function() { if ($(c.element).is("input")) { $(c.element).val('') } else { $(c.element).css({ 'backgroundColor': '', }) }
                    c._hide() });
                $(c._defaults.elementClass).on('click', '.button.apply', function() { var a = $('.customColorHash', c._defaults.elementClass);
                    c._testHash(a, true) });
                $(c._defaults.elementClass).on('keyup', '.customColorHash', function() { var a = $(this);
                    c._testHash(a, false) });
                $(c._defaults.elementClass).on('click', '.button[data-close]', function(a) { c._hide();
                    a.preventDefault() }); return false }) }, _show: function() { var c = this;
            $(c._defaults.elementClass).remove();
            $("body").append('<div data-duration="200" data-delay="20" class="wojo color picker animate"><h5>' + c.options.paletteLabel + '</h5></div>');
            jQuery.each(this.palette, function(a, b) { $(c._defaults.elementClass).append('<div class="item" hexValue="' + b + '" style="background:' + b + '"></div>') }); if (c.options.allowCustomColor === true) { $(c._defaults.elementClass).append('<div class="wojo mini input"><input type="text" class="customColorHash" /></div>') } if (c.options.allowRecent === true) { $(c._defaults.elementClass).append('<h5>' + c.options.recentLabel + '</h5>'); if (JSON.parse(localStorage.getItem("wColorRecentItems")) === null || JSON.parse(localStorage.getItem("wColorRecentItems")) === []) { $(c._defaults.elementClass).append('<div class="button colorPickDummy"></div>') } else { jQuery.each(JSON.parse(localStorage.getItem("wColorRecentItems")), function(a, b) { $(c._defaults.elementClass).append('<div class="item" hexValue="' + b + '" style="background:' + b + '"></div>'); if (a === c.options.recentMax - 1) { return false } }) } } var d = $(".item", c._defaults.elementClass); var e = c.options.rows; for (var i = 0; i < d.length; i += e) { d.slice(i, i + e).wrapAll("<div class='items'></div>") } var f = '<button type="button" class="wojo mini icon button reset"><i class="icon eraser"></i></button>'; var g = (c.options.allowCustomColor ? '<button type="button" class="wojo mini primary inverted button apply">Apply</button>' : '');
            $(c._defaults.elementClass).append('<div class="row align ' + (c.options.allowCustomColor ? 'spaced' : 'around') + '">' + g + f + '</div>');
            $(c._defaults.elementClass).prepend('<a class="wojo small icon simple button" data-close="true"><i class="icon close"></i></a>');
            c._setPosition();
            $(c._defaults.elementClass).addClass(c.options.inAnimation) }, _hide: function() { var a = this;
            $(a._defaults.elementClass).fadeOut(200, function() { $(a._defaults.elementClass).remove(); return this }) }, _appendToStorage: function(a) { var b = this; if (b.options.allowRecent === true) { var c = JSON.parse(localStorage.getItem("wColorRecentItems")); if (c === null) { c = [] } if ($.inArray(a, c) === -1) { c.unshift(a);
                    c = c.slice(0, b.options.recentMax);
                    localStorage.setItem("wColorRecentItems", JSON.stringify(c)) } } }, _onChange: function() { if ($(this.element).is("input")) { $(this.element).val(this.color);
                $(this.element).css("color", this.color) } else { $(this.element).css({ 'backgroundColor': this.color, }) } }, _testHash: function(a, b) { var c = this; var d = a.val(); if (d.indexOf('#') !== 0) { d = "#" + d } if (/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(d)) { c.color = d;
                c._appendToStorage(d);
                c._onChange();
                a.parent().removeClass('error');
                (b) ? c._hide(): '' } else { a.parent().addClass('error') } }, _setPosition: function() { var a = this,
                target, picker, wWidth, left;
            target = a._getElementOffset($(a.element));
            picker = a._getElementOffset($(a._defaults.elementClass));
            wWidth = $(h).width(); switch (a.options.alignment.toLowerCase()) {
                case 'tl':
                    left = target.l;
                    left = (parseInt(left + picker.w) >= wWidth) ? wWidth - picker.w : left;
                    $(a._defaults.elementClass).css({ left: left, top: target.t - (picker.h + 2) }); break;
                case 'tr':
                    left = (target.l + target.w) - picker.w;
                    left = (left <= 0) ? 16 : left;
                    $(a._defaults.elementClass).css({ left: left, top: target.t - (picker.h + 2) }); break;
                case 'br':
                    left = (target.l + target.w) - picker.w;
                    left = (left <= 0) ? 16 : left;
                    $(a._defaults.elementClass).css({ left: left, top: target.t + target.h + 2 }); break;
                default:
                    left = target.l;
                    left = (parseInt(left + picker.w) >= wWidth) ? wWidth - picker.w - 16 : left;
                    $(a._defaults.elementClass).css({ left: left, top: target.t + target.h + 2 }); break } }, _getElementOffset: function(a) { var o = []; var b = a.get(0);
            o.w = b.offsetWidth;
            o.h = b.offsetHeight;
            o.l = a.offset().left;
            o.t = a.offset().top; return o }, callback: function() { var a = this.options.onChangeColor; if (typeof a === 'function') { a.call(this.color, this.element) } } });
    $.fn.wColorPicker = function(a) { this.each(function() { if (!$.data(this, "plugin_" + l)) { $.data(this, "plugin_" + l, new Plugin(this, a)) } }); return this };
    $.fn.wColorPicker.defaults = { inAnimation: 'scaleIn', applyLabel: "Apply:", resetLabel: "Reset:", recentLabel: "Recent:", paletteLabel: 'Default Palette:', elementClass: ".wojo.color.picker", allowRecent: true, recentMax: 10, rows: 10, alignment: "bl", allowCustomColor: true, palette: ["#1abc9c", "#16a085", "#2ecc71", "#27ae60", "#3498db", "#2980b9", "#9b59b6", "#8e44ad", "#34495e", "#2c3e50", "#f1c40f", "#f39c12", "#e67e22", "#d35400", "#e74c3c", "#c0392b", "#ecf0f1", "#bdc3c7", "#95a5a6", "#7f8c8d"], onChangeColor: null } })(jQuery, window, document);
/*wNumber*/
(function($, d, f, g) { "use strict"; var h; var i = function(b, c) { this.$el = b;
        this.options = $.extend({}, i.rules.defaults, i.rules[c.rule] || {}, c);
        this.min = Number(this.options.min) || 0;
        this.max = Number(this.options.max) || 0;
        this.spinningTimer = null;
        this.$el.on({ 'focus.spinner': $.proxy(function(e) { e.preventDefault();
                $(f).trigger('mouseup.spinner');
                this.oldValue = this.value() }, this), 'change.spinner': $.proxy(function(e) { e.preventDefault();
                this.value(this.$el.val()) }, this), 'keydown.spinner': $.proxy(function(e) { var a = { 38: 'up', 40: 'down' }[e.which]; if (a) { e.preventDefault();
                    this.spin(a) } }, this) });
        this.oldValue = this.value();
        this.value(this.$el.val()); return this };
    i.rules = { defaults: { min: null, max: null, step: 1, precision: 0 }, currency: { min: 0.00, max: null, step: 0.01, precision: 2 }, quantity: { min: 1, max: 999, step: 1, precision: 0 }, percent: { min: 1, max: 100, step: 1, precision: 0 }, month: { min: 1, max: 12, step: 1, precision: 0 }, day: { min: 1, max: 31, step: 1, precision: 0 }, hour: { min: 0, max: 23, step: 1, precision: 0 }, minute: { min: 1, max: 59, step: 1, precision: 0 }, second: { min: 1, max: 59, step: 1, precision: 0 } };
    i.prototype = { spin: function(a) { if (this.$el.prop('disabled')) { return }
            this.oldValue = this.value(); var b = $.isFunction(this.options.step) ? this.options.step.call(this, a) : this.options.step; var c = a === 'up' ? 1 : -1;
            this.value(this.oldValue + Number(b) * c) }, value: function(v) { if (v === null || v === g) { return this.numeric(this.$el.val()) }
            v = this.numeric(v); var a = this.validate(v); if (a !== 0) { v = (a === -1) ? this.min : this.max }
            this.$el.val(v.toFixed(this.options.precision)); if (this.oldValue !== this.value()) { this.$el.trigger('changing.spinner', [this.value(), this.oldValue]);
                clearTimeout(this.spinningTimer);
                this.spinningTimer = setTimeout($.proxy(function() { this.$el.trigger('changed.spinner', [this.value(), this.oldValue]) }, this), h.delay) } }, numeric: function(v) { v = this.options.precision > 0 ? parseFloat(v, 10) : parseInt(v, 10); if (isFinite(v)) { return v } return v || this.options.min || 0 }, validate: function(a) { if (this.options.min !== null && a < this.min) { return -1 } if (this.options.max !== null && a > this.max) { return 1 } return 0 } };
    h = function(a, b) { this.$el = $(a);
        this.$spinning = this.$el.find('[data-spin="spinner"]'); if (this.$spinning.length === 0) { this.$spinning = this.$el.find('input[type="text"]') }
        b = $.extend({}, b, this.$spinning.data());
        this.spinning = new i(this.$spinning, b);
        this.$el.on('click.spinner', '[data-spin="up"], [data-spin="down"]', $.proxy(this, 'spin')).on('mousedown.spinner', '[data-spin="up"], [data-spin="down"]', $.proxy(this, 'spin'));
        $(f).on('mouseup.spinner', $.proxy(function() { clearTimeout(this.spinTimeout);
            clearInterval(this.spinInterval) }, this)); if (b.delay) { this.delay(b.delay) } if (b.changed) { this.changed(b.changed) } if (b.changing) { this.changing(b.changing) } };
    h.delay = 500;
    h.prototype = { constructor: h, spin: function(e) { var a = $(e.currentTarget).data('spin'); switch (e.type) {
                case 'click':
                    e.preventDefault();
                    this.spinning.spin(a); break;
                case 'mousedown':
                    if (e.which === 1) { this.spinTimeout = setTimeout($.proxy(this, 'beginSpin', a), 300) } break } }, delay: function(a) { var b = Number(a); if (b >= 0) { this.constructor.delay = b + 100 } }, value: function() { return this.spinning.value() }, changed: function(a) { this.bindHandler('changed.spinner', a) }, changing: function(a) { this.bindHandler('changing.spinner', a) }, bindHandler: function(t, a) { if ($.isFunction(a)) { this.$spinning.on(t, a) } else { this.$spinning.off(t) } }, beginSpin: function(a) { this.spinInterval = setInterval($.proxy(this.spinning, 'spin', a), 100) } }; var j = $.fn.wNumber;
    $.fn.wNumber = function(b, c) { return this.each(function() { var a = $.data(this, 'spinner'); if (!a) { a = new h(this, b);
                $.data(this, 'spinner', a) } if (b === 'delay' || b === 'changed' || b === 'changing') { a[b](c) } else if (b === 'step' && c) { a.spinning.step = c } else if (b === 'spin' && c) { a.spinning.spin(c) } }) };
    $.fn.wNumber.Constructor = h;
    $.fn.wNumber.noConflict = function() { $.fn.wNumber = j; return this }; return $.fn.wNumber })(jQuery, window, document);
/*! wRange.js - v2.3.2 | (c) 2018 @andreruffert | MIT license | https://github.com/andreruffert/wRange.js */
(function(factory) { 'use strict'; if (typeof define === 'function' && define.amd) { define(['jquery'], factory) } else if (typeof exports === 'object') { module.exports = factory(require('jquery')) } else { factory(jQuery) } }(function($) { 'use strict';
    Number.isNaN = Number.isNaN || function(value) { return typeof value === 'number' && value !== value };

    function supportsRange() { var input = document.createElement('input');
        input.setAttribute('type', 'range'); return input.type !== 'text' } var pluginName = 'wRange',
        pluginIdentifier = 0,
        hasInputRangeSupport = supportsRange(),
        defaults = { polyfill: false, orientation: 'horizontal', rangeClass: 'wojo range', disabledClass: 'disabled', activeClass: 'active', horizontalClass: 'horizontal', verticalClass: 'vertical', fillClass: 'fill', labelsClass: 'labels', labelClass: 'label', handleClass: 'handle', startEvent: ['mousedown', 'touchstart', 'pointerdown'], moveEvent: ['mousemove', 'touchmove', 'pointermove'], endEvent: ['mouseup', 'touchend', 'pointerup'] },
        constants = { orientation: { horizontal: { dimension: 'width', direction: 'left', directionStyle: 'left', coordinate: 'x' }, vertical: { dimension: 'height', direction: 'top', directionStyle: 'bottom', coordinate: 'y' } } };

    function delay(fn, wait) { var args = Array.prototype.slice.call(arguments, 2); return setTimeout(function() { return fn.apply(null, args) }, wait) }

    function debounce(fn, debounceDuration) { debounceDuration = debounceDuration || 100; return function() { if (!fn.debouncing) { var args = Array.prototype.slice.apply(arguments);
                fn.lastReturnVal = fn.apply(window, args);
                fn.debouncing = true }
            clearTimeout(fn.debounceTimeout);
            fn.debounceTimeout = setTimeout(function() { fn.debouncing = false }, debounceDuration); return fn.lastReturnVal } }

    function isHidden(element) { return (element && (element.offsetWidth === 0 || element.offsetHeight === 0 || element.open === false)) }

    function getHiddenParentNodes(element) { var parents = [],
            node = element.parentNode; while (isHidden(node)) { parents.push(node);
            node = node.parentNode } return parents }

    function getDimension(element, key) { var hiddenParentNodes = getHiddenParentNodes(element),
            hiddenParentNodesLength = hiddenParentNodes.length,
            inlineStyle = [],
            dimension = element[key];

        function toggleOpenProperty(element) { if (typeof element.open !== 'undefined') { element.open = (element.open) ? false : true } } if (hiddenParentNodesLength) { for (var i = 0; i < hiddenParentNodesLength; i++) { inlineStyle[i] = hiddenParentNodes[i].style.cssText; if (hiddenParentNodes[i].style.setProperty) { hiddenParentNodes[i].style.setProperty('display', 'block', 'important') } else { hiddenParentNodes[i].style.cssText += ';display: block !important' }
                hiddenParentNodes[i].style.height = '0';
                hiddenParentNodes[i].style.overflow = 'hidden';
                hiddenParentNodes[i].style.visibility = 'hidden';
                toggleOpenProperty(hiddenParentNodes[i]) }
            dimension = element[key]; for (var j = 0; j < hiddenParentNodesLength; j++) { hiddenParentNodes[j].style.cssText = inlineStyle[j];
                toggleOpenProperty(hiddenParentNodes[j]) } } return dimension }

    function tryParseFloat(str, defaultValue) { var value = parseFloat(str); return Number.isNaN(value) ? defaultValue : value }

    function ucfirst(str) { return str.charAt(0).toUpperCase() + str.substr(1) }

    function Plugin(element, options) { this.$window = $(window);
        this.$document = $(document);
        this.$element = $(element);
        this.options = $.extend({}, defaults, options);
        this.polyfill = this.options.polyfill;
        this.orientation = this.$element[0].getAttribute('data-orientation') || this.options.orientation;
        this.onInit = this.options.onInit;
        this.onSlide = this.options.onSlide;
        this.onSlideEnd = this.options.onSlideEnd;
        this.DIMENSION = constants.orientation[this.orientation].dimension;
        this.DIRECTION = constants.orientation[this.orientation].direction;
        this.DIRECTION_STYLE = constants.orientation[this.orientation].directionStyle;
        this.COORDINATE = constants.orientation[this.orientation].coordinate; if (this.polyfill) { if (hasInputRangeSupport) { return false } }
        this.identifier = pluginName + '-' + (pluginIdentifier++);
        this.startEvent = this.options.startEvent.join('.' + this.identifier + ' ') + '.' + this.identifier;
        this.moveEvent = this.options.moveEvent.join('.' + this.identifier + ' ') + '.' + this.identifier;
        this.endEvent = this.options.endEvent.join('.' + this.identifier + ' ') + '.' + this.identifier;
        this.toFixed = (this.step + '').replace('.', '').length - 1;
        this.$fill = $('<div class="' + this.options.fillClass + '" />');
        this.$handle = $('<div class="' + this.options.handleClass + '" />');
        this.$range = $('<div class="' + this.options.rangeClass + ' ' + this.options[this.orientation + 'Class'] + '" id="' + this.identifier + '" />').insertAfter(this.$element).prepend(this.$fill, this.$handle); var _this = this; if (typeof this.$element.attr("class") !== "undefined" && this.$element.attr("class") !== false) { this.$range.addClass(this.$element.attr("class")) } if (typeof this.$element.attr("data-labels") !== "undefined" && this.$element.attr("data-labels") !== false) { var rangeLabels = this.$element.attr('data-labels');
            rangeLabels = rangeLabels.split(',');
            this.$range.append('<div class="' + this.options.labelsClass + '"></div>'); var $el = this.$range;
            $(rangeLabels).each(function(index, value) { $el.find('.' + _this.options.labelsClass).append('<span class="' + _this.options.labelClass + '">' + value + '</span>') }) } var suffix = ''; if (typeof this.$element.attr("data-suffix") !== "undefined" && this.$element.attr("data-suffix") !== false) { suffix = '<div class="counter"><span>0</span>' + this.$element.attr("data-suffix") + '</div>' } else { suffix = '<div class="counter"><span>0</span></div>' }
        this.$range.prepend(suffix);
        this.$element.css({ 'opacity': '0' });
        this.handleDown = $.proxy(this.handleDown, this);
        this.handleMove = $.proxy(this.handleMove, this);
        this.handleEnd = $.proxy(this.handleEnd, this);
        this.init();
        this.$window.on('resize.' + this.identifier, debounce(function() { delay(function() { _this.update(false, false) }, 300) }, 20));
        this.$document.on(this.startEvent, '#' + this.identifier + ':not(.' + this.options.disabledClass + ')', this.handleDown);
        this.$element.on('change.' + this.identifier, function(e, data) { if (data && data.origin === _this.identifier) { return } var value = e.target.value,
                pos = _this.getPositionFromValue(value);
            _this.setPosition(pos) });
        this.$range.find('.counter span').text(this.value) }
    Plugin.prototype.init = function() { this.update(true, false); if (this.onInit && typeof this.onInit === 'function') { this.onInit() } };
    Plugin.prototype.update = function(updateAttributes, triggerSlide) { updateAttributes = updateAttributes || false; if (updateAttributes) { this.min = tryParseFloat(this.$element[0].getAttribute('min'), 0);
            this.max = tryParseFloat(this.$element[0].getAttribute('max'), 100);
            this.value = tryParseFloat(this.$element[0].value, Math.round(this.min + (this.max - this.min) / 2));
            this.step = tryParseFloat(this.$element[0].getAttribute('step'), 1) }
        this.handleDimension = getDimension(this.$handle[0], 'offset' + ucfirst(this.DIMENSION));
        this.rangeDimension = getDimension(this.$range[0], 'offset' + ucfirst(this.DIMENSION));
        this.maxHandlePos = this.rangeDimension - this.handleDimension;
        this.grabPos = this.handleDimension / 2;
        this.position = this.getPositionFromValue(this.value); if (this.$element[0].disabled) { this.$range.addClass(this.options.disabledClass) } else { this.$range.removeClass(this.options.disabledClass) }
        this.setPosition(this.position, triggerSlide) };
    Plugin.prototype.handleDown = function(e) { e.preventDefault(); if (e.button && e.button !== 0) { return }
        this.$document.on(this.moveEvent, this.handleMove);
        this.$document.on(this.endEvent, this.handleEnd);
        this.$range.addClass(this.options.activeClass); if ((' ' + e.target.className + ' ').replace(/[\n\t]/g, ' ').indexOf(this.options.handleClass) > -1) { return } var pos = this.getRelativePosition(e),
            rangePos = this.$range[0].getBoundingClientRect()[this.DIRECTION],
            handlePos = this.getPositionFromNode(this.$handle[0]) - rangePos,
            setPos = (this.orientation === 'vertical') ? (this.maxHandlePos - (pos - this.grabPos)) : (pos - this.grabPos);
        this.setPosition(setPos); if (pos >= handlePos && pos < handlePos + this.handleDimension) { this.grabPos = pos - handlePos } };
    Plugin.prototype.handleMove = function(e) { e.preventDefault(); var pos = this.getRelativePosition(e); var setPos = (this.orientation === 'vertical') ? (this.maxHandlePos - (pos - this.grabPos)) : (pos - this.grabPos);
        this.setPosition(setPos);
        this.$range.find('.counter span').text(this.value) };
    Plugin.prototype.handleEnd = function(e) { e.preventDefault();
        this.$document.off(this.moveEvent, this.handleMove);
        this.$document.off(this.endEvent, this.handleEnd);
        this.$range.removeClass(this.options.activeClass);
        this.$element.trigger('change', { origin: this.identifier }); if (this.onSlideEnd && typeof this.onSlideEnd === 'function') { this.onSlideEnd(this.position, this.value) }
        this.$range.find('.counter span').text(this.value) };
    Plugin.prototype.cap = function(pos, min, max) { if (pos < min) { return min } if (pos > max) { return max } return pos };
    Plugin.prototype.setPosition = function(pos, triggerSlide) { var value, newPos; if (triggerSlide === undefined) { triggerSlide = true }
        value = this.getValueFromPosition(this.cap(pos, 0, this.maxHandlePos));
        newPos = this.getPositionFromValue(value);
        this.$fill[0].style[this.DIMENSION] = (newPos + this.grabPos) + 'px';
        this.$handle[0].style[this.DIRECTION_STYLE] = newPos + 'px';
        this.setValue(value);
        this.position = newPos;
        this.value = value; if (triggerSlide && this.onSlide && typeof this.onSlide === 'function') { this.onSlide(newPos, value) } };
    Plugin.prototype.getPositionFromNode = function(node) { var i = 0; while (node !== null) { i += node.offsetLeft;
            node = node.offsetParent } return i };
    Plugin.prototype.getRelativePosition = function(e) { var ucCoordinate = ucfirst(this.COORDINATE),
            rangePos = this.$range[0].getBoundingClientRect()[this.DIRECTION],
            pageCoordinate = 0; if (typeof e.originalEvent['client' + ucCoordinate] !== 'undefined') { pageCoordinate = e.originalEvent['client' + ucCoordinate] } else if (e.originalEvent.touches && e.originalEvent.touches[0] && typeof e.originalEvent.touches[0]['client' + ucCoordinate] !== 'undefined') { pageCoordinate = e.originalEvent.touches[0]['client' + ucCoordinate] } else if (e.currentPoint && typeof e.currentPoint[this.COORDINATE] !== 'undefined') { pageCoordinate = e.currentPoint[this.COORDINATE] } return pageCoordinate - rangePos };
    Plugin.prototype.getPositionFromValue = function(value) { var percentage, pos;
        percentage = (value - this.min) / (this.max - this.min);
        pos = (!Number.isNaN(percentage)) ? percentage * this.maxHandlePos : 0; return pos };
    Plugin.prototype.getValueFromPosition = function(pos) { var percentage, value;
        percentage = ((pos) / (this.maxHandlePos || 1));
        value = this.step * Math.round(percentage * (this.max - this.min) / this.step) + this.min; return Number((value).toFixed(this.toFixed)) };
    Plugin.prototype.setValue = function(value) { if (value === this.value && this.$element[0].value !== '') { return }
        this.$element.val(value).trigger('input', { origin: this.identifier }) };
    Plugin.prototype.destroy = function() { this.$document.off('.' + this.identifier);
        this.$window.off('.' + this.identifier);
        this.$element.off('.' + this.identifier).removeAttr('style').removeData('plugin_' + pluginName); if (this.$range && this.$range.length) { this.$range[0].parentNode.removeChild(this.$range[0]) } };
    $.fn[pluginName] = function(options) { var args = Array.prototype.slice.call(arguments, 1); return this.each(function() { var $this = $(this),
                data = $this.data('plugin_' + pluginName); if (!data) { $this.data('plugin_' + pluginName, (data = new Plugin(this, options))) } if (typeof options === 'string') { data[options].apply(data, args) } }) }; return 'wRange.js is available in jQuery context e.g $(selector).wRange(options);' }));
/*wDatePicker*/
(function(t, $, u) { "use strict";
    (function() { Date.prototype.getDaysCount = function() { return new Date(this.getFullYear(), this.getMonth() + 1, 0).getDate() }; var s = [9, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123],
            DCAL_DATA = '_wDate',
            wDatePicker = function(a, b) { var _ = this;
                _.animating = false;
                _.visible = false;
                _.input = $(a);
                _.config = b;
                _.viewMode = 'calendar';
                _.datepicker = { container: $('<div class="wojo calendar"></div>'), wrapper: $('<div class="container"></div>'), header: { wrapper: $('<section class="header"></section>'), selectedYear: $('<span class="current year"></span>'), selectedDate: $('<span class="current date"></span>') }, calendarHolder: { wrapper: $('<section class="content"></section>'), btnPrev: $('<span class="prev link"><i class="icon chevron left"></i></span>'), btnNext: $('<span class="next link"><i class="icon chevron right"></i></span>'), calendarViews: { wrapper: $('<div class="views"></div>'), calendars: [] }, yearsView: $('<div class="years is-hidden"></div>'), monthsView: $('<div class="months is-hidden"></div>'), buttons: { wrapper: $('<div class="actions"></div>'), btnClear: $('<button type="button" class="button clear">' + _.config.clearBtnLabel + '</button>'), btnToday: $('<button type="button" class="button today">' + _.config.todayBtnLabel + '</button>'), btnCancel: $('<button type="button" class="button cancel">' + _.config.cancelBtnLabel + '</button>'), btnOk: $('<button type="button" class="button ok">' + _.config.okBtnLabel + '</button>') } } };
                _.date = _.input.val() === '' ? new Date() : _.parseDate(_.input.val()).date;
                _.selected = { year: _.date.getFullYear(), month: _.date.getMonth(), date: _.date.getDate() };
                _.viewMonth = _.selected.month;
                _.viewYear = _.selected.year;
                _.minDate = _.input.data('mindate') || _.config.minDate;
                _.maxDate = _.input.data('maxdate') || _.config.maxDate;
                _.rangeFromEl = _.input.data('rangefrom') || _.config.rangeFrom;
                _.rangeToEl = _.input.data('rangeto') || _.config.rangeTo; if (a.nodeName === 'INPUT') { this.elIsInput = true } var c = _.input.prop("name"); var d = _.input.val(); if (this.elIsInput) { if (!$('input[name="' + c + '_submit"]').length) { $('<input>', { type: "hidden", name: c + '_submit', value: d, }).insertAfter(_.input) } }
                _.setupPicker();
                _.setSelection() };
        wDatePicker.prototype = { constructor: wDatePicker, setupPicker: function() { var _ = this,
                    picker = _.datepicker,
                    header = picker.header,
                    calendarHolder = picker.calendarHolder,
                    buttons = calendarHolder.buttons;
                header.wrapper.append(header.selectedYear).append(header.selectedDate).appendTo(picker.wrapper); var b = 0; for (var r = 1; r < 4; r++) { var c = $('<div class="month-row"></div>'); for (var i = 0; i < 4; i++) { var d = $('<span class="month"></span>'); if (b === _.selected.month) { d.addClass('selected') }
                        d.text(_.config.short_months[b]).data('month', b).appendTo(c).on('click', function() { var a = $(this),
                                _data = a.data('month');
                            _.viewMonth = _data;
                            _.setupCalendar();
                            _.switchView('calendar') });
                        b++ }
                    calendarHolder.monthsView.append(c) }
                calendarHolder.yearsView.html(_.getYears()); if (_.config.clearBtn) { buttons.wrapper.append(buttons.btnClear) } if (_.config.todayBtn) { buttons.wrapper.append(buttons.btnToday) } if (_.config.cancelBtn) { buttons.wrapper.append(buttons.btnCancel) } if (!_.config.auto) { buttons.wrapper.append(buttons.btnOk) }
                calendarHolder.wrapper.append(calendarHolder.btnPrev).append(calendarHolder.btnNext).append(calendarHolder.calendarViews.wrapper).append(calendarHolder.monthsView).append(calendarHolder.yearsView).append(buttons.wrapper).appendTo(picker.wrapper);
                picker.container.append(picker.wrapper).appendTo('body');
                _.input.on('click', function() { _.show() }).on('keydown', function(e) { if (e.keyCode === 13) { _.show() } return !(s.indexOf(e.which) < 0) }).prop('readonly', true);
                header.selectedYear.click(function() { if (_.viewMode !== 'years') { _.switchView('years') } });
                header.selectedDate.click(function() { if ((_.viewMonth !== _.selected.month || _.viewYear !== _.selected.year) || _.viewMode !== 'calendar') { _.viewMonth = _.selected.month;
                        _.viewYear = _.selected.year;
                        _.setupCalendar();
                        _.switchView('calendar') } });
                calendarHolder.btnPrev.click(function() { _.move('prev') });
                calendarHolder.btnNext.click(function() { _.move('next') });
                calendarHolder.calendarViews.wrapper.on('click', '.heading', function() { if (_.viewMode !== 'months') { _.switchView('months') } }); if (_.config.clearBtn) { buttons.btnClear.click(function() { var a = new Date();
                        _.date = a;
                        _.input.val('').attr('value', '');
                        _.triggerChange($.Event('datechanged', { date: null }));
                        _.hide(); if ($('input[name="' + _.input.prop("name") + '_submit"]').length) { $('input[name="' + _.input.prop("name") + '_submit"]').val('') } }) } if (_.config.todayBtn) { buttons.btnToday.click(function() { var a = new Date();
                        _.date = a;
                        _.setValue(_.date);
                        _.hide() }) } if (_.config.overlayClose) { picker.container.click(function() { _.hide() });
                    picker.wrapper.click(function(e) { e.stopPropagation() }) } if (_.config.cancelBtn) { buttons.btnCancel.click(function() { _.hide() }) }
                buttons.btnOk.click(function() { var a = new Date(_.selected.year, _.selected.month, _.selected.date); if (_.disabledDate(a)) { return }
                    _.date = a;
                    _.setValue(_.date);
                    _.hide() }) }, getDates: function(j, k) { var _ = this,
                    day = 1,
                    now = new Date(),
                    today = new Date(now.getFullYear(), now.getMonth(), now.getDate()),
                    selected = new Date(_.selected.year, _.selected.month, _.selected.date),
                    date = new Date(j, k, day),
                    totalDays = date.getDaysCount(),
                    nmStartDay = 1,
                    weeks = []; for (var l = 1; l <= 6; l++) { var m = [$('<span class="item"></span>'), $('<span class="item"></span>'), $('<span class="item"></span>'), $('<span class="item"></span>'), $('<span class="item"></span>'), $('<span class="item"></span>'), $('<span class="item"></span>')]; while (day <= totalDays) { date.setDate(day); var n = date.getDay();
                        m[n].data('date', day).data('month', k).data('year', j); if (date.getTime() === today.getTime()) { m[n].addClass('current') } if (_.disabledDate(date)) { m[n].addClass('disabled') } if (l === 1 && n === 0) { break } else if (n < 6) { if (date.getTime() === selected.getTime()) { m[n].addClass('selected') }
                            m[n].text(day++) } else { if (date.getTime() === selected.getTime()) { m[n].addClass('selected') }
                            m[n].text(day++); break } } if (l === 1 || l > 4) { if (l === 1) { var o = new Date(j, k - 1, 1),
                                prevMonthDays = o.getDaysCount(); for (var a = 6; a >= 0; a--) { if (m[a].text() !== '') { continue }
                                m[a].data('date', prevMonthDays).data('month', k - 1).data('year', j);
                                o.setDate(prevMonthDays);
                                m[a].text((prevMonthDays--)).addClass('pm'); if (_.disabledDate(o)) { m[a].addClass('disabled') } if (o.getTime() === selected.getTime()) { m[a].addClass('selected') } if (o.getTime() === today.getTime()) { m[a].addClass('current') } } } else if (l > 4) { var p = new Date(j, k + 1, 1); for (var b = 0; b <= 6; b++) { if (m[b].text() !== '') { continue }
                                m[b].data('date', nmStartDay).data('month', k + 1).data('year', j);
                                p.setDate(nmStartDay);
                                m[b].text((nmStartDay++)).addClass('nm'); if (_.disabledDate(p)) { m[b].addClass('disabled') } if (p.getTime() === selected.getTime()) { m[b].addClass('selected') } if (p.getTime() === today.getTime()) { m[b].addClass('current') } } } }
                    weeks.push(m) } var q = [];
                $.each(weeks, function(e, f) { var g = $('<div class="week"></div>'); for (var i = 0; i < f.length; i++) { var h = f[i];
                        h.click(function() { var d = $(this),
                                _year = d.data('year'),
                                _month = d.data('month'),
                                _date = d.data('date'),
                                _selected = new Date(_year, _month, _date); if (_.disabledDate(_selected)) { return }
                            d.parents('.views').find('.item').each(function(a, b) { var c = $(b).data('year'),
                                    _deMonth = $(b).data('month'),
                                    _deDate = $(b).data('date');
                                $(b)[(_year === c && _month === _deMonth && _date === _deDate) ? 'addClass' : 'removeClass']('selected') });
                            d.parents('.dudp__cal-container').find('.month').each(function(a, b) { var c = $(b).data('month');
                                $(b)[c === _month ? 'addClass' : 'removeClass']('selected') });
                            d.addClass('selected');
                            _.selected = { year: _year, month: _month, date: _date };
                            _.setSelection(); if (_.config.auto) { _.date = _selected;
                                _.setValue(_.date);
                                _.hide() } });
                        g.append(h) }
                    q.push(g) }); return q }, getYears: function() { var _ = this,
                    _minYear = _.viewYear - 100,
                    _maxYear = _.viewYear + 100,
                    _years = []; for (var y = _minYear; y <= _maxYear; y++) { var b = $('<span class="year"></span>'); if (y === _.viewYear) { b.addClass('selected') }
                    b.text(y).data('year', y).on('click', function() { var a = $(this),
                            _data = a.data('year');
                        _.viewYear = _data;
                        _.selected.year = _data;
                        _.setSelection();
                        _.setupCalendar();
                        _.switchView('calendar') });
                    _years.push(b) } return _years }, setupCalendar: function() { var _ = this,
                    viewsHolder = _.datepicker.calendarHolder.calendarViews,
                    _year = _.viewYear,
                    _month = _.viewMonth; var a = "<span>" + _.config.days_min.map(function(x) { return x }).join("</span><span>") + "</span>";
                viewsHolder.calendars.length = 0; var b = { wrapper: $('<div class="sections"></div>'), header: $('<div class="heading"></div>'), weekDays: $('<div class="weekdays">' + a + '</div>'), datesHolder: $('<div class="dates"></div>') },
                    prev = { wrapper: $('<div class="sections"></div>'), header: $('<div class="heading"></div>'), weekDays: $('<div class="weekdays">' + a + '</div>'), datesHolder: $('<div class="dates"></div>') },
                    next = { wrapper: $('<div class="sections"></div>'), header: $('<div class="heading"></div>'), weekDays: $('<div class="weekdays">' + a + '</div>'), datesHolder: $('<div class="dates"></div>') };
                prev.header.text(_.formatDate(new Date(_year, _month - 1, 1), _.config.month_head_format)).appendTo(prev.wrapper);
                prev.wrapper.append(prev.weekDays);
                prev.datesHolder.html(_.getDates(_year, _month - 1)).appendTo(prev.wrapper);
                viewsHolder.calendars.push(prev);
                b.header.text(_.formatDate(new Date(_year, _month, 1), _.config.month_head_format)).appendTo(b.wrapper);
                b.wrapper.append(b.weekDays);
                b.datesHolder.html(_.getDates(_year, _month)).appendTo(b.wrapper);
                viewsHolder.calendars.push(b);
                next.header.text(_.formatDate(new Date(_year, _month + 1, 1), _.config.month_head_format)).appendTo(next.wrapper);
                next.wrapper.append(next.weekDays);
                next.datesHolder.html(_.getDates(_year, _month + 1)).appendTo(next.wrapper);
                viewsHolder.calendars.push(next);
                viewsHolder.wrapper.empty().append(prev.wrapper).append(b.wrapper).append(next.wrapper) }, move: function(a) { if (a !== 'next' && a !== 'prev') { return } if (this.animating) { return } var _ = this,
                    picker = _.datepicker,
                    viewsHolder = picker.calendarHolder.calendarViews,
                    _animDuration = 250,
                    _isNext = a === 'next'; var b = "<span>" + _.config.days_min.map(function(x) { return x }).join("</span><span>") + "</span>"; if (_isNext ? _.viewMonth + 1 > 11 : _.viewMonth - 1 < 0) { _.viewYear += (_isNext ? 1 : -1) }
                _.viewMonth = _isNext ? (_.viewMonth + 1 > 11 ? 0 : _.viewMonth + 1) : (_.viewMonth - 1 < 0 ? 11 : _.viewMonth - 1);
                _.animating = true; var c = 'animate-' + (_isNext ? 'left' : 'right');
                viewsHolder.wrapper.find('.sections').addClass(c); var d = _.viewYear,
                    _month = _isNext ? _.viewMonth + 1 : _.viewMonth - 1; if (_isNext ? _month > 11 : _month < 0) { _month = _isNext ? 0 : 11;
                    d += _isNext ? 1 : -1 } var e = _.getDates(d, _month),
                    newCalEl = { wrapper: $('<div class="sections"></div>'), header: $('<div class="heading"></div>'), weekDays: $('<div class="weekdays">' + b + '</div>'), datesHolder: $('<div class="dates"></div>') };
                newCalEl.header.text(_.formatDate(new Date(d, _month, 1), _.config.month_head_format)).appendTo(newCalEl.wrapper);
                newCalEl.wrapper.append(newCalEl.weekDays);
                newCalEl.datesHolder.html(e).appendTo(newCalEl.wrapper);
                setTimeout(function() { viewsHolder.wrapper[_isNext ? 'append' : 'prepend'](newCalEl.wrapper);
                    viewsHolder.wrapper.find('.sections').removeClass(c);
                    viewsHolder.calendars[_isNext ? 0 : 2].wrapper.remove();
                    viewsHolder.calendars[_isNext ? 'shift' : 'pop']();
                    viewsHolder.calendars[_isNext ? 'push' : 'unshift'](newCalEl);
                    _.animating = false }, _animDuration) }, switchView: function(a) { if (a !== 'calendar' && a !== 'months' && a !== 'years') { return } var _ = this,
                    picker = _.datepicker,
                    monthsView = picker.calendarHolder.monthsView,
                    yearsView = picker.calendarHolder.yearsView,
                    calViews = picker.calendarHolder.calendarViews.wrapper,
                    _animDuration = 250;
                _.viewMode = a; switch (a) {
                    case 'calendar':
                        calViews.addClass('is-out').removeClass('is-hidden');
                        picker.calendarHolder.btnPrev.removeClass('is-hidden');
                        picker.calendarHolder.btnNext.removeClass('is-hidden');
                        setTimeout(function() { calViews.removeClass('is-out') }, 10);
                        monthsView.addClass('is-out');
                        yearsView.addClass('is-hidden');
                        setTimeout(function() { monthsView.addClass('is-hidden').removeClass('is-out') }, _animDuration); break;
                    case 'months':
                        picker.calendarHolder.btnPrev.addClass('is-hidden');
                        picker.calendarHolder.btnNext.addClass('is-hidden');
                        calViews.addClass('is-out');
                        monthsView.addClass('is-out').removeClass('is-hidden');
                        setTimeout(function() { monthsView.removeClass('is-out') }, 10);
                        setTimeout(function() { calViews.addClass('is-hidden').removeClass('is-out') }, _animDuration); break;
                    case 'years':
                        yearsView.html(_.getYears()); var b = yearsView.find('.year.selected');
                        yearsView.scrollTop(b[0].offsetTop - 120);
                        picker.calendarHolder.btnPrev.addClass('is-hidden');
                        picker.calendarHolder.btnNext.addClass('is-hidden');
                        monthsView.addClass('is-out');
                        calViews.addClass('is-out');
                        yearsView.removeClass('is-hidden');
                        setTimeout(function() { calViews.addClass('is-hidden').removeClass('is-out');
                            monthsView.addClass('is-hidden').removeClass('is-out') }, _animDuration); break } }, resetSelection: function() { var _ = this;
                _.selected = { year: _.date.getFullYear(), month: _.date.getMonth(), date: _.date.getDate() };
                _.viewYear = _.selected.year;
                _.viewMonth = _.selected.month;
                _.datepicker.calendarHolder.monthsView.find('.month').each(function(a, b) { var c = $(b).data('month');
                    $(b)[c === _.selected.month ? 'addClass' : 'removeClass']('selected') }) }, setSelection: function() { var _ = this,
                    picker = _.datepicker,
                    selected = new Date(_.selected.year, _.selected.month, _.selected.date);
                picker.header.selectedYear.text(selected.getFullYear());
                picker.header.selectedDate.text(_.formatDate(selected, _.config.selected_format)) }, setValue: function(a) { if (typeof a === 'undefined') { throw new Error('Expecting a value.'); } var b = typeof a === 'string' ? this.parseDate(a, this.config.format).date : a,
                    formatted = this.formatDate(b, this.config.format),
                    submit_formatted = this.formatDate(b, this.config.format_submit);
                this.date = b;
                this.viewYear = b.getFullYear();
                this.viewMonth = b.getMonth();
                this.input.val(formatted).attr('value', formatted); if ($('input[name="' + this.input.prop("name") + '_submit"]').length) { $('input[name="' + this.input.prop("name") + '_submit"]').val(submit_formatted) }
                this.triggerChange($.Event('datechanged', { date: this.formatDate(this.date, this.config.outFormat || this.config.format) })) }, triggerChange: function(a) { this.input.trigger(a).trigger('onchange').trigger('change') }, parseDate: function(a, b) { var _ = this,
                    format = typeof b === 'undefined' ? _.config.format : b,
                    dayLength = (format.match(/d/g) || []).length,
                    monthLength = (format.match(/m/g) || []).length,
                    yearLength = (format.match(/y/g) || []).length,
                    isFullMonth = monthLength === 4,
                    isMonthNoPadding = monthLength === 1,
                    isDayNoPadding = dayLength === 1,
                    lastIndex = a.length,
                    firstM = format.indexOf('m'),
                    firstD = format.indexOf('d'),
                    firstY = format.indexOf('y'),
                    month = '',
                    day = '',
                    year = ''; if (a === '') { return { m: null, d: null, y: null, date: new Date('') } } if (isFullMonth) { var c = -1;
                    $.each(_.config.months, function(i, m) { if (a.indexOf(m) >= 0) { c = i } });
                    month = _.config.months[c];
                    format = format.replace('mmmm', month);
                    firstD = format.indexOf('d');
                    firstY = firstY < firstM ? format.indexOf('y') : format.indexOf('y', format.indexOf(month) + month.length) } else if (!isDayNoPadding && !isMonthNoPadding || (isDayNoPadding && !isMonthNoPadding && firstM < firstD)) { month = a.substr(firstM, monthLength) } else { var d = format.lastIndexOf('m'),
                        before = format.substring(firstM - 1, firstM),
                        after = format.substring(d + 1, d + 2); if (d === format.length - 1) { month = a.substring(a.indexOf(before, firstM - 1) + 1, lastIndex) } else if (firstM === 0) { month = a.substring(0, a.indexOf(after, firstM)) } else { month = a.substring(a.indexOf(before, firstM - 1) + 1, a.indexOf(after, firstM + 1)) } } if (!isDayNoPadding && !isMonthNoPadding || (!isDayNoPadding && isMonthNoPadding && firstD < firstM)) { day = a.substr(firstD, dayLength) } else { var e = format.lastIndexOf('d'),
                        before = format.substring(firstD - 1, firstD),
                        after = format.substring(e + 1, e + 2); if (e === format.length - 1) { day = a.substring(a.indexOf(before, firstD - 1) + 1, lastIndex) } else if (firstD === 0) { day = a.substring(0, a.indexOf(after, firstD)) } else { day = a.substring(a.indexOf(before, firstD - 1) + 1, a.indexOf(after, firstD + 1)) } } if (!isMonthNoPadding && !isDayNoPadding || (isMonthNoPadding && isDayNoPadding && firstY < firstM && firstY < firstD) || (!isMonthNoPadding && isDayNoPadding && firstY < firstD) || (isMonthNoPadding && !isDayNoPadding && firstY < firstM)) { year = a.substr(firstY, yearLength) } else { before = format.substring(firstY - 1, firstY);
                    year = a.substr(a.indexOf(before, firstY - 1) + 1, yearLength) } return { m: month, d: day, y: year, date: isNaN(parseInt(month)) ? new Date(month + " " + day + ", " + year) : new Date(year, month - 1, day) } }, formatDate: function(a, b) { var _ = this,
                    d = new Date(a),
                    day = d.getDate(),
                    m = d.getMonth(),
                    y = d.getFullYear(); return b.replace(/(yyyy|yy|mmmm|mmm|mm|m|DD|D|dd|d)/g, function(e) { switch (e) {
                        case 'd':
                            return day;
                        case 'dd':
                            return (day < 10 ? "0" + day : day);
                        case 'D':
                            return _.config.short_days[d.getDay()];
                        case 'DD':
                            return _.config.days_of_week[d.getDay()];
                        case 'm':
                            return m + 1;
                        case 'mm':
                            return (m + 1 < 10 ? "0" + (m + 1) : (m + 1));
                        case 'mmm':
                            return _.config.short_months[m];
                        case 'mmmm':
                            return _.config.months[m];
                        case 'yy':
                            return y.toString().substr(2, 2);
                        case 'yyyy':
                            return y } }) }, disabledDate: function(a) { var _ = this,
                    rangeFrom = null,
                    rangeTo = null,
                    rangeMin = null,
                    rangeMax = null,
                    min = null,
                    max = null,
                    now = new Date(),
                    today = new Date(now.getFullYear(), now.getMonth(), now.getDate()),
                    dsabldDates = _.config.disabledDates,
                    dsabldDays = _.config.disabledDays,
                    inDsabldDates = dsabldDates.filter(function(x) { if (x.indexOf('-') >= 0) { return (a >= _.parseDate(x.split('-')[0]).date && a <= _.parseDate(x.split('-')[1]).date) } else { return _.parseDate(x).date.getTime() === a.getTime() } }).length > 0,
                    inDsabledDays = dsabldDays.indexOf(_.config.days_of_week[a.getDay()]) >= 0 || dsabldDays.indexOf(_.config.short_days[a.getDay()]) >= 0 || dsabldDays.indexOf(_.config.short_days.map(function(x) { return x.substr(0, 2) })[a.getDay()]) >= 0; if (_.minDate) { min = _.minDate === "today" ? today : new Date(_.minDate) } if (_.maxDate) { max = _.maxDate === "today" ? today : new Date(_.maxDate) } if (_.rangeFromEl) { var b = $(_.rangeFromEl),
                        fromData = b.data(DCAL_DATA),
                        fromFormat = fromData.config.format,
                        fromVal = b.val();
                    rangeFrom = _.parseDate(fromVal, fromFormat).date;
                    rangeMin = fromData.minDate === "today" ? today : new Date(fromData.minDate) } if (_.rangeToEl) { var c = $(_.rangeToEl),
                        toData = c.data(DCAL_DATA),
                        toFormat = toData.config.format,
                        toVal = c.val();
                    rangeTo = _.parseDate(toVal, toFormat).date;
                    rangeMax = toData.maxDate === "today" ? today : new Date(toData.maxDate) } return ((min && a < min) || (max && a > max) || (rangeFrom && a < rangeFrom) || (rangeTo && a > rangeTo) || (rangeMin && a < rangeMin) || (rangeMax && a > rangeMax)) || (inDsabldDates || inDsabledDays) }, show: function() { var _ = this;
                $('body').attr('datepicker-display', 'on');
                _.resetSelection();
                _.setSelection();
                _.setupCalendar();
                _.datepicker.container.addClass('active');
                _.visible = true;
                _.input.blur() }, hide: function() { var _ = this;
                _.datepicker.container.addClass('inactive');
                _.switchView('calendar');
                _.visible = false;
                _.input.focus();
                $('body').removeAttr('datepicker-display');
                setTimeout(function() { _.datepicker.container.removeClass('inactive active') }, 200) }, destroy: function() { var _ = this;
                _.input.removeData(DCAL_DATA).unbind('keydown').unbind('click').removeProp('readonly');
                _.datepicker.container.remove() } };
        $.fn.wDate = function(d) { return $(this).each(function(a, b) { var c = this,
                    $that = $(this),
                    picker = $(this).data(DCAL_DATA),
                    options = $.extend({}, $.fn.wDate.defaults, $that.data(), typeof d === 'object' && d); if (!picker) { $that.data(DCAL_DATA, (picker = new wDatePicker(c, options))) } if (typeof d === 'string') { picker[d]() }
                $(document).on('keydown', function(e) { if (e.keyCode !== 27) { return } if (picker.visible) { picker.hide() } }) }) };
        $.fn.wDate.defaults = { months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], short_months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], days_of_week: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], short_days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'], days_min: ['S', 'M', 'T', 'W', 'T', 'F', 'S'], selected_format: 'DD, mmmm d', month_head_format: 'mmmm yyyy', format: 'mm/dd/yyyy', format_submit: 'mm-dd-yyyy', outFormat: null, auto: false, clearBtn: false, todayBtn: false, cancelBtn: false, clearBtnLabel: "Clear", cancelBtnLabel: "Cancel", okBtnLabel: "OK", todayBtnLabel: "Today", overlayClose: true, disabledDates: [], disabledDays: [], } })() })(window, jQuery);
/*wTimePicker*/
(function(n, $, o) { "use strict";
    (function() { var j = "_wTime",
            HOUR_START_DEG = 120,
            MIN_START_DEG = 90,
            END_DEG = 360,
            HOUR_DEG_INCR = 30,
            MIN_DEG_INCR = 6,
            EX_KEYS = [9, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123]; var l = function(f, g) { this.hour = f;
            this.minute = g;
            this.format = function(b, c) { var d = this,
                    is24Hour = (b.match(/h/g) || []).length > 1; return $.trim(b.replace(/(hh|h|mm|ss|tt|t)/g, function(e) { switch (e.toLowerCase()) {
                        case 'h':
                            var a = d.getHour(true); return (c && a < 10 ? '0' + a : a);
                        case 'hh':
                            return (d.hour < 10 ? '0' + d.hour : d.hour);
                        case 'mm':
                            return (d.minute < 10 ? '0' + d.minute : d.minute);
                        case 'ss':
                            return '00';
                        case 't':
                            return is24Hour ? '' : d.getT().toLowerCase();
                        case 'tt':
                            return is24Hour ? '' : d.getT() } })) };
            this.setHour = function(a) { this.hour = a };
            this.getHour = function(a) { return a ? this.hour === 0 || this.hour === 12 ? 12 : (this.hour % 12) : this.hour };
            this.invert = function() { if (this.getT() === 'AM') { this.setHour(this.getHour() + 12) } else { this.setHour(this.getHour() - 12) } };
            this.setMinutes = function(a) { this.minute = a };
            this.getMinutes = function(a) { return this.minute };
            this.getT = function() { return this.hour < 12 ? 'AM' : 'PM' } }; var m = function(c, d) { var f = this;
            this.visible = false;
            this.activeView = 'hours';
            this.hTimeout = null;
            this.mTimeout = null;
            this.input = $(c);
            this.config = d;
            this.time = new l(0, 0);
            this.selected = new l(0, 0);
            this.timepicker = { overlay: $('<div class="wojo time picker hidden"></div>'), wrapper: $('<div class="container"></div>'), timeHolder: { wrapper: $('<section class="header"></section>'), hour: $('<span class="hour">12</span>'), dots: $('<span class="separator">:</span>'), minute: $('<span class="minute">00</span>'), am_pm: $('<span class="ampm">AM</span>') }, clockHolder: { wrapper: $('<section class="content"></section>'), am: $('<span class="wojo small compact inverted button am">AM</span>'), pm: $('<span class="wojo small compact inverted button pm">PM</span>'), clock: { wrapper: $('<div class="section"></div>'), dot: $('<span class="dot"></span>'), hours: $('<div class="hours"></div>'), minutes: $('<div class="minutes"></div>') }, buttonsHolder: { wrapper: $('<div class="actions">'), btnOk: $('<span class="button ok">' + f.config.btnOk + '</span>'), btnNow: $('<span class="button now">' + f.config.btnNow + '</span>'), btnCancel: $('<span class="button cancel">' + f.config.btnCancel + '</span>') } } }; var g = f.timepicker;
            f.setup(g).appendTo('body');
            g.clockHolder.am.click(function() { if (f.selected.getT() !== 'AM') { f.setT('am') } });
            g.clockHolder.pm.click(function() { if (f.selected.getT() !== 'PM') { f.setT('pm') } });
            g.timeHolder.hour.click(function() { if (f.activeView !== 'hours') { f.switchView('hours') } });
            g.timeHolder.minute.click(function() { if (f.activeView !== 'minutes') { f.switchView('minutes') } });
            g.clockHolder.buttonsHolder.btnOk.click(function() { f.setValue(f.selected); var a = f.getFormattedTime();
                f.input.trigger($.Event('timechanged', { time: a.time, value: a.value })).trigger('onchange').trigger('change');
                f.hide() });
            g.clockHolder.buttonsHolder.btnCancel.click(function() { f.hide() });
            g.clockHolder.buttonsHolder.btnNow.click(function() { var a = f.getSystemTime();
                f.setValue(a); var b = f.getFormattedTime();
                f.input.trigger($.Event('timechanged', { time: b.time, value: b.value })).trigger('onchange').trigger('change');
                f.hide() });
            f.input.on('keydown', function(e) { if (e.keyCode === 13) { f.show() } return !(EX_KEYS.indexOf(e.which) < 0 && f.config.readOnly) }).on('click', function() { f.show() }).prop('readonly', f.config.readOnly); var h; if (f.input.val() !== '') { h = f.parseTime(f.input.val(), f.config.format);
                f.setValue(h) } else { h = f.getSystemTime();
                f.time = new l(h.hour, h.minute) }
            f.resetSelected();
            f.switchView(f.activeView) };
        m.prototype = { constructor: m, setup: function(b) { if (typeof b === 'undefined') { throw new Error('Expecting a value.'); } var c = this,
                    overlay = b.overlay,
                    wrapper = b.wrapper,
                    time = b.timeHolder,
                    clock = b.clockHolder;
                time.wrapper.append(time.hour).append(time.dots).append(time.minute).append(time.am_pm).appendTo(wrapper); for (var i = 0; i < 12; i++) { var d = i + 1,
                        deg = (HOUR_START_DEG + (i * HOUR_DEG_INCR)) % END_DEG,
                        hour = $('<div style="transform: rotate(' + deg + 'deg)" class="digit" data-hour="' + d + '"><span style="transform: rotate(-' + deg + 'deg)">' + d + ((c.config.is24) ? '<small>' + (d + 12) + '</small>' : '') + '</span></div>');
                    hour.find('span').click(function() { var a = parseInt($(this).parent().data('hour')),
                            _selectedT = c.selected.getT(),
                            _value = (a + ((_selectedT === 'PM' && a < 12) || (_selectedT === 'AM' && a === 12) ? 12 : 0)) % 24;
                        c.setHour(_value);
                        c.switchView('minutes') });
                    clock.clock.hours.append(hour) } for (var k = 0; k < 60; k++) { var e = k < 10 ? '0' + k : k,
                        degs = (MIN_START_DEG + (k * MIN_DEG_INCR)) % END_DEG,
                        minute = $('<div style="transform: rotate(' + degs + 'deg)" class="digit" data-minute="' + k + '"></div>'); if (k % 5 === 0) { minute.addClass('marker').html('<span style="transform: rotate(-' + degs + 'deg)">' + e + '</span>') } else { minute.html('<span></span>') }
                    minute.find('span').click(function() { c.setMinute($(this).parent().data('minute')) });
                    clock.clock.minutes.append(minute) }
                clock.clock.wrapper.append(clock.am).append(clock.pm).append(clock.clock.dot).append(clock.clock.hours).append(clock.clock.minutes).appendTo(clock.wrapper);
                clock.buttonsHolder.wrapper.append(clock.buttonsHolder.btnCancel).append(clock.buttonsHolder.btnNow).append(clock.buttonsHolder.btnOk).appendTo(clock.wrapper);
                clock.wrapper.appendTo(wrapper);
                wrapper.appendTo(overlay); return overlay }, setHour: function(d) { if (typeof d === 'undefined') { throw new Error('Expecting a value.'); } var e = this;
                this.selected.setHour(d);
                this.timepicker.timeHolder.hour.text(this.selected.getHour((this.config.is24) ? false : true));
                this.timepicker.clockHolder.clock.hours.children('div').each(function(a, b) { var c = $(b),
                        val = c.data('hour');
                    c[val === e.selected.getHour(true) ? 'addClass' : 'removeClass']('active') }) }, setMinute: function(d) { if (typeof d === 'undefined') { throw new Error('Expecting a value.'); }
                this.selected.setMinutes(d);
                this.timepicker.timeHolder.minute.text(d < 10 ? '0' + d : d);
                this.timepicker.clockHolder.clock.minutes.children('div').each(function(a, b) { var c = $(b),
                        val = c.data('minute');
                    c[val === d ? 'addClass' : 'removeClass']('active') }) }, setT: function(a) { if (typeof a === 'undefined') { throw new Error('Expecting a value.'); } if (this.selected.getT() !== a.toUpperCase()) { this.selected.invert() } var t = this.selected.getT();
                this.timepicker.timeHolder.am_pm.text(t);
                this.timepicker.clockHolder.am[t === 'AM' ? 'addClass' : 'removeClass']('primary');
                this.timepicker.clockHolder.pm[t === 'PM' ? 'addClass' : 'removeClass']('primary') }, setValue: function(a) { if (typeof a === 'undefined') { throw new Error('Expecting a value.'); } var b = typeof a === 'string' ? this.parseTime(a, this.config.format) : a;
                this.time = new l(b.hour, b.minute); var c = this.getFormattedTime();
                this.input.val(c.value).attr('data-time', c.time).attr('value', c.value) }, resetSelected: function() { this.setHour(this.time.hour);
                this.setMinute(this.time.minute);
                this.setT(this.time.getT()) }, getFormattedTime: function() { var a = this.time.format(this.config.timeFormat, false),
                    tValue = this.time.format(this.config.format, this.config.hourPadding); return { time: a, value: tValue } }, getSystemTime: function() { var a = new Date(); return new l(a.getHours(), a.getMinutes()) }, parseTime: function(a, b) { var c = this,
                    format = typeof b === 'undefined' ? c.config.format : b,
                    hLength = (format.match(/h/g) || []).length,
                    is24Hour = hLength > 1,
                    mLength = (format.match(/m/g) || []).length,
                    tLength = (format.match(/t/g) || []).length,
                    timeLength = a.length,
                    fH = format.indexOf('h'),
                    lH = format.lastIndexOf('h'),
                    hour = '',
                    min = '',
                    t = ''; if (c.config.hourPadding || is24Hour) { hour = a.substr(fH, 2) } else { var d = format.substring(fH - 1, fH),
                        next = format.substring(lH + 1, lH + 2); if (lH === format.length - 1) { hour = a.substring(a.indexOf(d, fH - 1) + 1, timeLength) } else if (fH === 0) { hour = a.substring(0, a.indexOf(next, fH)) } else { hour = a.substring(a.indexOf(d, fH - 1) + 1, a.indexOf(next, fH + 1)) } }
                format = format.replace(/(hh|h)/g, hour); var e = format.indexOf('m'),
                    lM = format.lastIndexOf('m'),
                    fT = format.indexOf('t'); var f = format.substring(e - 1, e),
                    nextM = format.substring(lM + 1, lM + 2); if (lM === format.length - 1) { min = a.substring(a.indexOf(f, e - 1) + 1, timeLength) } else if (e === 0) { min = a.substring(0, 2) } else { min = a.substr(e, 2) } if (is24Hour) { t = parseInt(hour) > 11 ? (tLength > 1 ? 'PM' : 'pm') : (tLength > 1 ? 'AM' : 'am') } else { t = a.substr(fT, 2) } var g = t.toLowerCase() === 'pm',
                    outTime = new l(parseInt(hour), parseInt(min)); if ((g && parseInt(hour) < 12) || (!g && parseInt(hour) === 12)) { outTime.invert() } return outTime }, switchView: function(a) { var b = this,
                    picker = this.timepicker,
                    anim_speed = 350; if (a !== 'hours' && a !== 'minutes') { return }
                b.activeView = a;
                picker.timeHolder.hour[a === 'hours' ? 'addClass' : 'removeClass']('active');
                picker.timeHolder.minute[a === 'hours' ? 'removeClass' : 'addClass']('active');
                picker.clockHolder.clock.hours.addClass('animate'); if (a === 'hours') { picker.clockHolder.clock.hours.removeClass('hidden') }
                clearTimeout(b.hTimeout);
                b.hTimeout = setTimeout(function() { if (a !== 'hours') { picker.clockHolder.clock.hours.addClass('hidden') }
                    picker.clockHolder.clock.hours.removeClass('animate') }, a === 'hours' ? 20 : anim_speed);
                picker.clockHolder.clock.minutes.addClass('animate'); if (a === 'minutes') { picker.clockHolder.clock.minutes.removeClass('hidden') }
                clearTimeout(b.mTimeout);
                b.mTimeout = setTimeout(function() { if (a !== 'minutes') { picker.clockHolder.clock.minutes.addClass('hidden') }
                    picker.clockHolder.clock.minutes.removeClass('animate') }, a === 'minutes' ? 20 : anim_speed) }, show: function() { var a = this; if (a.input.val() === '') { var b = a.getSystemTime();
                    this.time = new l(b.hour, b.minute) }
                a.resetSelected();
                $('body').attr('timepicker-display', 'on');
                a.timepicker.wrapper.addClass('animate');
                a.timepicker.overlay.removeClass('hidden').addClass('animate');
                setTimeout(function() { a.timepicker.overlay.removeClass('animate');
                    a.timepicker.wrapper.removeClass('animate');
                    a.visible = true;
                    a.input.blur() }, 10) }, hide: function() { var a = this;
                a.timepicker.overlay.addClass('animate');
                a.timepicker.wrapper.addClass('animate');
                setTimeout(function() { a.switchView('hours');
                    a.timepicker.overlay.addClass('hidden').removeClass('animate');
                    a.timepicker.wrapper.removeClass('animate');
                    $('body').removeAttr('timepicker-display');
                    a.visible = false;
                    a.input.focus() }, 300) }, destroy: function() { var a = this;
                a.input.removeData(j).unbind('keydown').unbind('click').removeProp('readonly');
                a.timepicker.overlay.remove() } };
        $.fn.wTime = function(d) { return $(this).each(function(a, b) { var c = this,
                    $that = $(this),
                    picker = $(this).data(j),
                    options = $.extend({}, $.fn.wTime.defaults, $that.data(), typeof d === 'object' && d); if (!picker) { $that.data(j, (picker = new m(c, options))) } if (typeof d === 'string') { picker[d]() }
                $(document).on('keydown', function(e) { if (e.keyCode !== 27) { return } if (picker.visible) { picker.hide() } }) }) };
        $.fn.wTime.defaults = { timeFormat: 'hh:mm:ss.000', format: 'hh:mm t', is24: true, readOnly: true, hourPadding: true, btnNow: "Now", btnOk: "Ok", btnCancel: "Cancel", } })() })(window, jQuery);
/*edit in place*/
$.fn.editableTableWidget = function(options) { return $(this).each(function() { var buildDefaultOptions = function() { var opts = $.extend({}, $.fn.editableTableWidget.defaultOptions);
                opts.editor = opts.editor.clone(); return opts },
            activeOptions = $.extend(buildDefaultOptions(), options),
            ARROW_LEFT = 37,
            ARROW_UP = 38,
            ARROW_RIGHT = 39,
            ARROW_DOWN = 40,
            ENTER = 13,
            ESC = 27,
            TAB = 9,
            element = $(this),
            editor = activeOptions.editor.css("position", "absolute").hide().appendTo(element.parent()),
            active, showEditor = function(select) { active = element.find("[data-editable]:focus"); if (active.length) { editor.val(active.text()).removeClass("error").show().offset(active.offset()).css(active.css(activeOptions.cloneProperties)).width(active.width()).height(active.height()).focus(); if (select) { editor.select() } } },
            setActiveText = function() { var text = editor.val(),
                    evt = $.Event("change"),
                    originalContent; if (active.text() === text || editor.hasClass("error")) { return true }
                originalContent = active.html();
                active.text(text).trigger(evt, text); if (evt.result === false) { active.html(originalContent) } },
            movement = function(element, keycode) { if (keycode === ARROW_RIGHT) { return element.next() } else { if (keycode === ARROW_LEFT) { return element.prev() } else { if (keycode === ARROW_UP) { return element.parent().prev().children().eq(element.index()) } else { if (keycode === ARROW_DOWN) { return element.parent().next().children().eq(element.index()) } } } } return [] };
        editor.blur(function() { setActiveText();
            editor.hide() }).keydown(function(e) { if (e.which === ENTER) { setActiveText();
                editor.hide();
                active.focus();
                e.preventDefault();
                e.stopPropagation() } else { if (e.which === ESC) { editor.val(active.text());
                    e.preventDefault();
                    e.stopPropagation();
                    editor.hide();
                    active.focus() } else { if (e.which === TAB) { active.focus() } else { if (this.selectionEnd - this.selectionStart === this.value.length) { var possibleMove = movement(active, e.which); if (possibleMove.length > 0) { possibleMove.focus();
                                e.preventDefault();
                                e.stopPropagation() } } } } } }).on("input paste", function() { var evt = $.Event("validate");
            active.trigger(evt, editor.val()); if (evt.result === false) { editor.addClass("error") } else { editor.removeClass("error") } });
        element.on("click keypress dblclick", showEditor).keydown(function(e) { var prevent = true,
                possibleMove = movement($(e.target), e.which); if (possibleMove.length > 0) { possibleMove.focus() } else { if (e.which === ENTER) { showEditor(false) } else { if (e.which === 17 || e.which === 91 || e.which === 93) { showEditor(true);
                        prevent = false } else { prevent = false } } } if (prevent) { e.stopPropagation();
                e.preventDefault() } });
        element.find("[data-editable]").css("cursor", "pointer").prop("tabindex", 1);
        $(window).on("resize", function() { if (editor.is(":visible")) { editor.offset(active.offset()).width(active.width()).height(active.height()) } }) }) };
$.fn.editableTableWidget.defaultOptions = { cloneProperties: ["padding", "padding-top", "padding-bottom", "padding-left", "padding-right", "text-align", "font", "font-size", "font-family", "font-weight", "border", "border-top", "border-bottom", "border-left", "border-right"], editor: $("<input>").addClass("wojo editable") };
/*wUpload*/
(function($) { var k = 'wojoUpload'; var l = { url: document.URL, method: 'POST', extraData: {}, maxFileSize: 0, maxFiles: 0, allowedTypes: '*', extFilter: null, dataType: null, fileName: 'file', onInit: function() {}, onFallbackMode: function(a) {}, onNewFile: function(a, b) {}, onBeforeUpload: function(a) {}, onComplete: function() {}, onUploadProgress: function(a, b) {}, onUploadSuccess: function(a, b) {}, onUploadError: function(a, b) {}, onFileTypeError: function(a) {}, onFileSizeError: function(a) {}, onFileExtError: function(a) {}, onFilesMaxError: function(a) {} }; var m = function(a, b) { this.element = $(a);
        this.settings = $.extend({}, l, b); if (!this.checkBrowser()) { return false }
        this.init(); return true };
    m.prototype.checkBrowser = function() { if (window.FormData === undefined) { this.settings.onFallbackMode.call(this.element, 'Browser doesn\'t support Form API'); return false } if (this.element.find('input[type=file]').length > 0) { return true } if (!this.checkEvent('drop', this.element) || !this.checkEvent('dragstart', this.element)) { this.settings.onFallbackMode.call(this.element, 'Browser doesn\'t support Ajax Drag and Drop'); return false } return true };
    m.prototype.checkEvent = function(a, b) { var b = b || document.createElement('div'); var a = 'on' + a; var c = a in b; if (!c) { if (!b.setAttribute) { b = document.createElement('div') } if (b.setAttribute && b.removeAttribute) { b.setAttribute(a, '');
                c = typeof b[a] == 'function'; if (typeof b[a] != 'undefined') { b[a] = undefined }
                b.removeAttribute(a) } }
        b = null; return c };
    m.prototype.init = function() { var c = this;
        c.queue = new Array();
        c.queuePos = -1;
        c.queueRunning = false;
        c.element.on('drop', function(a) { a.preventDefault(); var b = a.originalEvent.dataTransfer.files;
            c.queueFiles(b) });
        c.element.find('input[type=file]').on('change', function(a) { var b = a.target.files;
            c.queueFiles(b);
            $(this).val('') });
        this.settings.onInit.call(this.element) };
    m.prototype.queueFiles = function(a) { var j = this.queue.length; for (var i = 0; i < a.length; i++) { var b = a[i]; if ((this.settings.maxFileSize > 0) && (b.size > this.settings.maxFileSize)) { this.settings.onFileSizeError.call(this.element, b); continue } if ((this.settings.allowedTypes != '*') && !b.type.match(this.settings.allowedTypes)) { this.settings.onFileTypeError.call(this.element, b); continue } if (this.settings.extFilter != null) { var c = this.settings.extFilter.toLowerCase().split(';'); var d = b.name.toLowerCase().split('.').pop(); if ($.inArray(d, c) < 0) { this.settings.onFileExtError.call(this.element, b); continue } } if (this.settings.maxFiles > 0) { if (this.queue.length >= this.settings.maxFiles) { this.settings.onFilesMaxError.call(this.element, b); continue } }
            this.queue.push(b); var e = this.queue.length - 1;
            this.settings.onNewFile.call(this.element, e, b) } if (this.queueRunning) { return false } if (this.queue.length == j) { return false }
        this.processQueue(); return true };
    m.prototype.processQueue = function() { var g = this;
        g.queuePos++; if (g.queuePos >= g.queue.length) { g.settings.onComplete.call(g.element);
            g.queuePos = (g.queue.length - 1);
            g.queueRunning = false; return } var h = g.queue[g.queuePos]; var i = new FormData();
        i.append(g.settings.fileName, h); var j = g.settings.onBeforeUpload.call(g.element, g.queuePos); if (false === j) { return }
        $.each(g.settings.extraData, function(a, b) { i.append(a, b) });
        g.queueRunning = true;
        $.ajax({ url: g.settings.url, type: g.settings.method, dataType: g.settings.dataType, data: i, cache: false, contentType: false, processData: false, forceSync: false, xhr: function() { var f = $.ajaxSettings.xhr(); if (f.upload) { f.upload.addEventListener('progress', function(a) { var b = 0; var c = a.loaded || a.position; var d = a.total || e.totalSize; if (a.lengthComputable) { b = Math.ceil(c / d * 100) }
                        g.settings.onUploadProgress.call(g.element, g.queuePos, b) }, false) } return f }, success: function(a, b, c) { g.settings.onUploadSuccess.call(g.element, g.queuePos, a) }, error: function(a, b, c) { g.settings.onUploadError.call(g.element, g.queuePos, c) }, complete: function(a, b) { g.processQueue() } }) };
    $.fn.wojoUpload = function(a) { return this.each(function() { if (!$.data(this, k)) { $.data(this, k, new m(this, a)) } }) };
    $(document).on('dragenter', function(e) { e.stopPropagation();
        e.preventDefault() });
    $(document).on('dragover', function(e) { e.stopPropagation();
        e.preventDefault() });
    $(document).on('drop', function(e) { e.stopPropagation();
        e.preventDefault() }) })(jQuery);
/*console*/
var arrDebugTabs = ["General", "Params", "Warnings", "Errors", "Queries"];
var debugTabsHeight = "200px";

function appSetCookie(state, tab) { $.cookie("debugBarState", state); if (tab !== null) { $.cookie("debugBarTab", tab) } }

function appGetCookie(name) { if (document.cookie.length > 0) { start_c = document.cookie.indexOf(name + "="); if (start_c != -1) { start_c += (name.length + 1);
            end_c = document.cookie.indexOf(";", start_c); if (end_c == -1) { end_c = document.cookie.length } return unescape(document.cookie.substring(start_c, end_c)) } } return "" }

function appTabsMiddle() { appExpandTabs("middle", appGetCookie("debugBarTab")) }

function appTabsMaximize() { appExpandTabs("max", appGetCookie("debugBarTab")) }

function appTabsMinimize() { appExpandTabs("min", "General") }

function appExpandTabs(act, key) { if (act == "max") { debugTabsHeight = "500px" } else { if (act == "middle") { debugTabsHeight = "200px" } else { if (act == "min") { debugTabsHeight = "0px" } else { if (act == "auto") { if (debugTabsHeight == "0px") { debugTabsHeight = "200px";
                        act = "middle" } else { if (debugTabsHeight == "200px") { act = "middle" } else { if (debugTabsHeight == "500px") { act = "max" } } } } } } }
    keyTab = (key == null) ? "General" : key;
    $("#debugArrowExpand").css("display", ((act == "max") ? "none" : (act == "middle") ? "none" : ""));
    $("#debugArrowCollapse").css("display", ((act == "max") ? "" : (act == "middle") ? "" : "none"));
    $("#debugArrowMaximize").css("display", ((act == "max") ? "none" : (act == "middle") ? "" : ""));
    $("#debugArrowMinimize").css("display", ((act == "max") ? "" : (act == "middle") ? "none" : "none")); for (var i = 0; i < arrDebugTabs.length; i++) { if (act == "min" || arrDebugTabs[i] != keyTab) { $("#content" + arrDebugTabs[i]).css("display", "none");
            $("#tab" + arrDebugTabs[i]).css("color", "#bbb") } } if (act != "min") { $("#content" + keyTab).css("display", "");
        $("#content" + keyTab).css({ "overflow-y": "auto", height: debugTabsHeight });
        $("#tab" + keyTab).css("color", "#222") }
    $("#debug-panel").css("opacity", (act == "min") ? "0.9" : "1");
    appSetCookie(act, key) };