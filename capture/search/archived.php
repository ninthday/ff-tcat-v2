<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once '../../config.php';

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    die("Please login first, thx!");
}

$username = $_SERVER['PHP_AUTH_USER'];
include_once BASE_FILE . '/capture/common/ff-functions.php';
$search_bins = getArchiveSearchBins();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>FFtcat v2 | Flood Fire Twitter Capturing and Analysis Toolset</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <style>
            body {
                padding-top: 70px;
            }
            .huge {
                font-size: 40px;
            }
            .jqstooltip {
                -webkit-box-sizing: content-box;
                -moz-box-sizing: content-box;
                box-sizing: content-box;
            }
        </style>
    </head>
    <body>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Flood & Fire Tcat@V2</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Search</a></li>
                        <li class="active"><a href="#">Archive</a></li>
                        <li><a href="http://140.119.163.61/~ff-tcat/v2/analysis/" target="_blank">Analysis</a></li>
                        <li><a href="#">niceToolBar@v2</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-md-4">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php echo number_format(getSearchNum()); ?>
                                    </div>
                                    <div>In Processes!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-4">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-archive fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo number_format(getArchiveNum()); ?></div>
                                    <div>Archive Search!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-history fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo number_format(getTodayTweetAmount()); ?></div>
                                    <div>Capture Today!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Search Bins</div>
                        <div class="panel-body">
                            <p>All Archive Search Bin.</p>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="2%">#</th>
                                    <th width="8%">Bin Name</th>
                                    <th width="30%">Phrases</th>
                                    <th width="7%">Tweets</th>
                                    <th width="5%">Creator</th>
                                    <th width="10%" class="text-center">Create</th>
                                    <th width="10%" class="text-center">Archive</th>
                                    <th width="20%">Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($search_bins as $bin) {
                                    echo '<tr>';
                                    echo '<td>' . $i . '.</td>';
                                    echo '<td>' . $bin->name . '</td>';
                                    echo '<td>' . implode(', ', explode(" OR", $bin->phrases)) . '</td>';
                                    echo '<td align="center"> ' . number_format($bin->nrOfTweets) . '</td>';
                                    echo '<td>' . $bin->username . '</td>';
                                    echo '<td align="center"> ' . $bin->createtime . '</td>';
                                    echo '<td align="center"> ' . $bin->archivetime . '</td>';
                                    echo '<td> ' . $bin->comment . '</td>';
                                    echo '</tr>';
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</html>
