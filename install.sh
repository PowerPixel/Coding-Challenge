echo "|---------------------------------------------------------------------------------------------|";
echo "|Coding Challenge - Install script";
echo "|---------------------------------------------------------------------------------------------|";

function downloadCamisole(){
    echo "Downloading camisole ova file...";
    wget -O "$1/camisole.ova" https://camisole.prologin.org/ova/camisole-v1.4-2019-01-23.ova -q --show-progress;
}

echo "WARNING ! Before using this script, you must have installed VirtualBox, as well as docker.
 To do so, please refer to the wiki of the project";
echo "Please input the path where you'd like to download the camisole image (needs at least 1.5GiB of free space, absolute path)";
read CAMISOLE_DL_PATH;
downloadCamisole $CAMISOLE_DL_PATH;
echo "Installing camisole through VBoxManage...";
/usr/bin/VBoxManage import "$CAMISOLE_DL_PATH/camisole.ova";
echo "Installing Docker image"
docker build --tag coding-challenge ./docker;
echo "Everything done !";
echo "You can launch the docker machine through the script called startDocker.sh, and camisole through the script startCamisole.sh";
