$(document).ready(function(){

    var saveCahrtPints = '1200';
    var timeFormat = 'YYYY-MM-DD HH:mm:ss';
    var refreshTime = 5000;
    
    var chartQ1 = new Chartist.Line('.ct-chart-q1', {
        series: [
            {
            name: 'series-Q1',
            data: []
            }
        ]
        }, {
        showPoint: false,
        axisX: {
            type: Chartist.FixedScaleAxis,
            divisor: 5,
            labelInterpolationFnc: function(value) {
            return moment(value).format(timeFormat);
            }
        }
        });

        var chartT1 = new Chartist.Line('.ct-chart-t1', {
            series: [
                {
                name: 'series-T1',
                data: []
                }
            ]
            }, {
            showPoint: false,
            axisX: {
                type: Chartist.FixedScaleAxis,
                divisor: 5,
                labelInterpolationFnc: function(value) {
                return moment(value).format(timeFormat);
                }
            }
            });

            var chartP1 = new Chartist.Line('.ct-chart-p1', {
                series: [
                    {
                    name: 'series-P1',
                    data: []
                    }
                ]
                }, {
                showPoint: false,
                axisX: {
                    type: Chartist.FixedScaleAxis,
                    divisor: 5,
                    labelInterpolationFnc: function(value) {
                    return moment(value).format(timeFormat);
                    }
                }
                });
        
    loadLimits();
   
    document.getElementById('q1save').onclick=function(){
        saveLimits('q1');
    }
    
    document.getElementById('t1save').onclick=function(){
        saveLimits('t1');
    }

    document.getElementById('p1save').onclick=function(){
        saveLimits('p1');
    }

    var timerId = setTimeout(function tick() {
        loadValues();
        checkSaveLimits('q1');
        checkSaveLimits('t1');
        checkSaveLimits('p1');
    
        timerId = setTimeout(tick, refreshTime);
    }, refreshTime);

    function loadValues(success) {
        $.get("load.php", function(data){
            var duce = jQuery.parseJSON(data);
            var q1 = duce.q1;
            var t1 = duce.t1;
            var p1 = duce.p1;
            $('#q1').html(q1);
            checkValue('q1');
            $('#t1').html(t1);
            checkValue('t1');
            $('#p1').html(p1);
            checkValue('p1');

            chartQ1Add(q1);
            chartT1Add(t1);
            chartP1Add(p1);
        });
    }

    function checkValue(valStr) {
        var val = document.getElementById(valStr).innerHTML;
        var valMin = document.getElementById(valStr+'min').value;
        var valMax = document.getElementById(valStr+'max').value;
        if ((val-valMin < 0) || (val-valMax > 0)) {
            document.getElementById(valStr+'body').style.backgroundColor='#FF5300';
        } else {
            document.getElementById(valStr+'body').style.backgroundColor='#250672';
            
        };
    }

    function loadLimits() {
        if(getCookie('p1min') != null){
            document.getElementById('p1min').value = getCookie('p1min');
        };

        if(getCookie('p1max') != null){
            document.getElementById('p1max').value = getCookie('p1max');
        };
        
        if(getCookie('q1max') != null){
            document.getElementById('q1max').value = getCookie('q1max');
        };

        if(getCookie('q1min') != null){
            document.getElementById('q1min').value = getCookie('q1min');
        };

        if(getCookie('t1max') != null){
            document.getElementById('t1max').value = getCookie('t1max');
        };

        if(getCookie('t1min') != null){
            document.getElementById('t1min').value = getCookie('t1min');
        };
    }

    function saveLimits(valStr) {
        setCookie(valStr+'min', document.getElementById(valStr+'min').value, 365);
        setCookie(valStr+'max', document.getElementById(valStr+'max').value, 365);
        document.getElementById(valStr+'min').style.backgroundColor='';
        document.getElementById(valStr+'max').style.backgroundColor='';
    }

    function checkSaveLimits(valStr) {
        if(getCookie(valStr+'min') == document.getElementById(valStr+'min').value) {
            document.getElementById(valStr+'min').style.backgroundColor='';
        } else {
            document.getElementById(valStr+'min').style.backgroundColor='#FFDFDF';
        }

        if(getCookie(valStr+'max') == document.getElementById(valStr+'max').value) {
            document.getElementById(valStr+'max').style.backgroundColor='';
        } else {
            document.getElementById(valStr+'max').style.backgroundColor='#FFDFDF';
        }
    }

    function setCookie(cookieName, cookieValue, nDays) {
        var today = new Date();
        var expire = new Date();
        if (nDays == null || nDays == 0)
            nDays = 1;
        expire.setTime(today.getTime() + 3600000 * 24 * nDays);
        document.cookie = cookieName + "=" + escape(cookieValue)
                + ";expires=" + expire.toGMTString()
                + ";path=/";

    }

    function getCookie(c_name) {
        var i, x, y, ARRcookies = document.cookie.split(";");
        for (i = 0; i < ARRcookies.length; i++) {
            x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
            y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
            x = x.replace(/^\s+|\s+$/g, "");
            if (x == c_name) {
                return unescape(y);
            }
        }
    }

    function chartQ1Add(srtVal) {
        var nowTime = moment();
        newData =  {x: moment(nowTime, timeFormat), y: srtVal}
        if (chartQ1.data.series[0].data.length < saveCahrtPints) {
            chartQ1.data.series[0].data.push(newData);
        } else {
            chartQ1.data.series[0].data.shift();
            chartQ1.data.series[0].data.push(newData);
        }
        chartQ1.update();
    }

    function chartT1Add(srtVal) {
        var nowTime = moment();
        newData =  {x: moment(nowTime, timeFormat), y: srtVal}
        if (chartT1.data.series[0].data.length < saveCahrtPints) {
            chartT1.data.series[0].data.push(newData);
        } else {
            chartT1.data.series[0].data.shift();
            chartT1.data.series[0].data.push(newData);
        }
        chartT1.update();
    }

    function chartP1Add(srtVal) {
        var nowTime = moment();
        newData =  {x: moment(nowTime, timeFormat), y: srtVal}
        if (chartP1.data.series[0].data.length < saveCahrtPints) {
            chartP1.data.series[0].data.push(newData);
        } else {
            chartP1.data.series[0].data.shift();
            chartP1.data.series[0].data.push(newData);
        }
        chartP1.update();
    }

});