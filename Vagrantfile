# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
    config.vm.box = "ubuntu/xenial64"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # NOTE: This will enable public access to the opened port
  # config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine and only allow access
  # via 127.0.0.1 to disable public access
  # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"
      config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "192.168.45.3"

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  # config.vm.network "private_network", ip: "192.168.33.10"
  config.vm.network "private_network", ip: "192.168.45.3"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  # config.vm.synced_folder "../data", "/vagrant_data"
  config.vm.synced_folder "./application", "/var/www/html/application"
  config.vm.synced_folder "./vagrant/sql", "/home/vagrant/sql"
  config.vm.synced_folder "./vagrant/nginx/sites-available", "/etc/nginx/sites-available", owner: "www-data", group: "www-data"
  config.vm.synced_folder "./application/var", "/var/www/html/application/var", owner: "www-data", group: "www-data", mount_options: ["fmode=775"]

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  config.vm.provider "virtualbox" do |vb|
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true
  #
    # Customize the amount of memory on the VM:
    vb.memory = "1024"
    # Customize VM name:
    vb.name = "Aqarmap-task"
  end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
  config.vm.provision "shell", inline: <<-INSTALLATION
   echo "update Ubuntu Dependencies ===================================>"
   sudo apt-get update
   echo "Add PPA repository for php 7.x ===========================>"
   sudo add-apt-repository -y ppa:ondrej/php
   echo "update Ubuntu Dependencies ===================================>"
   sudo apt-get update
   echo "Install nginx ========================================>"
   sudo apt-get -y install nginx
   sudo /etc/init.d/nginx start
   mkdir /var/www/
   echo "install mysql ===================================================>"
   sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
   sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
   sudo apt-get -y install mysql-client mysql-server
   echo "import mysql database ==================================>"
   mysql -u root -p'root' -e "CREATE USER 'vagrant'@'localhost' IDENTIFIED BY 'vagrant';"
   mysql -u root -p'root' -e "GRANT ALL PRIVILEGES ON * . * TO 'vagrant'@'localhost';"
   mysql -u root -p'root' -e "FLUSH PRIVILEGES;"
   gunzip -c /home/vagrant/sql/aqarmapTaskDB.sql.gz > /home/vagrant/sql/aqarmapTaskDB.sql
   mysql -u vagrant -p'vagrant' -e "DROP DATABASE IF EXISTS aqarmapTaskDB;"
   mysql -u vagrant -p'vagrant' -e "CREATE DATABASE aqarmapTaskDB;"
   mysql -u vagrant -p'vagrant' aqarmapTaskDB < /home/vagrant/sql/aqarmapTaskDB.sql
   rm -r /home/vagrant/sql/aqarmapTaskDB.sql
   echo "create new mysql database ==================================>"
   mysql -u vagrant -p'vagrant' -e "DROP DATABASE IF EXISTS BBTask;"
   mysql -u vagrant -p'vagrant' -e "CREATE DATABASE BBTask;"
   echo "Install php 7.2 and some dependencies for php 7.2 ============>"
   sudo apt-get -y install php-common php7.2-fpm php7.2-cli php7.2-common php7.2-json php7.2-opcache php7.2-readline php7.2-mysql php7.2-gd php7.2-mbstring php7.2-intl php7.2-zip php7.2-xml php7.2-curl
   sudo apt-get -y install libsqlite3-dev zziplib-bin php-pear php-memcached
   echo "Removing defualt nginx files ==================================>"
   rm -rf /etc/nginx/sites-available/default
   rm -rf /etc/nginx/sites-enabled/default
   echo "Adding new nginx conf and edit php.ini =========================================>"
   sudo ln -s /etc/nginx/sites-available/application.conf /etc/nginx/sites-enabled/
   echo "Edit php.ini =========================================>"
   sudo sed -i.bak $'s/display_errors = Off/display_errors = On/g' /etc/php/7.2/cli/php.ini
   sudo sed -i.bak $'s/display_startup_errors = Off/display_startup_errors = On/g' /etc/php/7.2/cli/php.ini
   sudo sed -i.bak $'s/;date.timezone =/date.timezone = Africa\/Cairo/g' /etc/php/7.2/cli/php.ini
   echo "update Ubuntu Dependencies ===================================>"
   sudo apt-get update
   echo "install git ===================================================>"
   sudo apt-get install -y git
   echo "install curl ===================================================>"
   sudo apt-get install -y curl
   echo "install composer ===================================================>"
   curl -sS https://getcomposer.org/installer | php
   sudo mv composer.phar /usr/local/bin/composer
   sudo chown vagrant /usr/local/bin/composer
   sudo chgrp vagrant /usr/local/bin/composer
   echo "Install NodeJs v10 ===================================================>"
   curl -sL https://deb.nodesource.com/setup_10.x | sudo -E bash -
   sudo apt-get install -y nodejs
   sudo apt-get install -y build-essential
   echo "Install Yarn ===================================================>"
   curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
   echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
   sudo apt-get update
   sudo apt-get install -y yarn
   echo "Remove curl ===================================================>"
   sudo apt-get remove -y curl
   echo "Restart nginx and php fpm service ====================================>"
   sudo service nginx restart
   sudo service php7.2-fpm restart
  INSTALLATION

  config.vm.provision :shell, run: "always", inline: <<-RESTART_NGINX
    sudo service nginx restart
    sudo service php7.2-fpm restart
  RESTART_NGINX
end
