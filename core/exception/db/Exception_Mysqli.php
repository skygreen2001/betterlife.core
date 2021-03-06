<?php
/**
 +----------------------------------------<br/>
 * MysqlI异常处理类<br/>
 +----------------------------------------<br/>
 * @category betterlife
 * @package core.exception.db
 * @author zhouyuepu
 */
class Exception_Mysqli extends Exception_Db
{
    /**
     * MysqlI 异常记录：记录Myql的异常信息
     * @param string $extra  补充存在多余调试信息
     * @param string $category 异常分类
     */
    public static function record($extra = null, $category = null, $link = null)
    {
        if ( $link == null ) {
            if ( mysqli_connect_errno() ) {
                $category = Exception_Db::CATEGORY_MYSQL;
                LogMe::log( "连接数据库失败:" . mysqli_connect_error(), EnumLogLevel::ERR );
                self::recordException("连接数据库失败:".mysqli_connect_error(), $category,mysqli_connect_errno(),$extra);
            }else{
                $link = Manager_Db::newInstance()->currentdao()->getConnection();
            }
        }
        if ( $link && is_object($link) && $link->error ) {
            if ( !isset($category) ) {
                $category = Exception_Db::CATEGORY_MYSQL;
            }
            $errorinfo = $link->error;
            LogMe::log( "Error Info:" . $errorinfo, EnumLogLevel::ERR );
            self::recordException( $errorinfo, $category, $link->errno, $extra );
        }
    }

}
?>
