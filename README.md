#Graduation Project for HUST Computer Science And Technology Academy

##Deploy
require PHP version:5.3.0+
require MYSQL version:5.6.0+
Templete:ThinkPHP

###Linux
Deploy By LNMP(Linux,Nginx,Mysql,PHP)</br>

Nginx Configure File:
[nginx server config](https://github.com/AHEADer/bs/blob/master/nginx_config.conf)
Mysql:
In many situations,you have to install from the oracle website</br>
when deploy,create the databse bs,then import bs.sql,the origin admin account is "telanx",password is "abcd"</br>

Php:
remember to install php,php-fpm,php-mysql</br>
change config file in /ThinkPHP/Conf/convention.php,the databse,database password and so on

###Windows
I don't know how to deploy in IIS

##Left Problems
###管理员
*显示未选题学生</br>
*正确显示课题总览里面的统计，增加多次审核的显示结果</br>
*选题时间的前端适配</br>
###教师
*对于信息未填写完整的教师,提示填写信息,否则不能填报课题</br>
*相应的系主任的课题总览只能查看自己所属部门的课题和审核情况，院长则只能查看所有的系主任已通过的课题的审核情况</br>
*录入课题前端适配问题，部分浏览器不能下拉滚动条</br>
###学生
*暂无
