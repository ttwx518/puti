<?php exit(); ?> Time: 2015-12-07 15:57:50. || Page: /puti/ || IP: 127.0.0.1 || Error: 连接数据库失败，可能数据库密码不对或数据库服务器出错！
<?php exit(); ?> Time: 2015-12-09 15:29:00. || Page: /puti/myadmin/infolist_do.php || IP: 127.0.0.1 || Error: Unknown column 'cid' in 'where clause' Error sql: SELECT * FROM `lxlp_infolist` WHERE siteid='1' AND delstate='' AND cid=2 AND (classid=2 OR parentstr Like '%,2,%')AND id<>0
<?php exit(); ?> Time: 2015-12-09 15:29:00. || Page: /puti/myadmin/infolist_do.php || IP: 127.0.0.1 || Error: Unknown column 'cid' in 'where clause' Error sql: SELECT * FROM `lxlp_infolist` WHERE siteid='1' AND delstate='' AND cid=2 AND (classid=2 OR parentstr Like '%,2,%')AND id<>0 ORDER BY id desc LIMIT 0, 20
<?php exit(); ?> Time: 2015-12-09 15:29:02. || Page: /puti/myadmin/infolist_do.php || IP: 127.0.0.1 || Error: Unknown column 'cid' in 'where clause' Error sql: SELECT * FROM `lxlp_infolist` WHERE siteid='1' AND delstate='' AND cid=5 AND (classid=5 OR parentstr Like '%,5,%')AND id<>0
<?php exit(); ?> Time: 2015-12-09 15:29:02. || Page: /puti/myadmin/infolist_do.php || IP: 127.0.0.1 || Error: Unknown column 'cid' in 'where clause' Error sql: SELECT * FROM `lxlp_infolist` WHERE siteid='1' AND delstate='' AND cid=5 AND (classid=5 OR parentstr Like '%,5,%')AND id<>0 ORDER BY id desc LIMIT 0, 20
<?php exit(); ?> Time: 2015-12-09 15:29:26. || Page: /puti/myadmin/infolist_do.php || IP: 127.0.0.1 || Error: Unknown column 'cid' in 'where clause' Error sql: SELECT * FROM `lxlp_infolist` WHERE siteid='1' AND delstate='' AND cid=5 AND (classid=5 OR parentstr Like '%,5,%')AND id<>0
<?php exit(); ?> Time: 2015-12-09 15:29:26. || Page: /puti/myadmin/infolist_do.php || IP: 127.0.0.1 || Error: Unknown column 'cid' in 'where clause' Error sql: SELECT * FROM `lxlp_infolist` WHERE siteid='1' AND delstate='' AND cid=5 AND (classid=5 OR parentstr Like '%,5,%')AND id<>0 ORDER BY id desc LIMIT 0, 20
<?php exit(); ?> Time: 2015-12-09 15:29:28. || Page: /puti/myadmin/infolist_do.php || IP: 127.0.0.1 || Error: Unknown column 'cid' in 'where clause' Error sql: SELECT * FROM `lxlp_infolist` WHERE siteid='1' AND delstate='' AND cid=2 AND (classid=2 OR parentstr Like '%,2,%')AND id<>0
<?php exit(); ?> Time: 2015-12-09 15:29:28. || Page: /puti/myadmin/infolist_do.php || IP: 127.0.0.1 || Error: Unknown column 'cid' in 'where clause' Error sql: SELECT * FROM `lxlp_infolist` WHERE siteid='1' AND delstate='' AND cid=2 AND (classid=2 OR parentstr Like '%,2,%')AND id<>0 ORDER BY id desc LIMIT 0, 20
<?php exit(); ?> Time: 2015-12-12 14:27:29. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Unknown column 'useintegral' in 'field list' Error sql: INSERT INTO `lxlp_goodsorder`
                    (uid, recUid, recUid2, ordernum, addressId, name, mobile, prov, city, country, pccinfo, address, zipcode, 
                     paymode, postmode, isTax, taxHead, buyremark, weight, cost, goodsAmount, amount, checkinfo, 
                     createtime, updatetime, useintegral)
                    VALUES
                    ('25', '177', '0', '20151212142734709', '136', 'mxy', 
                     '18721579528', '2000', '2002', 
                     '2002.12', '河北省唐山市唐海县', 'asdf', 
                     '221700', '1', '2', '', '', 
                     '', '0', '0', 
                     '98', '98', 'confirm', '1449901649', '1449901649', '118')
