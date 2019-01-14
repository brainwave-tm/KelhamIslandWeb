<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <img id="pic" src="../content/images/3/3.JPG" style="display: none; width: 25%">

    <canvas id="myCanvas" width="1340" height="800" style="border:1px solid #000000;">
    </canvas>

    <script type="text/javascript">
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");

    // Create gradient
    var grd = ctx.createLinearGradient(0, 0, c.width, c.height);
    grd.addColorStop(0, "#005375");
    grd.addColorStop(1, "white");

    // Fill with gradient
    ctx.fillStyle = grd;
    ctx.fillRect(0, 0, c.width, c.height);

    ctx.font = "30px Arial";
    var offset = 0;
    for(var i = 0; i < 4; i++)
    {
        ctx.fillStyle = "white";
        var rectangle = {x : (offset + 250), y : 20, width: 250, height : 400};
        offset = rectangle.x + 25;
        rectangle.x -= 225;
        ctx.fillRect(rectangle.x, rectangle.y, rectangle.width, rectangle.height);

        ctx.fillStyle = "black";
        ctx.fillText("Bramah Press", rectangle.x + 25, 65);

        var img = document.getElementById("pic");
        ctx.drawImage(img, rectangle.x + 25, 130, 200, 200);
    }
    </script>
</body>
</html>