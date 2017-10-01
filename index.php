<?php
if(isset($_POST['submit'])){
    getList($_POST['str'],$_POST['p']);
}
function getList($str,$p){
    $json = file_get_contents('https://jsonmock.hackerrank.com/api/countries/search?name='.$str); // this WILL do an http request for you
    $data = json_decode($json);
    $outputCnt=0;
    $total=$data->{'total'};

        if($data->{'total_pages'}==1){
            $dataArray=$data->{'data'};
            for($j=0;$j<$total;$j++){
                if($dataArray[$j]->{'population'}>$p){
                    $outputCnt++;
                }
            }
        }else{
            for($i=1;$i<=$data->{'total_pages'};$i++){
                $json = file_get_contents('https://jsonmock.hackerrank.com/api/countries/search?name='.$str.'&page='.$i); // this WILL do an http request for you
                $data = json_decode($json);
                if($i==$data->{'total_pages'}){
                    $dataArray=$data->{'data'};
                    for($j=0;$j<$total;$j++){
                        if($dataArray[$j]->{'population'}>$p){
                            $outputCnt++;
                        }
                    }
                }else{
                    $dataArray=$data->{'data'};
                    for($j=0;$j<10;$j++){
                        if($dataArray[$j]->{'population'}>$p){
                            $outputCnt++;
                        }
                    }
                    $total=$total-10;
                }
            }        
        }
    echo $outputCnt;
    
}
?>
<html>
    <head>
        <title>Question 2</title>
    </head>
    <body>
        <form action="index.php" method="post">
            Enter Substring:<input type="text" name="str"><br>
            Enter population:<input type="text"name="p"><br>
            <input type="submit" name="submit">
        </form>
    </body>
</html>