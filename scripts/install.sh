if [ -f /swapfile ]; then
 echo "Swap file already exists."
else
 sudo fallocate -l 1G /swapfile
  sudo chmod 600 /swapfile
  sudo mkswap /swapfile
  sudo swapon /swapfile
  echo "/swapfile none swap sw 0 0" >> /etc/fstab
  echo "vm.swappiness=30" >> /etc/sysctl.conf
  echo "vm.vfs_cache_pressure=50" >> /etc/sysctl.conf
  echo "Swap created and added to /etc/fstab for boot up."
fi

apt update -y;

curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.1/install.sh | bash;

export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # This loads nvm bash_completion

nvm install 14.19.0;

echo 'export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" # This loads nvm' >> ~/.bash_profile

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"

mv composer.phar /usr/local/bin/composer

touch install-step-2.sh;

echo "
source ~/.bash_profile
source ~/.bashrc

hash -r nvm

apt-get update -y
apt install zip unzip python2.7  php7.2-mbstring php7.2-xml redis-server -y;
ln -s /usr/bin/python2.7 /usr/bin/python

rm -rf /var/www/*;
git clone https://github.com/GameserverApp/Community-Website.git /var/www;

mkdir -p /var/www/public/js
touch /var/www/public/js/app.js

composer install  --no-interaction --no-dev --prefer-dist -d /var/www;
npm --prefix /var/www ci;
npm --prefix /var/www run production;

chown -R www-data:www-data /var/www

sed -i 's#/var/www/html#/var/www/public#g' /etc/nginx/sites-enabled/digitalocean

php /var/www/artisan setup-community-website

php /var/www/artisan optimize
" >> install-step-2.sh;

sudo bash install-step-2.sh

sudo bash /var/www/install-ssl.sh

rm -rf install.sh
rm -rf install-step-2.sh
rm -rf /var/www/install-ssl.sh
