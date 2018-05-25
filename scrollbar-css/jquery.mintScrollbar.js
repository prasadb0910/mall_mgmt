/*!
 * mintScrollbar v0.1.1
 * http://cople.github.com/mintScrollbar/
 */
(function(factory) {
    if (typeof define === "function" && define.amd) {
        define(["jquery"], factory);
    } else if (typeof exports === "object") {
        factory(require("jquery"));
    } else {
        factory(jQuery);
    };
})(function($) {
    "use strict";

    var isMobile = /Android|iP(hone|od|ad)|webOS|BlackBerry|Opera Mini|Mobile/i.test(window.navigator.userAgent);

    var defaultOptions = {
        onChange: null,
        axis: "auto",
        wheelSpeed: 120,
        disableOnMobile: true
    };

    function mintScrollbar(target, options) {
        var self = this,
            callback = function() {},
            axisXActive = false,
            axisYActive = false,
            $doc = $(document),
            $target = $(target),
            _$scrollbar = $("<div class='mintScrollbar' />"),
            $scrollbarX = _$scrollbar.clone().addClass("mintScrollbar__x"),
            $scrollbarY = _$scrollbar.clone().addClass("mintScrollbar__y"),
            _$thumb = $("<div class='mintScrollbar__thumb' />"),
            $thumbX = _$thumb.clone().addClass("mintScrollbar__x__thumb"),
            $thumbY = _$thumb.clone().addClass("mintScrollbar__y__thumb"),
            $viewport,
            viewport,
            scrollWidth,
            scrollHeight,
            viewportWidth,
            viewportHeight,
            scrollMaxX,
            scrollMaxY,
            scrollbarXLeft,
            scrollbarYTop,
            scrollbarXWidth,
            scrollbarYHeight,
            thumbXMaxLeft,
            thumbYMaxTop,
            thumbXWidth,
            thumbYHeight,
            touchX,
            touchY;

        this.resize = function() {
            if (axisXActive) {
                scrollWidth = viewport.scrollWidth;
                viewportWidth = $viewport.width();
                scrollMaxX = scrollWidth - viewportWidth;
                scrollbarXWidth = $scrollbarX.width();
                thumbXWidth = Math.max(20, Math.round(scrollbarXWidth / scrollWidth * scrollbarXWidth));
                thumbXMaxLeft = scrollbarXWidth - thumbXWidth;
                $thumbX.css("width", thumbXWidth);
            };

            if (axisYActive) {
                scrollHeight = viewport.scrollHeight;
                viewportHeight = $viewport.height();
                scrollMaxY = scrollHeight - viewportHeight;
                scrollbarYHeight = $scrollbarY.height();
                thumbYHeight = Math.max(20, Math.round(scrollbarYHeight / scrollHeight * scrollbarYHeight));
                thumbYMaxTop = scrollbarYHeight - thumbYHeight;
                $thumbY.css("height", thumbYHeight);
            };
        };

        this.update = function() {
            if (axisXActive) {
                scrollbarXLeft = Math.round(viewport.scrollLeft / scrollMaxX * thumbXMaxLeft);
                $thumbX.css("left", scrollbarXLeft);
            };

            if (axisYActive) {
                scrollbarYTop = Math.round(viewport.scrollTop / scrollMaxY * thumbYMaxTop);
                $thumbY.css("top", scrollbarYTop);
            };

            callback();
        };

        this.destroy = function() {
            var _scrollTop = viewport.scrollTop,
                _scrollLeft = viewport.scrollLeft;
            $target.removeData("mintScrollbar").removeClass("mintScrollbar__container").append($viewport.children());
            $viewport.remove();
            $scrollbarX.remove();
            $scrollbarY.remove();
            target.scrollLeft = _scrollLeft;
            target.scrollTop = _scrollTop;
        };

        this.scrollTo = function(destX, destY) {
            viewport.scrollLeft = destX;
            viewport.scrollTop = destY;
            self.update();
        };

        this.scrollToX = function(destX) {
            viewport.scrollLeft = destX;
            self.update();
        };

        this.scrollToY = function(destY) {
            viewport.scrollTop = destY;
            self.update();
        };

        this.scrollBy = function(deltaX, deltaY) {
            self.scrollTo(viewport.scrollLeft + deltaX, viewport.scrollTop + deltaY);
        };

        this.scrollByX = function(deltaX) {
            self.scrollToX(viewport.scrollLeft + deltaX);
        };

        this.scrollByY = function(deltaY) {
            self.scrollToY(viewport.scrollTop + deltaY);
        };

        this.scrollByLines = function(lines) {
            var lineHeight = parseInt($target.css("lineHeight"), 10);
            self.scrollByY((isNaN(lineHeight) ? (parseInt($target.css("fontSize"), 10) * 1.5) : lineHeight) * lines);
        };

        this.scrollByPages = function(pages) {
            self.scrollByY(viewportHeight * pages);
        };

        function scrollbarToX(destX) {
            scrollbarXLeft = Math.min(thumbXMaxLeft, Math.max(0, destX));
            $thumbX.css("left", scrollbarXLeft);
            viewport.scrollLeft = scrollbarXLeft / thumbXMaxLeft * scrollMaxX;
            callback();
        };

        function scrollbarToY(destY) {
            scrollbarYTop = Math.min(thumbYMaxTop, Math.max(0, destY));
            $thumbY.css("top", scrollbarYTop);
            viewport.scrollTop = scrollbarYTop / thumbYMaxTop * scrollMaxY;
            callback();
        };

        function bindEvents() {
            if (axisXActive) {
                $scrollbarX.on("click", function(e) {
                    if (e.target == this) {
                        scrollbarToX(e.offsetX - thumbXWidth / 2);
                    };
                });

                $thumbX.on("mousedown", function(e) {
                    var _x = e.pageX;
                    $viewport.addClass("mintScrollbar__viewport--active");
                    e.preventDefault();

                    $doc.on("mousemove.mintScrollbar", function(e) {
                        scrollbarToX(scrollbarXLeft + e.pageX - _x);
                        _x = e.pageX;
                        e.preventDefault();
                    }).one("mouseup", function() {
                        $viewport.removeClass("mintScrollbar__viewport--active");
                        $doc.off(".mintScrollbar");
                    });
                });
            };

            if (axisYActive) {
                $scrollbarY.on("click", function(e) {
                    if (e.target == this) {
                        scrollbarToY(e.offsetY - thumbYHeight / 2);
                    };
                });

                $thumbY.on("mousedown", function(e) {
                    var _y = e.pageY;
                    $viewport.addClass("mintScrollbar__viewport--active");
                    e.preventDefault();

                    $doc.on("mousemove.mintScrollbar", function(e) {
                        scrollbarToY(scrollbarYTop + e.pageY - _y);
                        _y = e.pageY;
                        e.preventDefault();
                    }).one("mouseup", function() {
                        $viewport.removeClass("mintScrollbar__viewport--active");
                        $doc.off(".mintScrollbar");
                    });
                });
            };

            $viewport.on("mousewheel", function(e) {
                if (axisYActive) {
                    var y = viewport.scrollTop + e.deltaY * -options.wheelSpeed;
                    self.scrollToY(y);
                    if (y > -options.wheelSpeed && y < scrollHeight - viewportHeight + options.wheelSpeed) {
                        e.stopPropagation();
                        e.preventDefault();
                    };
                } else {
                    var x = viewport.scrollLeft + (e.deltaX || e.deltaY) * -options.wheelSpeed;
                    self.scrollToX(x);
                    if (x > -options.wheelSpeed && x < scrollWidth - viewportWidth + options.wheelSpeed) {
                        e.stopPropagation();
                        e.preventDefault();
                    };
                };
            });

            $viewport.on("touchstart", function(e) {
                var touch = e.originalEvent.touches[0];

                touchX = touch.pageX;
                touchY = touch.pageY;

                $viewport.addClass("mintScrollbar__viewport--active");

                e.preventDefault();
            }).on("touchmove", function(e) {
                var touch = e.originalEvent.changedTouches[0];

                if (axisXActive) {
                    self.scrollToX(viewport.scrollLeft - (touch.pageX - touchX));
                    touchX = touch.pageX;
                };
                if (axisYActive) {
                    self.scrollToY(viewport.scrollTop - (touch.pageY - touchY));
                    touchY = touch.pageY;
                };

                e.preventDefault();
                e.stopPropagation();
            }).on("touchend touchcancel", function() {
                $viewport.removeClass("mintScrollbar__viewport--active");
            });

            $viewport.attr("tabindex", 0).on("keydown", function(e) {

                if ($(e.target).is(":input, [contenteditable]")) {
                    return;
                };

                var deltaSpeed = options.wheelSpeed / 2,
                    deltaX = 0,
                    deltaY = 0;

                switch (e.which) {
                    case 37: // Left
                        deltaX = -deltaSpeed;
                        break;
                    case 38: // Up
                        deltaY = -deltaSpeed;
                        break;
                    case 39: // Right
                        deltaX = deltaSpeed;
                        break;
                    case 40: // Down
                        deltaY = deltaSpeed;
                        break;
                    case 33: // Page Up
                        deltaY = -viewportHeight;
                        break;
                    case 32: // Spacebar
                    case 34: // Page Down
                        deltaY = viewportHeight;
                        break;
                    case 36: // Home
                        deltaY = -scrollHeight;
                        break;
                    case 35: // End
                        deltaY = scrollHeight;
                        break;
                    default:
                        return;
                };

                if (axisXActive) self.scrollByX(deltaX);
                if (axisYActive) self.scrollByY(deltaY);

                e.stopPropagation();
                e.preventDefault();
            });
        };

        function initialize() {
            if (typeof options.onChange == "function") {
                callback = function() {
                    options.onChange.call(viewport);
                };
            };

            var _scrollLeft = target.scrollLeft,
                _scrollTop = target.scrollTop;

            if (options.axis == "auto") {
                target.style.overflow = "auto";
                if (target.scrollWidth > $target.width()) axisXActive = true;
                if (target.scrollHeight > $target.height()) axisYActive = true;
                target.style.overflow = "";
            } else {
                if (options.axis == "both" || options.axis == "x") axisXActive = true;
                if (options.axis == "both" || options.axis == "y") axisYActive = true;
            };

            $target.addClass("mintScrollbar__container").wrapInner("<div class='mintScrollbar__viewport' />");

            $viewport = $target.children();
            viewport = $viewport.get(0);

            if (axisXActive) $scrollbarX.append($thumbX).appendTo($target);
            if (axisYActive) $scrollbarY.append($thumbY).appendTo($target);

            bindEvents();

            self.resize();
            self.scrollTo(_scrollLeft, _scrollTop);
        };

        initialize();
    };

    $.fn.mintScrollbar = function(options) {
        options = $.extend({}, defaultOptions, options);
        return (options.disableOnMobile && isMobile) ? this : this.each(function() {
            var $this = $(this);
            if (!$this.data("mintScrollbar")) {
                $this.data("mintScrollbar", new mintScrollbar(this, options));
            };
        });
    };
});