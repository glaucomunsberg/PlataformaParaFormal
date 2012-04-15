# coding: utf-8
import os, shutil, sys, datetime
import time
PROJECT_ROOT_PATH = os.path.dirname(os.path.abspath(__file__))
files_js = ['_js/jquery-1.7.1.min.js', 
            '_js/jquery-ui-1.8.16.custom.min.js', 
            '_js/jquery.easing.1.3.min.js',
            '_js/jquery.jBreadCrumb.1.1.min.js',        
            '_js/jquery.ui.selectmenu.min.js',            
            '_js/jquery.form.2.52.min.js',
            '_js/jquery.ui.datepicker-pt-BR.min.js', 
            '_js/i18n/grid.locale-pt-br.js',             
            '_js/jquery.jqGrid.4.0.0.min.js',
            '_js/jquery.tablednd.min.js',
            '_js/jquery.cookie.min.js', 
            '_js/jquery.treeview.1.5pre.min.js',
            '_js/jquery.highlight-3.min.js',
            '_js/webtoolkit.utf8.min.js',
            '_js/jquery.maskedinput-1.2.2.min.js',
            '_js/masks.min.js',
            '_js/jquery.maskMoney.min.js',
            '_js/webcam.min.js',
            '_js/jquery.fixFloat.min.js',
            '_js/functions.min.js']
files_js_to_compressor = ['_js/jquery.easing.1.3.js',
                          '_js/jquery.jBreadCrumb.1.1.js',
                          '_js/jquery.ui.selectmenu.js',
                          '_js/jquery.form.2.52.js',
                          '_js/jquery.ui.datepicker-pt-BR.js',
                          '_js/jquery.tablednd.js',
                          '_js/jquery.cookie.js',
                          '_js/jquery.treeview.1.5pre.js',
                          '_js/webtoolkit.utf8.js',
                          '_js/masks.js',
                          '_js/jquery.maskMoney.js',
                          '_js/jquery.highlight-3.js',
                          '_js/jquery.fixFloat.js',
                          '_js/webcam.js',
                          '_js/functions.js']
files_css = ['_css/jquery.ui.selectmenu.min.css',
             '_css/breadcrumb.min.css',
             '_css/ui.jqgrid.4.0.0.min.css',
             '_css/jquery.treeview.1.5pre.min.css',
             '_css/agenda.min.css',
             '_css/global.min.css']
themes_jqueryui = ['_css/blitzer/', '_css/cupertino/', '_css/flick/',
                   '_css/hot-sneaks/', '_css/redmond/', '_css/smoothness/', '_css/ui-lightness/',
                   '_css/humanity/']
files_css_to_compressor = ['_css/jquery.ui.selectmenu.css',
                           '_css/breadcrumb.css',
                           '_css/ui.jqgrid.4.0.0.css',
                           '_css/jquery.treeview.1.5pre.css',
                           '_css/global.css',
                           '_css/agenda.css',                           
                           '_css/blitzer/jquery-ui-1.8.16.custom.css',
                           '_css/cupertino/jquery-ui-1.8.16.custom.css',
                           '_css/flick/jquery-ui-1.8.16.custom.css',
                           '_css/hot-sneaks/jquery-ui-1.8.16.custom.css',
                           '_css/redmond/jquery-ui-1.8.16.custom.css',
                           '_css/smoothness/jquery-ui-1.8.16.custom.css',
                           '_css/ui-lightness/jquery-ui-1.8.16.custom.css',
                           '_css/humanity/jquery-ui-1.8.16.custom.css']

for raiz, diretorios, arquivos in os.walk(PROJECT_ROOT_PATH):
    for arquivo in arquivos:
        if arquivo.startswith('all.javascript.'):
            os.remove(os.path.join(raiz,arquivo))
        if arquivo.startswith('all.css.'):
            os.remove(os.path.join(raiz,arquivo))

now = datetime.datetime.now().strftime('%d%m%Y%H%M%S%f')

print "compressing files javascript ..."
for file_js in files_js_to_compressor:
    os.system("java -jar yuicompressor-2.4.2.jar %s -o %s --charset utf-8" %
              (file_js, file_js.replace(".js", ".min.js")))

all_javascript = open(os.path.join('', '_js/all.javascript.'+now+'.js'), 'w')

for file_js in files_js:
    file = open(os.path.join('', file_js), 'r')
    all_javascript.write(file.read())
    file.close()

all_javascript.close()
print "javascript generated file: all.javascript.%s.js" % now

print "compressing files css ..."
for file_css in files_css_to_compressor:
    os.system("java -jar yuicompressor-2.4.2.jar %s -o %s --charset utf-8" %
              (file_css, file_css.replace(".css", ".min.css")))

all_css = open(os.path.join('', '_css/all.css.'+now+'.css'), 'w')

for file_css in files_css:
    file = open(os.path.join('', file_css), 'r')
    all_css.write(file.read())
    file.close()

all_css.close()

for theme_jqueryui in themes_jqueryui:
    file_all_css = open(os.path.join('', '_css/all.css.'+now+'.css'), 'r')
    all_css_jqueryui = open(os.path.join('', theme_jqueryui+'all.css.jquery-ui.'+now+'.css'), 'w')
    file = open(os.path.join('', theme_jqueryui+'jquery-ui-1.8.16.custom.min.css'), 'r')    
    all_css_jqueryui.write(file.read())
    all_css_jqueryui.write(file_all_css.read())
    file.close()
    all_css_jqueryui.close()
    file_all_css.close()

print "css generated file: all.css.%s.css" % now

str_header_html = "<script>\n"
str_header_html+= "    var BASE_URL = '<?=base_url();?>';\n"
str_header_html+= "    var PATH_COOKIE = '<?=PATH_COOKIE;?>';\n"
str_header_html+= "    var IMG = '<?=IMG;?>';\n"
str_header_html+= "</script>\n"
str_header_html+= "<link href='<?=CSS;?>/<?=(@$_COOKIE['tema'] == '' ? 'redmond' : @$_COOKIE['tema']);?>/all.css.jquery-ui."+now+".css' type='text/css' rel='stylesheet'/>\n"
str_header_html+= "<link rel='shortcut icon' href='<?=IMG;?>/favicon.ico' type='image/ico'/>\n"
str_header_html+= "<script type='text/javascript' src='<?=JS;?>/all.javascript."+ now +".js'></script>"
file_header_html = open(os.path.join('', '_views/headerScripts.php'), 'w')
file_header_html.write(str_header_html)
file_header_html.close()