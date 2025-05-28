<?php
//date_default_timezone_set('Asia/Karachi');
//$date = new DateTime('2020-12-04');
//echo $date->modify('next saturday')->format('Y-m-d');
// print_r($pinterest_login_url);
// print_r( $this->input->request_headers());
// die();
?>

    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/basic.min.css" rel="stylesheet" />
    <link href="<?= GeneralAssets ?>plugins/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <style>
        webhighlights-link-preview {
            display: flex;
            width: 500px;
            margin-top: 10px;
        }
        
        @media (min-width: 600px) {
            webhighlights-link-preview {
                margin: 10px 0px;
                border-radius: 10px;
            }
        }
        
        webhighlights-link-preview:hover {
            background: rgb(245, 248, 250);
            border-color: #8899a680;
        }
    </style>
    <script>
        /*! For license information please see main.js.LICENSE.txt */
        (() => {
                "use strict";
                const t = window,
                    e = t.ShadowRoot && (void 0 === t.ShadyCSS || t.ShadyCSS.nativeShadow) && "adoptedStyleSheets" in Document.prototype && "replace" in CSSStyleSheet.prototype,
                    i = Symbol(),
                    n = new WeakMap;
                class s {
                    constructor(t, e, n) {
                        if (this._$cssResult$ = !0, n !== i) throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");
                        this.cssText = t, this.t = e
                    }
                    get styleSheet() {
                        let t = this.o;
                        const i = this.t;
                        if (e && void 0 === t) {
                            const e = void 0 !== i && 1 === i.length;
                            e && (t = n.get(i)), void 0 === t && ((this.o = t = new CSSStyleSheet).replaceSync(this.cssText), e && n.set(i, t))
                        }
                        return t
                    }
                    toString() {
                        return this.cssText
                    }
                }
                const o = e ? t => t : t => t instanceof CSSStyleSheet ? (t => {
                    let e = "";
                    for (const i of t.cssRules) e += i.cssText;
                    return (t => new s("string" == typeof t ? t : t + "", void 0, i))(e)
                })(t) : t;
                var r;
                const l = window,
                    a = l.trustedTypes,
                    h = a ? a.emptyScript : "",
                    d = l.reactiveElementPolyfillSupport,
                    c = {
                        toAttribute(t, e) {
                            switch (e) {
                                case Boolean:
                                    t = t ? h : null;
                                    break;
                                case Object:
                                case Array:
                                    t = null == t ? t : JSON.stringify(t)
                            }
                            return t
                        },
                        fromAttribute(t, e) {
                            let i = t;
                            switch (e) {
                                case Boolean:
                                    i = null !== t;
                                    break;
                                case Number:
                                    i = null === t ? null : Number(t);
                                    break;
                                case Object:
                                case Array:
                                    try {
                                        i = JSON.parse(t)
                                    } catch (t) {
                                        i = null
                                    }
                            }
                            return i
                        }
                    },
                    p = (t, e) => e !== t && (e == e || t == t),
                    u = {
                        attribute: !0,
                        type: String,
                        converter: c,
                        reflect: !1,
                        hasChanged: p
                    };
                class v extends HTMLElement {
                    constructor() {
                        super(), this._$Ei = new Map, this.isUpdatePending = !1, this.hasUpdated = !1, this._$El = null, this.u()
                    }
                    static addInitializer(t) {
                        var e;
                        null !== (e = this.h) && void 0 !== e || (this.h = []), this.h.push(t)
                    }
                    static get observedAttributes() {
                        this.finalize();
                        const t = [];
                        return this.elementProperties.forEach(((e, i) => {
                            const n = this._$Ep(i, e);
                            void 0 !== n && (this._$Ev.set(n, i), t.push(n))
                        })), t
                    }
                    static createProperty(t, e = u) {
                        if (e.state && (e.attribute = !1), this.finalize(), this.elementProperties.set(t, e), !e.noAccessor && !this.prototype.hasOwnProperty(t)) {
                            const i = "symbol" == typeof t ? Symbol() : "__" + t,
                                n = this.getPropertyDescriptor(t, i, e);
                            void 0 !== n && Object.defineProperty(this.prototype, t, n)
                        }
                    }
                    static getPropertyDescriptor(t, e, i) {
                        return {get() {
                                return this[e]
                            },
                            set(n) {
                                const s = this[t];
                                this[e] = n, this.requestUpdate(t, s, i)
                            },
                            configurable: !0,
                            enumerable: !0
                        }
                    }
                    static getPropertyOptions(t) {
                        return this.elementProperties.get(t) || u
                    }
                    static finalize() {
                        if (this.hasOwnProperty("finalized")) return !1;
                        this.finalized = !0;
                        const t = Object.getPrototypeOf(this);
                        if (t.finalize(), this.elementProperties = new Map(t.elementProperties), this._$Ev = new Map, this.hasOwnProperty("properties")) {
                            const t = this.properties,
                                e = [...Object.getOwnPropertyNames(t), ...Object.getOwnPropertySymbols(t)];
                            for (const i of e) this.createProperty(i, t[i])
                        }
                        return this.elementStyles = this.finalizeStyles(this.styles), !0
                    }
                    static finalizeStyles(t) {
                        const e = [];
                        if (Array.isArray(t)) {
                            const i = new Set(t.flat(1 / 0).reverse());
                            for (const t of i) e.unshift(o(t))
                        } else void 0 !== t && e.push(o(t));
                        return e
                    }
                    static _$Ep(t, e) {
                        const i = e.attribute;
                        return !1 === i ? void 0 : "string" == typeof i ? i : "string" == typeof t ? t.toLowerCase() : void 0
                    }
                    u() {
                        var t;
                        this._$E_ = new Promise((t => this.enableUpdating = t)), this._$AL = new Map, this._$Eg(), this.requestUpdate(), null === (t = this.constructor.h) || void 0 === t || t.forEach((t => t(this)))
                    }
                    addController(t) {
                        var e, i;
                        (null !== (e = this._$ES) && void 0 !== e ? e : this._$ES = []).push(t), void 0 !== this.renderRoot && this.isConnected && (null === (i = t.hostConnected) || void 0 === i || i.call(t))
                    }
                    removeController(t) {
                        var e;
                        null === (e = this._$ES) || void 0 === e || e.splice(this._$ES.indexOf(t) >>> 0, 1)
                    }
                    _$Eg() {
                        this.constructor.elementProperties.forEach(((t, e) => {
                            this.hasOwnProperty(e) && (this._$Ei.set(e, this[e]), delete this[e])
                        }))
                    }
                    createRenderRoot() {
                        var i;
                        const n = null !== (i = this.shadowRoot) && void 0 !== i ? i : this.attachShadow(this.constructor.shadowRootOptions);
                        return ((i, n) => {
                            e ? i.adoptedStyleSheets = n.map((t => t instanceof CSSStyleSheet ? t : t.styleSheet)) : n.forEach((e => {
                                const n = document.createElement("style"),
                                    s = t.litNonce;
                                void 0 !== s && n.setAttribute("nonce", s), n.textContent = e.cssText, i.appendChild(n)
                            }))
                        })(n, this.constructor.elementStyles), n
                    }
                    connectedCallback() {
                        var t;
                        void 0 === this.renderRoot && (this.renderRoot = this.createRenderRoot()), this.enableUpdating(!0), null === (t = this._$ES) || void 0 === t || t.forEach((t => {
                            var e;
                            return null === (e = t.hostConnected) || void 0 === e ? void 0 : e.call(t)
                        }))
                    }
                    enableUpdating(t) {}
                    disconnectedCallback() {
                        var t;
                        null === (t = this._$ES) || void 0 === t || t.forEach((t => {
                            var e;
                            return null === (e = t.hostDisconnected) || void 0 === e ? void 0 : e.call(t)
                        }))
                    }
                    attributeChangedCallback(t, e, i) {
                        this._$AK(t, i)
                    }
                    _$EO(t, e, i = u) {
                        var n;
                        const s = this.constructor._$Ep(t, i);
                        if (void 0 !== s && !0 === i.reflect) {
                            const o = (void 0 !== (null === (n = i.converter) || void 0 === n ? void 0 : n.toAttribute) ? i.converter : c).toAttribute(e, i.type);
                            this._$El = t, null == o ? this.removeAttribute(s) : this.setAttribute(s, o), this._$El = null
                        }
                    }
                    _$AK(t, e) {
                        var i;
                        const n = this.constructor,
                            s = n._$Ev.get(t);
                        if (void 0 !== s && this._$El !== s) {
                            const t = n.getPropertyOptions(s),
                                o = "function" == typeof t.converter ? {
                                    fromAttribute: t.converter
                                } : void 0 !== (null === (i = t.converter) || void 0 === i ? void 0 : i.fromAttribute) ? t.converter : c;
                            this._$El = s, this[s] = o.fromAttribute(e, t.type), this._$El = null
                        }
                    }
                    requestUpdate(t, e, i) {
                        let n = !0;
                        void 0 !== t && (((i = i || this.constructor.getPropertyOptions(t)).hasChanged || p)(this[t], e) ? (this._$AL.has(t) || this._$AL.set(t, e), !0 === i.reflect && this._$El !== t && (void 0 === this._$EC && (this._$EC = new Map), this._$EC.set(t, i))) : n = !1), !this.isUpdatePending && n && (this._$E_ = this._$Ej())
                    }
                    async _$Ej() {
                        this.isUpdatePending = !0;
                        try {
                            await this._$E_
                        } catch (t) {
                            Promise.reject(t)
                        }
                        const t = this.scheduleUpdate();
                        return null != t && await t, !this.isUpdatePending
                    }
                    scheduleUpdate() {
                        return this.performUpdate()
                    }
                    performUpdate() {
                        var t;
                        if (!this.isUpdatePending) return;
                        this.hasUpdated, this._$Ei && (this._$Ei.forEach(((t, e) => this[e] = t)), this._$Ei = void 0);
                        let e = !1;
                        const i = this._$AL;
                        try {
                            e = this.shouldUpdate(i), e ? (this.willUpdate(i), null === (t = this._$ES) || void 0 === t || t.forEach((t => {
                                var e;
                                return null === (e = t.hostUpdate) || void 0 === e ? void 0 : e.call(t)
                            })), this.update(i)) : this._$Ek()
                        } catch (t) {
                            throw e = !1, this._$Ek(), t
                        }
                        e && this._$AE(i)
                    }
                    willUpdate(t) {}
                    _$AE(t) {
                        var e;
                        null === (e = this._$ES) || void 0 === e || e.forEach((t => {
                            var e;
                            return null === (e = t.hostUpdated) || void 0 === e ? void 0 : e.call(t)
                        })), this.hasUpdated || (this.hasUpdated = !0, this.firstUpdated(t)), this.updated(t)
                    }
                    _$Ek() {
                        this._$AL = new Map, this.isUpdatePending = !1
                    }
                    get updateComplete() {
                        return this.getUpdateComplete()
                    }
                    getUpdateComplete() {
                        return this._$E_
                    }
                    shouldUpdate(t) {
                        return !0
                    }
                    update(t) {
                        void 0 !== this._$EC && (this._$EC.forEach(((t, e) => this._$EO(e, this[e], t))), this._$EC = void 0), this._$Ek()
                    }
                    updated(t) {}
                    firstUpdated(t) {}
                }
                var f;
                v.finalized = !0, v.elementProperties = new Map, v.elementStyles = [], v.shadowRootOptions = {
                    mode: "open"
                }, null == d || d({
                    ReactiveElement: v
                }), (null !== (r = l.reactiveElementVersions) && void 0 !== r ? r : l.reactiveElementVersions = []).push("1.4.0");
                const g = window,
                    $ = g.trustedTypes,
                    m = $ ? $.createPolicy("lit-html", {
                        createHTML: t => t
                    }) : void 0,
                    _ = `lit$${(Math.random()+"").slice(9)}$`,
                    y = "?" + _,
                    A = `<${y}>`,
                    b = document,
                    w = (t = "") => b.createComment(t),
                    k = t => null === t || "object" != typeof t && "function" != typeof t,
                    x = Array.isArray,
                    E = /<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,
                    S = /-->/g,
                    C = />/g,
                    P = RegExp(">|[ \t\n\f\r](?:([^\\s\"'>=/]+)([ \t\n\f\r]*=[ \t\n\f\r]*(?:[^ \t\n\f\r\"'`<>=]|(\"|')|))|$)", "g"),
                    U = /'/g,
                    H = /"/g,
                    O = /^(?:script|style|textarea|title)$/i,
                    N = t => (e, ...i) => ({
                        _$litType$: t,
                        strings: e,
                        values: i
                    }),
                    R = N(1),
                    T = (N(2), Symbol.for("lit-noChange")),
                    M = Symbol.for("lit-nothing"),
                    z = new WeakMap,
                    D = b.createTreeWalker(b, 129, null, !1),
                    j = (t, e) => {
                        const i = t.length - 1,
                            n = [];
                        let s, o = 2 === e ? "<svg>" : "",
                            r = E;
                        for (let e = 0; e < i; e++) {
                            const i = t[e];
                            let l, a, h = -1,
                                d = 0;
                            for (; d < i.length && (r.lastIndex = d, a = r.exec(i), null !== a);) d = r.lastIndex, r === E ? "!--" === a[1] ? r = S : void 0 !== a[1] ? r = C : void 0 !== a[2] ? (O.test(a[2]) && (s = RegExp("</" + a[2], "g")), r = P) : void 0 !== a[3] && (r = P) : r === P ? ">" === a[0] ? (r = null != s ? s : E, h = -1) : void 0 === a[1] ? h = -2 : (h = r.lastIndex - a[2].length, l = a[1], r = void 0 === a[3] ? P : '"' === a[3] ? H : U) : r === H || r === U ? r = P : r === S || r === C ? r = E : (r = P, s = void 0);
                            const c = r === P && t[e + 1].startsWith("/>") ? " " : "";
                            o += r === E ? i + A : h >= 0 ? (n.push(l), i.slice(0, h) + "$lit$" + i.slice(h) + _ + c) : i + _ + (-2 === h ? (n.push(void 0), e) : c)
                        }
                        const l = o + (t[i] ||  "<?>") + (2 === e ? "</svg>" : "");
                        if (!Array.isArray(t) || !t.hasOwnProperty("raw")) throw Error("invalid template strings array");
                        return [void 0 !== m ? m.createHTML(l) : l, n]
                    };
                class B {
                    constructor({
                        strings: t,
                        _$litType$: e
                    }, i) {
                        let n;
                        this.parts = [];
                        let s = 0,
                            o = 0;
                        const r = t.length - 1,
                            l = this.parts,
                            [a, h] = j(t, e);
                        if (this.el = B.createElement(a, i), D.currentNode = this.el.content, 2 === e) {
                            const t = this.el.content,
                                e = t.firstChild;
                            e.remove(), t.append(...e.childNodes)
                        }
                        for (; null !== (n = D.nextNode()) && l.length < r;) {
                            if (1 === n.nodeType) {
                                if (n.hasAttributes()) {
                                    const t = [];
                                    for (const e of n.getAttributeNames())
                                        if (e.endsWith("$lit$") || e.startsWith(_)) {
                                            const i = h[o++];
                                            if (t.push(e), void 0 !== i) {
                                                const t = n.getAttribute(i.toLowerCase() + "$lit$").split(_),
                                                    e = /([.?@])?(.*)/.exec(i);
                                                l.push({
                                                    type: 1,
                                                    index: s,
                                                    name: e[2],
                                                    strings: t,
                                                    ctor: "." === e[1] ? W : "?" === e[1] ? K : "@" === e[1] ? J : V
                                                })
                                            } else l.push({
                                                type: 6,
                                                index: s
                                            })
                                        }
                                    for (const e of t) n.removeAttribute(e)
                                }
                                if (O.test(n.tagName)) {
                                    const t = n.textContent.split(_),
                                        e = t.length - 1;
                                    if (e > 0) {
                                        n.textContent = $ ? $.emptyScript : "";
                                        for (let i = 0; i < e; i++) n.append(t[i], w()), D.nextNode(), l.push({
                                            type: 2,
                                            index: ++s
                                        });
                                        n.append(t[e], w())
                                    }
                                }
                            } else if (8 === n.nodeType)
                                if (n.data === y) l.push({
                                    type: 2,
                                    index: s
                                });
                                else {
                                    let t = -1;
                                    for (; - 1 !== (t = n.data.indexOf(_, t + 1));) l.push({
                                        type: 7,
                                        index: s
                                    }), t += _.length - 1
                                }
                            s++
                        }
                    }
                    static createElement(t, e) {
                        const i = b.createElement("template");
                        return i.innerHTML = t, i
                    }
                }

                function L(t, e, i = t, n) {
                    var s, o, r, l;
                    if (e === T) return e;
                    let a = void 0 !== n ? null === (s = i._$Cl) || void 0 === s ? void 0 : s[n] : i._$Cu;
                    const h = k(e) ? void 0 : e._$litDirective$;
                    return (null == a ? void 0 : a.constructor) !== h && (null === (o = null == a ? void 0 : a._$AO) || void 0 === o || o.call(a, !1), void 0 === h ? a = void 0 : (a = new h(t), a._$AT(t, i, n)), void 0 !== n ? (null !== (r = (l = i)._$Cl) && void 0 !== r ? r : l._$Cl = [])[n] = a : i._$Cu = a), void 0 !== a && (e = L(t, a._$AS(t, e.values), a, n)), e
                }
                class I {
                    constructor(t, e) {
                        this.v = [], this._$AN = void 0, this._$AD = t, this._$AM = e
                    }
                    get parentNode() {
                        return this._$AM.parentNode
                    }
                    get _$AU() {
                        return this._$AM._$AU
                    }
                    p(t) {
                        var e;
                        const {
                            el: {
                                content: i
                            },
                            parts: n
                        } = this._$AD, s = (null !== (e = null == t ? void 0 : t.creationScope) && void 0 !== e ? e : b).importNode(i, !0);
                        D.currentNode = s;
                        let o = D.nextNode(),
                            r = 0,
                            l = 0,
                            a = n[0];
                        for (; void 0 !== a;) {
                            if (r === a.index) {
                                let e;
                                2 === a.type ? e = new F(o, o.nextSibling, this, t) : 1 === a.type ? e = new a.ctor(o, a.name, a.strings, this, t) : 6 === a.type && (e = new Z(o, this, t)), this.v.push(e), a = n[++l]
                            }
                            r !== (null == a ? void 0 : a.index) && (o = D.nextNode(), r++)
                        }
                        return s
                    }
                    m(t) {
                        let e = 0;
                        for (const i of this.v) void 0 !== i && (void 0 !== i.strings ? (i._$AI(t, i, e), e += i.strings.length - 2) : i._$AI(t[e])), e++
                    }
                }
                class F {
                    constructor(t, e, i, n) {
                        var s;
                        this.type = 2, this._$AH = M, this._$AN = void 0, this._$AA = t, this._$AB = e, this._$AM = i, this.options = n, this._$C_ = null === (s = null == n ? void 0 : n.isConnected) || void 0 === s || s
                    }
                    get _$AU() {
                        var t, e;
                        return null !== (e = null === (t = this._$AM) || void 0 === t ? void 0 : t._$AU) && void 0 !== e ? e : this._$C_
                    }
                    get parentNode() {
                        let t = this._$AA.parentNode;
                        const e = this._$AM;
                        return void 0 !== e && 11 === t.nodeType && (t = e.parentNode), t
                    }
                    get startNode() {
                        return this._$AA
                    }
                    get endNode() {
                        return this._$AB
                    }
                    _$AI(t, e = this) {
                        t = L(this, t, e), k(t) ? t === M || null == t || "" === t ? (this._$AH !== M && this._$AR(), this._$AH = M) : t !== this._$AH && t !== T && this.$(t) : void 0 !== t._$litType$ ? this.T(t) : void 0 !== t.nodeType ? this.k(t) : (t => x(t) || "function" == typeof(null == t ? void 0 : t[Symbol.iterator]))(t) ? this.O(t) : this.$(t)
                    }
                    S(t, e = this._$AB) {
                        return this._$AA.parentNode.insertBefore(t, e)
                    }
                    k(t) {
                        this._$AH !== t && (this._$AR(), this._$AH = this.S(t))
                    }
                    $(t) {
                        this._$AH !== M && k(this._$AH) ? this._$AA.nextSibling.data = t : this.k(b.createTextNode(t)), this._$AH = t
                    }
                    T(t) {
                        var e;
                        const {
                            values: i,
                            _$litType$: n
                        } = t, s = "number" == typeof n ? this._$AC(t) : (void 0 === n.el && (n.el = B.createElement(n.h, this.options)), n);
                        if ((null === (e = this._$AH) || void 0 === e ? void 0 : e._$AD) === s) this._$AH.m(i);
                        else {
                            const t = new I(s, this),
                                e = t.p(this.options);
                            t.m(i), this.k(e), this._$AH = t
                        }
                    }
                    _$AC(t) {
                        let e = z.get(t.strings);
                        return void 0 === e && z.set(t.strings, e = new B(t)), e
                    }
                    O(t) {
                        x(this._$AH) || (this._$AH = [], this._$AR());
                        const e = this._$AH;
                        let i, n = 0;
                        for (const s of t) n === e.length ? e.push(i = new F(this.S(w()), this.S(w()), this, this.options)) : i = e[n], i._$AI(s), n++;
                        n < e.length && (this._$AR(i && i._$AB.nextSibling, n), e.length = n)
                    }
                    _$AR(t = this._$AA.nextSibling, e) {
                        var i;
                        for (null === (i = this._$AP) || void 0 === i || i.call(this, !1, !0, e); t && t !== this._$AB;) {
                            const e = t.nextSibling;
                            t.remove(), t = e
                        }
                    }
                    setConnected(t) {
                        var e;
                        void 0 === this._$AM && (this._$C_ = t, null === (e = this._$AP) || void 0 === e || e.call(this, t))
                    }
                }
                class V {
                    constructor(t, e, i, n, s) {
                        this.type = 1, this._$AH = M, this._$AN = void 0, this.element = t, this.name = e, this._$AM = n, this.options = s, i.length > 2 || "" !== i[0] || "" !== i[1] ? (this._$AH = Array(i.length - 1).fill(new String), this.strings = i) : this._$AH = M
                    }
                    get tagName() {
                        return this.element.tagName
                    }
                    get _$AU() {
                        return this._$AM._$AU
                    }
                    _$AI(t, e = this, i, n) {
                        const s = this.strings;
                        let o = !1;
                        if (void 0 === s) t = L(this, t, e, 0), o = !k(t) || t !== this._$AH && t !== T, o && (this._$AH = t);
                        else {
                            const n = t;
                            let r, l;
                            for (t = s[0], r = 0; r < s.length - 1; r++) l = L(this, n[i + r], e, r), l === T && (l = this._$AH[r]), o || (o = !k(l) || l !== this._$AH[r]), l === M ? t = M : t !== M && (t += (null != l ? l : "") + s[r + 1]), this._$AH[r] = l
                        }
                        o && !n && this.P(t)
                    }
                    P(t) {
                        t === M ? this.element.removeAttribute(this.name) : this.element.setAttribute(this.name, null != t ? t : "")
                    }
                }
                class W extends V {
                    constructor() {
                        super(...arguments), this.type = 3
                    }
                    P(t) {
                        this.element[this.name] = t === M ? void 0 : t
                    }
                }
                const q = $ ? $.emptyScript : "";
                class K extends V {
                    constructor() {
                        super(...arguments), this.type = 4
                    }
                    P(t) {
                        t && t !== M ? this.element.setAttribute(this.name, q) : this.element.removeAttribute(this.name)
                    }
                }
                class J extends V {
                    constructor(t, e, i, n, s) {
                        super(t, e, i, n, s), this.type = 5
                    }
                    _$AI(t, e = this) {
                        var i;
                        if ((t = null !== (i = L(this, t, e, 0)) && void 0 !== i ? i : M) === T) return;
                        const n = this._$AH,
                            s = t === M && n !== M || t.capture !== n.capture || t.once !== n.once || t.passive !== n.passive,
                            o = t !== M && (n === M || s);
                        s && this.element.removeEventListener(this.name, this, n), o && this.element.addEventListener(this.name, this, t), this._$AH = t
                    }
                    handleEvent(t) {
                        var e, i;
                        "function" == typeof this._$AH ? this._$AH.call(null !== (i = null === (e = this.options) || void 0 === e ? void 0 : e.host) && void 0 !== i ? i : this.element, t) : this._$AH.handleEvent(t)
                    }
                }
                class Z {
                    constructor(t, e, i) {
                        this.element = t, this.type = 6, this._$AN = void 0, this._$AM = e, this.options = i
                    }
                    get _$AU() {
                        return this._$AM._$AU
                    }
                    _$AI(t) {
                        L(this, t)
                    }
                }
                const G = g.litHtmlPolyfillSupport;
                var Q, X;
                null == G || G(B, F), (null !== (f = g.litHtmlVersions) && void 0 !== f ? f : g.litHtmlVersions = []).push("2.3.0");
                class Y extends v {
                    constructor() {
                        super(...arguments), this.renderOptions = {
                            host: this
                        }, this._$Do = void 0
                    }
                    createRenderRoot() {
                        var t, e;
                        const i = super.createRenderRoot();
                        return null !== (t = (e = this.renderOptions).renderBefore) && void 0 !== t || (e.renderBefore = i.firstChild), i
                    }
                    update(t) {
                        const e = this.render();
                        this.hasUpdated || (this.renderOptions.isConnected = this.isConnected), super.update(t), this._$Do = ((t, e, i) => {
                            var n, s;
                            const o = null !== (n = null == i ? void 0 : i.renderBefore) && void 0 !== n ? n : e;
                            let r = o._$litPart$;
                            if (void 0 === r) {
                                const t = null !== (s = null == i ? void 0 : i.renderBefore) && void 0 !== s ? s : null;
                                o._$litPart$ = r = new F(e.insertBefore(w(), t), t, void 0, null != i ? i : {})
                            }
                            return r._$AI(t), r
                        })(e, this.renderRoot, this.renderOptions)
                    }
                    connectedCallback() {
                        var t;
                        super.connectedCallback(), null === (t = this._$Do) || void 0 === t || t.setConnected(!0)
                    }
                    disconnectedCallback() {
                        var t;
                        super.disconnectedCallback(), null === (t = this._$Do) || void 0 === t || t.setConnected(!1)
                    }
                    render() {
                        return T
                    }
                }
                Y.finalized = !0, Y._$litElement$ = !0, null === (Q = globalThis.litElementHydrateSupport) || void 0 === Q || Q.call(globalThis, {
                    LitElement: Y
                });
                const tt = globalThis.litElementPolyfillSupport;
                null == tt || tt({
                    LitElement: Y
                }), (null !== (X = globalThis.litElementVersions) && void 0 !== X ? X : globalThis.litElementVersions = []).push("3.2.2");
                const et = (t, e) => "method" === e.kind && e.descriptor && !("value" in e.descriptor) ? {...e,
                    finisher(i) {
                        i.createProperty(e.key, t)
                    }
                } : {
                    kind: "field",
                    key: Symbol(),
                    placement: "own",
                    descriptor: {},
                    originalKey: e.key,
                    initializer() {
                        "function" == typeof e.initializer && (this[e.key] = e.initializer.call(this))
                    },
                    finisher(i) {
                        i.createProperty(e.key, t)
                    }
                };

                function it(t) {
                    return (e, i) => void 0 !== i ? ((t, e, i) => {
                        e.constructor.createProperty(i, t)
                    })(t, e, i) : et(t, e)
                }
                var nt;

                function st(t, e) {
                    return (null == t ? void 0 : t.length) < e ? t : `${null==t?void 0:t.substring(0,e)}...`
                }
                null === (nt = window.HTMLSlotElement) || void 0 === nt || nt.prototype.assignedElements;
                const ot = ((t, ...e) => {
                    const n = 1 === t.length ? t[0] : e.reduce(((e, i, n) => e + (t => {
                        if (!0 === t._$cssResult$) return t.cssText;
                        if ("number" == typeof t) return t;
                        throw Error("Value passed to 'css' function must be a 'css' function result: " + t + ". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")
                    })(i) + t[n + 1]), t[0]);
                    return new s(n, t, i)
                })
                `:host{width:450px;height:120px;background-color:#fff;border-width:var(--link-preview-border-width);box-sizing:border-box;border:1px solid #e1e8ed;overflow:hidden;color:#181919;cursor:pointer;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;display:flex;text-decoration:none;opacity:1;position:relative;transition-duration:.15s;transition-timing-function:ease-in-out}.link-preview-image{display:block;flex:0 0 125px;overflow:hidden;height:auto;position:relative;transition:flex-basis .25s ease-in-out 0s}.link-preview-image.loading{animation:1.25s linear 0s infinite normal none running loadingBlinking;background:center center/cover no-repeat var(--link-preview-loading-bg-color)}.link-preview-image:not(.loading){width:100%;height:100%;object-fit:cover}@media(min-width:991px){.link-preview-image{flex:0 0 180px}}.link-preview-meta-info-container{display:flex;justify-content:space-around;flex-direction:column;flex:1 1 0%;padding:8px 8px;min-width:0;box-sizing:border-box}.link-preview-meta-info-header{height:20px;display:block;margin:2px 0 8px;word-break:break-all}.link-preview-meta-info-header.loading{opacity:.8;width:60%;height:30px;animation:.75s linear 0s infinite normal none running loadingBlinking;background:--link-preview-loading-bg-color}.link-preview-meta-info-header:not(.loading){text-align:left;font-size:16px;font-weight:400;margin:0;-webkit-box-flex:1.2;flex-grow:1.2}.link-preview-meta-info-description{display:block;margin-bottom:12px;position:relative;height:20px}.link-preview-meta-info-description.loading{width:95%;opacity:.8;height:30px;animation:.75s linear .125s infinite normal none running loadingBlinking;background:--link-preview-loading-bg-color}.link-preview-meta-info-description:not(.loading){text-align:left;font-size:13px;font-weight:300;-webkit-box-flex:2;flex-grow:2;margin:auto 0;line-height:16px;text-overflow:ellipsis}.link-preview-meta-info-footer{height:10px;display:block;word-break:break-all}.link-preview-meta-info-footer.loading{opacity:.8;width:40%;height:15px;animation:.75s linear .25s infinite normal none running loadingBlinking;background:--link-preview-loading-bg-color}.link-preview-meta-info-footer:not(.loading){text-align:left;margin:0;-webkit-box-flex:0;flex-grow:0;font-size:11px;color:#747474}@keyframes loadingBlinking{0%{background:#e1e8ed}70%{background:#cdd4d8}100%{background:#e1e8ed}}`;
                var rt = function(t, e, i, n) {
                    var s, o = arguments.length,
                        r = o < 3 ? e : null === n ? n = Object.getOwnPropertyDescriptor(e, i) : n;
                    if ("object" == typeof Reflect && "function" == typeof Reflect.decorate) r = Reflect.decorate(t, e, i, n);
                    else
                        for (var l = t.length - 1; l >= 0; l--)(s = t[l]) && (r = (o < 3 ? s(r) : o > 3 ? s(e, i, r) : s(e, i)) || r);
                    return o > 3 && r && Object.defineProperty(e, i, r), r
                };
                let lt = class extends Y {
                        constructor() {
                            super(...arguments), this.api = "https://transcendent-eclair-fd16ae.netlify.app/.netlify/functions/meta"
                        }
                        static get styles() {
                            return [ot]
                        }
                        get metaFallback() {
                            return {
                                title: this.titleFallback,
                                description: this.descriptionFallback,
                                url: this.url
                            }
                        }
                        get meta() {
                            return Object.assign(Object.assign({}, this.metaFallback), this.metaData)
                        }
                        get loading() {
                            return void 0 === this.metaData
                        }
                        firstUpdated() {
                            const t = encodeURIComponent(this.url);
                            fetch(`${this.api}?url=${t}`).then((t => function(t, e, i, n) {
                                return new(i || (i = Promise))((function(s, o) {
                                    function r(t) {
                                        try {
                                            a(n.next(t))
                                        } catch (t) {
                                            o(t)
                                        }
                                    }

                                    function l(t) {
                                        try {
                                            a(n.throw(t))
                                        } catch (t) {
                                            o(t)
                                        }
                                    }

                                    function a(t) {
                                        var e;
                                        t.done ? s(t.value) : (e = t.value, e instanceof i ? e : new i((function(t) {
                                            t(e)
                                        }))).then(r, l)
                                    }
                                    a((n = n.apply(t, e || [])).next())
                                }))
                            }(this, void 0, void 0, (function*() {
                                try {
                                    const e = yield t.json();
                                    this.metaData = e
                                } catch (t) {
                                    this.metaData = {}
                                }
                            })))).catch((() => this.metaData = {}))
                        }
                        get loadingClass() {
                            return this.loading ? "loading" : ""
                        }
                        get description() {
                            var t, e;
                            return st(null !== (e = null === (t = this.meta) || void 0 === t ? void 0 : t.description) && void 0 !== e ? e : "", 75)
                        }
                        get previewUrl() {
                            return this.loading ? "" : st(this.url.split("//")[1], 32)
                        }
                        get title() {
                            var t, e;
                            return st(this.loading ? "" : null !== (e = null === (t = this.meta) || void 0 === t ? void 0 : t.title) && void 0 !== e ? e : "", 45)
                        }
                        get imageSrc() {
                            var t, e, i, n;
                            return this.loading ? "" : null !== (n = null !== (i = null === (e = null === (t = this.meta) || void 0 === t ? void 0 : t.image) || void 0 === e ? void 0 : e.url) && void 0 !== i ? i : this.imageFallback) && void 0 !== n ? n : "https://web-highlights.com/images/fallback-image.png"
                        }
                        render() {
                                return R `
      <div class="link-preview-meta-info-container ${this.loadingClass}">
        <header class="link-preview-meta-info-header ${this.loadingClass}">
          ${this.title}
        </header>
        <main class="link-preview-meta-info-description ${this.loadingClass}">
          <span>${this.description}</span>
        </main>
        <footer class="link-preview-meta-info-footer ${this.loadingClass}">
          <span class="link-preview-meta-info-footer-url">${this.previewUrl}</span>
        </footer>
      </div>
      ${this.loading?R` <div class="link-preview-image ${this.loadingClass}"></div> `:R`
            <img
              class="link-preview-image"
              src="${this.imageSrc}"
              alt="Link preview image"
            />
          `}
    `}};rt([it()],lt.prototype,"api",void 0),rt([it()],lt.prototype,"url",void 0),rt([it()],lt.prototype,"titleFallback",void 0),rt([it()],lt.prototype,"descriptionFallback",void 0),rt([it()],lt.prototype,"imageFallback",void 0),rt([it()],lt.prototype,"metaData",void 0),lt=rt([t=>"function"==typeof t?((t,e)=>(customElements.define("webhighlights-link-preview",e),e))(0,t):((t,e)=>{const{kind:i,elements:n}=e;return{kind:i,elements:n,finisher(t){customElements.define("webhighlights-link-preview",t)}}})(0,t)],lt)})();
    </script>

    <style>
        .dropzone .dz-preview .dz-error-message {
            color: white !important;
        }
        
        .mt-100 {
            margin-top: 100px
        }
        
        body {
            background: #00B4DB;
            background: -webkit-linear-gradient(to right, #0083B0, #00B4DB);
            background: linear-gradient(to right, #0083B0, #00B4DB);
            color: #514B64;
            min-height: 100vh
        }
    </style>
    <?php

$page = 0;
$event = 0;

if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

if (isset($_GET['event'])) {
    $event = $_GET['event'];
}

?>

        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card simple-card">
                            <div class="card-body">
                                <?php
                        $upr  =  user_pr(BULKIMAGES_FEATURE_ID);
                        $account = $upr['ptu']->active;
                        $limit = $upr['ptr']->quota;
                        $left = $limit - $upr['ptr']->used;

                        $full = false;
                        if ($left <= 0) {
                            $full = true;
                        }
                        ?>
                                    <h2 class="text-center mt-2 m-b-0">Bulk Scheduling <small> <label class="label label-default text-success">Experimental <i class="mdi mdi-help-circle-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Our Bulk upload feature is in beta version, if you find any bug please email it on info@adublisher.com"></i> </small></label>
                                    </h2>
                                    <p class="text-center text-muted m-b-0">
                                        Allowed <strong><?= $limit; ?> </strong> images in your current package. <strong id="left"><?= $left ?></strong> Left
                                    </p>
                                    <?php
                        echo @$upr['pxn'];
                        ?>
                                        <!-- ============================================================== -->
                                        <!-- End Bread crumb and right sidebar toggle -->
                                        <!-- ============================================================== -->
                                        <!-- ============================================================== -->
                                        <!-- Start Page Content -->
                                        <!-- ============================================================== -->
                                        <div class="row p-10 m-0">

                                            <?php
                            echo loader();
                            ?>
                                                <div class="col-md-12 col-xlg-12">
                                                    <!-- Column -->
                                                    <!-- card for channel settings -->
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h3 class="card-title">Select Channels <i class="fa fa-share"></i></h3>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <button type="button" class="btn btn-primary btn-sm pull-right float-right" data-toggle="modal" data-target="#channels_settings"> Settings</button>
                                                                </div>
                                                            </div>
                                                            <!-- #channel_settings -->
                                                            <div class="row">
                                                                <input type="hidden" id="action_name" value="" />
                                                                <div class="col-md-12 m-b-10" id="channels"></div>
                                                                <div class="col-md-12">
                                                                    <hr />
                                                                </div>
                                                                <div class="col-md-12 m-t-10">
                                                                    <h3 class="card-title">Create Your Post <i class="fa fa-pencil"></i> </h3>
                                                                    <textarea class="form-control" id="channel_title" name="channel_title" rows="3" placeholder="Enter your message here"></textarea>
                                                                    <div id="previewbox"></div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="content-wrap dropzonewidget">
                                                                        <div class="nest" id="DropZoneClose">
                                                                            <div class="title-alt">
                                                                            </div>
                                                                            <div class="body-nest " id="DropZone">
                                                                                <div id="myDropZone" class="dropzone min-250">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="float-right my-3">
                                                                        <button id="save" class="btn btn-info btn-md border ">Save</button>
                                                                        <button id="schedule" class="btn btn-info btn-md border ">Schedule</button>
                                                                        <button id="publish" class="btn btn-info  btn-md border ">Publish</button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <hr />
                                                                </div>

                                                                <div class="col-md-12 m-t-10 text-left">
                                                                    <b class="m-l-5">Filter </b> : <i class="mdi mdi-help-circle-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Here you can manage the existing posts on channels. Select channel to load posts"></i>
                                                                    <span class="channelsdisplay">
                                                    <select class="m-2 m-2 form-control w-25" id="channel_filter">
                                                        <option value="all" selected>All</option>
                                                        <?php
                                                        if (isset($user_pages)) {
                                                            foreach ($user_pages as $fb_page) {

                                                        ?>
                                                                <option value="<?= $fb_page->id; ?>"> <?= $fb_page->page_name; ?></option>
                                                            <?php

                                                            }
                                                        }
                                                        if (isset($pinterest_boards)) {
                                                            foreach ($pinterest_boards as $board_item) {

                                                            ?>
                                                                <option value="<?= $board_item->id; ?>"><?= $board_item->name; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </span>
                                                                    <button class="btn btn-outline-danger deleteall m-l-5  pull-right mr-3" style="display: none;"><i class="fa fa-trash pointer"></i> Delete All</button>
                                                                </div>
                                                            </div>
                                                            <div class="row m-t-10  el-element-overlay popup-gallery" id="sceduled"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <!-- popup modal to show facebook pages -->
                                        <div class="modal fade bd-example-modal-lg" id="channels_settings" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Channels Settings</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                                    </div>
                                                    <div class="modal-body ">

                                                        <div class="row">
                                                            <!-- <div class="col-md-12  px-3" > Connection Settings </div> -->
                                                            <div class="col-md-12  p-3">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <img style="width:40px;height:40px;" src="<?= GeneralAssets ?>images/facebook_logo.png" class="rounded" alt="profile_pic">
                                                                        <a href="<?php echo $this->facebook->login_url(); ?>" class="btn btn-info btn-sm">Authorize Facebook</a>
                                                                        <small class="m-2"> Missing page ? Click <a href="<?php echo $this->facebook->addpage_url(); ?>"> HERE </a> to add it. </small>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <img style="width:40px;height:40px;" src="<?= GeneralAssets ?>images/pinterest_logo.png" class="rounded" alt="profile_pic">
                                                                        <!-- <?php echo '<a  href=' . $pinterest_login_url . '>Authorize Pinterest</a>'; ?> -->
                                                                        <!-- make the above anchor link into button -->
                                                                        <a href="<?php echo $pinterest_login_url ?>" class="btn btn-danger btn-sm">Authorize Pinterest</a>

                                                                        <small class="m-2 "> Missing Boards ? Click <a href="<?php echo $pinterest_login_url ?>"> HERE </a> to add it. </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="col-5 d-inline m-3 pt-3">
                                                                            <label  class="mt-4"> <b> Select timeslot for all channels </b></label>
                                                                        </div>
                                                                        <div class="col-7 float-right  m-3 mr-2">
                                                                            <select id="all_channels_timeslots" multiple data-placeholder="Select Hours to post..." class="chosen-select chosen-all_channels_timeslots form-control">
                                                                                <?php
                                                                                for ($i = 0; $i < 24; $i++) {
                                                                                    if (in_array($i, $clean)) {
                                                                                ?>
                                                                                <option selected="selected" value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
                                                                                <?php
                                                                                } else {
                                                                                ?>
                                                                                    <option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                            
                                                                                    
                                                        <div class="row">

                                                            <div class="col-md-12">
                                                                <!-- table to show userpages with additional column to save the timeslots -->
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="col-md-4">Channels Names</th>
                                                                            <th class="col-md-8">Posting Hours</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                        foreach ($user_pages as $page_item) {
                                                        ?>
                                                                            <tr>
                                                                                <td class="title"> <img style="width:40px;height:40px;" src="<?= GeneralAssets ?>images/facebook_logo.png" class="rounded" alt="profile_pic"> <b><?php echo $page_item->page_name ?></b></td>

                                                                                <td>
                                                                                    <?php

                                                                    // $clean = array_filter(explode(',', $page_item->channel_slots));
                                                                    $clean = explode(',', $page_item->channel_slots);

                                                                    ?>

                                                                                        <select id="fbpages_timeslots<?= $page_item->id; ?>" multiple data-placeholder="Select Hours to post..." data-pageid="<?= $page_item->id; ?>" class="chosen-select chosen-fbpages_timeslots form-control">
                                                                        <?php
                                                                        for ($i = 0; $i < 24; $i++) {
                                                                            if (in_array($i, $clean)) {
                                                                        ?>
                                                                                <option selected="selected" value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                                </td>
                                                            </div>
                                                            </tr>
                                                            <?php
                                                        }
                                        ?>
                                                                <?php
                                        foreach ($pinterest_boards as $board_item) {
                                        ?>
                                                                    <tr>
                                                                        <td class="title"> <img style="width:40px;height:40px;" src="<?= GeneralAssets ?>images/pinterest_logo.png" class="rounded" alt="profile_pic"> <b><?php echo $board_item->name; ?></b></td>

                                                                        <td>
                                                                            <?php
                                                    $clean = explode(',', $board_item->channel_slots);
                                                    ?>
                                                                                <select id="boards_timeslots<?= $board_item->id; ?>" multiple data-placeholder="Select Hours to post..." data-boardid="<?= $board_item->id; ?>" class="chosen-select chosen-boards_timeslots form-control">
                                                        <?php
                                                        for ($i = 0; $i < 24; $i++) {
                                                            if (in_array($i, $clean)) {
                                                        ?>
                                                                <option selected="selected" value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                                        </td>
                                                        </div>
                                                        </tr>
                                                        <?php
                                        }
                                    ?>
                                                            </tbody>
                                                            </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- end card for channel settings -->

                                        <!-- ============================================================== -->
                                        <!-- End PAge Content -->
                                        <!-- ============================================================== -->


                                        <!-- ============================================================== -->
                                        <!-- End Container fluid  -->
                                        <!-- ============================================================== -->
                                        <!-- ============================================================== -->
                                        <?php $this->load->view('templates/publisher/footer'); ?>


                                        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
                                        <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
                                        <script src="<?= GeneralAssets ?>plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
                                        <script type="text/javascript">
                                            Dropzone.autoDiscover = false;
                                            $(function() {
                                                setTimeout(() => {
                                                    get_channels_scheduled();
                                                }, 1000);

                                                $('#channel_title').bind('input propertychange', function() {
                                                    var text = this.value;
                                                    // Parse the text for URLs
                                                    var urlRegex = /(https?:\/\/[^\s]+)/g;
                                                    var urls = text.match(urlRegex);
                                                    if (urls) {
                                                        if (urls.length > 0) {
                                                            $("#previewbox").html('<webhighlights-link-preview url="' + urls[0] + '"></webhighlights-link-preview>');
                                                            document.querySelectorAll('webhighlights-link-preview').forEach(element => element.addEventListener('click', () => window.open(element.getAttribute('url'), '_blank')));
                                                        } else {
                                                            $("#previewbox").html("");
                                                        }
                                                    } else {
                                                        $("#previewbox").html("");
                                                    }
                                                });

                                                $('.popup-gallery').magnificPopup({
                                                    delegate: 'a.gallery',
                                                    type: 'image',
                                                    tLoading: 'Loading image #%curr%...',
                                                    mainClass: 'mfp-img-mobile',
                                                    gallery: {
                                                        enabled: true,
                                                        navigateByImgClick: true
                                                    },
                                                    image: {
                                                        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                                                        titleSrc: function(item) {
                                                            return '<small>will be posted on </small> ' + item.el.attr('title');
                                                        }
                                                    }
                                                });

                                                var Current_File = 1;
                                                var myDropzone = new Dropzone("div#myDropZone", {
                                                    autoProcessQueue: false,
                                                    url: "<?php echo SITEURL; ?>save_channels_bulkupload",
                                                    maxFiles: 450,
                                                    paramName: "file",
                                                    maxFilesize: 10,
                                                    acceptedFiles: 'image/*',
                                                    parallelUploads: 50,
                                                    init: function() {
                                                        this.on("addedfile", function(file) {
                                                            var channel_title = $("#channel_title").val();
                                                        });
                                                        this.on("sending", function(file, xhr, data) {
                                                            data.append("totalfiles", this.getAcceptedFiles().length);
                                                            data.append("current_file", Current_File);
                                                            data.append("channel_title", $("#channel_title").val());
                                                            data.append("action", $("#action_name").val());
                                                            Current_File = Current_File + 1;
                                                        });
                                                        this.on("success", function(file, response) {
                                                            // console.log(response);

                                                            if (response.status) {
                                                                $("#left").text(parseInt($("#left").text()) - 1);
                                                                alertbox("Success", response.message, "success");
                                                                if ($("#action_name").val() != "publish") {
                                                                    get_channels_scheduled();
                                                                }

                                                            } else {
                                                                alertbox("Error", response.message, "error");
                                                            }
                                                        });
                                                        this.on("complete", function(file) {
                                                            // setTimeout(() => {
                                                            this.removeFile(file); // right here after 3 seconds you can clear
                                                            // }, 2000);
                                                            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                                                                // doSomething();
                                                                $("#channel_title").val('');

                                                            }
                                                        });
                                                    },
                                                    accept: function(file, done) {
                                                        done();
                                                    }
                                                });


                                                $("#schedule").click(function(e) {
                                                    $("#action_name").val("schedule");
                                                    var channel_title = $("#channel_title").val();
                                                    // if (channel_title == "") {
                                                    //     alertbox("Error", "Please Provide Post Title", "error");
                                                    // } else {
                                                        myDropzone.processQueue();

                                                    // }

                                                });

                                                $("#publish").click(function(e) {
                                                    $("#action_name").val("publish");
                                                    var channel_title = $("#channel_title").val();
                                                    // if (channel_title == "") {
                                                    //     alertbox("Error", "Please Provide Post Title", "error");
                                                    // } else {
                                                        myDropzone.processQueue();

                                                    // }
                                                });

                                                // $("#save").click(function(e) {
                                                //     $("#action_name").val("save");
                                                //     var channel_title = $("#channel_title").val();
                                                //     if (channel_title == "") {
                                                //         alertbox("Error", "Please Provide Post Title", "error");
                                                //     } else {
                                                //         myDropzone.processQueue();
                                                //         $("#channel_title").val('');
                                                //     }
                                                // });
                                                
                                                $("#publish").click(function(e) {
                                                    var channel_title = $("#channel_title").val();
                                                    if (channel_title != "") {
                                                        if (myDropzone.getAcceptedFiles().length == 0) {
                                                            var dataOBJ = {
                                                                'channel_title' : channel_title,
                                                            }
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "<?php echo SITEURL; ?>publish_channels_to_link",
                                                                data: dataOBJ,
                                                                dataType: "json",
                                                                success: function(response) {
                                                                    if (response.status) {
                                                                        alertbox("Success", response.message, "success");
                                                                        get_channels_scheduled();
                                                                        $("#channel_title").val('');
                                                                    } else {
                                                                        alertbox("Error", response.message, "error");
                                                                    }
                                                                }
                                                            });
                                                        }

                                                    }
                                                });
                                                
                                                $("#schedule").click(function(e) {
                                                    var channel_title = $("#channel_title").val();
                                                    if (channel_title != "") {
                                                        if (myDropzone.getAcceptedFiles().length == 0) {
                                                            var dataOBJ = {
                                                                'channel_title' : channel_title,
                                                            }
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "<?php echo SITEURL; ?>schedule_channels_to_link",
                                                                data: dataOBJ,
                                                                dataType: "json",
                                                                success: function(response) {
                                                                    if (response.status) {
                                                                        alertbox("Success", response.message, "success");
                                                                        get_channels_scheduled();
                                                                        $("#channel_title").val('');
                                                                    } else {
                                                                        alertbox("Error", response.message, "error");
                                                                    }
                                                                }
                                                            });
                                                        }

                                                    }
                                                });

                                                $(document).on('click', '#save', function() {
                                                    var channel_title = $("#channel_title").val();
                                                    // if (channel_title == "") {
                                                    //     alertbox("Error", "Please Provide Post Title", "error");
                                                    // } else {
                                                        if (myDropzone.getAcceptedFiles().length == 0) {
                                                            var dataOBJ = {
                                                                    'channel_title': channel_title,
                                                                }
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "<?php echo SITEURL; ?>save_channels_to_link",
                                                                data: dataOBJ,
                                                                dataType: "json",
                                                                success: function(response) {
                                                                    if (response.status) {
                                                                        alertbox("Success", response.message, "success");
                                                                        $("#previewbox").html("");
                                                                        $("#channel_title").val('');

                                                                    } else {
                                                                        alertbox("Error", response.message, "error");
                                                                    }
                                                                },
                                                                error: function() {
                                                                    alertbox("Failed", "Something went wrong please try agian", "error");
                                                                }
                                                            });
                                                        }

                                                    // }
                                                });


                                                // delbulkone
                                                $(document).on('click', '.delbulkone', function() {
                                                    id = $(this).data('id');
                                                    row = $("#card_" + id);
                                                    // console.log(id);

                                                    swal({
                                                        title: "Are you sure?",
                                                        text: "You will not be able to recover this post again!",
                                                        type: "warning",
                                                        showCancelButton: true,
                                                        confirmButtonColor: "#DD6B55",
                                                        confirmButtonText: "Yes, delete it!",
                                                        closeOnConfirm: false
                                                    }, function() {
                                                        var dataOBJ = {
                                                            'id': id
                                                        }
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "<?php echo SITEURL; ?>channel_bulk_scheduled_delete",
                                                            data: dataOBJ,
                                                            dataType: "json",
                                                            success: function(response) {
                                                                if (response.status) {
                                                                    $("#left").text(parseInt($("#left").text()) + 1);
                                                                    row.remove();
                                                                    swal({
                                                                        title: "Deleted!",
                                                                        text: "Your scheduled post Removed Successfully!",
                                                                        type: "success",
                                                                        showConfirmButton: false,
                                                                        timer: 1500

                                                                    });
                                                                }
                                                            },
                                                            error: function() {
                                                                // alertbox("Error" , "Nothing Has been deleted, try again" ,  "error");
                                                                swal("Error", "Nothing Has been deleted, please try again", "error");
                                                            }
                                                        });


                                                    });
                                                });


                                                // deleteall
                                                $(document).on('click', '.deleteall', function() {

                                                    // var page = $("#pages").val();
                                                    // var event = $("#events").val();
                                                    swal({
                                                        title: "Delete ALL Posts???",
                                                        text: "You will not be able to recover these posts again!",
                                                        type: "warning",
                                                        showCancelButton: true,
                                                        confirmButtonColor: "#DD6B55",
                                                        confirmButtonText: "Yes, delete ALL!",
                                                        closeOnConfirm: false
                                                    }, function() {

                                                        $("#loader").show();
                                                        channel_filter
                                                        var channel_filter = $("#channel_filter").val();
                                                        var dataOBJ = {
                                                            'channel': channel_filter,
                                                        }
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "<?php echo SITEURL; ?>channel_bulk_scheduled_delete_all",
                                                            data: dataOBJ,
                                                            // dataType: "json",
                                                            success: function(response) {
                                                                // myDropzone.removeAllFiles(true);
                                                                $(".deleteall").hide();
                                                                $("#loader").hide();
                                                                if (response.status) {
                                                                    $("#left").text(parseInt($("#left").text()) + parseInt(response.total));
                                                                    $("#sceduled").html("");
                                                                    swal({
                                                                        title: "Deleted!",
                                                                        text: "Your scheduled posts Removed Successfully!",
                                                                        type: "success",
                                                                        showConfirmButton: false,
                                                                        timer: 1500

                                                                    });

                                                                }
                                                            },
                                                            error: function() {
                                                                $("#loader").hide();
                                                                // alertbox("Error" , "Nothing Has been deleted, try again" ,  "error");
                                                                swal("Error", "Nothing Has been deleted, please try again", "error");
                                                            }
                                                        });


                                                    });
                                                })

                                                $(".chosen-select").chosen({
                                                    no_results_text: "Oops, nothing found!"
                                                });

                                            });

                                            function create_block(elem) {

                                                var node = '<div class="col-lg-3 col-md-6" id="card_' + elem.id + '">'
                                                node += '<div class="card blog-widget">'
                                                node += '<div class="card-body">'
                                                node += '<div class="blog-image cursor-pointer"><a class="gallery" href="' + SITEURL + 'assets/bulkuploads/' + elem.link + '" title="' + elem.post_date + '"><img  style="min-height:165px;" loading="lazy" src="' + SITEURL + 'assets/bulkuploads/' + elem.link + '" alt="img" class="img-fluid blog-img-height w-100" /></a></div>'
                                                node += '<p class="my-1" style="height:35px;overflow: auto;" ><strong> <i class="mdi mdi-closed-caption"></i> ' + elem.title + '</strong></p>'
                                                    // chech if type is facebook 
                                                if (elem.type == "facebook") {
                                                    node += '<button class="btn btn-rounded p-1 pr-2 m-2" style="border: 1px solid green; zoom:0.80;"> <p class="m-0"><img style="width:30px;height:30px;" src="<?= GeneralAssets ?>images/facebook_logo.png" class="rounded" alt="facebook_logo">' + elem.channel_name + '</p> </button>'


                                                } else if (elem.type == "pinterest") {
                                                    node += '<button class="btn btn-rounded p-1  pr-2 m-2" style="border: 1px solid green;zoom:0.80;"> <p class="m-0"><img style="width:30px;height:30px;" src="<?= GeneralAssets ?>images/pinterest_logo.png" class="rounded" alt="pinterest_logo">' + elem.channel_name + '</p> </button>'

                                                }

                                                var date = new Date(elem.post_date);
                                                const monthNames = ["January", "February", "March", "April", "May", "June",
                                                    "July", "August", "September", "October", "November", "December"
                                                ];
                                                var monthName = monthNames[date.getMonth()];

                                                var date_ = date.getDate() + " " + monthName + ", " + date.getFullYear();
                                                // var date_ = date.getDate();

                                                var day = date.getDay();
                                                var dayName = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                                                var dayName = dayName[day];
                                                // console.log(dayName);  
                                                if (elem.type == "pinterest" || elem.type == "facebook") {
                                                    node += '<div class="d-flex align-items-center" style=" border-top: 1px solid #e6dbdb; padding-top: 5px; ">'
                                                    node += '<div class="read"><a href="javascript:void(0);" class="link font-medium"> <i class="mdi mdi-calendar"></i> ' + elem.post_day + ' ' + elem.post_time + ' <br> &nbsp;&nbsp; &nbsp;&nbsp;' + elem.post_date + '</a></div>'
                                                    node += '<div class="ml-auto">'
                                                    node += '<a href="javascript:void(0);" class="link h5  cursor-pointer delbulkone"  data-id="' + elem.id + '"  data-toggle="tooltip" title="Delete this image" data-original-title="Delete"><i class="mdi mdi-delete-forever"></i></a>'
                                                    node += '</div>'
                                                    node += '</div>'
                                                } else {
                                                    node += '<div class="d-flex align-items-center" style=" border-top: 1px solid #e6dbdb; padding-top: 5px; ">'
                                                    node += '<div class="read"><a href="#" class="link font-medium"> <i class="mdi mdi-calendar"></i> ' + dayName + ' ' + elem.post_time + ' <br> &nbsp;&nbsp; &nbsp;&nbsp;' + date_ + '</a></div>'
                                                    node += '<div class="ml-auto">'
                                                    node += '<a href="javascript:void(0);" class="link h5  cursor-pointer delbulkone"  data-id="' + elem.id + '"  data-toggle="tooltip" title="Delete this image" data-original-title="Delete"><i class="mdi mdi-delete-forever"></i></a>'
                                                    node += '</div>'
                                                    node += '</div>'
                                                }
                                                return node;
                                            }

                                            $(document).ready(function() {

                                                var multipleCancelButton = new Choices('.choices-multiple-remove-button', {
                                                    removeItemButton: true,
                                                    // maxItemCount:5,
                                                    // searchResultLimit:5,
                                                    // renderChoiceLimit:5
                                                });
                                            });

                                            // $('#pinForm').submit(function(event) {
                                            //     event.preventDefault();

                                            //     if ($.trim($("#image").val()) === "" || $.trim($("#title").val()) === "" || $.trim($("#description").val()) === "") {
                                            //         alert('You did not fill out all the fields');
                                            //         return false;
                                            //     } else {

                                            //         var dataOBJ = {
                                            //             'image': $("#image").val(),
                                            //             'title': $("#title").val(),
                                            //             'description': $("#description").val(),
                                            //         }

                                            //         $.ajax({
                                            //             type: "POST",
                                            //             url: "<?php echo SITEURL; ?>create_pin",
                                            //             dataType: "json",
                                            //             data: dataOBJ,
                                            //             success: function(response) {
                                            //                 // alertbox('Success: ' + respone.success);
                                            //                 swal("Success:", response.success, "success");
                                            //             },
                                            //             error: function(response) {
                                            //                 // alertbox('Error: ' + respone.error);
                                            //                 swal("Error:", response.error, "error");
                                            //             }
                                            //         });
                                            //     }
                                            // });

                                            // var save_channel_settings = function(event) {
                                            //     event.preventDefault();
                                            //     // console.log($("#facebook").val());
                                            //     // console.log($("#pinterest").val());

                                            //     var dataOBJ = {
                                            //         'facebook': $("#facebook").val(),
                                            //         'pinterest': $("#pinterest").val(),
                                            //     }

                                            //     $.ajax({
                                            //         type: "POST",
                                            //         url: "<?php echo SITEURL; ?>channel_settings",
                                            //         dataType: "json",
                                            //         data: dataOBJ,
                                            //         success: function(response) {
                                            //             alertbox('Success: ' + response.success);
                                            //         },
                                            //         error: function(response) {
                                            //             alertbox('Error: ' + response.error);
                                            //         }
                                            //     });
                                            // }

                                            // if ($.trim($("#facebook").val()) === "" || $.trim($("#pinterest").val()) === "") {
                                            //     alertbox('You did not select out all the fields of channels');
                                            // }

                                            // if ($.trim($("#facebook").val()) !== "" || $.trim($("#pinterest").val()) !== "") {
                                            //     // $(document).change(save_channel_settings);
                                            //     $(".save_channel_settings").on('change', save_channel_settings);
                                            // } else {
                                            //     alertbox('You did not select out all the fields of channels');
                                            // }

                                            $(".chosen-boards_timeslots").on('change', function() {
                                                var board_id = $(this).data('boardid')
                                                var time_slots = $(this).val();

                                                var dataOBJ = {
                                                    'timeslots': time_slots,
                                                    'board_id': board_id,
                                                }
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo SITEURL; ?>boards_channel_slots",
                                                    data: dataOBJ,
                                                    dataType: "json",
                                                    success: function(response) {
                                                        if (response.status) {
                                                            alertbox("Success", response.message, "success");
                                                        } else {
                                                            alertbox("Error", response.message, "error");
                                                        }
                                                    },
                                                    error: function() {
                                                        alertbox("Error", "Something went wrong", "error");
                                                    }
                                                });
                                            });

                                            $(".chosen-fbpages_timeslots").on('change', function() {
                                                var page_id = $(this).data('pageid')
                                                var time_slots = $(this).val();

                                                var dataOBJ = {
                                                    'timeslots': time_slots,
                                                    'page_id': page_id,
                                                }
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo SITEURL; ?>fbpages_channel_slots",
                                                    data: dataOBJ,
                                                    dataType: "json",
                                                    success: function(response) {
                                                        if (response.status) {
                                                            alertbox("Success", response.message, "success");
                                                        } else {
                                                            alertbox("Error", response.message, "error");
                                                        }
                                                    },
                                                    error: function() {
                                                        alertbox("Error", "Something went wrong!", "error");
                                                    }
                                                });
                                            });
                                            $(".chosen-all_channels_timeslots").on('change', function() {
                                                var time_slots = $(this).val();
                                                var dataOBJ = {
                                                    'timeslots': time_slots,
                                                }
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo SITEURL; ?>all_channels_slots",
                                                    data: dataOBJ,
                                                    dataType: "json",
                                                    success: function(response) {
                                                      alertbox("Success", response.message, "success");
                                                        $(".chosen-fbpages_timeslots").val(time_slots);
                                                        $(".chosen-fbpages_timeslots").trigger("chosen:updated");
                                                        $(".chosen-boards_timeslots").val(time_slots);
                                                        $(".chosen-boards_timeslots").trigger("chosen:updated");
                                                    },
                                                    error: function() {
                                                        alertbox("Error", response.message, "error");
                                                    }
                                                });
                                            });

                                            $(document).on('change', '.fbpages_channel_active', function() {
                                                var id = $(this).data("id");
                                                var status_ = false;
                                                if (this.checked) {
                                                    status_ = true;
                                                }
                                                var dataOBJ = {
                                                    'id': id,
                                                    'status': status_
                                                }
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo SITEURL; ?>fbpages_channel_active",
                                                    data: dataOBJ,
                                                    dataType: "json",
                                                    success: function(response) {
                                                        if (response.status) {
                                                            alertbox("Success", "Page Auto Posting Updated Successfully", "success");
                                                        }
                                                    },
                                                    error: function() {
                                                        alertbox("Error", "Nothing Has been changed, try again", "error");
                                                    }
                                                });
                                            });

                                            $(document).on('change', '.boards_channel_active', function() {
                                                var id = $(this).data("id");
                                                var status_ = false;
                                                if (this.checked) {
                                                    status_ = true;
                                                }
                                                var dataOBJ = {
                                                    'id': id,
                                                    'status': status_
                                                }
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo SITEURL; ?>boards_channel_active",
                                                    data: dataOBJ,
                                                    dataType: "json",
                                                    success: function(response) {
                                                        if (response.status) {
                                                            alertbox("Success", "Page Auto Posting Updated Successfully", "success");
                                                        }
                                                    },
                                                    error: function() {
                                                        alertbox("Error", "Nothing Has been changed, try again", "error");
                                                    }
                                                });
                                            });

                                            var get_channels_settings = function() {
                                                // console.log("modal closed");
                                                $.ajax({
                                                    type: "GET",
                                                    url: "<?php echo SITEURL; ?>get_channels_settings",
                                                    dataType: "json",
                                                    success: function(response) {
                                                        if (response.status) {
                                                            // console.log(response);
                                                            // respone.data
                                                            $("#channels").html("");
                                                            if (response.data.fbpages.length > 0) {

                                                                $.each(response.data.fbpages, function(index, value) {
                                                                    if (value.channel_active == 1) {
                                                                        $("#channels").append("<button class='btn btn-rounded p-0 pr-2 m-2 fb_channel' data-id='" + value.id + "' style='border: 2px solid green;'><img style='width:40px;height:40px;' src='<?= GeneralAssets ?>images/facebook_logo.png' class='rounded' alt='profile_pic'> " + value.page_name + "</button>");
                                                                    } else {
                                                                        $("#channels").append("<button class='btn btn-rounded p-0 pr-2 m-2 fb_channel active' data-id='" + value.id + "' ><img style='width:40px;height:40px;' src='<?= GeneralAssets ?>images/facebook_logo.png' class='rounded' alt='profile_pic'> " + value.page_name + "</button>");
                                                                    }
                                                                });
                                                            }

                                                            if (response.data.boards.length > 0) {
                                                                // $("#channels").append("<div class='col-md-12'><h4>Pinterest Boards</h4></div>");
                                                                $.each(response.data.boards, function(index, value) {
                                                                    if (value.channel_active == 1) {
                                                                        $("#channels").append("<button class='btn btn-rounded p-0 pr-2 m-2 board_channel' data-id='" + value.id + "' style='border: 2px solid green;'><img style='width:40px;height:40px;' src='<?= GeneralAssets ?>images/pinterest_logo.png' class='rounded' alt='profile_pic'> " + value.name + "</button>");
                                                                    } else {
                                                                        $("#channels").append("<button class='btn btn-rounded p-0 pr-2 m-2 board_channel active' data-id='" + value.id + "' ><img style='width:40px;height:40px;' src='<?= GeneralAssets ?>images/pinterest_logo.png' class='rounded' alt='profile_pic'> " + value.name + "</button>");
                                                                    }
                                                                });
                                                            }
                                                        } else {
                                                            alertbox("Error", "Channels Not Found", "error");
                                                        }
                                                    },
                                                    error: function() {
                                                        alertbox("Error", "Channels Not Found", "error");
                                                    }
                                                });
                                            }

                                            $(document).ready(get_channels_settings);

                                            // when click on button class=fb_channel_active then call this function which make the channel active and inactive 
                                            $(document).on("click", ".fb_channel", function() {
                                                var id = $(this).data("id");
                                                var dataOBJ = {
                                                    'channel_id': id
                                                }
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo SITEURL; ?>fb_channel_active",
                                                    data: dataOBJ,
                                                    dataType: "json",
                                                    success: function(response) {
                                                        if (response.status) {
                                                            alertbox("Success", "Channel Status Changed Successfully", "success");
                                                            get_channels_settings();
                                                        } else {
                                                            alertbox("Error", "Channel Status Not Changed", "error");
                                                        }
                                                    },
                                                    error: function() {
                                                        alertbox("Error", "Channel Status Not Changed", "error");
                                                    }
                                                });
                                            });

                                            $(document).on("click", ".board_channel", function() {
                                                var id = $(this).data("id");
                                                var dataOBJ = {
                                                    'channel_id': id,
                                                }
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo SITEURL; ?>board_channel_active",
                                                    data: dataOBJ,
                                                    dataType: "json",
                                                    success: function(response) {
                                                        if (response.status) {
                                                            alertbox("Success", "Channel Status Changed Successfully", "success");
                                                            get_channels_settings();
                                                        } else {
                                                            alertbox("Error", "Channel Status Not Changed", "error");
                                                        }
                                                    },
                                                    error: function() {
                                                        alertbox("Error", "Channel Status Not Changed", "error");
                                                    }
                                                });
                                            });

                                            var get_channels_scheduled = function() {
                                                $("#loader").show();
                                                var channel = $("#channel_filter").val();
                                                $.ajax({
                                                    type: "GET",
                                                    url: "<?php echo SITEURL; ?>get_channels_scheduled?channel=" + channel,
                                                    dataType: "json",
                                                    success: function(response) {
                                                        if (response.status) {
                                                            $("#sceduled").html("");
                                                            if (response.data) {
                                                                $(".deleteall").show();
                                                            }
                                                            $.each(response.data, function(index, elem) {
                                                                tr = create_block(elem);
                                                                $("#sceduled").append(tr);
                                                            });
                                                        }
                                                        $("#loader").hide();
                                                    },
                                                    error: function() {
                                                        $("#sceduled").html("");
                                                        $("#loader").hide();
                                                    }
                                                });
                                            }
                                            $(document).on("change", "#channel_filter", get_channels_scheduled);
                                        </script>