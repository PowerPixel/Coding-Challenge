echo "|---------------------------------------------------------------------------------------------|";
echo "|Coding Challenge - Dev install script";
echo "|---------------------------------------------------------------------------------------------|";

function downloadCamisole(){
    echo "Downloading camisole ova file...";
    wget -O "$1/camisole.ova" https://camisole.prologin.org/ova/camisole-v1.4-2019-01-23.ova -q --show-progress;
}

function composerSetup(){
    composer install;
}

function installDatabase(){
    php bin/console doctrine:schema:update -f;
    mysql -D $1 -u $2 -p < SQL_INSERT.sql;
}

echo "WARNING ! Before using this script, you must have installed VirtualBox, as well as composer.
 To do so, please refer to the wiki of the project";
echo "Please input the path where you'd like to download the camisole image (needs at least 1.5GiB of free space)";
read CAMISOLE_DL_PATH;
downloadCamisole $CAMISOLE_DL_PATH;
echo "Installing camisole through VBoxManage...";
/usr/bin/VBoxManage import "$CAMISOLE_DL_PATH/camisole.ova";
echo "Installing composer packages..."
composerSetup;
echo "Please input your db name";
read DB_NAME;
echo "Please input your mysql username";
read USERNAME_MYSQL_SETUP;
echo "Installing database...";
installDatabase $DB_NAME $USERNAME_MYSQL_SETUP;
echo "Everything done !"