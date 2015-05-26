<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once '../../config.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>FFtcat v2 | Flood Fire Twitter Capturing and Analysis Toolset</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <style>
            body {
                min-height: 2000px;
                padding-top: 70px;
            }
            .huge {
                font-size: 40px;
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
                        <li><a href="#about">Archive</a></li>
                        <li><a href="#contact">Analysis</a></li>

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
                                    <div class="huge">12</div>
                                    <div>In processes!</div>
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
                                    <div class="huge">32,250</div>
                                    <div>Update Today!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-4">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-archive fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">12</div>
                                    <div>Archive Search!</div>
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
                                            <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 以 <kbd>OR</kbd> 區別關鍵字，例如:台灣 OR 中華民國 OR Taiwan OR "Republic of China"</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="newbin_comments" class="control-label">Comment</label>
                                            <textarea name="newbin_comments" class="form-control" rows="3" placeholder="Comment"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-warning">Create Search bin</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Bin Name</th>
                                    <th>Phrases</th>
                                    <th>Tweet amount</th>
                                    <th>User name</th>
                                    <th>Created Times</th>
                                    <th>Last update</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>sparkline</td>
                                    <td>Bin Name</td>
                                    <td>Phrases</td>
                                    <td>Tweet amount</td>
                                    <td>User name</td>
                                    <td>Created Times</td>
                                    <td>Last update</td>
                                    <td>Description</td> 
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>sparkline</td>
                                    <td>Bin Name</td>
                                    <td>Phrases</td>
                                    <td>Tweet amount</td>
                                    <td>User name</td>
                                    <td>Created Times</td>
                                    <td>Last update</td>
                                    <td>Description</td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $("button[name='newbin']").click(function () {
                                                console.log('Click!');
                                                $("#new-content").slideDown('slow');
                                            });
                                        });
                                        function sendNewForm() {
                                            var _bin = $("#newbin_name").val();
                                            var _comments = $("textarea[name=newbin_comments]").val();
                                            if (!validateBin(_bin))
                                                return false;
                                            if (!validateComments(_comments))
                                                return false;
                                            var _phrases = $("#inputPhrase").val();
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

    </script>
</html>
