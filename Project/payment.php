<!DOCTYPE html>
<html>
<head>
	<title></title>

	<style type="text/css">
		/*----------  libraries ---------- */
@import url(https://fonts.googleapis.com/css?family=Montserrat:400,700);
@import url(https://fonts.googleapis.com/css?family=Work+Sans);
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed,
figure, figcaption, footer, header, hgroup,
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
  margin: 0;
  padding: 0;
  border: 0;
  font: inherit;
  font-size: 100%;
  vertical-align: baseline;
}

html {
  line-height: 1;
}

ol, ul {
  list-style: none;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
}

caption, th, td {
  text-align: left;
  font-weight: normal;
  vertical-align: middle;
}

q, blockquote {
  quotes: none;
}
q:before, q:after, blockquote:before, blockquote:after {
  content: "";
  content: none;
}

a img {
  border: none;
}

article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
  display: block;
}

/*----------  style ----------*/
* {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-rendering: optimizeLegibility;
}

body {
  background-color: #b3e5fc;
}

.wrapper {
  width: 611px;
  height: 400px;
  margin: 80px auto 0;
}
.wrapper .container {
  float: right;
  width: 600px;
  height: 400px;
  background-color: #fff;
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;
  border-radius: 10px;
}
.wrapper .container .part {
  float: left;
  height: 100%;
}
.wrapper .container .part.card-details {
  padding: 48px 40px 0;
  width: 60%;
}
.wrapper .container .part.card-details h1 {
  background-color: #00b0ff;
  color: white;
  font-family: 'Montserrat', sans-serif;
  font-size: 12px;
  text-transform: uppercase;
  padding: 14px 0 10px 49px;
  letter-spacing: 1px;
  margin-left: -52px;
  width: 330px;
}
.wrapper .container .part.bg {
  width: 40%;
  background-image: url("https://s13.postimg.org/d8emjhccn/image.jpg");
  background-size: 121%;
  background-repeat: no-repeat;
  overflow: hidden;
  -moz-border-radius-topright: 10px;
  -webkit-border-top-right-radius: 10px;
  border-top-right-radius: 10px;
  -moz-border-radius-bottomright: 10px;
  -webkit-border-bottom-right-radius: 10px;
  border-bottom-right-radius: 10px;
}
.wrapper .container form {
  font-family: 'Work Sans', sans-serif;
}
.wrapper .container form .group {
  display: block;
  width: 100%;
  float: left;
  position: relative;
  margin-bottom: 25px;
}
.wrapper .container form .group label {
  font-size: 12px;
  float: left;
  width: 100%;
  display: block;
  margin-bottom: 5px;
}
.wrapper .container form .group input {
  float: left;
  width: 100%;
  height: 30px;
  font-size: 18px;
  font-family: 'Work Sans', sans-serif;
  border: 0;
  color: #263238;
  border-bottom: 1px solid #d9d9d9;
}
.wrapper .container form .group input::-webkit-input-placeholder {
  font-family: 'Work Sans', sans-serif;
  font-size: 14px;
  line-height: 20px;
  vertical-align: middle;
  color: #d9d9d9;
  text-align: left;
}
.wrapper .container form .group input:-moz-placeholder {
  font-family: 'Work Sans', sans-serif;
  font-size: 14px;
  line-height: 20px;
  vertical-align: middle;
  color: #d9d9d9;
  text-align: left;
}
.wrapper .container form .group input::-moz-placeholder {
  font-family: 'Work Sans', sans-serif;
  font-size: 14px;
  line-height: 20px;
  vertical-align: middle;
  color: #d9d9d9;
  text-align: left;
}
.wrapper .container form .group input:-ms-input-placeholder {
  font-family: 'Work Sans', sans-serif;
  font-size: 14px;
  line-height: 20px;
  vertical-align: middle;
  color: #d9d9d9;
  text-align: left;
}
.wrapper .container form .group input:focus {
  outline: none;
  border-bottom-color: #00b0ff;
}
.wrapper .container form .group input:focus::-webkit-input-placeholder {
  color: transparent;
}
.wrapper .container form .group input:focus:-moz-placeholder {
  color: transparent;
}
.wrapper .container form .group input:focus::-moz-placeholder {
  color: transparent;
}
.wrapper .container form .group input:focus:-ms-input-placeholder {
  color: transparent;
}
.wrapper .container form .card-number {
  border-bottom: 1px solid #d9d9d9;
}
.wrapper .container form .card-number:first-of-type {
  margin-top: 32px;
}
.wrapper .container form .card-number input {
  width: 43px;
  border-bottom: 0;
}
.wrapper .container form .card-number.focused {
  border-bottom-color: #00b0ff;
}
.wrapper .container form .card-expiry {
  border-bottom: 0;
}
.wrapper .container form .card-expiry .input-item {
  float: left;
}
.wrapper .container form .card-expiry .input-item.expiry {
  width: 200px;
}
.wrapper .container form .card-expiry .input-item.expiry input:last-of-type {
  margin-left: 30px;
}
.wrapper .container form .card-expiry .input-item.csv {
  width: 80px;
  position: relative;
}
.wrapper .container form .card-expiry .input-item.csv a {
  display: block;
  position: absolute;
  top: 0;
  right: 0;
  font-size: 12px;
  text-decoration: none;
  color: #00b0ff;
}
.wrapper .container form .card-expiry .input-item.csv a:hover {
  color: #263238;
}
.wrapper .container form .card-expiry .input-item label {
  width: 100%;
}
.wrapper .container form .card-expiry .input-item input {
  border-bottom: 1px solid #d9d9d9;
  padding-bottom: 8px;
}
.wrapper .container form .card-expiry .input-item input.month {
  width: 60px;
}
.wrapper .container form .card-expiry .input-item input.year {
  width: 79px;
}
.wrapper .container form .card-expiry .input-item input.csv {
  width: 79px;
}
.wrapper .container form .card-expiry .input-item input:focus {
  border-bottom: 1px solid #00b0ff;
}
.wrapper .container form .submit-group {
  width: 100%;
  float: left;
  position: relative;
}
.wrapper .container form .submit {
  text-transform: uppercase;
  position: relative;
  border: none;
  background-color: transparent;
  font-size: 12px;
  line-height: 21px;
  letter-spacing: 1.4px;
  text-align: left;
  color: #263238;
  margin-left: 24px;
  cursor: pointer;
}
.wrapper .container form .submit:hover {
  text-decoration: underline;
}
.wrapper .container form .submit:focus {
  outline: none;
}
.wrapper .container form .arrow {
  position: absolute;
  top: -2px;
  left: -1px;
}
.wrapper .container form .arrow:before {
  content: '';
  width: 15px;
  height: 15px;
  background-image: url("https://s21.postimg.org/lgxvam5df/arrow.png");
  position: absolute;
  top: 4px;
  left: 0;
  -moz-transition: all 0.3s;
  -o-transition: all 0.3s;
  -webkit-transition: all 0.3s;
  transition: all 0.3s;
}
.wrapper .container form .arrow.rotate:before {
  -moz-transform: rotate(360deg);
  -ms-transform: rotate(360deg);
  -webkit-transform: rotate(360deg);
  transform: rotate(360deg);
}

