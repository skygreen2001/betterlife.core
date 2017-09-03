$(function(){
    $("#image-model").html($.templates("#imgModalTmpl"));

    //Datatables中文网[帮助]: http://datatables.club/
    if ($.dataTable) {
        var infoTable = $('#infoTable').DataTable({
            "language"  : $.dataTable.chinese,
            "processing": true,
            "serverSide": true,
            "retrieve"  : true,
            "ajax": {
                "url" : "api/web/blog.php",
                "data": function ( d ) {
                    d.query    = $("#input-search").val();
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
                { data:"blog_name" },
                { data:"user_name" },
                { data:"icon_url" },
                { data:"status" },
                { data:"updateTime"},
                { data:"user_id" }
            ],
            "columnDefs": [
                {"orderable": false, "targets": 2,
                 "render"   : function(data, type, row) {
                    var data = {
                        "img_id"  : "imgUrl"+row.id,
                        "img_src" : data,
                        "img_name": row.blog_name
                    };
                    var result = $.templates("#imgTmpl").render(data);

                    $("body").off('click', 'a#imgUrl'+row.id);
                    $("body").on('click', 'a#imgUrl'+row.id, function(){
                        $('#imagePreview').attr('src', $('a#imgUrl' + row.id + " img").attr('src'));
                        $('#imagePreview-link').attr('href', $('a#imgUrl' + row.id + " img").attr('src'));
                        $('#imageModal').modal('show');
                    });
                    return result;
                 }
                },
                {"orderable": false, "targets": 3,
                 "render"   : function(data,type,row){
                    if ( data == 0 ){
                        return '<span class="status-fail">待审核</span>';
                    } else if ( data == 1 ) {
                        return '<span class="status-pass">正常</span>';
                    } else {
                        return '<span class="status-wait">已结束</span>';
                    }
                 }
                },
                {"orderable": false, "targets": 5,
                 "render"   : function(data, type, row){
                    var result = $.templates("#actionTmpl").render({ "id"  : data });

                    $("body").off('click', 'a#info-view'+data);
                    $("body").on('click', 'a#info-view'+data, function(){//查看
                        bootbox.confirm("确定要查看该博客:" + data + "?",function(result){
                            if ( result == true ){
                                console.log("查看博客:" + data);
                            }
                        });
                    });
                    $("a#info-edit"+data).click(function(){
                        var pageNo = $_.params("pageNo");
                        if (!pageNo ) pageNo = 1;
                        location.href = 'index.php?go=admin.blog.edit&id='+data+'&pageNo='+pageNo;
                    });


                    $("body").off('click', 'a#info-dele'+data);
                    $("body").on('click', 'a#info-dele'+data, function(){//删除
                        bootbox.confirm("确定要删除该博客:" + data + "?",function(result){
                            if ( result == true ){
                                console.log("删除博客:" + data);
                            }
                        });
                    });
                    return result;
                }
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

    if( $(".content-wrapper form").length ){
        $.edit.fileBrowser("#iconImage", "#iconImageTxt", "#iconImageDiv");
        $.edit.datetimePicker('#creationTime');
        $.edit.multiselect('#categoryIds');

        $("input[name='isPublic']").bootstrapSwitch();

        $('input[name="isPublic"]').on('switchChange.bootstrapSwitch', function(event, state) {
            console.log(state);
        });

        var default_keyword_id   = 6;
        var default_keyword_text = "音乐";
        $.edit.select2("select[name='keyword_id']", "../../data/keyword.json", default_keyword_id, default_keyword_text);

        $('#editBlogForm').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            // focusInvalid: false,
            focusInvalid: true,
            // debug:true,
            rules: {
                title:{
                    required:true
                },
                content:{
                    required:true
                },
                authorName:{
                    required:true
                },
                sequenceNo: {
                    required:true,
                    number:true,
                },
                authorUrl:{
                    url:true
                }
            },
            messages: {
                title:"此项为必填项",
                content:"此项为必填项",
                authorName:"此项为必填项",
                sequenceNo:{
                    required:"此项为必填项",
                    number:"此项必须为数字"
                },
                authorUrl:{
                    url:"必须输入正确格式的网址"
                }
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
            },
            invalidHandler: function (form) {
            }
        });
    }
});
