<?php

//Connect to DB
$connection = mysqli_connect("localhost", "ukfl2020", "f801z3701h");
if(!$connection)
{
    die('Could not connect: ' . mysqli_error($connection));
}
mysqli_query($connection, "USE ovs;");

//Query DB
$sql = "SELECT eqm.ticker,eqm.issuer,UNIX_TIMESTAMP(eqp.date_) * 1000 as date, pcrc.volumeRatio AS vratio, pcrc.openIntRatio as oiratio, eqp.open_ as open, eqp.high, eqp.low, eqp.close_ as close, (eq1.factor / eq2.factor) as 'factor' 
    FROM eqprice AS eqp
	LEFT JOIN eqfactor AS eq1 ON eq1.eqId=eqp.eqId AND eqp.date_ between eq1.startDate and eq1.endDate AND eq1.adjType=1 
    LEFT JOIN eqfactor AS eq2 ON eq2.eqId=eqp.eqId AND '2020-10-05' between eq2.startDate AND eq2.endDate AND eq2.adjType=1  
    LEFT JOIN eqmaster AS eqm ON eqm.eqid=eqp.eqId AND eqp.date_ between eqm.startDate AND eqm.endDate 
    LEFT JOIN putcallratiochart AS pcrc ON eqp.eqid=pcrc.eqID AND eqp.date_=pcrc.date_
    WHERE eqm.ticker = '" . $_GET['ticker'] . "';";
$result = mysqli_query($connection, $sql);

//Extract data from query
$data = [];
while($row = mysqli_fetch_assoc($result))
{
    $data["ohlc"][] = array($row["date"], $row["open"] * $row["factor"], $row["high"] * $row["factor"], $row["low"] * $row["factor"], $row["close"] * $row["factor"]);
    $data["vratio"][] = array($row["date"], $row["vratio"]);
    $data["oiratio"][] = array($row["date"], $row["oiratio"]);
    $data["ticker"] = $row["ticker"];
    $data["issuer"] = $row["issuer"];
}
//Send data to index.php as an array and it recieves it as a javascript object 
echo json_encode($data, JSON_NUMERIC_CHECK);

//Close database connection
mysqli_close($connection);


/* ODDS examples
$sql = "SELECT eqp.eqid,eqm.ticker,eqm.issuer,eqp.date_,eqp.close_, iv.ivMid
    FROM eqprice AS eqp 
    LEFT JOIN eqmaster AS eqm ON eqm.eqid=eqp.eqid AND eqp.date_ between eqm.startDate AND eqm.endDate 
    LEFT JOIN ivcmpr as iv on eqp.eqId = iv.eqId and eqp.date_=iv.date_ and iv.strike=100
    WHERE eqm.ticker = 'aapl' and eqp.date_='2020-04-13'
    LIMIT 1;";

$sql = "SELECT eqp.date_ as date, eqp.open_ as open, eqp.high, eqp.low, eqp.close_ as close, (eq1.factor / eq2.factor) as 'factor' 
    FROM eqprice AS eqp
    LEFT JOIN eqfactor AS eq1 ON eq1.eqId=eqp.eqId AND eqp.date_ between eq1.startDate and eq1.endDate AND eq1.adjType=1 
    LEFT JOIN eqfactor AS eq2 ON eq2.eqId=eqp.eqId AND '2020-10-05' between eq2.startDate AND eq2.endDate AND eq2.adjType=1 
    LEFT JOIN eqmaster AS eqm ON eqm.eqId=eqp.eqId AND '2020-10-05' BETWEEN eqm.startDate AND eqm.endDate 
    WHERE eqm.ticker = 'aapl' AND eqp.date_<='2020-10-05';";
*/

?>