.credits {
  display: block;
  font-family: 'Work Sans', sans-serif;
  position: absolute;
  right: 0;
  bottom: 0;
  color: #263238;
  font-size: 12px;
  margin: 0 10px 10px 0;
}
.credits a {
  filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80);
  opacity: 0.8;
  color: inherit;
  font-weight: 700;
  text-decoration: none;
}
	</style>
</head>

<script>
	$(".cc-num").keyup(function() {
	    if (this.value.length == this.maxLength) {
	        var $next = $(this).next('.cc-num');
	        if ($next.length)
	            $(this).next('.cc-num').focus();
	        else
	            $(this).blur();
	    }
	});
	$('.cc-num').on("focusin", function() {
	    $('.cc-num').attr('type', 'password')
	    $(this).attr('type', 'text');
	    $('.card-number').addClass('focused');
	});
	$('.cc-num').on("focusout", function() {
	    $('.card-number').removeClass('focused');
	});
	$('.dropdown').click(function() {
	    $(this).next('ul').stop().slideToggle();
	    $(this).toggleClass('selected');
	});
	$('.card-number').on('keydown', '.cc-num', function(e) {
	    -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || /65|67|86|88/.test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey) || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey || 48 > e.keyCode || 57 < e.keyCode) && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
	});
	$('.submit').hover(function(){
	    $('.arrow').addClass('rotate');
	}, function(){
	    $('.arrow').removeClass('rotate');
	});
	$('.part.bg').mousemove(function(e){
	    var amountMovedX = (e.pageX * -1 / 30);
	    var amountMovedY = (e.pageY * -1 / 9);
	    $(this).css('background-position', amountMovedX + 'px ' + amountMovedY + 'px');
	});
</script>

<body>
<div class="wrapper">
    <div class="container">
        <article class="part card-details">
            <h1>
                Credit Card Details
            </h1>
            <form action="" if="cc-form" autocomplete="off">
                <div class="group card-number">
                    <label for="first">Card Number</label>
                    <input type="text" id="first" class="cc-num" type="text" maxlength="4" placeholder="&#9679;&#9679;&#9679;&#9679;">
                    <input type="text" id="second" class="cc-num" type="text" maxlength="4" placeholder="&#9679;&#9679;&#9679;&#9679;">
                    <input type="text" id="third" class="cc-num" type="text" maxlength="4" placeholder="&#9679;&#9679;&#9679;&#9679;">
                    <input type="text" id="fourth" class="cc-num" type="text" maxlength="4" placeholder="&#9679;&#9679;&#9679;&#9679;">
                </div>
                <div class="group card-name">
                    <label for="name">Name On Card</label>
                    <input type="text" id="name" class="" type="text" maxlength="20" placeholder="Name Surname">
                </div>
                <div class="group card-expiry">
                    <div class="input-item expiry">
                        <label for="expiry">Expiry Date</label>
                        <input type="text" class="month" id="expiry" placeholder="02">
                        <input type="text" class="year" id="" placeholder="2017">
                    </div>
                    <div class="input-item csv">
                        <label for="csv">CSV No.</label><a href="#what">?</a>
                        <input type="text" class="csv">
                    </div>
                </div>
                <div class="grup submit-group">
                    <span class="arrow"></span>
                    <input type="submit" class="submit" value="Continue to payment">
                </div>
            </form>
        </article>
        <div class="part bg"></div>
    </div>
</div>

</body>
</html>