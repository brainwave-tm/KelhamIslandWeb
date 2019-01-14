<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <canvas id="myCanvas" width="1340" height="800" style="border:1px solid #000000;">
    </canvas>

    <script type="text/javascript">
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
    ctx.beginPath();
    ctx.arc(c.width / 2, c.height / 2, 110, 0, 2 * Math.PI);
    ctx.stroke();

    // Create gradient
    var grd = ctx.createLinearGradient(0, 0, c.width, c.height);
    grd.addColorStop(0, "#005375");
    grd.addColorStop(1, "white");

    // Fill with gradient
    ctx.fillStyle = grd;
    ctx.fillRect(0, 0, c.width, c.height);

    ctx.font = "110px Arial";
    ctx.strokeText("Kelham Matchup", 250, c.height / 2);
    </script>
</body>
</html>