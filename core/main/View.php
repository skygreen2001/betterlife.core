<?php
/**
 +--------------------------------------------------<br/>
 * View Egine<br/>
 * 用于Template Engine<br/>
 * 方便开发者在controller里通过$this->view->set(varname, value)控制<br/>
 * 以便在显示层页面里任意访问使用变量varname<br/>
 +--------------------------------------------------<br/>
 * @category betterlife
 * @package core.main
 * @author skygreen
 */
class View {
    /**
     * 显示层文件所在目录名称
     */
    const VIEW_DIR_VIEW = "view";
    /**
     * 模板模式
     */
    const TEMPLATE_MODE_NONE        = 0;
    const TEMPLATE_MODE_SMARTY      = 1;
    const TEMPLATE_MODE_TWIG        = 2;
    const TEMPLATE_MODE_PHPTEMPLATE = 3;

    /**
     * 变量
     * @var array||object
     */
    private $vars = array();
    /**
     * 显示页面上使用的变量存储对象
     * 目前需模版是
     *     Smarty:TEMPLATE_MODE_SMARTY
     */
    private $viewObject;
    /**
     * 访问应用名
     * @var string
     */
    private $moduleName;
    private $template;//模板
    private $templateMode;//模板模式
    /**
     * @var string 模板规范要求所在的目录
     */
    private $template_dir;
    /**
     * @var string 模板文件规范要求的文件后缀名称
     */
    private $template_suffix_name;

    /**
     * @param array 显示层需要使用的全局变量
     */
    protected static $view_global=array();
    private function init_view_global(){
        self::$view_global = array(
            "isDev"         => Gc::$dev_debug_on,
            "url_base"      => Gc::$url_base,
            "site_name"     => Gc::$site_name,
            "appName"       => Gc::$appName,
            "template_url"  => $this->template_url_dir(),
            "upload_url"    => Gc::$upload_url,
            "uploadImg_url" => Gc::$upload_url . "images/",
            "templateDir"   => Gc::$nav_root_path . $this->getTemplate_View_Dir($this->moduleName),
            "encoding"      => Gc::$encoding
        );

        if ( contains( $_SERVER['HTTP_HOST'], array("127.0.0.1", "localhost", "192.168.") ) ) {
            self::$view_global["isDev"] = true;
        }
    }
    /**
    * @param mixed $moduleName 访问应用名
    * @param mixed $templatefile 模板文件
    * @return View
    */
    public function __construct($moduleName, $templatefile = null) {
        $this->moduleName = $moduleName;
        self::init_view_global();
        if ( isset(Gc::$template_mode_every) && array_key_exists($this->moduleName, Gc::$template_mode_every) ) {
            $this->initTemplate(Gc::$template_mode_every[$this->moduleName], $templatefile);
        } else {
            $this->initTemplate(Gc::$template_mode, $templatefile);
        }
        if ( !empty(self::$view_global) ) {
            foreach (self::$view_global as $key => $value) {
                $this->template_set($key, $value);
                if ( is_array($this->vars) ) {
                    $this->vars[$key] = $value;
                } else {
                    $this->vars->$key = $value;
                }
            }
        }
    }

    public function set($key, $value, $template_mode = null) {
        $this->template_set($key, $value, $template_mode);
    }

    public function get($key) {
        if ( is_array($this->vars) ) {
            return $this->vars[$key];
        } else {
            return $this->vars->$key;
        }

    }

    /***********************************魔术方法**************************************************/
    /**
     * 说明：若每个具体的实现类希望不想实现set,get方法；
     *      则将该方法复制到每个具体继承他的对象类内。
     * 可设定对象未定义的成员变量[但不建议这样做]
     * 可无需定义get方法和set方法
     * 类定义变量访问权限设定需要是pulbic
     * @param <type> $property
     */
    public function __call($method, $arguments) {
        if ( UtilString::contain( $method, "set" ) ) {
            $property = substr($method, strlen("set"), strlen($method));
            $property = lcfirst($property);
            if ( property_exists($this, $property) ) {
                $this->$property = $arguments[0];
            } else {
                $this->set($property, $arguments[0]);
            }
        } else if ( UtilString::contain($method,"get") ) {
            $property = substr($method, strlen("get"), strlen($method));
            $property = lcfirst($property);
            if ( is_array($this->vars) ) {
                return $this->vars[$property];
            } else if ( is_object($this->vars) ) {
                return $this->vars->$property;
            }
        }
    }

    public function __set($property, $value) {
        if ( property_exists($this, $property) ) {
            if ( ( !empty($property) ) && ( $property=='viewObject' ) &&
                !empty($this->viewObject->js_ready) && array_key_exists('js_ready',$value) ) {
               $value->js_ready = $this->viewObject->js_ready . $value->js_ready;
            }
            if ( ( !empty($property) ) && ( $property=='viewObject' )&&
                !empty($this->viewObject->css_ready) && array_key_exists('css_ready', $value) ) {
               $value->css_ready = $this->viewObject->css_ready . $value->css_ready;
            }
            $this->$property = $value;
        } else {
            $this->set($property, $value);
        }
    }

