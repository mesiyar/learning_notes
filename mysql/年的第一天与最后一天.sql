-- 当年第一天：
SELECT DATE_SUB(CURDATE(),INTERVAL dayofyear(now())-1 DAY);
 
-- 当年最后一天：
SELECT concat(YEAR(now()),'-12-31');  
 
-- 当前week的第一天：  
select date_sub(curdate(),INTERVAL WEEKDAY(curdate()) + 1 DAY);
 
-- 当前week的最后一天：  
select date_sub(curdate(),INTERVAL WEEKDAY(curdate()) - 5 DAY);
 
-- 前一week的第一天：  
select date_sub(curdate(),INTERVAL WEEKDAY(curdate()) + 8 DAY);
 
-- 前一week的最后一天：  
select date_sub(curdate(),INTERVAL WEEKDAY(curdate()) + 2 DAY);
 
-- 前两week的第一天：  
select date_sub(curdate(),INTERVAL WEEKDAY(curdate()) + 15 DAY);
 
-- 前两week的最后一天：  
select date_sub(curdate(),INTERVAL WEEKDAY(curdate()) + 9 DAY);
 
-- 当前month的第一天：  
SELECT concat(date_format(LAST_DAY(now()),'%Y-%m-'),'01');
 
-- 当前month的最后一天：  
SELECT  LAST_DAY(now());
 
-- 前一month的第一天：  
SELECT concat(date_format(LAST_DAY(now() - interval 1 month),'%Y-%m-'),'01');
 
-- 前一month的最后一天：  
SELECT LAST_DAY(now() - interval 1 month);
 
-- 前两month的第一天：  
SELECT concat(date_format(LAST_DAY(now() - interval 2 month),'%Y-%m-'),'01');
 
-- 前两month的最后一天：  
SELECT  LAST_DAY(now() - interval 2 month);
 
-- 当前quarter的第一天：  
select concat(date_format(LAST_DAY(MAKEDATE(EXTRACT(YEAR FROM  CURDATE()),1) + interval QUARTER(CURDATE())*3-3 month),'%Y-%m-'),'01'); 
 
-- 当前quarter的最后一天：  
select LAST_DAY(MAKEDATE(EXTRACT(YEAR  FROM CURDATE()),1) + interval QUARTER(CURDATE())*3-1 month);
 
-- 前一quarter的第一天：  
select concat(date_format(LAST_DAY(MAKEDATE(EXTRACT(YEAR FROM CURDATE()),1) + interval QUARTER(CURDATE())*3-6 month),'%Y-%m-'),'01');
 
-- 前一quarter的最后一天：  
select  LAST_DAY(MAKEDATE(EXTRACT(YEAR FROM CURDATE()),1) + interval QUARTER(CURDATE())*3-4 month);
 
-- 前两quarter的第一天：  
select concat(date_format(LAST_DAY(MAKEDATE(EXTRACT(YEAR FROM CURDATE()),1) + interval QUARTER(CURDATE())*3-9 month),'%Y-%m-'),'01');
 
-- 前两quarter的最后一天：  
select LAST_DAY(MAKEDATE(EXTRACT(YEAR FROM CURDATE()),1) + interval QUARTER(CURDATE())*3-7 month);
