# betterlife

符合中国开发者思维方式的快速开发的框架，设计初衷快捷、简单、实用。

它包括一套实用的通用模版、后台管理模版、手机模版，并根据项目的需要，按照数据库的设计一键生成定制化的代码框架。

## 安装说明

### 推荐方式

* **通过Github官网下载**

    官网地址: https://github.com/skygreen2001/betterlife.core

    ```
    > git clone https://github.com/skygreen2001/betterlife.core.git
    > git clone git@github.com:skygreen2001/betterlife.core.git
    ```
* **安装NodeJs**

  下载地址: https://nodejs.org/en/download/

* **安装 composer**

  安装composer: http://docs.phpcomposer.com/00-intro.html

* **安装Gulp**

  ```
  > npm install -g gulp
  ```

* **安装目录下运行**

  安装目录是根目录下的install目录, 即本说明文件目录下

  - 运行npm

    ```
    > npm install
    ```
    [Mac电脑用户]: sudo npm install

  - 运行composer

    ```
    > composer install
    ```
    [Mac电脑用户]: sudo composer install

  - 运行gulp

    ```
    > sudo gulp
    ```

  - 安装ueditor

    ```
    > sudo gulp ueditor_cp && sudo gulp ueditor
    ```

### [手动方式](install/README.md)

## 框架目录定义
  - core   : 框架核心支持文件
  - taglib : 自定义标签，您也可以在自己的应用中定义自定义标签
  - install: 安装目录
  - misc   : 引用第三方Js、Css、Image、Fonts资源目录
  - tools  : 开发项目中通常用到的工具，包括项目重用工具、代码生成工具、消除整站文件BOM头工具、压力测试工具等
  - home   : 应用目录，Web应用层所有代码都放在这里，每一个Web应用是一个子目录。
             (每个应用目录名称需在Gc.php里的变量:$module_name里注册)
  - api    : ajax请求服务端服务支持[手机或Web前端ajax请求返回json数据]
  - app    : 自适应html5Web网页[内嵌在手机App里]
  - log    : 日志目录，每天一个调试测试日志文件放在这里
  - upload : 后台上传文件(如图片、pdf)放置目录    
  - docs   : 框架帮助说明文档

  - 重要的二级目录说明
    - core/config      : 配置文件[各个功能模块]
    - install/db       : 框架数据库备份包括测试数据
    - core/include     : 常用的函数库
    - api/mobile       : 手机端ajax请求服务端返回json数据
    - api/web          : Pc端ajax请求服务端返回json数据
    - upload/images    : 上传图片放置路径
    - upload/attachment: 批量导入/导出数据文件(如excel)放置目录

## 参考资料

* **安装NodeJs**
  > https://nodejs.org/en/download/
* **安装Gulp**
  > 中文说明: http://www.gulpjs.com.cn/docs/getting-started/
  > 英文说明: http://www.gulpjs.com
* **安装Composer**
  > http://www.phpcomposer.com/
* **下载Smarty**
  > https://github.com/smarty-php/smarty
* **下载PHPExcel**
  > https://github.com/PHPOffice/PHPExcel
* **安装UEditor**
  > http://ueditor.baidu.com/website/download.html
* **本框架帮助文档**
  > http://skygreen2001.gitbooks.io/betterlife-cms-framework/content/index.html
