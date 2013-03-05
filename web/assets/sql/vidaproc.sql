DROP PROCEDURE `vida_rundaily`//
CREATE DEFINER=`vidaprint`@`%` PROCEDURE `vida_rundaily`()
NO SQL
begin
declare s datetime;
declare e datetime;

set e = CONCAT( SUBSTR( NOW( ) , 1, 11 ) , '00:00:00' ) ;
set s = DATE_SUB( e, INTERVAL 1 DAY) ;


insert into razor_vida_report_daily_user (period, product_id, channel, version, activeuser, updateuser, totaluser, totalsession)
select s as period, `r9`.`product_id` as `product_id`, `r9`.`channel_name` as `channel_name`,
`r8`.`version` as `version`,
`r8`.`activeusercount` as activeusercount,
`r8`.`updateusercount` as updateusercount,
`r8`.`totaluser` as totaluser,
`r8`.`totalsession` as totalsession  from
((select `r5`.`productkey` as productkey, `r5`.`version` as version, `r5`.`totaluser` as totaluser, `r5`.`totalsession` as totalsession, `r5`.`activeusercount` as activeusercount, ifnull(`r7`.`updateusercount`, 0) as updateusercount from
(
select `r2`.`productkey` as productkey, `r2`.`version` as version, `r2`.`totaluser` as totaluser, `r2`.`totalsession` as totalsession, ifnull(`r4`.`activeusercount`,0) as activeusercount from
(select `r1`.`productkey`,`r1`.`version`, count(`r1`.`deviceid`) AS `totaluser`,
sum(`r1`.`sessioncount`) AS `totalsession` from
`razor_vida`.`razor_vida_active_user` `r1` group by `r1`.`productkey`, `r1`.`version`) `r2` left join
(select count(*) as `activeusercount`, `r3`.`productkey` as `pk`
from `razor_vida`.`razor_vida_active_user` `r3`
where activedate >= s and activedate <e group by pk) `r4` on `r2`.`productkey` = `r4`.`pk`) `r5` left join
(select count(*) as `updateusercount`, `r6`.`productkey` as `pk`
from `razor_vida`.`razor_vida_active_user` `r6`
where updatedate >= s and updatedate <e group by pk) `r7` on `r5`.`productkey` = `r7`.`pk`) `r8` join (select `rc`.`channel_name` as `channel_name`, `rcp`.`productkey` as `productkey`, `rcp`.`product_id` as `product_id` from `razor`.`razor_channel` `rc`, `razor`.`razor_channel_product` `rcp` where `rc`.`channel_id` = `rcp`.`channel_id`) `r9` on `r8`.`productkey`=`r9`.`productkey`);


insert into razor_vida_report_daily_product (period, product_id, activeuser, updateuser, totaluser, totalsession)
(select s as period, `r9`.`product_id` as `product_id`,
sum(`r8`.`activeusercount`) as activeusercount,
sum(`r8`.`updateusercount`) as updateusercount,
sum(`r8`.`totaluser`) as totaluser,
sum(`r8`.`totalsession`) as totalsession  from
((select `r5`.`productkey` as productkey, `r5`.`totaluser` as totaluser, `r5`.`totalsession` as totalsession, `r5`.`activeusercount` as activeusercount, ifnull(`r7`.`updateusercount`, 0) as updateusercount from
(
select `r2`.`productkey` as productkey, `r2`.`version` as version, `r2`.`totaluser` as totaluser, `r2`.`totalsession` as totalsession, ifnull(`r4`.`activeusercount`,0) as activeusercount from
(select `r1`.`productkey`,`r1`.`version`, count(`r1`.`deviceid`) AS `totaluser`,
sum(`r1`.`sessioncount`) AS `totalsession` from
`razor_vida`.`razor_vida_active_user` `r1` group by `r1`.`productkey`, `r1`.`version`) `r2` left join
(select count(*) as `activeusercount`, `r3`.`productkey` as `pk`
from `razor_vida`.`razor_vida_active_user` `r3`
where activedate >= s and activedate < e group by pk) `r4` on `r2`.`productkey` = `r4`.`pk`) `r5` left join
(select count(*) as `updateusercount`, `r6`.`productkey` as `pk`
from `razor_vida`.`razor_vida_active_user` `r6`
where updatedate >= s and updatedate < e group by pk) `r7` on `r5`.`productkey` = `r7`.`pk`) `r8` join
(select `rcp`.`productkey` as `productkey`, `rcp`.`product_id` as `product_id` from `razor`.`razor_channel` `rc`, `razor`.`razor_channel_product` `rcp` where `rc`.`channel_id` = `rcp`.`channel_id`) `r9` on `r8`.`productkey`=`r9`.`productkey`) group by product_id);
end