<?php exit(); ?> Time: 2015-12-13 22:14:15. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Column 'id' in field list is ambiguous Error sql: SELECT count(id) num FROM `lxlp_integral` as i left join `lxlp_member` as m on i.uid=m.id WHERE uid=402
<?php exit(); ?> Time: 2015-12-13 22:14:53. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Column 'id' in field list is ambiguous Error sql: SELECT count(id) num FROM `lxlp_integral` as i left join `lxlp_member` as m on i.uid=m.id WHERE uid=402
<?php exit(); ?> Time: 2015-12-14 14:03:12. || Page: /puti/index.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'andclassid= 5' at line 1 Error sql: SELECT * FROM `lxlp_infolist` WHERE delstate='' AND checkinfo='true' AND starttime<1450072992 and endtime>1450072992 andclassid= 5
<?php exit(); ?> Time: 2015-12-17 00:16:06. || Page: /puti/index.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: select * from lxlp_infolist where id=
<?php exit(); ?> Time: 2015-12-17 16:10:37. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Unknown table 'msg' Error sql: select m.wechat_nickname,m.wechat_headimgurl,msg.* from `lxlp_message` as f left join  `lxlp_member` as g on msg.uid=m.id where msg.uid=402 and checkinfo='1' order by id desc
<?php exit(); ?> Time: 2015-12-17 16:11:45. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Unknown column 'createtime' in 'field list' Error sql: insert into `lxlp_message` (uid, content, createtime, checkinfo) values (402,'asdf',1450339905,'1')
<?php exit(); ?> Time: 2015-12-17 17:59:11. || Page: /puti/index.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE id=11' at line 1 Error sql: SELECT id,title,auid `lxlp_infolist` WHERE id=11
<?php exit(); ?> Time: 2015-12-17 17:59:11. || Page: /puti/index.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE id=' at line 1 Error sql: SELECT openid `lxlp_infolist` WHERE id=
<?php exit(); ?> Time: 2015-12-17 17:59:11. || Page: /puti/index.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''\xE7\xA7\x8D\xE5\xAD\x90\xE6\x8D\x90\xE8\xB5\xA0',402)' at line 2 Error sql: INSERT INTO `lxlp_integral`(uid,ordernum,integral,posttime,content,fuid)
            VALUES (402,'','-2147483647',,'种子捐赠',402)
<?php exit(); ?> Time: 2015-12-17 17:59:34. || Page: /puti/index.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE id=11' at line 1 Error sql: SELECT id,title,auid `lxlp_infolist` WHERE id=11
<?php exit(); ?> Time: 2015-12-17 17:59:34. || Page: /puti/index.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE id=' at line 1 Error sql: SELECT openid `lxlp_member` WHERE id=
<?php exit(); ?> Time: 2015-12-17 17:59:34. || Page: /puti/index.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''\xE7\xA7\x8D\xE5\xAD\x90\xE6\x8D\x90\xE8\xB5\xA0',402)' at line 2 Error sql: INSERT INTO `lxlp_integral`(uid,ordernum,integral,posttime,content,fuid)
            VALUES (402,'','-2147483647',,'种子捐赠',402)
<?php exit(); ?> Time: 2015-12-17 17:59:51. || Page: /puti/index.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''\xE7\xA7\x8D\xE5\xAD\x90\xE6\x8D\x90\xE8\xB5\xA0',402)' at line 2 Error sql: INSERT INTO `lxlp_integral`(uid,ordernum,integral,posttime,content,fuid)
            VALUES (402,'','-2147483647',,'种子捐赠',402)
