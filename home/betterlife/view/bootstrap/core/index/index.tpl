{extends file="$templateDir/layout/normal/layout.tpl"}
{block name=body}
  <div id="main-content-container" class="container-fluid" style="display:none;">
    <div class="section page" id="page1">
      <div class="container section-header-container">
        <div class="bb-lead-core">
          <span class="bb-icon">BB</span>
          <p class="lead">Betterlife is the most popular CMS framework for developing responsive, web first projects on the web browser.</p>
          <p class="lead"><a href="https://github.com/skygreen2001/betterlife/archive/master.zip" target="_blank" class="btn btn-outline-inverse btn-lg">下载 Betterlife Framework</a></p>
          <p class="version">版本 v1.0.0</p>
        </div>
      </div>
      <div class="starfield"></div>
    </div>

    <div class="section page" id="page2">
        <div class="container section-container">
            <h2 class="title slogan">I'm <span>BB</span>, 每一天<font class="flag">只 · 为 · 更 · 好</font></h2>
        </div>
    </div>

    <div class="section page darker" id="page3">
      <div class="page-over-header text-center">
        <div class="slogan-top">Betterlife</div>
        <div class="title slogan-bottom">
          Action → Better
          <div>Just Do It</div>
        </div>
      </div>
      <div class="container content-head">
        <div class="container page-detail">
          <h2>最佳方案设计</h2>
          <i class="icon-quote-left"></i>
          <p style="display:block;" data-id="1">
            专用于移动APP的html5 UI界面，可发布成原生应用。<br>
            也可用于html5 web页面；可嵌入微信；手机端优先。<br>
            实现框架底层采用: <br>
                <span> - [ jQuery + Bootstrap3 Css Only ] </span>
                <span> - [ jQuery + PureCss ] </span>
                <span> - [ AngularJS + jQuery WeUI ] </span>
          </p>
          <p data-id="2">
            Html5开发生成Native原生应用[iOS,Andriod]<br>
                <span> - `AngularJS`</span>
                <span> [ Mobile Angular UI + jQuery WeUI ]</span>
                <span> - `Angular` </span>
                <span> [ Angular + Ionic ]</span>
                <span> - `React Native` </span>
          </p>
          <p data-id="3">
            专用于Web开发的html5自适应界面，可用于pc电脑端<br>
            也可嵌入原生应用；可嵌入微信；Pc Web端优先。<br>
            实现框架底层采用: <br>
                <span> - [ Jquery + Bootstrap3 ] </span>
                <span> - [ AngularJS + Semantic-UI ] </span>
                <span> - [ jQuery + Layui ] </span>
          </p>
          <i class="icon-quote-right"></i>
        </div>
        <div class="row">
          <div class="col-md-4 active" data-id="1">
            <div>
              <i class="fa fa-desktop" aria-hidden="true"></i>
              <span>Web自适应界面</span>
              <span>可用于PC端</span>
            </div>
          </div>
          <div class="col-md-4" data-id="2">
            <div>
              <i class="fa fa-weixin" aria-hidden="true"></i>
              <span>可嵌入微信</span>
              <span>PC Web端优先</span>
            </div>
          </div>
          <div class="col-md-4" data-id="3">
            <div>
              <i class="glyphicon glyphicon-phone" aria-hidden="true"></i>
              <span>手机原生应用</span>
              <span>内嵌html5页面</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="section page" id="page4">
        <div class="container section-container">
            <h2 class="title">四大前端框架 完美快速开发<font>四大前端框架始终坚持在技术创新中前行，引领行业重新定义前端开发时尚潮流</font></h2>
            <div class="content-box" id="page-four-framework">
                <div class="content-list">
                    <div class="content-list-bg">
                        <div class="content-num"><span class="content-num-digital" id="countE1">65</span> %</div>
                        <div class="content-list-txt-bg"></div>
                        <div class="content-list-txt">
                          jQuery是一个高效、精简、功能丰富的 JavaScript 工具库。它的语法设计使得许多操作变得容易，如操作文档对象、选择文档对象模型元素、创建动画效果、处理事件、以及开发Ajax程序。<br><br>
                          全球前10,000个访问最高的网站中有65%使用了jQuery，是目前最受欢迎的JavaScript库。
                        </div>
                        <img src="{$template_url}resources/images/beauty.jpg" onload="this.src='https://lorempixel.com/900/500?r=1';" onerror="this.src='{$template_url}resources/images/beauty.jpg';" alt="美图">
                        <div class="content-list-pop"></div>
                    </div>
                    <p>Jquery</p>
                </div>
                <div class="content-list">
                    <div class="content-list-bg">
                        <div class="content-num"><span class="content-num-digital" id="countE2">105,000</span> 次</div>
                        <div class="content-list-txt-bg"></div>
                        <div class="content-list-txt">
                          Bootstrap 是最受欢迎的 HTML、CSS 和 JS 框架，用于开发响应式布局、移动设备优先的 WEB 项目。<br><br>
                          GitHub上面被标记为“Starred”次数排名第二最多的项目。Starred次数超过105,000，而分支次数超过了47,000次。
                        </div>
                        <img src="{$template_url}resources/images/beauty.jpg" onload="this.src='https://lorempixel.com/900/500?r=2';" onerror="this.src='{$template_url}resources/images/beauty.jpg';" alt="美图">
                        <div class="content-list-pop"></div>
                    </div>
                    <p>Bootstrap</p>
                </div>
                <div class="content-list">
                    <div class="content-list-bg">
                        <div class="content-num"><span class="content-num-digital" id="countE3">56.3</span> k</div>
                        <div class="content-list-txt-bg"></div>
                        <div class="content-list-txt">
                          AngularJS是一款开源JavaScript库，由Google维护，用来协助单一页面应用程序运行的。它的目标是通过MVC模式（MVC）功能增强基于浏览器的应用，使开发和测试变得更加容易。<br><br>
                          Angular是用于构建移动应用和桌面Web应用的开发平台。一套框架，多种平台，同时适用手机与桌面。
                        </div>
                        <img src="{$template_url}resources/images/beauty.jpg" onload="this.src='https://lorempixel.com/900/500?r=3';" onerror="this.src='{$template_url}resources/images/beauty.jpg';" alt="美图">
                        <div class="content-list-pop"></div>
                    </div>
                    <p>Angular</p>
                </div>
                <div class="content-list">
                    <div class="content-list-bg">
                        <div class="content-num"><span class="content-num-digital" id="countE4">70,319</span> <i class="glyphicon glyphicon-star"></i></div>
                        <div class="content-list-txt-bg"></div>
                        <div class="content-list-txt">
                          React是一个为数据提供渲染为HTML视图的开源JavaScript库。React为程序员提供了一种子组件不能直接影响外层组件的模型，数据改变时对HTML文档的有效更新，和现代单页应用中组件之间干净的分离。<br><br>
                          React和React Native在GitHub上的加星数量是Facebook位列第二的开源项目。
                        </div>
                        <img src="{$template_url}resources/images/beauty.jpg" onload="this.src='https://lorempixel.com/900/500?r=4';" onerror="this.src='{$template_url}resources/images/beauty.jpg';" alt="美图">
                        <div class="content-list-pop"></div>
                    </div>
                    <p>React</p>
                </div>
            </div>
        </div>
    </div>

    {include file="$templateDir/layout/normal/footer.tpl"}

    <div class="footer-rainbow">
      <div class="col-xs-1" style="border:4px solid #d71335;"></div>
      <div class="col-xs-1" style="border:4px solid #bc3768;"></div>
      <div class="col-xs-1" style="border:4px solid #f7366a;"></div>
      <div class="col-xs-1" style="border:4px solid #fa7533;"></div>
      <div class="col-xs-1" style="border:4px solid #ffba4e;"></div>
      <div class="col-xs-1" style="border:4px solid #4ec1c3;"></div>
      <div class="col-xs-1" style="border:4px solid #3aa9a8;"></div>
      <div class="col-xs-1" style="border:4px solid #9cd152;"></div>
      <div class="col-xs-1" style="border:4px solid #4ec1c3;"></div>
      <div class="col-xs-1" style="border:4px solid #cdf193;"></div>
      <div class="col-xs-1" style="border:4px solid #70cb79;"></div>
      <div class="col-xs-1" style="border:4px solid #3abc4d;"></div>
    </div>
  </div>

  <script src="{$template_url}js/common/bower/index.bower.min.js"></script>
  <script src="{$template_url}js/index.js"></script>
{/block}
