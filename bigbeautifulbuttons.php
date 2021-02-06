<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?
require_once("config.php");
require_once("common.php");
require_once("bbb-common.php");
require_once("fppversion.php");

$jquery = glob("/opt/fpp/www/js/jquery-*.min.js");
printf("<script type='text/javascript' src='js/%s'></script>\n", basename($jquery[0]));

$pluginJson = convertAndGetSettings();

?>
<script type="text/javascript">
var pluginJson = <? echo json_encode($pluginJson, JSON_PRETTY_PRINT); ?>;

function buttonClicked(cell, x)
{
	$(cell).animate({'opacity':'0.5'}, 100);
    
    var url = "api/command/";
    url += pluginJson["buttons"][x]["command"];

    <? if (getFPPVersionTriplet() != "3.5.0") { ?>
        var data = new Array();
        $.each( pluginJson["buttons"][x]["args"], function(key, v) {
           data.push(v);
        });
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            async: false,
            data: JSON.stringify(data),
            processData: false,
            contentType: 'application/json',
            success: function (data) {
            }
        });
<?  } else { ?>
        $.each( pluginJson["buttons"][x]["args"], function(key, v) {
           url += "/";
           url += encodeURIComponent(v);
        });
        $.get(url);
<? } ?>

	$(cell).animate({'opacity':'1.0'}, 100);
}
</script>
<style>
td{
	 position: relative;
	 display: inline-block;
	 width: 10em;
	 height: 10em;
	 border: 0;
	 margin: 1em;
	 outline: none;
	 background-color: rgba(194, 41, 10, 1);
	 border-radius: 50%;
	 cursor: pointer;
	 transition: box-shadow 200ms;
  
}
td font{
	position: absolute;
	bottom: 50%;
	margin-left: auto;
	margin-right: auto;
	left: 0;
	right: 0;
	text-align: center;
	color:white;
}
td {
	 box-shadow: inset 0 0.4166666667em 0 rgba(218, 46, 11, 1), inset 0 -0.4166666667em 0.1666666667em rgba(170, 36, 9, 1), 0 0 0.1666666667em rgba(194, 41, 10, 1), inset 0 0 0.3333333333em rgba(121, 26, 6, 1), inset 0 0 0.3333333333em rgba(51, 51, 51, 0.5), inset 0 0 0.1666666667em 0.8333333333em rgba(194, 41, 10, 1), inset 0 -0.3333333333em 0.25em 1em rgba(51, 51, 51, 0.7), inset 0 0 0.1666666667em 1em rgba(97, 20, 5, 1), inset 0 0 0.1666666667em 1em rgba(51, 51, 51, 0.7), inset 0 0 0.0833333333em 1.0869565217em rgba(0, 0, 0, 1), inset 0 0 0.0833333333em 1.25em rgba(247, 133, 110, 0.7), inset 0 0.5em 0 1.1764705882em rgba(244, 71, 37, 0.7), inset 0 -0.5em 0.1666666667em 1.1764705882em rgba(145, 31, 8, 0.2), inset 0 0 0 1.8181818182em rgba(194, 41, 10, 1), inset 0 4em 1.3333333333em rgba(170, 36, 9, 1), inset 0 0 1em 1.6666666667em rgba(145, 31, 8, 1), 0 0.25em 0.5em rgba(0, 0, 0, .5);
}
 td:active, .btn.is-pushed {
	 box-shadow: inset 0 0.4166666667em 0 rgba(218, 46, 11, 1), inset 0 -0.4166666667em 0.1666666667em rgba(170, 36, 9, 1), 0 0 0.1666666667em rgba(194, 41, 10, 1), inset 0 0 0.3333333333em rgba(121, 26, 6, 1), inset 0 0 0.3333333333em rgba(51, 51, 51, 0.5), inset 0 0 0.1666666667em 0.8333333333em rgba(194, 41, 10, 1), inset 0 -0.3333333333em 0.25em 1em rgba(51, 51, 51, 0.7), inset 0 0 0.1666666667em 1em rgba(97, 20, 5, 1), inset 0 0 0.1666666667em 1em rgba(51, 51, 51, 0.7), inset 0 0 0.25em 1.1764705882em rgba(0, 0, 0, 1), inset 0 0 0.0833333333em 1.3333333333em rgba(247, 133, 110, 0.2), inset 0 0.5em 0 28px rgba(244, 71, 37, 0.5), inset 0 -0.5em 0.1666666667em 28px rgba(97, 20, 5, 0.2), inset 0 0 0 1.8181818182em rgba(179, 38, 9, 1), inset 0 4em 1.3333333333em rgba(155, 33, 8, 1), inset 0 0 1em 1.6666666667em rgba(121, 26, 6, 1), 0 0.25em 0.5em rgba(0, 0, 0, .5);
	 background-color: rgba(184, 39, 10, 1);
}
 td:active:before, .btn.is-pushed:before {
	 opacity: 0.5;
}
 td:before {
	 content: '';
	 position: absolute;
	 bottom: 2.2222222222em;
	 left: 2.7777777778em;
	 display: block;
	 width: 4.5454545455em;
	 height: 3.0303030303em;
	 background: rgba(247, 133, 110, 0.2);
	 background: linear-gradient(to top, rgba(250, 173, 158, 0.3) 0%, rgba(194, 41, 10, 0.1) 100%);
	 border-radius: 40% 40% 60% 60%;
	 transition: opacity 200ms;
}
</style>
</head>
<body>
<center style='height: 100%'><b><font style='font-size: <?=$pluginJson["fontSize"];?>px;'>
<?
if (isset($_GET['title']))
	echo $_GET['title'];
