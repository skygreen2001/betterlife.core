{extends file="$templateDir/layout/normal/layout.tpl"}
{block name=body}

    <div class="page-container">
        <div class="page-content">
            {include file="$templateDir/layout/normal/sidebar.tpl"}
            <div class="content-wrapper">
                <div class="main-content">
                    <!-- page header begin -->
                    <div class="row">
                      <div class="breadcrumb-line">
                        <ul class="breadcrumb">
                          <li><a href="/"><i class="icon-home2 position-left"></i> 首页</a></li>
                          <li class="active">控制台</li>
                        </ul>
                      </div>
                    </div>
                    <!-- /page header end -->

                    <div class="container-fluid home">
                      <div class="row col-xs-12">
                        <section class="section container-fluid">
                          <h1 class="page-header">Betterlife</h1>
                          <h2>👌 后台管理，责无旁贷</h2>
                          <h3><a href="https://github.com/skygreen2001/betterlife.core" target="_blank">进一步了解 > </a></h3>
                        </section>
                      </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    {include file="$templateDir/layout/normal/footer.tpl"}
    <script type="text/javascript" src="{$template_url}js/normal/layout.js"></script>

    <script type="text/javascript">
      $(function(){
        var offset = $(window).height() - $(".navbar-container").height() - $(".breadcrumb-line").height() -$("footer").height();
        $(".home .container-fluid").css("height", offset);
      });
    </script>
{/block}
