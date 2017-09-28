<?php
$js_template = <<<JS
$(function(){
    //Datatables中文网[帮助]: http://datatables.club/
    if ($.dataTable) {
        var infoTable = $('#infoTable').DataTable({
            "language"  : $.dataTable.chinese,
            "processing": true,
            "serverSide": true,
            "retrieve"  : true,
            "ajax": {
                "url" : "api/web/{$instancename}.php",
                "data": function ( d ) {
                    d.query    = \$("#input-search").val();
                    d.pageSize = d.length;
                    d.page     = d.start / d.length + 1;
                    d.limit    = d.start + d.length;
                    return d;
                },
                //可以对返回的结果进行改写
                "dataFilter": function(data){
                    return data;
                }
            },
            "responsive"   : true,
            "searching"    : false,
            "ordering"     : false,
            "dom"          : '<"top">rt<"bottom"ilp><"clear">',
            "deferRender"  : true,
            "bStateSave"   : true,
            "bLengthChange": true,
            "aLengthMenu"  : [[10, 25, 50, 100,-1],[10, 25, 50, 100,'全部']],
            "columns": [
$column_contents
            ],
            "columnDefs": [
$imgColumnDefs
$bitColumnDefs
$statusColumnDefs
$idColumnDefs
             }
            ],
            "initComplete":function(){
                $.dataTable.filterDisplay();
            },
            "drawCallback": function( settings ) {
                $.dataTable.pageNumDisplay(this);
                $.dataTable.filterDisplay();
            }
        });
        $.dataTable.doFilter(infoTable);
    }

    if( \$(".content-wrapper form").length ) {
$editImgColumn
$editEnumColumn
$editDateColumn
$editMulSelColumn
$editBitColumn
        $('#edit{$classname}Form').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            // focusInvalid: false,
            focusInvalid: true,
            // debug:true,
            rules: {
                $editValidRules
            },
            messages: {
                $editValidMsg
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                $('.alert-danger', $('.login-form')).show();
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error').addClass('has-info');
                $(e).remove();
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    }
});

JS;

$js_sub_template_img = <<<JS_IMG
                {"orderable": false, "targets": $row_no,
                 "render"   : function(data, type, row) {
                    // 该图片仅供测试
                    if ( data ) {
                        var $realId = row.$realId;
                        var result = '<a id="' + "imgUrl" + $realId + '" href="#"><img src="' + data + '" class="img-thumbnail" alt="' + row.$realId + '" /></a>';

                        \$("body").off('click', 'a#imgUrl' + $realId);
                        \$("body").on('click', 'a#imgUrl' + $realId, function(){
                            var imgLink = $('a#imgUrl' + $realId + " img").attr('src');
                            $('#imagePreview').attr('src', imgLink);
                            $('#imagePreview-link').attr('href', imgLink);
                            var isShow = $.dataTable.showImages($(this).find("img"), "#imageModal .modal-dialog");
                            if (isShow) $('#imageModal').modal('show'); else window.open(imgLink, '_blank');
                        });
                    }
                    return result;
                 }
                },

JS_IMG;

$js_sub_template_bit = <<<JS_BIT
                {"orderable": false, "targets": $row_no,
                 "render"   : function(data,type,row){
                    if ( data == 1 ) {
                        return '是';
                    } else {
                        return '否';
                    }
                 }
                },

JS_BIT;

$js_sub_template_status = <<<JS_STATUS
                {"orderable": false, "targets": $row_no,
                 "render"   : function(data, type, row){
                    switch (data) {
$status_switch_show
                      default:
                        return '';
                    }
                 }
                },
JS_STATUS;

