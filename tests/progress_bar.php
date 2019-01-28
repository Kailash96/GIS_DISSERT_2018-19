<!DOCTYPE HTML>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- from this link: http://jsfiddle.net/juvap9mj/ -->
        <style>
            .ui-progress-bar {
			    margin: 0 auto;
			    width: 400px;
			    background: red;
			    position: relative;
			    border: 3px solid rgb(51, 102, 153);
			    height: 25px;
			    -moz-border-radius: 5px;
			    -webkit-border-radius: 5px;
			    border-radius: 5px;
			    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#10F000', endColorstr='#FF0000', GradientType=1);
			    /* IE6-9 */
			    background: linear-gradient(left, rgb(16, 240, 0) 0%, rgb(255, 255, 0) 50%, rgb(255, 0, 0) 100%);
			    background: -o-linear-gradient(left, rgb(16, 240, 0) 0%, rgb(255, 255, 0) 50%, rgb(255, 0, 0) 100%);
			    background: -moz-linear-gradient(left, rgb(16, 240, 0) 0%, rgb(255, 255, 0) 50%, rgb(255, 0, 0) 100%);
			    background: -webkit-linear-gradient(left, rgb(16, 240, 0) 0%, rgb(255, 255, 0) 50%, rgb(255, 0, 0) 100%);
			    background: -ms-linear-gradient(left, rgb(16, 240, 0) 0%, rgb(255, 255, 0) 50%, rgb(255, 0, 0) 100%);
			    background: -webkit-gradient(linear, left top, right top, color-stop(0, rgb(16, 240, 0)), color-stop(0.5, rgb(255, 255, 0)), color-stop(1, rgb(255, 0, 0)));
			}
			.ui-label {
			    position: absolute;
			    text-align: center;
			    width: 100%;
			    top: 3px;
			}
			.ui-labelTitle {
			    position: absolute;
			    text-align: center;
			    width: 100%;
			    top: -25px;
			}
			.ui-labelStart {
			    position: absolute;
			    text-align: left;
			    width: 100%;
			    top: 30px;
			}
			.ui-labelStop {
			    position: absolute;
			    text-align: right;
			    width: 100%;
			    top: 30px;
			}
			.ui-progress {
			    position: absolute;
			    display: block;
			    height: 25px;
			    background: #FFFFFF;
			    top: 0;
			    left: 0;
			    -moz-border-radius: 2px;
			    -webkit-border-radius: 2px;
			    border-radius: 2px;
			}
			.ui-progressColor {
			    position: absolute;
			    top: 0;
			    left: 0;
			    display: block;
			    height: 25px;
			    -moz-border-radius: 5px;
			    -webkit-border-radius: 5px;
			    border-radius: 5px;
			    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#10F000', endColorstr='#FF0000', GradientType=1);
			    /* IE6-9 */
			    background: linear-gradient(left, rgb(16, 240, 0) 0%, rgb(255, 255, 0) 50%, rgb(255, 0, 0) 100%);
			    background: -o-linear-gradient(left, rgb(16, 240, 0) 0%, rgb(255, 255, 0) 50%, rgb(255, 0, 0) 100%);
			    background: -moz-linear-gradient(left, rgb(16, 240, 0) 0%, rgb(255, 255, 0) 50%, rgb(255, 0, 0) 100%);
			    background: -webkit-linear-gradient(left, rgb(16, 240, 0) 0%, rgb(255, 255, 0) 50%, rgb(255, 0, 0) 100%);
			    background: -ms-linear-gradient(left, rgb(16, 240, 0) 0%, rgb(255, 255, 0) 50%, rgb(255, 0, 0) 100%);
			    background: -webkit-gradient(linear, left top, right top, color-stop(0, rgb(16, 240, 0)), color-stop(0.5, rgb(255, 255, 0)), color-stop(1, rgb(255, 0, 0)));
			}
        </style>

        <script>
            (function ($) {
			    $.fn.animateProgress = function (progress, callback) {
			        return this.each(function () {
			            $(this).animate({
			                width: 100 - progress + '%',
			                left: progress + '%'
			            }, {
			                duration: 1000,
			                easing: 'swing',
			                step: function (progress) {
			                    var labelEl = $('.ui-label', this),
			                        valueEl = $('.value', labelEl);
			                },
			                complete: function (scope, i, elem) {
			                    if (callback) {
			                        callback.call(this, i, elem);
			                    };
			                }
			            });
			        });
			    };
			})(jQuery);

			var workingDate = new Date();
			var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];


			$(document).ready(function () {

			  

			    drawbar();

			});

			function drawbar() {
			    

			    

			    $('#progress_bar .ui-progress').animateProgress(20);

			}
        </script>
    </head>
    <body>
        <div id="progressBarDiv">
            <div id="progress_bar" class="ui-progress-bar">
                <div class="ui-progress"></div><!-- .ui-progress -->
                <div class="ui-labelStart" id="progressStartDate"></div><!-- .ui-labelStart -->
                <div class="ui-labelStop" id="progressStopDate"></div><!-- .ui-labelStop -->
            </div><!-- #progress_bar -->
        </div>

        <hr>
<br>
<br>Select Date:
<input type="text" id="progressBarDate" class="datePicker">
 <br><br>
     The progress bar will appear the 2nd month of a quarter and will stay visible until the 3rd, month 16th day of the quarter.
    
    </body>
</html>