DROP PROCEDURE `vida_runhourly`//
CREATE DEFINER=`vidaprint`@`%` PROCEDURE `vida_runhourly`()
NO SQL
begin
declare s datetime;
declare e datetime;

set e = CONCAT( SUBSTR( NOW( ) , 1, 14 ) , '00:00' );
set s = DATE_SUB( e, INTERVAL 1 HOUR) ;



insert into razor_vida_report_hourly_user (period, product_id, channel, version, activeuser, updateuser, totaluser, totalsession)
select s as period, `r9`.`product_id` as `product_id`, `r9`.`channel_name` as `channel_name`,
`r8`.`version` as `version`,
`r8`.`activeusercount` as activeusercount,
`r8`.`updateusercount` as updateusercount,
`r8`.`totaluser` as totaluser,
`r8`.`totalsession` as totalsession  from
((select `r5`.`productkey` as productkey, `r5`.`version` as version, `r5`.`totaluser` as totaluser, `r5`.`totalsession` as totalsession, `r5`.`activeusercount` as activeusercount, ifnull(`r7`.`updateusercount`, 0) as updateusercount from
(
select `r2`.`productkey` as productkey, `r2`.`version` as version, `r2`.`totaluser` as totaluser, `r2`.`totalsession` as totalsession, ifnull(`r4`.`activeusercount`,0) as activeusercount from
(select `r1`.`productkey`,`r1`.`version`, count(`r1`.`deviceid`) AS `totaluser`,
sum(`r1`.`sessioncount`) AS `totalsession` from
`razor_vida`.`razor_vida_active_user` `r1` group by `r1`.`productkey`, `r1`.`version`) `r2` left join
(select count(*) as `activeusercount`, `r3`.`productkey` as `pk`
from `razor_vida`.`razor_vida_active_user` `r3`
where activedate >= s and activedate <e group by pk) `r4` on `r2`.`productkey` = `r4`.`pk`) `r5` left join
(select count(*) as `updateusercount`, `r6`.`productkey` as `pk`
from `razor_vida`.`razor_vida_active_user` `r6`
where updatedate >= s and updatedate <e group by pk) `r7` on `r5`.`productkey` = `r7`.`pk`) `r8` join (select `rc`.`channel_name` as `channel_name`, `rcp`.`productkey` as `productkey`, `rcp`.`product_id` as `product_id` from `razor`.`razor_channel` `rc`, `razor`.`razor_channel_product` `rcp` where `rc`.`channel_id` = `rcp`.`channel_id`) `r9` on `r8`.`productkey`=`r9`.`productkey`);


