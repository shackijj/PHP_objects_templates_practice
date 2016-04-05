#Xdebug install on debian

sudo apt-get install php5-xdebug

#PHPUnit asks for whitelist. Author used an old version of PHPUnit.
phpunit --coverage-html /tmp/coverage test/ --whitelist=userthing

#Sniffer install
sudo pear install PHP_CodeSniffer
#Example
phpcs --standard=Zend build/userthing/persist/UserStore.php

#For building packages from phing
sudo pear install PEAR
sudo pear install XML_Serializer-0.20.2
sudo pear install -a PEAR_PackageFileManager2