    public function __get($property) {
        if ( property_exists($this, $property) ) {
            return $this->$property;
        } else {
            if ( is_array($this->vars) ) {
                return $this->vars[$property];
            } else {
                return $this->vars->$property;
            }
        }
    }

    public function getVars() {
        return $this->vars;
    }

    /**
     * 获取模板
     * @return <type> huoqu
     */
    public function template() {
        return $this->template;
    }

    /**
     * 获取当前模板模式
     */
    public function templateMode() {
        return $this->templateMode;
    }

    /**
     * @return string 模板文件所在的目录
     */
    public function template_dir() {
        return $this->template_dir;
    }

    /**
     * @return string 模板文件所在的目录
     */
    public function template_url_dir(){
        return @Gc::$url_base . str_replace("\\","/",$this->getTemplate_View_Dir());
    }

    /**
     * @return string 模板文件的文件后缀名称
     */
    public function template_suffix_name() {
        return $this->template_suffix_name;
    }

    /**
     * 当在同一种网站里使用多个模板的时候
     * 通过本函数进行指定
     */
    public function setTemplate($template_mode, $moduleName, $templatefile = null) {
        $this->moduleName = $moduleName;
        if ( empty($template_mode) ) {
            $template_mode = Gc::$template_mode;
        }
        $this->initTemplate( $template_mode, $templatefile = null );
    }

    /**
    * 获取模板文件完整的路径
    *
    */
    private function getTemplate_View_Dir(){
        $result = "";
        if ( strlen(Gc::$module_root) > 0 ) {
            $result .= Gc::$module_root . DS;
        }
        $result .= $this->moduleName . DS . self::VIEW_DIR_VIEW . DS;
        if ( isset(Gc::$self_theme_dir_every) && array_key_exists($this->moduleName, Gc::$self_theme_dir_every) ) {
            $result .= Gc::$self_theme_dir_every[$this->moduleName] . DS;
        } else {
            $result .= Gc::$self_theme_dir . DS;
        }
        return $result;
    }

    /**
     * 初始化模板文件
     * @var string $template_mode 模板模式
     */
    private function initTemplate($template_mode, $templatefile = null) {
        if ( empty($template_mode) ) {
            $template_mode = Gc::$template_mode;
        }
        $this->template_dir = $this->getTemplate_View_Dir( $this->moduleName ) . Config_F::VIEW_CORE . DS;
        $template_tmp_dir   = $this->getTemplate_View_Dir( $this->moduleName ) . "tmp" . DS;

        if ( isset(Gc::$template_file_suffix_every) && array_key_exists($this->moduleName, Gc::$template_file_suffix_every) ) {
            $this->template_suffix_name = Gc::$template_file_suffix_every[$this->moduleName];
        } else {
            $this->template_suffix_name = Gc::$template_file_suffix;
        }

        switch ($template_mode) {
            case self::TEMPLATE_MODE_SMARTY:
                $this->templateMode = self::TEMPLATE_MODE_SMARTY;
                if ( !class_exists("Smarty") ) {
                  die("<p style='font: 15px/1.5em Arial;margin:15px;line-height:2em;'>没有安装Smarty,请通知管理员在服务器上按: install/README.md  文件中说明执行。<br/></p>");
                }
                $this->template = new Smarty();
                if ( Smarty::SMARTY_VERSION >= 3.1 && class_exists("SmartyBC") ) {
                    $this->template = new SmartyBC();
                }
                $this->template->template_dir  = Gc::$nav_root_path . $this->template_dir;
                $this->template->compile_dir   = Gc::$nav_root_path . $template_tmp_dir . "templates_c" . DS;
                $this->template->config_dir    = $template_tmp_dir . "configs" . DS;
                $this->template->cache_dir     = $template_tmp_dir . "cache" . DS;
                $this->template->compile_check = true;
                $this->template->allow_php_templates = true;
                // 开启自定义安全机制
                if ( class_exists("Smarty_Security") ){
                    $my_security_policy = new Smarty_Security($this->template);
                    $my_security_policy->secure_dir[] = Gc::$nav_root_path . $this->getTemplate_View_Dir($this->moduleName);
                    $my_security_policy->allow_php_tag = true;
                    $my_security_policy->php_functions = array();
                    $my_security_policy->php_handling = Smarty::PHP_PASSTHRU;
                    $my_security_policy->php_modifier = array();
                    $my_security_policy->modifiers = array();
                    $this->template->enableSecurity($my_security_policy);
                }

                // $my_security_policy = new Smarty_Security($this->template);
                // $my_security_policy->allow_php_tag = true;
                // $this->template->enableSecurity($my_security_policy);
                $this->template->debugging = Gc::$dev_smarty_on;
                $this->template->force_compile = false;
                $this->template->caching = Gc::$is_online_optimize;
                $this->template->cache_lifetime = 86400;//缓存一周
                UtilFileSystem::createDir($this->template->compile_dir);
                system_dir_info($this->template->compile_dir);
                break;
            case self::TEMPLATE_MODE_TWIG:
                $this->templateMode = self::TEMPLATE_MODE_TWIG;
                $this->template->template_dir = Gc::$nav_root_path . $this->template_dir;
                $this->template->cache_dir = $template_tmp_dir . "cache" . DS;
                UtilFileSystem::createDir($this->template->cache_dir);
                system_dir_info($this->template->cache_dir);
                $twig_loader = new \Twig\Loader\FilesystemLoader(dirname($this->template->template_dir));
                $this->template = new \Twig\Environment($twig_loader, [
                    'cache' => $this->template->cache_dir,
                ]);
                $this->template->template_dir = Gc::$nav_root_path . $this->template_dir;
                $this->template->temp_dir = $template_tmp_dir . "temp" . DS;
                $this->template->cache_dir = $template_tmp_dir . "cache" . DS;
                break;
            case self::TEMPLATE_MODE_PHPTEMPLATE:
                $this->templateMode = self::TEMPLATE_MODE_PHPTEMPLATE;
                $this->template = new template($tpl_set);
                break;
            default:
                $this->templateMode = self::TEMPLATE_MODE_NONE;
                break;
        }
    }

