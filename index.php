<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Энергомера 126 - PARSER</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="css/chartist.min.css">
</head>

<body>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4><p class="text-center">
                                Расход (м³/час)
                                <a data-toggle="collapse" data-parent="#accordionQ1" href="#collapseOneQ1">
                                    <span class="glyphicon glyphicon-cog"></span>
                                </a>
                            </p></h4>
                        </div>

                        <div class="panel-body" id="q1body">
                            <h1><p class="text-center"><b>q1=<span id="q1">0</span></b></p></h1>
                        </div>
                        <div class="panel-group" id="accordionQ1">

                            <div id="collapseOneQ1" class="panel-collapse collapse out">
                                <div class="panel-footer">
                                    <div class="form-group">
                                        <label for="q1min">Нижний предел:</label>
                                        <input type="text" class="form-control" id="q1min" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="q1max">Верхний предел</label>
                                        <input type="text" class="form-control" id="q1max" value="">
                                    </div>
                                    <button type="button" id="q1save" class="btn btn-primary mb-2">Сохранить уставку</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4><p class="text-center">
                                Темература (°С)
                                <a data-toggle="collapse" data-parent="#accordionT1" href="#collapseOneT1">
                                    <span class="glyphicon glyphicon-cog"></span>
                                </a>
                            </p></h4>
                        </div>

                        <div class="panel-body" id="t1body">
                            <h1><p class="text-center"><b>t1=<span id="t1">0</span></b></p></h1>
                        </div>

                        <div class="panel-group" id="accordionT1">
                            <div id="collapseOneT1" class="panel-collapse collapse out">
                                <div class="panel-footer">
                                    <div class="form-group">
                                        <label for="t1min">Нижний предел:</label>
                                        <input type="text" class="form-control" id="t1min" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="t1max">Верхний предел</label>
                                        <input type="text" class="form-control" id="t1max" value="">
                                    </div>
                                    <button type="button" id="t1save" class="btn btn-primary mb-2">Сохранить уставку</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4><p class="text-center">
                                Давление (МПа)
                                <a data-toggle="collapse" data-parent="#accordionP1" href="#collapseOneP1">
                                    <span class="glyphicon glyphicon-cog"></span>
                                </a>
                            </p></h4>
                        </div>

                        <div class="panel-body" id="p1body">
                            <h1><p class="text-center"><b>p1=<span id="p1">0</span></b></p></h1>
                        </div>

                        <div class="panel-group" id="accordionP1">
                            <div id="collapseOneP1" class="panel-collapse collapse out">
                                <div class="panel-footer">
                                    <div class="form-group">
                                        <label for="p1min">Нижний предел:</label>
                                        <input type="text" class="form-control" id="p1min" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="p1max">Верхний предел</label>
                                        <input type="text" class="form-control" id="p1max" value="">
                                    </div>
                                    <button type="button" id="p1save" class="btn btn-primary mb-2">Сохранить уставку</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#panel1">График q1</a></li>
                            <li><a data-toggle="tab" href="#panel2">График t1</a></li>
                            <li><a data-toggle="tab" href="#panel3">График p1</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="panel1" class="tab-pane fade in active panel-chart">
                                <div class="ct-chart-q1 ct-major-twelfth"></div>
                            </div>
                            <div id="panel2" class="tab-pane fade panel-chart">
                                <div class="ct-chart-t1 ct-major-twelfth"></div>
                            </div>
                            <div id="panel3" class="tab-pane fade panel-chart">
                                <div class="ct-chart-p1 ct-major-twelfth"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/chartist.min.js"></script>
    <script src="js/loader.js"></script>
</body>

</html>
