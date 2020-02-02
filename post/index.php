<?php
    if (isset($_GET['post']) and $_GET['post'] == 'get_post') {
        if (isset($_GET['id']) and isset($_GET['end_cursor'])) {
            $id = $_GET['id'];
            $end_cursor = $_GET['end_cursor'];
            $count = 12;

            if (isset($_GET['count'])) {
                $count = $_GET['count'];
            }

            $link = 'https://www.instagram.com/graphql/query/?query_hash=e769aa130647d2354c40ea6a439bfc08&variables=%7B%22id%22%3A%22'.$id.'%22%2C%22first%22%3A'.$count.'%2C%22after%22%3A%22'.$end_cursor.'%3D%3D%22%7D';
            $insta_source = file_get_contents($link);
            // $insta_source = file_get_contents('https://www.instagram.com/graphql/query/?query_hash=e769aa130647d2354c40ea6a439bfc08&variables=%7B%22id%22%3A%22492446087%22%2C%22first%22%3A12%2C%22after%22%3A%22QVFDa2d3SVBadjFOaUJnX1gwNDM3c1M3anBMUGpuNGc0MTFoWHAya0V2QUswUm1pZGw2d3FlRGUzSUNoOTJPQklLelFlREVReS1WbTcxQTktcllCcVZETg%3D%3D%22%7D');
            
            $response = ['success' => true, 'result' => $insta_source, 'from' => $link, 'get' => $_GET];
            header('Content-Type: application/json');
            echo(json_encode($response));
        } else {
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('status' => 'ERROR', 'success' => false, 'message' => 'not found \'id\' and \'end_cursor\'')));
        }
    } else {
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('status' => 'ERROR', 'success' => false)));
    }
?>