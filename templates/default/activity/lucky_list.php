<?php
$title="中奖查询";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title><?php echo $title?></title>
<script>
	
</script>
<style type="text/css">
.wrap { max-width: 640px; margin: 0 auto; position: relative; overflow-x: hidden; }
.table { border: 1px solid #ccc; width: 100%; background-color: #fff;  color: #888;}
.table tr th { color: #C1140B; padding: 5px; border: 1px solid #ccc; }
.table tr td { font-size: 10px; padding: 5px; border: 1px solid #ccc; }
</style>
</head>
<body>
	<section class="wrap">
	       <header class="header c">
         	<a href="javascript:history.go(-1)" class="back"></a>
            <?php echo $title;?>
        </header>
        <section class="main p10">
            <table class="table mt10 c">
            	<tr>
                	<th>奖项</th>
                	<th>奖品</th>
                    <th>是否兑奖</th>
                    <th>时间</th>
                </tr>
                <?php
                        $dosql->Execute("SELECT * FROM `#@__lottery_list` WHERE uid={$userInfo['id']} and result_desc !='' ORDER BY id DESC");
                        $data = '';
                        while($row = $dosql->GetArray())
                        {
                            
                    ?>
                <tr>
                	<td>
                	<?php 
                	if($row["result"]=='1'){
                		echo "一等奖";
                	}elseif($row["result"]=='2'){
                		echo "二等奖";
                	}elseif($row["result"]=='3'){
                		echo "三等奖";
                	}
                	?>
                	</td>
                	<td><?php echo $row["result_desc"];?></td>
                    <td><?php echo $row["status"]==0?"未兑奖":"已兑奖";?></td>
                    <td><?php echo date("Y-m-d",$row["dateline"]);?></td>
                </tr>
                <?php 
                        }
                    ?>
            </table>
        </section>
	</section>
</body>
</html>

