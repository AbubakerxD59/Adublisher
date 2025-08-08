<!-- 100% privacy-first analytics -->
<script async src="https://scripts.simpleanalyticscdn.com/latest.js"></script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-KDZLGC950R"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'G-KDZLGC950R');
</script>
<!-- Google tag (gtag.js) -->

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-1217ND3ZLP"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'G-1217ND3ZLP');
</script>

<!-- Hotjar Tracking Code for Adublisher -->
<script>
  (function(h, o, t, j, a, r) {
    h.hj = h.hj || function() {
      (h.hj.q = h.hj.q || []).push(arguments)
    };
    h._hjSettings = {
      hjid: 5099239,
      hjsv: 6
    };
    a = o.getElementsByTagName('head')[0];
    r = o.createElement('script');
    r.async = 1;
    r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
    a.appendChild(r);
  })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
</script>

<script data-cfasync="false"
  nonce="175b7791-5edd-4016-a25f-9317a4848d67">
  try {
    (function(w, d) {
      ! function(bz, bA, bB, bC) {
        if (bz.zaraz) console.error("zaraz is loaded twice");
        else {
          bz[bB] = bz[bB] || {};
          bz[bB].executed = [];
          bz.zaraz = {
            deferred: [],
            listeners: []
          };
          bz.zaraz._v = "5853";
          bz.zaraz._n = "175b7791-5edd-4016-a25f-9317a4848d67";
          bz.zaraz.q = [];
          bz.zaraz._f = function(bD) {
            return async function() {
              var bE = Array.prototype.slice.call(arguments);
              bz.zaraz.q.push({
                m: bD,
                a: bE
              })
            }
          };
          for (const bF of ["track", "set", "debug"]) bz.zaraz[bF] = bz.zaraz._f(bF);
          bz.zaraz.init = () => {
            var bG = bA.getElementsByTagName(bC)[0],
              bH = bA.createElement(bC),
              bI = bA.getElementsByTagName("title")[0];
            bI && (bz[bB].t = bA.getElementsByTagName("title")[0].text);
            bz[bB].x = Math.random();
            bz[bB].w = bz.screen.width;
            bz[bB].h = bz.screen.height;
            bz[bB].j = bz.innerHeight;
            bz[bB].e = bz.innerWidth;
            bz[bB].l = bz.location.href;
            bz[bB].r = bA.referrer;
            bz[bB].k = bz.screen.colorDepth;
            bz[bB].n = bA.characterSet;
            bz[bB].o = (new Date).getTimezoneOffset();
            if (bz.dataLayer)
              for (const bJ of Object.entries(Object.entries(dataLayer).reduce(((bK, bL) => ({
                  ...bK[1],
                  ...bL[1]
                })), {}))) zaraz.set(bJ[0], bJ[1], {
                scope: "page"
              });
            bz[bB].q = [];
            for (; bz.zaraz.q.length;) {
              const bM = bz.zaraz.q.shift();
              bz[bB].q.push(bM)
            }
            bH.defer = !0;
            for (const bN of [localStorage, sessionStorage]) Object.keys(bN || {}).filter((bP => bP.startsWith("_zaraz_"))).forEach((bO => {
              try {
                bz[bB]["z_" + bO.slice(7)] = JSON.parse(bN.getItem(bO))
              } catch {
                bz[bB]["z_" + bO.slice(7)] = bN.getItem(bO)
              }
            }));
            bH.referrerPolicy = "origin";
            bH.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(bz[bB])));
            bG.parentNode.insertBefore(bH, bG)
          };
          ["complete", "interactive"].includes(bA.readyState) ? zaraz.init() : bz.addEventListener("DOMContentLoaded", zaraz.init)
        }
      }(w, d, "zarazData", "script");
      window.zaraz._p = async dq => new Promise((dr => {
        if (dq) {
          dq.e && dq.e.forEach((ds => {
            try {
              const dt = d.querySelector("script[nonce]"),
                du = dt?.nonce || dt?.getAttribute("nonce"),
                dv = d.createElement("script");
              du && (dv.nonce = du);
              dv.innerHTML = ds;
              dv.onload = () => {
                d.head.removeChild(dv)
              };
              d.head.appendChild(dv)
            } catch (dw) {
              console.error(`Error executing script: ${ds}\n`, dw)
            }
          }));
          Promise.allSettled((dq.f || []).map((dx => fetch(dx[0], dx[1]))))
        }
        dr()
      }));
      zaraz._p({
        "e": ["(function(w,d){})(window,document)"]
      });
    })(window, document)
  } catch (e) {
    throw fetch("/cdn-cgi/zaraz/t"), e;
  };
</script>