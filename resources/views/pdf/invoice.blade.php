<!DOCTYPE html>
<html>
<head>
    <title>测试pdf</title>

    <style>
        @font-face {
            font-family: 'msyh';
            font-style: normal;
            font-weight: normal;
            src: url(http://www.testpdf.com/fonts/msyh.ttf) format('truetype');
        }
        html, body {  height: 100%;  }
        body {  margin: 0;  padding: 0;  width: 100%;
            /*display: table;  */
            font-weight: 100;  font-family: 'msyh';  }
        .container {  text-align: center;
            /*display: table-cell; */
            vertical-align: middle;  }
        .content {  text-align: center;  display: inline-block;  }
        .title {  font-size: 96px;  }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">xiao{{$name}}</div>
    </div>
</div>
</body>
</html>