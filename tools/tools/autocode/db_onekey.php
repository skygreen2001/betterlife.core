<?php
require_once ("../../../init.php");
if(Config_AutoCode::AFTER_MODEL_CONVERT_ADMIN){
    if(isset($_REQUEST["model_save_dir"])&&!empty($_REQUEST["model_save_dir"])){
        if(isset($_REQUEST["model_save_dir"])&&!empty($_REQUEST["model_save_dir"]))
            $model_save_dir=$_REQUEST["model_save_dir"];
        $overwrite=array();

        if(isset($_REQUEST["overwritedomain"])&&!empty($_REQUEST["overwritedomain"]))$overwrite=array_merge($overwrite,$_REQUEST["overwritedomain"]);
        if(isset($_REQUEST["overwritefront"])&&!empty($_REQUEST["overwritefront"]))$overwrite=array_merge($overwrite,$_REQUEST["overwritefront"]);
        if(isset($_REQUEST["overwritemodel"])&&!empty($_REQUEST["overwritemodel"]))$overwrite=array_merge($overwrite,$_REQUEST["overwritemodel"]);

        if(count($overwrite)>0)AutoCodeModelLike::overwrite($overwrite,$model_save_dir);
        $_REQUEST["save_dir"]=$_REQUEST["model_save_dir"];
        AutoCodePreviewReportLike::$is_first_run=false;
    }

    AutoCodeModelLike::UserInput();
    if (isset($_REQUEST["save_dir"])&&!empty($_REQUEST["save_dir"]))
    {
        $save_dir=$_REQUEST["save_dir"];
        AutoCodeModelLike::$save_dir =$save_dir;

        $table_names=$_GET["table_names"];
        if(empty($table_names)){
            die("<div align='center'><font color='red'>至少选择一张表,请确认！</font></div>");
        }else{
            AutoCodeConfig::Decode();
            AutoCodeModelLike::$showReport="";
            AutoCodeModelLike::AutoCode($table_names);
        }

        if(Config_AutoCode::SHOW_PREVIEW_REPORT){
            echo "<div style='width: 1000px; margin-left: 110px;'>";
            echo "<span>&nbsp;&nbsp;&nbsp;&nbsp;</span><a href='javascript:' style='cursor:pointer;' onclick=\"(document.getElementById('showPrepareWork').style.display=(document.getElementById('showPrepareWork').style.display=='none')?'':'none')\">预备工作</a>";
            echo"<div id='showPrepareWork' style='display: none;'>";
            echo AutoCodeModelLike::$showPreviewReport;
            echo "</div>";
            echo "<p style='height:20px;text-align:right;'><span style='float:left'>&nbsp;&nbsp;<a style='margin-left:15px;' href='javascript:' style='cursor:pointer;' onclick=\"(document.getElementById('showReport').style.display=(document.getElementById('showReport').style.display=='none')?'':'none')\">显示报告</a></span></p>";
            echo "<div id='showReport' style='display: none;'>";
            echo AutoCodeModelLike::$showReport;
            echo "</div>";
            echo "</div>";
        }
        AutoCodePreviewReportLike::init();
        $showReport=AutoCodePreviewReportLike::showReport($table_names);
        echo $showReport;
    }
} else {
    if(isset($_REQUEST["model_save_dir"])&&!empty($_REQUEST["model_save_dir"])){
        if(isset($_REQUEST["model_save_dir"])&&!empty($_REQUEST["model_save_dir"]))
            $model_save_dir=$_REQUEST["model_save_dir"];
        $overwrite=array();

        if(isset($_REQUEST["overwritedomain"])&&!empty($_REQUEST["overwritedomain"]))$overwrite=array_merge($overwrite,$_REQUEST["overwritedomain"]);
        if(isset($_REQUEST["overwritefront"])&&!empty($_REQUEST["overwritefront"]))$overwrite=array_merge($overwrite,$_REQUEST["overwritefront"]);
        if(isset($_REQUEST["overwritemodel"])&&!empty($_REQUEST["overwritemodel"]))$overwrite=array_merge($overwrite,$_REQUEST["overwritemodel"]);

        if(count($overwrite)>0)AutoCodeModel::overwrite($overwrite,$model_save_dir);
        $_REQUEST["save_dir"]=$_REQUEST["model_save_dir"];
        AutoCodePreviewReport::$is_first_run=false;
    }

    AutoCodeModel::UserInput();
    if (isset($_REQUEST["save_dir"])&&!empty($_REQUEST["save_dir"]))
    {
        $save_dir=$_REQUEST["save_dir"];
        AutoCodeModel::$save_dir =$save_dir;

        $table_names=$_GET["table_names"];
        if(empty($table_names)){
            die("<div align='center'><font color='red'>至少选择一张表,请确认！</font></div>");
        }else{
            AutoCodeConfig::Decode();
            AutoCodeModel::$showReport="";
            AutoCodeModel::AutoCode($table_names);
        }

        if(Config_AutoCode::SHOW_PREVIEW_REPORT){
            echo "<div style='width: 1000px; margin-left: 110px;'>";
            echo "<span>&nbsp;&nbsp;&nbsp;&nbsp;</span><a href='javascript:' style='margin-left: 5%;cursor:pointer;' onclick=\"(document.getElementById('showPrepareWork').style.display=(document.getElementById('showPrepareWork').style.display=='none')?'':'none')\">预备工作</a>";
            echo "<div id='showPrepareWork' style='display: none;'>";
            echo AutoCodeModel::$showPreviewReport;
            echo "</div>";
            echo "<p style='margin-left: 6%;padding-left:5px;height:20px;text-align:right;'><span style='float:left'>&nbsp;&nbsp;<a style='margin-left:15px;' href='javascript:' style='cursor:pointer;' onclick=\"(document.getElementById('showReport').style.display=(document.getElementById('showReport').style.display=='none')?'':'none')\">显示报告</a></span></p>";
            echo "<div id='showReport' style='display: none;margin-left: 11%;'>";
            echo AutoCodeModel::$showReport;
            echo "</div>";
            echo "</div>";
        }
        AutoCodePreviewReport::init();
        $showReport=AutoCodePreviewReport::showReport($table_names);
        echo $showReport;
    }
}