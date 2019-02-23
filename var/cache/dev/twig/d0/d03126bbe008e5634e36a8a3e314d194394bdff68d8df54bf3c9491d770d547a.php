<?php

/* @Auth/Login/index.html.twig */
class __TwigTemplate_aa1e5c61d667a87c1caa0751e50daeb8ea4cf956d24a9745704044ddc5715feb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "@Auth/Login/index.html.twig", 1);
        $this->blocks = array(
            'css' => array($this, 'block_css'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Auth/Login/index.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Auth/Login/index.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 2
    public function block_css($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "css"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "css"));

        // line 3
        echo "    <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("xadmin/css/font.css"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("xadmin/css/xadmin.css"), "html", null, true);
        echo "\">
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 6
    public function block_body($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 7
        echo "    <body class=\"login-bg\">
        <div class=\"login layui-anim layui-anim-up\">
            <div class=\"message\">x-admin2.0-管理登录</div>
            <div id=\"darkbannerwrap\"></div>

            <form method=\"post\" class=\"layui-form\" >
                <input name=\"username\" placeholder=\"用户名\"  type=\"text\" lay-verify=\"required\" class=\"layui-input\" >
                ";
        // line 15
        echo "                <input name=\"password\" lay-verify=\"required\" placeholder=\"密码\"  type=\"password\" class=\"layui-input\">
                ";
        // line 17
        echo "                <input value=\"登录\" lay-submit lay-filter=\"login\" style=\"width:100%;\" type=\"submit\">
                ";
        // line 19
        echo "            </form>
        </div>
    </body>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 23
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 24
        echo "    <script type=\"text/javascript\" src=\"https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js\"></script>
    <script src=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("xadmin/lib/layui/layui.js"), "html", null, true);
        echo "\" charset=\"utf-8\"></script>
    <script type=\"text/javascript\" src=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("xadmin/js/xadmin.js"), "html", null, true);
        echo "\"></script>
    <script>
        \$(function  () {
            layui.use('form', function(){
                var form = layui.form;
                // layer.msg('玩命卖萌中', function(){
                //   //关闭后的操作
                //   });
                //监听提交
                form.on('submit(login)', function(data){
                    // alert(888)
                    layer.msg(JSON.stringify(data.field),function(){
                        location.href='index.html'
                    });
                    return false;
                });
            });
        })


    </script>
    <!-- 底部结束 -->
    <script>
        //百度统计可去掉
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement(\"script\");
            hm.src = \"https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190\";
            var s = document.getElementsByTagName(\"script\")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@Auth/Login/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  121 => 26,  117 => 25,  114 => 24,  105 => 23,  92 => 19,  89 => 17,  86 => 15,  77 => 7,  68 => 6,  56 => 4,  51 => 3,  42 => 2,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends 'base.html.twig' %}
{% block css %}
    <link rel=\"stylesheet\" href=\"{{ asset('xadmin/css/font.css') }}\">
    <link rel=\"stylesheet\" href=\"{{ asset('xadmin/css/xadmin.css') }}\">
{% endblock %}
{% block body %}
    <body class=\"login-bg\">
        <div class=\"login layui-anim layui-anim-up\">
            <div class=\"message\">x-admin2.0-管理登录</div>
            <div id=\"darkbannerwrap\"></div>

            <form method=\"post\" class=\"layui-form\" >
                <input name=\"username\" placeholder=\"用户名\"  type=\"text\" lay-verify=\"required\" class=\"layui-input\" >
                {#<hr class=\"hr15\">#}
                <input name=\"password\" lay-verify=\"required\" placeholder=\"密码\"  type=\"password\" class=\"layui-input\">
                {#<hr class=\"hr15\">#}
                <input value=\"登录\" lay-submit lay-filter=\"login\" style=\"width:100%;\" type=\"submit\">
                {#<hr class=\"hr20\" >#}
            </form>
        </div>
    </body>
{% endblock %}
{% block javascripts %}
    <script type=\"text/javascript\" src=\"https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js\"></script>
    <script src=\"{{ asset('xadmin/lib/layui/layui.js') }}\" charset=\"utf-8\"></script>
    <script type=\"text/javascript\" src=\"{{ asset('xadmin/js/xadmin.js') }}\"></script>
    <script>
        \$(function  () {
            layui.use('form', function(){
                var form = layui.form;
                // layer.msg('玩命卖萌中', function(){
                //   //关闭后的操作
                //   });
                //监听提交
                form.on('submit(login)', function(data){
                    // alert(888)
                    layer.msg(JSON.stringify(data.field),function(){
                        location.href='index.html'
                    });
                    return false;
                });
            });
        })


    </script>
    <!-- 底部结束 -->
    <script>
        //百度统计可去掉
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement(\"script\");
            hm.src = \"https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190\";
            var s = document.getElementsByTagName(\"script\")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
{% endblock %}", "@Auth/Login/index.html.twig", "/var/www/html/Dream_Origin/src/AuthBundle/Resources/views/Login/index.html.twig");
    }
}