$js_sub_template_id = <<<JS_ID
                {"orderable": false, "targets": $row_no,
                 "render"   : function(data, type, row){
                    var result = \$.templates("#actionTmpl").render({ "id"  : data });

                    \$("a#info-view"+data).click(function(){
                        var pageNo = \$_.params("pageNo");
                        if (!pageNo ) pageNo = 1;
                        location.href = 'index.php?go={$appname}.{$instancename}.view&id=' + data + '&pageNo=' + pageNo;
                    });

                    \$("a#info-edit"+data).click(function(){
                        var pageNo = \$_.params("pageNo");
                        if (!pageNo ) pageNo = 1;
                        location.href = 'index.php?go={$appname}.{$instancename}.edit&id=' + data + '&pageNo=' + pageNo;
                    });

                    \$("body").off('click', 'a#info-dele' + data);
                    \$("body").on('click', 'a#info-dele' + data, function(){//删除
                        bootbox.confirm("确定要删除该博客:" + data + "?",function(result){
                            if ( result == true ){
                                \$.get("index.php?go={$appname}.{$instancename}.delete&id="+data, function(response, status){
                                    \$( 'a#info-dele' + data ).parent().parent().css("display", "none");
                                });
                            }
                        });
                    });

                    return result;
                }
JS_ID;

$list_template = <<<LIST_TPL

    <div class="page-container">
        <div class="page-content">
            {include file="\$templateDir/layout/normal/sidebar.tpl"}
            <div class="content-wrapper">
              <div class="main-content">
                <div class="row">
                  <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                      <li><a href="{\$url_base}index.php?go={$appname}.index.index"><i class="icon-home2 position-left"></i> 首页</a></li>
                      <li class="active">{$table_comment}</li>
                    </ul>
                  </div>
                </div>

                <div class="container-fluid list">
                    <div class="row">
                        <a class="btn btn-success" href="{\$url_base}index.php?go={$appname}.{$instancename}.edit">新增{$table_comment}</a>
                    </div><br/>
                    <div class="row up-container">
                        <div class="filter-up">
                            <div class="filter-up-right col-sm-12">
                                <div>
                                    <i aria-label="search-menu" class="glyphicon glyphicon-search" aria-hidden="true"></i>
                                    <input id="input-search" type="search" placeholder="搜索名称" aria-controls="infoTable" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row table-responsive col-xs-12">
                        <table id="infoTable" class="display nowrap dataTable table table-striped table-bordered">
                            <thead>
                                <tr>
$column_contents
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    {include file="\$templateDir/layout/normal/footer.tpl"}
    <div id="image-model">
      <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">X</span></button>
            </div>
            <div class="modal-body">
              <a id="imagePreview-link" href="#" target="_blank"><img src="" id="imagePreview" /></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    {literal}
    <script id="actionTmpl" type="text/x-jsrender">
    <a id="info-view{{:id}}" href="#" class="btn-view">查看</a>
    <a id="info-edit{{:id}}" href="#" class="btn-edit">修改</a>
    <a id="info-dele{{:id}}" href="#" class="btn-dele" data-toggle="modal" data-target="#infoModal">删除</a>
    </script>
    {/literal}
    <script src="{\$template_url}js/normal/list.js"></script>
    <script src="{\$template_url}js/core/{$instancename}.js"></script>
LIST_TPL;

$view_template = <<<VIEW_TPL
    <!-- page container begin -->
    <div class="page-container">
        <!-- page content begin -->
        <div class="page-content">
            {include file="\$templateDir/layout/normal/sidebar.tpl"}

            <!-- main content begin -->
            <div class="content-wrapper">
              <div class="main-content">
                <!-- page header begin -->
                <div class="row">
                  <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                      <li><a href="{\$url_base}index.php?go={$appname}.index.index"><i class="icon-home2 position-left"></i> 首页</a></li>
                      <li><a href="{\$url_base}index.php?go={$appname}.{$instancename}.lists">{$table_comment}</a></li>
                      <li class="active">查看{$table_comment}</li>
                    </ul>
                  </div>
                </div>
                <!-- /page header end -->

                <!-- content area begin -->
                <div class="container-fluid view">
                  <div class="row col-xs-12">
                    <h2>博客详情</h2><hr>
                    <h4>
                      <span class="glyphicon glyphicon-list-alt"></span>
                      <span>基本信息</span>
                    </h4><hr>
                    <dl>
                      <dt><span>标识</span></dt>
                      <dd><span>{\${$instancename}.$realId}</span></dd>
                    </dl>
$showColumns
                    <h4>
                      <span class="glyphicon glyphicon-list-alt"></span>
                      <span>其他信息</span>
                    </h4><hr>
                    <dl>
                      <dt><span>标识</span></dt>
                      <dd><span>{\${$instancename}.$realId}</span></dd>
                    </dl>
                    <dl>
                      <dt><span>创建时间</span></dt>
                      <dd><span>{\${$instancename}.{$commitTimeStr}|date_format:"%Y-%m-%d %H:%M"}</span></dd>
                    </dl><dl>
                      <dt><span>更新时间</span></dt>
                      <dd><span>{\${$instancename}.{$updateTimeStr}|date_format:"%Y-%m-%d %H:%M"}</span></dd>
                    </dl>
                    <button type="submit" onclick="location.href='{\$url_base}index.php?go={$appname}.{$instancename}.lists&amp;pageNo={\$smarty.get.pageNo|default:1}'" class="btn btn-info">
                      <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;<span>返回</span>
                    </button>
                    <button type="submit" onclick="location.href='{\$url_base}index.php?go={$appname}.{$instancename}.edit&amp;id={\$smarty.get.id}&amp;pageNo={\$smarty.get.pageNo|default:1}'" class="btn btn-info">
                      <span class="glyphicon glyphicon-pencil"></span>&nbsp;<span>编辑</span>
                    </button>
                  </div>
                </div>

                <!-- /content area end -->
              </div>
            </div>
            <!-- /main content end -->

            <div class="clearfix"></div>
        </div>
        <!-- /page content end -->
    </div>
    <!-- /page container end -->

    {include file="\$templateDir/layout/normal/footer.tpl"}
VIEW_TPL;

$edit_template = <<<EDIT_TPL

    <!-- page container begin -->
    <div class="page-container">
        <!-- page content begin -->
        <div class="page-content">
            {include file="\$templateDir/layout/normal/sidebar.tpl"}

            <!-- main content begin -->
            <div class="content-wrapper">
              <div class="main-content">
                <!-- page header begin -->
                <div class="row">
                  <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                      <li><a href="{\$url_base}index.php?go={$appname}.index.index"><i class="icon-home2 position-left"></i> 首页</a></li>
                      <li><a href="{\$url_base}index.php?go={$appname}.{$instancename}.lists">{$table_comment}</a></li>
                      <li class="active">编辑{$table_comment}</li>
                    </ul>
                  </div>
                </div>
                <!-- /page header end -->

                <!-- content area begin -->
                <div class="container-fluid edit">
                  <div class="row col-xs-12">
                      <form id="edit{$classname}Form" class="form-horizontal" action="#" method="post" $hasImgFormFlag>
                      {if \$message}
                      <div class="form-group">
                        <label class="col-sm-2 control-label error-msg">错误信息</label>
                        <div class="col-sm-9 edit-view error-msg">{\$message}</div>
                      </div>
                      {/if}
                      {if \${$instancename}}
                      <div class="form-group">
                        <label class="col-sm-2 control-label">标识</label>
                        <div class="col-sm-9 edit-view">{\${$instancename}.$realId}</div>
                      </div>
                      {/if}
$edit_contents
                      <div class="space-4"></div>
                      <input type="hidden" name="blog_id" value="{\{$instancename}.$realId}"/>
                      <div class="form-actions col-md-12">
                          <button type="submit" class="btn btn-success">确认</button>
                          <div  class="btn-group" role="group">
                            <button class="btn" type="reset"><i class="icon-undo bigger-110"></i>重置</button>
                          </div>
                      </div>
                      </form>
                    </div>
                </div>

                <!-- /content area end -->
              </div>
            </div>
            <!-- /main content end -->

            <div class="clearfix"></div>
        </div>
        <!-- /page content end -->
    </div>
    <!-- /page container end -->

    {include file="\$templateDir/layout/normal/footer.tpl"}

    <script src="{\$template_url}js/normal/edit.js"></script>
    <script src="{\$template_url}js/core/blog.js"></script>
$enumJsContent
$ueTextareacontents
EDIT_TPL;

$edit_sub_json_template = <<<EDIT_JSON
{
    "code": 1,
    "description": "",
    "data": [
$edit_json_enums
    ]
}
EDIT_JSON;
?>