<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../../config.php';
include_once BASE_FILE . '/capture/common/functions.php';

/**
 * 取得 Search Bins 的資料列表
 *
 * @return array Search Bin Content
 * @author ninthday <bee.me@ninthday.info>
 * @since 2014-09-27
 */
function getSearchBins()
{
    $dbh = pdo_connect();
    $sql = 'SELECT `tcat_query_bins`.`id`, `tcat_query_bins`.`querybin`, `comments`, `origin_phrase`, `username`, `createtime`, `updatetime`
            FROM `tcat_query_bins`
            INNER JOIN `tcat_search_queues` ON `tcat_search_queues`.`querybin_id` = `tcat_query_bins`.`id`';
    $rec = $dbh->prepare($sql);
    $rec->execute();
    $rs_sbin = $rec->fetchAll();
    $querybins = array();
    foreach ($rs_sbin as $data) {
        if (!isset($querybins[$data['id']])) {
            $bin = new stdClass();
            $bin->id = $data['id'];
            $bin->name = $data['querybin'];
            $bin->phrases = $data['origin_phrase'];
            $bin->username = $data['username'];
            $bin->createtime = $data['createtime'];
            $bin->updatetime = $data['updatetime'];
            $bin->comment = $data['comments'];

            $sql = "SELECT count(id) AS count FROM " . $data['querybin'] . "_tweets";
            $res = $dbh->prepare($sql);
            if ($res->execute() && $res->rowCount()) {
                $result = $res->fetch();
                $bin->nrOfTweets = $result['count'];
            }
        }
        $querybins[$data['id']] = $bin;
    }

    $dbh = false;
    return $querybins;
}

/**
 * 查詢 Search NULL 優先，最小日子次之，傳回 querybin_id，keywords, binname
 * @return array|bool
 * @author ninthday <bee.me@ninthday.info>
 * @since 2015-05-27
 */
function getBestSearchBin()
{
    $dbh = pdo_connect();
    $sql = "SELECT `tcat_search_queues`.`querybin_id`, `tcat_search_queues`.`origin_phrase`, `tcat_query_bins`.`querybin` FROM `tcat_search_queues`
            INNER JOIN `tcat_query_bins` ON `tcat_query_bins`.`id` = `tcat_search_queues`.`querybin_id`
            ORDER BY `tcat_search_queues`.`updatetime` ASC";
    $rec = $dbh->prepare($sql);
    $searchbins = array();
    if ($rec->execute()) {
        $res = $rec->fetch();
        $searchbins['querybin_id'] = $res['querybin_id'];
        $searchbins['keywords'] = $res['origin_phrase'];
        $searchbins['bin_name'] = $res['querybin'];
    } else {
        $dbh = false;
        return false;
    }
    $dbh = false;
    return $searchbins;
}

/**
 * 更新 Search 資料表的時間
 *
 * @param int $querybin_id Bin編號
 * @return bool 更新成功與否
 * @author ninthday <bee.me@ninthday.info>
 * @since 2015-05-27
 */
function updateSearchTime($querybin_id)
{
    $bolRtn = false;
    $dbh = pdo_connect();
    $nowtime = date('Y-m-d H:i:s');
    $sql = 'UPDATE `tcat_search_queues` SET `updatetime` = \'' . $nowtime . '\' WHERE `querybin_id` = ' . $querybin_id;
    $rec = $dbh->prepare($sql);
    if ($rec->execute()) {
        $bolRtn = true;
    }
    $dbh = false;
    return $bolRtn;
}

/**
 * 計算指定 bin 的 tweets 數量
 * 
 * @param Bin's name $bin_name
 * @return int | boolen
 */
function countCaptureAmount($bin_name)
{
    $rtn = 0;
    $dbh = pdo_connect();
    $sql = 'SELECT COUNT(*) FROM `' . $bin_name . '_tweets`';
    $rec = $dbh->prepare($sql);
    if ($rec->execute()) {
        $res = $rec->fetch(PDO::FETCH_NUM);
        $rtn = $res[0];
    } else {
        $dbh = false;
        return false;
    }

    $dbh = false;
    return $rtn;
}

/**
 * 儲存執行的記錄
 * 
 * @param int $querybin_id BinID
 * @param int $diffamount 新增筆數
 * @return boolean
 */
function saveActionLog($querybin_id, $diffamount)
{
    $rtn = false;
    $dbh = pdo_connect();
    $nowtime = date('Y-m-d H:i:s');
    $sql = 'INSERT INTO `tcat_action_log`(`querybin_id`, `diffamount`, `actiontime`) '
            . 'VALUES (:querybin_id, :diffamount, :actiontime)';

    $rec = $dbh->prepare($sql);
    $rec->bindParam(":querybin_id", $querybin_id, PDO::PARAM_INT);
    $rec->bindParam(":diffamount", $diffamount, PDO::PARAM_INT);
    $rec->bindParam(":actiontime", $nowtime, PDO::PARAM_STR);
    if ($rec->execute()) {
        $rtn = true;
    }
    $dbh = false;
    return $rtn;
}

/**
 * 取得今日抓取到的 tweets 總數
 * 
 * @return boolean
 */
function getTodayTweetAmount()
{
    $rtn = false;
    $dbh = pdo_connect();
    $sql = 'SELECT SUM(`diffamount`) FROM `tcat_action_log` WHERE DATE(`actiontime`) = CURDATE();';
    $rec = $dbh->prepare($sql);
    if ($rec->execute()) {
        $res = $rec->fetch(PDO::FETCH_NUM);
        $rtn = $res[0];
    } else {
        $dbh = false;
        return false;
    }

    $dbh = false;
    return $rtn;
}
