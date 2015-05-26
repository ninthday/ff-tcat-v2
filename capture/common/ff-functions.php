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
function getSearchBins(){
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