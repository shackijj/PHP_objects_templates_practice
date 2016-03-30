#Get selenium-server 
apt-get install default-jre
wget http://goo.gl/IHP6Qw
mv IHP6Qw server-standalone-2.53.0.kar
mv server-standalone-2.53.0.kar /usr/local/bin

#Run server
java -jar /usr/local/bin/server-standalone-2.53.0.jar

#Get php driver
git clone https://github.com/facebook/php-webdriver
sudo mv php-webdriver /usr/share/php/