<?php exit(); ?> Time: 2015-12-18 13:01:40. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery_list' doesn't exist Error sql: SELECT count(id) cc FROM `lxlp_lottery_list` WHERE uid='402' and dateline>='1450368000' and type=0
<?php exit(); ?> Time: 2015-12-18 13:01:40. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery' doesn't exist Error sql: SELECT * FROM `lxlp_lottery` where id=1
<?php exit(); ?> Time: 2015-12-18 13:32:14. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery_list' doesn't exist Error sql: SELECT count(id) cc FROM `lxlp_lottery_list` WHERE uid='402' and dateline>='1450368000' and type=0
<?php exit(); ?> Time: 2015-12-18 13:32:14. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery' doesn't exist Error sql: SELECT * FROM `lxlp_lottery` where id=1
<?php exit(); ?> Time: 2015-12-18 13:33:23. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery_list' doesn't exist Error sql: SELECT count(id) cc FROM `lxlp_lottery_list` WHERE uid='402' and dateline>='1450368000' and type=0
<?php exit(); ?> Time: 2015-12-18 13:33:23. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery' doesn't exist Error sql: SELECT * FROM `lxlp_lottery` where id=1
<?php exit(); ?> Time: 2015-12-18 13:33:24. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery_list' doesn't exist Error sql: SELECT count(id) cc FROM `lxlp_lottery_list` WHERE uid='402' and dateline>='1450368000' and type=0
<?php exit(); ?> Time: 2015-12-18 13:33:24. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery' doesn't exist Error sql: SELECT * FROM `lxlp_lottery` where id=1
<?php exit(); ?> Time: 2015-12-18 13:33:25. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery_list' doesn't exist Error sql: SELECT count(id) cc FROM `lxlp_lottery_list` WHERE uid='402' and dateline>='1450368000' and type=0
<?php exit(); ?> Time: 2015-12-18 13:33:25. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery' doesn't exist Error sql: SELECT * FROM `lxlp_lottery` where id=1
<?php exit(); ?> Time: 2015-12-18 13:33:25. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery_list' doesn't exist Error sql: SELECT count(id) cc FROM `lxlp_lottery_list` WHERE uid='402' and dateline>='1450368000' and type=0
<?php exit(); ?> Time: 2015-12-18 13:33:25. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery' doesn't exist Error sql: SELECT * FROM `lxlp_lottery` where id=1
<?php exit(); ?> Time: 2015-12-18 13:33:25. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery_list' doesn't exist Error sql: SELECT count(id) cc FROM `lxlp_lottery_list` WHERE uid='402' and dateline>='1450368000' and type=0
<?php exit(); ?> Time: 2015-12-18 13:33:25. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery' doesn't exist Error sql: SELECT * FROM `lxlp_lottery` where id=1
<?php exit(); ?> Time: 2015-12-18 13:33:52. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery_list' doesn't exist Error sql: SELECT count(id) cc FROM `lxlp_lottery_list` WHERE uid='402' and dateline>='1450368000' and type=0
<?php exit(); ?> Time: 2015-12-18 13:33:52. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Table 'puti.lxlp_lottery' doesn't exist Error sql: SELECT * FROM `lxlp_lottery` where id=1
<?php exit(); ?> Time: 2015-12-18 13:44:49. || Page: /puti/index.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' and result_desc !='' ORDER BY id DESC' at line 1 Error sql: SELECT * FROM `lxlp_lottery_list` WHERE uid=402' and result_desc !='' ORDER BY id DESC
<?php exit(); ?> Time: 2015-12-23 21:10:31. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Unknown column 'iid' in 'where clause' Error sql: SELECT * FROM `lxlp_fav` WHERE uid=402 and iid=11
<?php exit(); ?> Time: 2015-12-23 21:10:31. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Unknown column 'iid' in 'field list' Error sql: insert into `lxlp_fav` (uid,iid,createtime) values (402,11,1450876231)
<?php exit(); ?> Time: 2015-12-23 21:18:42. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Unknown column 'f.uid' in 'where clause' Error sql: select id,gid,iid from `lxlp_fav` where f.uid=402
<?php exit(); ?> Time: 2015-12-24 11:13:27. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Column count doesn't match value count at row 1 Error sql: INSERT INTO `lxlp_integral`(uid,ordernum,integral,posttime,content,fuid,type)
            VALUES (402,'','-8',1450926807,'种子捐赠',402)
