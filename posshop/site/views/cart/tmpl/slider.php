<script type="text/javascript">
    var sliders = [];
    function createSlider(id, dom, event, lang, top, bottom, displayScale, realScale, keyIncrement) {
        slider = YAHOO.widget.Slider.getHorizSlider('slider-bg' + id, 'slider-thumb' + id, top, bottom, keyIncrement);
        slider.subscribe("change", function (offsetFromStart) {
            var percentValue = dom.get('sv' + id);
            var displayValue = dom.get('scv' + id);
            var realValue = dom.get('srv' + id);
            percentValue.innerHTML = offsetFromStart;

            displayValue.innerHTML = Math.round(offsetFromStart * displayScale);
            realValue.value = Math.round(offsetFromStart * realScale);
            dom.get('slider-bg' + id).title = offsetFromStart + "%";
        });
        // set an initial value
        slider.setValue(0);
        dom.get('slider-bg' + id).title = "slider value = 0%";

        var ids = id.split("_");
		if (!(ids[0] in sliders)) {
			sliders[ids[0]] = [];
		}
        sliders[ids[0]][ids[1]] = slider;
    }

    (function () {
        var event = YAHOO.util.Event,
                dom = YAHOO.util.Dom,
                lang = YAHOO.lang;

        event.onDOMReady(function () {
		<?php
			foreach ($sliders as $slider) {
				echo "createSlider('" . $slider[0] . "', dom, event, lang, 0, 200, " . ($slider[1] / 100) . ", ". ($slider[2] / 100) . ", 25);\n";
			}
		?>
        })
    })();

    function setAll(id, state) {
        var cur_check = 1;
        for (i = 1; i < (sliders[id].length); i++) {
            sliders[id][i].setValue(state ? 100 : 0, false);
        }
    }
</script>