insert into razor_vida_report_hourly_product (period, product_id, activeuser, updateuser, totaluser, totalsession)
(select s as period, `r9`.`product_id` as `product_id`,
sum(`r8`.`activeusercount`) as activeusercount,
sum(`r8`.`updateusercount`) as updateusercount,
sum(`r8`.`totaluser`) as totaluser,
sum(`r8`.`totalsession`) as totalsession  from
((select `r5`.`productkey` as productkey, `r5`.`totaluser` as totaluser, `r5`.`totalsession` as totalsession, `r5`.`activeusercount` as activeusercount, ifnull(`r7`.`updateusercount`, 0) as updateusercount from
(
select `r2`.`productkey` as productkey, `r2`.`version` as version, `r2`.`totaluser` as totaluser, `r2`.`totalsession` as totalsession, ifnull(`r4`.`activeusercount`,0) as activeusercount from
(select `r1`.`productkey`,`r1`.`version`, count(`r1`.`deviceid`) AS `totaluser`,
sum(`r1`.`sessioncount`) AS `totalsession` from
`razor_vida`.`razor_vida_active_user` `r1` group by `r1`.`productkey`, `r1`.`version`) `r2` left join
(select count(*) as `activeusercount`, `r3`.`productkey` as `pk`
from `razor_vida`.`razor_vida_active_user` `r3`
where activedate >= s and activedate < e group by pk) `r4` on `r2`.`productkey` = `r4`.`pk`) `r5` left join
(select count(*) as `updateusercount`, `r6`.`productkey` as `pk`
from `razor_vida`.`razor_vida_active_user` `r6`
where updatedate >= s and updatedate < e group by pk) `r7` on `r5`.`productkey` = `r7`.`pk`) `r8` join
(select `rcp`.`productkey` as `productkey`, `rcp`.`product_id` as `product_id` from `razor`.`razor_channel` `rc`, `razor`.`razor_channel_product` `rcp` where `rc`.`channel_id` = `rcp`.`channel_id`) `r9` on `r8`.`productkey`=`r9`.`productkey`) group by product_id);
end


DROP PROCEDURE `vida_runmonthly`//
CREATE DEFINER=`vidaprint`@`%` PROCEDURE `vida_runmonthly`()
NO SQL
begin
declare s datetime;
declare e datetime;

set e = CONCAT( SUBSTR( NOW( ) , 1, 8 ) , '01 00:00:00' );
set s = DATE_SUB( e, INTERVAL 1 MONTH) ;

insert into razor_vida_report_monthly_user (period, product_id, channel, version, activeuser, updateuser, totaluser, totalsession)
select s as period, `r9`.`product_id` as `product_id`, `r9`.`channel_name` as `channel_name`,
`r8`.`version` as `version`,
`r8`.`activeusercount` as activeusercount,
`r8`.`updateusercount` as updateusercount,
`r8`.`totaluser` as totaluser,
`r8`.`totalsession` as totalsession  from
((select `r5`.`productkey` as productkey, `r5`.`version` as version, `r5`.`totaluser` as totaluser, `r5`.`totalsession` as totalsession, `r5`.`activeusercount` as activeusercount, ifnull(`r7`.`updateusercount`, 0) as updateusercount from
(
select `r2`.`productkey` as productkey, `r2`.`version` as version, `r2`.`totaluser` as totaluser, `r2`.`totalsession` as totalsession, ifnull(`r4`.`activeusercount`,0) as activeusercount from
(select `r1`.`productkey`,`r1`.`version`, count(`r1`.`deviceid`) AS `totaluser`,
sum(`r1`.`sessioncount`) AS `totalsession` from
`razor_vida`.`razor_vida_active_user` `r1` group by `r1`.`productkey`, `r1`.`version`) `r2` left join
(select count(*) as `activeusercount`, `r3`.`productkey` as `pk`
from `razor_vida`.`razor_vida_active_user` `r3`
where activedate >= s and activedate < e group by pk) `r4` on `r2`.`productkey` = `r4`.`pk`) `r5` left join
(select count(*) as `updateusercount`, `r6`.`productkey` as `pk`
from `razor_vida`.`razor_vida_active_user` `r6`
where updatedate >= s and updatedate < e group by pk) `r7` on `r5`.`productkey` = `r7`.`pk`) `r8` join (select `rc`.`channel_name` as `channel_name`, `rcp`.`productkey` as `productkey`, `rcp`.`product_id` as `product_id` from `razor`.`razor_channel` `rc`, `razor`.`razor_channel_product` `rcp` where `rc`.`channel_id` = `rcp`.`channel_id`) `r9` on `r8`.`productkey`=`r9`.`productkey`);
end