<?php exit(); ?> Time: 2015-12-24 11:16:26. || Page: /puti/index.php || IP: 127.0.0.1 || Error: Column count doesn't match value count at row 1 Error sql: INSERT INTO `lxlp_integral`(uid,ordernum,integral,posttime,content,fuid,type)
            VALUES (402,'','-8',1450926986,'种子捐赠',402)
<?php exit(); ?> Time: 2016-01-06 11:13:30. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT * FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:13:32. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT * FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:13:33. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT * FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:13:35. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT * FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:13:36. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT * FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:13:37. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT * FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:13:39. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT * FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:13:40. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT * FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:13:41. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT * FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:13:42. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT * FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:13:43. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT * FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:13:48. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT * FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:13:50. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT * FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:13:52. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT * FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:19:39. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT title,id FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-06 11:19:39. || Page: /puti/myadmin/lottery_do.php || IP: 127.0.0.1 || Error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 Error sql: SELECT title,id FROM `lxlp_infolist` where id=
<?php exit(); ?> Time: 2016-01-08 14:17:16. || Page: /puti/ || IP: 127.0.0.1 || Error: Unknown column 'marketprice_dashi' in 'field list' Error sql: SELECT weight,id,picurl,title,colorval,boldval,flag,salesprice,marketprice,marketprice_dashi,marketprice_tianshi,salenum FROM `lxlp_goods` WHERE (typeid=1 or typepid=1) AND checkinfo='true' AND delstate='' ORDER BY orderid DESC limit 0, 20
<?php exit(); ?> Time: 2016-01-08 16:55:03. || Page: /puti/myadmin/goodsorder.php || IP: 127.0.0.1 || Error: Unknown column 'o.createdate' in 'where clause' Error sql: SELECT o.*,m.username FROM `lxlp_goodsorder` o LEFT JOIN `lxlp_member` m ON o.uid=m.id WHERE o.delstate='' AND o.createdate>=1451923200 AND (o.goodsNames LIKE '%3%')
<?php exit(); ?> Time: 2016-01-08 16:55:03. || Page: /puti/myadmin/goodsorder.php || IP: 127.0.0.1 || Error: Unknown column 'o.createdate' in 'where clause' Error sql: SELECT o.*,m.username FROM `lxlp_goodsorder` o LEFT JOIN `lxlp_member` m ON o.uid=m.id WHERE o.delstate='' AND o.createdate>=1451923200 AND (o.goodsNames LIKE '%3%') ORDER BY id desc LIMIT 0, 20
<?php exit(); ?> Time: 2016-01-08 16:55:21. || Page: /puti/myadmin/goodsorder.php || IP: 127.0.0.1 || Error: Unknown column 'o.posttime' in 'where clause' Error sql: SELECT o.*,m.username FROM `lxlp_goodsorder` o LEFT JOIN `lxlp_member` m ON o.uid=m.id WHERE o.delstate='' AND o.posttime>=1451923200 AND (o.goodsNames LIKE '%3%')
<?php exit(); ?> Time: 2016-01-08 16:55:21. || Page: /puti/myadmin/goodsorder.php || IP: 127.0.0.1 || Error: Unknown column 'o.posttime' in 'where clause' Error sql: SELECT o.*,m.username FROM `lxlp_goodsorder` o LEFT JOIN `lxlp_member` m ON o.uid=m.id WHERE o.delstate='' AND o.posttime>=1451923200 AND (o.goodsNames LIKE '%3%') ORDER BY id desc LIMIT 0, 20
<?php exit(); ?> Time: 2016-01-11 09:51:47. || Page: / || IP: 127.0.0.1 || Error: 连接数据库失败，可能数据库密码不对或数据库服务器出错！
<?php exit(); ?> Time: 2016-01-28 09:51:40. || Page: /puti/index.php || IP: 127.0.0.1 || Error: BIGINT UNSIGNED value is out of range in '(`puti`.`lxlp_member`.`yongjin` - 100)' Error sql: UPDATE `lxlp_member` SET yongjin=yongjin - 100 where id=415
<?php exit(); ?> Time: 2016-01-28 09:53:46. || Page: /puti/index.php || IP: 127.0.0.1 || Error: BIGINT UNSIGNED value is out of range in '(`puti`.`lxlp_member`.`yongjin` - 100)' Error sql: UPDATE `lxlp_member` SET yongjin=yongjin - 100 where id=415
<?php exit(); ?> Time: 2016-08-10 14:56:50. || Page: /myadmin/ || IP: 127.0.0.1 || Error: 连接数据库失败，可能数据库密码不对或数据库服务器出错！
<?php exit(); ?> Time: 2016-08-10 14:56:51. || Page: /myadmin/ || IP: 127.0.0.1 || Error: 连接数据库失败，可能数据库密码不对或数据库服务器出错！
<?php exit(); ?> Time: 2016-08-11 10:34:16. || Page: /index.php || IP: 127.0.0.1 || Error: Erreur de syntaxe près de '' à la ligne 1 Error sql: SELECT * FROM `lxlp_infoclass` WHERE id=
<?php exit(); ?> Time: 2016-08-11 10:34:17. || Page: /index.php || IP: 127.0.0.1 || Error: Erreur de syntaxe près de '' à la ligne 1 Error sql: SELECT * FROM `lxlp_infoclass` WHERE id=
<?php exit(); ?> Time: 2016-08-11 10:48:42. || Page: /index.php || IP: 127.0.0.1 || Error: Erreur de syntaxe près de '10:48 >= starttime' à la ligne 1 Error sql: select * from `lxlp_infolist` where classid=5 AND delstate='' AND checkinfo='true'  and starttime <= 1470883722 and 1470883722 <= endtime and 2016-08-11 10:48 >= starttime 
<?php exit(); ?> Time: 2016-08-11 10:48:43. || Page: /index.php || IP: 127.0.0.1 || Error: Erreur de syntaxe près de '10:48 >= starttime' à la ligne 1 Error sql: select * from `lxlp_infolist` where classid=5 AND delstate='' AND checkinfo='true'  and starttime <= 1470883723 and 1470883723 <= endtime and 2016-08-11 10:48 >= starttime 
<?php exit(); ?> Time: 2016-08-11 10:49:55. || Page: /index.php || IP: 127.0.0.1 || Error: Erreur de syntaxe près de '10:49 >= starttime' à la ligne 1 Error sql: select * from `lxlp_infolist` where classid=5 AND delstate='' AND checkinfo='true'  and 2016-08-11 10:49 >= starttime 
<?php exit(); ?> Time: 2016-08-11 10:50:15. || Page: /index.php || IP: 127.0.0.1 || Error: Erreur de syntaxe près de '10:48 >= starttime  and starttime <= 1470883815 and 1470883815 <= endtime' à la ligne 1 Error sql: select * from `lxlp_infolist` where classid=5 AND delstate='' AND checkinfo='true'  and 2016-08-11 10:48 >= starttime  and starttime <= 1470883815 and 1470883815 <= endtime
<?php exit(); ?> Time: 2016-08-11 10:50:16. || Page: /index.php || IP: 127.0.0.1 || Error: Erreur de syntaxe près de '10:48 >= starttime  and starttime <= 1470883816 and 1470883816 <= endtime' à la ligne 1 Error sql: select * from `lxlp_infolist` where classid=5 AND delstate='' AND checkinfo='true'  and 2016-08-11 10:48 >= starttime  and starttime <= 1470883816 and 1470883816 <= endtime
<?php exit(); ?> Time: 2016-08-11 10:50:16. || Page: /index.php || IP: 127.0.0.1 || Error: Erreur de syntaxe près de '10:48 >= starttime  and starttime <= 1470883816 and 1470883816 <= endtime' à la ligne 1 Error sql: select * from `lxlp_infolist` where classid=5 AND delstate='' AND checkinfo='true'  and 2016-08-11 10:48 >= starttime  and starttime <= 1470883816 and 1470883816 <= endtime
