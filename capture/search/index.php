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
$search_bins = getSearchBins();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>FFtcat v2 | Flood Fire Twitter Capturing and Analysis Toolset</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="resources/tagEditor/jquery.tag-editor.css">
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
                        <li class="active"><a href="#">Search</a></li>
                        <li><a href="archived.php">Archive</a></li>
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
                                        <?php echo count($search_bins); ?>
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
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary" name="newbin"><i class="fa fa-search-plus"></i> New Search Bin</button>
                            </div>
                            <div class="col-md-9">
                                <div id="new-content" class="collapse">
                                    <form onsubmit="sendNewForm();
                                            return false;">
                                        <div class="form-group">
                                            <label for="newbin_name" class="control-label">Query Bin</label>
                                            <input type="text" class="form-control" id="newbin_name" placeholder="Bin name">
                                            <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 之後不可修改。</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPhrase" class="control-label">Phrase to search</label>
                                            <input type="text" class="form-control" id="inputPhrase" placeholder="Phrases">
                                            <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 逐一輸入關鍵字（上限 10 個），包含空白請以半形雙引號 <code>"</code> 框起。例如: "Republic of China"</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="newbin_comments" class="control-label">Comment</label>
                                            <textarea name="newbin_comments" class="form-control" rows="3" placeholder="Comment"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-warning">Create Search bin</button>
                                            <button type="reset" class="btn btn-default" name="cancel-new">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="2%">#</th>
                                        <th width="8%">Status</th>
                                        <th width="8%">Bin Name</th>
                                        <th width="25%">Phrases</th>
                                        <th width="7%">Tweets</th>
                                        <th width="5%">Creator</th>
                                        <th width="10%" class="text-center">Create</th>
                                        <th width="10%" class="text-center">Update</th>
                                        <th width="15%">Comment</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($search_bins as $bin) {
                                        echo '<tr>';
                                        echo '<td>' . $i . '.</td>';
                                        echo '<td><span class="inlinesparkline">' . getSparklineValue($bin->name) . '</span></td>';
                                        echo '<td>' . $bin->name . '</td>';
                                        echo '<td>' . implode(', ', explode(" OR", $bin->phrases)) . '</td>';
                                        echo '<td align="center"> ' . number_format($bin->nrOfTweets) . '</td>';
                                        echo '<td>' . $bin->username . '</td>';
                                        echo '<td align="center"> ' . $bin->createtime . '</td>';
                                        echo '<td align="center"> ' . $bin->updatetime . '</td>';
                                        echo '<td> ' . $bin->comment . '</td>';
                                        echo '<td align="right">';
                                        if ($username == $bin->username || $_SERVER['PHP_AUTH_USER'] == ADMIN_USER) {
                                            echo '<button class="btn btn-danger" name="del-' . $bin->id . '"><i class="fa fa-trash fa-lg"></i></button> ';
                                            echo '<button class="btn btn-warning" name="arch-' . $bin->id . '"><i class="fa fa-archive"></i></button>';
                                        }
                                        echo '</td>';
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
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="resources/tagEditor/jquery.caret.min.js"></script>
    <script src="resources/tagEditor/jquery.tag-editor.min.js"></script>
    <script src="resources/jquerySparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $("button[name='newbin']").click(function () {
                                                //console.log('Click!');
                                                $("#new-content").slideDown('slow');
                                            });

                                            $("button[name='cancel-new']").click(function () {
                                                $("#new-content").slideUp('slow');
                                                removeAllTags();
                                            });

                                            $("#inputPhrase").tagEditor({
                                                maxTags: 10,
                                                forceLowercase: false,
                                                placeholder: 'Enter keywords ...'
                                            });

                                            $("button[name^='del-']").click(function () {
                                                var qid = $(this).attr('name').replace('del-', '');
                                                console.log('delete');
                                                sendDelete(qid, 1, 'search');
                                            });

                                            $("button[name^='arch-']").click(function () {
                                                var qid = $(this).attr('name').replace('arch-', '');
                                                console.log(qid);
                                                sendArchive(qid, 'search');
                                            });

                                            $('.inlinesparkline').sparkline('html', {
                                                type: 'bar',
                                                zeroAxis: false
                                            });
                                        });
                                        function sendNewForm() {
                                            var _bin = $("#newbin_name").val();
                                            var _comments = $("textarea[name=newbin_comments]").val();
                                            if (!validateBin(_bin))
                                                return false;
                                            if (!validateComments(_comments))
                                                return false;
                                            var _phrases = formatPhrase($("#inputPhrase").tagEditor('getTags')[0].tags);

                                            var _check = window.confirm("You are about to create a new search query bin. Are you sure?");
                                            if (_check == true) {
                                                var _params = {action: "newbin", type: "search", newbin_phrases: _phrases, newbin_name: _bin, newbin_comments: _comments, active: $("#make_active").val()};
                                                $.ajax({
                                                    dataType: "json",
                                                    url: "../query_manager.php",
                                                    type: 'POST',
                                                    data: _params
                                                }).done(function (_data) {
                                                    alert(_data["msg"]);
                                                    location.reload();
                                                    $("#new-content").slideUp('slow');
                                                    clearInput();
                                                });
                                            }
                                            return false;
                                        }

                                        function sendDelete(_bin, _active, _type) {
                                            var _check = window.confirm("Are you sure that you want to REMOVE this bin?");
                                            if (_check == true) {
                                                if (_active == 1)
                                                    var _check = window.confirm("The query bin is STILL RUNNING! Are you absolutely sure that you want to completely remove it?");
                                                if (_check == false)
                                                    return false;

                                                var _check = window.confirm("Last time: are you really sure that you want to REMOVE the query bin?");
                                                if (_check == false)
                                                    return false;

                                                var _params = {action: "removebin", bin: _bin, type: _type, active: _active};

                                                $.ajax({
                                                    dataType: "json",
                                                    url: "../query_manager.php",
                                                    type: 'POST',
                                                    data: _params
                                                }).done(function (_data) {
                                                    alert(_data["msg"]);
                                                    location.reload();
                                                });
                                            }
                                            return false;
                                        }

                                        function sendArchive(_bin, _type) {
                                            var _check = window.confirm("Are you sure that you want to ARCHIVE this bin?");
                                            if (_check == true) {
                                                var _check = window.confirm("Last time: are you really sure that you want to ARCHIVE the query bin?");
                                                if (_check == false)
                                                    return false;
                                                var _params = {action: "archivesearchbin", bin: _bin, type: _type};

                                                $.ajax({
                                                    dataType: "json",
                                                    url: "../query_manager.php",
                                                    type: 'POST',
                                                    data: _params
                                                }).done(function (_data) {
                                                    alert(_data["msg"]);
                                                    location.reload();
                                                });
                                            }
                                            return false;
                                        }

                                        function validateBin(binname) {
                                            if (binname == null || binname.trim() == "") {
                                                alert("You cannot use an empty bin name");
                                                return false;
                                            }
                                            var reg = /^[a-zA-Z0-9_]+$/;
                                            if (!reg.test(binname.trim())) {
                                                alert("bin names can only consist of alpha-numeric characters and underscores")
                                                return false;
                                            }
                                            return true;
                                        }
                                        function validateComments(comments) {
                                            if (comments.length > 2000) {
                                                alert("Comments are too long (more than 2000 characters)");
                                                return false;
                                            }
                                            return true;
                                        }
                                        function clearInput() {
                                            $("#newbin_name").val('');
                                            $("#inputPhrase").val('');
                                            $("textarea[name=newbin_comments]").val('');
                                            removeAllTags();
                                        }
                                        function formatPhrase(tags) {
                                            return tags.join(" OR ");
                                        }

                                        function removeAllTags() {
                                            var tags = $('#inputPhrase').tagEditor('getTags')[0].tags;
                                            for (i = 0; i < tags.length; i++) {
                                                $('#inputPhrase').tagEditor('removeTag', tags[i]);
                                            }
                                        }

    </script>
</html>
