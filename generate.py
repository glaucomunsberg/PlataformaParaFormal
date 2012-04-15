# coding: utf-8
import os, shutil, sys
PROJECT_ROOT_PATH = os.path.dirname(os.path.abspath(__file__))

class Application:

    application = ''
    path_application = ''
    folders = ['config', 'controllers', 'errors', 'hooks', 'hooks/filters', 'language', 'language/pt-br', 'models', 'views', 'reports']
    files_config = ['config/autoload.php', 'config/config.php', 'config/constants.php', 'config/database.php', 'config/doctypes.php',
                    'config/filters.php', 'config/hooks.php', 'config/mimes.php', 'config/smiles.php', 'config/user_agents.php', 'config/mongodb.php']
    files_index = ['config/index.html', 'controllers/index.html', 'errors/index.html', 'hooks/index.html', 'models/index.html', 'views/index.html', 'reports/index.html']
    files_error = ['errors/error_404.php', 'errors/error_db.php', 'errors/error_general.php', 'errors/error_php.php']
    files_filter = ['hooks/filters/Filter.php', 'hooks/filters/init.php', 'hooks/filters/Pipe.php']
    arquives = ['.htaccess', 'index.php', 'config/routes.php']

    def __init__(self, application):
        self.application = application
        self.path_application = os.path.join(PROJECT_ROOT_PATH, application)

    def create_application(self):
        self.create_folder_main_application()
        self.create_folders_application()
        self.create_files_application()
        self.create_files_languages()

    # cria o diretório principal da aplicação
    def create_folder_main_application(self):        
        if not os.path.exists(self.path_application):
            print self.path_application
            os.mkdir(self.path_application)

    # cria todos os diretórios da aplicação
    def create_folders_application(self):
        for folder in self.folders:
            if not os.path.exists(os.path.join(self.path_application, folder)):
                print os.path.join(self.path_application, folder)
                os.mkdir(os.path.join(self.path_application, folder))

    # cria os arquivos language para internacionalização referentes a aplicação
    def create_files_languages(self):
        str_labels_language = "<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');\n"
        file_labels_lang = open(os.path.join(self.path_application, 'language/pt-br/'+self.application+'_labels_lang.php'), 'w')
        file_labels_lang.write(str_labels_language)
        file_labels_lang.close()

        str_messages_language = "<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');\n"
        file_messages_lang = open(os.path.join(self.path_application, 'language/pt-br/'+self.application+'_messages_lang.php'), 'w')
        file_messages_lang.write(str_messages_language)
        file_messages_lang.close()
        
        str_autoload = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n"        
        str_autoload+= "include BASEPATH.'config/autoload.php';\n"
        str_autoload+= "array_push($autoload['language'], '"+self.application+"_labels');\n"
        str_autoload+= "array_push($autoload['language'], '"+self.application+"_messages');\n"
        file_autoload = open(os.path.join(self.path_application, 'config/autoload.php'), 'w')
        file_autoload.write(str_autoload);                        
        file_autoload.close()

    def create_files_application(self):
        # cria os arquivos que não tem o script padrão
        for arquive in self.arquives:
            print os.path.join(self.path_application, arquive)
            open(os.path.join(self.path_application, arquive), 'w')

        # cria e adiciona o script padrão para os arquivos index.html
        for file_index in self.files_index:
            print os.path.join(self.path_application, file_index)    
            str_index_html = "<html>\n"
            str_index_html+= "    <head>\n"
            str_index_html+= "        <title>403 Forbidden</title>\n"
            str_index_html+= "    </head>\n"
            str_index_html+= "    <body>\n"
            str_index_html+= "        <p>Directory access is forbidden.</p>\n"
            str_index_html+= "    </body>\n"
            str_index_html+= "</html>"
            file_index_html = open(os.path.join(self.path_application, file_index), 'w')
            file_index_html.write(str_index_html)
            file_index_html.close()

        # cria os arquivos de errors e filters
        for file in self.files_error+self.files_filter:
            print os.path.join(self.path_application, file)
            open(os.path.join(self.path_application, file), 'w')

        # cria os arquivos e adiciona o script padrão de cada arquivo
        for file_config in self.files_config:
            print os.path.join(self.path_application, file_config)
            str_config = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n"            
            str_config+= "include BASEPATH.'"+file_config+"';"
            file = open(os.path.join(self.path_application, file_config), 'w')
            file.write(str_config)
            file.close()

        # adiciona o script padrão do arquivo config/routes.php
        str_routes = "<?php  if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');\n"
        str_routes+= "$route['default_controller'] = '"+self.application+"';\n"
        str_routes+= "$route['scaffolding_trigger'] = '';"
        file_routes = open(os.path.join(self.path_application, 'config/routes.php'), 'w')
        file_routes.write(str_routes)
        file_routes.close()

        # adiciona o script padrão do arquivo .htaccess
        str_htaccess = "<IfModule mod_rewrite.c>\n"
        str_htaccess+= "    RewriteEngine On\n"
        str_htaccess+= "    RewriteCond %{REQUEST_URI} ^system.*\n"
        str_htaccess+= "    RewriteRule ^(.*)$ /index.php/$1 [L]\n"
        str_htaccess+= "    RewriteCond %{REQUEST_FILENAME} !-f\n"
        str_htaccess+= "    RewriteCond %{REQUEST_FILENAME} !-d\n"
        str_htaccess+= "    RewriteRule ^(.*)$ index.php/$1 [L]\n"
        # compress text, html, javascript, css, xml:
        str_htaccess+= "    AddOutputFilterByType DEFLATE text/plain\n"
        str_htaccess+= "    AddOutputFilterByType DEFLATE text/html\n"
        str_htaccess+= "    AddOutputFilterByType DEFLATE text/xml\n"
        str_htaccess+= "    AddOutputFilterByType DEFLATE text/css\n"
        str_htaccess+= "    AddOutputFilterByType DEFLATE application/xml\n"
        str_htaccess+= "    AddOutputFilterByType DEFLATE application/xhtml+xml\n"
        str_htaccess+= "    AddOutputFilterByType DEFLATE application/rss+xml\n"
        str_htaccess+= "    AddOutputFilterByType DEFLATE application/javascript\n"
        str_htaccess+= "    AddOutputFilterByType DEFLATE application/x-javascript\n"       
        str_htaccess+= "</IfModule>\n\n"
        
        str_htaccess+= "<IfModule !mod_rewrite.c>\n"
        str_htaccess+= "    ErrorDocument 404 /index.php\n"
        str_htaccess+= "</IfModule>\n"
        file_htaccess = open(os.path.join(self.path_application, '.htaccess'), 'w')
        file_htaccess.write(str_htaccess)
        file_htaccess.close()

        #copia arquivos padrão
        shutil.copy2(os.path.join(PROJECT_ROOT_PATH, 'static/samples_generate/index.php'), os.path.join(self.path_application, 'index.php'))
        shutil.copy2(os.path.join(PROJECT_ROOT_PATH, 'static/samples_generate/error_404.php'), os.path.join(self.path_application, 'errors/error_404.php'))
        shutil.copy2(os.path.join(PROJECT_ROOT_PATH, 'static/samples_generate/error_db.php'), os.path.join(self.path_application, 'errors/error_db.php'))
        shutil.copy2(os.path.join(PROJECT_ROOT_PATH, 'static/samples_generate/error_general.php'), os.path.join(self.path_application, 'errors/error_general.php'))
        shutil.copy2(os.path.join(PROJECT_ROOT_PATH, 'static/samples_generate/error_php.php'), os.path.join(self.path_application, 'errors/error_php.php'))
        shutil.copy2(os.path.join(PROJECT_ROOT_PATH, 'static/samples_generate/Filter.php'), os.path.join(self.path_application, 'hooks/filters/Filter.php'))
        shutil.copy2(os.path.join(PROJECT_ROOT_PATH, 'static/samples_generate/init.php'), os.path.join(self.path_application, 'hooks/filters/init.php'))
        shutil.copy2(os.path.join(PROJECT_ROOT_PATH, 'static/samples_generate/Pipe.php'), os.path.join(self.path_application, 'hooks/filters/Pipe.php'))        

if __name__ == "__main__":
    name_application = raw_input("Application Name: ")
    print "creating application "+name_application
    app = Application(name_application)
    app.create_application()
    print "application created"