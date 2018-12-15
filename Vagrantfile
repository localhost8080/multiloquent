# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "centos/7"
  config.vm.network "private_network", ip: "192.168.33.10"
  
  config.vm.synced_folder ".", "/vagrant", disabled: true

  config.vm.synced_folder ".", "/var/www/vhosts/development/wp-content/themes/multiloquent", 
    create: true, 
    type: 'sshfs', 
    
    
  config.vm.synced_folder "../devops", "/var/www/vhosts/devops",
    create: true, 
    type: 'sshfs', 
   

  config.vm.provider "virtualbox" do |vb|
    vb.memory = "2048"
  end

  config.vm.provision "shell", inline: <<-SHELL
		
		# ===================================================================
		# Pretify logging to screen
		# ===================================================================
		printLog() {
			printf "[bootstrap] $1\n";
		}


		installExtras(){
			printLog "Updating Environment";
			sudo rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
			sudo rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
			sudo yum -y update
			sudo yum -y install centos-release mc tmux git httpd mod_ssl mariadb-server
			sudo yum -y install php71w-pdo php71w-mbstring php71w-process php71w-common php71w php71w-mcrypt php71w-xml php71w-pecl-xdebug php71w-cli php71w-devel php71w-gd php71w-tidy php71w-mysqlnd php71w-soap
			sudo mkdir /etc/ssl/private
			
			sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/apache-selfsigned.key -out /etc/ssl/certs/apache-selfsigned.crt -subj /CN=development.test

			printLog "Change permissions"
			sudo setenforce 0
			sudo setsebool -P httpd_can_network_connect=1
		}


		installPHP(){
			printLog "Configure HTTPD and php"
			sudo touch /etc/httpd/conf.d/development.conf
			sudo chmod 777 /etc/httpd/conf.d/development.conf
			
			sudo echo 'SetEnv REDBACK_ENV DEVELOPMENT
			<VirtualHost *:80>
			ServerAdmin errors@adeogroup.co.uk
			DocumentRoot /var/www/vhosts/development
			ServerName development.test
			<Directory /var/www/vhosts/development>
			Options Indexes FollowSymLinks MultiViews
			AllowOverride All
			Order allow,deny
			Allow from all
			<IfModule sapi_apache2.c>
			php_admin_flag engine on
			php_admin_flag safe_mode off
			php_admin_value open_basedir \"/var/www/vhosts/development:/tmp:/var/www/vhosts/core\"
			</IfModule>
			<IfModule mod_php5.c>
			php_admin_flag engine on
			php_admin_flag safe_mode off
			php_admin_value open_basedir \"/var/www/vhosts/development:/tmp:/var/www/vhosts/core\"
			</IfModule>
			</Directory>
			</VirtualHost>
			<VirtualHost *:443>
			ServerAdmin errors@adeogroup.co.uk
			DocumentRoot /var/www/vhosts/development
			ServerName development.test
			SSLEngine ON
			SSLCertificateFile /etc/ssl/certs/apache-selfsigned.crt
			SSLCertificateKeyFile /etc/ssl/private/apache-selfsigned.key
			<Directory /var/www/vhosts/development>
			Options Indexes FollowSymLinks MultiViews
			AllowOverride All
			Order allow,deny
			Allow from all
			<IfModule sapi_apache2.c>
			php_admin_flag engine on
			php_admin_flag safe_mode off
			php_admin_value open_basedir \"/var/www/vhosts/development:/tmp:/var/www/vhosts/core\"
			</IfModule>
			<IfModule mod_php5.c>
			php_admin_flag engine on
			php_admin_flag safe_mode off
			php_admin_value open_basedir \"/var/www/vhosts/development:/tmp:/var/www/vhosts/core\"
			</IfModule>
			</Directory>
			</VirtualHost>'  > /etc/httpd/conf.d/development.conf
			
			sudo chmod 777 /etc/php.d/xdebug.ini
			sudo echo 'xdebug.remote_log="/tmp/xdebug.log"
			xdebug.profiler_enable = 1
			xdebug.remote_enable=on
			xdebug.remote_port=9000
			xdebug.remote_autostart=0
			xdebug.remote_connect_back=on
			xdebug.idekey=editor-xdebug' >> /etc/php.d/xdebug.ini

			sudo touch /etc/httpd/conf.d/zz050-weak-cyphers.conf
			sudo chmod 777 /etc/httpd/conf.d/zz050-weak-cyphers.conf
			sudo echo '#SSLProtocol All -SSLv2 -SSLv3
			SSLProtocol -all -SSLv2 -SSLv3 -TLSv1 +TLSv1.1 +TLSv1.2
			SSLHonorCipherOrder On
			#SSLCipherSuite RC4-SHA:HIGH:!ADH!kEDH
			#SSLCipherSuite ECDHE-RSA-AES128-GCM-SHA384:ECDHE-RSA-AES128-GCM-SHA128:DHE-RSA-AES128-GCM-SHA384:DHE-RSA-AES128-GCM-SHA128:ECDHE-RSA-AES128-SHA384:ECDHE-RSA-AES128-SHA128:ECDHE-RSA-AES128-SHA:ECDHE-RSA-AES128-SHA:DHE-RSA-AES128-SHA128:DHE-RSA-AES128-SHA128:DHE-RSA-AES128-SHA:DHE-RSA-AES128-SHA:ECDHE-RSA-DES-CBC3-SHA:EDH-RSA-DES-CBC3-SHA:AES128-GCM-SHA384:AES128-GCM-SHA128:AES128-SHA128:AES128-SHA128:AES128-SHA:AES128-SHA:DES-CBC3-SHA:HIGH:!aNULL:!eNULL:!EXPORT:!DES:!MD5:!PSK:!RC4
			SSLCipherSuite EECDH+AESGCM:EDH+AESGCM:AES256+EECDH:AES256+EDH
			SSLInsecureRenegotiation off' >> /etc/httpd/conf.d/zz050-weak-cyphers.conf
		}

		installMysql(){
			printLog "Configure DB";	
				sudo touch /etc/yum.repos.d/mariadb.repo
				sudo chmod o+wrx /etc/yum.repos.d/mariadb.repo
				# leave the folowing lines at the start of the line - required for yum config file syntax
				echo '# MariaDB 10.2 CentOS repository list - created 2018-03-27 18:29 UTC 
# http://downloads.mariadb.org/mariadb/repositories/ 
[mariadb] 
name = MariaDB 
baseurl = http://yum.mariadb.org/10.2/centos7-amd64 
gpgkey=https://yum.mariadb.org/RPM-GPG-KEY-MariaDB 
gpgcheck=1 ' > /etc/yum.repos.d/mariadb.repo
				yum -y update
				yum -y install mariadb-server mariadb-client
				# leave the folowing lines at the start of the line - required for yum config file syntax
				sudo echo '[mysqld]
bind-address = 0.0.0.0
local-infile=0
datadir=/var/lib/mysql
socket=/var/lib/mysql/mysql.sock
sql_mode=
innodb_autoinc_lock_mode=0
symbolic-links=0
[mysqld_safe]
log-error=/var/log/mariadb/mariadb.log
pid-file=/var/run/mariadb/mariadb.pid
#
# include all files from the config directory
#
!includedir /etc/my.cnf.d' > /etc/my.cnf

				printLog "Start mysql server";	
				sudo systemctl start mariadb
				mysql -u root -e  "create database wordpress"
				mysql -u root -e  "SET PASSWORD FOR 'root'@'localhost' = PASSWORD('wordpress') "

		}

		installWordpress () {
			curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
			chmod +x wp-cli.phar
			sudo mv wp-cli.phar /usr/local/bin/wp
			cd /var/www/vhosts/development
			sudo /usr/local/bin/wp core download --allow-root
			sudo /usr/local/bin/wp core config --dbname=wordpress --dbuser=root --dbpass=wordpress  --allow-root
			sudo /usr/local/bin/wp core install --allow-root \
				--url=development.test \
				--admin_user=wordpress \
				--admin_password=wordpress \
				--admin_email=wordpress@development.test \
				--title="wordpress" \
				--skip-email \
				--allow-root
			sudo /usr/local/bin/wp theme activate multiloquent  --allow-root

		}
	

		installExtras
		installPHP
		installMysql
		installWordpress
		printLog "Restart apache";
		sudo systemctl restart httpd.service 


		printLog "--------------";
		printLog "access in browser https://development.test";


  SHELL
  
end
