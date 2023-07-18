$(function () {



    $(".icon-bar").click(function () {
        $(this).toggleClass('active');
        //$(this).parents("nav#navs").toggleClass("active");
        $("nav#navs").toggleClass("active");
        $(this).parents("body").toggleClass("active");
    });

    $(document).mouseup(function (e) {
        var container = $("nav#navs");
        if (!container.is(e.target) &&
            container.has(e.target).length === 0) {
            $('body').removeClass('active');
            $("nav#navs, .icon-bar").removeClass("active");
        }
    });



    moment.locale('ja');
    $('.date-picker-two').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minDate:new Date(),
        autoApply: true,
        useCurrent: false,
    });
    $(".date-picker-two").each(function (value) {
        $(this).val($(this).attr("value"));
    });



    $('.start-date-input').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        //minDate:new Date(),
        autoUpdateInput: false,
        locale: {
            format: 'YYYY/MM/DD',
            cancelLabel: 'Clear'
        },
        useCurrent: false,
    });

    $('.start-date-input').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD'));
    });
    $('.start-date-input').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
    $(".start-date-input").each(function (value) {
        $(this).val($(this).attr("value"));
    });




    $('.end-date-input').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        //minDate:new Date(),
        autoUpdateInput: false,
        locale: {
            format: 'YYYY/MM/DD',
            cancelLabel: 'Clear'
        },
        useCurrent: false,
    });

    $('.end-date-input').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD'));
    });
    $('.end-date-input').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
    $(".end-date-input").each(function (value) {
        $(this).val($(this).attr("value"));
    });

    $('.month-picker').daterangepicker({
        singleDatePicker: true,
        viewMode: "months",
        minViewMode: "months",
        autoUpdateInput: true,
        locale: {
            format: 'YYYY/MM',
        },
    });
    $(".month-picker").each(function (value) {
        $(this).val($(this).attr("value"));
    });


    $(".monthpicker").datepicker( {
        format: "yyyy/mm",
        viewMode: "months",
        autoclose: true,
        language: 'ja',
        minViewMode: "months"
    });

    // $('.start-date').daterangepicker({
    //     singleDatePicker: true,
    //     showDropdowns: true,
    //     minDate:new Date(),
    //     autoUpdateInput: false,
    //     locale: {
    //         format : "YYYY/MM/DD",
    //         daysOfWeek: [ "日", "月", "火", "水", "木", "金", "土" ],
    //         monthNames: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
    //         cancelLabel: 'Clear'
    //     }
    // });
    // $('input[name="start-date"]').on('apply.daterangepicker', function(ev, picker) {
    //     $(this).val(picker.startDate.format('YYYY/MM/DD'));
    // });
    // $('input[name="start-date"]').on('cancel.daterangepicker', function(ev, picker) {
    //     $(this).val('');
    // });
    // $(".start-date").each(function (value) {
    //     $(this).val($(this).attr("value"));
    // });


    $('.date-picker-time').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        //minDate:new Date(),
        autoUpdateInput: false,
        useCurrent: false,
        locale: {
            format: 'YYYY/MM/DD HH:mm:ss',
            cancelLabel: 'Clear'
        },
        timePicker:  true
    });
    $(".date-picker-time").each(function (value) {
        $(this).val($(this).attr("value"));
    });
    $('.date-picker-time').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD HH:mm:ss'));
    });
    $('.date-picker-time').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    //select
    var x, i, j, l, ll, selElmnt, a, b, c;
    /* Look for any elements with the class "custom-select": */
    x = document.getElementsByClassName("custom-select");
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        /* For each element, create a new DIV that will act as the selected item: */
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        if(selElmnt.options[selElmnt.selectedIndex].innerHTML != "" && selElmnt.options[selElmnt.selectedIndex].value != "0") {
            a.innerHTML = "<span class='"+selElmnt.options[selElmnt.selectedIndex].value+"_sys'>" + selElmnt.options[selElmnt.selectedIndex].innerHTML + "</span>";
        }else{
            a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        }
        x[i].appendChild(a);
        /* For each element, create a new DIV that will contain the option list: */
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 0; j < ll; j++) {
            /* For each option in the original select element,
            create a new DIV that will act as an option item: */
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                /* When an item is clicked, update the original select box,
                and the selected item: */
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        if(s.options[i].value != "" && s.options[i].value != "0") {
                            h.innerHTML = "<span class='"+s.options[i].value+"_sys'>" + this.innerHTML + "</span>";
                        }else{
                            h.innerHTML = this.innerHTML;
                        }
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function(e) {
            /* When the select box is clicked, close any other select boxes,
            and open/close the current select box: */
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }

    function closeAllSelect(elmnt) {
        /* A function that will close all select boxes in the document,
        except the current select box: */
        var x, y, i, xl, yl, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
            }
        }
    }

    /* If the user clicks anywhere outside the select box,
    then close all select boxes: */
    document.addEventListener("click", closeAllSelect);



    $(".eyes").click(function () {
        $(this).siblings('input').attr('type', function (index, attr) {
            return attr == 'password' ? 'text' : 'password';
        });

        $(this).children().attr('src', function(index, attr){
            return attr == '/static/user/images/eyes_active.png' ? '/static/user/images/eyes_disable.png' : '/static/user/images/eyes_active.png' ;
        });
    });

    $("textarea").each(function () {
        this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
    }).on("input", function () {
        this.style.height = "auto";
        this.style.height = (this.scrollHeight) + "px";
    });











    //select
    var x, i, j, l, ll, selElmnt, a, b, c;
    /* Look for any elements with the class "custom-select": */
    x = document.getElementsByClassName("custom-select-status");
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        /* For each element, create a new DIV that will act as the selected item: */
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        if(selElmnt.options[selElmnt.selectedIndex].innerHTML != "" && selElmnt.options[selElmnt.selectedIndex].value != "0") {
            //a.innerHTML = "<span class='"+selElmnt.options[selElmnt.selectedIndex].value+"_sys'>" + selElmnt.options[selElmnt.selectedIndex].innerHTML + "</span>";
            a.innerHTML = "<span class='"+selElmnt.options[selElmnt.selectedIndex].getAttribute('data-value')+"_sys'>" + selElmnt.options[selElmnt.selectedIndex].innerHTML + "</span>";
        }else{
            a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        }
        x[i].appendChild(a);
        /* For each element, create a new DIV that will contain the option list: */
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 0; j < ll; j++) {
            /* For each option in the original select element,
            create a new DIV that will act as an option item: */
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                /* When an item is clicked, update the original select box,
                and the selected item: */
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        if(s.options[i].value != "" && s.options[i].value != "0") {
                            //h.innerHTML = "<span class='"+s.options[i].value+"_sys'>" + this.innerHTML + "</span>";
                            h.innerHTML = "<span class='"+s.options[i].getAttribute('data-value')+"_sys'>" + this.innerHTML + "</span>";
                        }else{
                            h.innerHTML = this.innerHTML;
                        }
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function(e) {
            /* When the select box is clicked, close any other select boxes,
            and open/close the current select box: */
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }


});
