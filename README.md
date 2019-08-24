# chat

### 项目介绍
本项目为一个网页聊天项目,后端采用了laravel与Swoole结合的方式编写而成
前端为vue+elementUi,前端UI仿写的[LayIm](http://layim.layui.com/)界面,
目前已实现一些基本功能如:
* 已能进行好友通信
* 好友认证
* 好友添加
* 好友搜索

等相关功能。例外还有些不足,有些功能未完善,如:
* 聊天窗口的工具栏
* 群组未实现
* 没有emoji表情包发送等

后期有时间会继续更新此项目,现在如有志同道合闲得慌的可以clone一份下载下去继续完善一下


### 安装方法

#### 安装环境检查及配置

| 步骤  |
| ------|
|  确定mysql版本 >= 5.7 |
|  php版本 >= 7.1 |
|  php扩展安装了 fileinfo 扩展 |
|  移除掉php禁用函数 putenv |
|  移除掉php禁用函数 readlink |
|  移除掉php禁用函数 symlink |
|  移除掉php禁用函数 proc_open |
|  安装了swoole 扩展 没安装运行 `pecl install swoole` 安装 |
|  优化项:建议安装opcache 扩展 |




#### 具体安装
| 步骤 | 指令 |
| ------ | ------ |
| 1.下载 | git clone https://github.com/JueMeiAlg/chat.git 下载后执行 cd chat |
| 2.安装依赖 | composer update 或者 composer install|
| 3.复制出环境配置文件 |php -r "copy('.env.example', '.env')"; |
| 4.配置你的数据库连接信息 | 在项目根目录.env文件中的 DB_DATABASE DB_USERNAME DB_PASSWORD 等字段处填写你的数据库信息 |
| 5.修改.env APP_URL 处信息 | 此处填写你当前配置的网站域名 |
| 6.生成APP_KEY | php artisan key:generate |
| 7.运行数据迁移 | php artisan migrate |
| 8.运行数据填充 | php artisan db:seed |
| 8.storage软连接 | php artisan storage:link|
| 10.给予缓存文件合适的权限 | chmod -R 755 storage  |
| 11.运行程序  | `php artisan chat {start\stop\restart}`  --d 是否守护进程模式运行|
| 12.修改客户端访问地址  | /resource/basedata.json 中更改你具体的连接地址|
| 13.访问地址  | yourURL/ 默认登录账户13686840083 123456 |

#### 其他

* 输入指令 `php artisan chat --h` 可以查看具体的指令帮助信息