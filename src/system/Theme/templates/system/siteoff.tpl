<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="<?php echo ZLanguage::getLanguageCode(); ?>" dir="<?php echo ZLanguage::getDirection(); ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo ZLanguage::getEncoding(); ?>" />
        <title><?php echo __('The site is currently off-line.'); ?></title>
        <base href="<?php echo pnGetBaseURL(); ?>" />
        <style type="text/css">
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
                font-family: Verdana, Arial, Helvetica, Sans-serif;
                font-size: 14px;
                background: #F2F2F2;
                background: -webkit-gradient(linear, left top, left bottom, from(#FAFAFA), to(#eaeaea) );
                background: -moz-linear-gradient(center top , #FAFAFA, #eaeaea) repeat scroll 0 0 transparent;
                background: linear-gradient(center top , #FAFAFA, #eaeaea) repeat scroll 0 0 transparent;
                line-height: 1.6em;
            }
            a {
                color: #2147B3;
                border: none;
            }
            img {
                border: none;
            }
            h1 {
                font-size:24px;
                line-height:28px;
            }
            h2 {
                color:#770000;
                font-size:22px;
                line-height:26px;
                text-transform:uppercase;
            }
            .container {
                display: table;
                height: 100%;
                width: 100%;
            }
            .cell {
                display: table-cell;
                vertical-align: middle;
                /* For IE6/7 */
                position: relative;
                top:expression(this.parentNode.clientHeight/2 - this.firstChild.clientHeight/2 + " px");
            }
            .content {
                /* center horizontally */
                margin: 0 auto;
                width: 50%;
                padding: 1.5em;
                background: #fafafa;
                border: 1px solid #2147B3;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: #999 4px 4px 10px;
                -moz-box-shadow: #999 4px 4px 10px;
                box-shadow: #999 4px 4px 10px;
                text-align: center;
            }
            .showloginbutton {
                display: inline-block;
                padding: 15px 20px;
                color: #bed7e1;
                font-size: 12px;
                text-decoration: none;
                margin: 1em 0;
                border: 1px solid #A4C3EF;
                text-shadow: -1px -1px 0 rgba(0, 0, 0, 0.25);
                background: #2147B3;
                background: -webkit-gradient(linear, left top, left bottom, from(#7DA3DF), to(#2147B3) );
                background: -moz-linear-gradient(top, #7DA3DF, #2147B3);
                background: linear-gradient(top, #7DA3DF, #2147B3);
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
                -moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
            }
            a.showloginbutton:hover,
            a.showloginbutton:active {
                text-decoration: none;
                background: #3764DF;
                background: -webkit-gradient(linear, 0% 0, 0% 100%, from(#8FBAFF), to(#3764DF) );
                background: -moz-linear-gradient(-90deg, #8FBAFF, #3764DF);
                background: linear-gradient(-90deg, #8FBAFF, #3764DF);
            }
            .showloginbutton strong {
                display: block;
                color: #fff;
                font-size: 18px;
            }
            #login {
                text-align:left;
                visibility:hidden;
                border: 1px #ddd solid;
                margin: 0 0 1em 0;
                padding: 0.5em 1em;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 4px;
                background: #fafafa; /*non-CSS3 browsers*/
                background: -webkit-gradient(linear,left top, left bottom,from(#fafafa),to(#f2f2f2)); /*webkit*/
                background: -moz-linear-gradient(top,#fafafa,#f2f2f2); /*gecko*/
                background: linear-gradient(#fafafa, #f2f2f2); /*CSS3*/
            }
            #login .loginrow {
                clear:both;
                min-height:2em;
                padding:0.5em 0;
                font-size:14px;
                line-height:16px;
                font-weight:normal;
            }
            #login .loginrow label {
                float:left;
                margin:5px 0;
                padding:2px;
                text-align:right;
                width:40%;
            }
            #login .loginrow input {
                border:1px solid #DDDDDD;
                margin:5px 0 5px 1%;
                padding:2px;
                width:47%;
            }
            #login .logincheck {
                clear:both;
                margin:5px 0 5px 41%;
                padding:2px;
            }
            #login .loginbutton {
                margin:5px 0 5px 41%;
                padding:2px;
            }
        </style>

        <script type="text/javascript">
            <!--
            function toggleLoginBox()
            {
                document.getElementById('login').style.visibility = (document.getElementById('login').style.visibility == 'visible') ? 'hidden' : 'visible';
            }
            // -->
        </script>

    </head>
    <body>

        <div class="container">
            <div class="cell">
                <div class="content">
                    <h1><?php echo __('The site is currently off-line.'); ?></h1>
                    <h2><?php echo (System::VERSION_NUM != System::getVar('Version_Num')) ? __('This site needs to be upgraded, please contact the system administrator.') : System::getVar('siteoffreason');?></h2>
                    <p>
                        <a href="#" class="showloginbutton" onclick="toggleLoginBox();" title="<?php echo __('Administrator log-in'); ?>">
                            <strong><?php echo __('Administrator log-in'); ?></strong>
                        </a>
                    </p>
                    <form id="login" action="<?php System::getVar('entrypoint', 'index.php'); ?>?module=Users&amp;func=siteofflogin" method="post">
                        <div>
                        <p><strong><?php echo __('An administrator log-in is required.'); ?></strong></p>
                            <div class="loginrow">
                                <label for="user"><?php echo __('User name'); ?></label>
                                <input id="user" type="text" name="user" size="14" maxlength="64" />
                            </div>
                            <div class="loginrow">
                                <label for="pass"><?php echo __('Password'); ?></label>
                                <input id="pass" type="password" name="pass" size="14" maxlength="20" />
                            </div>
                            <div class="logincheck">
                                <input id="rememberme" type="checkbox" value="1" name="rememberme" />
                                <label for="rememberme"><?php echo __('Remember me'); ?></label>
                            </div>
                            <div class="loginbutton">
                                <input type="submit" value="<?php echo __('Log in'); ?>" />
                            </div>
                        </div>
                    </form>
                    <p>
                        <a href="http://zikula.org"><img src="images/powered/small/cms_zikula.png" alt="Proudly powered by Zikula" width="80" height="15" /></a>
                        <a href="http://www.php.net"><img src="images/powered/small/php_powered.png" alt="PHP Language" width="80" height="15" /></a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>