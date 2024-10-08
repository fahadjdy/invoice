document.addEventListener("DOMContentLoaded", function(e) {
    setTimeout(function() {
        var r = new Isotope(".gallery-wrapper", {
            itemSelector: ".element-item",
            layoutMode: "fitRows"
        });
        document.querySelector(".categories-filter").addEventListener("click", function(e) {
            var t;
            matchesSelector(e.target, "li a") && (t = e.target.getAttribute("data-filter"), r.arrange({
                filter: t
            }))
        });
        for (var e = document.querySelectorAll(".categories-filter"), t = 0, a = e.length; t < a; t++) {
            ! function(t) {
                t.addEventListener("click", function(e) {
                    matchesSelector(e.target, "li a") && (t.querySelector(".active").classList.remove("active"), e.target.classList.add("active"))
                })
            }(e[t])
        }
    }, 0)
});