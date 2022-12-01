function get_county(e) {
    var t = "undefined" == typeof type_search ? "" : "search";
    return false;
    $.ajax({
        url: base_url + "home/get_county/",
        type: "POST",
        data: { v: e, type: t },
        success: function (e) {
            $('select[name="county"]').html(e);
            var t = getUrlParameter("county"),
                n = $('select[name="county"]').attr("data-value");
            null != n && "" != n && (t = n), null != t && "" != t && ((t = t.split("+").join(" ")), $('select[name="county"]').val(t));
        },
    });
}
$(document).ready(function () {
    get_county($('select[name="region"]').val()),
        $('select[name="region"]').change(function () {
            get_county($(this).val());
        }),
        $(".viewby .btn-secondary").click(function () {
            if ($(this).hasClass("active")) return !1;
            var e = $(this).attr("data-value"),
                i = "";
            -1 < document.location.search.indexOf("&") &&
                $.each(document.location.search.substr(1).split("&"), function (e, t) {
                    var n = t.split("=");
                    "q" != n[0] && "per_page" != n[0] && (i = i + "&" + n[0] + "=" + n[1]);
                }),
                (i = "?q=true&per_page=" + e + i),
                (window.location.href = i);
        }),
        $(".listing-section .item .item-img .maker-like,.listing-bx .maker-like,.listing-detail .maker-like").click(function () {
            var e = $(this).attr("href"),
                t = $(this);
            if ("#" != e)
                return (
                    $(".custom-loading").show(),
                    $.ajax({
                        url: e,
                        dataType: "JSON",
                        type: "post",
                        success: function (e) {
                            "success" == e.status &&
                                ("actived" == e.message
                                    ? (0 < $(".listing-bx .maker-like").length && ($(".listing-bx .maker-like").addClass("actived"), $(".listing-detail .maker-like").addClass("actived")), t.addClass("actived"))
                                    : (t.removeClass("actived"), 0 < $(".listing-bx .maker-like").length && ($(".listing-bx .maker-like").removeClass("actived"), $(".listing-detail .maker-like").removeClass("actived"))));
                        },
                        error: function (e) {},
                        complete: function () {
                            $(".custom-loading").hide();
                        },
                    }),
                    !1
                );
        });
});
var getUrlParameter = function (e) {
    var t,
        n,
        i = window.location.search.substring(1).split("&");
    for (n = 0; n < i.length; n++) if ((t = i[n].split("="))[0] === e) return void 0 === t[1] || decodeURIComponent(t[1]);
};
function format_currency(e) {
    return (
        "$" +
        parseFloat(e)
            .toFixed(2)
            .split(".")[0]
            .split("")
            .reverse()
            .reduce(function (e, t, n, i) {
                return "-" == t ? e : t + (!n || n % 3 ? "" : ",") + e;
            }, "")
    );
}
function format_currency_2(e) {
    return "$" + parseFloat(e).toFixed(0);
}
function get_only_number(e) {
    return e.replace(/[^\d.-]/g, "");
}
function setCookie(e, t, n) {
    var i = new Date();
    i.setTime(i.getTime() + 24 * n * 60 * 60 * 1e3);
    var a = "expires=" + i.toUTCString();
    document.cookie = e + "=" + t + ";" + a + ";path=/";
}
function getCookie(e) {
    for (var t = e + "=", n = document.cookie.split(";"), i = 0; i < n.length; i++) {
        for (var a = n[i]; " " == a.charAt(0); ) a = a.substring(1);
        if (0 == a.indexOf(t)) return a.substring(t.length, a.length);
    }
    return "";
}
function checkCookie() {
    var e = getCookie("username");
    "" != e ? alert("Welcome again " + e) : "" != (e = prompt("Please enter your name:", "")) && null != e && setCookie("username", e, 365);
}