else if (isset($pluginJson['title']) && ($pluginJson['title'] != ''))
	echo $pluginJson['title'];
else
	echo $settings['HostName'] . " - Big Beautiful Buttons Plugin";
?></b></font>
<table border=1 width='100%' height='90%' bgcolor='#ffffff' style='position: absolute;left: 0px;'>
<tr>
<?

$buttonCount = 0;
if (is_array($pluginJson) && array_key_exists("buttons", $pluginJson)) {
    for ($x = 1; $x <= 20; $x++) {
        if (array_key_exists($x, $pluginJson["buttons"])) {
            $buttonCount = $x;
        }
    }
}

$start = 1;
$end = $buttonCount;

$buttonFontSize = returnIfExists($pluginJson, "fontSize");
if ($buttonFontSize == "") {
    $buttonFontSize = 12;
}

if (isset($_GET['start']))
	$start = $_GET['start'];

if (isset($_GET['end']))
	$end = $_GET['end'];

$i = 1;
$width = 2;

if (isset($_GET['width']))
	$width = $_GET['width'];

$wdPct = 100 / (int)$width;

for ($x = $start; $x <= $end; $x++) {
    if (array_key_exists($x, $pluginJson["buttons"])) {
        if (($i > 1) && ((($i % $width) == 1) || ($width == 1)))
            echo "</tr><tr>\n";
        $i++;

        $color = returnIfExists($pluginJson["buttons"][$x], "color");
        if ($color == "") {
            $color = "aqua";
        }
        printf( "<td bgcolor='%s' width='%d%%' align='center' onClick='buttonClicked(this, \"%d\");'><b><font style='font-size: %spx;'>%s</font></b>",
               $color,
               $wdPct,
               $x,
               $buttonFontSize,
            returnIfExists($pluginJson["buttons"][$x], "description"));
        
        if (returnIfExists($pluginJson["buttons"][$x], "adjustable") != "") {
            $adj = array_keys($pluginJson["buttons"][$x]["adjustable"])[0];
            $type = $pluginJson["buttons"][$x]["adjustable"][$adj];
            if ($type == "number") {
            
                printf("\n<script>\nfunction OnSlider%dChanged(slider) { \n", $x);
                printf("    var command = \"%s\";\n", returnIfExists($pluginJson["buttons"][$x], "command"));
                printf("    var arg = %d;\n", ((int)$adj - 1));
                printf("    pluginJson['buttons'][%d]['args'][arg] = slider.value;\n", $x);
                printf("}\n</script>\n");
                printf("<br><input type='range' class='adjustableSlider' id='slider%d' onchange='OnSlider%dChanged(this);' min='0' max='10' value='1'></input>\n", $x, $x);
                printf("<script>\n");
                printf("    var command = \"%s\";\n", returnIfExists($pluginJson["buttons"][$x], "command"));
                printf("    var arg = %d;\n", ((int)$adj - 1));
            ?>
                $.ajax({
                         dataType: "json",
                         async: false,
                         url: "api/commands/" + command,
                         success: function(data) {
                            $('#slider<?=$x;?>').prop("min", data['args'][arg].min);
                            $('#slider<?=$x;?>').prop("max", data['args'][arg].max);
                       
                            $.ajax({
                                   dataType: "text",
                                   async: false,
                                   url: data['args'][arg]['adjustableGetValueURL'],
                                   success: function(data) {
                                        pluginJson['buttons'][<?=$x;?>]['args'][arg] = data;
                                        $('#slider<?=$x;?>').prop("value", data);
                                   }
                            });
                         }
                       });
            <?
                printf("</script>\n");

            } else if ($type == "text") {
                printf("<br><input type='text' class='adjustableText' id='text%d' onchange='OnText%dChanged(this);' ></input>\n", $x, $x);
                ?>
                <script>
                $("#text<?=$x;?>").click(function(e){
                    e.stopPropagation();
                });
                function OnText<?=$x;?>Changed(text) {
                    var arg = <?=$adj;?> - 1;
                    pluginJson['buttons'][<?=$x;?>]['args'][arg] = text.value;
                    buttonClicked(text.parentElement, '<?=$x;?>');
                }
                </script>
                <?
            }

        }

        
        printf("</td>\n");
    }
}

?>
</tr>
</table>
</body>
</html>
