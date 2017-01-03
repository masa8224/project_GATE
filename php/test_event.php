
<html>
<body>
<head>
	<link rel="icon" type="image/png" href="nts-logo.png">
</head>
<h1>Getting server updates</h1>
<div id="result" style="display: inline;"></div>

<script>
if(typeof(EventSource) !== "undefined") {
    var source = new EventSource("server_event.php");
    source.onmessage = function(event) {
        document.getElementById("result").innerHTML = event.data;
    };
} else {
    document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
}
</script>

</body>
</html>