    /**
     * 设置模板认知的变量
     */
    public function template_set($key, $value, $template_mode = null) {
        if ( empty($template_mode) ) {
            if ( isset(Gc::$template_mode_every) && array_key_exists($this->moduleName, Gc::$template_mode_every) ) {
                $template_mode = Gc::$template_mode_every[$this->moduleName];
            } else {
                $template_mode = Gc::$template_mode;
            }
        }
        switch ($template_mode) {
            case self::TEMPLATE_MODE_NONE:
                break;
            case self::TEMPLATE_MODE_TWIG:
                break;
            case self::TEMPLATE_MODE_SMARTY:
            case self::TEMPLATE_MODE_PHPTEMPLATE:
                $this->template->assign($key, $value);
                break;
        }
        if ( is_array($this->vars) ) {
            $this->vars[$key] = $value;
        } else if ( is_object($this->vars) ) {
            $this->vars->$key = $value;
        }
    }

    /**
     * 渲染输出
     * @param string $templatefile 模板文件名
     */
    public function output($templatefile, $template_mode, $controller = null) {
        if ( empty($template_mode) ) {
            $template_mode = Gc::$template_mode;
        }
        $templateFilePath = $templatefile . $this->template_suffix_name;
        switch ($template_mode) {
            case self::TEMPLATE_MODE_SMARTY:
                if ( !empty($this->viewObject) ) {
                  $view_array = UtilObject::object_to_array( $this->viewObject, $this->vars );
                  foreach ($view_array as $key => $value) {
                    if ( !array_key_exists($key, self::$view_global) ) {
                      $this->set( $key, $value );
                    }
                  }
                } else {
                    $this->viewObject = new ViewObject();
                }
                $name_viewObject = ViewObject::get_Class();
                $name_viewObject = lcfirst($name_viewObject);
                $this->template->assignByRef($name_viewObject, $this->viewObject);
                $this->template->display($templateFilePath);
                break;
            case self::TEMPLATE_MODE_TWIG:
                if ( !empty($this->viewObject) ) {
                  $view_array = UtilObject::object_to_array( $this->viewObject, $this->vars );
                  foreach ($view_array as $key => $value) {
                    if ( !array_key_exists($key, self::$view_global) ) {
                      $this->set($key, $value);
                    }
                  }
                  $name_viewObject = ViewObject::get_Class();
                  $name_viewObject = lcfirst($name_viewObject);
                  $this->set($name_viewObject, $this->viewObject);
                  // print_r($this->viewObject);
                }
                $tplFilePath = Config_F::VIEW_CORE . DS . $templateFilePath;
                echo $this->template->render($tplFilePath, $this->vars);

                break;
            case self::TEMPLATE_MODE_PHPTEMPLATE:
                $filename_dir = explode(DS,$templateFilePath);
                if (!empty($sub_dir)) {
                    $filename_dir = $sub_dir[0];
                }
                $this->template->set_file(basename($filename_dir[1], $this->template_suffix_name), $filename_dir[0]);
                break;
            default:
                $viewvars = $this->getVars();
                extract($viewvars);
                include_once(Gc::$nav_root_path . $this->template_dir() . $templateFilePath);
                break;
        }
    }
}
