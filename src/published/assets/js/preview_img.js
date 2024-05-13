
$('body').on({
    mouseenter: function (e) {

        var x = e.screenX;
        var y = e.screenY;
        var scrW = $("#screenshot").width();
        var scrH = $("#screenshot").height();
        if (x <= 600) {
            var set = 70;
            var shet = (scrH / 2);
            xOffset = shet;
            yOffset = set;
        } else {
            var set = scrW + 70;
            var shet = (scrH / 2);
            xOffset = shet;
            yOffset = -set;
        }
        if (y >= 700) {
            var shet = scrH + 70;
            xOffset = shet;
        } else if (y <= 250) {
            var shet = (scrH / 4) - 50;
            xOffset = shet;
        }


        this.t = this.title;
        this.title = "";
        var c = (this.t != "") ? "<br/>" + this.t : "";
        $("body").append("<p id='screenshot'><img src='" + this.rel + "'  /></p>");
        $("#screenshot")
            .css("top",(e.pageY - xOffset) + "px")
            .css("left",(e.pageX + yOffset) + "px")
            .fadeIn("slow");
    },
    mouseleave: function () {
        this.title = this.t;
        $("#screenshot").remove();
    }
}, 'a.screenshot');

